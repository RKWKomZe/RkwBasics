<?php
namespace RKW\RkwBasics\Updates;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

/**
 * Class UpdateCore8Wizard
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTemplates
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class UpdateCore8Wizard extends AbstractUpdate
{

    /**
     * @var string
     */
    protected $extensionKey = 'rkwBasics';


    /**
     * @var string
     */
    protected $title = 'Updater for rkw_basics from TYPO3 7.6 to TYPO3 8.7.';



    /**
     * Checks whether updates are required.
     *
     * @param string $description The description for the update
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function checkForUpdate(&$description)
    {

        $currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        if ($currentVersion < 8000000) {
            return false;
        }

        if ($this->isWizardDone()) {
            return false;
        }

        return true;
    }


    /**
     * Performs the required update.
     *
     * @param array $databaseQueries Queries done in this update
     * @param string $customMessage Custom message to be displayed after the update process finished
     * @return bool Whether everything went smoothly or not
     * @throws Exception\ExistingTargetFileNameException
     */
    public function performUpdate(array &$databaseQueries, &$customMessage)
    {
        $this->migrateFieldTeaserText($databaseQueries);
        $this->migrateFieldArticleImage($databaseQueries);
        $this->migrateFieldArticleVideo($databaseQueries);

        $this->markWizardAsDone();
        return true;
    }


    /**
     * Update teaserText field
     *
     * @param array $databaseQueries Queries done in this update
     */
    protected function migrateFieldTeaserText(array &$databaseQueries)
    {
        if ($this->hasLock(__FUNCTION__)){
            return;
        }

        /** @var  \TYPO3\CMS\Core\Database\Connection $connectionPages */
        $connectionPages = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilderPages */
        $queryBuilderPages = $connectionPages->createQueryBuilder();
        $queryBuilderPages->getRestrictions()
            ->removeByType(StartTimeRestriction::class)
            ->removeByType(EndTimeRestriction::class)
            ->removeByType(HiddenRestriction::class)
            ->removeByType(DeletedRestriction::class);

        $statement = $queryBuilderPages->select('*')
            ->from('pages')
            ->where(
                $queryBuilderPages->expr()->neq('tx_rkwbasics_teaser_text',
                    $queryBuilderPages->createNamedParameter('',  \PDO::PARAM_STR)
                )

            )
            ->execute();


        // go through all elements
        while ($record = $statement->fetch()) {


            // update record elements
            /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $updateQueryBuilder */
            $updateQueryBuilder = $connectionPages->createQueryBuilder();
            $updateQueryBuilder->update('pages')
                ->set('abstract', $record['tx_rkwbasics_teaser_text'])
                ->where(
                    $updateQueryBuilder->expr()->eq('uid',
                        $updateQueryBuilder->createNamedParameter(intval($record['uid']), \PDO::PARAM_INT)
                    )
                );

            $databaseQueries[] = $updateQueryBuilder->getSQL();
            $updateQueryBuilder->execute();

        }

        $this->setLock(__FUNCTION__);
    }

    /**
     * Update articleImage field
     *
     * @param array $databaseQueries Queries done in this update
     */
    protected function migrateFieldArticleImage(array &$databaseQueries)
    {
        if ($this->hasLock(__FUNCTION__)){
            return;
        }

        // rkw_template has its own migration handling for this field
        if (ExtensionManagementUtility::isLoaded('rkw_template')) {
            return;
        }

        $fieldConfigurations = [
            'tx_rkwbasics_article_image' => [
                'field' => 'txRkwBasicsArticleImage',
                'fieldTarget' => 'media',
                'cropTarget' => 'Default',
                'sortingTarget' => $this->sortIntervals,
            ]
        ];


        /** @var  \TYPO3\CMS\Core\Database\Connection $connectionPages */
        $connectionPages = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');

        /** @var  \TYPO3\CMS\Core\Database\Connection $connectionReference */
        $connectionReference = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('sys_file_reference');

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilderPages */
        $queryBuilderPages = $connectionPages->createQueryBuilder();
        $queryBuilderPages->getRestrictions()
            ->removeByType(StartTimeRestriction::class)
            ->removeByType(EndTimeRestriction::class)
            ->removeByType(HiddenRestriction::class)
            ->removeByType(DeletedRestriction::class);

        $statement = $queryBuilderPages->select('*')
            ->from('pages')
            ->execute();


        // go through all elements
        while ($record = $statement->fetch()) {

            foreach ($fieldConfigurations as $dbField => $config) {

                if ($record[$dbField]) {

                    // get all sys_file_references of current page
                    /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilderReference */
                    $queryBuilderReference = $connectionReference->createQueryBuilder();
                    $queryBuilderReference->getRestrictions()
                        ->removeByType(StartTimeRestriction::class)
                        ->removeByType(EndTimeRestriction::class)
                        ->removeByType(HiddenRestriction::class)
                        ->removeByType(DeletedRestriction::class);

                    $statementReference = $queryBuilderReference->select('*')
                        ->from('sys_file_reference')
                        ->where(
                            $queryBuilderReference->expr()->in('tablenames',
                                $queryBuilderReference->createNamedParameter('pages',  \PDO::PARAM_STR)
                            ),
                            $queryBuilderReference->expr()->in('fieldname',
                                $queryBuilderReference->createNamedParameter($config['field'],  \PDO::PARAM_STR)
                            ),
                            $queryBuilderReference->expr()->in('uid_foreign',
                                $queryBuilderReference->createNamedParameter($record['uid'],  \PDO::PARAM_INT)
                            )
                        )
                        ->execute();

                    while ($reference = $statementReference->fetch()) {

                        // update reference elements
                        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $updateQueryBuilder */
                        $updateQueryBuilder = $connectionReference->createQueryBuilder();
                        $updateQueryBuilder->update('sys_file_reference')
                            ->set('tablenames', 'pages')
                            ->set('fieldname', $config['fieldTarget'])
                            ->set('sorting', $config['sortingTarget'])
                            ->where(
                                $updateQueryBuilder->expr()->eq('uid',
                                    $updateQueryBuilder->createNamedParameter(intval($reference['uid']), \PDO::PARAM_INT)
                                )
                            );

                        $databaseQueries[] = $updateQueryBuilder->getSQL();
                        $updateQueryBuilder->execute();
                    }
                }
            }
        }

        $this->setLock(__FUNCTION__);
    }


    /**
     * Update articleVideo field
     *
     * @param array $databaseQueries Queries done in this update
     * @throws Exception\ExistingTargetFileNameException
     */
    protected function migrateFieldArticleVideo(array &$databaseQueries)
    {
        if ($this->hasLock(__FUNCTION__)){
            return;
        }

        /** @var  \TYPO3\CMS\Core\Database\Connection $connectionPages */
        $connectionPages = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = $connectionPages->createQueryBuilder();
        $statement = $queryBuilder->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->neq('tx_rkwbasics_article_video',
                    $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                )
            )
            ->execute();

        // find default storage
        /** @var \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository */
        $storageRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\StorageRepository::class);
        $storages = $storageRepository->findAll();
        $defaultStorage = null;

        /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
        foreach ($storages as $storage) {
            if (strpos($storage->getName(), 'fileadmin') === 0) {
                $defaultStorage = $storage;
                break;
            }
        }

        // go through all elements
        while ($record = $statement->fetch()) {

            // strip params
            if (strpos($record['tx_rkwbasics_article_video'], '?')) {
                $parts = parse_url($record['tx_rkwbasics_article_video']);
                parse_str($parts['query'], $query);
                $youTubeCode = $query['v'];
            } else {
                $exploded = explode('/', $record['tx_rkwbasics_article_video']);
                $youTubeCode = $exploded[count($exploded) - 1];
            }

            if ($youTubeCode) {

                // write code to file
                $fileName = time() . '_' . $youTubeCode . '.youtube';
                $filePath = PATH_site . '/typo3temp/';
                file_put_contents( $filePath . $fileName, $youTubeCode);

                // add file to storage
                /** @var \TYPO3\CMS\Core\Resource\FileInterface $fileObject */
                $fileObject = $defaultStorage->addFile(
                    $filePath . $fileName,
                    $storage->getRootLevelFolder(),
                    $fileName
                );

                // Add file reference
                $fields = [
                    'fieldname' => 'media',
                    'table_local' => 'sys_file',
                    'pid' => $record['uid'],
                    'uid_foreign' => $record['uid'],
                    'uid_local' => $fileObject->getUid(),
                    'tablenames' => 'pages',
                    'crdate' => time(),
                    'tstamp' => time(),
                ];

                /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $insertQueryBuilder */
                $insertQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
                $insertQueryBuilder->insert('sys_file_reference')->values($fields)->execute();

                // Update page
                $updateQueryBuilder = $connectionPages->createQueryBuilder();
                $updateQueryBuilder->update('pages')
                    ->set('media', $record['media']+1)
                    ->where(
                        $updateQueryBuilder->expr()->eq('uid',
                            $updateQueryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                        )
                    );
                $databaseQueries[] = $updateQueryBuilder->getSQL();
                $updateQueryBuilder->execute();
            }
        }

        $this->setLock(__FUNCTION__);
    }
}

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
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

/**
 * Class AbstractUpdate
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTemplates
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

abstract class AbstractUpdate extends \TYPO3\CMS\Install\Updates\AbstractUpdate
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
     * Integer: The interval between sorting numbers used with tables with a 'sorting' field defined. Min 1
     *
     * @var int
     */
    protected $sortIntervals = 256;



    /**
     * Moves elements into a newly added grid container
     *
     * @param array  $colPosMapper
     * @param int    $gridColPos
     * @param string $gridLayout
     * @param int    $gridHeaderLayout
     * @param array  $gridLabels
     * @param array  $databaseQueries Queries done in this update
     * @param string $backendLayoutFilter
     * @param string $gridElementCTypeFilter
     */
    protected function moveElementsFromColToGridContainer (array $colPosMapper, int $gridColPos, string $gridLayout, int $gridHeaderLayout, array $gridLabels, array &$databaseQueries, string $backendLayoutFilter = '', string $gridElementCTypeFilter = '')
    {

        /** @var  \TYPO3\CMS\Core\Database\Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');

        // find all relevant pages
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = $connection->createQueryBuilder();
        $statement = $queryBuilder->select('*')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->in('colPos',
                    $queryBuilder->createNamedParameter(array_keys($colPosMapper), Connection::PARAM_INT_ARRAY)
                )
            )
            ->groupBy('pid')
            ->execute();


        // go through all pages
        while ($record = $statement->fetch()) {

            if ($pid = intval($record['pid'])) {

                if ($backendLayoutFilter) {

                    // only if backendLayout matches
                    $pageBackendLayout = $this->getBackendLayoutRecursiveOfPage($record['pid']);
                    if ($pageBackendLayout != $backendLayoutFilter) {
                        continue;
                    }
                }

                $gridLabel = 'Container';
                if (isset($gridLabels['_default'])) {
                    $gridLabel = $gridLabels['_default'];
                }
                if (isset($gridLabels[$pid])) {
                    $gridLabel = $gridLabels[$pid];
                }

                // create a new grid-element
                $newElement = [
                    'pid' => intval($record['pid']),
                    'sorting' => 0,
                    'colPos' => intval($gridColPos),
                    'tstamp' => time(),
                    'crdate' => time(),
                    'CType' => 'gridelements_pi1',
                    'header' => $gridLabel,
                    'header_layout' => $gridHeaderLayout,
                    'tx_gridelements_backend_layout' => $gridLayout
                ];


                /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $insertQueryBuilder */
                $insertQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');

                $insertQueryBuilder->insert('tt_content')->values($newElement)->execute();
                $databaseQueries[] = $insertQueryBuilder->getSQL();
                $newElementUid = $insertQueryBuilder->getConnection()->lastInsertId();

                // update sub elements
                /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $updateQueryBuilder */
                foreach ($colPosMapper as $mapperSourceColPos => $mapperTargetColPos) {

                    $updateQueryBuilder = $connection->createQueryBuilder();
                    $updateQueryBuilder->update('tt_content')
                        ->set('tx_gridelements_container', intval($newElementUid))
                        ->set('tx_gridelements_columns', intval($mapperTargetColPos))
                        ->set('colPos', -1)
                        ->where(
                            $updateQueryBuilder->expr()->eq('colPos',
                                $updateQueryBuilder->createNamedParameter(intval($mapperSourceColPos), \PDO::PARAM_INT)
                            ),
                            $updateQueryBuilder->expr()->eq('pid',
                                $updateQueryBuilder->createNamedParameter($pid, \PDO::PARAM_INT)
                            )
                        );

                    if ($gridElementCTypeFilter) {
                        $updateQueryBuilder->andWhere(
                            $updateQueryBuilder->expr()->eq('CType',
                                $updateQueryBuilder->createNamedParameter($gridElementCTypeFilter, \PDO::PARAM_STR)
                            )
                        );
                    } else {

                        $updateQueryBuilder->andWhere(
                            $updateQueryBuilder->expr()->neq('CType',
                                $updateQueryBuilder->createNamedParameter('gridelements_pi1', \PDO::PARAM_STR)
                            )
                        );
                    }

                    $databaseQueries[] = $updateQueryBuilder->getSQL();
                    $updateQueryBuilder->execute();

                }


                // update counter of container
                /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
                $countQueryBuilder = $connection->createQueryBuilder();
                $countQueryBuilder->getRestrictions()
                    ->removeByType(StartTimeRestriction::class)
                    ->removeByType(EndTimeRestriction::class)
                    ->removeByType(HiddenRestriction::class);

                $count = $countQueryBuilder->count('*')
                    ->from('tt_content')
                    ->where(
                        $countQueryBuilder->expr()->eq('tx_gridelements_container',
                            $countQueryBuilder->createNamedParameter($newElementUid, \PDO::PARAM_INT)
                        )
                    )
                    ->execute()
                    ->fetchColumn(0);


                /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $updateQueryBuilder */
                $updateQueryBuilder = $connection->createQueryBuilder();
                $updateQueryBuilder->update('tt_content')
                    ->set('tx_gridelements_children', intval($count))
                    ->where(
                        $updateQueryBuilder->expr()->eq('uid',
                            $updateQueryBuilder->createNamedParameter($newElementUid, \PDO::PARAM_INT)
                        )
                    );
                $databaseQueries[] = $updateQueryBuilder->getSQL();
                $updateQueryBuilder->execute();
            }
        }
    }



    /**
     * Moves elements into a newly added grid container
     *
     * @param array $colPosList
     * @param int $targetColPos
     * @param array  $databaseQueries Queries done in this update
     * @param string $backendLayoutFilter
     */
    protected function moveElementsFromColsIntoCol (array $colPosList, int $targetColPos, array &$databaseQueries, string $backendLayoutFilter = '')
    {

        /** @var  \TYPO3\CMS\Core\Database\Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');

        // find all contents for each colPos
        $sortingCnt = 0;
        foreach ($colPosList as $colCnt => $colPos) {

            /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->getRestrictions()
                ->removeByType(StartTimeRestriction::class)
                ->removeByType(EndTimeRestriction::class)
                ->removeByType(HiddenRestriction::class)
                ->removeByType(DeletedRestriction::class);

            $statement = $queryBuilder->select('*')
                ->from('tt_content')
                ->where(
                    $queryBuilder->expr()->eq('colPos',
                        $queryBuilder->createNamedParameter($colPos, \PDO::PARAM_INT)
                    )
                )
                ->orderBy('sorting')
                ->execute();


            // go through all elements of this colPos
            while ($record = $statement->fetch()) {

                if ($backendLayoutFilter) {

                    // only if backendLayout matches
                    $pageBackendLayout = $this->getBackendLayoutRecursiveOfPage($record['pid']);
                    if ($pageBackendLayout != $backendLayoutFilter) {
                        continue;
                    }
                }

                // now update sorting and colPos
                // higher sorting numbers mean that elements are displayed lower in the list.
                $updateQueryBuilder = $connection->createQueryBuilder();
                $updateQueryBuilder->update('tt_content')
                    ->set('colPos', $targetColPos)
                    ->set('sorting', $sortingCnt)
                    ->where(
                        $updateQueryBuilder->expr()->eq('uid',
                            $updateQueryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                        )
                    );
                $databaseQueries[] = $updateQueryBuilder->getSQL();
                $updateQueryBuilder->execute();

                $sortingCnt += $this->sortIntervals;

            }
        }
    }


    /**
     * Moves elements into a newly added grid container
     *
     * @param array $shortCut
     * @param int targetColPos
     * @param string $gridElementCType
     * @param string $gridLayout
     * @param int $gridHeaderLayout
     * @param string $gridDefaultLabel
     * @param array  $databaseQueries Queries done in this update
     */
    protected function moveElementsFromShortCutToGridContainer (array $shortCut, int $targetColPos, string $gridElementCType, string $gridLayout, int $gridHeaderLayout, string $gridDefaultLabel, array &$databaseQueries)
    {

        /** @var  \TYPO3\CMS\Core\Database\Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');

        // create a new grid-element
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $insertQueryBuilder */
        $insertQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $newElement = [
            'pid' => intval($shortCut['pid']),
            'colPos' => intval($shortCut['colPos']),
            'sorting' => 0,
            'tstamp' => time(),
            'crdate' => time(),
            'CType' => 'gridelements_pi1',
            'header' => $shortCut['header'] ? $shortCut['header'] : $gridDefaultLabel,
            'header_layout' => $gridHeaderLayout,
            'tx_gridelements_backend_layout' => $gridLayout,
        ];

        $insertQueryBuilder->insert('tt_content')->values($newElement)->execute();
        $databaseQueries[] = $insertQueryBuilder->getSQL();
        $newElementUid = $insertQueryBuilder->getConnection()->lastInsertId();


        // now get the records of the shortcut and set their sorting according to the sorting in the shortcut.
        // higher sorting numbers mean that elements are displayed lower in the list.
        // also change their cType and add them to the new gridElement
        if ($items = explode(',', $shortCut['records'])) {

            $sorting = $this->sortIntervals;
            foreach ($items as $item) {

                $updateQueryBuilder = $connection->createQueryBuilder();
                if ($itemId = str_replace('tt_content_', '', $item)) {
                    $updateQueryBuilder->update('tt_content')
                        ->set('CType', $gridElementCType)
                        ->set('sorting', $sorting)
                        ->set('pid', intval($shortCut['pid']))
                        ->set('tx_gridelements_container', intval($newElementUid))
                        ->set('tx_gridelements_columns', intval($targetColPos))
                        ->set('colPos', -1)
                        ->where(
                            $updateQueryBuilder->expr()->eq('uid',
                                $updateQueryBuilder->createNamedParameter($itemId, \PDO::PARAM_INT)
                            )
                        );

                    $databaseQueries[] = $updateQueryBuilder->getSQL();
                    $updateQueryBuilder->execute();

                    $sorting += $this->sortIntervals;
                }
            }
        }


        // now delete shortcut
        $updateQueryBuilder = $connection->createQueryBuilder();
        $updateQueryBuilder->update('tt_content')
            ->set('deleted', 1)
            ->where(
                $updateQueryBuilder->expr()->eq('uid',
                    $updateQueryBuilder->createNamedParameter($shortCut['uid'], \PDO::PARAM_INT)
                )
            );
        $databaseQueries[] = $updateQueryBuilder->getSQL();
        $updateQueryBuilder->execute();


        // delete all other elements from the col and page of the shortcut
        $updateQueryBuilder = $connection->createQueryBuilder();
        $updateQueryBuilder->update('tt_content')
            ->set('deleted', 1)
            ->where(
                $updateQueryBuilder->expr()->eq('pid',
                    $updateQueryBuilder->createNamedParameter($shortCut['pid'], \PDO::PARAM_INT)
                ),
                $updateQueryBuilder->expr()->eq('colPos',
                    $updateQueryBuilder->createNamedParameter($shortCut['colPos'], \PDO::PARAM_INT)
                ),
                $updateQueryBuilder->expr()->neq('CType',
                    $updateQueryBuilder->createNamedParameter($gridElementCType, \PDO::PARAM_STR)
                ),
                $updateQueryBuilder->expr()->neq('CType',
                    $updateQueryBuilder->createNamedParameter('gridelements_pi1', \PDO::PARAM_STR)
                )
            );

        $databaseQueries[] = $updateQueryBuilder->getSQL();
        $updateQueryBuilder->execute();

    }

    /**
     * @param int $pid
     * @return bool|string
     */
    protected function getBackendLayoutRecursiveOfPage (int $pid)
    {

        // get backendLayout of page
        /** @var  \TYPO3\CMS\Core\Database\Connection $connectionPages */
        $connectionPages = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilderPages */
        $queryBuilderPages = $connectionPages->createQueryBuilder();
        $recordBackendLayout = $queryBuilderPages->select('backend_layout')
            ->from('pages')
            ->where(
                $queryBuilderPages->expr()->eq('uid',
                    $queryBuilderPages->createNamedParameter($pid, \PDO::PARAM_INT)
                )
            )
            ->execute()
            ->fetchColumn(0);

        // check for backendLayout in rootline if not defined in page
        if (empty($recordBackendLayout)) {

            $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($pid);
            foreach ($rootline as $rootlinePage) {
                if ($rootlinePage['uid'] == $pid) {
                    continue;
                }

                if ($recordBackendLayout = $rootlinePage['backend_layout_next_level']) {
                    break;
                }
            }
        }

        return $recordBackendLayout;
    }


    /**
     * Checks the lock
     *
     * @param string $method
     * @return bool
     */
    protected function hasLock ($method)
    {
        return file_exists(PATH_site . 'typo3temp/var/locks/tx_' . $this->extensionKey . '_' . $method . '.lock');
    }


    /**
     * Sets the lock
     *
     * @param string $method
     * @return bool
     */
    protected function setLock ($method)
    {
        return touch(PATH_site . 'typo3temp/var/locks/tx_' . $this->extensionKey . '_' . $method . '.lock');
    }

}

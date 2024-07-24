<?php

declare(strict_types=1);

namespace RKW\RkwBasics\Updates;

/**
 * This file is part of the "news" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Madj2k\CoreExtended\Utility\QueryUtility;
use RKW\RkwBasics\Exception;
use Solarium\Component\Debug;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Install\Updates\ChattyInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate empty slugs
 */
class BlogArticleUpdater implements UpgradeWizardInterface
{

    public const ORIGIN_TABLE = 'pages';

    public const ORIGIN_SUB_TABLE = 'tt_content';

    public const FOLDER_DOKTYPE = 254;

    public const TARGET_TABLE = 'tx_news_domain_model_news';

    public const ITEM_LIMIT_PER_RUN = 9999;


    /**
     * Defines "PageRootUid" => "NewsFolderPid"
     *
     * !! Als TypoScript auslagern, damit man für DEV, STAGE und LIVE individuelle PIDs festlegen kann !!
     *
     * @var array
     */
    protected array $sitesValuePairs = [
        'development' => [
            'rkw_komze' => [
                1 => 11922
            ]
        ],
        'production' => [
            'rkw_komze' => [
                1 => 9999999999999
            ]
        ]
    ];


    /**
     * @var int
     */
    protected int $currentSourceRootId = 0;

    /**
     * @var int
     */
    protected int $currentTargetNewsFolderId = 0;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger|null
     */
    protected ?Logger $logger = null;


    /**
     * @return bool
     * @throws NoSuchCacheException
     */
    public function updateNecessary(): bool
    {
        $updateNeeded = false;
        // Check if the database table even exists
        if ($this->checkIfWizardIsRequired()) {
            $updateNeeded = true;
        }
        return $updateNeeded;
    }


    /**
     * @return \class-string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }


    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return 'RKW: From Pages to News';
    }


    /**
     * Get description
     *
     * @return string Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'Migrates Pages Blog Article of RkwBasics to EXT:news records';
    }


    /**
     * @return string Unique identifier of this updater
     */
    public function getIdentifier(): string
    {
        return 'rkwBasicsToNews';
    }


    /**
     * Performs the accordant updates.
     *
     * @return bool Whether everything went smoothly or not
     */
    public function executeUpdate(): bool
    {
        $this->migrateBlogArticle();
        return true;
    }


    /**
     * Check if there are record within database table with an empty "slug" field.
     *
     * @return bool
     * @throws \InvalidArgumentException
     * @throws NoSuchCacheException
     */
    protected function checkIfWizardIsRequired(): bool
    {

        if (Environment::getContext()->isProduction()) {
            $pidConfig = $this->sitesValuePairs['production'];
        } else {
            $pidConfig = $this->sitesValuePairs['development'];
        }

        // iterate all rootPid and return true as soon as records are found
        foreach ($pidConfig as $rootPagePidArray) {
            foreach ($rootPagePidArray as $rootPid => $newsFolderPid) {
                $this->currentSourceRootId = (int)$rootPid;

                $numberOfEntries = $this->getPages(true);

                if ($numberOfEntries[0] > 0) {
                    return true;
                }
            }
        }

        // nothing found to migrate
        return false;
    }


    /**
     * Fills the news table with articles from pages table
     *
     * @return void
     * @throws NoSuchCacheException
     */
    protected function migrateBlogArticle(): void
    {
        if (Environment::getContext()->isProduction()) {
            $pidConfig = $this->sitesValuePairs['production'];
        } else {
            $pidConfig = $this->sitesValuePairs['development'];
        }

         foreach ($pidConfig as $rootPagePidArray) {
             foreach ($rootPagePidArray as $rootPid => $newsFolderPid) {
                 $this->currentSourceRootId = (int)$rootPid;
                 $this->currentTargetNewsFolderId = (int)$newsFolderPid;

                 // for secure
                 // Check if target PID is a folder
                 if (!$this->checkIfTargetPidIsOfTypeFolder()) {
                    exit;
                 }

                 $this->doImportToNewsFolder($this->getPages());
             }
         }

    }


    /**
     * Returns a list of pages of a certain tree
     *
     * @return array []
     * @throws NoSuchCacheException
     */
    private function getPageTreeItems(): array
    {
        if (!$this->currentSourceRootId) {
            $this->getLogger()->log(
                \TYPO3\CMS\Core\Log\LogLevel::ERROR,
                sprintf('No root PID given.')
            );
            throw new Exception("No root PID given.");
        }
        return GeneralUtility::trimExplode(',', QueryUtility::getTreeList($this->currentSourceRootId, 9999, 0, '1'), true);
    }


    /**
     * @param bool $justCount
     * @return array
     * @throws NoSuchCacheException
     */
    private function getPages(bool $justCount = false): array
    {

        // pages[tx_rkwbasics_document_type] == 1 ("Blog-Beitrag")
        // get only pages from specific ROOT

        $selectArray = [
            'uid',
            'tstamp',
            'crdate',
            'cruser_id',
            'title',
            'media',
            'tx_rkwauthors_authorship',
            'tx_rkwbasics_enterprisesize',
            'tx_rkwbasics_sector',
            'tx_rkwbasics_series',
            'lastUpdated',
            'abstract',
            'slug'
        ];

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable(self::ORIGIN_TABLE);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        if (!(false)) {
            $queryBuilder->select(...$selectArray);
        } else {
            $queryBuilder->count('uid');
        }
        $queryBuilder->from(self::ORIGIN_TABLE);
        $queryBuilder->where(
                $queryBuilder->expr()->eq('tx_rkwbasics_document_type', $queryBuilder->createNamedParameter(1)),
                $queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(0)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0)),
                $queryBuilder->expr()->in('uid', $this->getPageTreeItems())
            );
        if (!$justCount) {
            $queryBuilder->setMaxResults(self::ITEM_LIMIT_PER_RUN);
        }

        if (!$justCount) {
            return [$queryBuilder->execute()];
        }

        return [$queryBuilder->execute()->fetchColumn()];
    }



    /**
     * @param int $pageUid
     * @return array
     */
    private function getBlogContentElement(int $pageUid): array
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable(self::ORIGIN_SUB_TABLE);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $statement = $queryBuilder
            ->select(
                'header',
                'bodytext'
            )
            ->from(self::ORIGIN_SUB_TABLE)
            ->where(
                $queryBuilder->expr()->in('pid', $pageUid),
                // get element "text" or "textpic"
                $queryBuilder->expr()->like(
                    'CType',
                    $queryBuilder->createNamedParameter('text%')
                ),
                //$queryBuilder->expr()->eq('CType', 'textpic'),
                //$queryBuilder->expr()->notLike('CType', 'gridelements_pi1'),
            )
            ->execute();

        while ($ttContentRecord = $statement->fetch()) {
            // !! return first; ignore something other
            return $ttContentRecord;
        }

        return [];
    }


    /**
     * @param array $statement
     * @return void
     */
    private function doImportToNewsFolder(array $statement): void
    {

        // headerimage: pages[media] -> news[fal_media]
        // author: pages[tx_rkwauthors_authorship] -> news[tx_news_authorship] (NEUE PROPERTY)
        // unternehmensgröße (sys_cat): pages[tx_rkwbasics_enterprisesize] -> news[tx_news_enterprisesize] (NEUE PROPERTY)
        // branche (sys_cat): pages[tx_rkwbasics_sector] -> news[tx_news_sector] (NEUE PROPERTY)
        // reihe (sys_cat): pages[tx_rkwbasics_series] -> news[tx_news_series] (NEUE PROPERTY)
        // erscheinungsdatum: pages[lastUpdated] -> news[datetime]
        // teaser: pages[abstract] -> news[teaser]
        // fließtext: tt_content element -> news[bodytext]
        // copy slugs: pages[slug] -> news[path_segment]


        while ($pagesRecord = $statement[0]->fetch()) {
            //DebuggerUtility::var_dump($pagesRecord); exit;

            $ttContentElement = $this->getBlogContentElement($pagesRecord['uid']);

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::TARGET_TABLE);
            $queryBuilder
                ->insert(self::TARGET_TABLE)
                ->values([
                    'pid' => $this->currentTargetNewsFolderId,
                    'tstamp' => $pagesRecord['tstamp'],
                    'crdate' => $pagesRecord['crdate'],
                    'cruser_id' => $pagesRecord['cruser_id'],
                    'title' => $pagesRecord['title'],
                    // 'fal_media' => $pagesRecord['media'],
                    'datetime' => $pagesRecord['lastUpdated'],
                    'teaser' => $pagesRecord['abstract'],
                    'path_segment' => $pagesRecord['slug'],

                    // from tt_content
                    'bodytext' => $ttContentElement['bodytext'],
                ])
                ->execute();


        //    var_dump("Neuer News-Testrecord angelegt.");
        //    exit;

            // @toDo: Hide copies pages element? (would not longer part of migration)

        }

    }


    /**
     * @return bool
     */
    private function checkIfTargetPidIsOfTypeFolder()
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable(self::ORIGIN_TABLE);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $result = $queryBuilder
            ->select(
                'uid',
                'doktype'
            )
            ->from(self::ORIGIN_TABLE)
            ->where(
                $queryBuilder->expr()->eq('uid', $this->currentTargetNewsFolderId)
            )
            ->execute();


        while ($pagesElement = $result->fetch()) {
            if ($pagesElement['doktype'] != self::FOLDER_DOKTYPE) {
                $this->getLogger()->log(
                    \TYPO3\CMS\Core\Log\LogLevel::ERROR,
                    sprintf(
                        'Given PID is not a folder: %s',
                        $this->currentTargetNewsFolderId
                    )
                );
                throw new \TYPO3\CMS\Core\Exception(
                    "Given PID is not a folder: '" . $this->currentTargetNewsFolderId . "'"
                );
            }

            // otherwise return true
            return true;
        }

        // if no page is with given uid is found
        return false;
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger(): Logger
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }

}

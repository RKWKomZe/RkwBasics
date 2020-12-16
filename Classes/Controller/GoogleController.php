<?php

namespace RKW\RkwBasics\Controller;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class GoogleController
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GoogleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * @var \RKW\RkwBasics\Cache\SitemapCache
     * @inject
     */
    protected $cache;


    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * pagesRepository
     *
     * @var \RKW\RkwBasics\Domain\Repository\PagesRepository
     * @inject
     */
    protected $pagesRepository = null;


    /**
     * action sitemap
     *
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function sitemapAction()
    {

        if (!$sitemap = $this->getCache()->getContent($this->getCacheKey())) {

            $currentPid = $GLOBALS['TSFE']->id;
            $depth = 999999;

            $treeList = explode(
                ',',
                \RKW\RkwBasics\Utility\GeneralUtility::getTreeList($currentPid , $depth, 0, 1)
            );

            $pages = $this->pagesRepository->findByUidListAndDokTypes($treeList);
            $this->view->assign('pages', $pages);
            $sitemap = $this->view->render();

            // flush caches
            $this->getCache()->getCacheManager()->flushCachesByTag('rkwbasics_sitemap');

            // save results in cache
            $this->getCache()->setContent(
                $sitemap,
                array(
                    'rkwbasics_sitemap',
                ),
                $this->getCacheKey()
            );

            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully rebuilt Google sitemap feed.'));
        } else {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully loaded Google sitemap from cache.'));
        }

        return $sitemap;

    }


    /**
     * Returns cache key
     *
     * @return string
     */
    protected function getCacheKey()
    {
        return GeneralUtility::getHostname();
    }



    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
    }


    /**
     * Returns the cache object
     *
     * @return \RKW\RkwBasics\Cache\SitemapCache
     */
    protected function getCache()
    {

        if (!$this->cache instanceof \RKW\RkwBasics\Cache\SitemapCache) {
            $this->cache = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RKW\RkwBasics\Cache\SitemapCache::class);
        }

        return $this->cache;
    }
}
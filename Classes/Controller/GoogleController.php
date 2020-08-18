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
     * pagesRepository
     *
     * @var \RKW\RkwBasics\Domain\Repository\PagesRepository
     * @inject
     */
    protected $pagesRepository = null;

    /**
     * action sitemap
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function sitemapAction()
    {
        $pages = $this->pagesRepository->findByDokTypes();
        $this->view->assign('pages', $pages);
    }

}
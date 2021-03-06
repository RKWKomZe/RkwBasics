<?php

namespace RKW\RkwBasics\Hooks;

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
 * Class HtmlMinifyHook
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class HtmlMinifyHook
{

    /**
     * Called before page is outputed in order to include INT-Scripts
     *
     * @param array $params
     * @return void The content is passed by reference
     */
    function hook_contentPostProc(&$params)
    {

        // get object
        $obj = $params['pObj'];

        // get CDN
        $cdn = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RKW\RkwBasics\ContentProcessing\HtmlMinify::class);

        // Replace content
        $obj->content = $cdn->process($obj->content);
    }

} 
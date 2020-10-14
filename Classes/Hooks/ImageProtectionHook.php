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
 * Class ImageProtectionHook
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ImageProtectionHook
{

    /**
     * Replaces string patterns from the page content.
     * You can use it to replace URLs for Content Delivery Network (CDN).
     * Called before page is outputed in order to include INT-Scripts
     *
     * @param array $params
     * @return void The content is passed by reference
     */
    function hook_contentPostProc(&$params)
    {
        /**@toDo:not working properly with picture-tags */
        return;

        // get object
        $obj = $params['pObj'];

        // Fetch configuration
        $config = $obj->config['config']['tx_rkwbasics_imageprotection.'];

        // check if enabled
        if ($config['enable'] != 1) {
            return;
        }

        // get object
        $cdn = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\RenderingProcessing\\ImageProtection', $config);

        // Replace content
        $obj->content = $cdn->searchReplace($obj->content, true);

    }

} 
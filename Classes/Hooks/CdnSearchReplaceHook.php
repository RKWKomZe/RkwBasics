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
 * Class CdnSearchReplaceHooks
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CdnSearchReplaceHook
{

    /**
     * Replaces string patterns from the page content.
     * You can use it to replace URLs for Content Delivery Network (CDN).
     * Called before page is indexed, thus CSS and JS-Files are missing here
     *
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $obj
     * @return void The content is also passed by reference
     */
    function hook_indexContent($obj)
    {

        // Fetch configuration
        $config = $obj->config['config']['tx_rkwbasics_cdn.'];

        // check if enabled
        if ($config['enable'] != 1) {
            return;
            //===
        }

        if ($config['enablePostProc'] == 1) {
            $config['subdomainCountBase'] = 0;
            $config['maxSubdomains'] = intval(intval($config['maxSubdomains']) / 2);
        }

        // get domain from base-url	if not set
        if (!$config['baseDomain']) {
            $config['baseDomain'] = preg_replace('/^http(s)?:\/\/(www\.)?([^\/]+)\/?$/i', '$3', $GLOBALS['TSFE']->tmpl->setup['config.']['baseURL']);
        }

        // get object
        $cdn = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Cdn\\SearchReplace', $config);

        // Replace content
        $obj->content = $cdn->searchReplace($obj->content, false);

    }

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

        // get object
        $obj = $params['pObj'];

        // Fetch configuration
        $config = $obj->config['config']['tx_rkwbasics_cdn.'];

        // check if enabled
        if (
            ($config['enable'] != 1)
            || ($config['enablePostProc'] != 1)
        ) {
            return;
            //===
        }

        $config['subdomainCountBase'] = intval(intval($config['maxSubdomains']) / 2);
        $config['maxSubdomains'] = intval(intval($config['maxSubdomains']) / 2);

        // get domain from base-url	if not set
        if (!$config['baseDomain']) {
            $config['baseDomain'] = preg_replace('/^http(s)?:\/\/(www\.)?([^\/]+)\/?$/i', '$3', $GLOBALS['TSFE']->tmpl->setup['config.']['baseURL']);
        }

        // get object
        $cdn = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Cdn\\SearchReplace', $config);

        // Replace content
        $obj->content = $cdn->searchReplace($obj->content, true);

    }

} 
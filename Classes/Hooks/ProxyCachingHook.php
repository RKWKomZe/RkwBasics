<?php

namespace RKW\RkwBasics\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
 * Class ProxyCachingHook
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ProxyCachingHook
{

    /**
     * ContentPostProc-output hook to add typo3-pid header
     *
     * @param array $parameters Parameter
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $parent The parent object
     * @return void
     */
    public function sendHeader(array $parameters, TypoScriptFrontendController $parent)
    {

        // Send login mode - can be used by varnish
        // get PageRepository and rootline
        $repository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $rootlinePages = $repository->getRootLine(intval($GLOBALS['TSFE']->id));

        $status = 0;
        if (isset($rootlinePages[count($rootlinePages) - 1])) {

            // check if something is set in current page
            if ($rootlinePages[count($rootlinePages) - 1]['tx_rkwbasics_proxy_caching']) {
                $status = intval($rootlinePages[count($rootlinePages) - 1]['tx_rkwbasics_proxy_caching']);

                // else inherit
            } else {

                foreach ($rootlinePages as $page => $values) {
                    if ($values['tx_rkwbasics_proxy_caching'] > 0) {
                        $status = intval($values['tx_rkwbasics_proxy_caching']);
                        break;
                        //===
                    }
                }
            }
        }

        header('X-TYPO3-ProxyCaching: ' . $status);
    }

}

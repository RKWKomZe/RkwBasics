<?php
namespace RKW\RkwBasics\Utility;

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

use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utilities to simulate a frontend in backend context.
 *
 */
class FrontendSimulatorUtility
{
    /**
     * @var mixed
     */
    protected static $tsFeBackup;


    /**
     * Sets $GLOBALS['TSFE'] in backend mode
     *
     * @param int $pid
     * @return void
     */
    public static function simulateFrontendEnvironment($pid = 1)
    {

        if (!$pid) {
            $pid = 1;
        }

        // only if in BE-Mode!!! Otherwise FE will be crashed
        if (TYPO3_MODE == 'BE') {

            $currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
            if ($currentVersion < 8000000) {
                if (!is_object($GLOBALS['TT'])) {
                    $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\NullTimeTracker;
                    $GLOBALS['TT']->start();
                }
            }

            // check if we have another pid OR typeNum here - otherwise we use the existing object
            if (!$GLOBALS['TSFE'] instanceof \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController) {

                self::$tsFeBackup = isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : null;

                // remove page-not-found-redirect in BE-context
                $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = '';

                // load frontend context
                try {

                    /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $GLOBALS ['TSFE'] */
                    $GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                        \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class,
                        $GLOBALS['TYPO3_CONF_VARS'],
                        $pid,
                        0
                    );

                    $GLOBALS['TSFE']->connectToDB();
                    $GLOBALS['TSFE']->initFEuser();
                    $GLOBALS['TSFE']->determineId();
                    $GLOBALS['TSFE']->initTemplate();
                    $GLOBALS['TSFE']->getConfigArray();
                    $GLOBALS['LANG']->csConvObj = $GLOBALS['TSFE']->csConvObj;

                    // set pid to $_GET - we need this for BackendConfigurationManager to load the right configuration
                    $_GET['id'] = $_POST['id'] = $pid;

                } catch (\Exception $e) {
                    // do nothing
                }

                // add correct domain to environment variables and flush their cache
                $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($pid);
                $host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
                $_SERVER['HTTP_HOST'] = $host;
                \TYPO3\CMS\Core\Utility\GeneralUtility::flushInternalRuntimeCaches();

                // add host and link-prefix
                $GLOBALS['TSFE']->config['config']['absRefPrefix'] = $host;
                $GLOBALS['TSFE']->config['config']['baseURL'] = $host;
                $GLOBALS['TSFE']->absRefPrefix = '/';
            }


            if (!is_object($GLOBALS['BE_USER'])) {

                // for file access
                /** @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication $backendUserAuthentication */
                $backendUserAuthentication = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class
                );

                $GLOBALS['BE_USER'] = $backendUserAuthentication;
            }
        }
    }



    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @see simulateFrontendEnvironment()
     */
    public static function resetFrontendEnvironment()
    {

        if (TYPO3_MODE == 'BE') {
            if (!empty(self::$tsFeBackup)) {
                $GLOBALS['TSFE'] = self::$tsFeBackup;
            }
        }
    }
}

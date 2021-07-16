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

/**
 * Utility to simulate a frontend in backend context.
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FrontendSimulatorUtility
{

    /**
     * @var array
     */
    protected static $backup;


    /**
     * @var array
     */
    protected static $cache;


    /**
     * Sets $GLOBALS['TSFE'] in backend mode
     *
     * @param int $pid
     * @return int
     */
    public static function simulateFrontendEnvironment($pid = 1): int
    {

        if (!$pid) {
            $pid = 1;
        }

        // only if in BE-Mode!!! Otherwise FE will crash
        if (TYPO3_MODE == 'BE') {

            // try to load from the cache
            if (self::$cache[$pid]) {

                $GLOBALS['TSFE'] = (isset(self::$cache[$pid]['TSFE']) ? self::$cache[$pid]['TSFE'] : null);
                $GLOBALS['LANG'] = (isset(self::$cache[$pid]['LANG']) ? self::$cache[$pid]['LANG'] : null);
                $GLOBALS['TYPO3_CONF_VARS'] = (isset(self::$cache[$pid]['TYPO3_CONF_VARS']) ? self::$cache[$pid]['TYPO3_CONF_VARS'] : null);
                $GLOBALS['BE_USER'] = (isset(self::$cache[$pid]['BE_USER']) ? self::$cache[$pid]['BE_USER'] : null);
                $_SERVER = (isset(self::$cache[$pid]['_SERVER']) ? self::$cache[$pid]['_SERVER'] : null);
                $_GET = (isset(self::$cache[$pid]['_GET']) ? self::$cache[$pid]['_GET'] : null);
                $_POST = (isset(self::$cache[$pid]['_POST']) ? self::$cache[$pid]['_POST'] : null);

                // flush cache of environment variables
                \TYPO3\CMS\Core\Utility\GeneralUtility::flushInternalRuntimeCaches();

                return 2;
            }

            // load frontend context
            try {

                // make a backup of the relevant data and also cache it
                self::$cache[$GLOBALS['TSFE']->id]['TSFE'] = self::$backup['TSFE'] = (isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : null);
                self::$cache[$GLOBALS['TSFE']->id]['LANG'] = self::$backup['LANG'] = (isset($GLOBALS['LANG']) ? $GLOBALS['LANG']: null);
                self::$cache[$GLOBALS['TSFE']->id]['BE_USER'] = self::$backup['BE_USER'] = (isset($GLOBALS['BE_USER']) ? $GLOBALS['BE_USER']: null);
                self::$cache[$GLOBALS['TSFE']->id]['TYPO3_CONF_VARS'] = self::$backup['TYPO3_CONF_VARS'] = (isset($GLOBALS['TYPO3_CONF_VARS']) ? $GLOBALS['TYPO3_CONF_VARS']: null);
                self::$cache[$GLOBALS['TSFE']->id]['_SERVER'] = self::$backup['_SERVER'] = (isset($_SERVER) ? $_SERVER : null);
                self::$cache[$GLOBALS['TSFE']->id]['_GET'] = self::$backup['_GET'] = (isset($_GET) ? $_GET : null);
                self::$cache[$GLOBALS['TSFE']->id]['_POST'] = self::$backup['_POST'] = (isset($_POST) ? $_POST : null);

                // remove page-not-found-redirect in BE-context
                $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = '';

                // add correct domain to environment variables
                $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($pid);
                $host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
                $_SERVER['HTTP_HOST'] = $host;

                // flush cache of environment variables
                \TYPO3\CMS\Core\Utility\GeneralUtility::flushInternalRuntimeCaches();

                // set pid to $_GET - we need this for BackendConfigurationManager to load the right configuration
                $_GET['id'] = $_POST['id'] = $pid;

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
                $GLOBALS['TSFE']->getPageAndRootline();
                $GLOBALS['TSFE']->domainStartPage = $GLOBALS['TSFE']->rootLine[0]['uid'];
                $GLOBALS['LANG']->csConvObj = $GLOBALS['TSFE']->csConvObj;

                // set absRefPrefix and baseURL accordingly
                $GLOBALS['TSFE']->config['config']['absRefPrefix'] = $GLOBALS['TSFE']->config['config']['baseURL'] = $host;
                $GLOBALS['TSFE']->absRefPrefix = $GLOBALS['TSFE']->config['config']['absRefPrefix'] = '/';

                /** @toDo: do we really need this? */
                if (!is_object($GLOBALS['BE_USER'])) {

                    // for file access
                    /** @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication $backendUserAuthentication */
                    $backendUserAuthentication = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                        \TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class
                    );

                    $GLOBALS['BE_USER'] = $backendUserAuthentication;
                }

            } catch (\Exception $e) {
                // do nothing
                return 0;
            }
        }

        return 1;
    }



    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @see simulateFrontendEnvironment()
     * @return bool
     */
    public static function resetFrontendEnvironment(): bool
    {

        if (TYPO3_MODE == 'BE') {
            if (isset(self::$backup)) {

                $GLOBALS['TSFE'] = (isset(self::$backup['TSFE']) ? self::$backup['TSFE'] : null);
                $GLOBALS['LANG'] = (isset(self::$backup['LANG']) ? self::$backup['LANG'] : null);
                $GLOBALS['TYPO3_CONF_VARS'] = (isset(self::$backup['TYPO3_CONF_VARS']) ? self::$backup['TYPO3_CONF_VARS'] : null);
                $GLOBALS['BE_USER'] = (isset(self::$backup['BE_USER']) ? self::$backup['BE_USER'] : null);
                $_SERVER = (isset(self::$backup['_SERVER']) ? self::$backup['_SERVER'] : null);
                $_GET = (isset(self::$backup['_GET']) ? self::$backup['_GET'] : null);
                $_POST = (isset(self::$backup['_POST']) ? self::$backup['_POST'] : null);

                // flush cache of environment variables
                \TYPO3\CMS\Core\Utility\GeneralUtility::flushInternalRuntimeCaches();

                return true;
            }
        }

        return false;
    }
}

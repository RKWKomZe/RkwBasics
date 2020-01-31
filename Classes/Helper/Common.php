<?php

namespace RKW\RkwBasics\Helper;

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
 * Class Common
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Common
{

    /**
     * @var array Setter/Getter underscore transformation cache
     */
    protected static $_underscoreCache = array();

    /**
     * @var array Setter/Getter backslash transformation cache
     */
    protected static $_backslashCache = array();

    /**
     * @var array Setter/Getter camlize transformation cache
     */
    protected static $_camelizeCache = array();


    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @return string
     */
    public static function underscore($name)
    {
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
            //===
        }

        $result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
        self::$_underscoreCache[$name] = $result;

        return $result;
    }

    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @return string
     */
    public static function backslash($name)
    {

        if (isset(self::$_backslashCache[$name])) {
            return self::$_backslashCache[$name];
        }

        $result = preg_replace('/(.)([A-Z])/', "$1\\\\$2", $name);
        self::$_backslashCache[$name] = $result;

        return $result;
    }


    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @param string $destSep
     * @param string $srcSep
     * @return string
     */
    public static function camelize($name, $destSep = '', $srcSep = '_')
    {

        if (isset(self::$_camelizeCache[$name])) {
            return self::$_camelizeCache[$name];
        }

        $result = lcfirst(str_replace(' ', $destSep, ucwords(str_replace($srcSep, ' ', $name))));
        self::$_camelizeCache[$name] = $result;

        return $result;
    }


    /**
     * Allows multiple delimiter replacement for explode
     *
     * @param array  $delimiters
     * @param string $string
     * @return array
     */
    public static function multiExplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $result = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode($delimiters[0], $ready, true);

        return $result;
    }

    /**
     * Splits string at upper-case chars
     *
     * @param string  $string String to process
     * @param integer $key Key to return
     * @return array
     * @see http://stackoverflow.com/questions/8577300/explode-a-string-on-upper-case-characters
     */
    public static function splitAtUpperCase($string, $key = null)
    {

        $result = preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY);

        if ($key !== null) {
            return $result[$key];
        }

        return $result;
    }


    /**
     * Get TypoScript configuration
     *
     * @param string $extension
     * @param string $type
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public static function getTyposcriptConfiguration($extension = null, $type = \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');

        // load configuration
        if ($configurationManager) {
            $settings = $configurationManager->getConfiguration($type, $extension);
            if (
                ($settings)
                && (is_array($settings))
            ) {
                return $settings;
            }
        }

        return array();
    }


    /**
     * init frontend to render frontend links in task
     *
     * @param int $pid
     * @param integer $typeNum
     * @return void
     * @throws \Exception
     */
    public static function initFrontendInBackendContext ($pid = 1, $typeNum = 0)
    {

        // only if in BE-Mode!!! Otherwise FE will be crashed
        if (TYPO3_MODE == 'BE') {

            if (!is_object($GLOBALS['TT'])) {
                $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\NullTimeTracker;
                $GLOBALS['TT']->start();
            }

            // check if we have another pid OR typeNum here - otherwise we use the existing object
            if (
                (!$GLOBALS['TSFE'] instanceof \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController)
                || ($GLOBALS['TSFE']->type != $typeNum)
                || ($GLOBALS['TSFE']->id != $pid)
            ) {

                // add correct domain to environment variables and flush their cache
                $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($pid);
                $host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
                $_SERVER['HTTP_HOST'] = $host;
                \TYPO3\CMS\Core\Utility\GeneralUtility::flushInternalRuntimeCaches();

                // add link-prefix
                $GLOBALS['TSFE']->config['config']['absRefPrefix'] = $host;
                $GLOBALS['TSFE']->absRefPrefix = '/';

                // remove page-not-found-redirect in BE-context
                $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = '';

                // load frontend context
                try {
                    
                    /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $frontendController */
                    $frontendController = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                        \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class,
                        $GLOBALS['TYPO3_CONF_VARS'],
                        $pid,
                        $typeNum
                    );

                    $frontendController->connectToDB();
                    $frontendController->initFEuser();
                    $frontendController->determineId();
                    $frontendController->initTemplate();
                    $frontendController->getConfigArray();

                    $GLOBALS['TSFE'] = $frontendController;
                    $GLOBALS['LANG']->csConvObj = $frontendController->csConvObj;

                } catch (\Exception $e) {
                    throw new \Exception ($e->getMessage());
                }

                // for files
                $backendUserAuthentication = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class
                );
                $GLOBALS['BE_USER'] = $backendUserAuthentication;
            }
        }
    }
}
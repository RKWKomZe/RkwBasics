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

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwBasics\Utility\FrontendSimulatorUtility;

/**
 * Class Common
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Common extends GeneralUtility
{

    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @return string
     */
    public static function underscore(string $name): string
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return GeneralUtility::underscore($name);
    }

    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @return string
     * @deprecated This function is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\GeneralUtility instead.
     */
    public static function backslash(string $name): string
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return GeneralUtility::backslash($name);
    }


    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @param string $destSep
     * @param string $srcSep
     * @return string
     * @deprecated This function is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\GeneralUtility instead.
     */
    public static function camelize(string $name, string $destSep = '', string $srcSep = '_'): string
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return GeneralUtility::camelize($name, $destSep, $srcSep);
    }


    /**
     * Allows multiple delimiter replacement for explode
     *
     * @param array  $delimiters
     * @param string $string
     * @return array
     * @deprecated This function is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\GeneralUtility instead.
     */
    public static function multiExplode(array $delimiters, string $string): array
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return GeneralUtility::multiExplode($delimiters, $string);
    }

    /**
     * Splits string at upper-case chars
     *
     * @param string  $string String to process
     * @param integer $key Key to return
     * @return array
     * @deprecated This function is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\GeneralUtility instead.
     * @see http://stackoverflow.com/questions/8577300/explode-a-string-on-upper-case-characters
     */
    public static function splitAtUpperCase(string $string, $key = null)
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return GeneralUtility::splitAtUpperCase($string, $key);
    }


    /**
     * Get TypoScript configuration
     *
     * @param string $extension
     * @param string $type
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @deprecated This function is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\GeneralUtility instead.
     */
    public static function getTyposcriptConfiguration(string $extension = null, $type = \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS): array
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return GeneralUtility::getTyposcriptConfiguration($extension, $type);
    }


    /**
     * init frontend to render frontend links in task
     *
     * @param int $pid
     * @param integer $typeNum
     * @return void
     * @deprecated This function is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\FrontendSimulatorUtility instead.
     */
    public static function initFrontendInBackendContext (int $pid = 1, int $typeNum = 0) {

        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        FrontendSimulatorUtility::simulateFrontendEnvironment($pid);

    }
}
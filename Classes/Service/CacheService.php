<?php

namespace RKW\RkwBasics\Service;

use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
 * CacheService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CacheService implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * cacheManager
     *
     * @var \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend
     */
    protected static $cacheManager;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected static $cObj;

    /**
     * initializeObject
     */
    public static function initializeObject() {
        // with own caching
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        self::$cacheManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache("rkw_related");
        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        self::$cObj = $configurationManager->getContentObject();
    }


    /**
     * Read session data
     *
     * @return array Returns the key related data
     */
    public static function getDataArray()
    {
        return self::getCacheValue();
        //===
    }



    /**
     * Read session data
     *
     * @param string $key
     * @return string Returns the key related data
     */
    public static function getDataByKey(string $key)
    {
        $data = self::getCacheValue();

        return $data[$key];
        //===
    }



    /**
     * Write session data. This method prevents overriding existing session data.
     * ses_id will always be set to $sessionId and overwritten if existing in $sessionData
     * This method updates ses_tstamp automatically
     *
     * @param string $key
     * @param string $data
     * @return array The cookie content
     */
    public static function setDataKey(string $key, string $data)
    {
        // Important: Check if something is new, before handle the cookie
        $existingDataOfKey = self::getDataByKey($key);
        if ($existingDataOfKey != $data) {

            $settings = self::getSettings();
            // Hint: if "settings.cookies.allowedKeys" is empty, all keys are allowed
            if (
                !$settings['cookies']['allowedKeys']
                || in_array($key, GeneralUtility::trimExplode(',', $settings['cookies']['allowedKeys']))
            ) {
                // we're updating a cookie by setting a new one (with merged data)
                self::createCache($key, $data);

            } else {
                // do nothing
            }
        }



        return self::getCacheValue();
        //===
    }



    /**
     * Removes cookie data
     *
     * @param string $key
     * @return void
     */
    public static function removeKey(string $key)
    {
        // remove key
        $value = false;
        if (self::$cacheManager->has(self::getCacheName())) {

            // existing
            $cachePresetValue = unserialize(self::$cacheManager->get(self::getCacheName()));

            if (key_exists($key, $cachePresetValue)) {
                unset($cachePresetValue[$key]);
            }

            // add (or overwrite)
            $value = $cachePresetValue;
        }

        if ($value) {
            $settings = self::getSettings();
            $cacheTtl = $settings['cache']['ttl'] ? $settings['cache']['ttl'] : 86400;
            self::$cacheManager->set(
                self::getCacheName(),
                serialize($value),
                array(
                    self::getCacheName(),
                    'tx_rkwbasics',
                    'tx_rkwbasics_session' . intval($GLOBALS['TSFE']->id),
                ),
                $cacheTtl
            );
        }

    }



    /**
     * Remove cookie
     *
     * @return void
     */
    public static function removeCache()
    {
        // will delete the cache of this user
        /** @var \TYPO3\CMS\Core\Cache\CacheManager $cacheManager */
        $cacheManager = self::$cacheManager;
        $cacheManager->flushCachesByTag(self::getCacheName());
    }



    /**
     * Merge RkwCookie data to the FeUser session data
     * (overwrites existing keys of session data; but is not deleting something other)
     *
     * @return void
     */
    public static function copyCacheDataToFeUserSession()
    {
        if (is_array(self::getDataArray())) {
            foreach (self::getDataArray() as $key => $data) {
                $GLOBALS['TSFE']->fe_user->setKey('ses', $key, $data);
            }
        }
    }



    /**
     * Create cookie
     *
     * @param string $key
     * @param string $data
     * @return void
     */
    protected static function createCache(string $key, string $data)
    {

        if (!self::$cacheManager->has(self::getCacheName())) {
            // new
            $value = [
                $key => $data,
            ];
        } else {
            // existing
            $cachePresetValue = unserialize(self::$cacheManager->get(self::getCacheName()));

            // (RE-)SET value
            if ($data) {
                // add (or overwrite)
                $cachePresetValue[$key] = $data;
            }
            $value = $cachePresetValue;
        }

        $settings = self::getSettings();
        $cacheTtl = $settings['cache']['ttl'] ? $settings['cache']['ttl'] : 86400;
        self::$cacheManager->set(
            self::getCacheName(),
            serialize($value),
            array(
                self::getCacheName(),
                'tx_rkwbasics',
                'tx_rkwbasics_session' . intval($GLOBALS['TSFE']->id),
            ),
            $cacheTtl
        );
    }



    /**
     * Returns the configured cache name
     *
     * @return string
     */
    protected static function getCacheName()
    {
        return $GLOBALS['TSFE']->fe_user->id;
        //===
    }



    /**
     * Returns the unserialized cookie value
     *
     * @return array
     */
    protected static function getCacheValue()
    {
        self::initializeObject();
        if (self::$cacheManager->has(self::getCacheName())) {
            return unserialize(self::$cacheManager->get(self::getCacheName()));
            //===
        }
        return [];
        //===
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected static function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return Common::getTyposcriptConfiguration('Rkwbasics', $which);
        //===
    }



    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    public static function getLogger()
    {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
    }
}

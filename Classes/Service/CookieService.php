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
 * CookieService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CookieService implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Read session data
     *
     * @return array Returns the key related data
     */
    public static function getDataArray()
    {
        return self::getCookieValue();
        //===
    }



    /**
     * Read session data
     *
     * @param string $key
     * @return string Returns the key related data
     */
    public static function getDataKey(string $key)
    {
        // @toDo: Read cookie
        $data = self::getCookieValue();

        // @toDo: remove entry?

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
        $settings = self::getSettings();
        // Hint: if "settings.cookies.allowedKeys" is empty, all keys are allowed
        if (
            !$settings['cookies']['allowedKeys']
            || in_array($key, GeneralUtility::trimExplode(',', $settings['cookies']['allowedKeys']))
        ) {
            // we're updating a cookie by setting a new one (with merged data)
            self::createCookie($key, $data);

        } else {
            // do nothing
        }


        return self::getCookieValue();
        //===
    }



    /**
     * Removes cookie data
     *
     * @param string $key
     * @return array The cookie content
     */
    public static function removeKey(string $key)
    {
        // remove key
        self::createCookie($key);

        return self::getCookieValue();
        //===
    }



    /**
     * Remove cookie
     *
     * @return void
     */
    public static function removeCookie()
    {
        setcookie(self::getCookieName(), "", time() - 3600);
    }



    /**
     * Merge RkwCookie data to the FeUser session data
     * (overwrites existing keys of session data; but is not deleting something other)
     *
     * @return void
     */
    public static function copyCookieDataToFeUserSession()
    {
        if (is_array(self::getDataArray())) {

            foreach (self::getDataArray() as $key => $data) {
                $GLOBALS['TSFE']->fe_user->setKey('ses', $key, $data);
                $GLOBALS['TSFE']->storeSessionData();
                // Reminder: The "storeSessionData" will save the DB session data in turn again to our cookie
                // Means: What ever happen in meantime: RkwCookie and FeUserSessionData are synchronized now
                // Means anyhow: Calling this function in RkwSessionBackend::update would create a wonderful loop
                // -> don't be a hero
                // see: \RKW\RkwBasics\Session\RkwSessionBackend::update
            }
        }
    }



    /**
     * Create cookie
     * Set nothing in $data will remove an existing key from the cookie
     *
     * @param string $key
     * @param string $data
     * @return void
     */
    protected static function createCookie(string $key, string $data = '')
    {
        if(!isset($_COOKIE[self::getCookieName()])) {

            // just serialize data
            $value = [$key => $data];

        } else {
            // read existing data and merge with new one
            $cookiePresetValue = unserialize($_COOKIE[self::getCookieName()]);
            if (!$data) {
                // REMOVE
                unset($cookiePresetValue[$key]);
            } else {
                // ADD (or overwrite)
                $cookiePresetValue[$key] = $data;
            }

            // copy to $value which is written below to the cookie
            $value = $cookiePresetValue;
            DebuggerUtility::var_dump($key);
            DebuggerUtility::var_dump($value);
        }

        // remove before set the new one
        //self::removeCookie();

        /*
         Von SK via Slack:
       Falls du doch auf eigene Cookies willst, fänd ich folgende Settings gut:
       • expires = 0
       • path = /
       • domain --> cookieDomain auf LocalConf müsste hier gehen
       • secure --> da gibt es auch was an der LocalConf
       • httpOnly --> true
        */
        $cookieName = self::getCookieName();
        //$value = "";
        $expires = 0;
        $path = "/";
        $domain = trim($GLOBALS['TYPO3_CONF_VARS']['BE']['cookieDomain']);
        $secure = trim($GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieSecure']);
        $httpOnly = true;

        setcookie ($cookieName, serialize($value), $expires, $path, $domain, $secure, $httpOnly);
    }



    /**
     * Returns the configured cookie name
     *
     * @return string
     */
    protected static function getCookieName()
    {
        // @toDo: Make it possible to set cookie name via TS?


        $configuredCookieName = trim($GLOBALS['TYPO3_CONF_VARS']['FE']['cookieNameRkwBasics']);
        if (empty($configuredCookieName)) {
            $configuredCookieName = 'rkw_rkwbasics_fe_typo_user';
        }
        return $configuredCookieName;
        //===
    }



    /**
     * Returns the unserialized cookie value
     *
     * @return array
     */
    protected static function getCookieValue()
    {
        return unserialize($_COOKIE[self::getCookieName()]);
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
}

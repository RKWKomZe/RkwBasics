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
        // Important: Check if something is new, before handle the cookie
        $existingDataOfKey = self::getDataKey($key);
        if ($existingDataOfKey != $data) {

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
        // will delete the cookie with next page reload
        setcookie(self::getCookieName(), "", time() - 3600);
        $_COOKIE[self::getCookieName()] = "";
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
                if ($key != 'typo3_session_id') {
                    $GLOBALS['TSFE']->fe_user->setKey('ses', $key, $data);
                }

                // Reminder: The "storeSessionData" will save the DB session data in turn again to our cookie
                // Means: What ever happen in meantime: RkwCookie and FeUserSessionData are synchronized now
                // Means anyhow: Calling this function in RkwSessionBackend::update would create a wonderful loop
                // -> don't be a hero
                // see: \RKW\RkwBasics\Session\RkwSessionBackend::update
                //$GLOBALS['TSFE']->storeSessionData();
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
        // if typo3_session_id has no match: Kill cookie before create a new one
        // (means: our RKW cookie is part of an old session or the session of another user)
        if (
            $data
            && self::getDataKey('typo3_session_id')
            != $GLOBALS['TSFE']->fe_user->id
        ) {
            self::removeCookie();
        }

        if(!isset($_COOKIE[self::getCookieName()])) {

            // just serialize given data
            // bind cookie to feUserSessionId
            $value = [
                $key => $data,
                'typo3_session_id' => $GLOBALS['TSFE']->fe_user->id
            ];


        } else {
            // read existing data and merge with new one
            $cookiePresetValue = unserialize($_COOKIE[self::getCookieName()]);

            // REMOVE value (always, if exists)
            if (key_exists($key, $cookiePresetValue)) {
                unset($cookiePresetValue[$key]);
                //unset($cookiePresetValue['typo3_session_id']);
            }

            // (RE-)SET value
            if ($data) {
                // add (or overwrite)
                $cookiePresetValue[$key] = $data;
            }

            // copy to $value which is written below to the cookie
            $value = $cookiePresetValue;

        }

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
        $domain = trim($GLOBALS['TYPO3_CONF_VARS']['FE']['cookieDomain']);
        $secure = trim($GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieSecure']);
        $httpOnly = true;


        // will set after page reload
        setcookie($cookieName, serialize($value), $expires, $path, $domain, $secure, $httpOnly);
        // necessary to work immediately with it: https://stackoverflow.com/questions/3230133/accessing-cookie-immediately-after-setcookie
        $_COOKIE[self::getCookieName()] = serialize($value);

        self::getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('Following value is delivered: %s', serialize($value)));
        self::getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('Writing following value to the cookie: %s', serialize(self::getDataArray())));
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

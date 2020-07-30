<?php

namespace RKW\RkwBasics\Session;

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
use TYPO3\CMS\Core\Session\Backend\Exception\SessionNotCreatedException;
use TYPO3\CMS\Core\Session\Backend\Exception\SessionNotFoundException;
use TYPO3\CMS\Core\Session\Backend\Exception\SessionNotUpdatedException;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Doctrine\DBAL\DBALException;
use RKW\RkwBasics\Service\CookieService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class RkwSessionBackend
 *
 * take a look to: /typo3/sysext/core/Classes/Session/Backend/DatabaseSessionBackend.php
 *
 * Show also (to understand frontendUser management):
 * /typo3/sysext/frontend/Classes/Authentication/FrontendUserAuthentication.php
 * /typo3/sysext/core/Classes/Authentication/AbstractUserAuthentication.php
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RkwSessionBackend extends \TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend  implements \TYPO3\CMS\Core\Session\Backend\SessionBackendInterface
{

    /**
     * Updates the session data.
     * ses_id will always be set to $sessionId and overwritten if existing in $sessionData
     * This method updates ses_tstamp automatically
     * IMPORTANT: Always called on $GLOBALS['TSFE']->storeSessionData();
     *
     * @param string $sessionId
     * @param array $sessionData The session data to update. Data may be partial.
     * @return array $sessionData The newly updated session record.
     * @throws SessionNotUpdatedException
     */
    public function update(string $sessionId, array $sessionData): array
    {
        // to handle some data issues on login / logout, we're using an own cookie management
        // activate it through setting the "cookieNameRkwBasics"

        if ($configuredCookieName = trim($GLOBALS['TYPO3_CONF_VARS']['FE']['cookieNameRkwBasics'])) {

            // to synchronize the data of the RkwCookie with the TYPO3 session data, we clear the RkwCookie before we rewrite it
            //CookieService::removeCookie();
            $sesData = unserialize($sessionData['ses_data']);
            foreach ($sesData as $key => $data) {
                //$this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Writing key "%s" with data "%s" to RKW cookie with fe_user ses_id %s', $key, $data, $sessionId));
                // fetch flashMessageArray and other not serialized stuff
                if ($data
                    && is_string($data)
                ) {
                    CookieService::setDataKey($key, $data);
                }
            }
        }

        // do what the function always does
        return parent::update($sessionId, $sessionData);
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
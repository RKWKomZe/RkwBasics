<?php

namespace RKW\RkwBasics\UserFunctions;

use TYPO3\CMS\Core\Messaging\ErrorpageMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * Class FileGetContents
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileGetContents
{

    /**
     * Load given file
     *
     * @param string  Empty string (no content to process)
     * @param array   TypoScript configuration
     * @return string HTML output, showing the current server time.
     */
    function read($content = '', $conf = array())
    {

        $conf = $conf['userFunc.'];
        try {

            $content = '';
            foreach($conf as $key => $file) {

                if (strpos($key, 'file') === 0) {

                    if (strpos($file, 'EXT:') === 0) {
                        $file = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($file);
                    }

                    if ($read = file_get_contents($file)) {
                        $content .= $read;
                    }

                }
            }

            return $content;

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to read file %s. Error: %s', $file, $e->getMessage()));
        }

       return '';
    }



    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    private function getLogger()
    {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
    }


}
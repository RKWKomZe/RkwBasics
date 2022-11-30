<?php

namespace RKW\RkwBasics\ContentProcessing;

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
 * Class ReplaceExtensionPaths
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ReplaceExtensionPaths
{

    /**
     * replaces extension paths in content
     *
     * @param string $content content to replace
     * @return string new content
     */
    public function process($content)
    {

        // Replace content
        $callback = function ($matches) {

            $extKey = $matches[2];
            if (
                ($extKey)
                && (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extKey))
            ) {
                return
                trim (
                    \TYPO3\CMS\Core\Utility\PathUtility::stripPathSitePrefix(
                        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey)
                    )
                , '/');
            }

            return $matches[1];
        };

        return preg_replace_callback('/(EXT:([a-z0-9_]+))/', $callback, $content);
    }

}

<?php

namespace RKW\RkwBasics\ViewHelpers;
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
 * Class OrViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This ViewHelper is not needed any more and will be removed soon
 */
class OrViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Checks if one of the given values is true
     *
     * @param mixed $or1
     * @param mixed $or2
     * @param mixed $or3
     * @return boolean
     */
    public function render($or1, $or2, $or3 = null)
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon. Use natively supported logical operators supported since TYPO3 8.7.');
        if ($or1 || $or2 || $or3) {
            return true;
            //===
        }

        return false;
        //===
    }
}
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
 * Class PageListExplodeViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PageListExplodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @param string $list
     * @param string $delimiter
     * @param string $delimiterTwo
     * @return array
     */
    public function render($list, $delimiter = '|', $delimiterTwo = '###')
    {

        $result = array();
        $items = explode($delimiter, $list);

        foreach ($items as $item) {

            $explodeTemp = explode($delimiterTwo, $item);
            $result[$explodeTemp[0]] = $explodeTemp[1];
        }

        return $result;
        //===

    }

}
<?php
namespace RKW\RkwBasics\ViewHelpers\Rss;

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
 * Class RssDateFormatViewHelper
 *
 * @package RKW_RkwBasics
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Steffen Kroggel, RKW Kompetenzzentrum
 * @licence http://www.gnu.org/copyleft/gpl.htm GNU General Public License, version 2 or later
 */
class DateFormatViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {


	/**
	 * Format timestamps to "D, d M Y H:i:s T"
	 *
	 * @param integer $dateTime
	 * @return string
	 */
	public function render($dateTime) {

		return date("D, d M Y H:i:s O", $dateTime);
		//===
	}

}
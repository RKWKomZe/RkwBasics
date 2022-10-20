<?php
namespace RKW\RkwBasics\Utility;

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
 * Class FrontendLocalizationUtility
 *
 * Localization helper which should be used to fetch localized labels.
 * We can not extend the basic class here, since the methods are used as static methods and this confuses translation-handling
 *
 * @api
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @see \TYPO3\CMS\Extbase\Utility\LocalizationUtility, base is TYPO3 8.7
 */
class FrontendLocalizationUtility extends \TYPO3\CMS\Extbase\Utility\LocalizationUtility
{

}



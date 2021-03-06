<?php
namespace RKW\RkwBasics\Helper;

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
 * Class FrontendLocalization
 *
 * Localization helper which should be used to fetch localized labels.
 * We can not extend the basic class here, since the methods are used as static methods and this confuses translation-handling
 *
 * @api
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class is deprecated and will be removed soon. Please use RKW\RkwBasics\Utility\FrontendLocalization instead.
 */
class FrontendLocalization extends \RKW\RkwBasics\Utility\FrontendLocalization
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
    }
}

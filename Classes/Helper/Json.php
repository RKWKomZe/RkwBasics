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
 * Class Json
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since 2019-08-02 - use \RKW\RkwBasics\Api\JsonApi instead
 */
class Json extends \RKW\RkwAjax\Encoder\JsonTemplateEncoder
{

    /**
     * Constructor
     */
    public function __construct()
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon. Use RKW\RkwAjax\Encoder\JsonTemplateEncoder instead.');
        parent::__construct();
    }
}
<?php
namespace RKW\RkwBasics\Routing\Aspect;

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

use RKW\RkwBasics\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PersistedSlugifiedPatternMapper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PersistedSlugifiedPatternMapper extends \Calien\PersistedSanitizedRouting\Routing\Aspect\PersistedSanitizedPatternMapper
{

    /**
     * @return SlugHelper
     */
    protected function getSlugHelper(): SlugHelper
    {
        if ($this->slugHelper === null) {
            $this->slugHelper = GeneralUtility::makeInstance(
                SlugHelper::class,
                $this->tableName,
                '',
                []
            );
        }

        return $this->slugHelper;
    }

}

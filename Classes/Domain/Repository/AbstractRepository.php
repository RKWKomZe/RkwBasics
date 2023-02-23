<?php
namespace RKW\RkwBasics\Domain\Repository;

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

use Madj2k\CoreExtended\Utility\QueryUtility;

/**
 * Class AbstractRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
abstract class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * get the WHERE clause for the enabled fields of this TCA table
     * depending on the context
     *
     * @param string $table
     * @return string the additional where clause, something like " AND deleted=0 AND hidden=0"
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @see \TYPO3\CMS\Core\Resource\AbstractRepository
     */
    protected function getWhereClauseForEnabledFields(string $table): string
    {
        return QueryUtility::getWhereClauseEnabled($table);
    }


    /**
     * Function to return the current TYPO3_MODE.
     * This function can be mocked in unit tests to be able to test frontend behaviour.
     *
     * @return string
     * @see \TYPO3\CMS\Core\Resource\AbstractRepository
     */
    protected function getEnvironmentMode(): string
    {
        return TYPO3_MODE;
    }


}

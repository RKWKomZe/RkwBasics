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
 * Class QueryTypo3
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class QueryTypo3
{


    /**
     * get the WHERE clause for the enabled fields of this TCA table
     * depending on the context
     *
     * @param string $table table name
     * @return string the additional where clause, something like " AND deleted=0 AND hidden=0"
     * @see \TYPO3\CMS\Core\Resource\AbstractRepository
     */
    static public function getWhereClauseForEnableFields($table)
    {

        // backend context
        $whereClause = \TYPO3\CMS\Backend\Utility\BackendUtility::BEenableFields($table);
        $whereClause .= \TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause($table);

        return $whereClause;
        //===
    }


    /**
     * get the WHERE clause for the enabled fields of this TCA table
     * depending on the context
     *
     * @param string $table table name
     * @return string the additional where clause, something like " AND deleted=0 AND hidden=0"
     * @see \TYPO3\CMS\Core\Resource\AbstractRepository
     */
    static public function getWhereClauseForDeleteFields($table)
    {

        // backend context
        $whereClause = \TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause($table);

        return $whereClause;
        //===
    }

    /**
     * get the WHERE clause for the language
     * depending on the context
     *
     * @param string $table tablename
     * @param integer $languageUid
     * @return string the additional where clause, something like " AND sys_language_uid = X"
     */
    static public function getWhereClauseForLanguageFields($table, $languageUid = null)
    {

        $whereClause = '';

        if ($GLOBALS['TCA'][$table]['ctrl']['languageField']) {
            $whereClause = ' AND ' . $table . '.' . $GLOBALS['TCA'][$table]['ctrl']['languageField'] . ' = ' . intval($languageUid);
        }

        return $whereClause;
        //===
    }

    /**
     * get the WHERE clause for the versioning
     * depending on the context
     *
     * @param string $table tablename
     * @return string the additional where clause, something like " AND deleted=0 AND hidden=0"
     * @see \TYPO3\CMS\Core\Resource\AbstractRepository
     * @throws \TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException
     */
    static public function getWhereClauseForVersioning($table)
    {

        $whereClause = '';
        if ($GLOBALS['TCA'][$table] && $GLOBALS['TCA'][$table]['ctrl']['versioningWS']) {
            $whereClause = ' AND ' . $table . '.t3ver_state = ' . new \TYPO3\CMS\Core\Versioning\VersionState(\TYPO3\CMS\Core\Versioning\VersionState::DEFAULT_STATE);
        }

        return $whereClause;
        //===
    }


}
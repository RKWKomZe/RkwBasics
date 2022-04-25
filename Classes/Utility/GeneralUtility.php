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

use TYPO3\CMS\Core\Database\Query\QueryHelper;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Class GeneralUtility
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GeneralUtility extends \TYPO3\CMS\Core\Utility\GeneralUtility
{

    /**
     * @var array Setter/Getter underscore transformation cache
     */
    protected static $_underscoreCache = [];

    /**
     * @var array Setter/Getter backslash transformation cache
     */
    protected static $_backslashCache = [];

    /**
     * @var array Setter/Getter camlize transformation cache
     */
    protected static $_camelizeCache = [];


    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @return string
     */
    public static function underscore(string $name): string
    {
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
        }

        $result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
        self::$_underscoreCache[$name] = $result;

        return $result;
    }

    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @return string
     */
    public static function backslash(string $name): string
    {

        if (isset(self::$_backslashCache[$name])) {
            return self::$_backslashCache[$name];
        }

        $result = preg_replace('/(.)([A-Z])/', "$1\\\\$2", $name);
        self::$_backslashCache[$name] = $result;

        return $result;
    }


    /**
     * Converts field names for setters and getters
     * Uses cache to eliminate unnecessary preg_replace
     *
     * @param string $name
     * @param string $destSep
     * @param string $srcSep
     * @return string
     */
    public static function camelize(string $name, string $destSep = '', string $srcSep = '_'): string
    {
        if (isset(self::$_camelizeCache[$name])) {
            return self::$_camelizeCache[$name];
        }

        $result = lcfirst(str_replace(' ', $destSep, ucwords(str_replace($srcSep, ' ', $name))));
        self::$_camelizeCache[$name] = $result;

        return $result;
    }


    /**
     * Allows multiple delimiter replacement for explode
     *
     * @param array  $delimiters
     * @param string $string
     * @return array
     */
    public static function multiExplode(array $delimiters, string $string): array
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $result = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode($delimiters[0], $ready, true);
        return $result;
    }

    /**
     * Splits string at upper-case chars
     *
     * @param string  $string String to process
     * @param integer $key Key to return
     * @return array
     * @see http://stackoverflow.com/questions/8577300/explode-a-string-on-upper-case-characters
     */
    public static function splitAtUpperCase(string $string, $key = null)
    {
        $result = preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY);

        if ($key !== null) {
            return $result[$key];
        }

        return $result;
    }


    /**
     * Get TypoScript configuration
     *
     * @param string $extension
     * @param string $type
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public static function getTyposcriptConfiguration(string $extension = null, $type = \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS): array
    {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');

        // load configuration
        if ($configurationManager) {
            $settings = $configurationManager->getConfiguration($type, $extension);
            if (
                ($settings)
                && (is_array($settings))
            ) {
                return $settings;
            }
        }

        return array();
    }


    /**
     * Recursively fetch all descendants of a given page - slightly modified version of core-method
     *
     * @param int $id uid of the page
     * @param int $depth
     * @param int $begin
     * @param string $permClause
     * @return string comma separated list of descendant pages
     * @see \TYPO3\CMS\Core\Database\QueryGenerator::getTreeList()
     */
    static public function getTreeList(int $id, int $depth, int $begin = 0, string $permClause = ''): string
    {

        if ($id < 0) {
            $id = abs($id);
        }
        if ($begin === 0) {
            $theList = $id;
        } else {
            $theList = '';
        }
        if ($id && $depth > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
            $statement = $queryBuilder->select('uid', 'tx_rkwbasics_no_index')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT)),
                    QueryHelper::stripLogicalOperatorPrefix($permClause)
                )
                ->execute();

            while ($row = $statement->fetch()) {
                if ($begin <= 0) {
                    $theList .= ',' . $row['uid'];
                }
                if (
                    ($depth > 1)
                    && (! $row['tx_rkwbasics_no_index'])
                ){
                    $theSubList = self::getTreeList($row['uid'], $depth - 1, $begin - 1, $permClause);
                    if (!empty($theList) && !empty($theSubList) && ($theSubList[0] !== ',')) {
                        $theList .= ',';
                    }
                    $theList .= $theSubList;
                }
            }
        }

        return $theList;
    }

    /**
     * Merges arrays by numeric key and sorts them in zipper procedure
     * 
     * @param array ...$arrays
     * @return array
     */
    static public function arrayZipMerge(
        array ...$arrays
    ): array {
        
        // find array with highest number of keys
        $maxCount = 0;
        foreach ($arrays as $array) {
            if (count($array) > $maxCount) {
                $maxCount = count($array);
            }
        }
        
        // move all keys to new numeric index
        foreach($arrays as $key => $array) {
            $arrays[$key] = array_values($array);
        }
        
        // now rebuild array
        $result = [];
        for ($i = 0; $i < $maxCount; $i++) {
            foreach ($arrays as $array) {
                if (isset($array[$i])) {
                    $result[] = $array[$i];
                }
            }
        }        
        
        return $result;
    }

}
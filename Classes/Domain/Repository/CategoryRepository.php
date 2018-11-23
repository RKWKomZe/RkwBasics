<?php

namespace RKW\RkwBasics\Domain\Repository;

use \RKW\RkwBasics\Domain\Model\Category;

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
 * Class CategoryRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>, Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * findOneWithAllRecursiveChildren
     *
     * @param \RKW\RkwBasics\Domain\Model\Category $sysCategory
     * @param boolean $returnUidArray
     * @param boolean $excludeEntriesWithoutParent
     * @param string $ordering
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array|object|void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findOneWithAllRecursiveChildren(Category $sysCategory = null, $returnUidArray = null, $excludeEntriesWithoutParent = false, $ordering = "ASC")
    {
        $query = $this->createQuery();
        $constraints = array();
        $sysCategoryUidArray = array();

        // if sysCategoryList is set, go recursive through the db
        if (!$sysCategory instanceof \RKW\RkwBasics\Domain\Model\Category) {
            // important: Return void. No empty string, no empty array - simply nothing!
            return;
            //===
        } else {

            // 1. Set initial UID
            $sysCategoryUidArray[] = $sysCategory->getUid();

            // 2. Get children (of children, of children...)
            $goAhead = true;
            do {
                $query->matching(
                    $query->in('parent', $sysCategoryUidArray)
                );

                if ($furtherResults = $query->execute()) {
                    $itemCounter = 0;
                    // iterate results
                    foreach ($furtherResults as $category) {
                        // if not set yet, add to array
                        if (!in_array($category->getUid(), $sysCategoryUidArray)) {
                            $sysCategoryUidArray[] = $category->getUid();
                            $itemCounter++;
                        }
                    }
                    // check if something was added to the array. If not, we're at the end here!
                    if (!$itemCounter) {
                        $goAhead = false;
                    }
                } else {
                    $goAhead = false;
                }
            } while ($goAhead);

            // If wanted: Return the UID array and get out of here! :)
            if ($returnUidArray) {
                return $sysCategoryUidArray;
                //===
            }

            // 3. define final query with summary of sysCategoryUid's!
            $constraints[] = $query->in('uid', $sysCategoryUidArray);
        }

        // excluding parent
        if ($excludeEntriesWithoutParent) {
            $constraints[] = $query->logicalNot($query->equals('parent', 0));
        }

        // NOW: construct final query!
        if ($constraints) {
            $query->matching($query->logicalAnd($constraints));
        }

        // orderings
        if ($ordering == "ASC") {
            $query->setOrderings(array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }
        if ($ordering == "DESC") {
            $query->setOrderings(array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        }

        // if there is no sysCategoryList defined, this execute is equal to a findAll()!
        // get single result
        if (count($sysCategoryUidArray) == 1) {
            return $query->execute()->getFirst();
            //===
        }

        // here we got a good old QueryResultInterface-Result
        return $query->execute();
        //===
    }


    /**
     * findAllOrRecursiveBySelection
     *
     * @author Maximilian Fäßler
     * @param array $sysCategoryList
     * @param boolean $returnUidArray
     * @param boolean $excludeEntriesWithoutParent
     * @param string $ordering
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllOrRecursiveBySelection($sysCategoryList = null, $returnUidArray = null, $excludeEntriesWithoutParent = true, $ordering = "ASC")
    {
        $query = $this->createQuery();
        $constraints = array();

        $sysCategoryUidArray = array();

        // if sysCategoryList is set, go recursive through the db
        // Attention: FlexForm lists with no selected entries returns an empty array. So we check if there is something in
        if (
            is_array($sysCategoryList)
            && $sysCategoryList[0]
        ) {

            // 1. Get by uid
            $query->matching(
                $query->in('uid', $sysCategoryList)
            );

            $resultArray = $query->execute();
            foreach ($resultArray as $result) {
                $sysCategoryUidArray[] = $result->getUid();
            }

            // 2. Get children (of children, of children...)
            $goAhead = true;
            do {
                $query->matching(
                    $query->in('parent', $sysCategoryUidArray)
                );

                if ($furtherResults = $query->execute()) {
                    $itemCounter = 0;
                    // iterate results
                    foreach ($furtherResults as $category) {
                        // if not set yet, add to array
                        if (!in_array($category->getUid(), $sysCategoryUidArray)) {
                            $sysCategoryUidArray[] = $category->getUid();
                            $itemCounter++;
                        }
                    }
                    // check if something was added to the array. If not, we're at the end here!
                    if (!$itemCounter) {
                        $goAhead = false;
                    }
                } else {
                    $goAhead = false;
                }
            } while ($goAhead);

            // If wanted: Return the UID array and get out of here! :)
            if ($returnUidArray) {
                return $sysCategoryUidArray;
                //===
            }

            // 3. define final query with summary of sysCategoryUid's!
            $constraints[] = $query->in('uid', $sysCategoryUidArray);
        }

        // excluding parent
        if ($excludeEntriesWithoutParent) {
            $constraints[] = $query->logicalNot($query->equals('parent', 0));
        }

        // NOW: construct final query!
        if ($constraints) {
            $query->matching($query->logicalAnd($constraints));
        }

        // orderings
        if ($ordering == "ASC") {
            $query->setOrderings(array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        }
        if ($ordering == "DESC") {
            $query->setOrderings(array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        }

        // findAll()-Uid return, if uid-Array is wanted
        if ($returnUidArray) {
            foreach ($query->execute() as $result) {
                $sysCategoryUidArray[] = $result->getUid();
            }

            return $sysCategoryUidArray;
            //===
        }

        // if there is no sysCategoryList defined, this execute is equal to a findAll()!
        // here we got a good old QueryResultInterface-Result
        return $query->execute();
        //===
    }
}

?>
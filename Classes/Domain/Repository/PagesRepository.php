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

/**
 * Class PagesRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PagesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * initializeObject
     *
     * @return void
     */
    public function initializeObject()
    {

        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');

        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($querySettings);
    }


    /**
     * find all pages which have the given seriesId but not the currentPageId
     *
     * @param integer $seriesId
     * @param integer $currentPageId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findByTxRkwbasicsSeries($seriesId, $currentPageId)
    {

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('tx_rkwbasics_series', $seriesId),
                $query->logicalNot(
                    $query->equals('uid', $currentPageId)
                )
            )
        );

        return $query->execute();
    }


    /**
     * find all pages of list and dokTypes
     *
     * @param array $uidList
     * @param array $dokTypes
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByUidListAndDokTypes(array $uidList, array $dokTypes = [1])
    {

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->in('uid', $uidList),
                $query->in('doktype', $dokTypes),
                $query->equals('tx_rkwbasics_no_index', 0)
            )
        );

        return $query->execute();
    }

}


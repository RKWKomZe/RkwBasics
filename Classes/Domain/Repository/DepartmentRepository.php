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
 * Class DepartmentRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DepartmentRepository extends AbstractRepository
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
     * findAllByVisibility
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAllByVisibility()
    {

        $query = $this->createQuery();
        $query->matching(
            $query->equals('visibility', 1)
        );

        return $query->execute();
        //===

    }

    /**
     * findAllSorted
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAllSorted()
    {
        $query = $this->createQuery();
        $query->setOrderings(array('name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));

        return $query->execute();
        //===
    }


    /**
     * findAllByVisibility
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByBoxImageAndMainPage()
    {

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('boxImage', 1),
                $query->greaterThan('mainPage', 0)
            )
        );

        return $query->execute();
        //===

    }


}

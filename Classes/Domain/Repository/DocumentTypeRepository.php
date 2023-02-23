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

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * Class DocumentTypeRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DocumentTypeRepository extends AbstractRepository
{

    /**
     * initializeObject
     *
     * @return void
     */
    public function initializeObject(): void
    {

        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);

        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($querySettings);
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
     * findAllByTypeAndVisibility
     *
     * @param string  $type
     * @param boolean $includeDefault
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAllByTypeAndVisibility($type = null, $includeDefault = true)
    {

        if (!$type) {
            $type = 'default';
        }

        $query = $this->createQuery();
        if ($includeDefault) {
            $query->matching(
                $query->logicalAnd(
                    $query->logicalOr(
                        $query->equals('type', $type),
                        $query->equals('type', 'default')
                    ),
                    $query->equals('visibility', 1)
                )
            );

        } else {
            $query->matching(
                $query->logicalAnd(
                    $query->equals('type', $type),
                    $query->equals('visibility', 1)
                )
            );
        }

        $query->setOrderings(
            array('name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)
        );

        return $query->execute();
        //===

    }

}

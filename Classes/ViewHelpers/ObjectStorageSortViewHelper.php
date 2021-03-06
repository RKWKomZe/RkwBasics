<?php

namespace RKW\RkwBasics\ViewHelpers;

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
 * Class ObjectStorageSortViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ObjectStorageSortViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('sortBy', 'string', 'Which property/field to sort by - leave out for numeric sorting based on indexes(keys)', false, false);
        $this->registerArgument('order', 'string', 'ASC or DESC', false, 'ASC');
        $this->registerArgument('sortFlags', 'string', 'Constant name from PHP for SORT_FLAGS: SORT_REGULAR, SORT_STRING, SORT_NUMERIC, SORT_NATURAL, SORT_LOCALE_STRING or SORT_FLAG_CASE', false, 'SORT_REGULAR');
    }

    /**
     * "Render" method - sorts a target list-type target. Either $array or $objectStorage must be specified. If both are,
     * ObjectStorage takes precedence.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage
     * @return mixed
     */
    public function render(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage)
    {

        return $this->sortObjectStorage($objectStorage);
        //===
    }

    /**
     * Sort an ObjectStorage
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected function sortObjectStorage($objectStorage)
    {

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
        $tempObjectStorage = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');

        // put all into a temporary storage in order to keep the original one untouched
        foreach ($objectStorage as $item) {
            $tempObjectStorage->attach($item);
        }

        // now build an index based on the given field
        $sorted = array();
        foreach ($objectStorage as $index => $item) {
            if ($this->arguments['sortBy']) {
                $index = $this->getSortValue($item);
            }
            // if index already exists, append "1" as string
            while (isset($sorted[$index])) {
                $index .= '1';
            }
            $sorted[$index] = $item;
        }

        // now do the real sorting
        if ($this->arguments['order'] === 'ASC') {
            ksort($sorted, constant($this->arguments['sortFlags']));
        } else {
            krsort($sorted, constant($this->arguments['sortFlags']));
        }

        // now we finally rebuild our object storage
        $storage = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
        foreach ($sorted as $item) {
            $storage->attach($item);
        }

        return $storage;
        //===
    }

    /**
     * Gets the value to use as sorting value from $object
     *
     * @param mixed $object
     * @return mixed
     * @throws \TYPO3\CMS\Extbase\Reflection\Exception\PropertyNotAccessibleException
     */
    protected function getSortValue($object)
    {
        $field = $this->arguments['sortBy'];

        /** @var \TYPO3\CMS\Extbase\Reflection\ObjectAccess $objectAccess */
        $objectAccess = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Reflection\\ObjectAccess');
        $value = $objectAccess::getProperty($object, $field);

        if ($value instanceof \DateTime) {
            $value = $value->format('U');

        } elseif ($value instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            $value = $value->count();

        } elseif (is_array($value)) {
            $value = count($value);
        }

        return $value;
        //===
    }
}

?>
<?php

namespace RKW\RkwBasics\Domain\Model;
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
 * FileReference
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * @var string
     */
    protected $tableLocal = 'sys_file';


    /**
     * @var string
     */
    protected $fieldname = 'image';


    /**
     * @var \RKW\RkwBasics\Domain\Model\File
     */
    protected $file;


    /**
     * @var string
     */
    protected $tablenames = '';


    /**
     *
     * @var string
     */
    protected $uidForeign = '';


    /**
     * Returns the tableLocal
     *
     * @return string $tableLocal
     */
    public function getTableLocal()
    {
        return $this->tableLocal;
    }

    /**
     * Sets the tableLocal
     *
     * @param string $tableLocal
     * @return void
     */
    public function setTableLocal($tableLocal)
    {
        $this->tableLocal = $tableLocal;
    }


    /**
     * Set fieldname
     *
     * @param string
     */
    public function setFieldname($fieldname)
    {
        $this->fieldname = $fieldname;
    }

    /**
     * Get fieldname
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->fieldname;
    }


    /**
     * Set file
     *
     * @param \RKW\RkwBasics\Domain\Model\File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return \RKW\RkwBasics\Domain\Model\File
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Returns the tablenames
     *
     * @return string $tablenames
     */
    public function getTablenames()
    {
        return $this->tablenames;
    }

    /**
     * Sets the tablenames
     *
     * @param string $tablenames
     * @return void
     */
    public function setTablenames($tablenames)
    {
        $this->tablenames = $tablenames;
    }

    /**
     * Returns the uidForeign
     *
     * @return string $uidForeign
     */
    public function getUidForeign()
    {
        return $this->uidForeign;
    }

    /**
     * Sets the uidForeign
     *
     * @param string $uidForeign
     * @return void
     */
    public function setUidForeign($uidForeign)
    {
        $this->uidForeign = $uidForeign;
    }


}
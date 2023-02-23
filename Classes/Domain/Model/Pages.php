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

use \Madj2k\CoreExtended\Domain\Model\FileReference;

/**
 * Class Pages
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since v9.5. References should be replaced with sys_categories in the long run
 */
class Pages extends \Madj2k\CoreExtended\Domain\Model\Pages
{

    /**
     * txRkwbasicsDepartment
     *
     * @var \RKW\RkwBasics\Domain\Model\Department|null
     */
    protected ?Department $txRkwbasicsDepartment = null;


    /**
     * txRkwbasicsDocumentType
     *
     * @var \RKW\RkwBasics\Domain\Model\DocumentType|null
     */
    protected ?DocumentType $txRkwbasicsDocumentType = null;


    /**
     * txRkwbasicsSeries
     *
     * @var \RKW\RkwBasics\Domain\Model\Series|null
     */
    protected ?Series $txRkwbasicsSeries = null;


    /**
     * txRkwbasicsExternalLink
     *
     * @var string
     */
    protected string $txRkwbasicsExternalLink =  '';


    /**
     * Returns the txRkwbasicsDepartment
     *
     * @return \RKW\RkwBasics\Domain\Model\Department
     * @deprecated should be changed to usage of sys_categories
     */
    public function getTxRkwbasicsDepartment():? Department
    {
        return $this->txRkwbasicsDepartment;
    }


    /**
     * Sets the txRkwbasicsDepartment
     *
     * @param \RKW\RkwBasics\Domain\Model\Department $txRkwbasicsDepartment
     * @return void
     * @deprecated should be changed to usage of sys_categories
     */
    public function setTxRkwbasicsDepartment(Department $txRkwbasicsDepartment): void
    {
        $this->txRkwbasicsDepartment = $txRkwbasicsDepartment;
    }


    /**
     * Returns the txRkwbasicsDocumentType
     *
     * @return \RKW\RkwBasics\Domain\Model\DocumentType
     * @deprecated should be changed to usage of sys_categories
     */
    public function getTxRkwbasicsDocumentType():? DocumentType
    {
        return $this->txRkwbasicsDocumentType;
    }


    /**
     * Sets the txRkwbasicsDocumentType
     *
     * @param \RKW\RkwBasics\Domain\Model\DocumentType $txRkwbasicsDocumentType
     * @return void
     * @deprecated should be changed to usage of sys_categories
     */
    public function setTxRkwbasicsDocumentType(DocumentType $txRkwbasicsDocumentType): void
    {
        $this->txRkwbasicsDocumentType = $txRkwbasicsDocumentType;
    }


    /**
     * Returns the txRkwbasicsSeries
     *
     * @return \RKW\RkwBasics\Domain\Model\Series
     * @deprecated should be changed to usage of sys_categories
     */
    public function getTxRkwbasicsSeries():? Series
    {
        return $this->txRkwbasicsSeries;
    }


    /**
     * Sets the txRkwbasicsSeries
     *
     * @param \RKW\RkwBasics\Domain\Model\Series $txRkwbasicsSeries
     * @return void
     * @deprecated should be changed to usage of sys_categories
     */
    public function setTxRkwbasicsSeries(Series $txRkwbasicsSeries): void
    {
        $this->txRkwbasicsSeries = $txRkwbasicsSeries;
    }


    /**
     * Returns the txRkwbasicsExternalLink
     *
     * @return string
     */
    public function getTxRkwbasicsExternalLink(): string
    {
        return $this->txRkwbasicsExternalLink;
    }


    /**
     * Sets the txRkwbasicsExternalLink
     *
     * @param string $txRkwbasicsExternalLink
     * @return void
     */
    public function setTxRkwbasicsExternalLink(string $txRkwbasicsExternalLink)
    {
        $this->txRkwbasicsExternalLink = $txRkwbasicsExternalLink;
    }
}

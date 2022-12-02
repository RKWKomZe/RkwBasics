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
 */
class Pages extends \Madj2k\CoreExtended\Domain\Model\Pages
{


    /**
     * txRkwbasicsTeaserImage
     *
     * @var \Madj2k\CoreExtended\Domain\Model\FileReference
     */
    protected $txRkwbasicsTeaserImage = null;


    /**
     * txRkwbasicsDepartment
     *
     * @var \RKW\RkwBasics\Domain\Model\Department
     */
    protected $txRkwbasicsDepartment = null;

    /**
     * txRkwbasicsDocumentType
     *
     * @var \RKW\RkwBasics\Domain\Model\DocumentType
     */
    protected $txRkwbasicsDocumentType = null;


    /**
     * txRkwbasicsSeries
     *
     * @var \RKW\RkwBasics\Domain\Model\Series
     */
    protected $txRkwbasicsSeries = null;


    /**
     * txRkwbasicsFile
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $txRkwbasicsFile = null;


    /**
     * txRkwbasicsCover
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $txRkwbasicsCover = null;


    /**
     * txRkwbasicsExternalLink
     *
     * @var string
     */
    protected $txRkwbasicsExternalLink = null;


    /**
     * Returns the txRkwbasicsTeaserText
     *
     * @return string $txRkwbasicsTeaserText
     * @deprecated This function  is deprecated and will be removed soon.
     */
    public function getTxRkwbasicsTeaserText(): string
    {
        trigger_error('This method "' . __METHOD__ . '" is deprecated and will be removed soon. Do not use it anymore.', E_USER_DEPRECATED);
        return $this->getAbstract();
    }


    /**
     * Returns the txRkwbasicsTeaserImage
     *
     * @return \Madj2k\CoreExtended\Domain\Model\FileReference $txRkwbasicsTeaserImage
     */
    public function getTxRkwbasicsTeaserImage()
    {
        return $this->txRkwbasicsTeaserImage;
    }


    /**
     * Sets the txRkwbasicsTeaserImage
     *
     * @param \Madj2k\CoreExtended\Domain\Model\FileReference $txRkwbasicsTeaserImage
     * @return void
     */
    public function setTxRkwbasicsTeaserImage(FileReference $txRkwbasicsTeaserImage): void
    {
        $this->txRkwbasicsTeaserImage = $txRkwbasicsTeaserImage;
    }


    /**
     * Returns the txRkwbasicsDepartment
     *
     * @return \RKW\RkwBasics\Domain\Model\Department $txRkwbasicsDepartment
     */
    public function getTxRkwbasicsDepartment()
    {
        return $this->txRkwbasicsDepartment;
    }


    /**
     * Sets the txRkwbasicsDepartment
     *
     * @param \RKW\RkwBasics\Domain\Model\Department $txRkwbasicsDepartment
     * @return void
     */
    public function setTxRkwbasicsDepartment(Department $txRkwbasicsDepartment): void
    {
        $this->txRkwbasicsDepartment = $txRkwbasicsDepartment;
    }


    /**
     * Returns the txRkwbasicsDocumentType
     *
     * @return \RKW\RkwBasics\Domain\Model\DocumentType $txRkwbasicsDocumentType
     */
    public function getTxRkwbasicsDocumentType()
    {
        return $this->txRkwbasicsDocumentType;
    }


    /**
     * Sets the txRkwbasicsDocumentType
     *
     * @param \RKW\RkwBasics\Domain\Model\DocumentType $txRkwbasicsDocumentType
     * @return void
     */
    public function setTxRkwbasicsDocumentType(DocumentType $txRkwbasicsDocumentType): void
    {
        $this->txRkwbasicsDocumentType = $txRkwbasicsDocumentType;
    }


    /**
     * Returns the txRkwbasicsSeries
     *
     * @return \RKW\RkwBasics\Domain\Model\Series $txRkwbasicsSeries
     */
    public function getTxRkwbasicsSeries()
    {
        return $this->txRkwbasicsSeries;
    }


    /**
     * Sets the txRkwbasicsSeries
     *
     * @param \RKW\RkwBasics\Domain\Model\Series $txRkwbasicsSeries
     * @return void
     */
    public function setTxRkwbasicsSeries(Series $txRkwbasicsSeries): void
    {
        $this->txRkwbasicsSeries = $txRkwbasicsSeries;
    }


    /**
     * Returns the txRkwbasicsFile
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsFile
     */
    public function getTxRkwbasicsFile()
    {
        return $this->txRkwbasicsFile;
    }


    /**
     * Sets the txRkwbasicsFile
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsFile
     * @return void
     */
    public function setTxRkwbasicsFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsFile): void
    {
        $this->txRkwbasicsFile = $txRkwbasicsFile;
    }


    /**
     * Returns the txRkwbasicsCover
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsCover
     */
    public function getTxRkwbasicsCover()
    {
        return $this->txRkwbasicsCover;
    }


    /**
     * Sets the txRkwbasicsCover
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsCover
     * @return void
     */
    public function setTxRkwbasicsCover(\TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsCover): void
    {
        $this->txRkwbasicsCover = $txRkwbasicsCover;
    }


    /**
     * Returns the txRkwbasicsExternalLink
     *
     * @return string $txRkwbasicsExternalLink
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

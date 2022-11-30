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
 * Class Pages
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Pages extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{


    /**
     * crdate
     *
     * @var integer
     */
    protected $crdate = 0;


    /**
     * tstamp
     *
     * @var integer
     */
    protected $tstamp = 0;


    /**
     * hidden
     *
     * @var bool
     */
    protected $hidden = 0;


    /**
     * deleted
     *
     * @var bool
     */
    protected $deleted = 0;


    /**
     * sorting
     *
     * @var int
     */
    protected $sorting = 0;


    /**
     * doktype
     *
     * @var int
     */
    protected $doktype = 1;


    /**
     * title
     *
     * @var string
     */
    protected $title = '';


    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle = '';


    /**
     * abstract
     *
     * @var string
     */
    protected $abstract = '';


    /**
     * description
     *
     * @var string
     */
    protected $description = '';


    /**
     * noSearch
     *
     * @var bool
     */
    protected $noSearch = false;


    /**
     * lastUpdated
     *
     * @var integer
     */
    protected $lastUpdated = 0;


    /**
     * txRkwbasicsAlternativeTitle
     *
     * @var string
     */
    protected $txRkwbasicsAlternativeTitle = '';


    /**
     * txRkwbasicsFeLayoutNextLevel
     *
     * @var \integer
     */
    protected $txRkwbasicsFeLayoutNextLevel = 0;



    /**
     * txRkwbasicsTeaserImage
     *
     * @var \RKW\RkwBasics\Domain\Model\FileReference
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
     * Returns the pid
     *
     * @return int $pid
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * Returns the crdate value
     *
     * @return integer
     * @api
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }


    /**
     * Sets the crdate value
     *
     * @param int $crdate
     * @return void
     * @api
     */
    public function setCrdate(int $crdate): void
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the tstamp value
     *
     * @return integer
     * @api
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp value
     *
     * @param int $tstamp
     * @return void
     * @api
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Returns the hidden value
     *
     * @return bool
     * @api
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }


    /**
     * Sets the hidden value
     *
     * @param bool $hidden
     * @return void
     * @api
     */
    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the deleted value
     *
     * @return bool
     * @api
     */
    public function getDeleted(): int
    {
        return $this->deleted;
    }


    /**
     * Sets the deleted value
     *
     * @param bool $deleted
     * @return void
     * @api
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }


    /**
     * Returns the sorting
     *
     * @return int $sorting
     */
    public function getSorting(): int
    {
        return $this->sorting;
    }


    /**
     * Sets the sorting value
     *
     * @param int $sorting
     * @return void
     * @api
     */
    public function setSorting(int $sorting): void
    {
        $this->sorting = $sorting;
    }


    /**
     * Returns the doktype
     *
     * @return int $doktype
     */
    public function getDoktype(): int
    {
        return $this->doktype;
    }


    /**
     * Sets the doktype value
     *
     * @param int $doktype
     * @return void
     * @api
     */
    public function setDoktype(int $doktype): void
    {
        $this->doktype = $doktype;
    }


    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * Returns the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }


    /**
     * Set the subtitle
     *
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }


    /**
     * Returns the abstract
     *
     * @return string $abstract
     */
    public function getAbstract(): string
    {
        return $this->abstract;
    }


    /**
     * Set the abstract
     *
     * @param string $abstract
     * @return void
     */
    public function setAbstract(string $abstract): void
    {
        $this->abstract = $abstract;
    }


    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    /**
     * Returns the noSearch
     *
     * @return bool $noSearch
     */
    public function getNoSearch(): bool
    {
        return $this->noSearch;
    }


    /**
     * Set the noSearch
     *
     * @param bool $noSearch
     * @return void
     */
    public function setNoSearch(bool $noSearch): void
    {
        $this->noSearch = $noSearch;
    }


    /**
     * Returns the lastUpdated
     *
     * @return int $lastUpdated
     */
    public function getLastUpdated(): int
    {
        return $this->lastUpdated;
    }


    /**
     * Set the lastUpdated
     *
     * @param int $lastUpdated
     * @return void
     */
    public function setLastUpdated(int $lastUpdated): void
    {
        $this->lastUpdated = $lastUpdated;
    }


    /**
     * Returns the txRkwbasicsAlternativeTitle
     *
     * @return string $txRkwbasicsAlternativeTitle
     */
    public function getTxRkwbasicsAlternativeTitle(): string
    {
        return $this->txRkwbasicsAlternativeTitle;
    }


    /**
     * Sets the txRkwbasicsAlternativeTitle
     *
     * @param string $txRkwbasicsAlternativeTitle
     * @return void
     */
    public function setTxRkwbasicsAlternativeTitle(string $txRkwbasicsAlternativeTitle): void
    {
        $this->txRkwbasicsAlternativeTitle = $txRkwbasicsAlternativeTitle;
    }


    /**
     * Returns the txRkwbasicsFeLayoutNextLevel
     *
     * @return int txRkwbasicsFeLayoutNextLevel
     */
    public function getTxRkwbasicsFeLayoutNextLevel(): int
    {
        return $this->txRkwbasicsFeLayoutNextLevel;
    }


    /**
     * Sets the txRkwbasicsFeLayoutNextLevel
     *
     * @param \integer $txRkwbasicsFeLayoutNextLevel
     * @return \integer txRkwbasicsFeLayoutNextLevel
     */
    public function setTxRkwbasicsFeLayoutNextLevel(int $txRkwbasicsFeLayoutNextLevel): void
    {
        $this->txRkwbasicsFeLayoutNextLevel = $txRkwbasicsFeLayoutNextLevel;
    }


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
     * @return \RKW\RkwBasics\Domain\Model\FileReference $txRkwbasicsTeaserImage
     */
    public function getTxRkwbasicsTeaserImage()
    {
        return $this->txRkwbasicsTeaserImage;
    }


    /**
     * Sets the txRkwbasicsTeaserImage
     *
     * @param \RKW\RkwBasics\Domain\Model\FileReference $txRkwbasicsTeaserImage
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

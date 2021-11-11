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
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Pages extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * uid
     *
     * @var int
     */
    protected $uid;

    /**
     * pid
     *
     * @var int
     */
    protected $pid;


    /**
     * crdate
     *
     * @var integer
     */
    protected $crdate;


    /**
     * tstamp
     *
     * @var integer
     */
    protected $tstamp;


    /**
     * hidden
     *
     * @var integer
     */
    protected $hidden;


    /**
     * deleted
     *
     * @var integer
     */
    protected $deleted;


    /**
     * sorting
     *
     * @var int
     */
    protected $sorting;


    /**
     * doktype
     *
     * @var int
     */
    protected $doktype;


    /**
     * title
     *
     * @var string
     */
    protected $title;


    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle;


    /**
     * abstract
     *
     * @var string
     */
    protected $abstract;


    /**
     * description
     *
     * @var string
     */
    protected $description;


    /**
     * noSearch
     *
     * @var integer
     */
    protected $noSearch = 0;


    /**
     * lastUpdated
     *
     * @var integer
     */
    protected $lastUpdated;


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
    protected $txRkwbasicsFeLayoutNextLevel;

    /**
     * txRkwbasicsCssClass
     *
     * @var \integer
     * @deprecated
     */
    protected $txRkwbasicsCssClass;


    /**
     * txRkwbasicsOldDomain
     *
     * @var string
     * @deprecated
     */
    protected $txRkwbasicsOldDomain = '';


    /**
     * txRkwbasicsOldLink
     *
     * @var string
     * @deprecated
     */
    protected $txRkwbasicsOldLink = '';


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
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Returns the crdate value
     *
     * @return integer
     * @api
     */
    public function getCrdate()
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
    public function setCrdate(int $crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the tstamp value
     *
     * @return integer
     * @api
     */
    public function getTstamp()
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
    public function setTstamp(int $tstamp)
    {
        $this->tstamp = $tstamp;
    }
    
    /**
     * Returns the hidden value
     *
     * @return integer
     * @api
     */
    public function getHidden()
    {
        return $this->hidden;
    }
    

    /**
     * Sets the hidden value
     *
     * @param int $hidden
     * @return void
     * @api
     */
    public function setHidden(int $hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the deleted value
     *
     * @return integer
     * @api
     */
    public function getDeleted()
    {
        return $this->deleted;
    }


    /**
     * Sets the deleted value
     *
     * @param int $deleted
     * @return void
     * @api
     */
    public function setDeleted(int $deleted)
    {
        $this->deleted = $deleted;
    }


    /**
     * Returns the sorting
     *
     * @return int $sorting
     */
    public function getSorting()
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
    public function setSorting(int $sorting)
    {
        $this->sorting = $sorting;
    }


    /**
     * Returns the doktype
     *
     * @return int $doktype
     */
    public function getDoktype()
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
    public function setDoktype(int $doktype)
    {
        $this->doktype = $doktype;
    }


    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the subtitle
     *
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the abstract
     *
     * @return string $abstract
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set the abstract
     *
     * @param string $abstract
     * @return void
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }



    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * Returns the noSearch
     *
     * @return int $noSearch
     */
    public function getNoSearch()
    {
        return $this->noSearch;
    }


    /**
     * Set the noSearch
     *
     * @param int $noSearch
     * @return void
     */
    public function setNoSearch($noSearch)
    {
        $this->noSearch = $noSearch;
    }


    /**
     * Returns the lastUpdated
     *
     * @return int $lastUpdated
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set the lastUpdated
     *
     * @param int $lastUpdated
     * @return void
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }


    /**
     * Returns the txRkwbasicsAlternativeTitle
     *
     * @return string $txRkwbasicsAlternativeTitle
     */
    public function getTxRkwbasicsAlternativeTitle()
    {
        return $this->txRkwbasicsAlternativeTitle;
    }

    /**
     * Sets the txRkwbasicsAlternativeTitle
     *
     * @param string $txRkwbasicsAlternativeTitle
     * @return void
     */
    public function setTxRkwbasicsAlternativeTitle($txRkwbasicsAlternativeTitle)
    {
        $this->txRkwbasicsAlternativeTitle = $txRkwbasicsAlternativeTitle;
    }


    /**
     * Returns the txRkwbasicsFeLayoutNextLevel
     *
     * @return \integer txRkwbasicsFeLayoutNextLevel
     */
    public function getTxRkwbasicsFeLayoutNextLevel()
    {
        return $this->txRkwbasicsFeLayoutNextLevel;
    }

    /**
     * Sets the txRkwbasicsFeLayoutNextLevel
     *
     * @param \integer $txRkwbasicsFeLayoutNextLevel
     * @return \integer txRkwbasicsFeLayoutNextLevel
     */
    public function setTxRkwbasicsFeLayoutNextLevel($txRkwbasicsFeLayoutNextLevel)
    {
        $this->txRkwbasicsFeLayoutNextLevel = $txRkwbasicsFeLayoutNextLevel;
    }


    /**
     * Returns the txRkwbasicsCssClass
     *
     * @return \integer $txRkwbasicsCssClass
     * @deprecated 
     */
    public function getTxRkwbasicsCssClass()
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return $this->txRkwbasicsCssClass;
    }

    /**
     * Sets the txRkwbasicsCssClass
     *
     * @param \integer $txRkwbasicsCssClass
     * @return void
     * @deprecated 
     */
    public function setTxRkwbasicsCssClass($txRkwbasicsCssClass)
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        $this->txRkwbasicsCssClass = $txRkwbasicsCssClass;
    }


    /**
     * Returns the txRkwbasicsOldDomain
     *
     * @return string $txRkwbasicsOldDomain
     * @deprecated 
     */
    public function getTxRkwbasicsOldDomain()
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return $this->txRkwbasicsOldDomain;
    }

    /**
     * Sets the txRkwbasicsOldDomain
     *
     * @param string $txRkwbasicsOldDomain
     * @return void
     * @deprecated 
     */
    public function setTxRkwbasicsOldDomain($txRkwbasicsOldDomain)
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        $this->txRkwbasicsOldDomain = $txRkwbasicsOldDomain;
    }

    /**
     * Returns the txRkwbasicsOldLink
     *
     * @return string $txRkwbasicsOldLink
     * @deprecated 
     */
    public function getTxRkwbasicsOldLink()
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        return $this->txRkwbasicsOldLink;
    }

    /**
     * Sets the txRkwbasicsOldLink
     *
     * @param string $txRkwbasicsOldLink
     * @return void
     * @deprecated 
     */
    public function setTxRkwbasicsOldLink($txRkwbasicsOldLink)
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
        $this->txRkwbasicsOldLink = $txRkwbasicsOldLink;
    }


    /**
     * Returns the txRkwbasicsTeaserText
     *
     * @return string $txRkwbasicsTeaserText
     * @deprecated This function  is deprecated and will be removed soon.
     */
    public function getTxRkwbasicsTeaserText()
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();
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
    public function setTxRkwbasicsTeaserImage(\RKW\RkwBasics\Domain\Model\FileReference $txRkwbasicsTeaserImage)
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
    public function setTxRkwbasicsDepartment(\RKW\RkwBasics\Domain\Model\Department $txRkwbasicsDepartment)
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
    public function setTxRkwbasicsDocumentType(\RKW\RkwBasics\Domain\Model\DocumentType $txRkwbasicsDocumentType)
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
    public function setTxRkwbasicsSeries(\RKW\RkwBasics\Domain\Model\Series $txRkwbasicsSeries)
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
    public function setTxRkwbasicsFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsFile)
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
    public function setTxRkwbasicsCover(\TYPO3\CMS\Extbase\Domain\Model\FileReference $txRkwbasicsCover)
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

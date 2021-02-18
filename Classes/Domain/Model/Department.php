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
 * Class Department
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Department extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';


    /**
     * shortName
     *
     * @var string
     */
    protected $shortName = '';


    /**
     * internalName
     *
     * @var string
     * @deprecated
     */
    protected $internalName = '';


    /**
     * cssClass
     *
     * @var string
     */
    protected $cssClass = '';

    /**
     * main page
     *
     * @var string
     */
    protected $mainPage = '';

    /**
     * visibility
     *
     * @var integer
     */
    protected $visibility = 0;

    /**
     * description
     *
     * @var string
     */
    protected $description = '';


    /**
     * boxImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $boxImage = null;


    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the shortName
     *
     * @return string $shortName
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Sets the shortName
     *
     * @param string $shortName
     * @return void
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * Returns the internalName
     *
     * @return string $internalName
     * @deprecated
     */
    public function getInternalName()
    {
        return $this->internalName;
    }

    /**
     * Sets the internalName
     *
     * @param string $internalName
     * @return void
     * @deprecated
     */
    public function setInternalName($internalName)
    {
        $this->internalName = $internalName;
    }

    /**
     * Returns the cssClass
     *
     * @return string $cssClass
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * Sets the cssClass
     *
     * @param string $cssClass
     * @return void
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * Returns the mainPage
     *
     * @return string $mainPage
     */
    public function getMainPage()
    {
        return $this->mainPage;
    }

    /**
     * Sets the mainPage
     *
     * @param string $mainPage
     * @return void
     */
    public function setMainPage($mainPage)
    {
        $this->mainPage = $mainPage;
    }

    /**
     * Returns the visibility
     *
     * @return string $type
     */
    public function getVisibility()
    {
        return $this->visibility;
        //===
    }

    /**
     * Sets the visibility
     *
     * @param string $visibility
     * @return void
     */
    public function setVisibility($visibility)
    {
        $this->visibility = intval($visibility);
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
     * Returns the boxImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $boxImage
     */
    public function getBoxImage()
    {

        if (!is_object($this->boxImage)) {
            return null;
            //===

        } elseif ($this->boxImage instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->boxImage->_loadRealInstance();
        }

        return $this->boxImage->getOriginalResource();
        //===
    }

    /**
     * Sets the boxImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $boxImage
     * @return void
     */
    public function setBoxImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $boxImage)
    {
        $this->boxImage = $boxImage;
    }

}
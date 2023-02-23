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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * Class Department
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since v9.5. References should be replaced with sys_categories in the long run
 */
class Department extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     */
    protected string $name = '';


    /**
     * @var string
     */
    protected string $shortName = '';


    /**
     * @var string
     * @deprecated
     */
    protected string $internalName = '';


    /**
     * @var string
     * @deprecated since TYPO3 v9
     */
    protected string $cssClass = '';


    /**
     * @var string
     */
    protected string $mainPage = '';


    /**
     * @var bool
     */
    protected bool $visibility = false;


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     */
    protected ?FileReference $boxImage = null;


    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Returns the shortName
     *
     * @return string $shortName
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }


    /**
     * Sets the shortName
     *
     * @param string $shortName
     * @return void
     */
    public function setShortName(string $shortName): void
    {
        $this->shortName = $shortName;
    }


    /**
     * Returns the internalName
     *
     * @return string $internalName
     * @deprecated
     */
    public function getInternalName(): string
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
    public function setInternalName(string $internalName): void
    {
        $this->internalName = $internalName;
    }


    /**
     * Returns the cssClass
     *
     * @return string $cssClass
     * @deprecated since TYPO3 v9
     */
    public function getCssClass(): string
    {
        return $this->cssClass;
    }


    /**
     * Sets the cssClass
     *
     * @param string $cssClass
     * @return void
     * @deprecated since TYPO3 v9
     */
    public function setCssClass(string $cssClass): void
    {
        $this->cssClass = $cssClass;
    }


    /**
     * Returns the mainPage
     *
     * @return string $mainPage
     */
    public function getMainPage(): string
    {
        return $this->mainPage;
    }


    /**
     * Sets the mainPage
     *
     * @param string $mainPage
     * @return void
     */
    public function setMainPage(string $mainPage): void
    {
        $this->mainPage = $mainPage;
    }


    /**
     * Returns the visibility
     *
     * @return bool
     */
    public function getVisibility(): bool
    {
        return $this->visibility;
    }


    /**
     * Sets the visibility
     *
     * @param bool $visibility
     * @return void
     */
    public function setVisibility(bool $visibility): void
    {
        $this->visibility = $visibility;
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
     * Returns the boxImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $boxImage
     */
    public function getBoxImage():? FileReference
    {

        if (!is_object($this->boxImage)) {
            return null;

        } elseif ($this->boxImage instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->boxImage->_loadRealInstance();
        }

        return $this->boxImage->getOriginalResource();
    }


    /**
     * Sets the boxImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $boxImage
     * @return void
     */
    public function setBoxImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $boxImage): void
    {
        $this->boxImage = $boxImage;
    }

}

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
 * Class DocumentType
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since v9.5. References should be replaced with sys_categories in the long run
 */
class DocumentType extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * @deprecated
     */
    protected string $boxTemplateName = '';


    /**
     * @var string
     */
    protected string $type = '';


    /**
     * @var int
     */
    protected int $visibility = 0;


    /**
     * @var string
     */
    protected string $description = '';


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
        //===
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
     * Returns the boxTemplateName
     *
     * @return string $boxTemplateName
     * @deprecated
     */
    public function getBoxTemplateName(): string
    {
        return $this->boxTemplateName;
        //===
    }


    /**
     * Sets the boxTemplateName
     *
     * @param string $boxTemplateName
     * @return void
     * @deprecated
     */
    public function setBoxTemplateName(string $boxTemplateName): void
    {
        $this->boxTemplateName = $boxTemplateName;
    }


    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }


    /**
     * Returns the visibility
     *
     * @return string $type
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }


    /**
     * Sets the visibility
     *
     * @param string $visibility
     * @return void
     */
    public function setVisibility(string $visibility): void
    {
        $this->visibility = intval($visibility);
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


}

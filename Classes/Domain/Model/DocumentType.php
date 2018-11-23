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
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DocumentType extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     * @validate NotEmpty
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
     * @validate NotEmpty
     */
    protected $internalName = '';

    /**
     * boxTemplateName
     *
     * @var string
     */
    protected $boxTemplateName = '';

    /**
     * type
     *
     * @var string
     * 0     */
    protected $type = '';


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
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
        //===
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
        //===
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
     */
    public function getInternalName()
    {
        return $this->internalName;
        //===
    }

    /**
     * Sets the internalName
     *
     * @param string $internalName
     * @return void
     */
    public function setInternalName($internalName)
    {
        $this->internalName = $internalName;
    }

    /**
     * Returns the boxTemplateName
     *
     * @return string $boxTemplateName
     */
    public function getBoxTemplateName()
    {
        return $this->boxTemplateName;
        //===
    }

    /**
     * Sets the boxTemplateName
     *
     * @param string $boxTemplateName
     * @return void
     */
    public function setBoxTemplateName($boxTemplateName)
    {
        $this->boxTemplateName = $boxTemplateName;
    }

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
        //===
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
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
        //===
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


}
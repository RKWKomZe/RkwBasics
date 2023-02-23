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
 * Class Series
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since v9.5. References should be replaced with sys_categories in the long run
 */
class Series extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected int $crdate = 0;


    /**
     * @var int
     */
    protected int $tstamp = 0;


    /**
     * @var bool
     */
    protected bool $hidden = false;


    /**
     * @var bool
     */
    protected bool $deleted = false;


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
     **/
    protected string $type = '';


    /**
     * @var bool
     */
    protected bool $visibility = false;

    /**
     * @var string
     */
    protected string $description = '';


    /**
     * Returns the crdate value
     *
     * @return int
     * @api
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }


    /**
     * Returns the tstamp value
     *
     * @return int
     * @api
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
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
     * Returns the deleted value
     *
     * @return bool
     * @api
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }


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
     * Returns the type
     *
     * @return string
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


}

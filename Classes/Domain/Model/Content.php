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
 * Class Content
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * txRkwbasicsImagesNoCopyright
     *
     * @var boolean
     */
    protected $txRkwbasicsImagesNoCopyright = false;

    /**
     * Returns the txRkwbasicsImagesNoCopyright
     *
     * @return boolean $txRkwbasicsImagesNoCopyright
     */
    public function getTxRkwbasicsImagesNoCopyright()
    {
        return $this->txRkwbasicsImagesNoCopyright;
    }

    /**
     * Sets the txRkwbasicsImagesNoCopyright
     *
     * @param boolean $txRkwbasicsImagesNoCopyright
     * @return void
     */
    public function setTxRkwbasicsImagesNoCopyright($txRkwbasicsImagesNoCopyright)
    {
        $this->txRkwbasicsImagesNoCopyright = $txRkwbasicsImagesNoCopyright;
    }

    /**
     * Returns the boolean state of txRkwbasicsImagesNoCopyright
     *
     * @return boolean
     */
    public function isTxRkwbasicsImagesNoCopyright()
    {
        return $this->txRkwbasicsImagesNoCopyright;
    }

}
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
 * Class MediaFileMeta
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MediaFileMeta extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * txRkwbasicsPublisher
     *
     * @var string
     */
    protected $txRkwbasicsPublisher = '';

    /**
     * txRkwbasicsSource
     *
     * @var \RKW\RkwBasics\Domain\Model\MediaSources
     */
    protected $txRkwbasicsSource = null;

    /**
     * Returns the txRkwbasicsPublisher
     *
     * @return string $txRkwbasicsPublisher
     */
    public function getTxRkwbasicsPublisher()
    {
        return $this->txRkwbasicsPublisher;
    }

    /**
     * Sets the txRkwbasicsPublisher
     *
     * @param string $txRkwbasicsPublisher
     * @return void
     */
    public function setTxRkwbasicsPublisher($txRkwbasicsPublisher)
    {
        $this->txRkwbasicsPublisher = $txRkwbasicsPublisher;
    }

    /**
     * Returns the txRkwbasicsSource
     *
     * @return \RKW\RkwBasics\Domain\Model\MediaSources $txRkwbasicsSource
     */
    public function getTxRkwbasicsSource()
    {
        return $this->txRkwbasicsSource;
    }

    /**
     * Sets the txRkwbasicsSource
     *
     * @param \RKW\RkwBasics\Domain\Model\MediaSources $txRkwbasicsSource
     * @return void
     */
    public function setTxRkwbasicsSource(\RKW\RkwBasics\Domain\Model\MediaSources $txRkwbasicsSource)
    {
        $this->txRkwbasicsSource = $txRkwbasicsSource;
    }

}

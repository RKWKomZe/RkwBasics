<?php

namespace RKW\RkwBasics\RenderingProcessing;

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
 * Class ImageProtection
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ImageProtection
{
    /**
     * @var array contains configuration
     */
    protected $config = array();

       /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config)
    {

        $this->config = $config;

        if (!is_array($this->config)) {
            $this->config = array();
        }

        // set default if nothing is set
        if (!$this->config['search']) {
            $this->config['search'] = '/(<img [^>]+>/i';
        }

    }

    /**
     * Adds BlindGif
     *
     * @param string $match
     * @return string
     */
    public function addBlindGif($match)
    {

        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('rkw_basics');
        $blindGifPath = $extPath . 'Resources/Public/Img/blind.gif';
        $blindGifTag = '<img src="' . $blindGifPath . '" role="presentation" alt="Download" class="tx-rkwbasics-imageprotection__img">';
        return '<div class="tx-rkwbasics-imageprotection">' . $blindGifTag . $match . '</div>';
    }


    /**
     * adds blind gif
     *
     * @param string $content content to replace
     * @return string new content
     */
    public function searchReplace($content)
    {

        // Replace content
        $object = $this;
        $config = $this->config;
        $callback = function ($matches) use ($object, $config) {
            return $object->addBlindGif($matches[1]);
        };

        return preg_replace_callback($this->config['search'], $callback, $content);
    }


} 
<?php

namespace RKW\RkwBasics\ContentProcessing;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class HtmlMinify
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class HtmlMinify
{

    /**
     * @var array
     */
    protected $settings;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->settings = $this->getSettings();
    }


    /**
     * Replaces extension paths in content
     *
     * @param string $content content to replace
     * @return string new content
     */
    public function process($content)
    {

        if (!$this->settings['enable']) {
            return $content;
        }

        $pages = GeneralUtility::trimExplode(',', $this->settings['excludePids']);
        if ($pages) {
            $pages = array_flip($pages);
            if (isset($pages[$GLOBALS['TSFE']->page['uid']])) {
                return $content;
            }
        }

        $pageTypes = GeneralUtility::trimExplode(',', $this->settings['includePageTypes']);
        $pageTypes = array_flip($pageTypes);
        if (! isset($pageTypes[$GLOBALS['TSFE']->type])) {
            return $content;
        }

        return $this->minify($content);
    }


    /**
     * Minify
     *
     * @param string $content
     * @return string $content
     */
    protected function minify($content)
    {
        $content = preg_replace('%(?>[^\S ]\s*| \s{2,})(?=(?:(?:[^<]++| <(?!/?(?:textarea|pre|script)\b))*+)(?:<(?>textarea|pre|script)\b| \z))%ix', ' ', $content);
        return $content;
    }


    /**
     * Loads settings
     *
     * @return array
     */
    public function getSettings()
    {

        $settings = [
            'enable' => 0,
            'excludePids' => '',
            'includePageTypes' => '0',
        ];

        /** @var  $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
        $configuration = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'Rkwbasics'
        );

        if (
            (isset($configuration['htmlMinify']))
            && (is_array($configuration['htmlMinify']))
        ){
            $settings = array_merge($settings, $configuration['htmlMinify']);
        }

        return $settings;
    }

} 
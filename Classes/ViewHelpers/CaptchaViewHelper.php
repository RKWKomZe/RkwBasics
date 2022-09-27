<?php

namespace RKW\RkwBasics\ViewHelpers;

use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

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
 * Class CaptchaViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwRegistration
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CaptchaViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Returns a standard text for the privacy checkbox
     * (not a partial because this is more complicated to use it universally in several extensions)
     *
     * @return string
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function render()
    {
        $settingsExtension = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        /** @var StandaloneView $template */
        $template = GeneralUtility::makeInstance(StandaloneView::class);
        $template->setLayoutRootPaths([$settingsExtension['view']['layoutRootPath']]);
        $template->setPartialRootPaths([$settingsExtension['view']['partialRootPath']]);
        $template->setTemplateRootPaths([$settingsExtension['view']['templateRootPath']]);
        $template->getRequest()->setControllerExtensionName(GeneralUtility::underscoredToUpperCamelCase('rkw_basics'));

        $template->setTemplate('SrFreecap/CaptchaElement');

        return $template->render();
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {
        return Common::getTyposcriptConfiguration('Rkwbasics', $which);
    }


}

<?php

namespace RKW\RkwBasics\ViewHelpers;

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

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Class MediaCopyrightViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MediaCopyrightViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('source', 'mixed', 'The stock agency where the media was bought (uid or string)', false, '');
        $this->registerArgument('originator', 'string', 'The originator of the media', false, '');
    }

    /**
     * Generates a normalized copyright information for media
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {

        $source = $arguments['source'];
        $originator = $arguments['originator'];

        if (is_numeric($source)) {
            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

            /** @var \RKW\RkwBasics\Domain\Repository\MediaSourcesRepository $mediaSourceRepository */
            $mediaSourceRepository = $objectManager->get(\RKW\RkwBasics\Domain\Repository\MediaSourcesRepository::class);

            /** @var \RKW\RkwBasics\Domain\Model\MediaSources $mediaSource */
            if ($mediaSource = $mediaSourceRepository->findByIdentifier($source)) {
                $source = $mediaSource->getName();
            }
        }

        if ($originator) {
            return '© ' . $source . ' / ' . $originator;
        }

        return '© ' . $source;
    }
}

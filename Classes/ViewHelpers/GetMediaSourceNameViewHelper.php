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

/**
 * Class GetMediaSourceNameViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GetMediaSourceNameViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @param int $mediaSourceId
     * @return string
     */
    public function render(int $mediaSourceId): string
    {

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

        /** @var \RKW\RkwBasics\Domain\Repository\MediaSourcesRepository $mediaSourceRepository */
        $mediaSourceRepository = $objectManager->get(\RKW\RkwBasics\Domain\Repository\MediaSourcesRepository::class);

        /** @var \RKW\RkwBasics\Domain\Model\MediaSources $mediaSource */
        if ($mediaSource = $mediaSourceRepository->findByIdentifier($mediaSourceId)) {

            return $mediaSource->getName();
        }

        return '';

    }


}
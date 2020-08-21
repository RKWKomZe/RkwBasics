<?php
namespace RKW\RkwBasics\View;

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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;


/**
 * A standalone template view.
 * Should be used as view if you want to use Fluid without Extbase extensions
 *
 * @api
 * @deprecated
 */
class StandaloneView extends \RKW\RkwAjax\View\AjaxStandaloneView
{

    /**
     * Constructor
     *
     * @param ContentObjectRenderer $contentObject The current cObject. If NULL a new instance will be created
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function __construct(ContentObjectRenderer $contentObject = null)
    {
        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon. Use RKW\RkwAjax\View\AjaxStandaloneView instead.');
        parent::__construct($contentObject);
    }

}

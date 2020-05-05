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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

/**
 * A standalone template view.
 * Should be used as view if you want to use Fluid without Extbase extensions
 *
 * @api
 */
class StandaloneView extends \TYPO3\CMS\Fluid\View\StandaloneView
{


    /**
     * Set the request object
     *
     * @return void
     */
    public function setRequest(\TYPO3\CMS\Extbase\Mvc\Web\Request $webRequest)
    {

        // set basics
        $webRequest->setRequestURI(GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'));
        $webRequest->setBaseURI(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'));

        /**
         * reset uriBuilder
         * @var UriBuilder $uriBuilder
         * @see __construct()
         **/
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($webRequest);

        /**
         * reset ControllerContext
         * @var ControllerContext $controllerContext
         * @see __construct()
         **/
        $this->controllerContext->setRequest($webRequest);
        $this->controllerContext->setUriBuilder($uriBuilder);

    }

}

<?php
namespace RKW\RkwBasics\View;

/**                                                                       *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Mvc\Web\Request as WebRequest;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;
use TYPO3\CMS\Fluid\Core\Compiler\TemplateCompiler;
use TYPO3\CMS\Fluid\Core\Parser\TemplateParser;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

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

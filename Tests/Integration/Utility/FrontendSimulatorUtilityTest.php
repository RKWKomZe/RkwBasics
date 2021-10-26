<?php
namespace RKW\RkwBasics\Tests\Integration\Utility;

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

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwBasics\Utility\FrontendSimulatorUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\FrontendConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * FrontendSimulatorUtilityTest
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FrontendSimulatorUtilityTest extends FunctionalTestCase
{

    const BASE_PATH = __DIR__ . '/FrontendSimulatorUtilityTest';


    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
    ];

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [ ];


    /**
     * Setup
     * @throws \Exception
     */
    protected function setUp()
    {

        parent::setUp();

        $this->importDataSet(self::BASE_PATH . '/Fixtures/Database/Global.xml');
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:rkw_basics/Configuration/TypoScript/setup.txt',
                'EXT:rkw_basics/Tests/Integration/Utility/FrontendSimulatorUtilityTest/Fixtures/Frontend/Configuration/Rootpage.typoscript',
            ]
        );
    }



    //=============================================

    /**
     * @test
     */
    public function simulateFrontendEnvironmentRemovesPageNotFoundHandler()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then the page-not-found-handler is deleted
         */

        $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = 'Test';
        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        self::assertEmpty($GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling']);
    }


    /**
     * @test
     */
    public function simulateFrontendEnvironmentSetsHostVariableToDomainOfRootpage()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then the host-environment-variable is set to the domain of the rootpage
         * Then the environment-caches are flushed
         */

        // set variable an fill caches
        $_SERVER['HTTP_HOST'] = 'example.com';
        GeneralUtility::getIndpEnv('HTTP_HOST');

        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        self::assertEquals('www.rkw-kompetenzzentrum.rkw.local', $_SERVER['HTTP_HOST']);
        self::assertEquals('www.rkw-kompetenzzentrum.rkw.local',  GeneralUtility::getIndpEnv('HTTP_HOST'));

    }


    /**
     * @test
     */
    public function simulateFrontendEnvironmentSetsGetAndPostId()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then the key 'id' of _GET and _POST is set to the id of the given sub-page
         */

        // set variables
        $_GET['id'] = $_POST['id'] = 99;

        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        self::assertEquals(3, $_GET['id']);
        self::assertEquals(3, $_POST['id']);

    }

    /**
     * @test
     */
    public function simulateFrontendEnvironmentSetsBaseUrlInConfiguration()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then a TyposcriptFrontendController-Object is generated
         * Then this TyposcriptFrontendController-Object contains a config-key 'absRefPrefix' which is set to '/'
         * Then this TyposcriptFrontendController-Object contains a config-key 'baseURL' which is set to the domain of the given sub-page
         * Then this TyposcriptFrontendController-Object contains a property 'absRefPrefix' which is set to '/'
         */
        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        self::assertInstanceOf(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class, $GLOBALS['TSFE']);

        self::assertEquals('/', $GLOBALS['TSFE']->config['config']['absRefPrefix']);
        self::assertEquals('www.rkw-kompetenzzentrum.rkw.local', $GLOBALS['TSFE']->config['config']['baseURL']);
        self::assertEquals('/', $GLOBALS['TSFE']->absRefPrefix);

    }


    /**
     * @test
     */
    public function simulateFrontendEnvironmentSetsAGlobalCharsetConvertingObject()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then a global TYPO3\CMS\Core\Charset\CharsetConverter-Object is generated in $GLOBALS['LANG']
         * Then is object is identical with the corresponding object in $GLOBALS['TSFE']
         */

        $GLOBALS['LANG']->csConvObj = null;

        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        self::assertInstanceOf(\TYPO3\CMS\Core\Charset\CharsetConverter::class, $GLOBALS['LANG']->csConvObj);

        self::assertEquals($GLOBALS['LANG']->csConvObj, $GLOBALS['TSFE']->csConvObj);

    }

    /**
     * @test
     */
    public function simulateFrontendEnvironmentGeneratesCompleteFrontendObject()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then a TyposcriptFrontendController-Object is generated
         * Then this TyposcriptFrontendController-Object has the property 'id' set to the given sub-page-id
         * Then this TyposcriptFrontendController-Object has the property 'rootline' set to an array
         * Then this array has three items
         * Then this three items are the root-page, the parent-page and the given sub-page in that order
         * Then this TyposcriptFrontendController-Object has the property 'page' set to an array
         * Then this array has the key 'id' with the id of the given sub-page
         * Then this array has the key 'title' with the title of the given sub-page
         * Then this TyposcriptFrontendController-Object has the property 'domainStartPage' set to root-page id (=1)
         * Then this TyposcriptFrontendController-Object has the property 'sys_language_uid' set to zero
         * Then this TyposcriptFrontendController-Object has the property 'pageNotFound' set to zero
         * Then this TyposcriptFrontendController-Object has the property 'sys_page' set to a TYPO3\CMS\Frontend\Page\PageRepository-object
         * Then this TyposcriptFrontendController-Object has the property 'fe_user' set to a TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication-object
         * Then this TyposcriptFrontendController-Object has the property 'tmpl' set to a TYPO3\CMS\Core\TypoScript\TemplateService-object
         */

        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        self::assertInstanceOf(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class, $GLOBALS['TSFE']);
        self::assertEquals(3, $GLOBALS['TSFE']->id);
        self::assertInternalType('array', $GLOBALS['TSFE']->rootLine);

        $rootline = $GLOBALS['TSFE']->rootLine;
        self::assertCount(3, $rootline);
        self::assertEquals(1, $rootline[0]['uid']);
        self::assertEquals(2, $rootline[1]['uid']);
        self::assertEquals(3, $rootline[2]['uid']);

        self::assertEquals(3, $GLOBALS['TSFE']->page['uid']);
        self::assertEquals('Test-Sub-Page', $GLOBALS['TSFE']->page['title']);

        self::assertEquals(1, $GLOBALS['TSFE']->domainStartPage);
        self::assertEquals(0,$GLOBALS['TSFE']->sys_language_uid);
        self::assertEquals(0, $GLOBALS['TSFE']->pageNotFound);

        self::assertInstanceOf(\TYPO3\CMS\Frontend\Page\PageRepository::class, $GLOBALS['TSFE']->sys_page);
        self::assertInstanceOf(\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class, $GLOBALS['TSFE']->fe_user);
        self::assertInstanceOf(\TYPO3\CMS\Core\TypoScript\TemplateService::class, $GLOBALS['TSFE']->tmpl);

    }


    /**
     * @test
     */
    public function simulateFrontendEnvironmentLoadsDataFromCache()
    {

        /**
         * Scenario:
         *
         * Given the method was called for sub-page A in the rootline
         * Given the method was then called for sub-page B in the rootline
         * Given now sub-page A again
         * When the method is called
         * Then the method returns the value 2
         * Then a TyposcriptFrontendController-Object is identical with the one generated the first time
         * Then the _TYPO3_CONF_VARS is identical with the one generated the first time
         * Then the _SERVER-superglobal is identical with the one generated the first time
         * Then the _POST-superglobal is identical with the one generated the first time
         * Then the _GET-superglobal is identical with the one generated the first time
         * Then the environment-cache is flushed and thus identical with the one generated the first time
         */

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);

        $beforeTSFE = $GLOBALS['TSFE'];
        $beforeConfVars = $GLOBALS['TYPO3_CONF_VARS'];
        $beforeGET = $_GET;
        $beforePOST = $_POST;
        $beforeSERVER = $_SERVER;
        $beforeEnvironmentCache = GeneralUtility::getIndpEnv('HTTP_HOST');

        FrontendSimulatorUtility::simulateFrontendEnvironment(11);

        self::assertEquals(2, FrontendSimulatorUtility::simulateFrontendEnvironment(3));

        self::assertEquals($beforeTSFE, $GLOBALS['TSFE']);
        self::assertEquals($beforeConfVars, $GLOBALS['TYPO3_CONF_VARS']);
        self::assertEquals($beforeGET, $_GET);
        self::assertEquals($beforePOST, $_POST);
        self::assertEquals($beforeSERVER, $_SERVER);
        self::assertEquals($beforeEnvironmentCache,  GeneralUtility::getIndpEnv('HTTP_HOST'));
        
    }

    /**
     * @test
     */
    public function simulateFrontendEnvironmentSetsFrontendConfigurationManager()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * When the method is called
         * Then the method returns the value 1
         * Then the Typoscript-configuration for frontend is available via configurationManager
         */

        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManager::class);

        $settings = $configurationManager->getConfiguration($configurationManager::CONFIGURATION_TYPE_SETTINGS, 'rkwBasics');
        self::assertEquals(1, $settings['frontendContext']);
    }

    /**
     * @test
     */
    public function simulateFrontendEnvironmentSetsContentObjectRenderer ()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * Given the configurationManager has no contentObjectRenderer-object
         * When the method is called
         * Then the method returns the value 1
         * Then the configurationManager has a contentObjectRenderer-object
         */

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManager::class);
        
        self::assertEmpty($configurationManager->getContentObject());
        self::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));

        self::assertNotEmpty($configurationManager->getContentObject());

    }


    //=============================================

    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresPageNotFoundHandler()
    {

        /**
         * Scenario:
         *
         * Given we were in FE-Mode
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the page-not-found-handler is restored
         */

        $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = 'Test';

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        self::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        self::assertEquals('Test', $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling']);
    }


    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresHostVariable()
    {

        /**
         * Scenario:
         *
         * Given we were in FE-Mode
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the host-environment-variable is restored
         * Then the environment-caches are flushed
         */

        // set variable an fill caches
        $_SERVER['HTTP_HOST'] = 'example.com';
        GeneralUtility::getIndpEnv('HTTP_HOST');

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        self::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        self::assertEquals('example.com', $_SERVER['HTTP_HOST']);
        self::assertEquals('example.com',  GeneralUtility::getIndpEnv('HTTP_HOST'));

    }



    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresGetAndPostId()
    {

        /**
         * Scenario:
         *
         * Given we were in FE-Mode
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the key 'id' of _GET and _POST is restored
         */

        // set variable an fill caches
        $_GET['id'] = $_POST['id'] = 99;

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        self::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        self::assertEquals(99, $_GET['id']);
        self::assertEquals(99, $_POST['id']);

    }


    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresFrontendObject()
    {

        /**
         * Scenario:
         *
         * Given we were in FE-Mode
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the $GLOBALS['TSFE']-object is restored
         */

        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $GLOBALS ['TSFE'] */
        $before = $GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class,
            $GLOBALS['TYPO3_CONF_VARS'],
            11,
            0
        );

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        self::assertNotSame($before, $GLOBALS['TSFE']);
        self::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        self::assertSame($before, $GLOBALS['TSFE']);

    }


    /**
     * @test
     */
    public function resetFrontendEnvironmentDoesNotSetEmptyValues()
    {

        /**
         * Scenario:
         *
         * Given we were in BE-mode 
         * Given the $GLOBALS['TSFE']-object was not set
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the $GLOBALS['TSFE']-object is not set
         */
        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        self::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        self::assertNull($GLOBALS['TSFE']);

    }

    /**
     * @test
     */
    public function resetFrontendEnvironmentSetsBackendConfigurationManager()
    {

        /**
         * Scenario:
         *
         * Given we were in BE-Mode
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the Typoscript-configuration for backend is available via configurationManager
         */

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        self::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        
        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManager::class);

        $settings = $configurationManager->getConfiguration($configurationManager::CONFIGURATION_TYPE_SETTINGS, 'rkwBasics');
        self::assertEquals(1, $settings['backendContext']);
    }
    

    //=============================================

    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();


    }


}
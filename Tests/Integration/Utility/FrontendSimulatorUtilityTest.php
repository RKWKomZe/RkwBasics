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
        static::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        static::assertEmpty($GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling']);
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

        static::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        static::assertEquals('www.rkw-kompetenzzentrum.rkw.local', $_SERVER['HTTP_HOST']);
        static::assertEquals('www.rkw-kompetenzzentrum.rkw.local',  GeneralUtility::getIndpEnv('HTTP_HOST'));

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

        static::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        static::assertEquals(3, $_GET['id']);
        static::assertEquals(3, $_POST['id']);

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
        static::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        static::assertInstanceOf(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class, $GLOBALS['TSFE']);

        static::assertEquals('/', $GLOBALS['TSFE']->config['config']['absRefPrefix']);
        static::assertEquals('www.rkw-kompetenzzentrum.rkw.local', $GLOBALS['TSFE']->config['config']['baseURL']);
        static::assertEquals('/', $GLOBALS['TSFE']->absRefPrefix);

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

        static::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        static::assertInstanceOf(\TYPO3\CMS\Core\Charset\CharsetConverter::class, $GLOBALS['LANG']->csConvObj);

        static::assertEquals($GLOBALS['LANG']->csConvObj, $GLOBALS['TSFE']->csConvObj);

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

        static::assertEquals(1, FrontendSimulatorUtility::simulateFrontendEnvironment(3));
        static::assertInstanceOf(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class, $GLOBALS['TSFE']);
        static::assertEquals(3, $GLOBALS['TSFE']->id);
        static::assertInternalType('array', $GLOBALS['TSFE']->rootLine);

        $rootline = $GLOBALS['TSFE']->rootLine;
        static::assertCount(3, $rootline);
        static::assertEquals(1, $rootline[0]['uid']);
        static::assertEquals(2, $rootline[1]['uid']);
        static::assertEquals(3, $rootline[2]['uid']);

        static::assertEquals(3, $GLOBALS['TSFE']->page['uid']);
        static::assertEquals('Test-Sub-Page', $GLOBALS['TSFE']->page['title']);

        static::assertEquals(1, $GLOBALS['TSFE']->domainStartPage);
        static::assertEquals(0,$GLOBALS['TSFE']->sys_language_uid);
        static::assertEquals(0, $GLOBALS['TSFE']->pageNotFound);

        static::assertInstanceOf(\TYPO3\CMS\Frontend\Page\PageRepository::class, $GLOBALS['TSFE']->sys_page);
        static::assertInstanceOf(\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class, $GLOBALS['TSFE']->fe_user);
        static::assertInstanceOf(\TYPO3\CMS\Core\TypoScript\TemplateService::class, $GLOBALS['TSFE']->tmpl);

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

        static::assertEquals(2, FrontendSimulatorUtility::simulateFrontendEnvironment(3));

        static::assertEquals($beforeTSFE, $GLOBALS['TSFE']);
        static::assertEquals($beforeConfVars, $GLOBALS['TYPO3_CONF_VARS']);
        static::assertEquals($beforeGET, $_GET);
        static::assertEquals($beforePOST, $_POST);
        static::assertEquals($beforeSERVER, $_SERVER);
        static::assertEquals($beforeEnvironmentCache,  GeneralUtility::getIndpEnv('HTTP_HOST'));


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
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the page-not-found-handler is restored
         */

        $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = 'Test';

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        static::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        static::assertEquals('Test', $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling']);
    }


    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresHostVariable()
    {

        /**
         * Scenario:
         *
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
        static::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        static::assertEquals('example.com', $_SERVER['HTTP_HOST']);
        static::assertEquals('example.com',  GeneralUtility::getIndpEnv('HTTP_HOST'));

    }



    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresGetAndPostId()
    {

        /**
         * Scenario:
         *
         * Given a sub-page in the rootline
         * Given simulateFrontendEnvironment was called before
         * When the method is called
         * Then the method returns true
         * Then the key 'id' of _GET and _POST is restored
         */

        // set variable an fill caches
        $_GET['id'] = $_POST['id'] = 99;

        FrontendSimulatorUtility::simulateFrontendEnvironment(3);
        static::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        static::assertEquals(99, $_GET['id']);
        static::assertEquals(99, $_POST['id']);

    }


    /**
     * @test
     */
    public function resetFrontendEnvironmentRestoresFrontendObject()
    {

        /**
         * Scenario:
         *
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
        static::assertNotSame($before, $GLOBALS['TSFE']);
        static::assertTrue(FrontendSimulatorUtility::resetFrontendEnvironment());
        static::assertSame($before, $GLOBALS['TSFE']);

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
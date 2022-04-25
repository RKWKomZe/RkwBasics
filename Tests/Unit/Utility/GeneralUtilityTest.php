<?php
namespace RKW\RkwBasics\Tests\Unit\Utility;

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

use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * GeneralUtilityTest
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GeneralUtilityTest extends UnitTestCase
{

    /**
     * @var \RKW\RkwBasics\Utility\GeneralUtility
     */
    private $subject;


    /**
     * Setup
     */
    protected function setUp()
    {
        parent::setUp();
        $this->subject = GeneralUtility::makeInstance(\RKW\RkwBasics\Utility\GeneralUtility::class);

    }

   
    //=============================================

    /**
     * @test
     */
    public function arrayZipMergeWithTwoArrays()
    {

        /**
         * Scenario:
         *
         * Given an array A with non-continuous numeric keys
         * Given that array A as four key-value-pairs
         * Given an array B with string-keys
         * Given that array B as two key-value-pairs
         * When the method is called
         * Then an array is returned
         * Then the array contains six items
         * Then the array has continuous numeric keys
         * Then the array contains the array-items of both arrays in zipper-method
         */

        $array1 = [
            100 => 'test1.0',
            200 => 'test1.1',
            300 => 'test1.2',
            400 => 'test1.3'
        ];

        $array2 = [
            'a' => 'test2.0',
            'b' => 'test2.1'
        ];
        
        $result = $this->subject::arrayZipMerge($array1, $array2);
        self::assertInternalType('array', $result);
        self::assertCount(6, $result);
        self::assertEquals('test1.0', $result[0]);
        self::assertEquals('test2.0', $result[1]);
        self::assertEquals('test1.1', $result[2]);
        self::assertEquals('test2.1', $result[3]);
        self::assertEquals('test1.2', $result[4]);
        self::assertEquals('test1.3', $result[5]);
    }

    /**
     * @test
     */
    public function arrayZipMergeWithThreeArrays()
    {

        /**
         * Scenario:
         *
         * Given an array A with non-continuous numeric keys
         * Given that array A as four key-value-pairs
         * Given an array B with string-keys
         * Given that array B as two key-value-pairs
         * Given an array C with mixed-keys
         * Given that array C as three key-value-pairs
         * When the method is called
         * Then an array is returned
         * Then the array contains nine items
         * Then the array has continuous numeric keys
         * Then the array contains the array-items of both arrays in zipper-method
         */

        $array1 = [
            100 => 'test1.0',
            200 => 'test1.1',
            300 => 'test1.2',
            400 => 'test1.3'
        ];

        $array2 = [
            'a' => 'test2.0',
            'b' => 'test2.1'
        ];

        $array3 = [
            'a' => 'test3.0',
            200  => 'test3.1',
            '445'  => 'test3.2'
        ];

        $result = $this->subject::arrayZipMerge($array1, $array2, $array3);
        self::assertInternalType('array', $result);
        self::assertCount(9, $result);
        self::assertEquals('test1.0', $result[0]);
        self::assertEquals('test2.0', $result[1]);
        self::assertEquals('test3.0', $result[2]);
        self::assertEquals('test1.1', $result[3]);
        self::assertEquals('test2.1', $result[4]);
        self::assertEquals('test3.1', $result[5]);
        self::assertEquals('test1.2', $result[6]);
        self::assertEquals('test3.2', $result[7]);
        self::assertEquals('test1.3', $result[8]);

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
<?php

use \PHPUnit\Framework\TestCase;

include_once __DIR__.'/InvokeMethodTrait.php';

class SanitizerTraitImplementation
{
    use \SpanishGuestReportGenerator\SanitizerTrait;
}

class SanitizerTraitTest extends TestCase
{
    use InvokeMethodTrait;

    private $traitObject;

    public function setUp()
    {
        $this->traitObject = new SanitizerTraitImplementation();
    }

    public function genderProvider()
    {
        return [
            ['f', 'F'],
            ['F', 'F'],
            ['m', 'M'],
            ['M', 'M'],
            ['',  'F'],
            ['Z', 'F'],
            ['0', 'F'],
            [3,   'F'],
        ];
    }

    /**
     * @covers          ::sanitizeGender
     * @dataProvider    genderProvider
     */
    public function testSanitizeGender($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeGender',
                [$actual]
            )
        );
    }

    public function docTypeProvider()
    {
        return [
            ['D', 'D'],
            ['P', 'P'],
            ['C', 'C'],
            ['I', 'I'],
            ['N', 'N'],
            ['X', 'X'],
            ['d', 'D'],
            ['p', 'P'],
            ['c', 'C'],
            ['i', 'I'],
            ['n', 'N'],
            ['x', 'X'],
            ['',  'D'],
            ['Z', 'D'],
            ['0', 'D'],
            [3,   'D'],
        ];
    }

    /**
     * @covers          ::sanitizeDocType
     * @dataProvider    docTypeProvider
     */
    public function testSanitizeDocType($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeDocType',
                [$actual]
            )
        );
    }

    public function dateProvider()
    {
        return [
            ['20160926',   '20160926'],
            ['2016-09-26', '20160926'],
            ['2016.09.26', '20160926'],
            ['2016/09/26', '20160926'],
            ['26-09-2016', '20160926'],
            ['26.09.2016', '20160926'],
            ['26/09/2016', '20160926'],
            ['whatevs',    '00000000'],
            [true,         '00000000'],
            [false,        '00000000'],
            [null,         '00000000'],
            ['',           '00000000'],
        ];
    }

    /**
     * @covers          ::sanitizeDate
     * @dataProvider    dateProvider
     */
    public function testSanitizeDate($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeDate',
                [$actual]
            )
        );
    }

    public function codeProvider()
    {
        return [
            ['1234567890',           '1234567890'],
            [1234567890,             '1234567890'],
            ['12345678901234567890', '1234567890'],
            [3210987654321,          '3210987654'],
            ['3210987654321',        '3210987654'],
            ['09876543210987654321', '0987654321'],
        ];
    }

    /**
     * @covers          ::sanitizeCode
     * @dataProvider    codeProvider
     */
    public function testSanitizeCode($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeCode',
                [$actual]
            )
        );
    }

    public function bizNameProvider()
    {
        return [
            ['1234567890',           '1234567890'],
            [1234567890,             '1234567890'],
            [3210987654321,          '3210987654321'],
            ['3210987654321',        '3210987654321'],
            ['09876543210987654321', '09876543210987654321'],
            ['12345678901234567890123456789012345678901234567890', '1234567890123456789012345678901234567890'],
        ];
    }

    /**
     * @covers          ::sanitizeBizName
     * @dataProvider    bizNameProvider
     */
    public function testSanitizeBizName($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeBizName',
                [$actual]
            )
        );
    }

    public function spanishIDNumberProvider()
    {
        return [
            ['1234567890',           '1234567890'],
            [1234567890,             '1234567890'],
            ['12345678901234567890', '12345678901'],
        ];
    }

    /**
     * @covers          ::sanitizeSpanishID
     * @dataProvider    spanishIDNumberProvider
     */
    public function testSanitizeSpanishID($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeSpanishID',
                [$actual]
            )
        );
    }

    public function foreignIDNumberProvider()
    {
        return [
            [1234567890123,          '1234567890123'],
            ['1234567890123',        '1234567890123'],
            ['12345678901234567890', '12345678901234'],
        ];
    }

    /**
     * @covers          ::sanitizeForeignID
     * @dataProvider    foreignIDNumberProvider
     */
    public function testSanitizeForeignID($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeForeignID',
                [$actual]
            )
        );
    }

    public function personNameProvider()
    {
        return [
            ['1234567890',           '1234567890'],
            [1234567890,             '1234567890'],
            [3210987654321,          '3210987654321'],
            ['3210987654321',        '3210987654321'],
            ['09876543210987654321', '09876543210987654321'],
            ['1234567890123456789012345678901234567890', '123456789012345678901234567890'],
        ];
    }

    /**
     * @covers          ::sanitizePersonName
     * @dataProvider    personNameProvider
     */
    public function testSanitizePersonName($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizePersonName',
                [$actual]
            )
        );
    }

    public function countryNameProvider()
    {
        return [
            ['1234567890',           '1234567890'],
            [1234567890,             '1234567890'],
            [3210987654321,          '3210987654321'],
            ['3210987654321',        '3210987654321'],
            ['09876543210987654321', '09876543210987654321'],
            ['09876543210987654321098765', '098765432109876543210'],
            ['1234567890123456789012345678901234567890', '123456789012345678901'],
        ];
    }

    /**
     * @covers          ::sanitizeCountryName
     * @dataProvider    countryNameProvider
     */
    public function testSanitizeCountryName($actual, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeCountryName',
                [$actual]
            )
        );
    }

    public function sanitizePresenceProvider()
    {
        return [
            ['a',          ['a','b','c','d','e'], 'a'],
            ['c',          ['a','b','c','d','e'], 'c'],
            ['e',          ['a','b','c','d','e'], 'e'],

            ['x',          ['a','b','c','d','e'], 'a'],

            [3,            ['1','2','3','4','5'], '3'],
            [3,            [1,2,3,4,5],           '3'],

            [new stdClass, ['a','b','c','d','e'], 'a'],
            [new stdClass, ['','b','c','d','e'],  ''],

            [[],           ['a','b','c','d','e'], 'a'],
            [[],           ['','b','c','d','e'],  ''],
        ];
    }

    /**
     * @covers          ::sanitizePresence
     * @dataProvider    sanitizePresenceProvider
     */
    public function testSanitizePresence($actual, $array, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizePresence',
                [$actual, $array]
            )
        );
    }

    public function sanitizeLengthProvider()
    {
        return [
            ['abcdefbhijklmnopqrstuvwxyz', 3,   'abc'],
            ['abcdefbhijklmnopqrstuvwxyz', 12,  'abcdefbhijkl'],
            ['abcdefbhijklmnopqrstuvwxyz', 32,  'abcdefbhijklmnopqrstuvwxyz'],
            ['abcdefbhijklmnopqrstuvwxyz', 0,   ''],
            ['abcdefbhijklmnopqrstuvwxyz', -33, ''],
        ];
    }

    /**
     * @covers          ::sanitizeLength
     * @dataProvider    sanitizeLengthProvider
     */
    public function testSanitizeLength($actual, $length, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->invokeMethod(
                $this->traitObject,
                'sanitizeLength',
                [$actual, $length]
            )
        );
    }
}

<?php

use \PHPUnit\Framework\TestCase;

include_once __DIR__.'/../../src/Util/helpers.php';

class HelpersTest extends TestCase
{
    public function isAssocArrayProvider()
    {
        return [
            [[],                                               false],
            [['abc','def','ghi'],                              false],
            [[0 => 'abc', 1 => 'def', 2 => 'ghi'],             false],
            [['abc' => 'def', 'ghi' => 'jkl', 'mno' => 'pqr'], true],
            [[1 => 'abc', 2 => 'def', 3 => 'ghi'],             true],
        ];
    }

    public function stringifyProvider()
    {
        return [
            ['', ''],
            ['whatevs', 'whatevs'],
            [0, '0'],
            [0.0, '0.0'],
            [null, ''],
            [false, ''],
            [[], ''],
            [[1,2,3], ''],
            [new stdClass, ''],
            [new SimpleXMLElement('<yo>dude!</yo>'), 'dude!'],
        ];
    }

    /**
     * @covers          ::is_assoc_array
     * @dataProvider    isAssocArrayProvider
     */
    public function testIsAssocArray($actual, $expected)
    {
        $this->assertEquals($expected, is_assoc_array($actual));
    }

    /**
     * @covers          ::stringify
     * @dataProvider    stringifyProvider
     */
    public function testStringify($actual, $expected)
    {
        $this->assertEquals($expected, stringify($actual));
    }
}

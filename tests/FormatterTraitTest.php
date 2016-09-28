<?php

namespace SpanishGuestReportGenerator;

include_once __DIR__.'/helpers/InvokeMethodTrait.php';

class FormatterTraitImplementation
{
    use FormatterTrait;
}

class FormatterTraitTest extends \PHPUnit_Framework_TestCase
{
    use \InvokeMethodTrait;

    private $traitObject;

    public function setUp()
    {
        $this->traitObject = new FormatterTraitImplementation();
    }

    public function dateTimeProvider()
    {
        return [
            [new \DateTime('2013-07-21 12:34'), ['date' => '20130721', 'time' => '1234']],
            [new \DateTime('2015-08-22 11:00'), ['date' => '20150822', 'time' => '1100']],
            [new \DateTime('2016-09-23 09:09'), ['date' => '20160923', 'time' => '0909']],
            [new \DateTime('2017-10-24 17:18'), ['date' => '20171024', 'time' => '1718']],
            [new \DateTime('2018-11-25 00:00'), ['date' => '20181125', 'time' => '0000']],
        ];
    }

    /**
     * @covers          ::formatDate
     * @dataProvider    dateTimeProvider
     */
    public function testFormatDate($actual, $expected)
    {
        $this->assertEquals($expected['date'], $this->invokeMethod($this->traitObject, 'formatDate', [$actual]));
    }

    /**
     * @covers          ::formatTime
     * @dataProvider    dateTimeProvider
     */
    public function testFormatTime($actual, $expected)
    {
        $this->assertEquals($expected['time'], $this->invokeMethod($this->traitObject, 'formatTime', [$actual]));
    }
}

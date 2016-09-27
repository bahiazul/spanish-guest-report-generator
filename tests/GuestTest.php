<?php

namespace SpanishGuestReportGenerator;

/**
 * @coversDefaultClass \SpanishGuestReportGenerator\Guest
 */
class GuestTest extends \PHPUnit_Framework_TestCase
{
    private $g;

    private $isSpanish    = true;
    private $idNumber     = '00126939278';
    private $docType      = 'd';
    private $docIssueDate = '2013-02-16';
    private $lastName1    = 'Eutychus';
    private $lastName2    = 'Tarik';
    private $firstName    = 'Orlov';
    private $gender       = 'm';
    private $birthDate    = '1972-11-05';
    private $countryName  = 'España';
    private $arrivalDate  = '2016-09-26';

    private $cols = [
        2,
        '00126939278',
        '',
        'D',
        '20130216',
        'Eutychus',
        'Tarik',
        'Orlov',
        'M',
        '19721105',
        'España',
        '20160926',
    ];

    public function setUp()
    {
        $this->g = new Guest();
    }

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            new Guest()
        );
    }

    public function isSpanishProvider()
    {
        return [
            [true,    true],
            ['true',  true],
            ['false', true],
            ['.',     true],
            [1,       true],
            [false,   false],
            [null,    false],
            ['',      false],
            [0,       false],
        ];
    }

    /**
     * @covers          ::setIsSpanish
     * @dataProvider    isSpanishProvider
     */
    public function testSetIsSpanish($actual, $expected)
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setIsSpanish($actual)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('isSpanish');
        $rp->setAccessible(true);


        $this->assertEquals($expected, $rp->getValue($this->g));
    }

    /**
     * @covers  ::setIDNumber
     */
    public function testSetIDNumber()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g
            ->setIsSpanish($this->isSpanish)
            ->setIDNumber($this->idNumber)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('idNumber');
        $rp->setAccessible(true);

        $this->assertEquals($this->idNumber, $rp->getValue($this->g));
    }

    /**
     * @covers  ::setDocType
     */
    public function testSetDocType()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setDocType($this->docType)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('docType');
        $rp->setAccessible(true);

        $this->assertNotNull($rp->getValue($this->g));
    }

    /**
     * @covers  ::setDocIssueDate
     */
    public function testSetDocIssueDate()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setDocIssueDate($this->docIssueDate)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('docIssueDate');
        $rp->setAccessible(true);

        $this->assertNotNull($rp->getValue($this->g));
    }

    /**
     * @covers ::setLastName1
     */
    public function testSetLastName1()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setLastName1($this->lastName1)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('lastName1');
        $rp->setAccessible(true);

        $this->assertEquals($this->lastName1, $rp->getValue($this->g));
    }

    /**
     * @covers ::setLastName2
     */
    public function testSetLastName2()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setLastName2($this->lastName2)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('lastName2');
        $rp->setAccessible(true);

        $this->assertEquals($this->lastName2, $rp->getValue($this->g));
    }

    /**
     * @covers ::setFirstName
     */
    public function testSetFirstName()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setFirstName($this->firstName)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('firstName');
        $rp->setAccessible(true);

        $this->assertEquals($this->firstName, $rp->getValue($this->g));
    }

    /**
     * @covers  ::setGender
     */
    public function testSetGender()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setGender($this->gender)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('gender');
        $rp->setAccessible(true);

        $this->assertNotNull($rp->getValue($this->g));
    }

    /**
     * @covers  ::testSetBirthDate
     */
    public function testSetBirthDate()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setBirthDate($this->birthDate)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('birthDate');
        $rp->setAccessible(true);

        $this->assertNotNull($rp->getValue($this->g));
    }

    /**
     * @covers  ::setCountryName
     */
    public function testSetCountryName()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setCountryName($this->countryName)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('countryName');
        $rp->setAccessible(true);

        $this->assertEquals($this->countryName, $rp->getValue($this->g));
    }

    /**
     * @covers  ::setArrivalDate
     */
    public function testSetArrivalDate()
    {
        $this->assertInstanceOf(
            '\SpanishGuestReportGenerator\Guest',
            $this->g->setArrivalDate($this->arrivalDate)
        );

        $rc = new \ReflectionClass($this->g);
        $rp = $rc->getProperty('arrivalDate');
        $rp->setAccessible(true);

        $this->assertNotNull($rp->getValue($this->g));
    }

    /**
     * @covers  ::getCols
     */
    public function testGetCols()
    {
        $this->g
        ->setIsSpanish($this->isSpanish)
        ->setIDNumber($this->idNumber)
        ->setDocType($this->docType)
        ->setDocIssueDate($this->docIssueDate)
        ->setLastName1($this->lastName1)
        ->setLastName2($this->lastName2)
        ->setFirstName($this->firstName)
        ->setGender($this->gender)
        ->setBirthDate($this->birthDate)
        ->setCountryName($this->countryName)
        ->setArrivalDate($this->arrivalDate);

        $this->assertEquals($this->cols, $this->g->getCols());
    }
}

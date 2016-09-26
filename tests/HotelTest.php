<?php

namespace SpanishGuestReportGenerator;

use \PHPUnit\Framework\TestCase;

class HotelTest extends TestCase
{
    private $h;

    private $gf;

    private $hotelCode = '12345ABCDE';
    private $hotelName = 'Green Phone Hotel';
    private $dt;
    private $guests = [
        [
            'isSpanish'    => true,
            'idNumber'     => '00126939278',
            'docType'      => 'd',
            'docIssueDate' => '2013-02-16',
            'lastName1'    => 'Eutychus',
            'lastName2'    => 'Tarik',
            'firstName'    => 'Orlov',
            'gender'       => 'f',
            'birthDate'    => '1972-11-05',
            'countryName'  => 'España',
            'arrivalDate'  => '2016-09-26',
        ],
        [
            'isSpanish'    => false,
            'idNumber'     => '82021854627922',
            'docType'      => 'p',
            'docIssueDate' => '2011-11-24',
            'lastName1'    => 'Munroe',
            'lastName2'    => '',
            'firstName'    => 'Amor Asim',
            'gender'       => 'f',
            'birthDate'    => '1972-04-28',
            'countryName'  => 'Holanda',
            'arrivalDate'  => '2016-09-26',
        ],
        [
            'isSpanish'    => false,
            'idNumber'     => '09982824072174',
            'docType'      => 'p',
            'docIssueDate' => '2009-09-22',
            'lastName1'    => 'Nuremberg',
            'lastName2'    => '',
            'firstName'    => 'Aindriú',
            'gender'       => 'm',
            'birthDate'    => '1975-09-05',
            'countryName'  => 'Reino Unido',
            'arrivalDate'  => '2016-09-26',
        ],
    ];

    private $rows = [
        [
            1,
            '12345ABCDE',
            'Green Phone Hotel',
            '20160926',
            '0000',
            3,
        ],
        [
            2,
            '00126939278',
            '',
            'D',
            '20130216',
            'Eutychus',
            'Tarik',
            'Orlov',
            'F',
            '19721105',
            'España',
            '20160926',
        ],
        [
            2,
            '',
            '82021854627922',
            'P',
            '20111124',
            'Munroe',
            '',
            'Amor Asim',
            'F',
            '19720428',
            'Holanda',
            '20160926',
        ],
        [
            2,
            '',
            '09982824072174',
            'P',
            '20090922',
            'Nuremberg',
            '',
            'Aindriú',
            'M',
            '19750905',
            'Reino Unido',
            '20160926',
        ],
    ];

    public function setUp()
    {
        $this->dt = new \DateTime('2016-09-26 00:00:00');

        $this->gf = new GuestFactory;
        $this->builtGuests = $this->gf->buildMultiple($this->guests);

        $this->h = new Hotel($this->hotelCode, $this->hotelName, $this->dt, $this->builtGuests);

        // var_dump($this->rows, $this->h->getRows());
        // die();
    }

    /**
     * @covers ::setHotelCode
     */
    public function testSetHotelCode()
    {
        $this->assertInstanceOf(
            Hotel::class,
            $this->h->setHotelCode($this->hotelCode)
        );

        $rc = new \ReflectionClass($this->h);
        $rp = $rc->getProperty('hotelCode');
        $rp->setAccessible(true);

        $this->assertEquals($this->hotelCode, $rp->getValue($this->h));
    }

    /**
     * @covers ::setHotelName
     */
    public function testSetHotelName()
    {
        $this->assertInstanceOf(
            Hotel::class,
            $this->h->setHotelName($this->hotelName)
        );

        $rc = new \ReflectionClass($this->h);
        $rp = $rc->getProperty('hotelName');
        $rp->setAccessible(true);

        $this->assertEquals($this->hotelName, $rp->getValue($this->h));
    }

    /**
     * @covers ::setReportDateTime
     */
    public function testSetReportDateTime()
    {
        $this->assertInstanceOf(
            Hotel::class,
            $this->h->setReportDateTime($this->dt)
        );

        $rc = new \ReflectionClass($this->h);
        $rp = $rc->getProperty('reportDateTime');
        $rp->setAccessible(true);

        $this->assertEquals($this->dt, $rp->getValue($this->h));
    }

    /**
     * @covers ::setGuests
     */
    public function testSetGuests()
    {
        $this->assertInstanceOf(
            Hotel::class,
            $this->h->setGuests($this->builtGuests)
        );

        $rc = new \ReflectionClass($this->h);
        $rp = $rc->getProperty('guests');
        $rp->setAccessible(true);

        $this->assertNotEmpty($rp->getValue($this->h));
        $this->assertEquals(count($this->guests), count($rp->getValue($this->h)));
    }

    /**
     * @covers  ::getRows
     */
    public function testGetRows()
    {
        $this->assertEquals($this->rows, $this->h->getRows());
    }
}

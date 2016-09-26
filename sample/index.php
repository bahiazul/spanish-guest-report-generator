<?php

date_default_timezone_set('Europe/Madrid'); // Avoid possible PHP warnings

require_once __DIR__.'/../vendor/autoload.php';

use SpanishGuestReportGenerator\GuestReport;
use SpanishGuestReportGenerator\HotelFactory;
use SpanishGuestReportGenerator\GuestFactory;


$reportDateTime = new \DateTime('2016-09-26 00:00:00');
$reportNumber   = 321;
$guests = [
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

$hotels = [
    [
        'hotelCode'      => '12345ABCDE',
        'hotelName'      => 'Green Phone Hotel',
        'reportDateTime' => $reportDateTime,
        'guests'         => $guests,
    ],
    [
        'hotelCode'      => 'ABCDE12345',
        'hotelName'      => 'Transparent Scarf Hotel',
        'reportDateTime' => $reportDateTime,
        'guests'         => $guests,
    ]
];

$gr = new GuestReport(new HotelFactory, new GuestFactory);

$gr->setReportNumber($reportNumber)
->setChain('ZYXWV98765', 'Simple Tiger Hotels', $reportDateTime, $hotels)
->save();

<?php

date_default_timezone_set('Europe/Madrid'); // Avoid possible PHP warnings

require_once __DIR__.'/../vendor/autoload.php';

use SpanishGuestReportGenerator\GuestReport;
use SpanishGuestReportGenerator\HotelFactory;
use SpanishGuestReportGenerator\GuestFactory;


// Dummy content
$chainCode = 'ZYXWV98765';          // Only required for multiple hotels
$chainName = 'Simple Tiger Hotels'; // Only required for multiple hotels

$reportDateTime = new \DateTime('2016-09-26 00:00:00');
$reportNumber   = 321; // Determines the extension of the exported file

$guests = [
    [
        'isSpanish'    => true,
        'idNumber'     => '00126939278', // 11 chars. max. for Spanish DNI
        'docType'      => 'd',           // Spanish DNI#/NIF
        'docIssueDate' => '2013-02-16',  // Y-m-d, d-m-Y, Ymd, d.m.Y, d/m/Y
        'lastName1'    => 'Eutychus',
        'lastName2'    => 'Tarik',       // Required for Spanish citizens
        'firstName'    => 'Orlov',
        'gender'       => 'm',           // 'M' male, 'F' female
        'birthDate'    => '1972-00-00',  // Valid if only the year is known
        'countryName'  => 'España',      // In Spanish, preferably
        'arrivalDate'  => '2016-09-26',
    ],
    [
        'isSpanish'    => false,
        'idNumber'     => '82021854627922', // 14 chars. max. for Passports
        'docType'      => 'p',              // Passport
        'docIssueDate' => '2011-11-24',
        'lastName1'    => 'Munroe',
        'lastName2'    => '',
        'firstName'    => 'Amor Asim',
        'gender'       => 'f',
        'birthDate'    => '1972-04-28',
        'countryName'  => 'Holanda',
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


// Single Hotel

extract($hotels[0]); // for the sake of simplicty

$guestReport = new GuestReport(new HotelFactory, new GuestFactory);

$guestReport
->setReportNumber($reportNumber) // Optional
->setHotel($hotelCode, $hotelName, $reportDateTime, $guests)
->setDirectoryPath(__DIR__.'/out') // will try to create the directory if doesn't exist
->save();                          // will overwrite any file with the same filename


// Multiple Hotels (Hotel Chain)

$guestReport = new GuestReport(new HotelFactory, new GuestFactory);

$guestReport
->setReportNumber($reportNumber) // Optional
->setChain($chainCode, $chainName, $reportDateTime, $hotels)
->setDirectoryPath(__DIR__.'/out', false) // will raise an exception if the dir. doesn't exist
->save(false);                            // will raise an exception if the file already exists

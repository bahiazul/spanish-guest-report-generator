<?php
/**
 * Spanish Guest Report Generator
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/nkm/spanish-guest-report-generator
 */

namespace SpanishGuestReportGenerator;

use SpanishGuestReportGenerator\Util\Helper;

/**
 * Guest Report
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/nkm/spanish-guest-report-generator
 */
class GuestReport
{
    use FormatterTrait;
    use SanitizerTrait;

    /**
     * Newline character to use
     *
     * @var string
     */
    const FILE_NEWLINE  = "\r\n";

    /**
     * Character encoding to use
     *
     * @var string
     */
    const FILE_ENCODING = 'CP437';

    /**
     * Path to the directory in which to save the generated file
     *
     * @var string
     */
    private $directoryPath;

    /**
     * Delimiter for all the fields in the document
     *
     * @var string
     */
    const FIELD_DELIMITER = '|';

    /**
     * First digit for the Chain info line
     *
     * @var integer
     */
    const ROW_TYPE = 0;

    /**
     * Sequential number of the document to generate (1-999)
     *
     * @var integer
     */
    private $reportNumber = '999';

    /**
     * Unique code (given by the authorities) for the Hotel Chain
     *
     * @var string
     */
    private $chainCode = '';

    /**
     * Name of the Hotel Chain (max. 40 characters)
     *
     * @var string
     */
    private $chainName = '';

    /**
     * Date and time of the report
     *
     * @var \DateTime
     */
    private $reportDateTime;

    /**
     * Holds all the Hotels
     *
     * @var array
     */
    private $hotels = [];

    /**
     * Hotel creator class
     *
     * @var HotelFactory
     */
    private $hotelFactory;

    /**
     * Guest creator class
     *
     * @var GuestFactory
     */
    private $guestFactory;

    /**
     * Creates a new report
     *
     * @param   HotelFactory $hotelFactory    Hotel creator class
     * @param   GuestFactory $guestFactory    Guest creator class
     * @param   \DateTime    $reportDateTime  Date and time of the report
     */
    public function __construct(
        HotelFactory $hotelFactory,
        GuestFactory $guestFactory,
        \DateTime $reportDateTime = null
    ) {
        $this->hotelFactory = $hotelFactory;
        $this->guestFactory = $guestFactory;

        $this->setReportDateTime($reportDateTime ?: new \DateTime);
    }

    /**
     * Sets the Chain's code
     *
     * @param   string $chainCode
     * @return  GuestReport
     */
    public function setChainCode($chainCode)
    {
        $this->chainCode = $this->sanitizeCode($chainCode);

        return $this;
    }

    /**
     * Sets the Chain's name
     *
     * @param   string $chainName Chain name
     * @return  GuestReport
     */
    public function setChainName($chainName)
    {
        $this->chainName = $this->sanitizeBizName($chainName);

        return $this;
    }

    /**
     * Sets the report number
     *
     * @param   integer $reportNumber Report number
     * @return  GuestReport
     */
    public function setReportNumber($reportNumber)
    {
        $reportNumber = intval($reportNumber);

        if ($reportNumber < 1 || $reportNumber > 999) {
            $reportNumber = 1;
        }

        $this->reportNumber = str_pad(strval($reportNumber), 3, '0', STR_PAD_LEFT);

        return $this;
    }

    /**
     * Sets the Date and time of the report
     *
     * @param   \DateTime $reportDateTime Date and time of the report
     * @return  GuestReport
     */
    public function setReportDateTime(\DateTime $reportDateTime)
    {
        $this->reportDateTime = $reportDateTime;

        return $this;
    }

    /**
     * Sets the info and contents for the Chain
     *
     * @param   string    $chainCode      Code of the Chain
     * @param   string    $chainName      Name of the Chain
     * @param   \DateTime $reportDateTime Date and Time of report
     * @param   array     $hotels         Hotels that belong to this Chain
     * @return  GuestReport
     */
    public function setChain($chainCode, $chainName, \DateTime $reportDateTime, array $hotels = [])
    {
        $this->setChainCode($chainCode);
        $this->setChainName($chainName);
        $this->setReportDateTime($reportDateTime);
        $this->setHotels($hotels);

        return $this;
    }

    /**
     * Set multiple Hotels at once
     *
     * @param   array  $hotels    Hotels
     * @return  GuestReport
     */
    public function setHotels(array $hotels)
    {
        foreach ($hotels as $h) {
            $hotelCode      = '';
            $hotelName      = '';
            $reportDateTime = new \DateTime;
            $guests         = [];

            extract($h);

            $this->setHotel($hotelCode, $hotelName, $reportDateTime, $guests);
        }

        return $this;
    }

    /**
     * Sets the info and contents for a single Hotel
     *
     * @param   string    $hotelCode      Code of the Hotel
     * @param   string    $hotelName      Name of the Hotel
     * @param   \DateTime $reportDateTime Date and Time of report
     * @param   array     $guests         Guests that belong to this Hotel
     * @return  GuestReport
     */
    public function setHotel(
        $hotelCode,
        $hotelName,
        \DateTime $reportDateTime = null,
        array $guests = []
    ) {
        $hotelCode = $this->sanitizeCode($hotelCode);
        $guests = $this->guestFactory->buildMultiple($guests);

        $reportDateTime ?: new \DateTime;

        $args = compact('hotelCode', 'hotelName', 'reportDateTime', 'guests');
        $this->hotels[$hotelCode] = $this->hotelFactory->build($args);

        return $this;
    }

    /**
     * Set the Guests for a specific Hotel
     *
     * @param   string $hotelCode Code of the Hotel
     * @param   array  $guests    Guests that belong to this Hotel
     * @return  GuestReport
     * @throws  GuestReportException
     */
    public function setHotelGuests($hotelCode, array $guests)
    {
        if (!$hotel = &$this->hotels[$hotelCode]) {
            throw new GuestReportException("Hotel by code `{$hotelCode}` not found.");
        }

        $guests = $this->guestFactory->buildMultiple($guests);

        $hotel->setGuests($guests);

        return $this;
    }

    /**
     * Sets the path in which the generated file will be saved
     *
     * @param   string  $path   Destination path
     * @param   boolean $create Create the path if it does not exist
     * @return  GuestReport
     * @throws  GuestReportException
     */
    public function setDirectoryPath($path, $create = true)
    {
        $path = rtrim(Helper::stringify($path), '\/');

        if (!is_dir($path)) {
            if (!$create) {
                throw new GuestReportException("Path `{$path}` does not exist.");
            }

            if (!mkdir($path, 0775, true)) {
                throw new GuestReportException("Could not create directory `{$path}`.");
            }
        }

        if (!is_writable($path)) {
            if (!chmod($path, 0775)) {
                throw new GuestReportException("Could not make directory `{$path}` writable.");
            }
        }

        $this->directoryPath = $path;

        return $this;
    }

    /**
     * Save the report to a file
     *
     * @param   boolean $overwrite  Overwrite the file if already exists
     * @return  boolean             Whether the file was succesfully saved
     * @throws  GuestReportException
     */
    public function save($overwrite = true)
    {
        $filename  = realpath($this->directoryPath); // Fallback to the current directory
        $filename .= '/'.$this->getFilename();

        if (file_exists($filename) && !$overwrite) {
            throw new GuestReportException("File `{$filename}` already exists.");
        }

        $data = $this->getContents();

        return (bool) file_put_contents($filename, $data);
    }

    /**
     * Returns the output filename
     *
     * @return string Output filename
     */
    private function getFilename()
    {
        switch (count($this->hotels)) {
            case 0:
                $filename = 'EMPTY';
                break;

            // The hotel code
            case 1:
                $hotels = $this->hotels;
                reset($hotels);
                $filename = key($hotels);
                break;

            default:
                $filename = $this->chainCode ?: 'NONAME';
                break;
        }

        return $filename.'.'.$this->reportNumber;
    }

    /**
     * Returns the report's contents
     *
     * @return  string The report's contents
     */
    private function getContents()
    {
        $lines = array_map(function($cols){ return self::rowToLine($cols); }, $this->getRows());

        $contents = implode(self::FILE_NEWLINE, $lines);
        $contents = iconv(mb_internal_encoding(), self::FILE_ENCODING.'//TRANSLIT', $contents);

        return $contents;
    }

    /**
     * Returns the report's data
     *
     * @return array
     */
    private function getRows()
    {
        $rows = [];
        foreach ($this->hotels as $hotel) {
            $rows = array_merge($rows, $hotel->getRows());
        }

        if (count($this->hotels) > 1) {
            array_unshift($rows, $this->getHeadRow());
        }

        return $rows;
    }

    /**
     * Returns the data for the Chain info row
     *
     * @return array
     */
    private function getHeadRow()
    {
        $cols = [];
        $cols[] = self::ROW_TYPE;
        $cols[] = $this->chainCode;
        $cols[] = $this->chainName;
        $cols[] = $this->formatDate($this->reportDateTime);
        $cols[] = $this->formatTime($this->reportDateTime);
        $cols[] = count($this->hotels);

        return $cols;
    }

    /**
     * Generates a line of text from a given array of values
     *
     * @param  array  $cols      The data
     * @return string
     */
    private static function rowToLine(array $cols)
    {
        $row = mb_strtoupper(implode(self::FIELD_DELIMITER, $cols));

        return $row . self::FIELD_DELIMITER;
    }
}

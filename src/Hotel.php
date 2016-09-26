<?php
/**
 * Spanish Guest Report Generator
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/spanish-guest-report-generator
 */

namespace SpanishGuestReportGenerator;

/**
 * Hotel
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/spanish-guest-report-generator
 */
class Hotel
{
    use FormatterTrait;
    use SanitizerTrait;

    /**
     * First digit for this type of line
     *
     * @var integer
     */
    const ROW_TYPE = 1;

    /**
     * Unique code (given by the authorities) for the Hotel
     *
     * @var string
     */
    private $hotelCode = '';

    /**
     * Name of the Hotel
     *
     * @var string
     */
    private $hotelName = '';

    /**
     * Date and time of the report
     *
     * @var \DateTime
     */
    private $reportDateTime;

    /**
     * Holds all the Guests
     *
     * @var array
     */
    private $guests = [];

    /**
     * Create a new Hotel
     *
     * @param string         $hotelCode      Code of the Hotel
     * @param string         $hotelName      Name of the Hotel
     * @param \DateTime|null $reportDateTime Date and time of the report
     * @param array          $guests         Guests that belong to this Hotel
     */
    public function __construct(
        $hotelCode      = '',
        $hotelName      = '',
        $reportDateTime = null,
        $guests         = []
    ) {
        $this->setHotelCode($hotelCode);
        $this->setHotelName($hotelName);
        $this->setReportDateTime($reportDateTime ?: new \DateTime);
        $this->setGuests($guests);
    }

    /**
     * Sets the Hotel's code
     *
     * @param   string $hotelCode
     * @return  Hotel
     */
    public function setHotelCode($hotelCode)
    {
        $this->hotelCode = $this->sanitizeCode($hotelCode);

        return $this;
    }

    /**
     * Sets the Hotel's name
     *
     * @param   string $hotelName
     * @return  Hotel
     */
    public function setHotelName($hotelName)
    {
        $this->hotelName = $this->sanitizeBizName($hotelName);

        return $this;
    }

    /**
     * Sets the report date and time
     *
     * @param   \DateTime $reportDateTime
     * @return  Hotel
     */
    public function setReportDateTime(\DateTime $reportDateTime)
    {
        $this->reportDateTime = $reportDateTime;

        return $this;
    }

    /**
     * Set multiple Guests at once
     *
     * @param   array $guests
     * @return  Hotel
     */
    public function setGuests(array $guests)
    {
        $this->guests = [];
        foreach ($guests as $guest) {
            $this->addGuest($guest);
        }

        return $this;
    }

    /**
     * Return all the Guests and the Hotel info
     *
     * @return array
     */
    public function getRows()
    {
        $rows = [];

        foreach ($this->guests as $guest) {
            array_push($rows, $guest->getCols());
        }

        if (count($this->guests)) {
            array_unshift($rows, $this->getHeadRow());
        }

        return $rows;
    }

    /**
     * Add a single Guest
     *
     * @param Guest $guest Guest object
     */
    private function addGuest(Guest $guest)
    {
        array_push($this->guests, $guest);
    }

    /**
     * Returns the data for the Hotel info row
     *
     * @return array
     */
    private function getHeadRow()
    {
        $cols = [];
        $cols[] = self::ROW_TYPE;
        $cols[] = $this->hotelCode;
        $cols[] = $this->hotelName;
        $cols[] = $this->formatDate($this->reportDateTime);
        $cols[] = $this->formatTime($this->reportDateTime);
        $cols[] = count($this->guests);

        return $cols;
    }
}

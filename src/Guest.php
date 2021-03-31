<?php
/**
 * Spanish Guest Report Generator
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/spanish-guest-report-generator
 */

namespace SpanishGuestReportGenerator;

/**
 * Guest
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/spanish-guest-report-generator
 */
class Guest
{
    use FormatterTrait;
    use SanitizerTrait;

    /**
     * First digit for the Guest info line
     *
     * @var integer
     */
    const ROW_TYPE = 2;

    /**
     * Is Spanish citizen?
     *
     * @var boolean
     */
    private $isSpanish;

    /**
     * Identification number
     *
     * @var string
     */
    private $idNumber = '';

    /**
     * Type of ID
     *
     * @var string
     */
    private $docType = '';

    /**
     * Issue date of the ID
     *
     * @var string
     */
    private $docIssueDate = '';

    /**
     * Last name
     *
     * @var string
     */
    private $lastName1 = '';

    /**
     * Second last name (only required for Spanish citizens)
     *
     * @var string
     */
    private $lastName2 = '';

    /**
     * First name
     *
     * @var string
     */
    private $firstName = '';

    /**
     * Gender
     *
     * @var string
     */
    private $gender = '';

    /**
     * Birth date
     *
     * @var string
     */
    private $birthDate = '';

    /**
     * Country of nationality
     *
     * @var string
     */
    private $countryName = '';

    /**
     * Arrival date
     *
     * @var string
     */
    private $arrivalDate = '';

    /**
     * Create a new Guest
     *
     * @param boolean $isSpanish    Indicates if the guest is a spanish resident
     * @param string  $idNumber     ID number that appears in the document
     * @param string  $docType      Letter identifying the type
     * @param string  $docIssueDate Expiration date of the document
     * @param string  $lastName1    First last name
     * @param string  $lastName2    Second last name (only required for spaniards)
     * @param string  $firstName    First name
     * @param string  $gender       Letter identifying the gender
     * @param string  $birthDate    Date of birth
     * @param string  $countryName  Name of the country
     * @param string  $arrivalDate  Date of arrival
     */
    public function __construct(
        $isSpanish    = false,
        $idNumber     = '',
        $docType      = '',
        $docIssueDate = '',
        $lastName1    = '',
        $lastName2    = '',
        $firstName    = '',
        $gender       = '',
        $birthDate    = '',
        $countryName  = '',
        $arrivalDate  = ''
    ) {
        $this->setIsSpanish($isSpanish);
        $this->setIDNumber($idNumber);
        $this->setDocType($docType);
        $this->setDocIssueDate($docIssueDate);
        $this->setLastName1($lastName1);
        $this->setLastName2($lastName2);
        $this->setFirstName($firstName);
        $this->setGender($gender);
        $this->setBirthDate($birthDate);
        $this->setCountryName($countryName);
        $this->setArrivalDate($arrivalDate);
    }

    /**
     * Sets wether or not the guest is a Spanish citizen
     *
     * @param   boolean $isSpanish
     * @return  Guest
     */
    public function setIsSpanish($isSpanish)
    {
        $this->isSpanish = (bool) $isSpanish;

        return $this;
    }

    /**
     * Sets the ID number
     *
     * @param   string  $idNumber  ID Number
     * @return  Guest
     */
    public function setIDNumber($idNumber)
    {
        $this->idNumber = $this->isSpanish
                        ? $this->sanitizeSpanishID($idNumber)
                        : $this->sanitizeForeignID($idNumber);

        return $this;
    }

    /**
     * Sets the document type
     *
     * @param   string $docType Letter identifying the type
     * @return  Guest
     */
    public function setDocType($docType)
    {
        $this->docType = $this->sanitizeDocType($docType);

        return $this;
    }

    /**
     * Sets the document issue date
     *
     * @param   string $date The date
     * @return  Guest
     */
    public function setDocIssueDate($date)
    {
        $this->docIssueDate = $this->sanitizeDate($date);

        return $this;
    }

    /**
     * Sets the first last name
     *
     * @param   string $lastName1 First last name
     * @return  Guest
     */
    public function setLastName1($lastName1)
    {
        $this->lastName1 = $this->sanitizePersonName($lastName1);

        return $this;
    }

    /**
     * Sets the second last name (only required for spanish citizens)
     *
     * @param   string $lastName2 Second last name
     * @return  Guest
     */
    public function setLastName2($lastName2)
    {
        $this->lastName2 = $this->sanitizePersonName($lastName2);

        return $this;
    }

    /**
     * Sets the first name
     *
     * @param   string $firstName First name
     * @return  Guest
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $this->sanitizePersonName($firstName);

        return $this;
    }

    /**
     * Sets the gender
     *
     * @param   string $gender Letter identifying the gender
     * @return  Guest
     */
    public function setGender($gender)
    {
        $this->gender = $this->sanitizeGender($gender);

        return $this;
    }

    /**
     * Sets the birth date
     *
     * @param   string $date Birth date
     * @return  Guest
     */
    public function setBirthDate($date)
    {
        $this->birthDate = $this->sanitizeDate($date);

        return $this;
    }

    /**
     * Sets the country name
     *
     * @param   string $countryName Country name
     * @return  Guest
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $this->sanitizeCountryName($countryName);

        return $this;
    }

    /**
     * Sets the arrival date
     *
     * @param   string $date Arrival date
     * @return  Guest
     */
    public function setArrivalDate($date)
    {
        $this->arrivalDate = $this->sanitizeDate($date);

        return $this;
    }

    /**
     * Returns the data for this object
     *
     * @return array
     */
    public function getCols()
    {
        $cols = [];
        $cols[] = self::ROW_TYPE;
        $cols[] = $this->isSpanish ? $this->idNumber : '';
        $cols[] = $this->isSpanish ? '' : $this->idNumber;
        $cols[] = $this->docType;
        $cols[] = $this->docIssueDate;
        $cols[] = $this->lastName1;
        $cols[] = $this->lastName2;
        $cols[] = $this->firstName;
        $cols[] = $this->gender;
        $cols[] = $this->birthDate;
        $cols[] = $this->countryName;
        $cols[] = $this->arrivalDate;

        return $cols;
    }
}

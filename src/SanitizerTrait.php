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
 * Sanitizers
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/nkm/spanish-guest-report-generator
 */
trait SanitizerTrait
{
    /**
     * Maximum length for string properties
     *
     * @var array
     */
    private static $lengths = [
        'code'        => 10,
        'bizName'     => 40,
        'spanishID'   => 11,
        'foreignID'   => 14,
        'personName'  => 30,
        'countryName' => 21,
    ];

    /**
     * Accepted Gender Codes
     *
     * @var array
     */
    private static $genders = [
        'F', // Female
        'M', // Male
    ];

    /**
     * Accepted Document Type Codes
     *
     * @var array
     */
    private static $docTypes = [
        'D', // Spanish ID (DNI)
        'P', // Passport
        'C', // Driving License
        'I', // Foreign ID
        'N', // Spanish Residence Permit
        'X', // Foreign (EU) Residence Permit
    ];

    /**
     * Accepted date patterns indexed by its human-readable format
     *
     * @var array
     */
    private static $dateFormats = [
        'DD-MM-YYYY' => '/^(?<d>\d{2})-(?<m>\d{2})-(?<y>\d{4})$/',
        'DD.MM.YYYY' => '/^(?<d>\d{2})\.(?<m>\d{2})\.(?<y>\d{4})$/',
        'DD/MM/YYYY' => '/^(?<d>\d{2})\/(?<m>\d{2})\/(?<y>\d{4})$/',
        'YYYY-MM-DD' => '/^(?<y>\d{4})-(?<m>\d{2})-(?<d>\d{2})$/',
        'YYYY.MM.DD' => '/^(?<y>\d{4})\.(?<m>\d{2})\.(?<d>\d{2})$/',
        'YYYY/MM/DD' => '/^(?<y>\d{4})\/(?<m>\d{2})\/(?<d>\d{2})$/',
        'YYYYMMDD'   => '/^(?<y>\d{4})(?<m>\d{2})(?<d>\d{2})$/',
    ];

    /**
     * Sanitizes a given gender
     *
     * @param   string $gender  Gender
     * @return  string
     */
    private function sanitizeGender($gender)
    {
        $gender = strtoupper($gender);

        return $this->sanitizePresence($gender, self::$genders);
    }

    /**
     * Sanitizes a given document type
     *
     * @param   string $docType     Document Type
     * @return  string
     */
    private function sanitizeDocType($docType)
    {
        $docType = strtoupper($docType);

        return $this->sanitizePresence($docType, self::$docTypes);
    }

    /**
     * Sanitizes the format of a date (not the date itself)
     *
     * @param   string $date        The date which format is to sanitize
     * @return  string
     */
    private function sanitizeDate($date)
    {
        $date = Helper::stringify($date);

        $matches = [];
        foreach (self::$dateFormats as $pattern) {
            if (preg_match($pattern, $date, $matches)) break;
        }

        return !empty($matches)
             ? $matches['y'].$matches['m'].$matches['d']
             : '00000000';
    }

    /**
     * Sanitizes an internal code
     *
     * @param   string $string       Code
     * @return  string
     */
    private function sanitizeCode($string)
    {
        return $this->sanitizeLength($string, self::$lengths['code']);
    }

    /**
     * Sanitizes a business name
     *
     * @param   string $string       Business name
     * @return  string
     */
    private function sanitizeBizName($string)
    {
        return $this->sanitizeLength($string, self::$lengths['bizName']);
    }

    /**
     * Sanitizes a spanish ID number
     *
     * @param   string $string       Spanish ID number
     * @return  string
     */
    private function sanitizeSpanishID($string)
    {
        return $this->sanitizeLength($string, self::$lengths['spanishID']);
    }

    /**
     * Sanitizes a foreign ID number
     *
     * @param   string $string       Foreign ID number
     * @return  string
     */
    private function sanitizeForeignID($string)
    {
        return $this->sanitizeLength($string, self::$lengths['foreignID']);
    }

    /**
     * Sanitizes a person name
     *
     * @param   string $string       Person name
     * @return  string
     */
    private function sanitizePersonName($string)
    {
        return $this->sanitizeLength($string, self::$lengths['personName']);
    }

    /**
     * Sanitizes a country name
     *
     * @param   string $string       Country name
     * @return  string
     */
    private function sanitizeCountryName($string)
    {
        return $this->sanitizeLength($string, self::$lengths['countryName']);
    }

    /**
     * Sanitizes the presence of a value in a given list
     *
     * @param   mixed  $string       Value to sanitize
     * @param   array  $array        List of values to be checked against
     * @return  string
     */
    private function sanitizePresence($string, array $array)
    {
        $string = Helper::stringify($string);

        return in_array($string, $array)
             ? $string
             : Helper::stringify(array_shift($array));
    }

    /**
     * Sanitizes the length of a string
     *
     * @param   string  $string     String to sanitize
     * @param   int     $length     Maximum length allowed
     */
    private function sanitizeLength($string, $length)
    {
        $string = trim(Helper::stringify($string));
        $length >= 0 || $length = 0;

        return substr($string, 0, $length);
    }
}

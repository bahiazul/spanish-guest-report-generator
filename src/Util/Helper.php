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

namespace SpanishGuestReportGenerator\Util;

/**
 * Static helpers
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/spanish-guest-report-generator
 */
class Helper
{
    /**
     * Finds whether an array is associative
     *
     * @param  array   $array The array being evaluated.
     * @return boolean
     */
    final public static function is_assoc_array(array $array)
    {
        if ($array === []) return false;

        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Converts any value into a string without raising Errors, Notices or
     * getting weird results (like "Array")
     *
     * @param  mixed $value
     * @return string
     */
    final public static function stringify($value)
    {
        if (is_array($value) || (is_object($value) && !method_exists($value, '__toString'))) {
            $value = '';
        } elseif (!is_string($value)) {
            $value = strval($value);
        }

        return $value;
    }
}

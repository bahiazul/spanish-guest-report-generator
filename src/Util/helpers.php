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

/**
 * Helpers
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/spanish-guest-report-generator
 */

if (!function_exists('is_assoc_array')) {

    /**
     * Finds whether an array is associative
     *
     * @param  array   $array The array being evaluated.
     * @return boolean
     */
    function is_assoc_array(array $array)
    {
        if ($array === []) return false;

        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (!function_exists('stringify')) {

    /**
     * Converts any value into a string without raising Errors, Notices or
     * getting weird results (like "Array")
     *
     * @param  mixed $value
     * @return string
     */
    function stringify($value)
    {
        if (is_array($value) || (is_object($value) && !method_exists($value, '__toString'))) {
            $value = '';
        } elseif (!is_string($value)) {
            $value = strval($value);
        }

        return $value;
    }
}

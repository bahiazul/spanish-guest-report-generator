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
 * Formatters
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/spanish-guest-report-generator
 */
trait FormatterTrait
{
    /**
     * Format for the date
     *
     * @var string
     */
    private static $dateFormat = 'Ymd';

     /**
     * Format for the time
     *
     * @var string
     */
    private static $timeFormat = 'Hi';

    /**
     * Format a given DateTime into a date string
     *
     * @param  \DateTime $date   Date to format
     * @return string
     */
    private function formatDate(\DateTime $date)
    {
        return $date->format(self::$dateFormat);
    }

    /**
     * Format a given DateTime into a time string
     *
     * @param  \DateTime $date   Date to format
     * @return string
     */
    private function formatTime(\DateTime $date)
    {
        return $date->format(self::$timeFormat);
    }
}

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

/**
 * Guest Factory
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/nkm/spanish-guest-report-generator
 */
class HotelFactory extends AbstractFactory
{
    /**
     * Name of the class to be built
     *
     * @var string
     */
    protected $className = '\SpanishGuestReportGenerator\Hotel';

    /**
     * List of sorted constructor arguments for the class to be built
     *
     * @var array
     */
    protected $argsOrder = [
        'hotelCode',
        'hotelName',
        'reportDateTime',
        'guests',
    ];
}

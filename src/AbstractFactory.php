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

include_once __DIR__.'/Util/helpers.php';

/**
 * Abstract Factory
 *
 * @package    Spanish Guest Report Generator
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2016 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/spanish-guest-report-generator
 */
abstract class AbstractFactory
{
    /**
     * Name of the class to be built
     *
     * @var string
     */
    protected $className;

    /**
     * Sorted list of constructor arguments for the class to be built
     *
     * @var array
     */
    protected $argsOrder;

    /**
     * Returns a collection of instances given an array with its data
     *
     * @param  array  $collection Data for the objects to be built
     * @return array              Collection of instances of the given class
     */
    final public function buildMultiple(array $collection)
    {
        foreach ($collection as &$args) {
            // Already built
            if ($args instanceof $this->className) continue;

            $args = $this->build($args);
        }

        return $collection;
    }

    /**
     * Returns a new instance of a given class name and arguments
     *
     * @param  array  $args Arguments for the constructor
     * @return object       Instance of the given class
     */
    final public function build(array $args = [])
    {
        if ($args && !is_assoc_array($args)) {
            throw new FactoryException("`args` should be an associative array indexed by the property names of the class to be built.");
        }

        $newArgs = [];
        foreach ($this->argsOrder as $name) {
            $value = array_key_exists($name, $args)
                   ? $args[$name]
                   : null;

            array_push($newArgs, $value);
        }

        $class = new \ReflectionClass($this->className);

        return $class->newInstanceArgs($newArgs);
    }
}

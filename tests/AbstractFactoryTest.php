<?php

use \PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \SpanishGuestReportGenerator\AbstractFactory
 */
class ConcreteTestObject
{
    public $argOne;
    public $argTwo;
    public $argThree;
    public $argFour;

    public function __construct($argOne = '', $argTwo = '', $argThree = '', $argFour = '')
    {
        $this->argOne   = $argOne;
        $this->argTwo   = $argTwo;
        $this->argThree = $argThree;
        $this->argFour  = $argFour;
    }
}

/**
 * @coversDefaultClass \SpanishGuestReportGenerator\AbstractFactory
 */
class ConcreteTestObjectFactory extends \SpanishGuestReportGenerator\AbstractFactory
{
    protected $className = 'ConcreteTestObject';

    protected $argsOrder = [
        'argOne',
        'argTwo',
        'argThree',
        'argFour',
    ];
}

/**
 * @coversDefaultClass \SpanishGuestReportGenerator\AbstractFactory
 */
class AbstractFactoryTest extends TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new ConcreteTestObjectFactory();
    }

    /**
     * @covers ::build
     */
    public function testBuild()
    {
        $this->assertInstanceOf('ConcreteTestObject', $this->factory->build());

        $args = [
            'argOne'   => '1',
            'argTwo'   => '2',
            'argThree' => '3',
            'argFive'  => '5',
        ];
        $concreteTestObjectArgs = $this->factory->build($args);

        $this->assertInstanceOf('ConcreteTestObject', $concreteTestObjectArgs);
        $this->assertEquals($args['argOne'], $concreteTestObjectArgs->argOne);
        $this->assertEquals($args['argTwo'], $concreteTestObjectArgs->argTwo);
        $this->assertEquals($args['argThree'], $concreteTestObjectArgs->argThree);
        $this->assertNull($concreteTestObjectArgs->argFour);
    }

    /**
     * @covers ::build
     * @expectedException \SpanishGuestReportGenerator\FactoryException
     */
    public function testBuildRaisesException()
    {
        $this->factory = new ConcreteTestObjectFactory();
        $this->factory->build([
            'argOne',
            'argTwo',
            'argThree',
            'argFive',
        ]);
    }

    /**
     * @covers ::buildMultiple
     */
    public function testBuildMultiple()
    {
        $concreteTestCollection = $this->factory->buildMultiple([
            [
                'argOne'   => '1',
                'argTwo'   => '2',
                'argThree' => '3',
            ],
            [
                'argOne'   => '4',
                'argTwo'   => '5',
                'argThree' => '6',
            ],
            [
                'argOne'   => '7',
                'argTwo'   => '8',
                'argThree' => '9',
            ],
            new ConcreteTestObject('10', '11', '12', '13')
        ]);

        $this->assertInternalType('array', $concreteTestCollection);
        $this->assertEquals('1', $concreteTestCollection[0]->argOne);
        $this->assertEquals('5', $concreteTestCollection[1]->argTwo);
        $this->assertEquals('9', $concreteTestCollection[2]->argThree);
        $this->assertEquals('13', $concreteTestCollection[3]->argFour);
    }
}

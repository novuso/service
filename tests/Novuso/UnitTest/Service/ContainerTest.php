<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\UnitTest\Service;

use PHPUnit_Framework_TestCase;
use Novuso\Component\Service\Api\ContainerInterface;
use Novuso\Component\Service\Container;
use DateTime;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function testInterface()
    {
        $this->assertInstanceOf(
            'Novuso\Component\Service\Api\ContainerInterface',
            $this->container
        );
    }

    public function testParameterModification()
    {
        $this->container->setParameter('foo', 'bar');
        $this->assertTrue($this->container->hasParameter('foo'));
        $this->assertEquals('bar', $this->container->getParameter('foo'));
        $this->container->removeParameter('foo');
        $this->assertFalse($this->container->hasParameter('foo'));
        $this->assertNull($this->container->getParameter('foo'));
        $this->assertEquals('default', $this->container->getParameter('foo', 'default'));
    }

    public function testSingletonServiceDefinition()
    {
        $this->container->setParameter('date', '2007-08-17');
        $this->container->set('date', function ($c) {
            return new DateTime($c->getParameter('date'));
        });
        $this->assertTrue($this->container->has('date'));
        $date1 = $this->container->get('date');
        $this->assertEquals('August 17th, 2007', $date1->format('F jS, Y'));
        $date1->modify('+1 day');
        $date2 = $this->container->get('date');
        $this->assertEquals('August 18th, 2007', $date2->format('F jS, Y'));
        $this->assertSame($date1, $date2);
        $this->container->remove('date');
        $this->assertFalse($this->container->has('date'));
    }

    public function testFactoryServiceDefinition()
    {
        $this->container->setParameter('date', '2007-08-17');
        $this->container->factory('date', function ($c) {
            return new DateTime($c->getParameter('date'));
        });
        $this->assertTrue($this->container->has('date'));
        $date1 = $this->container->get('date');
        $this->assertEquals('August 17th, 2007', $date1->format('F jS, Y'));
        $date1->modify('+1 day');
        $date2 = $this->container->get('date');
        $this->assertEquals('August 17th, 2007', $date2->format('F jS, Y'));
        $this->assertNotSame($date1, $date2);
        $this->container->remove('date');
        $this->assertFalse($this->container->has('date'));
    }

    public function testUndefinedNullGetBehavior()
    {
        $this->assertNull($this->container->get('foo', ContainerInterface::UNDEFINED_NULL));
    }

    /**
     * @expectedException Novuso\Component\Service\Exception\ServiceNotFoundException
     */
    public function testServiceNotFoundOnGet()
    {
        $this->container->get('foo');
    }

    /**
     * @expectedException Novuso\Component\Service\Exception\FrozenContainerException
     */
    public function testFactoryMethodFrozenContainer()
    {
        $this->container->freeze();
        $this->container->factory('date', function () {
            return new DateTime();
        });
    }

    /**
     * @expectedException Novuso\Component\Service\Exception\FrozenContainerException
     */
    public function testSetMethodFrozenContainer()
    {
        $this->container->freeze();
        $this->container->set('date', function () {
            return new DateTime();
        });
    }

    /**
     * @expectedException Novuso\Component\Service\Exception\FrozenContainerException
     */
    public function testRemoveMethodFrozenContainer()
    {
        $this->container->set('date', function () {
            return new DateTime();
        });
        $this->container->freeze();
        $this->container->remove('date');
    }

    /**
     * @expectedException Novuso\Component\Service\Exception\FrozenContainerException
     */
    public function testSetParameterMethodFrozenContainer()
    {
        $this->container->freeze();
        $this->container->setParameter('foo', 'bar');
    }

    /**
     * @expectedException Novuso\Component\Service\Exception\FrozenContainerException
     */
    public function testRemoveParameterMethodFrozenContainer()
    {
        $this->container->setParameter('foo', 'bar');
        $this->container->freeze();
        $this->container->removeParameter('foo');
    }
}

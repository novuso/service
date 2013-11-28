<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\UnitTest\Service\Mixin;

use PHPUnit_Framework_TestCase;
use Novuso\UnitTest\Service\Stub\Controller;
use Mockery;

class ContainerAwareTraitTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $mockContainer;

    public function setUp()
    {
        $this->controller = new Controller();
        $this->mockContainer = Mockery::mock('Novuso\Component\Service\Container');
    }

    public function testSetContainerMethod()
    {
        $this->assertInstanceOf(
            'Novuso\Component\Service\Api\ContainerAwareInterface',
            $this->controller
        );
        $this->controller->setContainer($this->mockContainer);
        $this->assertInstanceOf(
            'Novuso\Component\Service\Api\ContainerInterface',
            $this->controller->getContainer()
        );
    }
}

<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\Test\Service;

use PHPUnit_Framework_TestCase;
use Novuso\Component\Service\Container;

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
}

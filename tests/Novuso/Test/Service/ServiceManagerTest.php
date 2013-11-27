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
use Novuso\Component\Service\ServiceManager;

class ServiceManagerTest extends PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    public function setUp()
    {
        $this->serviceManager = new ServiceManager();
    }

    public function testInterface()
    {
        $this->assertInstanceOf(
            'Novuso\Component\Service\Api\ServiceManagerInterface',
            $this->serviceManager
        );
    }
}
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
use Novuso\Component\Service\Definition;

class DefinitionTest extends PHPUnit_Framework_TestCase
{
    public function testDefinitionCanBeCalled()
    {
        $definition = new Definition(function () {
            return 'called';
        });
        $this->assertEquals('called', $definition());
    }

    public function testDefinitionCodeDump()
    {
        $definition = new Definition(function () {
            $date = new \DateTime('now');

            return $date;
        });
        $expected = <<<EOF
function () {
            \$date = new \\DateTime('now');

            return \$date;
        }
EOF;
        $this->assertEquals($expected, $definition->getCode());
    }

    public function testDefinitionUsedVariables()
    {
        $foo = 'bar';
        $config = ['key' => 'value'];
        $definition = new Definition(function () use ($foo, $config) {
            return array_merge($config, ['foo' => $foo]);
        });
        $used = $definition->getUsed();
        $this->assertEquals($foo, $used['foo']);
        $this->assertEquals($config, $used['config']);
    }

    public function testDefinitionUsedEmptyArray()
    {
        $definition = new Definition(function () {});
        $used = $definition->getUsed();
        $this->assertEquals([], $used);
    }
}

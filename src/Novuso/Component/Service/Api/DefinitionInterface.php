<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\Component\Service\Api;

use Closure;

interface DefinitionInterface
{
    public function getCallback();
    public function getReflection();
    public function getCode();
    public function getUsed();
}

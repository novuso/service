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

interface ContainerInterface
{
    const UNDEFINED_NULL = 0;
    const UNDEFINED_EXCEPTION = 1;

    public function set($name, Closure $callback);
    public function get($name, $undefined = self::UNDEFINED_EXCEPTION);
    public function has($name);
    public function setParameter($key, $value);
    public function getParameter($key, $default = null);
    public function hasParameter($key);
    public function removeParameter($key);
}

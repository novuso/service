<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\Component\Service;

use Novuso\Component\Service\Api\ContainerInterface;
use InvalidArgumentException;
use Closure;

class Container implements ContainerInterface
{
    protected $services = [];
    protected $parameters = [];

    public function set($name, Closure $callback)
    {
        $this->services[$name] = function ($c) use ($callback) {
            static $object;
            if (null === $object) {
                $object = $callback($c);
            }

            return $object;
        };

        return $this;
    }

    public function get($name, $undefined = self::UNDEFINED_EXCEPTION)
    {
        if (!isset($this->services[$name])) {
            if (self::UNDEFINED_NULL === $undefined) {
                return null;
            }
            throw new InvalidArgumentException(sprintf('Service "%s" is not defined', $name));
        }

        return $this->services[$name]($this);
    }

    public function has($name)
    {
        return isset($this->services[$name]);
    }

    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function getParameter($key, $default = null)
    {
        if (!array_key_exists($key, $this->parameters)) {
            return $default;
        }

        return $this->parameters[$key];
    }

    public function hasParameter($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    public function removeParameter($key)
    {
        unset($this->parameters[$key]);

        return $this;
    }
}

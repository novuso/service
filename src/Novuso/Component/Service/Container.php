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
use Novuso\Component\Service\Exception\FrozenContainerException;
use Novuso\Component\Service\Exception\ServiceNotFoundException;
use Closure;

class Container implements ContainerInterface
{
    protected $services = [];
    protected $parameters = [];
    protected $frozen = false;

    public function factory($name, Closure $callback)
    {
        if ($this->isFrozen()) {
            throw new FrozenContainerException(sprintf('%s cannot modify a frozen container', __METHOD__));
        }
        $this->services[$name] = $callback;

        return $this;
    }

    public function set($name, Closure $callback)
    {
        if ($this->isFrozen()) {
            throw new FrozenContainerException(sprintf('%s cannot modify a frozen container', __METHOD__));
        }
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
            throw new ServiceNotFoundException(sprintf('Service "%s" is not defined', $name));
        }

        return $this->services[$name]($this);
    }

    public function has($name)
    {
        return isset($this->services[$name]);
    }

    public function remove($name)
    {
        if ($this->isFrozen()) {
            throw new FrozenContainerException(sprintf('%s cannot modify a frozen container', __METHOD__));
        }
        unset($this->services[$name]);

        return $this;
    }

    public function setParameter($key, $value)
    {
        if ($this->isFrozen()) {
            throw new FrozenContainerException(sprintf('%s cannot modify a frozen container', __METHOD__));
        }
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
        if ($this->isFrozen()) {
            throw new FrozenContainerException(sprintf('%s cannot modify a frozen container', __METHOD__));
        }
        unset($this->parameters[$key]);

        return $this;
    }

    public function isFrozen()
    {
        return $this->frozen;
    }

    public function freeze()
    {
        $this->frozen = true;
    }
}

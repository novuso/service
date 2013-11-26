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

class Container implements ContainerInterface
{
    protected $parameters = [];

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

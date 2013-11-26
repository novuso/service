<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\Component\Service\Api;

interface ContainerInterface
{
    public function setParameter($key, $value);
    public function getParameter($key, $default = null);
    public function hasParameter($key);
    public function removeParameter($key);
}

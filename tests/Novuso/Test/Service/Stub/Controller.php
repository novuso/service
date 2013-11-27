<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\Test\Service\Stub;

use Novuso\Component\Service\Api\ContainerAwareInterface;
use Novuso\Component\Service\Mixin\ContainerAwareTrait;

class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getContainer()
    {
        return $this->container;
    }
}

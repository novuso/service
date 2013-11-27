<?php
/**
 * This file is part of the Novuso Framework
 *
 * @author    John Nickell
 * @copyright Copyright (c) 2013, Novuso. (http://novuso.com)
 * @license   http://opensource.org/licenses/MIT The MIT License
 */

namespace Novuso\Component\Service;

use Novuso\Component\Service\Api\DefinitionInterface;
use ReflectionFunction;
use SplFileObject;
use Closure;

class Definition implements DefinitionInterface
{
    protected $callback;
    protected $reflection;
    protected $code;
    protected $used;

    public function __construct(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke()
    {
        return call_user_func_array($this->getCallback(), func_get_args());
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getReflection()
    {
        if (!isset($this->reflection)) {
            $this->reflection = new ReflectionFunction($this->callback);
        }

        return $this->reflection;
    }

    public function getCode()
    {
        if (!isset($this->code)) {
            $reflection = $this->getReflection();
            $file = new SplFileObject($reflection->getFileName());
            $file->seek($reflection->getStartLine() - 1);
            $this->code = '';
            while ($file->key() < $reflection->getEndLine()) {
                $this->code .= $file->current();
                $file->next();
            }
            $start = strpos($this->code, 'function');
            $end = strrpos($this->code, '}');
            $this->code = substr($this->code, $start, $end - $start + 1);
        }

        return $this->code;
    }

    public function getUsed()
    {
        if (!isset($this->used)) {
            $reflection = $this->getReflection();
            $code = $this->getCode();
            $pos = stripos($code, 'use');
            if (!$pos) {
                return $this->used = [];
            }
            $start = strpos($code, '(', $pos) + 1;
            $end = strpos($code, ')', $start);
            $vars = explode(',', substr($code, $start, $end - $start));
            $static = $reflection->getStaticVariables();
            $this->used = [];
            foreach ($vars as $var) {
                $var = trim($var, ' &$');
                $this->used[$var] = $static[$var];
            }
        }

        return $this->used;
    }
}

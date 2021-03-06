<?php

/*
 * This file is part of the Prophecy.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *     Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prophecy\Doubler\Generator\Node;

use Prophecy\Exception\InvalidArgumentException;

/**
 * Class node.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ClassNode
{
    private $parentClass = 'stdClass';
    private $interfaces  = array();
    private $properties  = array();

    /**
     * @var MethodNode[]
     */
    private $methods     = array();

    public function getParentClass()
    {
        return $this->parentClass;
    }

    public function setParentClass($class)
    {
        $this->parentClass = $class ?: 'stdClass';
    }

    public function getInterfaces()
    {
        return $this->interfaces;
    }

    public function addInterface($interface)
    {
        if ($this->hasInterface($interface)) {
            return;
        }

        array_unshift($this->interfaces, $interface);
    }

    public function hasInterface($interface)
    {
        return in_array($interface, $this->interfaces);
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty($name, $visibility = 'public')
    {
        $visibility = strtolower($visibility);

        if (!in_array($visibility, array('public', 'private', 'protected'))) {
            throw new InvalidArgumentException(sprintf(
                '`%s` property visibility is not supported.', $visibility
            ));
        }

        $this->properties[$name] = $visibility;
    }

    /**
     * @return MethodNode[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    public function addMethod(MethodNode $method)
    {
        $this->methods[$method->getName()] = $method;
    }

    /**
     * @param string $name
     *
     * @return MethodNode|null
     */
    public function getMethod($name)
    {
        return $this->hasMethod($name) ? $this->methods[$name] : null;
    }

    public function hasMethod($name)
    {
        return isset($this->methods[$name]);
    }
}

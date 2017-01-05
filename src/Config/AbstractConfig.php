<?php

namespace Crembl\Config;

/**
 * Abstract class for configuration objects. Extending classes should create protected properties with the default value
 * set to the type.
 *
 * @see TaskConfig
 */
abstract class AbstractConfig {
    protected $json = [];

    /**
     * Magic method for setter methods.
     *
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments) {
        $property = lcfirst(substr($name, 3));
        if (!property_exists($this, $property)) {
            throw new \BadMethodCallException(sprintf('The property "%s" is not available for this object.', $property));
        } elseif (empty($arguments)) {
            throw new \InvalidArgumentException('A value needs to be set.');
        } else {
            $value = $arguments[0];
            $expect = gettype($this->$property);
            $actual = gettype($value);
            if ($actual != $expect) {
                throw new \InvalidArgumentException(sprintf('The property "%s" requires a value of type %s, not %s.', $property, $expect, $actual));
            }
            $this->json[$property] = $value;
            return $this;
        }
    }

    /**
     * Returns the array which is to be sent to the API.
     *
     * @return array
     */
    public function __toArray() {
        return $this->json;
    }

    /**
     * Disable this magic method.
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        throw new \BadMethodCallException('The magic setter method is not available for this object.');
    }
}
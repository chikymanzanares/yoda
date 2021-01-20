<?php

namespace Inbenta\SharedKernel\Domain;


abstract class AbstractValueObject implements Equalable
{
    protected $value;

    public function __construct($value)
    {
        $this->set($value);
    }


    public function __toString()
    {
        if (is_array($this->value)) {
            return json_encode($this->value);
        }
        return (string) $this->value;
    }


    protected function set($newValue)
    {

        if (is_a($newValue, self::class)) {
            $newValue = $newValue->getValue();
        }
        $this->value = $newValue;
    }

    public function getValue()
    {
        return $this->value;
    }

    final public function isArray()
    {
        return is_array($this->value);
    }

    final public function isNumeric()
    {
        return is_numeric($this->value);
    }

    final public function isString()
    {
        return is_string($this->value);
    }

    public function equals($object)
    {
        return ($object instanceof AbstractValueObject)
            && get_class($this) === get_class($object)
            && $this->getValue() === $object->getValue()
        ;
    }
}

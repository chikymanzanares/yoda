<?php

namespace Inbenta\SharedKernel\Domain;


abstract class AbstractEntity implements Arrayable, Equalable, \Serializable
{

    public function serialize()
    {
        return json_encode($this->toArray());
    }

    public function unserialize($serialized)
    {

    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            if ($value instanceof AbstractValueObject){
                $array["$key"] = $value->getValue();
            } elseif (!($value === null)) {
                $array["$key"] = $value;
            }
        }
        return $array;
    }

    public function toArrayNoID(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            if ($key === 'id'){
                continue;
            }
            if ($value instanceof AbstractValueObject){
                $array["$key"] = $value->getValue();
            } elseif (!($value === null)) {
                $array["$key"] = $value;
            }
        }
        return $array;
    }

    public function setVariables(array $entityArray, array $entityKeys = [])
    {
        foreach ($this as $key => $value) {
            if ((isset($entityArray[$key]))
                && ($entityArray[$key] !== null)
                && !(in_array($key, $entityKeys))
                ){
                $this->$key = $entityArray[$key];
            }
        }
    }

    public function totallyEquals(AbstractEntity $entity)
    {
        foreach ($this as $key => $value) {
            if ($key !== 'id') {
                if ($value instanceof AbstractValueObject) {
                    if (! $value->equals($entity->$key)) {
                     return false;
                    }
                } else {
                    if ($this->$key !== $entity->$key) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function noTotallyEquals(AbstractEntity $entity)
    {
        return !($this->totallyEquals($entity));
    }


}

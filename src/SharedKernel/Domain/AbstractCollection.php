<?php

namespace Inbenta\SharedKernel\Domain;



abstract class AbstractCollection implements \IteratorAggregate, \Countable, \JsonSerializable, Arrayable
{
    protected array $collection;

    public function __construct(array $array = [])
    {
        $this->checkArrayBelongToThis($array);
        $this->collection = $this->removeArrayKeys($array);
    }

    protected function checkArrayBelongToThis(array $array)
    {
        foreach ($array as $item) {
            $this->checkItemBelongToThis($item);
        }
    }

    protected function checkItemBelongToThis($item)
    {
        if (! is_object($item)
            || get_class($item) != static::CLASSNAME
            || ! class_implements(static::CLASSNAME, Equalable::class)
        ) {
            throw new \InvalidArgumentException('This item doesn\'t belong to the collection');
        }
    }

    protected function removeArrayKeys($array) // : array
    {
        return array_values($array);
    }

    public function add($item) // : static
    {
        $this->checkItemBelongToThis($item);
        $this->collection[] = $item;
        return $this;
    }

    public function addIfHasNotItem($item)
    {
        if (!$this->has($item)){
            $this->add($item);
        }
    }

    public function remove($item) // : static
    {
        $this->checkItemBelongToThis($item);
        $this->collection = array_filter(
            $this->collection,
            function ($collectionItem) use ($item) {
                return ! $collectionItem->equals($item);
            }
        );
        return $this;
    }

    public function has($item) // : bool
    {
        try {
            $this->checkItemBelongToThis($item);
            foreach ($this->collection as $collectionItem) {
                if ($collectionItem->equals($item)) {
                    return true;
                }
            }
            return false;
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }

    public function get(int $index)
    {
        if ($index >= $this->count()){
            throw new \InvalidArgumentException("Index does not exists");
        }
        return $this->collection[$index];
    }



    public function end()
    {
        return end($this->collection);
    }

    public function addArray(array $array) // : static
    {
        while (! empty($array)) {
            $this->add(array_shift($array));
        }
        return $this;
    }

    public function merge(self $collection) // : static
    {
        $this->checkArrayBelongToThis($collection->toArray());
        return new static(array_merge($this->collection, $collection->toArray()));
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    public function count()
    {
        return count($this->collection);
    }

    public function jsonSerialize()
    {
        return json_encode($this->collection);
    }

    public function toArray(): array
    {
        return $this->collection;
    }

    public function map(callable $callback) // : array
    {
        return array_map(
            $callback,
            $this->collection
        );
    }



    public function filter(callable $callback) // : static
    {
        $this->collection = array_filter(
            $this->collection,
            $callback
        );
        return $this;
    }

    public function reduce(callable $callback, $initial = null) // : array
    {
        return array_reduce(
            $this->collection,
            $callback,
            $initial
        );
    }

    public function toPlainArray(): array
    {
        $array = [];
        foreach ($this->collection as $entity){
            $array[] = $entity->toArray();
        }
        return $array;
    }

    public function copyFilter(callable $callback)
    {
        $collection = array_filter(
            $this->collection,
            $callback
        );
        return new static($collection);
    }

    public function copy()
    {
        return new static($this->collection);
    }

    public function insertElement($item, $position)
    {
        $this->checkItemBelongToThis($item);
        array_splice( $this->collection, $position, 0, [$item] );
        $this->checkItemBelongToThis($item);
        return $this;
    }
}

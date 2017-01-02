<?php

namespace Collection;

use Closure;
use Countable;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate, JsonSerializable
{

    protected $items;

    /**
     * Create a collection from passed items
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Return udnerlying array in collection
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get an item in the collection by its key
     * @param  mixed $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * Check if key exists in the collection
     * @param  mixed  $key
     * @return boolean
     */
    public function has($key)
    {
        if (isset($this->items[$key])) {
            return true;
        }

        return false;
    }

    /**
     * Set a key and value to the collection
     * @param  mixed $key
     * @param  mixed $value
     */
    public function put($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Add item to the end of the collection
     * @param  mixed $value
     */
    public function push($value)
    {
        $this->items[] = $value;
    }

    /**
     * Remove and return an item via its key
     * @param  mixed $key
     * @param  mixed $default
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        $value = $this->get($key, $default);

        $this->remove($key);

        return $value;
    }

    /**
     * Return the first item in the collection
     * @return mixed
     */
    public function first()
    {
        return count($this->items) ? reset($this->items) : null;
    }

    /**
     * Return the last item in the collection
     * @return mixed
     */
    public function last()
    {
        return count($this->items) ? end($this->items) : null;
    }

    /**
     * Return and remove the last item in the array
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Return and remove the first item in the array
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Remove item from the collection via its key
     * @param  mixed $key
     */
    public function remove($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Return the collection keys as a new collection
     * @return Collection
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * Reset the collections keys
     */
    public function values()
    {
        $this->items = array_values($this->items);

        return $this;
    }

    /**
     * Transform the current collection
     * @param  Closure $iterator
     */
    public function transform(Closure $iterator)
    {
        $this->items = array_map($iterator, $this->items);

        return $this;
    }

    /**
     * Returns a collection without duplicate values
     * @return Collection
     */
    public function unique()
    {
        return new static(array_unique($this->items, SORT_REGULAR));
    }

    /**
     * Return a new collection with the items reverese
     * @return Collection
     */
    public function reverse()
    {
        return new static(array_reverse($this->items));
    }

    /**
     * Return a new collection with the items shuffled
     * @return Collection
     */
    public function shuffle()
    {
        $items = $this->items;

        shuffle($items);

        return new static($items);
    }

    /**
     * Get one or more items randomly from the collection
     * @param  integer $amount
     */
    public function random($amount = 1)
    {
        if ($this->isEmpty()) {
            return null;
        }

        $keys = array_rand($this->items, $amount);

        if (is_array($keys)) {
            return new static(array_intersect_key($this->items, array_flip($keys)));
        }

        return $this->items[$keys];
    }

    /**
     * Flip items in the collection
     * @return Collection
     */
    public function flip()
    {
        return new static(array_flip($this->items));
    }

    /**
     * Map over each of the items in the collection
     * @param  Closure $iterator
     * @return Collection
     */
    public function map(Closure $iterator)
    {
        return new static(array_map($iterator, $this->items));
    }

    /**
     * Filter items within the collection
     * @param  Closure $filter
     * @return Collection
     */
    public function filter(Closure $filter)
    {
        return new static(array_filter($this->items, $filter));
    }

    /**
     * Reduce the collection to a single value
     * @param  Closure $callback
     * @param  mixed   $initial
     * @return Collection
     */
    public function reduce(Closure $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Sum the items in the collection
     * @param  string $key
     */
    public function sum($key = null)
    {
        if (is_null($key)) {
            return array_sum($this->items);
        }

        if (is_string($key)) {
            return $this->map(function ($item) use ($key) {
                return $item[$key];
            })->sum();
        }
    }

    /**
     * Concatenate items into a string
     * @param  string $glue
     */
    public function implode($glue = '')
    {
        return implode($glue, $this->items);
    }

    /**
     * Return total items in collection
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Check if the collection is empty
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Return the collection as an array
     * @return Array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Return the collection as JSON
     * @param  integer $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->items, $options);
    }

    /**
     * Iterate over items in collection
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * JSON Serialize items in the collection
     */
    public function jsonSerialize()
    {
        return $this->items;
    }
}

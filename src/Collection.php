<?php

namespace Collection;

use Closure;
use Countable;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;
use Traversable;

class Collection implements Countable, IteratorAggregate, JsonSerializable
{
    /**
     * Collection items.
     *
     * @var array
     */
    protected array $items;

    /**
     * Create a collection with items passed.
     * 
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Create a collection statically.
     *
     * @param array $items
     * @return static
     */
    public static function collect(array $items): static
    {
        return new static($items);
    }

    /**
     * Return items in the collection.
     * 
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Get an item by key.
     * 
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed
    {
        if ($this->has($key)) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * Check if key exists in the collection.
     * 
     * @param string|int $key
     * @return boolean
     */
    public function has(string|int $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Put value to collection with key.
     *
     * @param string|int $key
     * @param mixed $value
     */
    public function put(string|int $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * Add item to the end of the collection.
     * 
     * @param mixed $value
     */
    public function push(mixed $value): void
    {
        $this->items[] = $value;
    }

    /**
     * Remove and return an item via its key.
     * 
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function pull(string|int $key, mixed $default = null): mixed
    {
        $value = $this->get($key, $default);

        $this->remove($key);

        return $value;
    }

    /**
     * Return the first item in the collection.
     * 
     * @return mixed
     */
    public function first(): mixed
    {
        return count($this->items) ? reset($this->items) : null;
    }

    /**
     * Return the last item in the collection.
     * 
     * @return mixed
     */
    public function last(): mixed
    {
        return count($this->items) ? end($this->items) : null;
    }

    /**
     * Return and remove the last item in the array.
     * 
     * @return mixed
     */
    public function pop(): mixed
    {
        return array_pop($this->items);
    }

    /**
     * Return and remove the first item in the array.
     * 
     * @return mixed
     */
    public function shift(): mixed
    {
        return array_shift($this->items);
    }

    /**
     * Remove item from the collection via its key.
     * 
     * @param string|int $key
     */
    public function remove(string|int $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * Return the collection keys as a new collection.
     * 
     * @return static
     */
    public function keys(): static
    {
        return new static(array_keys($this->items));
    }

    /**
     * Reset the collections keys.
     * 
     * @return static
     */
    public function values(): static
    {
        $this->items = array_values($this->items);

        return $this;
    }

    /**
     * Transform the current collection.
     * 
     * @param callable $iterator
     */
    public function transform(callable $iterator): static
    {
        $this->items = array_map($iterator, $this->items);

        return $this;
    }

    /**
     * Returns a collection without duplicate values.
     * 
     * @return static
     */
    public function unique(): static
    {
        return new static(array_unique($this->items, SORT_REGULAR));
    }

    /**
     * Return a new collection with the items reverse.
     * 
     * @return static
     */
    public function reverse(): static
    {
        return new static(array_reverse($this->items));
    }

    /**
     * Return a new collection with the items shuffled.
     * 
     * @return static
     */
    public function shuffle(): static
    {
        $items = $this->items;

        shuffle($items);

        return new static($items);
    }

    /**
     * Get one or more items randomly from the collection.
     * 
     * @param int $amount
     * @return mixed
     */
    public function random(int $amount = 1): mixed
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
     * Flip items in the collection.
     * 
     * @return static
     */
    public function flip(): static
    {
        return new static(array_flip($this->items));
    }

    /**
     * Map over each of the items in the collection.
     * 
     * @param callable $iterator
     * @return static
     */
    public function map(callable $iterator): static
    {
        return new static(array_map($iterator, $this->items));
    }

    /**
     * Filter items within the collection.
     * 
     * @param callable $filter
     * @return static
     */
    public function filter(?callable $filter): static
    {
        return new static(array_filter($this->items, $filter));
    }

    /**
     * Reduce the collection to a single value.
     * 
     * @param callable $callback
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null): mixed
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Sum the items in the collection.
     * 
     * @param string|int|null $key
     */
    public function sum(string|int|null $key = null): int
    {
        if (is_null($key)) {
            return array_sum($this->items);
        }

        return $this->map(function ($item) use ($key) {
            return $item[$key];
        })->sum();
    }

    /**
     * Concatenate items into a string.
     * 
     * @param string $glue
     * @return string
     */
    public function implode(string $glue = ''): string
    {
        return implode($glue, $this->items);
    }

    /**
     * Return total items in collection.
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Check if the collection is empty.
     * 
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Check if the collection is not empty.
     * 
     * @return boolean
     */
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * Return the collection as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Return the collection as JSON.
     * 
     * @param int $flags
     * @param int $depth
     * @return string|false
     */
    public function toJson(int $flags = 0, int $depth = 512): string|false
    {
        return json_encode($this->items, $flags, $depth);
    }

    /**
     * Iterate over items in collection.
     * 
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * JSON Serialize items in the collection.
     * 
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->items;
    }
}

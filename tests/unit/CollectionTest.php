<?php

use Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function test_create_collection_from_array()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(3, $collection->count());
    }

    public function test_collection_returns_all_items()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals([1, 2, 3], $collection->all());
    }

    public function test_get_returns_correct_value()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $this->assertEquals('one', $collection->get('a'));
    }

    public function test_get_returns_null_if_doesnt_exist()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertNull($collection->get('a'));
    }

    public function test_get_returns_default_if_doesnt_exist()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals('default', $collection->get('a', 'default'));
    }

    public function test_has_returns_true_if_exists()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $this->assertTrue($collection->has('a'));
    }

    public function test_has_returns_false_if_doesnt_exist()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $this->assertFalse($collection->has('c'));
    }

    public function test_put_is_in_items()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $collection->put('c', 'three');

        $this->assertEquals('three', $collection->get('c'));
    }

    public function test_push_adds_item_to_end()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->push(4);

        $this->assertEquals([1, 2, 3, 4], $collection->all());
    }

    public function test_pull_returns_value()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $this->assertEquals('two', $collection->pull('b'));
    }

    public function test_pull_removes_value_from_items()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $collection->pull('b');

        $this->assertEquals(1, $collection->count());
    }

    public function test_first_returns_first_item()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(1, $collection->first());
    }

    public function test_first_returns_null_when_empty()
    {
        $collection = new Collection;

        $this->assertNull($collection->first());
    }

        public function test_last_returns_last_item()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(3, $collection->last());
    }

    public function test_last_returns_null_when_empty()
    {
        $collection = new Collection;

        $this->assertNull($collection->last());
    }

    public function test_pop_returns_last_item()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(3, $collection->pop());
    }

    public function test_pop_removes_last_item()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->pop();

        $this->assertEquals(2, $collection->count());
    }

    public function test_shift_returns_last_item()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(1, $collection->shift());
    }

    public function test_shift_removes_last_item()
    {
        $collection = new Collection([1, 2, 3]);

        $collection->shift();

        $this->assertEquals(2, $collection->count());
    }

    public function test_remove_deletes_item()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $collection->remove('a');

        $this->assertFalse($collection->has('a'));
    }

    public function test_keys_returns_collection_of_keys()
    {
        $collection = new Collection(['a' => 'one', 'b' => 'two']);

        $keys = $collection->keys();

        $this->assertEquals(['a', 'b'], $keys->all());
    }

    public function test_values_resets_array_keys()
    {
        $collection = new Collection([1 => 'one', 2 => 'two']);

        $collection->values();

        $this->assertEquals('one', $collection->get(0));
    }

    public function tets_transform_modifies_collection()
    {
        $collection = new Collection(['red', 'green']);

        $collection->transform(function($item) {
            return $item + ' apple';
        });

        $this->assertEquals(['red apple', 'green apple'], $collection->all());
    }

    public function test_unique_removes_duplicate_values()
    {
        $collection = new Collection([1, 1, 1, 2, 2, 3]);

        $unique = $collection->unique();

        $this->assertEquals([1, 2, 3], $unique->values()->all());
    }

    public function test_duplicate_values_in_collection()
    {
        $this->assertEquals(['Bram'], (new Collection(['Bram', 'Bram', 'John', 'Doe']))->duplicates()->values()->all());
        $this->assertEquals([1, 45], (new Collection([1, 1, 2, 5, 11, 28, 45, 45, 60]))->duplicates()->values()->all());
        $this->assertEquals([], (new Collection(['Bram', 'John', 'Doe', 'Jane']))->duplicates()->values()->all());
    }

    public function test_reverse_items_in_collection()
    {
        $collection = new Collection([1, 2, 3]);

        $reversed = $collection->reverse();

        $this->assertEquals([3, 2, 1], $reversed->all());
    }

    public function test_random_returns_null_when_empty()
    {
        $collection = new Collection;

        $this->assertEquals(null, $collection->random());
    }

    public function test_flip_collection()
    {
        $collection = new Collection(['a', 'b']);

        $this->assertEquals(['a' => 0, 'b' => 1], $collection->flip()->all());
    }

    public function test_map_returns_correct_collection()
    {
        $collection = new Collection([
            ['name' => 'Alex', 'email' => 'alex@mail.com'],
            ['name' => 'Beth', 'email' => 'beth@mail.com'],
        ]);

        $mapped = $collection->map(function($item) {
            return $item['name'];
        });

        $this->assertEquals(['Alex', 'Beth'], $mapped->all());
    }

    public function test_filter_returns_correct_collection()
    {
        $collection = new Collection([
            ['name' => 'Alex', 'email' => 'alex@mail.com'],
            ['name' => 'Beth', 'email' => 'beth@mail.com'],
        ]);

        $filtered = $collection->filter(function($item) {
            return $item['name'] === 'Alex';
        });

        $this->assertEquals([['name' => 'Alex', 'email' => 'alex@mail.com']], $filtered->all());
    }

    public function test_reduce_returns_correct_value()
    {
        $collection = new Collection([1, 2, 3]);

        $reduced = $collection->reduce(function($carry, $item) {
            return $carry + $item;
        }, 0);

        $this->assertEquals(6, $reduced);
    }

    public function test_sum_returns_correct_total()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(6, $collection->sum());
    }

    public function test_implode_returns_correct_string()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals('1, 2, 3', $collection->implode(', '));
    }

    public function test_collection_count()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(3, $collection->count());
    }

    public function test_collection_is_empty()
    {
        $collection = new Collection;

        $this->assertTrue($collection->isEmpty());
    }

    public function test_collection_to_array()
    {
        $collection = new Collection;

        $this->assertEquals([], $collection->toArray());
    }

    public function test_collection_to_json()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals('[1,2,3]', $collection->toJson());
    }

    public function test_collection_is_countable()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals(3, count($collection));
    }

    public function test_collection_is_json_serializable()
    {
        $collection = new Collection([1, 2, 3]);

        $this->assertEquals('[1,2,3]', json_encode($collection));
    }
}

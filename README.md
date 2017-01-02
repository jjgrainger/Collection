# Collection v1.0

> A collection class for working with arrays

## Principles

* Immutable - Most methods return a new collection, leaving the previous untouched
* Chainable - Methods can be chained to create fluent mapping and reduce original collection

## Requirements

* PHP v5.3
* Composer

## Installation

```
$ composer require jjgrainger/collection
```

## Usage

```php

$collection = new Collection([1, 2, 3]);

$total = $collection->sum(); // 6
```


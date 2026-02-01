# Collection v1.1

> A collection class for working with arrays

[![tests](https://github.com/jjgrainger/Collection/actions/workflows/tests.yml/badge.svg)](https://github.com/jjgrainger/Collection/actions/workflows/tests.yml) [![codecov](https://codecov.io/gh/jjgrainger/Collection/graph/badge.svg?token=XMLzVOcLHB)](https://codecov.io/gh/jjgrainger/Collection) [![Latest Stable Version](https://badgen.net/github/release/jjgrainger/Collection/stable)](https://packagist.org/packages/jjgrainger/collection) [![Total Downloads](https://badgen.net/packagist/dt/jjgrainger/Collection)](https://packagist.org/packages/jjgrainger/collection) [![License](https://badgen.net/github/license/jjgrainger/Collection)](https://packagist.org/packages/jjgrainger/collection)

## Principles

* Immutable - Most methods return a new collection, leaving the previous untouched
* Chainable - Methods can be chained to create fluent mapping and reduce original collection

## Requirements

* PHP >=7.2
* [Composer](https://getcomposer.org/)

## Installation

```
$ composer require jjgrainger/collection
```

## Usage

```php
$collection = new Collection([1, 2, 3]);

$total = $collection->sum(); // 6
```

## Notes

* This project was created to learn unit testing, not intended for production use.
* Inspired by [Laravel Collections](https://laravel.com/docs/5.8/collections)
* Licensed under the [MIT License](https://github.com/jjgrainger/wp-posttypes/blob/master/LICENSE)
* Maintained under the [Semantic Versioning Guide](https://semver.org)

## Author

**Joe Grainger**

* [https://jjgrainger.co.uk](https://jjgrainger.co.uk)
* [https://twitter.com/jjgrainger](https://twitter.com/jjgrainger)

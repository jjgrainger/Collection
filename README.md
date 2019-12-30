# Collection v1.0

> A collection class for working with arrays

[![Build Status](https://travis-ci.org/jjgrainger/Collection.svg?branch=master)](https://travis-ci.org/jjgrainger/Collection) [![Total Downloads](https://poser.pugx.org/jjgrainger/collection/downloads)](https://packagist.org/packages/jjgrainger/collection) [![Latest Stable Version](https://poser.pugx.org/jjgrainger/collection/v/stable)](https://packagist.org/packages/jjgrainger/collection) [![License](https://poser.pugx.org/jjgrainger/collection/license)](https://packagist.org/packages/jjgrainger/collection)

## Principles

* Immutable - Most methods return a new collection, leaving the previous untouched
* Chainable - Methods can be chained to create fluent mapping and reduce original collection

## Requirements

* PHP >=7.2
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


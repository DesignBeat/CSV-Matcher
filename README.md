# CSV parser

[![Downloads this Month](https://img.shields.io/packagist/dm/designbeat/csv-matcher.svg?style=flat-square)](https://packagist.org/packages/designbeat/csv-matcher)
[![Latest stable](https://img.shields.io/packagist/v/designbeat/csv-matcher.svg?style=flat-square)](https://packagist.org/packages/designbeat/csv-matcher)


## Install
```sh
$ composer require designbeat/csv-matcher
```

## Usage

See more in tests.

```php
use DesignBeat\Matchers\CSV\CsvMatcher;
use DesignBeat\Matchers\CSV\CsvReader;

$scheme = [
    0 => 'user.name',
    1 => 'user.surname',
    2 => 'city',
    3 => 'extra.id',
    4 => 'extra.x',
];

$matcher = new CsvMatcher(new CsvReader(__DIR__ . '/tests/cases/files/fixtures.csv'));
$result = $matcher->match($scheme);
```

Result is:

```php
0 => [
    'user' => [
        'name' => 'Milan',
        'surname' => 'Sulc',
    ],
    'city' => 'HK',
    'extra' => [
        'id' => '123456',
        'x' => 'foo',
    ],
],
1 => [
    'user' => [
        'name' => 'John',
        'surname' => 'Doe',
    ],
    'city' => 'Doens',
    'extra' => [
        'id' => '111111',
        'x' => 'bar',
    ],
],
```
<?php

/**
 * Test: DesignBeat\Matchers\CSV\CsvParser
 */

use DesignBeat\Matchers\CSV\CsvMatcher;
use DesignBeat\Matchers\CSV\CsvReader;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// Simple array matching
test(function () {
    $matcher = new CsvMatcher(new CsvReader(__DIR__ . '/files/fixtures.csv'));

    Assert::equal([
        0 => [
            'name' => 'Milan',
            'surname' => 'Sulc',
            'city' => 'HK',
            'id' => '123456',
            'x' => 'foo',
        ],
        1 => [
            'name' => 'John',
            'surname' => 'Doe',
            'city' => 'Doens',
            'id' => '111111',
            'x' => 'bar',
        ],
    ], $matcher->match([
        0 => 'name',
        1 => 'surname',
        2 => 'city',
        3 => 'id',
        4 => 'x',
    ]));
});

// Complex array matching
test(function () {
    $matcher = new CsvMatcher(new CsvReader(__DIR__ . '/files/fixtures.csv'));

    Assert::equal([
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
    ], $matcher->match([
        0 => 'user.name',
        1 => 'user.surname',
        2 => 'city',
        3 => 'extra.id',
        4 => 'extra.x',
    ]));
});

// Part of simple array matching
test(function () {
    $matcher = new CsvMatcher(new CsvReader(__DIR__ . '/files/fixtures.csv'));

    Assert::equal([
        0 => [
            'x' => 'foo',
        ],
        1 => [
            'x' => 'bar',
        ],
    ], $matcher->match([
        4 => 'x',
    ]));
});

// Part of complex array matching
test(function () {
    $matcher = new CsvMatcher(new CsvReader(__DIR__ . '/files/fixtures.csv'));

    Assert::equal([
        0 => [
            'x' => [
                'y' => [
                    'z' => 'foo'
                ],
            ],
        ],
        1 => [
            'x' => [
                'y' => [
                    'z' => 'bar'
                ],
            ],
        ],
    ], $matcher->match([
        4 => 'x.y.z',
    ]));
});

// Overriding
test(function () {
    $matcher = new CsvMatcher(new CsvReader(__DIR__ . '/files/fixtures.csv'));

    Assert::equal([
        0 => [
            'x' => 'foo',
        ],
        1 => [
            'x' => 'bar',
        ],
    ], $matcher->match([
        2 => 'x',
        4 => 'x',
    ]));
});

// Invalid arguments
test(function () {
    Assert::throws(function () {
        $matcher = new CsvMatcher(new CsvReader(__DIR__ . '/files/fixtures.csv'));
        $matcher->match([
            0 => 'a',
            1 => 'b',
            2 => 'c',
            3 => 'd',
            4 => 'e',
            5 => 'f',
            6 => 'g',
        ]);
    }, InvalidArgumentException::class);
});

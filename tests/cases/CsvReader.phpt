<?php

/**
 * Test: DesignBeat\Matchers\CSV\CsvReader
 */

use DesignBeat\Matchers\CSV\CsvReader;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// Read all lines
test(function () {
    $reader = new CsvReader(__DIR__ . '/files/fixtures.csv');

    Assert::equal([
        ['Milan', 'Sulc', 'HK', '123456', 'foo'],
        ['John', 'Doe', 'Doens', '111111', 'bar'],
    ], $reader->read());
});

// Read single lines
test(function () {
    $reader = new CsvReader(__DIR__ . '/files/fixtures.csv');

    Assert::equal(['Milan', 'Sulc', 'HK', '123456', 'foo'], $reader->readLine());
    Assert::equal(['John', 'Doe', 'Doens', '111111', 'bar'], $reader->readLine());
    Assert::false($reader->readLine());
});

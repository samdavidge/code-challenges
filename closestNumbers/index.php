<?php

include 'ClosestNumbers.php';

$closestNumbers = new ClosestNumbers\ClosestNumbers(1000000, 2147483647);

echo 'Pair(s): ' . $closestNumbers->getClosestPairs(), PHP_EOL;

echo 'Time: ' . (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), PHP_EOL;
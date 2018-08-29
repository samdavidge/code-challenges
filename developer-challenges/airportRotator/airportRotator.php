<?php

$chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ ?!@#&()|<>.:=-+*/0123456789');

$start = 'LONDON HEATHROW';
$end = 'SAN FRANCISCO INTERNATIONAL';

$startLen = strlen($start);
$endLen = strlen($end);

$loopCount = $startLen > $endLen ? $startLen : $endLen;

echo PHP_EOL . $start . "\r";

for ($i = 0; $i < $loopCount; $i++) {

  $currentChar = isset($start[$i]) ? $start[$i] : ' ';
  $targetChar = isset($end[$i]) ? $end[$i] : ' ';

  $currentPos = array_search($currentChar, $chars);

  while ($currentChar !== $targetChar) {

    $currentPos = $currentPos <= 52 ? $currentPos+1 : 0;

    $currentChar = $chars[$currentPos];

    $start[$i] = $currentChar;

    echo $start . "\r";

    usleep(12500);

  }

}

echo $start . PHP_EOL . PHP_EOL;

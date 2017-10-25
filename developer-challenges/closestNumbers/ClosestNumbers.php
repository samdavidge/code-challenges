<?php

namespace ClosestNumbers;

class ClosestNumbers
{

  private $arraySize;
  private $values = array();
  private $smallestDifference;
  private $closestPairs = array();
  private $maxNumber;

  public function __construct($arraySize, $maxNumber)
  {

    $this->arraySize = $arraySize;
    $this->maxNumber = $maxNumber;
    $this->smallestDifference = ($maxNumber + 1);
    $this->generateArray();

  }

  public function getClosestPairs ()
  {

    foreach ($this->values as $key => $value) {

      foreach ($this->values as $compareKey => $compareValue) {

        if ($key === $compareKey) continue;

        $difference = abs($value - $compareValue);

        if ($difference > $this->smallestDifference) continue;

        if ($difference !== $this->smallestDifference) $this->closestPairs = array();

        $this->smallestDifference = $difference;

        array_push($this->closestPairs, [
          'firstValue'  => $value,
          'secondValue' => $compareValue,
          'difference'  => $difference
        ]);

      }

    }

    return $this->formatResults();

  }

  private function formatResults ()
  {

    $result = '';

    foreach ($this->closestPairs as $pair) {
      $result .= $pair['firstValue'] . ' and ' . $pair['secondValue'] . ' (diff ' . $pair['difference'] . ') ';
    }

    return $result;

  }

  private function generateArray ()
  {

    for ($i = 1; $i <= $this->arraySize; $i++) {

      array_push($this->values, rand(0, $this->maxNumber));

    }

  }

}

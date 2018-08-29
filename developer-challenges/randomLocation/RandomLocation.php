<?php

class RandomLocation {

  private $lat;
  private $long;

  private function getDate () : String {
    $date = new DateTime();
    return $date->format('Y-m-d-H:i:s');
  }

  private function splitStringInFour (String $string) : array {
    // Work out a quarter of the string length
    $quarter = (int) ((strlen($string) / 4));
    $quarters = [];
    // Split the string into 4 equal parts
    for($i=0;$i<4;$i++){
      $quarters[] = substr($string, $quarter*$i, $quarter);
    }
    return $quarters;
  }

  private function generateRandomLatLong () {
    $string = md5($this->getDate());
    $quarters = $this->splitStringInFour($string);
    $lat = rand(-89, 89) . '.' . (hexdec($quarters[0]) + hexdec($quarters[2]));
    $long = rand(-179, 179) . '.' . (hexdec($quarters[1]) + hexdec($quarters[3]));
    $this->lat = $lat;
    $this->long = $long;
  }

  public function getLatLong () : String {
    $this->generateRandomLatLong();
    return $this->lat . ', ' . $this->long;
  }

}

$randomLocation = new RandomLocation();

echo $randomLocation->getLatLong();
echo PHP_EOL;

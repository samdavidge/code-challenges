<?php

namespace NameScore;

/**
 * Class NameScore
 * @package NameScore
 */
class NameScore {

    //Attributes
    private $alphabet;
    private $names;
    private $score;

    /**
     * __construct()
     *
     * NameScore constructor.
     * @param String $fileName
     */
    public function __construct(String $fileName)
    {

        $this->alphabet = array_flip(range('a', 'z'));

        $file = fopen($fileName, 'r');

        $this->names = fread($file, filesize($fileName));

        $this->names = str_replace(array('"', ' '), '', $this->names);

        $this->names = explode(',', $this->names);

        sort($this->names);

    }

    /**
     * addNameToscore()
     *
     * @param String $name
     * @param int $key
     */
    private function addNameToScore (String $name, int $key) {

        $nameValue = 0;

        $letters = str_split($name);

        foreach ($letters as $letter) {

            $nameValue += $this->alphabet[strtolower($letter)] + 1;

        }

        $this->score += $nameValue * ($key + 1);

    }

    /**
     * getscore()
     *
     * @return int
     */
    public function getScore () : int {

        array_walk($this->names, array($this, 'addNameToScore'));

        return $this->score;

    }

}

$nameScore = new NameScore('names.txt');

echo PHP_EOL;
echo 'Value:    ' . $nameScore->getscore() . PHP_EOL;
echo 'Time:     ' . (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), PHP_EOL;
echo PHP_EOL;
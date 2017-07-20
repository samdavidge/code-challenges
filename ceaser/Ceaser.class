<?php

namespace Ceaser;

class Ceaser {


    //Attributes
    private $alphabet;

    //Construct
    public function __construct()
    {
        $this->alphabet = range('a', 'z');
    }


    //Methods
    public function encrypt(string $message, int $offset)
    {

        $encrypted = '';

        foreach (str_split($message) as $character) {

            if (is_numeric($position = array_search(strtolower($character), $this->alphabet)) ) {

                $encrypted .= ($newPos = $position + $offset) < 26 ? $this->alphabet[$newPos] : $this->alphabet[abs(25 - ($position + $offset)) - 1];

            } else {

                $encrypted .= $character;

            }

        }

        return $encrypted;
    }


    public function decrypt (string $message, int $offset)
    {

        $decrypted = '';

        foreach (str_split($message) as $character) {

            if (is_numeric($position = array_search($character, $this->alphabet)) ) {

                $decrypted .= ($newPos = $position - $offset) >= 0  ? $this->alphabet[$newPos] : $this->alphabet[26 - abs($newPos)];

            } else {

                $decrypted .= $character;

            }

        }

        return $decrypted;

    }

}
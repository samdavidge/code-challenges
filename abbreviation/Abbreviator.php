<?php

namespace Abbreviation;

class Abbreviator
{

    private $sentence;
    private $newSentence;

    public function __construct($sentence)
    {
        $this->sentence = $sentence === '' ? 'You forgot to provide a sentence' : $sentence;
    }

    public function main ($action)
    {

        foreach($words = explode(' ', $this->sentence) as $key => $word){

            $length = strlen($word);

            $firstAlphabetic = $this->isAlpabetic($word[0]);
            $lastAlphabetic = $this->isAlpabetic($word[$length - 1]);

            if($firstAlphabetic !== TRUE) {

                $word = substr($word, 1, $length);
                $length -= 1;

            };

            if($lastAlphabetic !== TRUE) {

                $word = substr($word, 0, $length - 1);
                $length -= 1;

            };

            if ($length > 2) {

                $word = $action === 'shuffle' ? $this->shuffle($word, $length) : $this->replace($word, $length);

            }

            if ($firstAlphabetic !== TRUE || $lastAlphabetic !== TRUE) {

                $word = ($addCharacter = $firstAlphabetic !== TRUE ? $firstAlphabetic : '') . $word;
                $word .= $lastAlphabetic !== TRUE ? $lastAlphabetic : '';

            }

            $words[$key] = $word;

        }

        $this->newSentence = implode(' ', $words);

        return $this->newSentence;

    }

    private function isAlpabetic ($character)
    {

        return preg_match("/^[a-zA-Z]$/", $character) ? TRUE : $character;

    }

    private function replace ($word, $length)
    {

        return $word[0] . ($length - 2) . $word[$length - 1];

    }

    private function shuffle ($word, $length)
    {

        $originalCharacters = str_split($word);

        $shuffledCharacters = array_slice($originalCharacters, 1, -1);

        shuffle($shuffledCharacters);

        return $originalCharacters[0] . implode($shuffledCharacters) . $originalCharacters[$length - 1];

    }

}
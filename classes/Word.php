<?php

class Word
{
    public $word; // the actual word
    public $id; // db id
    public $length;
    public $firstLetter;
    public $lastLetter;
    public $letterList;

    /**
     * Word constructor.
     *
     * @param null $word
     * @param $id
     */
    public function __construct($word, $id = '')
    {
        $this->word = $word;
        $this->id = $id;
        $this->calculateAttributes();
    }

    /**
     * Randomly selects a word from database.
     *
     * @param DB $db
     * @return Word
     */
    public static function selectRandom(DB $db) {
        $wordList = $db->selectAll('words');
        $randomWord = $wordList[array_rand($wordList)];
        return new Word($randomWord->word, $randomWord->id); // map to Word class
    }

    /**
     * Calculates word's attributes.
     */
    private function calculateAttributes() {
        $this->letterList = mb_str_split($this->word);
        $this->length = mb_strlen($this->word, 'UTF-8');
        $this->firstLetter = $this->letterList[0];
        $this->lastLetter = $this->letterList[$this->length - 1];
    }
}

<?php

class Game
{
    public $score = 100;
    public $triedLetters = [];
    public $wrongTries = 0;
    public $life = 100;
    private $maxWrongTries = 8;
    private $drawnWord = [];
    public $word;
    public $player;

    /**
     * Game constructor.
     * Assigns game's player and word
     *
     * @param User $player
     * @param Word $word
     */
    public function __construct(User $player, Word $word)
    {
        $this->player = $player;
        $this->word = $word;
    }

    /**
     * Generates the word with underscores according to player's guesses.
     */
    public function drawWord()
    {
        foreach ($this->word->letterList as $letter) {
            if (in_array($letter, $this->triedLetters)
                || $letter === $this->word->firstLetter
                || $letter === $this->word->lastLetter) {
                echo $letter;
                $this->drawnWord[] = $letter;
            }
            else {
                echo '_ ';
                $this->drawnWord[] = '_';
            }
        }
    }

    /**
     * Checks if game is won.
     *
     * @return bool
     */
    public function isWon()
    {
        // if drawn word has not any '_', then the game is won.
        return in_array('_', $this->drawnWord) ? false : true;
    }

    /**
     * Checks if game is lost.
     *
     * @return bool
     */
    public function isLost() {
        return $this->wrongTries >= $this->maxWrongTries ? true : false;
    }

    /**
     * Calculates score
     */
    private function calculateScore() {
        if ($this->isLost()) {
            $this->score = 0;
        }
        else {
            $this->score -= 10;
        }
    }

    /**
     * Calculates life remaining as a percentage of wrong tries left.
     */
    public function calculateLife() {
        $this->life = (int) round(($this->maxWrongTries - $this->wrongTries) / $this->maxWrongTries * 100);
    }

    /**
     * Guesses a letter. If letter already tried or given throws Exception. If it is wrong, depletes score
     * and increments wrongTries.
     *
     * @param $letter
     * @throws Exception
     */
    public function guessLetter($letter)
    {
        $letter = mb_strtoupper($letter);

        // if already tried throw an exception
        if(in_array($letter, $this->triedLetters)) {
            throw new Exception('Letter already tried!');
        }

        // if it is the first or last letter throw exception
        if($letter === $this->word->firstLetter || $letter === $this->word->lastLetter) {
            throw new Exception('Letter already given as first or last!');
        }

        //  else push it to the list
        $this->triedLetters[] = $letter;

        // and update score and wrongTries
        if (!in_array($letter, $this->word->letterList)) {
            $this->wrongTries += 1;
            $this->calculateLife();
            $this->calculateScore();
        }
    }
}

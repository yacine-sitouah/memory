
<?php

class Card {
    private $id;
    private $value;
    private $isMatched;

    public function __construct($id, $value) {
        $this->id = $id;
        $this->value = $value;
        $this->isMatched = false;
    }

    public function getId() {
        return $this->id;
    }

    public function getValue() {
        return $this->value;
    }

    public function setMatched($matched) {
        $this->isMatched = $matched;
    }

    public function isMatched() {
        return $this->isMatched;
    }
}

class Deck {
    private $cards = [];

    public function __construct($numPairs) {
        $this->generateDeck($numPairs);
    }

    private function generateDeck($numPairs) {
        for ($i = 1; $i <= $numPairs; $i++) {
            $this->cards[] = new Card($i, "Image $i");
            $this->cards[] = new Card($i + $numPairs, "Image $i");
        }
        shuffle($this->cards);
    }

    public function getCards() {
        return $this->cards;
    }
}

class Player {
    private $name;
    private $scores = [];

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function addScore($score) {
        $this->scores[] = $score;
    }

    public function getBestScore() {
        return ($this->scores);
    }

    public function getScores() {
        return $this->scores;
    }
}


class Game {
    private $players = [];
    private $deck;
    private $currentPlayer;

    public function __construct($numPairs, $playerNames) {
        $this->deck = new Deck($numPairs);
        foreach ($playerNames as $name) {
            $this->players[] = new Player($name);
        }
        $this->currentPlayer = 0;
    }

    public function play() {
        // Code to handle the game logic
    }

    public function switchPlayer() {
        $this->currentPlayer = ($this->currentPlayer + 1) % count($this->players);
    }

    public function getCurrentPlayer() {
        return $this->players[$this->currentPlayer];
    }

    public function getDeck() {
        return $this->deck->getCards();
    }

    public function addScoreToCurrentPlayer($score) {
        $this->players[$this->currentPlayer]->addScore($score);
    }

    public function getLeaderboard() {
        usort($this->players, function($a, $b) {
            return $a->getBestScore() <=> $b->getBestScore();
        });
        return array_slice($this->players, 0, 10);
    }
}


class Leaderboard {
    private $topScores = [];

    public function addScore($player, $score) {
        $this->topScores[] = ['player' => $player, 'score' => $score];
        usort($this->topScores, function($a, $b) {
            return $a['score'] <=> $b['score'];
        });

        if (count($this->topScores) > 10) {
            array_pop($this->topScores);
        }
    }

    public function getTopScores() {
        return $this->topScores;
    }
}


$game = new Game(6, ['Alice', 'Bob']);
$game->play();

// Afficher le leaderboard
$leaderboard = $game->getLeaderboard();



?> 
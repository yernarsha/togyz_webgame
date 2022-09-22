<?php

const NUM_KUMALAKS = 9;
const DRAW_GAME = NUM_KUMALAKS * NUM_KUMALAKS;
const TOTAL_KUMALAKS = DRAW_GAME * 2;
const TUZD = -1;

class TogyzBoard {
    private $finished = false;
    private $gameResult = -2;
    private $fields = [];
    private $moves = [];

    function __construct($boardstr = '') {
        if ($boardstr === '') {
            for ($i = 0; $i < 23; $i++) {
                if ($i < 18) {
                    array_push($this->fields, NUM_KUMALAKS);
                } else {
                    array_push($this->fields, 0);
                }
            }
        } else {
            $board = explode(',', $boardstr);
            for ($i = 0; $i < 23; $i++) {
                array_push($this->fields, intval($board[$i]));
            }
        }
    }

    function checkPosition() {
        $color = $this->fields[22];
        $numWhite = 0;
        for ($i = 0; $i < 9; $i++) {
            if ($this->fields[$i] > 0) {
                $numWhite += $this->fields[$i];
            }
        }

        $numBlack = TOTAL_KUMALAKS - $numWhite - $this->fields[20] - $this->fields[21];

        if (($color == 0) && ($numWhite == 0)) {
            $this->fields[21] += $numBlack;
        } else if (($color == 1) && ($numBlack == 0)) {
            $this->fields[20] += $numWhite;
        }

        if ($this->fields[20] > DRAW_GAME) {
            $this->finished = true;
            $this->gameResult = 1;
        } elseif ($this->fields[21] > DRAW_GAME) {
            $this->finished = true;
            $this->gameResult = -1;
        } elseif (($this->fields[20] == DRAW_GAME) && ($this->fields[21] == DRAW_GAME)) {
            $this->finished = true;
            $this->gameResult = 0;
        }
    }

    function makeMove($move) {
        $tuzdCaptured = false;
        $color = $this->fields[22];
        $madeMove = strval($move);

        $move = $move + ($color * 9) - 1;
        $num = $this->fields[$move];

        if (($num == 0) || ($num == TUZD)) {
            return "";
        }

        if ($num == 1)
        {
            $this->fields[$move] = 0;
            $sow = 1;
        }
        else
        {
            $this->fields[$move] = 1;
            $sow = $num - 1;
        }

        $num = $move;
        for ($i = 1; $i <= $sow; $i++) {
            $num += 1;
            if ($num > 17) {
                $num = 0;
            }

            if ($this->fields[$num] == TUZD) {
                if ($num < 9) {
                    $this->fields[21] += 1;
                } else {
                    $this->fields[20] += 1;
                }
            } else {
                $this->fields[$num] += 1;
            }
        }

        if ($this->fields[$num] % 2 == 0) {
            if (($color == 0) && ($num > 8)) {
                $this->fields[20] += $this->fields[$num];
                $this->fields[$num] = 0;
            } elseif (($color == 1) && ($num < 9)) {
                $this->fields[21] += $this->fields[$num];
                $this->fields[$num] = 0;
            }
        } elseif ($this->fields[$num] == 3) {
            if (($color == 0) && ($this->fields[18] == 0) && ($num > 8) && ($num < 17) && ($this->fields[19] != $num - 8)) {
                $this->fields[18] = $num - 8;
                $this->fields[$num] = TUZD;
                $this->fields[20] += 3;
                $tuzdCaptured = true;
            } elseif (($color == 1) && ($this->fields[19] == 0) && ($num < 8) && ($this->fields[18] != $num + 1)) {
                $this->fields[19] = $num + 1;
                $this->fields[$num] = TUZD;
                $this->fields[21] += 3;
                $tuzdCaptured = true;
            }
        }

        $this->fields[22] = ($color == 0) ? 1 : 0;

        if ($num < 9)
        {
            $num = $num + 1;
        }
        else
        {
            $num = $num - 8;
        }

        $madeMove = $madeMove . $num;
        if ($tuzdCaptured)
        {
            $madeMove = $madeMove . "x";
        }

        array_push($this->moves, $madeMove);
        $this->checkPosition();
        return $madeMove;
    }

    function makeRandomMove() {
        $possible = [];
        $color = $this->fields[22];

        for ($i = 1; $i <= 9; $i++) {
            $move = $i + ($color * 9) - 1;

            if ($this->fields[$move] > 0) {
                array_push($possible, $i);
            }
        }

        $movesCount = count($possible);

        if ($movesCount == 0) {
            return "";
        }

        if ($movesCount == 1) {
            $randomIndex = 0;
        } else {
            $randomIndex = rand(0, $movesCount - 1);
        }

        $randMove = $possible[$randomIndex];
        $madeMove = $this->makeMove($randMove);
        return $madeMove;
    }

    function getPos() {
        return $this->fields;
    }

    function isGameFinished() {
        return $this->finished;
    }
}

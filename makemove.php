<?php
session_start();

require "tog.php";

$move = intval($_POST['move']);

if (($move >= 1) && ($move <= 9)) {
    $tBoard = new TogyzBoard($_SESSION['board']);

    $human = $tBoard->makeMove($move);
    if (!empty($human)) {
        $_SESSION['moves'] .= $human . ',';

        if (!$tBoard->isGameFinished()) {
            $ai = $tBoard->makeRandomMove();
            $_SESSION['moves'] .= $ai . ',';
        }

        $_SESSION['board'] = implode(',', $tBoard->getPos());
    }
}

header('Location: index.php');
<?php
session_start();
unset($_SESSION['board']);

header('Location: index.php');
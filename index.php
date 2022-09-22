<?php
session_start();

if (isset($_SESSION['board'])) {
    $board = explode(',', $_SESSION['board']);
} else {
    $_SESSION['moves'] = '';
    $_SESSION['board'] = '9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,9,0,0,0,0,0';
    $board = explode(',', $_SESSION['board']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Togyz Kumalak Webgame</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<h3>Togyz Kumalak: play against random AI</h3>

<form method="post" action="newgame.php">
    <button name="newgame" value="newgame">New game</button>
</form>

<div id="board">
    <?php
    $html = "<table border='1' cellspacing='3' height='300'>";
    $html .= "<tr class='numbering'>";
    $html .= "<td class='kazan' rowspan='4'>" . $board[21] . "</td>";
    for ($i = 9; $i > 0; $i--)
        $html .= "<td>" . $i . "</td>";
    $html .= "<td class='kazan' rowspan='4'>" . $board[20] . "</td>";
    $html .= "</tr>";

    $html .= "<tr class='otau'>";
    for ($i = 17; $i > 8; $i--)
        if ($board[$i] == -1)
            $html .= "<td onclick='click_otau(" . $i . "); '>" . "X</td>";
        else
            $html .= "<td onclick='click_otau(" . $i . "); '>" . $board[$i] . "</td>";

    $html .= "</tr>";

    $html .= "<tr class='otau'>";
    for ($i = 0; $i < 9; $i++)
        if ($board[$i] == -1)
            $html .= "<td onclick='click_otau(" . $i . "); '>" . "X</td>";
        else
            $html .= "<td onclick='click_otau(" . $i . "); '>" . $board[$i] . "</td>";
    $html .= "</tr>";

    $html .= "<tr class='numbering'>";
    for ($i = 1; $i < 10; $i++)
        $html .= "<td>" . $i . "</td>";
    $html .= "</tr>";
    $html .= "</table>";
    echo $html;
    ?>
</div>

<form method="post" action="makemove.php">
    <input type="text" name="move" placeholder="Enter your move">
    <button name="sendmove" value="sendmove">Send move</button>
</form><br>

<p>
<?php
echo $board[22] == 0 ? 'White turn' : 'Black turn';
?>
</p>

<div id="moves">
    <?php
    echo empty($_SESSION['moves']) ? 'Moves' : $_SESSION['moves'];
    ?>
</div>

</body>
</html>
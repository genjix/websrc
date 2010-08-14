<?php header("Content-type: text/html");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta name="author" content="Genjix" />
  <meta name="keywords" content="nobody" />
  <meta name="description" content="none" />
  <meta name="robots" content="all" />

  <title>genjix</title>

  <script type="text/javascript">
<?php
function getPosition($pos)
{
    switch ($pos) {
        case 0:
            return "UTG";
        case 1:
            return "UTG+1";
        case 2:
            return "4off";
        case 3:
            return "3off";
        case 4:
            return "HJ";
        case 5:
            return "CO";
        case 6:
            return "BTN";
        case 7:
            return "SB";
        default:
            return "Invalid Position";
    }
}
function getCardValue($v)
{
    switch($v) {
        case 2:
            return "2";
        case 3:
            return "3";
        case 4:
            return "4";
        case 5:
            return "5";
        case 6:
            return "6";
        case 7:
            return "7";
        case 8:
            return "8";
        case 9:
            return "9";
        case 10:
            return "T";
        case 11:
            return "J";
        case 12:
            return "Q";
        case 13:
            return "K";
        case 14:
            return "A";
        default:
            return "Invalid Card";
    }
}
function getCardDiz($s)
{
    switch($s) {
        case "2":
            return 2;
        case "3":
            return 3;
        case "4":
            return 4;
        case "5":
            return 5;
        case "6":
            return 6;
        case "7":
            return 7;
        case "8":
            return 8;
        case "9":
            return 9;
        case "T":
            return 10;
        case "J":
            return 11;
        case "Q":
            return 12;
        case "K":
            return 13;
        case "A":
            return 14;
        default:
            return "Invalid Card";
    }
}
function getSuit($s)
{
    switch($s) {
        case 0:
            return "d";
        case 1:
            return "c";
        case 2:
            return "s";
        case 3:
            return "h";
        default:
            return "Invalid Suit";
    }
}

$pos = rand(0,7);
$mnum = rand(3,8);
$card1 = rand(2,14);
$suit1 = rand(0,3);
$card2 = rand(2,14);
$suit2 = rand(0,3);

/*$pos = 0;
$mnum = 4;
$card1 = 2;
$suit1 = 1;
$card2 = 2;
$suit2 = 0;*/

$hicard = -1;
$locard = -1;
if ($card2 > $card1) {
   $hicard = $card2;
   $locard = $card1;
}
else {
   $hicard = $card1;
   $locard = $card2;
}
//$hicard = getCardValue($hicard);
//$locard = getCardValue($locard);

$offsuit = 1;
if ($suit1 == $suit2)
    $offsuit = 0;
$pp = 0;
if ($hicard == $locard)
    $pp = 1;

$handle = @fopen("hands", "r");
$pushHand = 0;
$toggle = 0;
$skilloop = 0;
$debug = "";
if ($handle)
{
  while (!feof($handle))
  {
    $buffer = trim(fgets($handle, 4096));
    if ($buffer[0] == "M") {
        if ($skilloop == 1)
            break;
        if ($buffer[1] != $mnum)
            $toggle = 1;
        else {
            $toggle = 0;
            $skilloop = 1;
        }
    }
    if ($toggle == 1)
        continue;

    $ranges = split(", ", $buffer);
    if (count($ranges) == 0)
        continue;

    if ($ranges[0] == getPosition($pos)) {
        $ranges = array_slice($ranges, 1);
        foreach($ranges as $h) {
            $h = trim($h);
            if ($h[0] == $h[1] and $pp == 1 and $hicard >= getCardDiz($h[0])) {
                $pushHand = 1;
                //$debug = $h[3];
                break;
            }
            if (strlen($h) == 4)
            {
                if ($h[2] == "o" and $offsuit == 1) {
                    if (getCardDiz($h[0]) == $hicard and $locard >= getCardDiz($h[1])) {
                        $pushHand = 1;
                        $debug = $hicard;
                        break;
                    }
                }
                else if ($h[2] == "s" and $offsuit == 0) {
                    if (getCardDiz($h[0]) == $hicard and $locard >= getCardDiz($h[1])) {
                        $pushHand = 1;
                        break;
                    }
                }
            }
            else if (strlen($h) == 3 and $h[2] == "+")
            {
                if (getCardDiz($h[0]) == $hicard and $locard >= getCardDiz($h[1])) {
                    $pushHand = 1;
                    break;
                }
            }
            else if (strlen($h) == 3 and $h[2] == "s")
            {
                if (getCardDiz($h[0]) == $hicard and $locard == getCardDiz($h[1]) and $offsuit == 0) {
                    $pushHand = 1;
                    break;
                }
            }
            else if (strlen($h) == 3 and $h[2] == "o")
            {
                if (getCardDiz($h[0]) == $hicard and $locard == getCardDiz($h[1]) and $offsuit == 1) {
                    $pushHand = 1;
                    break;
                }
            }
        }
    }
  }
  fclose($handle);
}

$push = $pushHand;
$fold = 1 - $push;
$push++;
$fold++;

$total = $_GET["total"];
$total1up = $total + 1;
$win = $_GET["win"];
if ($_GET["win"] == 0)
    $win = 0;
if ($_GET["corr"] == 2)
    $win++;

echo "function push()
{
    location.href = \"index.php?corr=$push&win=$win&total=$total1up\";
}
function fold()
{
    location.href = \"index.php?corr=$fold&win=$win&total=$total1up\";
}";
echo "  </script>";
if ($_GET["corr"] == 2)
    echo "<p>Correct";
else if ($_GET["corr"] == 1)
    echo "<p>Incorrect";
if ($_GET["corr"] != 0)
    echo " <i>$win / $total</i></p>";
echo "<p><img src=\"http://www.liquidpoker.net/images/cards/", getCardValue($card1), getSuit($suit1), "_color.gif\" />";
echo " <img src=\"http://www.liquidpoker.net/images/cards/", getCardValue($card2), getSuit($suit2), "_color.gif\" /></p>";
echo "<p>m = $mnum</p>";
echo "<p><b>", getPosition($pos), "</b></p>";

/*if ($pushHand == 1)
    echo "Push!";
else
    echo "Fold!";*/

/*for($x = 14; $x >= 2; $x--) {
    echo "<p>";
    for($y = 14; $y >= 2; $y--) {
        if ($x < $y)
            echo getCardValue($y), getCardValue($x), "o";
        else
            echo getCardValue($x), getCardValue($y), "s";
        echo "  ";
    }
    echo "</p>";
}*/
//echo $debug;

?>
</head>

<body>

<form action="answer.php" method="post">
    <input type="button" value="Push" onclick="push();" />
    <input type="button" value="Fold" onclick="fold();" />
</form>

</body>

<?
srand(time());
$random = rand(0,3);
switch ($random)
{
  case 0:
    echo "images/site/eq.gif";
    break;
  case 1:
    echo "images/site/eq1.gif";
    break;
  case 2:
    echo "images/site/eq2.gif";
    break;
  case 3:
    echo "images/site/eq3.gif";
    break;
}
?>

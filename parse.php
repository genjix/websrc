<?php

function DoGallery($handle)
{
  echo "<p><table>\n  <tr>\n";
  $item = 0;
  while (!feof($handle))
  {
    $buffer = trim(fgets($handle, 4096));
    if ($buffer == "")
      break;
    echo preg_replace("/(^.*)\\.(.*)$/", '    <td><a href="\1.\2" target="_blank"><img src="\1_thumb.\2" /></a></td>', $buffer);
    echo "\n";
    #echo "    <td><img src=\"$buffer\" /></td>\n";
    if ($item >= 1)
    {
      echo "  </tr>\n";
      $item = -1;
    }
    $item = $item + 1;
  }
  echo "</table></p>\n";
}

$page = $_GET["page"];
$file = "articles/$page";
$handle = @fopen($file, "r");
$title = false;
$descrip = false;
$utube = "http://www.youtube.com/";
if ($handle)
{
  while (!feof($handle))
  {
    $buffer = trim(fgets($handle, 4096));
    $buf4utube = substr($buffer, 0, strlen($utube));
    if ($buffer == "")
    {
    }
    else if (!$title)
    {
      $title = $buffer;
      //echo "<p>title = $title</p>";
    }
    else if (!$descrip)
    {
      $descrip = $buffer;
      //echo "<p>descrip = $descrip</p>";
    }
    else if (substr($buffer,0,1-strlen($buffer)) == "-")
    {
      $buffer = substr($buffer, 1);
      echo "<h3>$buffer</h3>\n";
    }
    else if ($buffer == "[gallery]")
    {
      DoGallery($handle);
    }
    else if ($buf4utube == $utube)
    {
      echo "<p><object class=\"youtube\" width=\"425\" height=\"344\"><param name=\"movie\" value=\"$buffer\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"$buffer\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object></p>";
    }
    else
    {
      $buffer = preg_replace('/\*([^]]+)\*/', '<b class="under">\\1</b>', $buffer);
      $buffer = preg_replace('/\\{[R]([^]]+)[.](.*)\}/U', '<a href="\1.\2" target="_blank"><img class="right" src="\1_thumb.\2" /></a>', $buffer);
      $buffer = preg_replace('/\\{([^]]+)[.](.*)\}/U', '<a href="\1.\2" target="_blank"><img src="\1_thumb.\2" /></a>', $buffer);
      $buffer = preg_replace('/\[([^]]+)\|([^]]+)\]/', '<a href="\\1">\\2</a>', $buffer);
      echo "<p>$buffer</p>\n";
    }
  }
  fclose($handle);
}
?>

<div id="footer">
  <a href="email:genjix@gmail.com">contact</a> &nbsp;
  <a href="http://creativecommons.org/licenses/by-nc-sa/1.0/" title="View details of the license of this site, courtesy of Creative Commons.">cc</a>
</div>

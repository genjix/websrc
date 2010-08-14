<?php
if ($handle = opendir('articles'))
{
    // read directory into array
    $dir_array = array();
    while($lyric_file = readdir($handle)) {
        //if(is_file("/var/ww/html/$lyric_file")) {
            $dir_array[] = $lyric_file;
        //}
    }
    closedir($handle);

    // sort the array
    sort($dir_array);

    $artlist = array();

  //while (false !== ($file = readdir($handle)))
  foreach ($dir_array as $file)
  {
    if ($file != "." && $file != "..")
    {
      $filename = "articles/$file";
      $fh = @fopen($filename, "r");
      $title = false;
      $descrip = false;

      if ($fh)
      {
    while (!feof($fh))
    {
      $buffer = trim(fgets($fh, 4096));
      if ($buffer == "")
      {
      }
      else if (!$title)
        $title = $buffer;
      else if (!$descrip)
      {
        $descrip = $buffer;
        break;
      }
    }
    if ($title != "!hidden")
    {
        $artlist[] = $file;
      echo "\t  <li><a href=\"#$file\">$title</a><b>$descrip</b></li>\n";
    }

    fclose($fh);
      }
    }
  }
}
?>

<script type="text/javascript">
function NextArticle()
{
    switch(location.hash.substr(1))
    {
<?php
    for($i = 0; $i < count($artlist); $i++) {
        $nexti = $i + 1;
        if ($nexti == count($artlist)) {
            $nexti = 0;
        }
        echo "        case \"{$artlist[$i]}\":\n";
        echo "            Load(\"{$artlist[$nexti]}\");\n";
        echo "            break;\n";
    }
echo "        default:\n";
echo "            Load(\"{$artlist[0]}\");\n";
echo "            break;\n";
?>
    }
}

function PreviousArticle()
{
    switch(location.hash.substr(1))
    {
<?php
    for($i = 0; $i < count($artlist); $i++) {
        $nexti = $i - 1;
        if ($nexti < 0) {
            $nexti = count($artlist) - 1;
        }
        echo "        case \"{$artlist[$i]}\":\n";
        echo "            Load(\"{$artlist[$nexti]}\");\n";
        echo "            break;\n";
    }
echo "        default:\n";
echo "            Load(\"{$artlist[0]}\");\n";
echo "            break;\n";
?>
    }
}
</script>

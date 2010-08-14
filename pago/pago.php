<h3>pages</h3>

<?php
function RemoveExtension($strName)  
{  
     $ext = strrchr($strName, '.');  

     if($ext !== false)  
     {  
         $strName = substr($strName, 0, -strlen($ext));  
     }  
     return $strName;  
}

if ($handle = opendir('.'))
{
?>
<p><table>
<?php
    $dir_array = array();
    while($lyric_file = readdir($handle)) {
        $dir_array[] = $lyric_file;
    }
    closedir($handle);
    sort($dir_array);
    $step = 0;
    foreach ($dir_array as $file) {
        if ($ext = substr(strrchr($file, '.'), 1) != "jpg") 
            continue;
        if ($step == 0)
            echo "  <tr>\n";
        $art = RemoveExtension($file);
        echo "    <td><a href=\"#$art\"><img src=\"pago/$file\" /></a></td>\n";
        $step++;
        if ($step >= 2) {
            echo "  </tr>\n";
            $step = 0;
        }
    }
    if ($step < 2 && $step != 0)
        echo "  </tr>\n";
}
?>
</table></p>

<div id="footer">
  <a href="email:genjix@gmail.com">contact</a> &nbsp;
  <a href="http://creativecommons.org/licenses/by-nc-sa/1.0/" title="View details of the license of this site, courtesy of Creative Commons.">cc</a>
</div>

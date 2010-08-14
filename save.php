<?php 
$content = $_POST['content']; 
$file = "articles/uberman"; 
$Saved_File = fopen($file, 'w'); 
fwrite($Saved_File, $content); 
fclose($Saved_File); 
?>
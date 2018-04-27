<?php
$fileName = $_REQUEST["fileName"];
header('Last-Modified: '.
gmdate('D, d M Y H:i:s', filemtime($fileName)).' GMT');

if ($_SERVER["REQUEST_METHOD"] != "HEAD") {
   header('Content-Type: text/xml');
   $myFile = fopen($fileName, "r");
   $contents = "";
   while (feof($myFile) == FALSE) {
     $contents = $contents . fgets($myFile);
    }
  fclose($myFile);
  print $contents;
}
?>
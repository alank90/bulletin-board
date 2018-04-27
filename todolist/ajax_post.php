<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$fileName = $_POST["file_Name"];
echo $fileName;
header('Last-Modified: '. gmdate('D, d M Y H:i:s', filemtime($fileName)) . ' GMT');
if ($_SERVER["REQUEST_METHOD"] != "HEAD") {
   $myFile = fopen($fileName, "r");
   $contents = "";
   while (feof($myFile) == FALSE) {
   $contents = $contents . fgets($myFile);
   }
   fclose($myFile);
   print $contents;
   
 }
 
?>
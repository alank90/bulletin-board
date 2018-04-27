<?php

$fileName = $_REQUEST["fileName"];
$contents = $_REQUEST["contents"];
$myFile = fopen($fileName, "w");
$success = fwrite($myFile, stripslashes($contents));

fclose($myFile);
if ($success == TRUE) {
  print "success";
} 
else {
  print "failure";
}
?>
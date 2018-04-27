<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Clear Done Items</title>
</head>

<body>
<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

$xml_cookie = $_COOKIE['user'];

$xml_file_name = $xml_cookie . ".xml";

    /* Here we will use the The DOMDocument class functions to delete 
       the text nodes.*/
    
     //Format XML to save indented tree rather than one line
$domxml = new DOMDocument('1.0');

if ($domxml->load($xml_file_name) === TRUE) {
$domxml->preserveWhiteSpace = false;
$domxml->formatOutput = true;

// Start Delete process of node
echo "<br>";

$xpath = new DOMXPath($domxml);
// Here we use the The DOMXPath class function evaluate to do the heavy lifting.

foreach ($xpath->evaluate('//doneitems/item') as $node) {
  $node->parentNode->removeChild($node);
}

//Save XML to file - remove this and following line if save not desired
$domxml->save($xml_file_name);
echo "<strong>XML Document updated.</strong>";
 }
 
else {
echo "  <strong>Error in loading XML file:</strong>"; 
 echo "<br>";
 print_r(error_get_last()); 
  
}
  
?>

</body>

</html>



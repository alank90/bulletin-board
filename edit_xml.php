<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$searchString = 'Laura';

$doc = new DOMDocument;
$doc->preserveWhiteSpace = FALSE;
$doc->load('todolist/BookList.xml');

$xPath = new DOMXPath($doc);
$query = sprintf('//number[./contents[contains(., "%s")]]', $searchString);
foreach($xPath->query($query) as $node) {
    $node->parentNode->removeChild($node);
}
$doc->formatOutput = TRUE;
echo $doc->saveXML();
?>
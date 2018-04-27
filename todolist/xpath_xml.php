<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>XPath</title>
</head>

<body>
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
    $xml = simplexml_load_file('alan.xml');
    print_r($xml);
    echo "<br>";
    echo "<br>";

    echo "<strong>Using direct method...</strong><br />";
    $list_items = $xml->xpath('/list/doneitems/item');
    foreach($list_items as $list_item) {
        echo "Found {$list_item->number} {$list_item->contents}<br />";
    }
    echo "<br />";

    echo "<strong>Using indirect method...</strong><br />";
    $list_item = $xml->xpath('/list/doneitems/item');
    print_r($list_items);
    echo "<br>";
    foreach($list_item as $item) {
        echo "Found {$item->contents}<br />";
    }
    echo "<br />";

    echo "<strong>Using wildcard method...</strong><br />";
    $list_items = $xml->xpath('//item');
    print_r($list_items);
    echo "<br>";
    foreach($list_items as $list_item) {
        echo "Found $list_item->number $list_item->contents<br />";
    }
    echo "<br>";

    echo "<strong>Querying on Two fields...</strong>";
    $results = $xml->xpath('//item[number=2][contents="Check Chrome Cart"]');
    echo "<br>";
    print_r($results);
    foreach($results as $result)
    echo "<br>";
    if (isset($result)) {
    echo("Found {$result->number} {$result->contents}");
    }
    else {
    echo "<br>";
    echo "No items found for search criteria...";
    }
     echo "<br>";
     echo "<br>";

    echo " Changing and Outputting XML with asXML";
    $xml->item[0]->contents = "Chrome cart uptodate";
    print_r($xml);
    echo "<br>";
    echo $xml->asXML();
    
    
?>
</body>

</html>

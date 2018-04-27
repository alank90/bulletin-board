<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>SimpleXML</title>
</head>

<body>
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
    $todolists = simplexml_load_file('alan.xml');
    var_dump($todolists);
    $list_items = $todolists->xpath('/list/doneitems/item/');
    echo "<br>";
    foreach ($list_items as $item) {
        echo " Found $item<br>";
       
    }
?> </body>

</html>


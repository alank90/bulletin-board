<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>XML2 Path</title>
</head>

<body>
<?php
    $xml = simplexml_load_file('employees.xml');
    echo "\nBefore transformation:\n\n";
    echo "<br />";

    echo $xml->asXML();
    echo "<br />";

    $xml->employee[1]->age = 55;

    $employees = $xml->xpath('/employees/employee[name="Anthony Clarke"]');
    $employees[0]->title = "Chairman of the Board, Chief Information Office";

    echo "\n\nAfter transformation:\n\n";
    echo "<br />";

    echo $xml->asXML();
    $xml->save('employees.xml');
?>

</body>

</html>




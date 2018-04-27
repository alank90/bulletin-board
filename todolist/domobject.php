<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>XML2 Path</title>
</head>

<body>
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
    $simplexml = simplexml_load_file('employees.xml');
    echo "\nBefore transformation:\n\n";
    echo "<br />";

    echo    $simplexml->asXML();
    echo "<br />";

       $simplexml->employee[1]->age = 34;

    $employees = $simplexml->xpath('/employees/employee[name="Anthony Clarke"]');
    $employees[0]->title = "Chairman of the Board, Chief Information Office";

    echo "\n\nAfter transformation:\n\n";
    echo "<br />";
    
    /* Now convert employyees.xml which is currently a simpleXML object to a 
       DOMobject so we can use it functions to format and save it back to server file.*/
    
     //Format XML to save indented tree rather than one line
$domxml = new DOMDocument('1.0');
$domxml->preserveWhiteSpace = false;
$domxml->formatOutput = true;
$domxml->loadXML(   $simplexml->asXML());
//Echo XML - remove this and following line if echo not desired
echo $domxml->saveXML();
//Save XML to file - remove this and following line if save not desired
$domxml->save('employees.xml');
       
    
?>

</body>

</html>



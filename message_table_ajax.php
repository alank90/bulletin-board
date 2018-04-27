<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	// connect to db
require "dbinfo.openjs.php";

echo "Im in message.php";
require_once("grid.php");
$grid = new Grid("Messages", array(
"save"=>true,
"delete"=>true,
"select" => 'selectFunction'
));
// ****This portion is if you want to have a Drop Down menu item ****
 // if you have anonymous function support in PHP (5.3.2+) Then you can just write the
// Function above instead of creating a separate one here.
//function selectFunction($grid) {
//$selects = array();
// active select
//$selects["Brwd_Rsn"] = array("Borrowed","In for Repair","Replacement","Returned","Other");
// render data
//$grid->render($selects);
//} 
// End Drop Down

?> 
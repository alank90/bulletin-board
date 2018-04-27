<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Convert Date Page</title>
</head>

<body>
<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

$current_date = date('Y-m-d H:i:s');
echo "The date & Time in the Old Format is: " . $current_date . "<br>";

$cnvrted_date = convert_date($current_date);
echo "And the New Time is: " . $cnvrted_date;

function convert_date($dt) {
   
    $new_day =  substr($dt, 8, 2);
    $new_month = substr($dt, 5, 2);
    $new_year = substr($dt, 2, 2);
    $new_time = substr($dt, -8, 5);
    $new_hour = substr($dt, -8, 2);
        
     //Morning
    if ($new_hour < 13 && $new_hour != 12) {
         if ($new_hour < 10) {
           $new_time = substr($new_time,0,5) . " AM";
         }
         else $new_time .= " AM";
 
      //Afternoon
    } elseif ($new_hour > 12) {
         $new_time = $new_time - 12 . ':' . substr($dt, -5, 2) . " PM";
              
      //Midnight   
    } elseif  ($new_hour == 0) {
       $new_time = $new_time + 12 . ':' . substr($dt, -5, 2) . " AM";
    }
      // 12-1PM 
      else {
        $new_time .= " PM";
     }
       
    $new_date = $new_month . "/" . $new_day . "/" . $new_year .  "&nbsp" .$new_time;
    return $new_date;
} 

?>

</body>

</html>

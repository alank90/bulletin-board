<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include ("dbinfo.inc.php"); //include login info file

  //Start a PDO session to insert the form data into the MySQL Table

try
    {
      $conn=new PDO($dsn, $username,$password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch (PDOException $e)
    {
    $error_message=$e->getMessage();
    echo "<h1>Resource Unavailable. Please Contact the System Administrator</h1>";
    }
    
$prsn_from=$_POST['from_val'];
$note=$_POST['note_val'];
$non_formatted_date=date('Y-m-d H:i:s');

   // Call Date conversion function
$crnt_date = convert_date($non_formatted_date);


   //Clean input to make sure it is formatted with a leading Capital letter.
$prsn_from=ucfirst($prsn_from);

if ($prsn_from !='') { $stmt = $conn->prepare("INSERT INTO Messages SET prsn_from = :prsn_from, note = :note, crnt_date = :crnt_date");

                             
     $stmt->execute(array(
            ':prsn_from' => $prsn_from,
            ':note' => $note,
            ':crnt_date' => $crnt_date));
           
            
     //Return to Main Page.      
     $url = 'http://' . $_SERVER['HTTP_HOST'];            // Get the server
     $url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); // Get the current directory
     $url .= '/index.php';            // <-- Your relative path
     header('Location: ' . $url, true, 302);              // Use either 301 or 302 
     die();
  }
            
else {

echo '<h2>Attention. You Did Not Enter a Message. Please enter the Message</h2>';

echo '<h2>At a Minimum...</h2>';
}

/* Function To Convert from Date from MySQL format to Human Readable Format ----->
-------------------------------------------------------------------------------<*/
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
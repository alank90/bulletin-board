<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html id="bkgrd_color">
<title>Verificatio Page</title>
<head>
      <!-- Bootstrap core CSS -->
        	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
      <!-- Custom styles for this template -->
    <link href="css/styles/starter-template.css" rel="stylesheet"/>




<link rel="stylesheet" type="text/css" href="css/styles/main.css"/>
</head>

<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
session_start();

//Form input from Index.php
if (isset($_POST['username']) && isset($_POST['password'])) {
	   $uname_val=$_POST['username'];
	   $pswd_val=$_POST['password'];
	}
else {
	    echo "<br>";
	    echo '<h3>You Must Login to Use Site. Please Login.</h3>';
	    echo '<br>';
	    echo '<br>';
        echo '<center><input type=button onClick=location.href="index.html" value="Click Here To Login"</center>';
		exit;
}
		

include ("dbinfo.inc.php"); //include login info file
//MySQL Connection Info
try
    {
      $conn = new PDO($dsn, $username, $password);
    }
catch (PDOException $e)
    {
    $error_message=$e->getMessage();
    echo "<h1>Resource Unavailable. Please contact the System Administrator</h1>";
    }
//End of Connection


    echo "<br>";
    $check = "SELECT COUNT(*) FROM member WHERE username='$uname_val' && password='$pswd_val'";
    $result = $conn->query($check);
 
  
//Check if username is on the database
    if ($result->fetchColumn() > 0) {
    	// this sets session variable to check on other pages if user came from this page
		$_SESSION['status']='set'; 
		echo "<h3>Welcome $uname_val</h3>";
?>


   
<script type="text/javascript">
		<!--
		function delayer(){
    		window.location = "admin.php"
			}
		//-->
		</script>
		
		<body onload="setTimeout('delayer()', 500)">
		</body>
		
<?php
                    echo "<br/>";
        
        
	  } 
	
   else {
?>
		
		<script type="text/javascript">
		<!--
		function delayer(){
    		window.location = "login.html"
			}
		//-->
		</script>
		
		<body onload="setTimeout('delayer()', 3000)">
		<h2>Login Failed. Please Try Again.</h2>
		<p>You will be redirected back to the Login Page Momentarily...</p>

		</body>
 
</html>
	      
        
<?php

		echo "<br>";
		echo '<br>';
        /* Make sure that code below does not get executed when we redirect. */
		exit;

        }		
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  id="bkgrd_color" xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="images/favicon.ico" rel="icon" type="image/x-icon" />

<title>Logout</title>

<link rel="stylesheet" type="text/css" href="css/main_style.css"/>
 <!-- Bootstrap core CSS -->
    <link href="css/styles/bootstrap.min.css" rel="stylesheet"/>
    	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/styles/starter-template.css" rel="stylesheet"/>

   
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"/></script>
    <![endif]-->      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>




</head>

<?php
    session_start();
    
    if($_SESSION['session_life'] > $_SESSION['inactive'])  {
?>
       
<body>
<script type="text/javascript">
		<!--
		function delayer(){
    		window.location = "index.php"
			}
		//-->
		</script>
		
		<body  id="bkgrd_color" onload="setTimeout('delayer()', 2000)">
		<h2>Logoff Due to Inactivity</h2>
		<p>You will return to Main page momentarily...</p>

		</body>
<?php 
        session_unset();
        session_destroy();   
 }
    
 
    else   {  
?>

<script type="text/javascript">
		<!--
		function delayer(){
    		window.location = "index.php"
			}
		//-->
		</script>
		
		<body  id="bkgrd_color" onload="setTimeout('delayer()', 2000)">
		<h2>Logoff Succesful</h2>
		<p>You will return to Main page momentarily...</p>

		</body>
		
<?php
        session_unset();
        session_destroy();
 }
?>		
</body>

</html>

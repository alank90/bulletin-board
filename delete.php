<!DOCTYPE html>
<html lang="en">
<head>
</head>

<body>
<?php
session_start();

/*Check if session has expired*/

if (!isset($_SESSION['user']) OR !isset($_SESSION['password']))  {
     echo "<h2> 'Trouble Signing In/Gmail User Timeout. Retry Logging In'</h2>"; 
     exit();
   }  

/* connect to gmail */
$user = $_SESSION['user'];
$password = $_SESSION['password'];
$mailbox = "{imap.gmail.com:993/imap/ssl}INBOX";

//Get Msgno from The ?id passed in url amd move it to the Trash.
$msgno = $_GET['msg']; //I won't validate this input, but you should. Passed the Msgno to be deleted via $_GET 

//Proceed to move the message to the Trash folder. Used mailboxlist.php to find name of 
//folders Gmail uses. 
$mbx = imap_open($mailbox , $user , $password);
imap_mail_move($mbx, "$msgno", '[Gmail]/Trash');
imap_expunge($mbx);
imap_close($mbx,CL_EXPUNGE);

echo " <h2>Message Moved to the Trash</h2>";
?>
</body>
</html>


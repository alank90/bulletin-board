<!-- sesion_start must come before anything else ---->
<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
</head>

<body>
<?php
//session_start();

/*Check if session has expired*/

if (!isset($_SESSION['user']) OR !isset($_SESSION['password']))  {
     echo "<h2> 'Trouble Signing In/Gmail User Timeout. Retry Logging In'</h2>";
     exit();
   }  

/* connect to gmail */
$user = $_SESSION['user'];
$password = $_SESSION['password'];
$mailbox = "{imap.gmail.com:993/imap/ssl}INBOX";

$uid = $_GET['id']; //I won't validate this input, but you should
$mbx = imap_open($mailbox , $user , $password);
$overviews = imap_fetch_overview($mbx, $uid, FT_UID);
$body = imap_body($mbx, $uid, FT_UID);

foreach($overviews as $overview)
{

?>
<table>
     <tr>
          <td style="width:75px">From:</td>
          <td><?php echo $overview->from; ?></td>
     </tr>
     <tr>
          <td style="width:75px">Date:</td>
          <td><?php echo $overview->date; ?></td>
     </tr>
     <tr>
          <td style="width:75px">Subject:</td>
          <td><?php echo $overview->subject; ?></td>
     </tr>
     
     <tr>
          <td colspan="2"><?php echo quoted_printable_decode($body); ?></td>
     </tr>
</table>
<?php
    }
    
?>
</body>
</html>

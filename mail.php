<?php

/* Declare Global Variables for use later */
$username_item = "";
$password_item = "";



if (isset($_POST['user_val'])) {
     //do the assignment of the Username & Password variables from the form &_POST
        gmail_submit();
     // End If
}

//ini_set('display_errors',1); 
//error_reporting(E_ALL);

/*----------------------------------------------------------------------------------------------------<
 Check if anything was input on signin page. This is the main section to render the emails table. 
-----------------------------------------------------------------------------------------------------*/
if ($username_item != "" OR $password_item != "") {

/* connect to gmail */
$user = $username_item;
$password = $password_item;
$mailbox = "{imap.gmail.com:993/imap/ssl}INBOX";
// Assign session Variables to pass to open.php
$_SESSION['user'] = $username_item;
$_SESSION['password'] = $password_item;

$mbx = imap_open($mailbox , $user , $password);
  //Error handle on no connection to Mail Server
if (!$mbx) {
        echo "Error Connecting to Gmail";
        echo "<br>";
        print imap_last_error();
        echo "<br>";
        echo "<br>";
        echo "<button class='btn  btn-primary btn-lg' onclick = window.location.href='index.php'>Return To SignIn</button>";
    
}


/* grab emails from last 5 days*/
$since_date = date ( "d M Y", strToTime ( "-5 days" ) );
$emails = imap_search($mbx, "SINCE \"$since_date\"");

//Here we reverse the array so latest emails appear on top.
$emails = array_reverse($emails,true);

/* if emails are returned, cycle through each... */
if($emails) {

    /* begin output var */
    $output = '';

   
?>

<h2><center><span id="hide_messages"> My Gmail Inbox <h4>(click to hide/view mail)</h4>&nbsp;&nbsp;</span><br><h3><?php echo $_SESSION['user'];?></h3>&nbsp;&nbsp;<a href='https:mail.google.com' target='_tab'><img src='assets/Gmail_icon.jpg' style='width:64px;height:64px'></a></center></h2>

<br><br>

<table class="table table-bordered table-hover table_messages_hide">
    
     <colgroup>
        <col style="width:10%">
        <col style="width:10%">
        <col style="width:60%">
 
 <tr> 
        <th>From</th>
        <th>Date</th>
        <th><center>Subject</center></th>
        <th></th>
 </tr>

<?php    
 

    /* for every email... */
    foreach($emails as $email_number) {
       /* get information specific to this email */
        $overviews = imap_fetch_overview($mbx,$email_number,0);
      
      
 /*           
imap_fetch_overview returns an overview for a message.
An overview contains information such as message subject,
sender, date, and if it has been seen. Note that it does
not contain the body of the message. Setting the second
parameter to "1:n" will cause it to return a sequence of messages*/

 //print_r ($overviews);

foreach($overviews as $overview)    {
?>
     
        <tbody>

     <tr>
          <td><?php echo $overview->from; ?></td>
          <td><?php echo date ("F jS", strtotime($overview->date)); ?></td>
          <td><a href="open.php?id=<?php echo $overview->uid; ?>" target="_tab"><?php echo $overview->subject; ?></a></td>
          <td><a href="?msg=<?php echo $overview->msgno; ?>" class='glyphicon glyphicon-trash' title='Delete Mail' aria-hidden='true'></a></td> 
     </tr>
    
     	 </tbody>				

    <?php
    

         }
       
    
  }     
  
   ?>
      
     </table> 

     <div class="table_messages_hide"><button class="btn  btn-primary btn-md" onclick="window.location.href='index.php'">Gmail Sign Off</button>&nbsp;&nbsp;
          <button class="btn  btn-primary btn-md" onclick="window.location.reload()">Check For New Emails</button>&nbsp;&nbsp;
          <button class="btn  btn-primary btn-md" onclick="window.open('http://mail.google.com', '_blank')">Goto Gmail</button>&nbsp;&nbsp;

     <br>
     <br>
     
   </div>
         
   <?php
   imap_close($mbx);
     
 }
 
 
/*----------------------------------------------------------------------------------------------------<
 End of If statement on render the Mail table on entering User & Password 
-----------------------------------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------------------------------<
 Check if $_GET['msg'] is set. Then Someone wants a message deleted. 
-----------------------------------------------------------------------------------------------------*/
 
} elseif (isset($_GET['msg'])) {
       //Call delete_mail() function to delete this message and rerender the Email table.
         delete_mail(); 
         signin_mail();
         

/*----------------------------------------------------------------------------------------------------<
 Else we fall down to this conditional of nothing has been set so it
 must be a new page call and we should render the signin button. 
-----------------------------------------------------------------------------------------------------*/
  
}  else {

            /* Begin rendering of Gmail SignIn button and its associated Dialog Modal */

       echo "<h2>My Gmail Account&nbsp&nbsp<span><a href='https:mail.google.com' target='_tab'><img src='assets/Gmail_icon.jpg' style='width:64px;height:64px'></a></span></h2>"; 
?>    
      

      <div class="container">
 <br>  
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Add_Modal">SignIn</button>
 

<div class="modal fade" id="Add_Modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="Signin_Label"></h3> 
      </div>
      
      <!-- Gmail Signin Modal --------------------------------------------------------------------------->
      <div class="modal-body">
    
       
        
        
  <h2>Gmail SignIn</h2>
    
      
  <form id="signin_submit" role="form" action="?signin_submit" method="post">
    <div class="form-group col-lg-6">
      

      <label for="add_mess"></label>
      <div class="row">
       <div class="form-group col-lg-11">
        Username:<input type="text" size="35" class="form-control" id="user_item" name="user_val" required placeholder="jdoe@scarsdaleschools.org">
        </div>
       </div>
       <div class="row">
        <div class="form-group col-lg-11">
        Password:<input type="password" size="35" class="form-control" id="pass_item" name="password_val" required >
      </div>
      </div>
       
       
       <div class="modal-footer pull-left">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  id="newData" class="btn btn-primary btn-md">Submit</button>
       </div> 
      </div>  
   </form>
                         </div>
                         
                      </div>
                    </div>
                  </div>                 
                </div>

 
 <!-- End Gmail SignIn Form -->
 
 <?php
   }
 





/*-------------------------------------------------------<
	   PHP function code for GMail Submit 	
--------------------------------------------------------*/	

function gmail_submit() {
// need to declare as global variables because accessing them from inside a function
global $username_item, $password_item;
$username_item = $_POST['user_val'];
$password_item = $_POST['password_val'];
}
/* ------------------------------------------------------<
             End Gmail Submit Function -----------------
--------------------------------------------------------*/



/*------------------------------------------------------------<
	   PHP function code to Delete an Email 	
-------------------------------------------------------------*/	
		
 function delete_mail()  {

/*Check if session has expired*/

if (!isset($_SESSION['user']) OR !isset($_SESSION['password']))  {
     echo "<h2> 'Trouble Signing In/Gmail User Timeout. Retry Logging In'</h2>"; 
     exit();
   }  

/* connect to gmail via the Global $_SESSION variables set in index.php */
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

}

	    /*-----------------------------------------------------< 
	               End Delete an Emai function code 
	    ------------------------------------------------------*/
	    
	   /*-------------------------------------------------<
	       Begin GMail SignIn Function to resignin 
	       after a delete message is performed.
	   --------------------------------------------------*/
	    
	    
function signin_mail()  {

/*Check if session has expired*/

if (!isset($_SESSION['user']) OR !isset($_SESSION['password']))  {
     echo "<h2> 'Trouble Signing In/Gmail User Timeout. Retry Logging In'</h2>"; 
     exit();
   }  
   
   /* connect to gmail via the Global $_SESSION variables set in index.php */
$user = $_SESSION['user'];
$password = $_SESSION['password'];
$mailbox = "{imap.gmail.com:993/imap/ssl}INBOX";

$mbx = imap_open($mailbox , $user , $password);
  //Error handle on no connection to Mail Server
if (!$mbx) {
        echo "Error Connecting to Gmail";
        echo "<br>";
        print imap_last_error();
        echo "<br>";
        echo "<br>";
        echo "<button class='btn  btn-primary btn-lg' onclick = window.location.href='index.php'>Return To SignIn</button>";
    
}

/* grab emails from last 10 days*/
$since_date = date ( "d M Y", strToTime ( "-10 days" ) );
$emails = imap_search($mbx, "SINCE \"$since_date\"");

//Here we reverse the array so latest emails appear on top.
$emails = array_reverse($emails,true);

/* if emails are returned, cycle through each... */
if($emails) {

    /* begin output var */
    $output = '';

   
?>

<h2><center>My Gmail Inbox&nbsp;&nbsp;<span><br><h3><?php echo $_SESSION['user'];?></h3>&nbsp;&nbsp;<a href='https:mail.google.com' target='_tab'><img src='assets/Gmail_icon.jpg' style='width:64px;height:64px'></a></span></center></h2>
<br><br>

<table class="table table-bordered table-hover">
    
     <colgroup>
        <col style="width:10%">
        <col style="width:10%">
        <col style="width:60%">
 
 <tr> 
        <th>From</th>
        <th>Date</th>
        <th>Subject</th>
        <th></th>
 </tr>

<?php    
 

    /* for every email... */
    foreach($emails as $email_number) {
       /* get information specific to this email */
        $overviews = imap_fetch_overview($mbx,$email_number,0);
      
      
 /*           
imap_fetch_overview returns an overview for a message.
An overview contains information such as message subject,
sender, date, and if it has been seen. Note that it does
not contain the body of the message. Setting the second
parameter to "1:n" will cause it to return a sequence of messages*/

 //print_r ($overviews);

foreach($overviews as $overview)    {
?>
     
        <tbody>

     <tr>
          <td><?php echo $overview->from; ?></td>
          <td><?php echo date ("F jS", strtotime($overview->date)); ?></td>
          <td><a href="open.php?id=<?php echo $overview->uid; ?>" target="_tab"><?php echo $overview->subject; ?></a></td>
          <td><a href="?msg=<?php echo $overview->msgno; ?>" class='glyphicon glyphicon-trash' title='Delete Mail' aria-hidden='true'></a></td> 
     </tr>
    
     	 </tbody>				

    <?php
    

         }
       
    
  }     
  
   ?>
      
     </table> 

     <div><button class="btn  btn-primary btn-md" onclick="window.location.href='index.php'">Gmail Sign Off</button>&nbsp;&nbsp;
          <button class="btn  btn-primary btn-md" onclick="window.location.reload()">Check For New Emails</button>&nbsp;&nbsp;
          <button class="btn  btn-primary btn-md" onclick="window.open('http://mail.google.com', '_blank')">Goto Gmail</button>&nbsp;&nbsp;

     <br>
     <br>
     
      </div>
         
   <?php
   imap_close($mbx);
     
  }
 
}

/* End SignIn Functionn do something if User & Password entered */

   
   ?>

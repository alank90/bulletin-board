<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>SHS Tech Admin Page</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/> 
        <script src="jquery.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<link rel="icon" href="assets/favicon.ico" rel="icon" type="image/x-icon">

		
	</head>
	
	
 <body>
	
	<nav class="navbar navbar-static">
		<div class="container">
		   <a class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
			<span class="glyphicon glyphicon-chevron-down"></span>
		  </a>
		  <div class="nav-collapse collase">
			<ul class="nav navbar-nav">  
			  <li><a href="index.php">Home</a></li>
			  <li><a href="#">Link</a></li>
			</ul>
			<ul class="nav navbar-right navbar-nav">
			   <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-chevron-down"></i></a>
				<ul class="dropdown-menu">
				  <li><a href="logoff.php">Logoff</a></li>
				  <li><a href="#">Profile</a></li>
				  <li class="divider"></li>
				  <li><a href="#">About</a></li>
				 </ul>
			  </li>  
			</ul>
		  </div>		
		</div>
	
		
	</nav><!-- /.navbar -->


	  <div class="container">
		<div class="row">
		  <div class="col col-sm-4">
			<h1>Administrative Page</h1>
		  </div>
		  <div class="col col-sm-8">
			 <img src="assets/tools-icon.jpg" class="img-responsive">
 		  </div>

		  
		  </div>
		</div>
	 
	  
	  <div class="container">
		<div class="row">
		  <div class="col col-sm-8">
			
			<div class="panel">
			<div class="panel-body">
			  <h3>For your friendly local Administrator <span class="glyphicon glyphicon-wrench"></span></h3>  
			</div>
			</div>
			
		  </div>
		</div>
	  </div>
	

	<!-- Begin Body -->
	<div class="container">
		<div class="row">
				<div class="col col-sm-4">
					<div id="sidebar">
					<ul class="nav nav-stacked">
						<li><h3 class="highlight">Channels <i class="glyphicon glyphicon-dashboard pull-right"></i></h3></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
					</ul>
					
						
					</div>
				   
				</div>  
				
				  <br />
				  <br />
				  <br />
				  
				  
		<div class="container">
				  
				  <div class="col col-lg-8">
				  <div class="panel">
				  <h2>Administrative Tasks</h2>
				  
				  <div class="row">
					<div class="col col-lg-8">
					  <div class="container">
					  
        <!-- Begin Edit Modal ---------------------------> 
		

  
 
&nbsp;
&nbsp;  


			  
<ul>
            <!-- Add Newsticker item  & Edit News.txt Button trigger modal buttons -->
   
 <li><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Add_Modal">
 New Ticker Item
</button></li>
<br />
<br />

<li><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Edit_Modal">
 Edit Ticker Items
</button></li>
<br />
<br />

<li><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Edit_XML_Modal">
 Edit user_Info.xml
</button></li>
</ul>


<!-- Add Newsticker Item Modal -->
<!-- PHP code used to add a Newsticker item from the Add Newsticker form that is submitted from below back to same page-->
<!-- using the name variables First we check if the $_POST variable for an add is set-->
<?php
 
   if (isset($_POST['dt_item_val'])) {
     //do the add of the item to newsticker.txt
     newsticker_submit();
    
   }
   else {
    //show the add form 
   
?>

 
<div class="modal fade" id="Add_Modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="Alan_Modal_Label"></h3>
      </div>
      
      <!-- Add Ticker Item Form--------------------------------------------------------------------------->
      <div class="modal-body">
    
        <div class="container">
        
        
  <h2>New Ticker Message</h2>
    
      
  <form id="newsticker_submit" role="form" action="?newsticker_submit" method="post">
    <div class="form-group">
      

      <label for="add_mess"></label>
        Date Entered:<input type="text" size="5" class="form-control" id="dt_item" name="dt_item_val" required placeholder="* ex. 4/21">
        Ticker Item:<input type="text" size="85" class="form-control" id="tkr_item" name="tkr_item_val" required placeholder="* Enter Ticker Item">
      </div>
     
      
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  id="newData" class="btn btn-primary btn-md">Submit</button>
    
   </form>
                         </div>
                      </div>
                    </div>
                  </div>                 
                </div>
                


      <!-- End Add Newsticker Item  Form-->



<?php
 }
function newsticker_submit() {
$dt_item = $_POST['dt_item_val'];
$tkr_item=$_POST['tkr_item_val'];
$tkr_txt = file_get_contents('webticker/news.txt');

$myfile = fopen("/var/www/bb/webticker/news.txt", "w+") or die("Unable to open file!");
$txt = "HNEWS=" . '"' . $dt_item . " " ."•" ." " . $tkr_item . '"' .  PHP_EOL . "HLINK=" . '"/bb/index.php"' . PHP_EOL . $tkr_txt;
fwrite($myfile,$txt);
fclose($myfile);
?>
<script>window.location = "success.html"</script>;
<?php
exit();
}
?>



<!-- End of PHP to add a Newsticker item -->



<!------------------------------------------------------------------------------------------------------------------------------<
-- Edit Newsticker file Modal begins here.
-- PHP code used to edit the Newsticker.txt file. The  form that is submitted from below is sent back to this same  page
-- using the name=text variable. First we check if the $_POST variable for an edit is set. If it is we call
-- the php function newsticker_edit to update the newsticker and close the modal.
-------------------------------------------------------------------------------------------------------------------------------->

<?php

   if (isset($_POST['text'])) {
       //do the edit of newsticker.txt file
         newsticker_edit();
    }
   else {
    //we show the form. 
     $file = 'webticker/news.txt';
     $text = file_get_contents($file);
?>




             <!--Start Edit News.txt file Modal  & Form-->
<div class="modal fade" id="Edit_Modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="Alan_Modal_Label">Edit News.txt</h3>
      </div>
        
        
       <div class="modal-body">
         <div class="container">
            <h2>Update Ticker Message</h2> 
             <!-- HTML form -->
           <form id="newstkr_edit" role="form" action="?newstkr_edit" method="post">
               <div class="form-group">
               <label for="tkr_mess"></label>
               <textarea name="text" class="form-control" id="edit_txt"><?php echo htmlspecialchars($text) ?></textarea>
               <!--<input type="submit" class="btn btn-primary btn-md"/> -->
               <button type="submit"  id="newData" class="btn btn-primary btn-md">Submit</button>
               <button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Close</button>

              </div>
           </form>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

			  
			<!-- End Edit News.txt Modal & Form ----------------------------------------------------------------->	  
				  
			
	<!-- PHP function code to edit news.txt file on server. -->			
     <?php
 
           }
           
             function newsticker_edit()  {
             //Get file Contents
                $url = 'http://localhost/var/www/bb/admin.php';
                $file = 'webticker/news.txt';

                 
                // save the text contents
                file_put_contents($file, $_POST['text']);
                ?>
                 <script>window.location = "success.html"</script>;
                <?php
                exit();
              }

               
         
    ?>
	    <!-- End PHP newsticker_edit function code -->
 

	

<!------------------------------------------------------------------------------------------------------------------------------<
-- Edit UserInfo.xml file Modal begins here.
-- PHP code used to edit the UserInfo.xml file. The  form that is submitted from below is sent back to this same  page
-- using the name=xml_text variable. First we check if the $_POST variable for an edit of userInfo.xml is set. If it is we call
-- the php function UserInfo_edit to update the UserInfo.xml and close the modal.
-------------------------------------------------------------------------------------------------------------------------------->

<?php

   if (isset($_POST['xml_text'])) {
       //do the edit of userInfo.xml file
         xml_info_edit();
     }
   else {
    //we show the form. 
     $xml_file = 'todolist/userInfo.xml';
     $user_info = file_get_contents($xml_file);
?>




             <!--Start Edit userInfo.xml file Modal  & Form-->
<div class="modal fade" id="Edit_XML_Modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="Alan_Modal_Label">Edit userInfo.xml</h3>
      </div>
        
        
       <div class="modal-body">
         <div class="container">
            <h2>Update UserInfo XML File</h2> 
             <!-- HTML form -->
           <form id="user_info_edit" role="form" action="?user_info_edit" method="post">
               <div class="form-group">
               <label for="xml_info"></label>
               <textarea name="xml_text" class="form-control" id="edit_xml"><?php echo htmlspecialchars($user_info) ?></textarea>
               <!--<input type="submit" class="btn btn-primary btn-md"/> -->
               <button type="submit"  id="newData" class="btn btn-primary btn-md">Submit</button>
               <button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Close</button>

              </div>
           </form>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

			  
			<!-- End Edit userInfo.xml Modal & Form ----------------------------------------------------------------->	  
				  
			
	<!-- PHP function code to edit user_Info.xml file on server. -->			
     <?php
 
           }
           
             function xml_info_edit()  {
             //Get file Contents
                $url = 'http://localhost/var/www/bb/admin.php';
                $file = 'todolist/userInfo.xml';

                 
                // save the text contents
                file_put_contents($file, $_POST['xml_text']);
                echo "Wrote Changes to user_Info.xml.";
                ?>
                 <script>window.location = "success.html"</script>;
                <?php

                exit();
              }
    ?>
	    <!-- End PHP user_Info.xml edit function code -->





			
			

	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	     </div>
	    </div>
	  </div>
	
	
		<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>
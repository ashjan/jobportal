<?php
error_reporting(E_ALL ^ E_DEPRECATED); // in order to hide my sql deprecation errors<br>

include('include/file_include.php');
######################
#
# 	POST SECTION
#
######################

if(isset($_POST['mode'])){


	$inner_page = $_POST['request_page'];
	
	
	if($inner_page==""){
		$inner_page = "index";
	}
	
	include("query.include/".$inner_page.".php");

}//end if(isset($_POST['mode']))

######################
#
# 	GET SECTION
#
######################

if(isset($_GET['mode'])){
	
	$inner_page = $_GET['request_page'];
	
	if($inner_page==""){
		$inner_page = "index";
	}
	
	include("query.include/".$inner_page.".php");
		
}

// END if(isset($_GET['mode']))
?>
<?php include('include/script_include.php');?>
<?php include("include/header_logo.php");?>

				<?php include("include/leftpanel.php");?>
					<div  class="col-md-10">
					<?php
					if(isset($_REQUEST['act'])){
							if(file_exists("bodies/".$_REQUEST['act'].".php")){

								include("bodies/".$_REQUEST['act'].".php");
							
							}else{
								include("bodies/error.php");
							}
					}else{
					 
					  	include("bodies/welcome.php");
				     
					 }
					?>	
                                        </div>
				  
			
		<!--# Login Page Ends Here-->	
	 
<?php include("include/footer.php");?>
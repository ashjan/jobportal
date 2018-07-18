<?php
if($_POST['mode']=='add' && $_POST['act']=='city' && $_POST['request_page']=='manage_city'){
		
		$city_name = addslashes(trim($_POST['city_name']));
		if($city_name == '' ){
			$errmsg = base64_encode('Please Enter City Name');
			header("Location: admin.php?act=city&errmsg=$errmsg");
			exit;
		}
		
				 	   	$update_img_query = "INSERT ".$tblprefix."city SET
											city_name = '".$city_name."' ";    
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("City inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add City in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
					
			}

//---------Update Car---------
	   
###############################################################################	 
	 
	 	
	 if($_POST['mode']=='update' && $_POST['act']=='edit_city' && $_POST['request_page']=='manage_city'){
$post=$_POST;
$error='';
$id=base64_decode($_POST['id']);
$city_name = addslashes(trim($_POST['city_name'])); 
if($city_name==''){
	$error="Please Enter City Name<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit();
}
					 	$update_img_query = "UPDATE ".$tblprefix."city SET
														city_name = '".$city_name."'
														WHERE city_id=".$id; 
														
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("City Name Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($id));
								exit;
							}else{
							
								$errmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}
						
		}


	
	
######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='city' && $_GET['request_page']=='manage_city'){
	    $id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."city WHERE city_id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			
		$okmsg = base64_encode("City Deleted successfully.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	

	
	   
?>
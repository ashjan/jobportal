<?php

// A D D      R O O M    F A C I L I T Y    M A N A G E M E N T 	
if($_POST['mode']=='add' && $_POST['act']=='manage_car_facility' && $_POST['request_page']=='car_facility_management'){
$post=$_POST;
$error='';
if($post['car_facility_status']==''){
  $error="You forgot to select room facility status!<br>";	
}
if($post['property_fac_category'] == ''){
	$error="Facility Name Required<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
						 $update_img_query = "INSERT ".$tblprefix."car_facility 
						                                SET
														car_facility_status = '".$post['car_facility_status']."',
														car_facility_name = '".$post['car_facility_name']."',
														car_facility_type = '".$post['property_fac_category']."'";
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Facility inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Facility in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
	}
} 
if($_POST['mode']=='update_room_ameneties' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

$post=$_POST;
$error='';

		foreach ($_POST as $key => $value) {
    $idd1 = explode("_", $key);
	$idd = $idd1[3];
	if($idd !== '' ){
	
	$update_img_query = "UPDATE ".$tblprefix."room_facility 
						                                SET
														room_facility_status = '".$value."'
														WHERE id = ".$idd;
							$run_query = $db->Execute($update_img_query);
							
	}
}
								$okmsg = base64_encode("Status Changed successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
	}
	
	if($_POST['mode']=='update_media_n_tech' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

$post=$_POST;
$error='';
	foreach ($_POST as $key => $value) {
    $idd1 = explode("_", $key);
	$idd = $idd1[3];
	if($idd !== '' ){
	
	$update_img_query = "UPDATE ".$tblprefix."room_facility 
						                                SET
														room_facility_status = '".$value."'
														WHERE id = ".$idd;
							$run_query = $db->Execute($update_img_query);
							
	}
}
								$okmsg = base64_encode("Status Changed successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
	}
	
	


 //       U P D A T E      R O O M    F A C I L I T Y       M A N A G E M E N T 
 if($_POST['mode']=='food_n_drinks' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

$post=$_POST;
$error='';

		foreach ($_POST as $key => $value) {
    $idd1 = explode("_", $key);
	$idd = $idd1[3];
	if($idd !== '' ){
	
	$update_img_query = "UPDATE ".$tblprefix."room_facility 
						                                SET
														room_facility_status = '".$value."'
														WHERE id = ".$idd;
							$run_query = $db->Execute($update_img_query);
							
	}
}
								$okmsg = base64_encode("Status Changed successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
	}



 //       U P D A T E     B A T H   R O O M          M A N A G E M E N T 
 if($_POST['mode']=='update_bathroom' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){
$post=$_POST;
$error='';

		foreach ($_POST as $key => $value) {
    $idd1 = explode("_", $key);
	$idd = $idd1[3];
	if($idd !== '' ){
	
	$update_img_query = "UPDATE ".$tblprefix."room_facility 
						                                SET
														room_facility_status = '".$value."'
														WHERE id = ".$idd;
							$run_query = $db->Execute($update_img_query);
							
	}
}
								$okmsg = base64_encode("Status Changed successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
	}
	
	
if($_POST['mode']=='update' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

$id=base64_decode($_POST['id']);
$post=$_POST;
$error='';

/*echo $post['room_facility_status'];
echo $post['facility_type'];
exit();*/


if($post['room_facility_status']==''){
  $error="You forgot to select room facility status!<br>";	
}
if($post['facility_type']==''){
	$error="Facility Type required<br>";
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
					 $update_img_query = "UPDATE ".$tblprefix."room_facility 
						                                SET
														room_facility_status = '".$post['room_facility_status']."',
														facility_name = '".$post['facility_name']."',
														facility_type = '".$post['facility_type']."'
														WHERE id=".base64_decode($_POST['id']);
														
							$run_query = $db->Execute($update_img_query);
							
							if($run_query){
								$okmsg = base64_encode("Facility Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}
					
						
	}
} 

	   
######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='room_facility_management' && $_GET['request_page']=='manage_room_facility'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT facility_type FROM ".$tblprefix."room_facility WHERE id =".$id;
	
		$rs_select = $db->Execute($sel_qry);
		
		$del_qry = " DELETE FROM ".$tblprefix."room_facility WHERE id =".$id;
		
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
					   $okmsg = base64_encode("Sadržaj uspješno izbrisan. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
		else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	
	
//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='room_facility_management' && $_GET['request_page']=='manage_room_facility'){
	
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	$status=$_GET['m_status'];
//if parent is disable 

		
				
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."room_facility 
													SET 
													room_facility_status=".$status."
													WHERE
													id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				
		
				if($rs_currencies){
						$okmsg = base64_encode(" Room Facility Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
						exit;	  
				}else{
				$errmsg = base64_encode(" Room Facility Status could not be updated. !");
						header("Location: admin.php?okmsg=$errmsg&act=".$_GET['act']);
						exit;
				}
		
	
	}
?>	
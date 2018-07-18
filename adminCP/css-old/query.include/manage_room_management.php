<?php	
if($_POST['mode']=='add' && $_POST['act']=='room_management' && $_POST['request_page']=='manage_room_management'){

$post = $_POST;
$error='';

if($post['room_type']==''){
  //$error="Room Type Required!<br>";	
  $error="Morate izabrati sobu!<br>";
}

if($post['property_id']==0){
  //$error="Property Name Required!<br>";	
  $error="Morate izabrati objekat	!<br>";	
}

if($post['pm_id']==0){
 //$error="Property Manager required!<br>";	
  $error="Morate izabrati vlasnika objekta!<br>";
}

if($post['number_resources_available']=='' or is_int('number_resources_available')=='false'){
	//$error="you forgot to select the Number of rooms<br>";
	$error="zaboravili ste odabrali Broj soba<br>";
}


if($post['max_persons_per_resource']==''){
	//$error="you forgot to select the Number of rooms<br>";
	$error="zaboravili ste odabrali Broj soba<br>";
}

$room_type_rus = $post['room_type_rus'];
$room_type_mon = $post['room_type_mon'];

if($error!=''){
	$msg=base64_encode($error);
	$post=implode(",",$_POST);
	header("Location: admin.php?okmsg=$msg&act=".$_POST['act']."&p=".base64_encode($post));
}else{
						$update_img_query = "INSERT ".$tblprefix."rooms SET
							room_type = '".$post['room_type']."',
							property_id = ".$_POST['property_id'].",
							pm_id = ".$_POST['pm_id'].",
							long_stay = '".$post['long_stay']."',
							discount_long_stay = '".$post['discount_long_stay']."',
							number_resources_available = ".$post['number_resources_available'].",
							max_persons_per_resource = ".$post['max_persons_per_resource'].",
							meter_square = '".$_POST['meter_square']."'";
							$run_query      =  $db->Execute($update_img_query);
							$last_insert_id =  $db->Insert_ID('tbl_rooms','id'); 
							if($run_query){
							//$okmsg = base64_encode("Room  inserted successfully.!");
							//$okmsg = base64_encode("Morate unijeti broj soba.!");
							
							// for RUSSIAN 	
							if($post['room_type_rus']!=NULL and $post['room_type_rus']!=""){
							$insert_query_rus_lan = "INSERT ".$tblprefix."language_contents SET
							language_id = 5, 
							page_id     = ".$last_insert_id.", 
							field_name  = 'room_type_rus', 
							translation_text = '".$post['room_type']."', 
							translated_text  = '".$post['room_type_rus']."', 
							fld_type         = 'room_type'";
							$run_query_language  =  $db->Execute($insert_query_rus_lan);
							}
							
							// for MONTENEGRIN 	
							if($post['room_type_mon']!=NULL and $post['room_type_mon']!=""){
							$insert_query_mon_lan = "INSERT ".$tblprefix."language_contents SET
							language_id = 7, 
							page_id     = ".$last_insert_id.", 
							field_name  = 'room_type_mon', 
							translation_text = '".$post['room_type']."', 
							translated_text  = '".$post['room_type_mon']."', 
							fld_type         = 'room_type'";
							$run_query_language  =  $db->Execute($insert_query_mon_lan);
							}
								
							$okmsg = base64_encode("Soba uspješno dodata.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&p=".base64_encode($_POST));
							exit;
							}else{
								//$errmsg = base64_encode("Unable to add Room Record in database.!");
							$okmsg = base64_encode("Soba nije dodata.!");
							header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&p=".base64_encode($_POST));
							exit;
							}
	}
} 
//Update Section
if($_POST['mode']=='update' && $_POST['act']=='edit_room_management' && $_POST['request_page']=='manage_room_management'){
$post=$_POST;
$error='';

$_SESSION[room_type]=$post['number_resources_available'];
$_SESSION[long_stay]=$post['long_stay'];
$_SESSION[property_id]=$post['property_id'];
$_SESSION[pm_id]=$post['pm_id'];
$_SESSION[discount_long_stay]=$post['discount_long_stay'];
$_SESSION[number_resources_available]=$post['number_resources_available'];
$_SESSION[max_persons_per_resource]=$post['max_persons_per_resource'];



if($post['property_id']==0){
	//$error="Proprty name required"; 
      $error="Ime nekretnine potrebna";	
}


if($post['pm_id']==0){
  //$error="PM required";	
    $error="Morate izabrati vlasnika objekta";	
}

if($post['room_type']==''){
  //$error="Room Type required";	 
  $error="Morate izabrati sobu";	
}
if($post['number_resources_available']=='' or is_int('number_resources_available')=='false'){
	//$error="You forgot to select Number of Resource!<br>";
	$error="Morate unijeti broj soba!<br>";
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&p=".base64_encode($_POST)."&id=".base64_encode($_POST['id'])."&pm_id=".base64_encode($_POST['pm_id'])."&property_id=".base64_encode($_POST['property_id']));
}else{												$update_img_query = "UPDATE ".$tblprefix."rooms SET
														room_type = '".$post['room_type']."',
														property_id = ".$_POST['property_id'].",
														pm_id = ".$_POST['pm_id'].",
														long_stay = '".$post['long_stay']."',
														discount_long_stay = '".$post['discount_long_stay']."',
														number_resources_available = ".$post['number_resources_available'].",
														max_persons_per_resource = ".$post['max_persons_per_resource'].",
														meter_square = '".$_POST['meter_square']."'
														 WHERE id=".base64_decode($_POST['id']);
							$run_query = $db->Execute($update_img_query);
							if($run_query){
							
							if ($post['rus_lan_id']!=""){
							$update_query_rus_lan = "UPDATE ".$tblprefix."language_contents SET translation_text = '".$post['room_type']."',         
							translated_text  = '".$post['room_type_rus']."' 
							WHERE  
							field_name  = 'room_type_rus'  
							AND  
							fld_type    = 'room_type' 
							AND 
							page_id     = ".base64_decode($_POST['id'])."  
							AND 
							language_id = 5
							AND 
							id          = ".$post['rus_lan_id'];
							
							$run_query_language  =  $db->Execute($update_query_rus_lan);
							}else{
							$insert_query_rus_lan = "INSERT ".$tblprefix."language_contents 
							SET
							language_id = 5, 
							page_id     = ".base64_decode($_POST['id']).", 
							field_name  = 'room_type_rus', 
							translation_text = '".$post['room_type']."', 
							translated_text  = '".$post['room_type_rus']."', 
							fld_type         = 'room_type'";
							$run_query_language  =  $db->Execute($insert_query_rus_lan);
							}
							if ($post['mon_lan_id']!=""){
							$update_query_mon_lan = "UPDATE ".$tblprefix."language_contents 
							SET
							translation_text = '".$post['room_type']."', 
							translated_text  = '".$post['room_type_mon']."' 
							WHERE  
							field_name  = 'room_type_mon'  
							AND  
							fld_type    = 'room_type' 
							AND 
							page_id     = ".base64_decode($_POST['id'])." 
							AND 
							language_id = 7
							AND 
							id          = ".$post['mon_lan_id']." 
							";
							$run_query_language  =  $db->Execute($update_query_mon_lan);
							}else{
							$insert_query_mon_lan = "INSERT ".$tblprefix."language_contents SET
							language_id = 7, 
							page_id     = ".base64_decode($_POST['id']).", 
							field_name  = 'room_type_mon', 
							translation_text = '".$post['room_type']."', 
							translated_text  = '".$post['room_type_mon']."', 
							fld_type         = 'room_type'";
							$run_query_language  =  $db->Execute($insert_query_mon_lan);
							}
							
							
							
								//$okmsg = base64_encode("Room Facility Updated successfully.!");
								$okmsg = base64_encode("Saržaj sobe uspješno ažuriran.!");
								header("Location: admin.php?okmsg=$okmsg&act=room_management&id=".base64_encode($_POST['id'])."&pm_id=".base64_encode($_POST['pm_id'])."&property_id=".base64_encode($_POST['property_id'])."&p=".base64_encode($_POST));
								exit;
							}else{
								//$okmsg = base64_encode("Unable to Update Room Facility in database.!");
								$okmsg = base64_encode("Sadržaj sobe nije ažuriran.!");
								header("Location: admin.php?okmsg=$okmsg&act=room_management&id=".base64_encode($_POST['id'])."&pm_id=".base64_encode($_POST['pm_id'])."&property_id=".base64_encode($_POST['property_id'])."&p=".base64_encode($_POST));
								exit;
							}
					
						
	}
} 

// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='room_management' && $_GET['request_page']=='manage_room_management'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT facility_type FROM ".$tblprefix."rooms WHERE id =".$id;
		$rs_select = $db->Execute($sel_qry);
		$del_qry = " DELETE FROM ".$tblprefix."rooms WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
		$del_qry_rus = " DELETE FROM ".$tblprefix."language_contents  
			                 WHERE  
			                 field_name  = 'room_type_rus'  
							 AND  
							 fld_type    = 'room_type' 
							 AND 
							 page_id     = ".$id."  
							 AND 
							 language_id = 5";
		$rs_delete_rus = $db->Execute($del_qry_rus);
		
		
		$del_qry_mon = " DELETE FROM ".$tblprefix."language_contents  
			                 WHERE  
			                 field_name  = 'room_type_mon'  
							 AND  
							 fld_type    = 'room_type' 
							 AND 
							 page_id     = ".$id."  
							 AND 
							 language_id = 7";
		$rs_delete_mon = $db->Execute($del_qry_mon);
		
			//$okmsg = base64_encode("Room Record Deleted successfully. !"); 
			$okmsg = base64_encode("Podaci o sobi uspješno izbrisani. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']."&p=".base64_encode($_POST));
			exit;			
		}
		else{
			//$okmsg = base64_encode("Cijena nije izbrisana .!");
					$okmsg = base64_encode("Cijena nije izbrisana.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']."&p=".base64_encode($_POST));
			exit;			
		
		}
  
} 	
	
//---------Status Code---------		
/*
if($_GET['mode']=='change_default' && $_GET['act']=='room_facility_management' && $_GET['request_page']=='manage_room_facility'){
	
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	$status=$_GET['m_status'];
//if parent is disable 

		
				
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."rooms 
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
*/
?>	
	

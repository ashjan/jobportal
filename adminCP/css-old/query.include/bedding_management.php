<?php	
if($_POST['mode']=='add' && $_POST['act']=='manage_bedding' && $_POST['request_page']=='bedding_management'){

$post=$_POST;
$error='';
if($post['bedding_type_name']==''){
  //$error="Please Enter The Bedding Type Name<br>";	
  $error="Molimo unesite naziv vrste kreveta<br>";
  }
if($post['number_beds']==''){
	//$error="Please Enter the Number of Beds<br>";
	$error="Molimo unesite broj kreveta<br>";
	
}elseif( !is_numeric($_POST['number_beds'])){       
   //$error="Please Enter The Numeric Value In The Number of  Beds<br>";
   $error="Broj ležajeva mora da bude broj <br>";
}

if($post['pm_id']==0){
   //$error="Please select property manager<br>";
   $error="Molimo izaberite vlasnika objekta<br>";
}


if($post['property_id']==0){
   //$error="Please select property name<br>"; 
   $error="Molimo izaberite objekat<br>";
}


if($post['dimensions_width']==''){
	//$error="Please Enter The Dimensions Width<br>";
	$error="Molimo unesite širinu ležaja<br>";
}elseif( !is_numeric($_POST['dimensions_width'])){

	//$error="Please Enter The Numeric Value In The Dimension Width<br>";
	$error="Širina kreveta mora da bude numerička<br>";
}

if($post['room_id']==0){
   //$error="Please select Room<br>";
   $error="Molimo izaberite sobu<br>";
}

if($post['extra_beds']==''){
$post['extra_beds']=0;
}	
	
	
	
if($post['dimensions_length']==''){
	//$error="Please Enter  The Dimensions Length<br>";
	$error="Molimo unesite dužinu ležaja<br>";
}elseif( !is_numeric($_POST['dimensions_length'])){

	//$error="Please Enter The Numeric Value In The Dimension Length<br>";
	$error="Dužina kreveta mora da bude numerička<br>";
}


$bedding_type_name_rus = $post['bedding_type_name_rus'];
$bedding_type_name_mon = $post['bedding_type_name_mon'];


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
}else{
						    $update_img_query = "INSERT ".$tblprefix."bedding  
						                                SET
														bedding_type_name = '".$_POST['bedding_type_name']."',
														room_id           = '".$_POST['room_id']."',
														number_beds       = ".$_POST['number_beds'].",
														extra_beds        = ".$post['extra_beds'].",
														dimensions_width  = ".$_POST['dimensions_width'].",
														dimensions_length = ".$_POST['dimensions_length'].", 
														property_id = ".$_POST['property_id'].",
														pm_id       = ".$_POST['pm_id']."														
														";
							$run_query      = $db->Execute($update_img_query);
							$last_insert_id =  $db->Insert_ID('tbl_bedding','id'); 
							if($run_query){
                            
							// for RUSSIAN 	
							if($bedding_type_name_rus != NULL and $bedding_type_name_rus!=""){
							$insert_query_rus_lan      = "INSERT ".$tblprefix."language_contents SET
															language_id = 5, 
															page_id     = ".$last_insert_id.", 
															field_name  = 'bedding_type_name_rus', 
															translation_text = '".$post['bedding_type_name']."', 
															translated_text  = '".$post['bedding_type_name_rus']."', 
															fld_type         = 'bedding_type_name'";
							$run_query_language  =  $db->Execute($insert_query_rus_lan);
							}
							
							// for MONTENEGRIN 	
							if($bedding_type_name_mon != NULL and $bedding_type_name_mon!=""){
							$insert_query_mon_lan      = "INSERT ".$tblprefix."language_contents SET
															language_id = 7, 
															page_id     = ".$last_insert_id.", 
															field_name  = 'bedding_type_name_mon', 
															translation_text = '".$post['bedding_type_name']."', 
															translated_text  = '".$post['bedding_type_name_mon']."', 
															fld_type         = 'bedding_type_name'";
							$run_query_language  =  $db->Execute($insert_query_mon_lan);
							}
							
							
								$okmsg = base64_encode("Bedding Record inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Room Record in database.!");
								header("Location: admin.php?errmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
	}
} 

//Update Section

if($_POST['mode']=='update' && $_POST['act']=='manage_bedding' && $_POST['request_page']=='bedding_management'){
$post=$_POST;

$id 			= base64_decode($_POST['id']);
$pm_id			= $_POST['pm_id'];
$property_id 	= $_POST['property_id'];
$room_id 		= $_POST['room_id'];

$error='';
if($post['bedding_type_name']==''){
	//$error="Please Enter The Bedding Type Name<br>";	
    $error="Molimo unesite naziv vrste kreveta<br>";
}
if($post['number_beds']==''){
	//$error="Please Enter the Number of Beds<br>";
	$error="Molimo unesite broj kreveta<br>";
	
}elseif( !is_numeric($_POST['number_beds'])){       
	  //$error="Please Enter The Numeric Value In The Number of  Beds<br>";
   $error="Broj ležajeva mora da bude broj <br>";
}

if($post['pm_id']==0){
    //$error="Please select property manager<br>";
   $error="Molimo izaberite vlasnika objekta<br>";
}


if($post['property_id']==0){
    //$error="Please select property name<br>"; 
   $error="Molimo izaberite objekat<br>";
}

if($post['room_id']==0){
   //$error="Please select Room<br>"; 
   $error="Molimo izaberite sobu<br>";
}
if($post['dimensions_width']==''){
	//$error="Please Enter The Dimensions Width<br>";
	$error="Molimo unesite širinu ležaja<br>";
	
}elseif( !is_numeric($_POST['dimensions_width'])){
	//$error="Please Enter The Numeric Value In The Dimension Width<br>";
	$error="Širina kreveta mora da bude numerička<br>";
}
if($post['dimensions_length']==''){
	//$error="Please Enter  The Dimensions Length<br>";
	$error="Molimo unesite dužinu ležaja<br>";
	
}elseif( !is_numeric($_POST['dimensions_length'])){

	//$error="Please Enter The Numeric Value In The Dimension Length<br>";
	$error="Dužina kreveta mora da bude numerička<br>";
}
if($error!=''){
			$msg=base64_encode($error);
			//header("Location: admin.php?okmsg=$msg&act=manage_bedding&id=".base64_encode($_POST['id']));
			header("Location: admin.php?errmsg=$msg&act=edit_bedding&id=".$_POST['id']);
			exit;
}else{
						    if($_POST['room_id']!=0){
						    $update_img_query = "UPDATE ".$tblprefix."bedding
						                                SET
														bedding_type_name = '".$_POST['bedding_type_name']."',
														room_id = ".$_POST['room_id'].",
														number_beds = ".$_POST['number_beds'].",
						                                extra_beds = ".$_POST['extra_beds'].",
														property_id=".$_POST['property_id'].",
														pm_id=".$_POST['pm_id'].",
														dimensions_width = ".$_POST['dimensions_width'].",
														dimensions_length = ".$_POST['dimensions_length']."
														WHERE id=".base64_decode($_POST['id']);
														
							$run_query = $db->Execute($update_img_query);
							}else{
													$update_img_query = "UPDATE ".$tblprefix."bedding
						                                SET
														bedding_type_name = '".$_POST['bedding_type_name']."',
														number_beds = ".$_POST['number_beds'].",
						                                extra_beds = ".$_POST['extra_beds'].",
														dimensions_width = ".$_POST['dimensions_width'].",
														dimensions_length = ".$_POST['dimensions_length']."
														WHERE property_id=".$_POST['property_id']." and
														pm_id=".$_POST['pm_id'].""; 
							$run_query = $db->Execute($update_img_query);
							}
							if($run_query){
							if($_POST['rus_lan_id']!=""){
							$update_query_rus_lan = "UPDATE ".$tblprefix."language_contents SET translation_text = '".$_POST['bedding_type_name']."',							translated_text  = '".$_POST['bedding_type_name_rus']."' 
							WHERE  
							field_name  = 'bedding_type_name_rus'  
							AND  
							fld_type    = 'bedding_type_name' 
							AND 
							page_id     = ".base64_decode($_POST['id'])."  
							AND 
							language_id = 5
							AND 
							id          = ".$_POST['rus_lan_id'];
							
							$run_query_language  =  $db->Execute($update_query_rus_lan);
							}else{
							$insert_query_rus_lan = "INSERT ".$tblprefix."language_contents 
							SET
							language_id = 5, 
							page_id     = ".base64_decode($_POST['id']).", 
							field_name  = 'bedding_type_name_rus', 
							translation_text = '".$_POST['bedding_type_name']."', 
							translated_text  = '".$_POST['bedding_type_name_rus']."', 
							fld_type         = 'bedding_type_name'";
							$run_query_language  =  $db->Execute($insert_query_rus_lan);
							}
							if ($_POST['mon_lan_id']!=""){
							$update_query_mon_lan = "UPDATE ".$tblprefix."language_contents 
							SET
							translation_text = '".$_POST['bedding_type_name']."', 
							translated_text  = '".$_POST['bedding_type_name_mon']."' 
							WHERE  
							field_name  = 'bedding_type_name_mon'  
							AND  
							fld_type    = 'bedding_type_name' 
							AND 
							page_id     = ".base64_decode($_POST['id'])." 
							AND 
							language_id = 7
							AND 
							id          = ".$_POST['mon_lan_id']." 
							";
							$run_query_language  =  $db->Execute($update_query_mon_lan);
							}else{
							$insert_query_mon_lan = "INSERT ".$tblprefix."language_contents SET
							language_id = 7, 
							page_id     = ".base64_decode($_POST['id']).", 
							field_name  = 'bedding_type_name_mon', 
							translation_text = '".$_POST['bedding_type_name']."', 
							translated_text  = '".$_POST['bedding_type_name_mon']."', 
							fld_type         = 'bedding_type_name'";
							$run_query_language  =  $db->Execute($insert_query_mon_lan);
							}
							
								$okmsg = base64_encode("Bedding Facility Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=manage_bedding&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Room Facility Update in database.!");
								header("Location: admin.php?errmsg=$okmsg&act=edit_bedding&id=".base64_encode($_POST['id']));
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

if($_GET['mode']=='delete' && $_GET['act']=='manage_bedding' && $_GET['request_page']=='bedding_management'){
	$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."bedding WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
		
		
		
		
		
		$del_qry_rus = " DELETE FROM ".$tblprefix."language_contents  
			                 WHERE  
			                 field_name  = 'bedding_type_name_rus'  
							 AND  
							 fld_type    = 'bedding_type_name' 
							 AND 
							 page_id     = ".$id."  
							 AND 
							 language_id = 5";
		$rs_delete_rus = $db->Execute($del_qry_rus);
		
		
		$del_qry_mon = " DELETE FROM ".$tblprefix."language_contents  
			                 WHERE  
			                 field_name  = 'bedding_type_name_mon'  
							 AND  
							 fld_type    = 'bedding_type_name' 
							 AND 
							 page_id     = ".$id."  
							 AND 
							 language_id = 7";
		$rs_delete_mon = $db->Execute($del_qry_mon);
		
		
		
		
		
					$okmsg = base64_encode("bedding Record Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		            $okmsg = base64_encode("Unable to Delete .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	
	
?>	
	

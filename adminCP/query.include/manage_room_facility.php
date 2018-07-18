<?php

// A D D      R O O M    F A C I L I T Y    M A N A G E M E N T
if($_POST['mode']=='add' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){
	$post=$_POST;
	$error='';
    if($post['first_name']==0){
    	$error="Molimo izaberite vlasnika objekta<br/>";
    }
    if($post['room_type']==0){
	//$error="Please select room type<br/>";
	$error="Molimo izaberite sobu<br/>";
}


	if($post['pr_id']==0){
	//$error="Please select Property Name<br/>";
		$error="Molimo izaberite objekat<br/>";
	}
	if($post['room_type']==0){
		$error="Molimo izaberite sobu<br/>";
	}
	if($post['property_fac_category']==0){
		//$error="Please select facility category<br/>";
		$error="Molimo izaberite kategoriju objekta<br/>";
		
	}
	if($_POST['fac_id'][0]==0){
	 $error="Please select room facility<br/>";
	  //$error="Molimo izaberite sadržaj sobe<br/>";	
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
	}else{
		            $add_flag=0;
					foreach($post['fac_id'] as $key=>$value){
				    $update_img_query = "INSERT ".$tblprefix."room_facility SET
														property_id = ".$post['pr_id'].",
														pm_id = ".$post['first_name'].",
														fac_cat_id = '".$value."',
														facility_type =".$post['property_fac_category'].",
														rm_id=".$post['room_type'].",
														room_facility_status=1".""
														;
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$add_flag=1;
				
							}else{
								$add_flag=0;
							}
					}
	 		
		
		if($add_flag==1){
			//$okmsg = base64_encode("Facility inserted successfully.!");
			//$okmsg = base64_encode("Sadržaj uspješno dodat.!");
			$okmsg = base64_encode("Sadr&#382;aj uspje&scaron;no dodat.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
		}else{
			//$okmsg = base64_encode("Unable to add Facility in database.!");
			$okmsg = base64_encode("Sadr&#382;aj nije dodat.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
		}
	}
}
if($_POST['mode']=='delete_room_ameneties' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

	$post=$_POST;
	$error='';

	if($_POST['first_name']==0){
		$error = "Please select PM";
	}

	if($_POST['property_id']==0){
		$error = "Molimo izaberite objekat";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
	}else {
		foreach ($_POST as $key => $value) {
			foreach ($value as $val){
			
				$property_id = $_POST['property_id'];
				$pm_id = $_POST['first_name'];
				$update_img_query = "DELETE FROM ".$tblprefix."room_facility WHERE id = ".$val;
				
				$run_query = $db->Execute($update_img_query);

			}
		
		}
		$okmsg = base64_encode("Sadržaj uspješno izbrisan.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;

	}
}

if($_POST['mode']=='delete_media_n_tech' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

	$post=$_POST;
	$error='';
	if($_POST['first_name']==0){
		$error = "Please select PM";
	}

	if($_POST['property_id']==0){
		$error = "Molimo izaberite objekat";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
	}else {
		
		foreach ($_POST as $key=>$value) {
			foreach ($value as $val){
			
            
				$property_id = $_POST['property_id'];
				$pm_id = $_POST['first_name'];
				$update_img_query = "DELETE FROM ".$tblprefix."room_facility
						                         
														WHERE id = ".$val;
				
				$run_query = $db->Execute($update_img_query);

			
		}
		}
		$okmsg = base64_encode("Sadržaj uspješno izbrisan.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;

	}
}




//       U P D A T E      R O O M    F A C I L I T Y       M A N A G E M E N T
if($_POST['mode']=='delete_food_n_drinks' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

	$post=$_POST;
	$error='';
	if($_POST['first_name']==0){
		$error = "Please select PM";
	}

	if($_POST['property_id']==0){
		//$error = "Please select property ";
		$error = "Molimo izaberite objekat";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
	}else {
		foreach ($_POST as $key => $value) {
			foreach ($value as $val){
			

				$property_id = $_POST['property_id'];
				$pm_id = $_POST['first_name'];
				$update_img_query = "DELETE FROM ".$tblprefix."room_facility
						                   
														WHERE id = ".$val;
				$run_query = $db->Execute($update_img_query);

			}
		
		}
		$okmsg = base64_encode("Sadržaj uspješno izbrisan.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;

	}
}



//       U P D A T E     B A T H   R O O M          M A N A G E M E N T
if($_POST['mode']=='delete_bathroom' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){
	$post=$_POST;
	$error='';
	if($_POST['first_name']==0){
		$error = "Please select PM";
	}

	if($_POST['property_id']==0){
		//$error = "Please select property ";
		$error = "Molimo izaberite objekat";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
	}else {
		foreach ($_POST as $key => $value) {
			
			foreach ($value as $val){
			
                
				$property_id = $_POST['property_id'];
				$pm_id = $_POST['first_name'];
				$update_img_query = "DELETE FROM ".$tblprefix."room_facility                
														WHERE id = ".$val;
				
				$run_query = $db->Execute($update_img_query);

			}
		
		}
		$okmsg = base64_encode("Sadržaj uspješno izbrisan.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;

	}
}


if($_POST['mode']=='update' && $_POST['act']=='room_facility_management' && $_POST['request_page']=='manage_room_facility'){

	$id=base64_decode($_POST['id']);
	$post=$_POST;
	$error='';

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
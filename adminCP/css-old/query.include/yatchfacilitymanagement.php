<?php

// A D D      R O O M    F A C I L I T Y    M A N A G E M E N T
if($_POST['mode']=='add' && $_POST['act']=='yatchfacility' && $_POST['request_page']=='yatchfacilitymanagement'){
	$post=$_POST;
	$error='';
	if($post['facility_name']==''){
		$error = "Facility name is required<br>";
	}
	if($post['yacht_facility_status']==''){
		$error.="You forgot to select yatch facility status!<br>";
	}
	if($post['property_fac_category'] == 0){
		$error.="Yatch category Required<br>";
	}
	if($post['yatch_name'] == 0){
		$error.="Yatch name Required<br>";
	}
	if($post['first_name']==0){
	$error.="PM Name Required<br>";
}
if($post['agency_id']==0){
	$error.="Agency Name Required<br>";
}

	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
	}else{

		$update_img_query = "INSERT ".$tblprefix."yacht_facility
						                                SET
														yacht_facility_status = '".$post['yacht_facility_status']."',
														facility_name = '".$post['facility_name']."',
														facility_type = '".$post['property_fac_category']."',
														pm_id = '".$post['first_name']."',
														agency_id = '".$post['agency_id']."',
														yatch_id =".$post['yatch_name']."
														";


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
if($_POST['mode']=='update_room_ameneties' && $_POST['act']=='yatchfacility' && $_POST['request_page']=='yatchfacilitymanagement'){


	$post=$_POST;
	$error='';

	foreach ($_POST as $key => $value) {
		$idd1 = explode("_", $key);
		$idd = $idd1[3];
		if($idd !== '' ){

			$update_img_query = "UPDATE ".$tblprefix."yacht_facility
						                                SET
														yacht_facility_status = '".$value."'
														WHERE id = ".$idd;

			$run_query = $db->Execute($update_img_query);

		}
	}
	$okmsg = base64_encode("Status Changed successfully.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
	exit;

}

if($_POST['mode']=='update_media_n_tech' && $_POST['act']=='yatchfacility' && $_POST['request_page']=='yatchfacilitymanagement'){

	$post=$_POST;
	$error='';
	foreach ($_POST as $key => $value) {
		$idd1 = explode("_", $key);
		$idd = $idd1[3];
		if($idd !== '' ){

			$update_img_query = "UPDATE ".$tblprefix."yacht_facility
						                                SET
														yacht_facility_status = '".$value."'
														WHERE id = ".$idd;

			$run_query = $db->Execute($update_img_query);

		}
	}
	$okmsg = base64_encode("Status Changed successfully.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
	exit;

}
/*else{
	$okmsg = base64_encode("Unable to update room ameneties in database.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
	exit;
}*/




//       U P D A T E      Yacht    F A C I L I T Y       M A N A G E M E N T
if($_POST['mode']=='food_n_drinks' && $_POST['act']=='yatchfacility' && $_POST['request_page']=='yatchfacilitymanagement'){
	$post=$_POST;
	$error='';

	foreach ($_POST as $key => $value) {
		$idd1 = explode("_", $key);
		$idd = $idd1[3];
		if($idd !== '' ){

			$update_img_query = "UPDATE ".$tblprefix."yacht_facility
						                                SET
														yacht_facility_status = '".$value."'
														WHERE id = ".$idd;

			$run_query = $db->Execute($update_img_query);

		}
	}
	$okmsg = base64_encode("Status Changed successfully.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
	exit;

}/*else{
	$okmsg = base64_encode("Unable to update room ameneties in database.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
	exit;
}*/



//       U P D A T E     B A T H   R O O M          M A N A G E M E N T
if($_POST['mode']=='update_bathroom' && $_POST['act']=='yatchfacility' && $_POST['request_page']=='yatchfacilitymanagement'){
	$post=$_POST;
	$error='';

	foreach ($_POST as $key => $value) {
		$idd1 = explode("_", $key);
		$idd = $idd1[3];
		if($idd !== '' ){

			$update_img_query = "UPDATE ".$tblprefix."yacht_facility
						                                SET
														yacht_facility_status = '".$value."'
														WHERE id = ".$idd;

			$run_query = $db->Execute($update_img_query);

		}
	}
	$okmsg = base64_encode("Status Changed successfully.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
	exit;

}/*else{
	$okmsg = base64_encode("Unable to update room ameneties in database.!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
	exit;
}*/


if($_POST['mode']=='update' && $_POST['act']=='edityatchfacility' && $_POST['request_page']=='yatchfacilitymanagement'){

	$id=base64_decode($_POST['id']);
	$post=$_POST;
	$error='';
	
	/*echo $post['yacht_facility_status'];
	echo $post['facility_type'];
	exit();*/
    if($post['facility_name']==''){
    	$error = "Please enter facility name<br>";
    }

	if($post['yacht_facility_status']==''){
		$error.="You forgot to select Yacht facility status!<br>";
	}
	if($post['facility_type']==0){
		$error.="Facility Type required<br>";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']."&id=".$_POST['id']);
	}else{
		$update_img_query = "UPDATE ".$tblprefix."yacht_facility
						                                SET
														yacht_facility_status = '".$post['yacht_facility_status']."',
														facility_name = '".$post['facility_name']."',
														facility_type = '".$post['facility_type']."'
														WHERE id=".base64_decode($_POST['id']);

		$run_query = $db->Execute($update_img_query);

		if($run_query){
			$okmsg = base64_encode("Facility Updated successfully.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($id));
			exit;
		}else{
			
			$okmsg = base64_encode("Unable to Update in database.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".$_POST['id']);
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

if($_GET['mode']=='delete' && $_GET['act']=='yatchfacility' && $_GET['request_page']=='yatchfacilitymanagement'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT facility_type FROM ".$tblprefix."yacht_facility WHERE id =".$id;

	$rs_select = $db->Execute($sel_qry);

	$del_qry = " DELETE FROM ".$tblprefix."yacht_facility WHERE id =".$id;

	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$okmsg = base64_encode("Sadržaj uspješno izbrisan. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}
	else{
		$okmsg = base64_encode("Unable to Delete .!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;

	}

}

//---------Status Code---------
if($_GET['mode']=='change_default' && $_GET['act']=='yatchfacility' && $_GET['request_page']=='yatchfacilitymanagement'){
	// First disable the default language status of all the languages
	$id=base64_decode($_GET['id']);
	$status=$_GET['m_status'];
	//if parent is disable




	// Now activate the status of the currently selected default language
	$sql_currencies= "UPDATE ".$tblprefix."yacht_facility
													SET 
													yacht_facility_status=".$status."
													WHERE
													id=".$id;
	$rs_currencies = $db->Execute($sql_currencies);


	if($rs_currencies){
		$okmsg = base64_encode(" Yacht Facility Status updated successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}else{
		$errmsg = base64_encode(" Yacht Facility Status could not be updated. !");
		header("Location: admin.php?okmsg=$errmsg&act=".$_GET['act']);
		exit;
	}


}
?>	
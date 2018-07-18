<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

if($_POST['mode']=='add' && $_POST['act']=='manage_criteria' && $_POST['request_page']=='criteria_management'){
	
	$criteria_name = addslashes(trim($_POST['criteria_name']));
	
	if($criteria_name == ''){
		$errmsg = base64_encode('Please Enter Criteria Name');
		header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		exit;
	}
    $check_duplicate = "SELECT id FROM ".$tblprefix."criteria WHERE criteria_name='".$criteria_name."'";
    $rs_duplicate = $db->Execute($check_duplicate);
    $count_duplicate =  $rs_duplicate->RecordCount();
    if($count_duplicate>0){
    	$errmsg = base64_encode("Criteria is already entered");
    	header("Location:admin.php?act=".$_POST['act']."&errmsg=".$errmsg);
    	exit();
    }
    else {
	$sql_category= "INSERT INTO ".$tblprefix."criteria
														SET
														
														criteria_name ='".$criteria_name."'
														";

	$rs_category = $db->Execute($sql_category);

	if($rs_category){
		$okmsg = base64_encode("Criteria added successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
		exit;
	}else{
		$okmsg = base64_encode("Could not add Criteria, please try again.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;
	}

}
}
//---------Edit Category---------
if($_POST['mode']=='update' && $_POST['act']=='update_criteria' && $_POST['request_page']=='criteria_management'){
	$criteria_name = addslashes(trim($_POST['criteria_name']));
	
	$id=base64_decode($_POST['id']);

	$_SESSION['criteria_name']= $criteria_name;
	

	if($criteria_name == ''){
		$errmsg = base64_encode('Please Enter Criteria Name');
		header("Location: admin.php?act=update_criteria&errmsg=$errmsg&id=".base64_encode($id));
		exit;
	}else{
    $check_duplicate = "SELECT id FROM ".$tblprefix."criteria WHERE criteria_name='".$criteria_name."' AND id!=".$id;
    $rs_duplicate = $db->Execute($check_duplicate);
    $count_duplicate =  $rs_duplicate->RecordCount();
    if($count_duplicate>0){
    	$errmsg = base64_encode("Criteria is already entered");
    	header("Location:admin.php?act=".$_POST['act']."&errmsg=".$errmsg."&id=".base64_encode($id));
    	exit();
    }else {
		$sql_category= "UPDATE ".$tblprefix."criteria
														SET
														criteria_name = '".$criteria_name."'
														WHERE
														id=".$id;




		$rs_category = $db->Execute($sql_category);

		if($rs_category){
			$okmsg = base64_encode("Criteria updated successfully!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
			exit;
		}
		else{

			$okmsg = base64_encode("Could not update Criteria, please try again!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
		}
	}

}
}
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_criteria' && $_GET['act']=='manage_criteria' && $_GET['request_page']=='criteria_management'){
	$id=base64_decode($_GET['id']);
	$del_qry = " DELETE FROM ".$tblprefix."criteria WHERE id = ".$id;
	$rs_del = $db->Execute($del_qry);

	$okmsg = base64_encode("Criteria deleted successfully!");
	header("Location: admin.php?okmsg=$okmsg&act=manage_criteria");
	exit;
}

?>
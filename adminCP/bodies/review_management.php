<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

if($_POST['mode']=='add' && $_POST['act']=='manage_reviews' && $_POST['request_page']=='review_management'){
	
	$review_name = addslashes(trim($_POST['review_name']));
	
	if($review_name == ''){
		$errmsg = base64_encode('Please Enter Review Name');
		header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		exit;
	}

	$check_duplicate = "SELECT id FROM ".$tblprefix."reviews WHERE reviews_name='".$review_name."'";
    $rs_duplicate = $db->Execute($check_duplicate);
    $count_duplicate =  $rs_duplicate->RecordCount();
    if($count_duplicate>0){
    	$errmsg = base64_encode("Review is already entered");
    	header("Location:admin.php?act=".$_POST['act']."&errmsg=".$errmsg);
    	exit();
    }else {
	$sql_review= "INSERT INTO ".$tblprefix."reviews
														SET
														
														reviews_name ='".$review_name."'
														";
    
	$rs_review = $db->Execute($sql_review);

	if($rs_review){
		$okmsg = base64_encode("Review added successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
		exit;
	}else{
		$okmsg = base64_encode("Could not add Review, please try again.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;
	}

}
}
//---------Edit Category---------
if($_POST['mode']=='update' && $_POST['act']=='update_review' && $_POST['request_page']=='review_management'){
	$review_name = addslashes(trim($_POST['review_name']));
	
	$id=base64_decode($_POST['id']);

	$_SESSION['review_name']= $review_name;
	

	if($review_name == ''){
		$errmsg = base64_encode('Please Enter Review Name');
		header("Location: admin.php?act=update_review&errmsg=$errmsg&id=".base64_encode($id));
		exit;
	}else{
	$check_duplicate = "SELECT id FROM ".$tblprefix."reviews WHERE reviews_name='".$review_name."' AND id!=".$id;
	
    $rs_duplicate = $db->Execute($check_duplicate);
    $count_duplicate =  $rs_duplicate->RecordCount();
    if($count_duplicate>0){
    	$errmsg = base64_encode("Review is already entered");
    	header("Location:admin.php?act=".$_POST['act']."&errmsg=".$errmsg."&id=".base64_encode($id));
    	exit();
    }else {
		$sql_review= "UPDATE ".$tblprefix."reviews
														SET
														reviews_name = '".$review_name."'
														WHERE
														id=".$id;




		$rs_review = $db->Execute($sql_review);

		if($rs_review){
			$okmsg = base64_encode("Review updated successfully!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
			exit;
		}
		else{

			$okmsg = base64_encode("Could not update Review, please try again!");
			header("Location: admin.php?errmsg=$okmsg&act=".$_POST['act']);
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
if($_GET['mode']=='del_review' && $_GET['act']=='manage_reviews' && $_GET['request_page']=='review_management'){
	$id=base64_decode($_GET['id']);
	$del_qry = " DELETE FROM ".$tblprefix."reviews WHERE id = ".$id;
	$rs_del = $db->Execute($del_qry);

	$okmsg = base64_encode("Review deleted successfully!");
	header("Location: admin.php?okmsg=$okmsg&act=manage_reviews");
	exit;
}

?>
<?php
######################
#
# 	POST SECTION
#
######################

//---------Edit Category---------

if($_POST['mode']=='update' && $_POST['act']=='comments_management' && $_POST['request_page']=='comment_management')
{

	
	$id=base64_decode($_POST['id']);
	$comment_status = $_POST['status'];
	$comments_type = $_POST['comment_type'];
	$comments = addslashes($_POST['comments']);


	if($comments == ''){
		$errmsg = base64_encode('Please Enter Comment');
		header("Location: admin.php?act=editcomments&id=".base64_encode($id)."&errmsg=$errmsg");
		exit;
	}

	


	//upload in the edit form
	//image upload code from here
	$error='';
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?act=editcomments&id=".base64_encode($id)."&errmsg=$errmsg");
		exit();
	}else{

		
		$sql_update= "UPDATE ".$tblprefix."property_comments set
										status = '".$comment_status."',
										comment_type = '".$comments_type."',
										comment_description ='".$comments."'
										WHERE
										id=".$id;
		

		$run_query = $db->Execute($sql_update);
		if($run_query)
		{
			$okmsg = base64_encode("Comment Updated successfully.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
		}else{
			$okmsg = base64_encode("Unable to Update Comment in database.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
		}
	}
}

######################
#
# 	GET SECTION
#
######################




//---------Delete THe Category and its language contents---------
if($_GET['mode']=='del_comments' && $_GET['act']=='comments_management' && $_GET['request_page']=='comment_management'){
	$id=base64_decode($_GET['id']);

	
	$del_comments = " DELETE FROM ".$tblprefix."property_comments WHERE id = ".$id." ";
	$rs_commments = $db->Execute($del_comments);


	$okmsg = base64_encode("Comment Deleted successfully. !");
	header("Location: admin.php?okmsg=$okmsg&act=comments_management");
	exit;
}


//---------Delete THe Category and its language contents---------
if($_GET['mode']=='change_commentstatus' && $_GET['act']=='comments_management' && $_GET['request_page']=='comment_management'){
	$id=base64_decode($_GET['id']);

	$status=$_GET['m_status'];

	if($status == 1){
		$newstatus = 0;
	}elseif( $status == 0){
		$newstatus = 1;
	}
	$update_qry = " UPDATE ".$tblprefix."property_comments SET
		                                                  status = '".$newstatus."'
														  WHERE id          = '".$id."' ";
   
	
	$rs_newsletter = $db->Execute($update_qry);

	$okmsg = base64_encode("Comment  Status UPDATED successfully. !");
	header("Location: admin.php?errmsg=$okmsg&act=comments_management");
	exit;
}

//---------Service Provider Status---------




?>
<?php
// EDIT CONTENT
if($_POST['mode']=='update' && $_POST['act']=='edit_resume_views'){ 
echo $id=base64_decode($_POST['id']);  die;
$post=$_POST;
$error='';
//if($post['page_title']==''){
//	$error="Page Title is compulsory<br>";
//}
if($post['pm_id']==0)
{
	$error = "Select Property Manager";
}
if(trim($post['candidate_id'])=='')
{
	$error = "Please Enter Candidate Name";
}

if($post['no_of_views']==''){
	$error.="Please Enter Number Of Views<br>";
}

if($post['limit_flag']==''){
	$error.="Please Select Limit Flag Option<br>";
}

if($post['view_limit']==''){
	$error.="Please Enter Number Of Views Limit<br>";
}

if($error!=''){
	$msg=base64_encode($error);
	header("Location: admin.php?errmsg=$msg&act=edit_resume_views&pageid=".base64_encode($id)."");
	exit();
}else{
		$no_of_views= $post['no_of_views'];
		$limit_flag = $post['limit_flag'];
		$view_limit = $post['view_limit'];

	 	$qry_update = "UPDATE ".$tblprefix."resume_views SET 
								    no_of_views = '".$no_of_views."',
                                                                    limit_flag = '".$limit_flag."',
								    view_limit = '".$view_limit."' 
                                                                    WHERE id = ".$id;  
		$rs = $db->Execute($qry_update);
		if($rs){
		// collect all the posted values and get the translated language ids 
		$my_post=$_POST;
		        $msg=base64_encode("$pagename Contents Updated successfully.");
			header("Location: admin.php?okmsg=$msg&act=contentpage");
		}else{
			$msg=base64_encode("Contents could not be updated");
			header("Location: admin.php?errmsg=$msg&act=contentpage");
		}
		exit;
	}
}

	
?>
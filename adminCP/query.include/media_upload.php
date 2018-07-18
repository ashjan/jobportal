<?php 
#####################
#
# 	Media Image add
#
#####################

if($_POST['mode']=='add' && $_POST['act']=='mediaimages' && $_POST['request_page']=='media_upload'){ 
	$post=$_POST;
	$error='';
	$id = addslashes(trim($_POST['id']));
	
		$images=$_FILES['image'];
                $count=count($images['name']);
		$errmsg='';
		$okmsg='';
		for($i=0; $i<$count; $i++){
			$type = explode("/", $images['type'][$i]);
			$size = $images['size'][$i];
			if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png"){
				$errmsg .= base64_encode(" image format was wrong!<br>");
			}else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];

				$sel_qry = "SELECT * FROM ".$tblprefix."users WHERE profile_pic ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".".$type[1];

				}

				$filename = BASE_URL."uploads/profile_images/".$imagename;
				$target_path = BASE_URL."uploads/profile_images/";
				$info = getimagesize($_FILES['image']['tmp_name'][$i]);
//echo $target_path.$imagename;die;
				if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_path)){
				
					   
					$update_img_query = "UPDATE ".$tblprefix."users SET
												profile_pic= '".$imagename."'
												WHERE id= ".$id.""; 
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$okmsg.= base64_encode("image inserted successfully!\n");
						
					}else{
						$errmsg.= base64_encode("image not inserted to DB!");
					}
				
				}else{
					$errmsg.= base64_encode("Unable to upload ".$i." image!<br>");
				}
			}
		}
		header("Location: admin.php?msg=$msg&errmsg=$errmsg&act=".$_POST['act']);
		exit;
	

}

########################
#
# Update Media Image 
#
########################

if($_POST['mode']=='update' && $_POST['act']=='editmediaimages' && $_POST['request_page']=='media_upload'){
	$post=$_POST;

	$id=base64_decode($_POST['id']);
	if(!empty($_FILES['image']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
			$imagename = $image_name_rand.".".$type[1];
			$filename = BASE_URL."uploads/profile_images/".$imagename;
			$target_path = BASE_URL."uploads/profile_images/";
			$info = getimagesize($_FILES['image']['tmp_name']);

			if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){

				if($_POST['old_image']!=""){
					if(file_exists($target_path.$_POST['old_image'])){
						@unlink($target_path.$_POST['old_image']);
					}
				}

			
					 
					  
					 
					  $update_img_query = "UPDATE ".$tblprefix."users SET
												profile_pic= '".$imagename."'
												WHERE id= ".$id."";
					  $run_query = $db->Execute($update_img_query);
					 
					  
	                 
			
			
			}else{
				$okmsg = base64_encode("Unable to upload  image.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}
			
		}
	} 

}


#####################
#
# DELETE Media Image
#
#####################
if($_GET['mode']=='delete' && $_GET['act']=='mediaimages' && $_GET['request_page']=='media_upload'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT profile_pic FROM ".$tblprefix."users WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['profile_pic'];
	$del_qry = " DELETE profile_pic FROM ".$tblprefix."Users WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$target_path = "".BASE_URL."uploads/profile_images/";
		if(file_exists($target_path.$image_name)){
			@unlink($target_path.$image_name);
		}
		$msg = base64_encode("Image Deleted successfully. !");
		header("Location: admin.php?msg=$msg&act=".$_GET['act']);
		exit;
	}
	else{
		$errmsg = base64_encode("Unable to Delete .!");
		header("Location: admin.php?errmsg =$errmsg&act=".$_GET['act']);
		exit;

	}

}



?>
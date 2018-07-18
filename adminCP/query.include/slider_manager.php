<?php 
// image media add
if($_POST['mode']=='add' && $_POST['act']=='slider_management' && $_POST['request_page']=='slider_manager'){
	$post=$_POST;
	$error='';
	$image_title = $post['image_title'];
	$image = addslashes(trim($_POST['userfile']));
	
	if($image_title==''){
		$error.= "Image title is required<br/>";
	}
	$file = $_FILES['userfile'];
	if($file['name']==''){
		$error.="Image file is required<br>";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
		exit;
	}else{
		$images=$_FILES['userfile'];
		$count=count($images['name']);
		$errmsg='';
		$okmsg='';
		
			$type = explode("/", $images['type']);
			$size = $images['size'][$i];
			
			if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png"){
				$errmsg .= base64_encode("Image format was wrong!<br>");
			}else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];

				$sel_qry = "SELECT * FROM ".$tblprefix."slider_images WHERE image_title ='".$image_title."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".".$type[1];

				}

				$filename = MYSURL."media/slider/".$imagename;
				$target_path = "media/slider/";
				$info = getimagesize($_FILES['userfile']['tmp_name']);
               
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path.$imagename)){

					  $update_img_query = "INSERT ".$tblprefix."slider_images SET
												image_title = '".$post['image_title']."',
												image= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
				          
               
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$msg.= base64_encode("Image inserted successfully!\n");
					}else{
						$errmsg.= base64_encode("Image not inserted to DB!");
					}
				}else{
					$errmsg.= base64_encode("Unable to upload image!<br>");
				}

			}

		
		header("Location: admin.php?msg=$msg&errmsg=$errmsg&act=".$_POST['act']);
		exit;
	}
}


// image media update



if($_POST['mode']=='update' && $_POST['act']=='editsliderimages' && $_POST['request_page']=='slider_manager'){
	$post=$_POST;

	$error='';
	
	$id=base64_decode($_POST['id']);
	$image_title = addslashes(trim($_POST['image_title']));

	if($image_title == ''){
		$error.="Image title is empty <br>";
		
	}

	
	
	
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=editsliderimages&id=".$_POST['id']);
		exit;
	}
	

	if(!empty($_FILES['image']['name'])){
		
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("Image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=editsliderimages&id=".base64_encode($_POST['id']));
			exit();
		}else{
			$imagename = $image_name_rand.".".$type[1];
			$filename = MYSURL."media/slider/".$imagename;
			$target_path = "media/slider/";
			$info = getimagesize($_FILES['image']['tmp_name']);

			
			if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
                
				if($_POST['old_image']!=""){
					if(file_exists($target_path.$_POST['old_image'])){
						@unlink($target_path.$_POST['old_image']);
					}
				}


				$update_img_query = "UPDATE ".$tblprefix."slider_images SET
												image_title = '".$image_title."',
												image= '".$imagename."',
												image_full_path= '".$filename."'
												where id=".$id;



				$run_query = $db->Execute($update_img_query);

				if($run_query){
					$msg.= base64_encode("image inserted successfully!\n");
					header("Location: admin.php?okmsg=$msg&act=slider_management");
				exit;
				}else{
					$errmsg.= base64_encode("image not inserted to DB!");
					header("Location: admin.php?errmsg=$errmsg&act=slider_management");
				exit;
				}
			}else{
				$okmsg = base64_encode("Unable to upload  image.!");
				header("Location: admin.php?okmsg=$okmsg&act=editsliderimages&id=".base64_encode($_POST['id']));
				exit;
			}
			//}
		}
	} else {
		$imagename = $_POST['old_image'];
		$id = base64_decode($_POST['id']);
		$filename = MYSURL."media/slider/".$imagename;
		$update_img_query = "UPDATE ".$tblprefix."slider_images SET
												image_title = '".$image_title."',
												image= '".$imagename."',
												image_full_path= '".$filename."'
												where id=".$id;
		
		
		$run_query = $db->Execute($update_img_query);
	    if($run_query){
					$msg.= base64_encode("Naziv slike uspješno ažuriran!\n");
				}else{
					$errmsg.= base64_encode("Image tile not updated!");
				}
		
		header("Location: admin.php?okmsg=$msg&errmsg=$errmsg&act=slider_management");
		exit;

	}

}



######################
#
# 	GET SECTION
#
######################


// image media delete

if($_GET['mode']=='delete' && $_GET['act']=='slider_management' && $_GET['request_page']=='slider_manager'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT image FROM ".$tblprefix."slider_images WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['image'];
	$del_qry = " DELETE FROM ".$tblprefix."slider_images WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$target_path = "media/slider/";
		if(file_exists($target_path.$image_name)){
			@unlink($target_path.$image_name);
		}
		$okmsg = base64_encode("Image Deleted successfully. !");
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
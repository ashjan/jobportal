<?php 
// image media add
if($_POST['mode']=='add' && $_POST['act']=='manage_car_images' && $_POST['request_page']=='car_media_upload'){
$post=$_POST;
$error='';

						$property_id = addslashes(trim($_POST['property_name']));
						$pm_id = addslashes(trim($_POST['first_name']));
						
if($post['images_title']==''){
	$error="Title is required<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit;
}else{
$images=$_FILES['image'];
$count=count($images['name']);
$errmsg='';
$okmsg='';
for($i=0; $i<$count; $i++){
		$type = explode("/", $images['type'][$i]);
		$size = $images['size'][$i];
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png"){
			$errmsg .= base64_encode("image".$i." image format was wron!<br>");
		}
		elseif($size>5000000){
			$errmsg.= base64_encode("image".$i."must be less than 5 MB!<br>");		
		}
		else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];
				xy:
				$sel_qry = "SELECT * FROM ".$tblprefix."mediaimages WHERE image_name ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".".$type[1];
					goto xy;
				}
				
				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name'][$i]);
				
				if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_path.$imagename)){
					$update_img_query = "INSERT ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												image_title = '".$post['images_title']."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
												
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$msg.= base64_encode("image inserted successfully!\n");
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
} 


// image media update



if($_POST['mode']=='update' && $_POST['act']=='manage_car_images' && $_POST['request_page']=='car_media_upload'){

$post=$_POST;


$error='';
								$property_id = addslashes(trim($_POST['property_name']));
								$pm_id = addslashes(trim($_POST['first_name']));
								$id=base64_decode($_POST['id']);
								$image_title = addslashes(trim($_POST['image_title']));
								
if(!empty($_FILES['image']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);

			/*	if($info[0] > 200 and $info[1] > 200) {
						$okmsg = base64_encode("image must be less then '200 X 200'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
						exit;				
				}else{*/
						if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){			
						
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
						
               $update_img_query = "UPDATE ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												image_title = '".$image_title."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
						
						
								
					$run_query = $db->Execute($update_img_query);
							
							if($run_query){
						$msg.= base64_encode("image inserted successfully!\n");
					}else{
						$errmsg.= base64_encode("image not inserted to DB!");
					}
						}else{
							$okmsg = base64_encode("Unable to upload  image.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
							exit;
						}		
			//}
		}
}

	}
 

	   
######################
#
# 	GET SECTION
#
######################


// image media delete

if($_GET['mode']=='delete' && $_GET['act']=='manage_car_images' && $_GET['request_page']=='car_media_upload'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT image_name FROM ".$tblprefix."mediaimages WHERE id =".$id;
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['image_name'];
		$del_qry = " DELETE FROM ".$tblprefix."mediaimages WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "media/images/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		$okmsg = base64_encode("Image Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
}

// vidio media add

if($_POST['mode']=='add' && $_POST['act']=='mediaivideos' && $_POST['request_page']=='car_media_upload'){
$post=$_POST;
$error='';
if($post['video_title']==''){
	$error="Title is required<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit;
}else{
		$video=$_FILES['video'];
 		$size=$video['size'];
		$type = explode(".", $video['name']);
		$size = $video['size'];
		if($size > 10000000){//18 MB
			$errmsg = base64_encode("Video must be less than 10 MB");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;				
		}
		if($type[1]!="flv"){
			$errmsg = base64_encode("Only flv videos allowed");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;				
		}
		else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];
				
				
				xyz:
				$sel_qry = "SELECT * FROM ".$tblprefix."mediaivideos WHERE video_name ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".flv";
					goto xyz;
				}
				
				$filename = MYSURL."media/videos/".$imagename;
				$target_path = "media/videos/";
				$info = getimagesize($_FILES['video']['tmp_name']);
				
				if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path.$imagename)){
	 						$update_img_query = "INSERT ".$tblprefix."mediaivideos SET
												property_id = 2,
												video_title = '".$post['video_title']."',
												thumb_image ='dsdfdf.jpv',
												video_name= '".$imagename."',
												video_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$okmsg.= base64_encode("video".$i." inserted successfully!\n");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;			
					}else{
						$errmsg.= base64_encode("Video".$i." not inserted to DB!");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
						exit;			
						
					}
				}else{
					$errmsg.= base64_encode("Unable to upload ".$i." image!<br>");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;			

				}		

		}
		
	}

}
?>
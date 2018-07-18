<?php 
if($_POST['mode']=='addbadgefree' && $_POST['act']=='freeimage' && $_POST['request_page']=='manage_freeimages'){
$post=$_POST;
$_SESSION['landmark_icon'] = $_POST['landmark_icon_old'];
$error='';
if(empty($_FILES['landmark_icon']['name']))
{	
	//$error.="Image Field is Required";
	$error.="Polje za sliku je obavezno";
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
if(!empty($_FILES['landmark_icon']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['landmark_icon']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			//$okmsg = base64_encode("Image must be of image format.!");
			$okmsg = base64_encode("Image must be of image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = "graphics/thumbnail_upload/".$imagename; 
				$target_path = "graphics/thumbnail_upload/";
				$info = getimagesize($_FILES['landmark_icon']['tmp_name']);
						if(move_uploaded_file($_FILES['landmark_icon']['tmp_name'], $target_path.$imagename)){
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
							
						
							
						$update_img_query = "UPDATE ".$tblprefix."free_badge SET 
														badge_path= '".$imagename."' 
														WHERE id='1'"; 
						$run_query = $db->Execute($update_img_query);
							
							if($run_query){
								//$okmsg = base64_encode("Badge Image Updated successfully.!");
								$okmsg = base64_encode("Slika za bedž uspješno dodat.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$okmsg = base64_encode("Unable to Update Badge Image in database.!");
								$okmsg = base64_encode("Podvrsta nije Slika za bedž ažurirano.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							//$okmsg = base64_encode("Unable to upload Picture.!");
							$okmsg = base64_encode("Slika nije dodata.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
							exit;
						}
						
						//unset($_SESSION['add_sees']);		
			
		}
}

	}
}
?>

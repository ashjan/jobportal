<?php	
if($_POST['mode']=='add' && $_POST['act']=='manage_hotel' && $_POST['request_page']=='hotel_management'){
$post=$_POST;
$error='';
if($post['themes_name']==''){
	$error="Theme Name required<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['themes_image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/themes_upload/".$imagename;
				$target_path = "graphics/themes_upload/";
				$info = getimagesize($_FILES['themes_image']['tmp_name']);

				if($info[0] > 900 and $info[1] > 900) {
						$okmsg = base64_encode("image must be less then '900 X 900'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;				
				}else{
						if(move_uploaded_file($_FILES['themes_image']['tmp_name'], $target_path.$imagename)){
						$update_img_query = "INSERT ".$tblprefix."hotal_themes SET
														themes_name = '".$post['themes_name']."',
														themes_image  = '".$post['themes_image']."',
														accomm_imge= '".$imagename."'";
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Theme inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Theme in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							$okmsg = base64_encode("Unable to upload  image.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
							exit;
						}		
			}
		}

	}
} 

//Update Section

if($_POST['mode']=='update' && $_POST['act']=='manage_hotel' && $_POST['request_page']=='hotel_management'){
$post=$_POST;
$error='';


if($post['themes_name']==''){
	$error="Theme  Name required<br>";
}



if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
if(!empty($_FILES['themes_image']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['themes_image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/themes_upload/".$imagename;
				$target_path = "graphics/themes_upload/";
				$info = getimagesize($_FILES['themes_image']['tmp_name']);

				if($info[0] > 900 and $info[1] > 900) {
						$okmsg = base64_encode("image must be less then '900 X 900'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
						exit;				
				}else{
						if(move_uploaded_file($_FILES['themes_image']['tmp_name'], $target_path.$imagename)){
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
						$update_img_query = "UPDATE ".$tblprefix."hotal_themes SET
														themes_name = '".$post['themes_name']."',
														themes_image= '".$post['themes_image']."'
														WHERE id=".$_POST['id']
														;
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Theme Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}
						}else{
							$okmsg = base64_encode("Unable to upload  Theme image.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
							exit;
						}		
			}
		}
}
else{
						$update_img_query = "UPDATE ".$tblprefix."hotal_themes SET
														themes_name= '".$post['themes_name']."',
														themes_image= '".$post['themes_image']."'
														WHERE id=".base64_decode($_POST['id'])
														;
														
														
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Theme Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
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


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_hotel' && $_GET['request_page']=='hotel_management'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT themes_name FROM ".$tblprefix."hotal_themes WHERE id =".$id;
	
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['themes_image'];
		
		$del_qry = " DELETE FROM ".$tblprefix."hotal_themes WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/themes_upload/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		$okmsg = base64_encode("Theme Deleted successfully. !");
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
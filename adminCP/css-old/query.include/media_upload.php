<?php 
######################
#
# 	Media Image add
#
######################
if($_POST['mode']=='add' && $_POST['act']=='mediaimages' && $_POST['request_page']=='media_upload'){
	$post=$_POST;
	$error='';
	$property_id = addslashes(trim($_POST['property_id']));
	// "room_type" will come from ajax response
	$room_id = addslashes(trim($_POST['room_id']));
	$pm_id = addslashes(trim($_POST['first_name']));
	$image_title = addslashes(trim($_POST['images_title']));
	
	if($property_id == 0){
		$error.="Pleas Select Property  <br/>";
	}

	if($pm_id == 0){
		$error.="Please Select PM Name <br/>";
	}

	if($post['images_title']==''){
		$error.="Title is required <br/>";
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
				$errmsg .= base64_encode(" image format was wrong!<br>");
			}else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];

				$sel_qry = "SELECT * FROM ".$tblprefix."mediaimages WHERE image_name ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".".$type[1];

				}

				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name'][$i]);
				if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_path.$imagename)){
					  /*  if($room_id=='0000'){
					   $get_all_rooms_qry = "SELECT ".$tblprefix."rooms.id 
					                            FROM ".$tblprefix."rooms 
                                                WHERE 
												".$tblprefix."rooms.pm_id = ".$pm_id." AND
												".$tblprefix."rooms.property_id = ".$property_id;
					  
					  $run_get_all_rooms_query = $db->Execute($get_all_rooms_qry);
					  while(!$run_get_all_rooms_query->EOF){
					  $room_id = $run_get_all_rooms_query->fields['id'];
					  $update_img_query = "INSERT ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$post['images_title']."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
					  $run_query = $db->Execute($update_img_query);
					  $run_get_all_rooms_query->MoveNext();
					  }
	                  }else{ */
					 
					 $update_img_query = "INSERT ".$tblprefix."mediaimages 
					                      SET   pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
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
				//  }
					
					
					
				}else{
					$errmsg.= base64_encode("Unable to upload ".$i." image!<br>");
				}

			}

		}
		header("Location: admin.php?msg=$msg&errmsg=$errmsg&act=".$_POST['act']);
		exit;
	}
}
#####################
#
# Update Media Image 
#
#####################

if($_POST['mode']=='update' && $_POST['act']=='mediaimages' && $_POST['request_page']=='media_upload'){
	
	$id=base64_decode($_POST['id']);
	// "room_type" will come from ajax response
	$room_id = $_POST['room_id'];
	$pm_id = $_POST['first_name'];
	
	$post=$_POST;
	$error='';
	$property_id = $_POST['property_id'];


	$image_title = addslashes(trim($_POST['image_title']));

	if($property_id == 0){
		$error="Pleas Select Property <br>";		
	}

	if($pm_id == 0){
		$error="Please Select PM Name <br>";		
	}
	
	if($post['image_title']==''){
		$error="Please Enter Title<br>";		
	}
	if($error!=''){
		$errmsg=base64_encode($error);
		header("Location: admin.php?errmsg=$errmsg&act=editmediaimages&id=".$_POST['id']);
		exit;
	}	

	if(!empty($_FILES['image']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$errmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?errmsg=$errmsg&act=editmediaimages&id=".$_POST['id']);
			exit();
		}else{
			$imagename = $image_name_rand.".".$type[1];
			$filename = MYSURL."media/images/".$imagename;
			$target_path = "media/images/";
			$info = getimagesize($_FILES['image']['tmp_name']);
			if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){

				if($_POST['old_image']!=""){
					if(file_exists($target_path.$_POST['old_image'])){
						@unlink($target_path.$_POST['old_image']);
					}
				}
			 if($room_id=='all'){
					   $get_all_rooms_qry = "SELECT ".$tblprefix."rooms.id 
					                            FROM ".$tblprefix."rooms 
                                                WHERE 
												".$tblprefix."rooms.pm_id = ".$pm_id." AND
												".$tblprefix."rooms.property_id = ".$property_id;
					  
					  $run_get_all_rooms_query = $db->Execute($get_all_rooms_qry);
					  while(!$run_get_all_rooms_query->EOF){
					  $room_id = $run_get_all_rooms_query->fields['id'];
					  $update_img_query = "INSERT ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$post['images_title']."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
					  $run_query = $db->Execute($update_img_query);
					  $run_get_all_rooms_query->MoveNext();
					  }
	                  }else{
				$update_img_query = "UPDATE ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$image_title."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
				$run_query = $db->Execute($update_img_query);

				if($run_query){
					$okmsg.= base64_encode("image Update successfully!\n");
					header("Location: admin.php?okmsg=$okmsg&act=mediaimages&id=".base64_encode($_POST['id']));
					exit;
				}else{
					$errmsg = base64_encode("Unable to Update in database!");				
					header("Location: admin.php?errmsg=$errmsg&act=editmediaimages&id=".$_POST['id']);
					exit;
				}
			 }
			 
			 
			}else{
					$errmsg = base64_encode("Unable to upload  image.!");
					header("Location: admin.php?errmsg=$errmsg&act=editmediaimages&id=".$_POST['id']);
					exit;
			}
			
		}
	} else {
		$imagename = $_POST['old_image'];
		$id = base64_decode($_POST['id']);
		$filename = MYSURL."media/images/".$imagename;
		$update_img_query = "UPDATE ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$image_title."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
		
		$run_query = $db->Execute($update_img_query);	
		$okmsg = base64_encode("Image Update successfully.!");
		header("Location: admin.php?okmsg=$okmsg&act=editmediaimages&id=".$_POST['id']);
		exit;
	}

}

#####################
#
# 	Media Image1 add
#
#####################

if($_POST['mode']=='add' && $_POST['act']=='mediaimages1' && $_POST['request_page']=='media_upload'){
	$post=$_POST;
	$error='';
	$property_id = addslashes(trim($_POST['property_id']));
	// "room_type" will come from ajax response
	$room_id = addslashes(trim($_POST['room_id']));
	$pm_id = addslashes(trim($_POST['first_name']));
	$image_title = addslashes(trim($_POST['images_title']));
	
	if($property_id == 0){
		$error.="Pleas Select Property <br>";
	}

	if($pm_id == 0){
		$error.="Please Select PM Name<br>";
	}

	if($post['images_title']==''){
		$error.="Title is required<br>";
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
				$errmsg .= base64_encode(" image format was wrong!<br>");
			}else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];

				$sel_qry = "SELECT * FROM ".$tblprefix."mediaimages WHERE image_name ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".".$type[1];

				}

				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name'][$i]);

				if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_path.$imagename)){
				 if($room_id=='all'){
					   $get_all_rooms_qry = "SELECT ".$tblprefix."rooms.id 
					                            FROM ".$tblprefix."rooms 
                                                WHERE 
												".$tblprefix."rooms.pm_id = ".$pm_id." AND
												".$tblprefix."rooms.property_id = ".$property_id;
					  
					  $run_get_all_rooms_query = $db->Execute($get_all_rooms_qry);
					  while(!$run_get_all_rooms_query->EOF){
					  $room_id = $run_get_all_rooms_query->fields['id'];
					  $update_img_query = "INSERT ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$post['images_title']."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
					  $run_query = $db->Execute($update_img_query);
					  $run_get_all_rooms_query->MoveNext();
					  }
	                  }else{
					  $update_img_query = "INSERT ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$post['images_title']."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												";
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$okmsg.= base64_encode("image inserted successfully!\n");
						
					}else{
						$errmsg.= base64_encode("image not inserted to DB!");
					}
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

########################
#
# Update Media Image1 
#
########################

if($_POST['mode']=='update' && $_POST['act']=='mediaimages1' && $_POST['request_page']=='media_upload'){
	$post=$_POST;

	$error='';
	$property_id = $_POST['property_id'];
	// "room_type" will come from ajax response
	$room_id = $_POST['room_id'];
	$pm_id = $_POST['first_name'];
	$id=base64_decode($_POST['id']);
	$image_title = addslashes(trim($_POST['image_title']));

	if($property_id == 0){
		$error.="Pleas Select Property <br>";
		
	}

	if($pm_id == 0){
		$error.="Please Select PM Name <br>";
		
	}
	
	if($post['image_title']==''){
		$error.="Please Enter Title<br>";
		
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=editmediaimages1&id=".$_POST['id']);
		exit;
	}
	

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
						@unlink($target_path.$_POST['old_image']);
					}
				}

			 if($room_id=='all'){
					   $get_all_rooms_qry = "SELECT ".$tblprefix."rooms.id 
					                            FROM ".$tblprefix."rooms 
                                                WHERE 
												".$tblprefix."rooms.pm_id = ".$pm_id." AND
												".$tblprefix."rooms.property_id = ".$property_id;
					  
					  $run_get_all_rooms_query = $db->Execute($get_all_rooms_qry);
					  while(!$run_get_all_rooms_query->EOF){
					  $room_id = $run_get_all_rooms_query->fields['id'];
					  $update_img_query = "UPDATE ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												image_title = '".$post['images_title']."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												WHERE id= ".$id." AND room_id = ".$room_id;
					  $run_query = $db->Execute($update_img_query);
					  $run_get_all_rooms_query->MoveNext();
					  }
	                  }else{
				$update_img_query = "UPDATE ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$image_title."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;



				$run_query = $db->Execute($update_img_query);

				if($run_query){
					$okmsg.= base64_encode("image inserted successfully!\n");
					
				}else{
					$errmsg.= base64_encode("image not inserted to DB!");
				}
			}
			
			
			}else{
				$okmsg = base64_encode("Unable to upload  image.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}
			//}
		}
	} else {
		$imagename = $_POST['old_image'];
		$id = base64_decode($_POST['id']);
		$filename = MYSURL."media/images/".$imagename;
		$update_img_query = "UPDATE ".$tblprefix."mediaimages SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												image_title = '".$image_title."',
												image_name= '".$imagename."',
												image_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
		
		$run_query = $db->Execute($update_img_query);
		$okmsg = base64_encode("Image Update successfully.!");
		header("Location: admin.php?okmsg=$okmsg&act=editmediaimages1&id=".$_POST['id']);
		exit;		

	}

}

#####################
#
# DELETE Media Image1 
#
#####################
if($_GET['mode']=='delete' && $_GET['act']=='mediaimages1' && $_GET['request_page']=='media_upload'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT image_name FROM ".$tblprefix."mediaimages WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['image_name'];
	$del_qry = " DELETE FROM ".$tblprefix."mediaimages WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$target_path = "media/images/";
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
#####################
#
# DELETE Media Image
#
#####################
if($_GET['mode']=='delete' && $_GET['act']=='mediaimages' && $_GET['request_page']=='media_upload'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT image_name FROM ".$tblprefix."mediaimages WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['image_name'];
	$del_qry = " DELETE FROM ".$tblprefix."mediaimages WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$target_path = "media/images/";
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
#####################
#
# DELETE Media videos 
#
#####################

if($_GET['mode']=='delete' && $_GET['act']=='mediaivideos' && $_GET['request_page']=='media_upload'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT video_name FROM ".$tblprefix."mediaivideos WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['video_name'];
	$del_qry = " DELETE FROM ".$tblprefix."mediaivideos WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$target_path = "media/videos/";
		if(file_exists($target_path.$image_name)){
			@unlink($target_path.$image_name);
		}
		$okmsg = base64_encode("Video Deleted successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}
	else{
		$okmsg = base64_encode("Unable to Delete .!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;

	}

}
######################
#
# DELETE Media videos1 
#
######################

if($_GET['mode']=='delete' && $_GET['act']=='mediaivideos1' && $_GET['request_page']=='media_upload'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT video_name FROM ".$tblprefix."mediaivideos WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['video_name'];
	$del_qry = " DELETE FROM ".$tblprefix."mediaivideos WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$target_path = "media/videos/";
		if(file_exists($target_path.$image_name)){
			@unlink($target_path.$image_name);
		}
		$okmsg = base64_encode("Video Deleted successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}
	else{
		$okmsg = base64_encode("Unable to Delete .!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;

	}

}
###################
#
# Add Media videos 
#
###################

if($_POST['mode']=='add' && $_POST['act']=='mediaivideos' && $_POST['request_page']=='media_upload'){

	$post=$_POST;
	$error='';
	if($post['video_title']==''){
		$error="Title is required <br>";
	}
	if($post['first_name']==0){
		
		$error .= "Select Property Manager <br>";
	}
	if($post['property_id']==0){
		
		$error .= "Select Property <br>";
	}
	$room_id = $_POST['room_id'];
	
     
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
		exit;
	}else{
		$video=$_FILES['video'];
		$size=$video['size'];
		$type = explode(".", $video['name']);
		$size = $video['size'];
		if($size > 26214400){//25 MB
			$errmsg = base64_encode("Video must be less than 25 MB");
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



			$sel_qry = "SELECT * FROM ".$tblprefix."mediaivideos WHERE video_name ='".$imagename."'";
			$rs_select = $db->Execute($sel_qry);

			if($rs_select->fields){
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".flv";

			}

			$filename = MYSURL."media/videos/".$imagename;
			$target_path = "media/videos/";
			$info = getimagesize($_FILES['video']['tmp_name']);

			if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path.$imagename)){
			 	$update_img_query = "INSERT ".$tblprefix."mediaivideos SET
												property_id = ".$post['property_id'].",
												room_id = ".$room_id.",
												pm_id = ".$post['first_name'].",
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
#####################
#
# Add Media videos1 
#
#####################
if($_POST['mode']=='add' && $_POST['act']=='mediaivideos1' && $_POST['request_page']=='media_upload'){

	$post=$_POST;
	$error='';
	if($post['video_title']==''){
		$error="Title is required <br>";
	}
	if($post['first_name']==0){
		
		$error .= "Select Property Manager <br>";
	}
	if($post['property_id']==0){
		
		$error .= "Select Property <br>";
	}
	$room_id = $_POST['room_id'];
	
     
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
		exit;
	}else{
		$video=$_FILES['video'];
		$size=$video['size'];
		$type = explode(".", $video['name']);
		$size = $video['size'];
		if($size > 26214400){//25 MB
			$errmsg = base64_encode("Video must be less than 25 MB");
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



			$sel_qry = "SELECT * FROM ".$tblprefix."mediaivideos WHERE video_name ='".$imagename."'";
			$rs_select = $db->Execute($sel_qry);

			if($rs_select->fields){
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".flv";

			}

			$filename = MYSURL."media/videos/".$imagename;
			$target_path = "media/videos/";
			$info = getimagesize($_FILES['video']['tmp_name']);

			if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path.$imagename)){
			 	$update_img_query = "INSERT ".$tblprefix."mediaivideos SET
												property_id = ".$post['property_id'].",
												room_id = ".$room_id.",
												pm_id = ".$post['first_name'].",
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
#####################
#
# Update Media videos
#
#####################
if($_POST['mode']=='update' && $_POST['act']=='mediaivideos' && $_POST['request_page']=='media_upload'){

	$post=$_POST;

	$error='';
	$property_id = $_POST['property_id'];
	$room_id = $_POST['room_id'];
	$pm_id = $_POST['first_name'];
	$id=base64_decode($_POST['id']);
	$image_title = addslashes(trim($_POST['video_title']));
    if($post['video_title']==''){
		$error="Title is required <br>";
	}
	if($post['first_name']==0){
		
		$error .= "Select Property Manager <br>";
	}
	if($post['property_id']==0){
		
		$error .= "Select Property <br>";
	}
     
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act2']."&id=".$_POST['id']);
		exit;
	}else{
	
	

	if(!empty($_FILES['video']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['video']['name']);
		if($size > 26214400){//25 MB
			$errmsg = base64_encode("Video must be less than 25 MB");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit;
		}
		if($type[1]!="flv"){
			$okmsg = base64_encode("video must be flv format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
			$imagename = $image_name_rand.".".$type[1];
			$filename = MYSURL."media/videos/".$imagename;
			$target_path = "media/videos/";
			$info = getimagesize($_FILES['video']['tmp_name']);

			/*	if($info[0] > 200 and $info[1] > 200) {
			$okmsg = base64_encode("image must be less then '200 X 200'");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit;
			}else{*/
			if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path.$imagename)){
				if($_POST['old_video']!=""){
					if(file_exists($target_path.$_POST['old_video'])){
						@unlink($target_path.$_POST['old_video']);
					}
				}
					
					
				  $update_img_query = "UPDATE ".$tblprefix."mediaivideos SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												video_title = '".$image_title."',
												video_name= '".$imagename."',
												video_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
												



				$run_query = $db->Execute($update_img_query);

				if($run_query){
					$msg.= base64_encode("video updated successfully!\n");
				}else{
					$errmsg.= base64_encode("Video not updated to DB!");
				}
			}else{
				$okmsg = base64_encode("Video uploaded successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}
			//}
		}
	} else {
		$imagename = $_POST['old_video'];
		$id = base64_decode($_POST['id']);
		$filename = MYSURL."media/videos/".$imagename;
		$update_img_query = "UPDATE ".$tblprefix."mediaivideos SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												video_title = '".$image_title."',
												video_name= '".$imagename."',
												video_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
		
		$run_query = $db->Execute($update_img_query);
		if($run_query){
					$msg.= base64_encode("video updated successfully!\n");
				}else{
					$errmsg.= base64_encode("Video not updated to DB!");
				}
			
				$okmsg = base64_encode("Video updated successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}

	}

}
#####################
#
# Update Media videos1
#
#####################

if($_POST['mode']=='update' && $_POST['act']=='mediaivideos1' && $_POST['request_page']=='media_upload'){

	$post=$_POST;

	$error='';
	$property_id = $_POST['property_id'];
	$room_id = $_POST['room_id'];
	$pm_id = $_POST['first_name'];
	$id=base64_decode($_POST['id']);
	$image_title = addslashes(trim($_POST['video_title']));
    if($post['video_title']==''){
		$error="Title is required <br>";
	}
	if($post['first_name']==0){
		
		$error .= "Select Property Manager <br>";
	}
	if($post['property_id']==0){
		
		$error .= "Select Property <br>";
	}
     
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act2']."&id=".$_POST['id']);
		exit;
	}else{
	
	

	if(!empty($_FILES['video']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['video']['name']);
		if($size > 26214400){//25 MB
			$errmsg = base64_encode("Video must be less than 25 MB");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit;
		}
		if($type[1]!="flv"){
			$okmsg = base64_encode("video must be flv format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
			$imagename = $image_name_rand.".".$type[1];
			$filename = MYSURL."media/videos/".$imagename;
			$target_path = "media/videos/";
			$info = getimagesize($_FILES['video']['tmp_name']);

			/*	if($info[0] > 200 and $info[1] > 200) {
			$okmsg = base64_encode("image must be less then '200 X 200'");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit;
			}else{*/
			if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path.$imagename)){
				if($_POST['old_video']!=""){
					if(file_exists($target_path.$_POST['old_video'])){
						@unlink($target_path.$_POST['old_video']);
					}
				}
					
					
				  $update_img_query = "UPDATE ".$tblprefix."mediaivideos SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												video_title = '".$image_title."',
												video_name= '".$imagename."',
												video_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
												



				$run_query = $db->Execute($update_img_query);

				if($run_query){
					$msg.= base64_encode("video updated successfully!\n");
				}else{
					$errmsg.= base64_encode("Video not updated to DB!");
				}
			}else{
				$okmsg = base64_encode("Video uploaded successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}
			//}
		}
	} else {
		$imagename = $_POST['old_video'];
		$id = base64_decode($_POST['id']);
		$filename = MYSURL."media/videos/".$imagename;
		$update_img_query = "UPDATE ".$tblprefix."mediaivideos SET
												pm_id = ".$pm_id.",
												property_id = ".$property_id.",
												room_id = ".$room_id.",
												video_title = '".$image_title."',
												video_name= '".$imagename."',
												video_full_path= '".$filename."',
												date ='".date('Y-m-d')."'
												where id=".$id;
		
		$run_query = $db->Execute($update_img_query);
		if($run_query){
					$msg.= base64_encode("video updated successfully!\n");
				}else{
					$errmsg.= base64_encode("Video not updated to DB!");
				}
			
				$okmsg = base64_encode("Video updated successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}

	}

}
?>
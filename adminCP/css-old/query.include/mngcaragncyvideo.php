<?php 
if($_POST['mode']=='add' && $_POST['act']=='mng_caragncy_video' && $_POST['request_page']=='mngcaragncyvideo'){
$post=$_POST;
$error='';
$property_id = addslashes(trim($_POST['agency_id']));
$pm_id = addslashes(trim($_POST['first_name']));
						
if($post['first_name']==""){
	$error="Select PM!!<br>";
}
if($post['agency_id']==""){
	$error.="Select Agency!!<br>";
}
if($post['supplier_id']==""){
	$error.="Select Car/Brand Type!!<br>";
}
if($post['yatch_id']==""){
	$error.="Select Car model!!<br>";
}
if($_FILES['video']['name']==''){
	$error.="Video is Required!!<br>";
}


if($error!=''){

			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit;
}else{
		$video=$_FILES['video'];
 		$size=$video['size'];
		$type = explode(".", $video['name']);
		
		
		if($type[1]!="flv"){
			$errmsg = base64_encode("Only flv videos allowed");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;				
		}
		else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];
				
				
				xyz:
				$sel_qry = "SELECT * FROM ".$tblprefix."agncy_mediafiles WHERE fileurl ='".$imagename."'";
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
	 							$update_img_query = "INSERT ".$tblprefix."agncy_mediafiles SET
												pm_id = ".$pm_id.",
												agncy_id = ".$property_id.",
												supplier_id = '".$post['supplier_id']."',
												car_yatch_id= '".$post['yatch_id']."',
												status= '1',
												fileurl= '".$filename."',
												aflag ='1',
												which_agency ='1'
												"; 
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$okmsg.= base64_encode("Video inserted successfully!\n");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;			
					}else{
						$errmsg.= base64_encode("Video not inserted to DB!");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
						exit;			
						
					}
				}else{
					$errmsg.= base64_encode("Unable to upload Video!<br>");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;			

				}		

		}
		
	}

}

if($_POST['mode']=='update' && $_POST['act']=='mng_caragncy_video' && $_POST['request_page']=='mngcaragncyvideo'){


$post=$_POST;

$id=base64_decode($_POST['id']);

$error='';
	
$property_id = addslashes(trim($_POST['agency_id']));
$pm_id = addslashes(trim($_POST['first_name']));
						
if($post['first_name']=="0"){
	$error="Select PM!!<br>";
}
if($post['agency_id']=="0"){
	$error.="Select Agency!!<br>";
}
if($post['supplier_id']=="0"){
	$error.="Select Car/Brand Type!!<br>";
}
if($post['yatch_id']=="0"){
	$error.="Select Car model!!<br>";
}

if($error!='')
{
			$msg=base64_encode($error);
			//header("Location: admin.php?errmsg=$msg&act=".$post['act2']);
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act2']."&id=".base64_encode($id));
			exit;
}
else
{
	/*echo '<pre>';
print_r($post);
echo $id;
exit;*/
								
	if(!empty($_FILES['video']['name']))
	{
		$video=$_FILES['video'];
 		$size=$video['size'];
		$type = explode(".", $video['name']);
		$size = $video['size'];
		
		if($type[1]!="flv"){
			$errmsg = base64_encode("Only flv videos allowed");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;				
		}
		else{
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];
				
				
				rst:
				$sel_qry = "SELECT * FROM ".$tblprefix."agncy_mediafiles WHERE fileurl ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".flv";
					goto xyz;
				}
				
				$filename = MYSURL."media/videos/".$imagename;
				$target_path = "media/videos/";
				$info = getimagesize($_FILES['video']['tmp_name']);
				
				if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path.$imagename))
				{
						if($_POST['old_image']!="")
						{
								if(file_exists($_POST['old_image']))
								{
									unlink($_POST['old_image']);
								}
						}
						
	 						$update_img_query = "UPDATE ".$tblprefix."agncy_mediafiles SET
												pm_id = ".$pm_id.",
												agncy_id = ".$property_id.",
												supplier_id = '".$post['supplier_id']."',
												car_yatch_id= '".$post['yatch_id']."',
												fileurl= '".$filename."' 
												where mf_id=".$id;
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$okmsg.= base64_encode("Video Updated successfully!\n");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;			
					}else{
						$errmsg.= base64_encode("Video not Updated to DB!");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
						exit;			
						
					}
				}else{
					$errmsg.= base64_encode("Unable to upload Video!<br>");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;			

				}		

		}
		
		}
	
	else
	{
					$update_img_query = "UPDATE ".$tblprefix."agncy_mediafiles SET
												pm_id = ".$pm_id.",
												agncy_id = ".$property_id.",
												supplier_id = '".$post['supplier_id']."',
												car_yatch_id= '".$post['yatch_id']."' 
												where mf_id=".$id;
				
					$run_query = $db->Execute($update_img_query);
							
					if($run_query)
					{
						$msg.= base64_encode("Info Updated successfully!");
						header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
					}
					else
					{
						$errmsg.= base64_encode("Info not Updated to DB!");
						header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act2']."&id=".base64_encode($id));
					}
	
	}
}
 }
 
 if($_GET['mode']=='delete' && $_GET['act']=='mng_caragncy_video' && $_GET['request_page']=='mngcaragncyvideo'){
	$id=base64_decode($_GET['id']);
	
		$sel_qry = "SELECT fileurl FROM ".$tblprefix."agncy_mediafiles WHERE mf_id =".$id; 
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['fileurl'];
		
		
		$del_qry = " DELETE FROM ".$tblprefix."agncy_mediafiles WHERE mf_id =".$id; 
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			//$target_path = "media/images/";
				if(file_exists($image_name))
				{
						unlink($image_name);
				}
		$okmsg = base64_encode("Image Deleted successfully!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Unable to Delete!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
}
?>
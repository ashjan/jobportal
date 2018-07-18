<?php 
// image media add
if($_POST['mode']=='add' && $_POST['act']=='yatchtypesimages' && $_POST['request_page']=='mngyatchtypimages'){
$post=$_POST;
$error='';


$property_id = addslashes(trim($_POST['agency_id']));

						

if($post['agency_id']=="0"){
	$error.="Select Agency!!<br>";
}
/*if($post['supplier_id']=="0"){
	$error.="Select Car/Brand Type!!<br>";
}*/
if($post['yatch_id']=="0"){
	$error.="Select Car model!!<br>";
}
if($_FILES['S_IMAGE']['name'][0]==''){
	$error.="Image is Required!!<br>";
}


if($error!='')
{
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit;
}
else
{
$images=$_FILES['S_IMAGE'];
$count=count($images['name']);
$errmsg='';
$okmsg='';
for($i=0; $i<$count; $i++){
		$type = explode("/", $images['type'][$i]);
		$size = $images['size'][$i];
		
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png"){
			$errmsg .= base64_encode("Image ".$i." image format was wron!<br>");
		}
		
		
		
		
		
		elseif($size>5000000){
			$errmsg.= base64_encode("Image ".$i."must be less than 5 MB!<br>");		
		}
		else{
				
				
				$image_name_rand = generateRandomString(10);
				$imagename = $image_name_rand.".".$type[1];
				xy:
				$sel_qry = "SELECT * FROM ".$tblprefix."type_mediafiles WHERE fileurl ='".$imagename."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$imagename = $image_name_rand.".".$type[1];
					goto xy;
				}
				
				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['S_IMAGE']['tmp_name'][$i]);
				
				if($info[0] > 1000) 
				{
					$get_thumb = new Thumbnail($_FILES['S_IMAGE']['tmp_name'][$i],800,600, $target_path.$imagename,100,'');
					$get_thumb->create();
					$image_upload_status = TRUE;
				}
				else
				{
					if(move_uploaded_file($_FILES['S_IMAGE']['tmp_name'][$i], $target_path.$imagename))
					{
						$image_upload_status = TRUE;
					}
					else
					{
						$image_upload_status = FALSE;
					}
				}
				
				if($image_upload_status)
				{
				
					 $update_img_query = "INSERT ".$tblprefix."type_mediafiles SET
												agncy_id = ".$property_id.",
												car_yatch_id= '".$post['yatch_id']."',
												status= '1',
												fileurl= '".$filename."',
												aflag ='0',
												which_type ='0'
												"; 
											
					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$errmsg.= base64_encode("Image inserted successfully!");
					}else{
						$errmsg.= base64_encode("Image not inserted to DB!");
					}
				}
				else
				{
					$errmsg.= base64_encode("Unable to upload ".$i." Image!<br>");
				}		

		}
		
		}
	header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
	exit;			
	}
} 


// image media update



if($_POST['mode']=='update' && $_POST['act']=='edit_yatchtype_images' && $_POST['request_page']=='mngyatchtypimages'){

$post=$_POST;

$id=base64_decode($_POST['id']);

$error='';
	
$property_id = addslashes(trim($_POST['agency_id']));

						

if($post['agency_id']=="0"){
	$error.="Select Agency!!<br>";
}
/*if($post['supplier_id']=="0"){
	$error.="Select Car/Brand Type!!<br>";
}*/
if($post['yatch_id']=="0"){
	$error.="Select Yacht model!!<br>";
}

if($error!='')
{
			$okmsg=base64_encode($error);
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
}
else
{
	/*echo '<pre>';
print_r($post);
echo $id;
exit;*/
								
	if(!empty($_FILES['image']['name']))
	{
			$image_name_rand = generateRandomString(10);
			$type = explode(".", $_FILES['image']['name']);
			if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
				$okmsg = base64_encode("image must be image format.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit();
			}
			else
			{
					$imagename = $image_name_rand.".".$type[1];
					$filename = MYSURL."media/images/".$imagename;
					$target_path = "media/images/";
					$info = getimagesize($_FILES['image']['tmp_name']);
	
				if($info[0] > 1000) 
				{
					$get_thumb = new Thumbnail($_FILES['image']['tmp_name'],800,600, $target_path.$imagename,100,'');
					$get_thumb->create();
					$image_upload_status = TRUE;
				}
				else
				{
					if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename))
					{
						if($_POST['old_image']!="")
						{
								if(file_exists($target_path.$_POST['old_image']))
								{
									unlink($target_path.$_POST['old_image']);
								}
						}
								
						$image_upload_status = TRUE;
					}
					else
					{
						$image_upload_status = FALSE;
					}
				}
				
						if($image_upload_status)
						{			
							
								
							$update_img_query = "UPDATE ".$tblprefix."type_mediafiles SET
												agncy_id = ".$property_id.",
												car_yatch_id= '".$post['yatch_id']."',
												fileurl= '".$filename."' 
												where mf_id=".$id;
						
							$run_query = $db->Execute($update_img_query);
									
							if($run_query)
							{
								$msg.= base64_encode("Image Updated successfully!");
								header("Location: admin.php?okmsg=$msg&act=".$_POST['act2']."&id=".base64_encode($id));
							}
							else
							{
								$errmsg.= base64_encode("Image not Updated to DB!");
								header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
							}
						}
						else
						{
								$okmsg = base64_encode("Unable to upload  image.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
						}		
				//}
			}
	}
	else
	{
					$update_img_query = "UPDATE ".$tblprefix."type_mediafiles SET 
												agncy_id = ".$property_id.",
												car_yatch_id= '".$post['yatch_id']."' 
												where mf_id=".$id;
				
					$run_query = $db->Execute($update_img_query);
							
					if($run_query)
					{
						$msg.= base64_encode("Info Updated successfully!");
						header("Location: admin.php?okmsg=$msg&act=".$_POST['act2']);
					}
					else
					{
						$errmsg.= base64_encode("Info not Updated to DB!");
						header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
					}
	
	}
}
}
 

	   
######################
#
# 	GET SECTION
#
######################


// image media delete

if($_GET['mode']=='delete' && $_GET['act']=='yatchtypesimages' && $_GET['request_page']=='mngyatchtypimages'){
	$id=base64_decode($_GET['id']);
	
		$sel_qry = "SELECT fileurl FROM ".$tblprefix."type_mediafiles WHERE mf_id =".$id; 
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['fileurl'];
		
		$del_qry = " DELETE FROM ".$tblprefix."type_mediafiles WHERE mf_id =".$id; 
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

// vidio media add

if($_POST['mode']=='add' && $_POST['act']=='mediaivideos' && $_POST['request_page']=='media_upload'){
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
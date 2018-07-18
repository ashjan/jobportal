<?php
if($_POST['mode']=='add' && $_POST['act']=='category' && $_POST['request_page']=='manage_category'){
$post=$_POST;
$error='';
$imagename='';
$filename='';
$category_name = addslashes($post['category_name']);
$description = addslashes($post['description']); 
$category_slug=slugcreation($category_name);
$description = addslashes($post['description']);
//regular exprission
$category_slug=preg_replace('/[^a-z0-9]/i', '', $category_slug);
				if($post['category_name']==''){
					$error="category Name is compulsory<br>";
				}
                                if($_FILES["image"]["name"][$key]==""){
                                    $error="Image is compulsory<br>";
                                }
                                
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}
				
		
		if($_FILES["image"]["name"][$key]!=""){
				$image= $_FILES['image'];
				$image_name_rand = generateRandomString(10);
				$type = explode(".", $_FILES['image']['name']);	
				$imagename = $image_name_rand.".".$type[1];
				$filename = "media/images/".$imagename; 
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);	
				
				if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
					$okmsg = base64_encode("Unable to upload image!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				}
				
				}

					$update_img_query  =  "INSERT ".$tblprefix."category SET 
												category_name = '".$category_name."',
												image='".$imagename."',
												description = '".$description."',
												category_slug = '".$category_slug."'"; 
	 				$run_query = $db->Execute($update_img_query);
							
							
			if($run_query)
			{
		        $okmsg = base64_encode("category inserted successfully.!");
                        header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
                        exit;
                        }else{
                              $okmsg = base64_encode("Unable to add category in database.!");
                              header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
                              exit;
                              }

//}

}



	


/****************************************************************************
*																			*
*                            Update category 									*
*																			*
****************************************************************************/




if($_POST['mode']=='update' && $_POST['act']=='edit_category' && $_POST['request_page']=='manage_category')
{
$post=$_POST;
$error='';
 $id=$_POST['page_id'];
$qry_limit =  "SELECT * FROM  ".$tblprefix."category WHERE id=".$id;	
$rs_limit = $db->Execute($qry_limit);

$imagename= $rs_limit->fields['image'];
$category_name = addslashes($post['category_name']);
$description = addslashes($post['description']);
$category_slug=slugcreation($category_name);
//regular exprission
$category_slug=preg_replace('/[^a-z0-9]/i', '', $category_slug);

				if($post['category_name']==''){ 
					$error="category Name is compulsory<br>";
				}
                                
				
		if($error!=''){ 
					$msg=base64_encode($error);
					header("Location: admin.php?pageid=".base64_encode($id)."&okmsg=$msg&act=".$post['act']);
                                        exit();
		} 
                
                if($_FILES["image"]["name"][$key]!=""){
				$image= $_FILES['image'];
				$image_name_rand = generateRandomString(10);
				$type = explode(".", $_FILES['image']['name']);	
				$imagename = $image_name_rand.".".$type[1];
				$filename = "media/images/".$imagename; 
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);	
				
				if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
					if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
				}
				
				

				
				$update_img_query  =  "UPDATE ".$tblprefix."category SET 
											category_name = '".$category_name."',
											image='".$imagename."',
											description = '".$description."',
											category_slug = '".$category_slug."'
											where id=".$id;  
	 						
							$run_query = $db->Execute($update_img_query);
							
							
							if($run_query){
							
							
										
										

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		
							
							
								$okmsg = base64_encode("category updated successfully.!");
								header("Location: admin.php?pageid=".base64_encode($id)."&okmsg=$okmsg&act=".$_POST['act2']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to updated category in database.!");
								header("Location: admin.php?pageid=".base64_encode($id)."&okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}


// Switch_video occurs here, if We have URL
}else{
                                            $update_img_query  =  "UPDATE ".$tblprefix."category SET 
                                                                                                    category_name = '".$category_name."',
                                                                                                    description = '".$description."',
                                                                                                    category_slug = '".$category_slug."'
                                                                                                    where id=".$id; 
                                            $run_query = $db->Execute($update_img_query);
                                            if($run_query){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
									
		$okmsg = base64_encode("category updated successfully.!");
		header("Location: admin.php?pageid=".base64_encode($id)."&okmsg=$okmsg&act=".$_POST['act2']);
		exit;
		}else{
		$okmsg = base64_encode("Unable to updated category in database.!");
		header("Location: admin.php?pageid=".base64_encode($id)."&okmsg=$okmsg&act=".$_POST['act']);
		exit;
		}
}


}
	
	

/***************************************************************************
*
*                         Delete category 
*
***************************************************************************/

if($_GET['mode']=='delete' && $_GET['act']=='category' && $_GET['request_page']=='manage_category')
{


 	$id=base64_decode($_GET['id']); 
	$sel_qry = "SELECT image FROM ".$tblprefix."category WHERE id =".$id; 
	$rs_select = $db->Execute($sel_qry);
	$is_rs = $rs_select->RecordCount();
	if($is_rs > 0){
	
		$image_name=$rs_select->fields['image'];
		//$video_name=$rs_select->fields['category_video'];
		$target_path = "media/images/";
		//$vtarget_path = "media/videos/";
		
		$del_qry = " DELETE FROM ".$tblprefix."category WHERE id =".$id;  
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			
			if(file_exists($target_path.$image_name)){
				unlink($target_path.$image_name);
			}
			
//			if(file_exists($vtarget_path.$video_name)){
//					unlink($vtarget_path.$video_name);
//			}
			
			$del_qry = '';
			$rs_delete = '';
			
		//$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='categorydescription_type' ";  
		//$rs_delete = $db->Execute($del_qry);
			
			//$okmsg = base64_encode("category Deleted successfully. !");
			//header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			//exit;			
		}//else{
		//$okmsg = base64_encode("Cijena nije izbrisana .!");
				//	header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				//	exit;			
		
		//}
 	} 
} 






?>
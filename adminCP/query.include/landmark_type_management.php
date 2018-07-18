<?php	
if($_POST['mode']=='add' && $_POST['act']=='manage_landmark_type' && $_POST['request_page']=='landmark_type_management'){

$post=$_POST;
$error='';

$landmark_type_name=$post['landmark_type_name'];
if($post['landmark_type_name']==''){
	$error="Landmark Type Name required<br>";
	}

if(empty($_FILES['landmark_icon']['name']))
{
  //$error.="Image Field is Required";  
  $error.="Polje za sliku je obavezno";
  }
  if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
			}
  $qry_landmark_exist= "SELECT
							".$tblprefix."landmark_type.id 
							FROM
							".$tblprefix."landmark_type where landmark_type_name ='".$post['landmark_type_name']."' "; 
				$rs_landmark_exist=$db->Execute($qry_landmark_exist);
				$count_rec =  $rs_landmark_exist->RecordCount();
				if($count_rec > 0){
					//$errmsg = base64_encode('This Landmark Recorod already exist. Try another one');
					$errmsg = base64_encode('This Landmark Recorod already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
				}	



if($_FILES['landmark_icon']['name']==NULL){
		//$okmsg =base64_encode('Image Field is Required');
		$okmsg =base64_encode('Polje za sliku je obavezno');
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		
	     }else{
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['landmark_icon']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			//$okmsg = base64_encode("image must be image format.!");
			$okmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = "graphics/thumbnail_upload/".$imagename; 
				$target_path = "graphics/thumbnail_upload/";
				$info = getimagesize($_FILES['landmark_icon']['tmp_name']);

				
						if(move_uploaded_file($_FILES['landmark_icon']['tmp_name'], $target_path.$imagename)){	
						
						 $update_img_query = "INSERT ".$tblprefix."landmark_type SET
						 								cat_id 			   = ".$_POST['landmark_type_cat'].",
														landmark_type_name = '".$post['landmark_type_name']."',
														landmark_icon= '".$imagename."'
														";
											
						$run_query = $db->Execute($update_img_query);
							if($run_query){
							
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"landmark_type_name") and strlen($key)>strlen("landmark_type_name")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			$language_id = substr($language_id,strpos($language_id,"_")+1);
			
			// Now that we have got the Language IDs we will need to update the language content table
			// Find whether the field already exist or not 
			$language_qry = "SELECT id,
				language_id,
				page_id,
				field_name,
				translation_text,
				translated_text,
				fld_type 
				FROM 
				".$tblprefix."language_contents 
				WHERE   
				language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='landmark_type_name' 
				AND fld_type='landmark_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='landmark_type_name',
				translation_text ='".addslashes($landmark_type_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='landmark_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='landmark_type_name',
				translation_text ='".addslashes($landmark_type_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='landmark_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='landmark_type_name'  
				AND fld_type='landmark_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
							
							
							
								$okmsg = base64_encode("Landmark Type inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Landmark Type  in database.!");
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


//  U P D A T E         F U N C T I O N  


if($_POST['mode']=='update' && $_POST['act']=='edit_landmark_type' && $_POST['request_page']=='landmark_type_management')
{

$post=$_POST;
$id = $_POST['id'];
$landmark_type_name=$post['landmark_type_name'];
$_SESSION['landmark_icon'] = $_POST['landmark_icon_old'];


$error='';
//$_SESSION['add_sees'] = $_POST;

$_SESSION['landmark_type_name']=$_POST['landmark_type_name'];

if($post['landmark_type_name']==''){
	$error="Landmark Type Name required<br>";
}

$qryappend='';
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
			exit();
}else{
if(!empty($_FILES['landmark_icon']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['landmark_icon']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
		
				$imagename = $image_name_rand.".".$type[1];
				$filename = "graphics/thumbnail_upload/".$imagename; 
				$target_path = "graphics/thumbnail_upload/";
				$info = getimagesize($_FILES['landmark_icon']['tmp_name']);
						if(move_uploaded_file($_FILES['landmark_icon']['tmp_name'], $target_path.$imagename)){
						$qryappend = ", landmark_icon='".$imagename."'";
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
							
						}else{
							
							
							//$okmsg = base64_encode("Unable to upload Picture.!");
							$okmsg = base64_encode("Unable to upload Picture.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
							exit;
						}
						}
						}
						
						$update_img_query = "UPDATE ".$tblprefix."landmark_type SET
														cat_id 			   = ".$_POST['landmark_type_cat'].",
														landmark_type_name = '".$post['landmark_type_name']."' 
                                                        ".$qryappend."
														WHERE id=".$_POST['id']
														; 
						$run_query = $db->Execute($update_img_query);
							
							if($run_query){
							
							
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		
		
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"landmark_type_name") and strlen($key)>strlen("landmark_type_name")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			$language_id = substr($language_id,strpos($language_id,"_")+1);
			
			// Now that we have got the Language IDs we will need to update the language content table
			// Find whether the field already exist or not 
			$language_qry = "SELECT id,
				language_id,
				page_id,
				field_name,
				translation_text,
				translated_text,
				fld_type 
				FROM 
				".$tblprefix."language_contents 
				WHERE   
				language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='landmark_type_name' 
				AND fld_type='landmark_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='landmark_type_name',
				translation_text ='".addslashes($landmark_type_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='landmark_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='landmark_type_name',
				translation_text ='".addslashes($landmark_type_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='landmark_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='landmark_type_name'  
				AND fld_type='landmark_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
							
								$okmsg = base64_encode("Landmark Type  Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update Landmark Type  in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}
						
						
						//unset($_SESSION['add_sees']);		
			
		}
}

   
######################
#
# 	GET SECTION
#
######################
// Delete Function
if($_GET['mode']=='delete' && $_GET['act']=='manage_landmark_type' && $_GET['request_page']=='landmark_type_management'){

	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT landmark_icon FROM ".$tblprefix."landmark_type WHERE id =".$id;
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['landmark_icon'];
		
		$del_qry = " DELETE FROM ".$tblprefix."landmark_type WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/landmark_type_uploads/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
				
		$del_qry_con = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='landmark_type' ";
		$rs_delete_con = $db->Execute($del_qry_con);		
				
		$okmsg = base64_encode("Landmark Type Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Cijena nije izbrisana.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	

if($_POST['mode']=='addbadgegold' && $_POST['act']=='goldofr_badge' && $_POST['request_page']=='landmark_type_management')
{

$post=$_POST;

$_SESSION['landmark_icon'] = $_POST['landmark_icon_old'];


$error='';



if(empty($_FILES['landmark_icon']['name'])){
	$error.="Image Field is Required"; 
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
if(!empty($_FILES['landmark_icon']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['landmark_icon']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
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
							
						
							
						$update_img_query = "UPDATE ".$tblprefix."golofr_badge SET 
														badge_path= '".$imagename."' 
														WHERE id='1'"; 
						$run_query = $db->Execute($update_img_query);
							
							if($run_query){
								$okmsg = base64_encode("Badge Image Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update Badge Image in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							
							
							$okmsg = base64_encode("Unable to upload Picture.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
							exit;
						}
						
						//unset($_SESSION['add_sees']);		
			
		}
}

	}
}	
	
	?>
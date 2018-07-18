<?php
if($_POST['mode']=='send' && $_POST['act']=='manage_third_level_categories'){
$post=$_POST;
$id = base64_decode($_POST['id']);

$error='';
if($post['page_title']==''){
	$error="Page Title is compulsory<br>";
}

if($post['description']==''){
	$error.="Description is compulsory<br>";
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act2']);
}else{
		$page_title = addslashes($post['page_title']);
		
		$meta_title = addslashes($post['meta_title']);
		$meta_keyword = addslashes($post['meta_keyword']);
		$meta_phrase = addslashes($post['meta_phrase']);
		$meta_description = addslashes($post['meta_description']);
		
		$latitude = addslashes($post['latitude']);
		$longitude = addslashes($post['longitude']);
		
		$description = addslashes($post['description']);
		$page_type = 2;
		$pagename = str_replace('_',' ',$page_type);
		$pagename = ucwords($pagename);
				
		$page_type1=slugcreation($page_title);
		
		/*
		
		Podgorica, Montenegro
		Country: Montenegro
		Latitude: 42.441111
		Longitude: 19.263611
		
		*/
		
		if($latitude==''){
		
		$latitude= 42.441111;
				
		}
		
		if($longitude==''){
		
		$longitude= 19.263611;
		
		}
		
		$qry_update = "INSERT ".$tblprefix."pagecontent SET 
														page_title = '".$page_title."',
														cat_id = ".$id.",
														page_type = ".$page_type.",
														meta_title = '".$meta_title."', 
														meta_keyword = '".$meta_keyword."', 
														meta_phrase = '".$meta_phrase."', 
														meta_description = '".$meta_description."', 
														description = '".$description."',
														latitude = '".$latitude."',
														longitude = '".$longitude."',
														page_type1='".$page_type1."'";
														
														
		$rs = $db->Execute($qry_update);	
		
		//$rs = TRUE;
		
		if($rs){

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Page Title
		foreach($my_post as $key=>$val){
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			
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
				AND field_name='page_title' 
				AND fld_type='content_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='content_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='category_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='page_title' 
				AND fld_type='content_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"description") and strlen($key)>strlen("description") and ($key<>"meta_description")){ 
			$language_id=substr($key,strpos($key,"_")+1);
			
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
				AND field_name='description' 
				AND fld_type='content_type'"
				;

			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='description',
				translation_text ='".$description."',
				translated_text ='".$val."',
				fld_type='content_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='description',
				translation_text ='".$description."',
				translated_text ='".$val."',
				fld_type='content_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='description' 
				AND fld_type='content_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
			
			$_SESSION['sportal-adminauth']['name'] = $_POST['name'];
			$msg=base64_encode("Contents page created successfully.");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
			
		}else{
		
			$msg=base64_encode("Contents could not be updated");
			header("Location: admin.php?errmsg=$msg&lan=$lan_id&act=".$_POST['act']);
			
		}//if($rs)
		exit;
	
	}
}	/* END: if($_POST['mode']=='send' && $_POST['act']=='contentpage')*/



// EDIT CONTENT

if($_POST['mode']=='update' && $_POST['act']=='manage_third_level_categories'){
$id=base64_decode($_POST['id']);

$post=$_POST;
$error='';

if($post['page_title']==''){
	$error="Page Title is compulsory<br>";
}

if($post['description']==''){
	$error.="Description is compulsory<br>";
}

if($error!=''){
	$msg=base64_encode($error);
	header("Location: admin.php?okmsg=$msg&act=".$post['act2']."&pageid=".base64_encode($post['page_id']));
}else{
		$page_title = addslashes($post['page_title']);
		$meta_title = addslashes($post['meta_title']);
		$meta_keyword = addslashes($post['meta_keyword']);
		$meta_phrase = addslashes($post['meta_phrase']);
		$meta_description = addslashes($post['meta_description']);
		$description = addslashes($post['description']);
		$latitude = addslashes($post['latitude']);
		$longitude = addslashes($post['longitude']);
		$page_type = 2;
		$page_type1 = slugcreation($page_title);
		
		$page_id = $post['page_id'];
		 
		$pagename = ucwords($pagename);
		
		
		if($latitude==''){
		
		$latitude= 42.441111;
				
		}
		
		if($longitude==''){
		
		$longitude= 19.263611;
		
		}
		
		
		$qry_update = "UPDATE ".$tblprefix."pagecontent SET 
														 page_title = '".$page_title."',
														 page_type = ".$page_type.",
														 meta_title = '".$meta_title."', 
														 meta_keyword = '".$meta_keyword."', 
														 meta_phrase = '".$meta_phrase."', 
														 meta_description = '".$meta_description."', 
														 description = '".$description."',
														 latitude = '".$latitude."',
														 longitude = '".$longitude."',
														 page_type1 = '".$page_type1."' 
														 WHERE cat_id = '".$id."'
														";
		$rs = $db->Execute($qry_update);
		if($rs){
		// collect all the posted values and get the translated language ids 
		$my_post=$_POST;
		$id = $post['page_id'];
		
		// Update or Add the language content for Page Title
		foreach($my_post as $key=>$val){
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
			$language_id=substr($key,strpos($key,"_",9)+1);
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
				AND field_name='page_title' 
				AND fld_type='content_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='content_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			 $update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='content_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='page_title' 
				AND fld_type='content_type'
				";
				
			$rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
		
		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"description") and strlen($key)>strlen("description") and ($key<>"meta_description")){ 
			$language_id=substr($key,strpos($key,"_")+1);
			
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
				AND field_name='description' 
				AND fld_type='content_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='description',
				translation_text ='".$description."',
				translated_text ='".$val."',
				fld_type='content_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='description',
				translation_text ='".$description."',
				translated_text ='".$val."',
				fld_type='content_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='description' 
				AND fld_type='content_type'
				";
				
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
			$msg=base64_encode("$pagename Contents Updated successfully.");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
		}else{
			$msg=base64_encode("Contents could not be updated");
			header("Location: admin.php?errmsg=$msg&act=".$_POST['act']."&pageid=".base64_encode($post['page_id']));
		}
		exit;
	}
}

if($_GET['mode']=='delpage' && $_GET['act']=='contentpage' && $_GET['request_page']=='content_management'){
		$pageid=base64_decode($_GET['pageid']);
		$del_qry = " DELETE FROM ".$tblprefix."pm_pagecontent WHERE id = ".$pageid;  
		$rs_newsletter = $db->Execute($del_qry);				
		if($rs_newsletter){
		$okmsg = base64_encode("Deleted Content Page successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	
					}else{
					$okmsg = base64_encode("Unable Deleted Content Page. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	
					}  
} 	
?>
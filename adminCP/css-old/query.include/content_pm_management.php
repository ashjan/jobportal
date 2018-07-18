<?php

if($_POST['mode']=='send' && $_POST['act']=='add_content_pages'){

$post=$_POST;

$_SESSION['add_content_page'] = $_POST;
$id = base64_decode($_POST['id']);
$_SESSION['add_content']= $_POST;
$error='';
if($post['page_title']==''){
	$error="Page Title is compulsory<br>";
}
if($post['pm_id']==0)
{
	$error = "Select Property Manager";
}
if(trim($post['sitegdt'])=='')
{
	$error = "Please Enter English description";
}
if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=add_pm_content_pages");
		exit();
}else{
	    
	
		$page_title = addslashes($post['page_title']);
		$pm_id = $post['pm_id'];
		
		$property_page = addslashes(trim($post['property_page']));
		$pagename = str_replace('_',' ',$page_type);
		$pagename = ucwords($pagename);
		$page_type1=slugcreation($page_title);
		$content_slug = $post['content_type'];
		$description = addslashes(trim($post['sitegdt']));
		$qry_update = "INSERT ".$tblprefix."pm_pagecontent SET 
														page_title = '".$page_title."',
														pm_id = ".$pm_id.",
														description = '".$description."',
														content_slug='".$content_slug."',
														page_type1='".$page_type1."'
														";
												
		
		
		$rs = $db->Execute($qry_update);	
		
		//$rs = TRUE;
		if($rs){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		// Update or Add the language content for Page Title
		foreach($my_post as $key=>$val){
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			// Now that we have got the Language IDs we will need to update the language content table
			// Find whether the field already exist or not 
			$fld_type = 'content_type,'.$my_post['content_type'];
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
				AND fld_type='".$fld_type."'"
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
				fld_type='".$fld_type."'
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
				AND fld_type='".$fld_type."'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"sitegdt") and strlen($key)>strlen("sitegdt") and ($key<>"meta_description")){ 
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
				AND fld_type='".$fld_type."'"
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
				fld_type='".$fld_type."'
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
				AND fld_type='".$fld_type."'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
			
			$_SESSION['sportal-adminauth']['name'] = $_POST['name'];
			$msg=base64_encode("Contents page created successfully.");
			header("Location: admin.php?okmsg=$msg&act=contentpage");
			unset($_SESSION['add_content_page']);
			
		}else{
		
			$msg=base64_encode("Contents could not be updated");
			header("Location: admin.php?errmsg=$msg&lan=$lan_id&act=contentpage");
			unset($_SESSION['add_content_page']);
			
		}//if($rs)
		exit;
	}
}	/* END: if($_POST['mode']=='send' && $_POST['act']=='contentpage')*/

// EDIT CONTENT
if($_POST['mode']=='update' && $_POST['act']=='add_content_pages'){ 
$_SESSION['add_content_page'] = $_POST;
$id=base64_decode($_POST['id']); 
$post=$_POST;
$error='';
if($post['page_title']==''){
	$error="Page Title is compulsory<br>";
}
if($post['pm_id']==0)
{
	$error = "Select Property Manager";
}
if(trim($post['sitegdt'])=='')
{
	$error = "Please Enter English description";
}

/*if($post['description']==''){
	$error.="Description is compulsory<br>";
}
*/
if($error!=''){
	$msg=base64_encode($error);
	header("Location: admin.php?errmsg=$msg&act=edit_content_page&pageid=".base64_encode($id)."");
	exit();
}else{
		$page_title = addslashes($post['page_title']);
		$pm_id = $post['pm_id'];
		$property_page = addslashes(trim($post['property_page']));
		$pagename = str_replace('_',' ',$page_type);
		$pagename = ucwords($pagename);
		$page_type1=slugcreation($page_title);
		$content_slug = $post['content_type'];
		$description = addslashes(trim($post['sitegdt']));
	 	$qry_update = "UPDATE ".$tblprefix."pm_pagecontent SET 
														 page_title = '".$page_title."',
														 pm_id = ".$pm_id.",
														 description = '".$description."',
														 content_slug = '".$content_slug."',
														 page_type1 = '".$page_type1."' 
														 WHERE id = ".$id;  
		$rs = $db->Execute($qry_update);
		if($rs){
		// collect all the posted values and get the translated language ids 
		$my_post=$_POST;
		
		
		// Update or Add the language content for Page Title
		foreach($my_post as $key=>$val){
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
			$language_id=substr($key,strpos($key,"_",9)+1);
			
			// Now that we have got the Language IDs we will need to update the language content table
			// Find whether the field already exist or not 
			$fld_type = 'content_type,'.$my_post['content_slug'];
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
				AND fld_type='".$fld_type."'"
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
				fld_type='content_type,".$my_post['content_type']."'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			  $update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='content_type,".$my_post['content_type']."' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='page_title' 
				AND fld_type='".$fld_type."'
				";
				
			$rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}
		 // foreach($my_post as $key=>$val)
		
		// Update or Add the language content for Site GDT
		
		foreach($my_post as $key=>$val){
			if(strstr($key,"sitegdt") and strlen($key)>strlen("sitegdt")){ 
			$language_id=substr($key,strpos($key,"_")+1);
			$fld_type = 'content_type,'.$my_post['content_slug'];
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
				AND fld_type='".$fld_type."'"
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
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='content_type,".$my_post['content_type']."'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			 $update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='description',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='content_type,".$my_post['content_type']."' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='description' 
				AND fld_type='".$fld_type."'
				";
				
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
			$msg=base64_encode("$pagename Contents Updated successfully.");
			header("Location: admin.php?okmsg=$msg&act=contentpage");
		}else{
			$msg=base64_encode("Contents could not be updated");
			header("Location: admin.php?errmsg=$msg&act=contentpage");
		}
		unset($_SESSION['add_conte_page']);
		exit;
	}
}

if($_GET['mode']=='delpage' && $_GET['act']=='contentpage' && $_GET['request_page']=='content_management'){

		$pageid=base64_decode($_GET['pageid']);
		$del_qry = " DELETE FROM ".$tblprefix."pm_pagecontent WHERE id = ".$pageid;
		$rs_newsletter = $db->Execute($del_qry);				
		$okmsg = base64_encode("Deleted Content Page successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 	
?>
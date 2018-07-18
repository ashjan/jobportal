<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------
	if($_POST['mode']=='add' && $_POST['act']=='manage_reviews_category' && $_POST['request_page']=='reviews_category_management'){
		$categoryname = addslashes(trim($_POST['categoryname']));
		$cat_parent = addslashes(trim($_POST['cat_parent']));	
		$slug=slugcreation($categoryname);
			if($categoryname == ''){
				$errmsg = base64_encode('Please Enter Category Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}else{
				$qry_already_category= "SELECT
							".$tblprefix."reviews_category.category_title
							FROM
							".$tblprefix."reviews_category where category_slug ='".$slug."' ";
					
				$rs_already_category=$db->Execute($qry_already_category);
				$count_add =  $rs_already_category->RecordCount();
				
				if($count_add > 0){
					$errmsg = base64_encode('This Category already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
					exit;
				}	
	 
				$sql_category= "INSERT INTO ".$tblprefix."reviews_category 
														SET
														category_title = '".$categoryname."',
														parent_id =".$cat_parent.",
														category_slug ='".$slug."'
														";

				$rs_category = $db->Execute($sql_category);
				
		if($rs_category){
		// collect all the posted values and get the translated language ids 
		$my_post=$_POST;
		$id=mysql_insert_id();
		foreach($my_post as $key=>$val){
			if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname")){ 
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
				AND field_name='category_title' 
				AND fld_type='category_type'"
				;
			
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='category_title',
				translation_text ='".$categoryname."',
				translated_text ='".$val."',
				fld_type='category_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='category_title',
				translation_text ='".$categoryname."',
				translated_text ='".$val."',
				fld_type='category_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='category_title' 
				AND fld_type='category_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
				
					$okmsg = base64_encode("Category Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				} 
			} 
	} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='manage_reviews_category' && $_POST['request_page']=='reviews_category_management'){

	    $categoryname = addslashes(trim($_POST['categoryname']));
		$cat_parent = addslashes(trim($_POST['cat_parent']));
		$id=$_POST['id'];
		
		// collect all the posted values and get the translated language ids 
		$my_post=$_POST;

		foreach($my_post as $key=>$val){
			
			if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname")){ 
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
				AND field_name='category_title' 
				AND fld_type='category_type'"
				;
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='category_title',
				translation_text ='".$categoryname."',
				translated_text ='".$val."',
				fld_type='category_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='category_title',
				translation_text ='".$categoryname."',
				translated_text ='".$val."',
				fld_type='category_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='category_title' 
				AND fld_type='category_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
		
	
		$slug=slugcreation($categoryname);
		

			if($categoryname == ''){
				$errmsg = base64_encode('Please Enter Category Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				$qry_already_category= "SELECT
							".$tblprefix."reviews_category.category_title
							FROM
							".$tblprefix."reviews_category 
							WHERE id<>".$id;
				$rs_already_category=$db->Execute($qry_already_category);
				$count_add =  $rs_already_category->RecordCount();
				
				
				if($count_add >0){
				while(!$rs_already_category->EOF){
				if($rs_already_category->fields['category_title']==$categoryname){
					$errmsg = base64_encode('This Category already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
					exit;
				}
				$rs_already_category->MoveNext();
				}				
				}
	 			$sql_category= "UPDATE ".$tblprefix."reviews_category 
														SET
														category_title = '".$categoryname."',
														parent_id =".$cat_parent.",
														category_slug ='".$slug."'
														WHERE
														id=".$id;

														
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Category Updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;	  
					}
			} 
	
	} 	


	   
######################
#
# 	GET SECTION
#
######################


	//---------Change  Default Language Status---------
	if($_GET['mode']=='change_default' && $_GET['act']=='manage_language' && $_GET['request_page']=='reviews_category_management'){
	
	// First disable the default language status of all the languages  
	 
	$id=base64_decode($_GET['id']);
	  
	$qry_language= "UPDATE ".$tblprefix."language  
					SET 
					".$tblprefix."language.Lan_default=0";
		
    $rs_language=$db->Execute($qry_language);
	$total_language =  $rs_language->RecordCount();
	
	// Now activate the status of the currently selected default language 			
	$sql_language= "UPDATE ".$tblprefix."language 
														SET 
														".$tblprefix."language.Lan_default=1 
														WHERE  
													    ".$tblprefix."language.id=".$id;
				$rs_language = $db->Execute($sql_language);
				if($rs_language){
					$okmsg = base64_encode("Language Updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_language");
					exit;	  
				}
	}// END if($_POST['mode']=='change_default' && $_POST['act']=='manage_language' 


//---------Delete THe Category and its language contents---------
if($_GET['mode']=='del_category' && $_GET['act']=='manage_reviews_category' && $_GET['request_page']=='reviews_category_management'){
		$id=base64_decode($_GET['id']);

	    $del_qry = " DELETE FROM ".$tblprefix."reviews_category WHERE id = ".$id." or parent_id=".$id;

		$rs_del = $db->Execute($del_qry);				
		

		$del_qry_lng = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND field_name='category_title' AND fld_type='category_type'";
		$rs_del_lng = $db->Execute($del_qry_lng);				
		
		
		
		$okmsg = base64_encode("Category Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_reviews_category");
					exit;	  
} 
//---------Service Provider Status---------		
?>
<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='business_subtype' && $_POST['request_page']=='business_subtype_management'){
		$_SESSION["addproperty"] = $_POST;
	    $post=$_POST;
################## Property code script ##################

	$business_subtype = addslashes(trim($_POST['business_subtype']));
	$business_type_id = $_POST['business_type_id'];
	$business_category_id = $_POST['business_category_id'];
	$slug=slugcreation($business_subtype);
	$business_subtype_management = $_POST['business_subtype_management'];
						
		if($business_subtype == '0'){
				$error = base64_encode('Please Enter Business Subtype Name');
				header("Location: admin.php?act=business_subtype&errmsg=$errmsg");
				exit;
			}
	
			
			if($error!=''){
						$msg=base64_encode($error);
						header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
			}else{
									$update_img_query = "INSERT INTO ".$tblprefix."business_subtype 
														SET
														business_subtype ='".$business_subtype."',
														business_type_id =".$business_type_id.",
														business_category_id=".$business_category_id.",
														business_subtype_slug ='".$slug."'";
										
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
			if(strstr($key,"business_subtype") and strlen($key)>strlen("business_subtype")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			
			//$language_id = substr($language_id,strpos($language_id,"_")+1);
			
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
				AND field_name='business_subtype_title' 
				AND fld_type='business_subtype_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='business_subtype_title',
				translation_text ='".addslashes($business_subtype)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_subtype_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='business_subtype_title',
				translation_text ='".addslashes($business_subtype)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_subtype_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='business_subtype_title'  
				AND fld_type='business_subtype_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
										
										
										
										
										
											$okmsg = base64_encode("Business Subtype added successfully.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}else{
											$okmsg = base64_encode("Unable to add Business Subtype, please try again!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}
									}		
						
	}
	
	// Ordering section 
//----------  Change Ordering Code     
if($_POST['mode']=='order_menu' && $_POST['act']=='business_subtype' && $_POST['request_page']=='business_subtype_management'){
	$menu_order=$_POST['menu_order'];
	foreach($menu_order as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
	$sql_change_order= "UPDATE ".$tblprefix."business_subtype  
													SET 
													cat_orderdering=".$val." 
													WHERE  
													id=".$id;
	$rs_change_order = $db->Execute($sql_change_order);
	}
	$okmsg = base64_encode(" Ordering Set Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=business_subtype");
					exit;	
}
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='edit_business_subtype' && $_POST['request_page']=='business_subtype_management')
	{
		$id=base64_decode($_POST['id']); 
		$business_subtype = addslashes(trim($_POST['business_subtype']));
		$business_type_id = $_POST['business_type_id'];
		$business_category_id = $_POST['business_category_id'];
		$slug=slugcreation($business_subtype);
		//$_SESSION['business_subtype']=$business_subtype;
		
				if($business_subtype == ''){
				$errmsg = base64_encode('Please Enter Business Subtype Name');
				header("Location: admin.php?act=edit_business_subtype&errmsg=$errmsg&id=$encryptedid");
				exit;
			}else{			
		
		
										$sql_update= "UPDATE ".$tblprefix."business_subtype set
										business_subtype ='".$business_subtype."',
										business_type_id =".$business_type_id.",
										business_category_id=".$business_category_id.",
										business_subtype_slug = '".$slug."'
										WHERE
										id=".$id; 
										
										$run_query = $db->Execute($sql_update);
										if($run_query)
										{
										
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"business_subtype") and strlen($key)>strlen("business_subtype")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			//$language_id = substr($language_id,strpos($language_id,"_")+1);
			
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
				AND field_name='business_subtype_title' 
				AND fld_type='business_subtype_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='business_subtype_title',
				translation_text ='".addslashes($business_subtype)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_subtype_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='business_subtype_title',
				translation_text ='".addslashes($business_subtype)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_subtype_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='business_subtype_title'  
				AND fld_type='business_subtype_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
										
										
										
										
										
											$okmsg = base64_encode("Business Subtype updated successfully.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
											exit;
										}
										else
										{
											$okmsg = base64_encode("Unable to update Business, please try again!");
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


	

//---------Delete THe Category and its language contents---------
if($_GET['mode']=='delete' && $_GET['act']=='business_subtype' && $_GET['request_page']=='business_subtype_management'){
		$id=base64_decode($_GET['id']);


		$del_property = " DELETE FROM ".$tblprefix."business_subtype WHERE id = ".$id." ";
		$rs_property = $db->Execute($del_property);
		
		$del_property = '';
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = ".$id." ";
		$rs_property = $db->Execute($del_property);				
						
		$okmsg = base64_encode("Business Subtype deleted successfully!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	  
 }
		
	
//---------Service Provider Status---------		
		 
		
		

?>
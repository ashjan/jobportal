<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Property Manager---------
	
	if($_POST['mode']=='add' && $_POST['act']=='feature_list' && $_POST['request_page']=='feature_list_management'){
	
	
	/*echo 'successful';
	exit();*/
	
		$_SESSION['add_sees'] = $_POST;
		
		
		$feature_description = addslashes(trim($_POST['feature_description']));
		$feature_status = addslashes(trim($_POST['feature_status']));
		
		
		if($feature_description == ''){
				$errmsg = base64_encode('Please Enter Feature Description');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		
				
			 	$sql_property= "INSERT INTO ".$tblprefix."feature_list 
														SET 
														 feature_description ='".$feature_description."',
														 feature_status = '".$feature_status."'";  
				$rs_ins_menu = $db->Execute($sql_property);
				if($rs_ins_menu){
				
				
				// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"feature_description") and strlen($key)>strlen("feature_description")){ 
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
				AND field_name='feature_title' 
				AND fld_type='feature_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='feature_title',
				translation_text ='".addslashes($feature_description)."',
				translated_text ='".addslashes($val)."',
				fld_type='feature_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='feature_title',
				translation_text ='".addslashes($feature_description)."',
				translated_text ='".addslashes($val)."',
				fld_type='feature_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='feature_title'  
				AND fld_type='feature_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
				
				
				
					$okmsg = base64_encode("Feature Record Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
					$errmsg = base64_encode("Feature Record Not Added. !");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;
				
				} 
				
				
			 
	} 
//---------Edit Property Managers---------
	if($_POST['mode']=='update' && $_POST['act']=='edit_feature_list' && $_POST['request_page']=='feature_list_management'){
 		$feature_description = addslashes(trim($_POST['feature_description']));
		$feature_status = addslashes(trim($_POST['feature_status']));
				$id=base64_decode($_POST['id']);
		
				

		$_SESSION['add_sees'] = $_POST;
	
		
		if($feature_description == ''){
				$errmsg = base64_encode('Please Enter Feature Description');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
		}
		
		
		
	 	 $sql_update= "UPDATE ".$tblprefix."feature_list  SET	
														 feature_description ='".$feature_description."',
														feature_status = '".$feature_status."'																												                                                        WHERE
														id=".$id;
													 
														
		$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			
			
					
					// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"feature_description") and strlen($key)>strlen("feature_description")){ 
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
				AND field_name='feature_title' 
				AND fld_type='feature_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='feature_title',
				translation_text ='".addslashes($feature_description)."',
				translated_text ='".addslashes($val)."',
				fld_type='feature_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='feature_title',
				translation_text ='".addslashes($feature_description)."',
				translated_text ='".addslashes($val)."',
				fld_type='feature_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='feature_title'  
				AND fld_type='feature_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
			
			$okmsg = base64_encode(" Feature updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
			exit;	  
				}else{
			$errmsg = base64_encode(" Feature Record not updated!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;	  	
				
			} 
			
			} 

	   
######################
#
# 	GET SECTION
#
######################

//---------Delete Service Provider---------
if($_GET['mode']=='delete' && $_GET['act']=='feature_list' && $_GET['request_page']=='feature_list_management'){
		
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."feature_list WHERE id = '".$id."' ";
		
		$rs_newsletter = $db->Execute($del_qry);
		
		$del_qry = '';
		$rs_newsletter = '';
		
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = '".$id."' AND fld_type='feature_type' ";
		
		$rs_newsletter = $db->Execute($del_qry);
		
						
		$okmsg = base64_encode("Feature List successfully deleted. !");
					header("Location: admin.php?errmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 


//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='feature_list' && $_GET['request_page']=='feature_list_management'){

		$id=base64_decode($_GET['id']);
        $status=$_GET['feature_status'];
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		
		$update_qry = " UPDATE ".$tblprefix."feature_list SET
		                                                  feature_status = '".$newstatus."'
														  WHERE id          = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);				
		
		if($rs_newsletter){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
						exit;	  
				}
		  
 }
?>
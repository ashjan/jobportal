<?php
######################
#
# 	POST SECTION
#
######################
//---------Add fix list Item---------
	
	if($_POST['mode']=='add' && $_POST['act']=='fix_list' && $_POST['request_page']=='fix_list_management'){
	
			$_SESSION['add_sees'] = $_POST;
		
		
			$list_item		= addslashes(trim($_POST['list_item']));
			$list_item_eng 	= addslashes(trim($_POST['list_item_eng']));
		
		
		if($list_item == ''){
				$errmsg = base64_encode('Please Enter Fix List');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		echo print_r($_POST);
				
			 $sql_property= "INSERT INTO ".$tblprefix."fix_list 
														SET 
														 list_item 		='".$list_item."',
														 list_item_eng 	= '".$list_item_eng."'"; 
				$rs_ins_menu = $db->Execute($sql_property);
				if($rs_ins_menu){
				
				
				
					$okmsg = base64_encode("Feature Record Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
					$errmsg = base64_encode("Feature Record Not Added. !");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;
				
				} 
				
				
			 
	} 
//---------Edit List Item ---------
if($_POST['mode']=='update' && $_POST['act']=='edit_fix_list' && $_POST['request_page']=='fix_list_management'){
 		
		$list_item		= addslashes(trim($_POST['list_item']));
		$list_item_eng 	= addslashes(trim($_POST['list_item_eng']));
		$id=base64_decode($_POST['id']);
		

		$_SESSION['add_sees'] = $_POST;
	
		
		if($list_item == ''){
				$errmsg = base64_encode('Please Enter list Item');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
		}
		
		
		
	 	 $sql_update= "UPDATE ".$tblprefix."fix_list  SET	
														list_item 		='".$list_item."',
														list_item_eng 	= '".$list_item_eng."'	
																																									                                                        WHERE id=".$id;
														
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

//---------Delete List Item---------
if($_GET['mode']=='delete' && $_GET['act']=='fix_list' && $_GET['request_page']=='fix_list_management'){
		
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."fix_list WHERE id = '".$id."' ";
		
		$rs_newsletter = $db->Execute($del_qry);
		
		$del_qry = '';
		$rs_newsletter = '';
		
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = '".$id."' AND fld_type='feature_type' ";
		
		$rs_newsletter = $db->Execute($del_qry);
		
						
		$okmsg = base64_encode("Fix List successfully deleted. !");
					header("Location: admin.php?errmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 


?>
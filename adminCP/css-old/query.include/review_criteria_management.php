<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_review_criteria' && $_POST['request_page']=='review_criteria_management'){
		
	//echo "<pre>";        print_r($_POST); exit;
		
	        $review_criteria_name = addslashes(trim($_POST['review_criteria_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($review_criteria_name);
		
			if($review_criteria_name == ''){
				$errmsg = base64_encode('Please Enter Property Category Name');
				//$errmsg = base64_encode('Unesite naziv kategorije');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."review_criteria 
														SET
														criteria = '".$review_criteria_name."',
														slug ='".$slug."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
				
										

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"review_criteria_name") and strlen($key)>strlen("review_criteria_name")){ 
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
				AND field_name='cate_title' 
				AND fld_type='cate_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='cate_title',
				translation_text ='".addslashes($review_criteria_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='cate_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='cate_title',
				translation_text ='".addslashes($review_criteria_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='cate_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='cate_title'  
				AND fld_type='cate_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		/*foreach($my_post as $key=>$val){
			if(strstr($key,"short_description") and strlen($key)>strlen("short_description")){ 
			$language_id=substr($key,strpos($key,"_")+1);
			$language_id=substr($language_id,strpos($language_id,"_")+1);
			
			
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
				AND field_name='short_description'  
				AND fld_type='property_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='short_description',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='property_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='short_description',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='property_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='short_description' 
				AND fld_type='property_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}*/  // foreach($my_post as $key=>$val)
			
		
				
					$okmsg = base64_encode("Review Criteria added successfully. !");
					//$okmsg = base64_encode("Kategorija objeCriteria addedkta uspješno dodata. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Could not add Review Criteria, please try again.!");
					   //$okmsg = base64_encode("Kategorija nije dodata, molimo pokušajte ponovo!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_review_criteria' && $_POST['request_page']=='review_criteria_management'){
	    $review_criteria_name = addslashes(trim($_POST['review_criteria_name']));
		//$pm_id = $_POST['pm_id'];
	 $id=base64_decode($_POST['id']);
		
		
		//$_SESSION['id']=$id;
		$_SESSION['review_criteria_name']= $review_criteria_name;
			$slug=slugcreation($review_criteria_name);
			
			if($review_criteria_name == ''){
				$errmsg = base64_encode('Please Enter Review Criteria Name');
				
				header("Location: admin.php?act=update_review_criteria&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				$sql_category= "UPDATE ".$tblprefix."review_criteria 
														SET
														criteria = '".$review_criteria_name."',
														slug ='".$slug."'
														WHERE
														id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
					
					// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
//		foreach($my_post as $key=>$val){
//			if(strstr($key,"criteria") and strlen($key)>strlen("criteria")){ 
//			$language_id = substr($key,strpos($key,"_",9)+1);
//			$language_id = substr($language_id,strpos($language_id,"_")+1);
//			
//			// Now that we have got the Language IDs we will need to update the language content table
//			// Find whether the field already exist or not 
//			$language_qry = "SELECT id,
//				language_id,
//				page_id,
//				field_name,
//				translation_text,
//				translated_text,
//				fld_type 
//				FROM 
//				".$tblprefix."language_contents 
//				WHERE   
//				language_id=".$language_id." 
//				AND page_id=".$id." 
//				AND field_name='cate_title' 
//				AND fld_type='cate_type'"
//				;
//				
//			$rs_language = $db->Execute($language_qry);
//			$totallang_flds =  $rs_language->RecordCount();
//			
//            if($totallang_flds <= 0){
//			// There is no field exists so create one for this language
//			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
//                SET
//				language_id = ".$language_id.",
//				page_id =".$id.",
//				field_name ='cate_title',
//				translation_text ='".addslashes($review_criteria_name)."',
//				translated_text ='".addslashes($val)."',
//				fld_type='cate_type'
//				";
//			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
//			}else{
//			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
//                SET
//				field_name ='cate_title',
//				translation_text ='".addslashes($review_criteria_name)."',
//				translated_text ='".addslashes($val)."',
//				fld_type='cate_type' 
//				WHERE language_id=".$language_id." 
//				AND page_id=".$id." 
//				AND field_name='cate_title'  
//				AND fld_type='cate_type'";
//	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
//			}// END if($totallanguages<=0)
//			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
//		}  // foreach($my_post as $key=>$val)
					
					
						$okmsg = base64_encode("Review Criteria updated successfully!");
						//$okmsg = base64_encode("Kategorija uspješno ažurirana!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Could not update Review Criteria, please try again!");
						//$okmsg = base64_encode("Kategorija nije ažurirana, molimo pokušajte ponovo!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	} 	
	
// Ordering section 
//----------  Change Ordering Code     
if($_POST['mode']=='order_menu' && $_POST['act']=='manage_review_criteria' && $_POST['request_page']=='review_criteria_management'){
	$menu_order=$_POST['menu_order'];
	foreach($menu_order as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
	$sql_change_order= "UPDATE ".$tblprefix."review_criteria  
													SET 
													criteria_ordering=".$val." 
													WHERE  
													id=".$id;
	$rs_change_order = $db->Execute($sql_change_order);
	}
	$okmsg = base64_encode(" Ordering Set Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_review_criteria");
					exit;	
}
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if(isset($_GET['mode']))
{
if($_GET['mode']=='del_review_criteria' && $_GET['act']=='manage_review_criteria' && $_GET['request_page']=='review_criteria_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."review_criteria WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);
							
		$del_qry = '';
		$rs_del = '';
		
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = ".$id." AND fld_type='cate_type'";
		$rs_del = $db->Execute($del_qry);
		
		$okmsg = base64_encode("Review Criteria deleted successfully!");
		
					header("Location: admin.php?okmsg=$okmsg&act=manage_review_criteria");
					exit;	  
}
}

?>
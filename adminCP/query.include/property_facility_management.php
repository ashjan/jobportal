<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_property_facility' && $_POST['request_page']=='property_facility_management'){
	
	        $facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
			
		
		
			if($facility_name == ''){
				//$errmsg = base64_encode('Please Enter Property Facility  Name');
				$errmsg = base64_encode('Molimo unesite naziv sadržaja');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			if($property_fac_category == 0){
				//$errmsg = base64_encode('Please Select The Facility ');
				$errmsg = base64_encode('Molimo izaberite sadržaj ');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	  $sql_category= "INSERT INTO ".$tblprefix."facility_management 
														SET
														facility_name = '".$facility_name."',
														property_fac_category =".$property_fac_category."
														";
				$rs_category = $db->Execute($sql_category);
		if($rs_category){
				// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"facility_name") and strlen($key)>strlen("facility_name")){ 
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
				AND field_name='facility_title' 
				AND fld_type='facility_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='facility_title',
				translation_text ='".addslashes($facility_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='facility_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='facility_title',
				translation_text ='".addslashes($facility_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='facility_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='facility_title'  
				AND fld_type='facility_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
				
				
					//$okmsg = base64_encode("Facility Added Successfully. !");
					//$okmsg = base64_encode("Sadržaj uspješno dodat. !");
					$okmsg = base64_encode("Sadr&#382;aj uspje&scaron;no dodat. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				    //$okmsg = base64_encode("Facility Not Added .!");
					//$okmsg = base64_encode("Sadržaj nije dodat.!");
					$okmsg = base64_encode("Sadr&#382;aj nije dodat.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_property' && $_POST['request_page']=='property_facility_management'){
	
			$facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
	 $id=base64_decode($_POST['id']);
			if($facility_name == ''){
				//$errmsg = base64_encode('Please Enter Property Facility  Name');
				//$errmsg = base64_encode('Molimo unesite naziv sadržaja');
				$errmsg = base64_encode('Molimo unesite naziv sadr&#382;aja');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
			if($property_fac_category == 0){
				//$errmsg = base64_encode('Please Select The Facility ');
				//$errmsg = base64_encode('Molimo izaberite sadržaj ');
				$errmsg = base64_encode('Molimo izaberite sadr&#382;aj');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
		
			
			
			 $sql_category= "UPDATE ".$tblprefix."facility_management 
														SET
														facility_name = '".$facility_name."',
														property_fac_category =".$property_fac_category."
														WHERE
														id=".$id;
												
														
														
				$rs_category = $db->Execute($sql_category);
					if($rs_category){
					
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"facility_name") and strlen($key)>strlen("facility_name")){ 
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
				AND field_name='facility_title' 
				AND fld_type='facility_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='facility_title',
				translation_text ='".addslashes($facility_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='facility_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='facility_title',
				translation_text ='".addslashes($facility_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='facility_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='facility_title'  
				AND fld_type='facility_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
					
					
					
						//$okmsg = base64_encode("Property Facility Updated successfully!");
						$okmsg = base64_encode("Sadr&#382;aj objekta uspje&scaron;no a&#382;uriran");
						header("Location: admin.php?okmsg=$okmsg&act=manage_property_facility");
						exit;	  
					}
					else{
					      
						//$okmsg = base64_encode("Property Facility Is Not Updated!");
						//$okmsg = base64_encode("Sadržaj objekta nije ažuriran");
						$okmsg = base64_encode("Sadr&#382;aj objekta nije a&#382;uriran");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_category' && $_GET['act']=='manage_property_facility' && $_GET['request_page']=='property_facility_management'){

		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."facility_management WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		$del_qry = '';
		$rs_del = '';
		
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = ".$id." AND fld_type='facility_type'";
		$rs_del = $db->Execute($del_qry);
		
		//$okmsg = base64_encode("Facility  Deleted successfully. !");
		//$okmsg = base64_encode("Sadržaj uspješno izbrisan. !");
		$okmsg = base64_encode("Sadr&#382;aj uspje&scaron;no izbrisan. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_property_facility");
					exit;	  
} 

?>
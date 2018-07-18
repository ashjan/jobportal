<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_room_facility' && $_POST['request_page']=='room_facility_management'){
	        $facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
			
		
		    $duplicate_query = "SELECT id FROM ".$tblprefix."room_facility_management WHERE facility_name='"
		                       .$facility_name."' AND room_fac_category=".$property_fac_category;
		              
		    $rs_duplicate = $db->Execute($duplicate_query);
		    $totalcount =  $rs_duplicate->RecordCount();
		    if($totalcount>0){
		    	$errmsg = base64_encode("Ovaj sadržaj sobe vec postoji");
		    	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		    	exit();
		    }else {
			if($facility_name == ''){
				$errmsg = base64_encode('Molimo unesite naziv sadržaja sobe');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			if($property_fac_category == 0){
				$errmsg = base64_encode('Please Select The Facility');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	  $sql_category= "INSERT INTO ".$tblprefix."room_facility_management 
														SET
														facility_name = '".$facility_name."',
														room_fac_category =".$property_fac_category."
														";
$rs_category = $db->Execute($sql_category);
if($rs_category){
			     // insert for russian language
	$last_id = mysql_insert_id();								
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'room_facility_mon' AND fld_type ='room_facility'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0)
{
 	$language_id=7;  // for Montenegrin language for offline
	 	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_mon',
				translation_text ='".$facility_name."',
				translated_text ='".addslashes($_POST['room_facility_mon'])."',
				fld_type='room_facility' 
				WHERE language_id=".$language_id." 
				AND field_name='room_facility_mon' 
				AND fld_type='room_facility'
				";

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}else{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_mon',
				translation_text ='".$facility_name."',
				translated_text ='".addslashes($_POST['room_facility_mon'])."',
				fld_type='room_facility' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}
		
		
		
	// insert for montenegro language for offline
	//$last_id = mysql_insert_id();
  $property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` = 'room_facility_rus' AND fld_type ='room_facility'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Russian language for offline
	 	
		        $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_rus',
				translation_text ='".$facility_name."',
				translated_text ='".addslashes($_POST['room_facility_rus'])."',
				fld_type='room_facility' 
				WHERE language_id=".$language_id." 
				AND field_name='room_facility_rus' 
				AND fld_type='room_facility'
				";

	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
$language_id=5;  // for Russian language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_rus',
				translation_text ='".$facility_name."',
				translated_text ='".addslashes($_POST['room_facility_rus'])."',
				fld_type='room_facility' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
}
					 
					
					
					
					
					//$okmsg = base64_encode("Facility Added Successfully. !");
					//$okmsg = base64_encode("Sadržaj uspješno dodat");
					$okmsg = base64_encode("Sadr&#382;aj uspje&scaron;no dodat");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				      // $okmsg = base64_encode("Facility Not Added .!");
					  //$okmsg = base64_encode("Sadržaj nije dodat");
					  $okmsg = base64_encode("Sadr&#382;aj nije dodat");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			}
	} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='edit_room_facility_management' && $_POST['request_page']=='room_facility_management'){
			$facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
	 $id=base64_decode($_POST['id']);
	 	$duplicate_query = "SELECT id FROM ".$tblprefix."room_facility_management WHERE facility_name='"
		                       .$facility_name."' AND room_fac_category=".$property_fac_category." AND 
		                       id!=".$id;
		
		$rs_duplicate = $db->Execute($duplicate_query);
		    $totalcount =  $rs_duplicate->RecordCount();
		    if($totalcount>0){
		    	//$errmsg = base64_encode("Room facility is already management");
				//$errmsg = base64_encode("Sadržaj sobe vec postoji");
				$errmsg = base64_encode("Sadr&#382;aj sobe vec postoji");
				
		    	header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg&id=".base64_encode($id));
		    	exit();
		    }else {
			if($facility_name == ''){
				//$errmsg = base64_encode('Molimo unesite naziv sadržaja sobe');
				$errmsg = base64_encode('Molimo unesite naziv sadr&#382;aja sobe');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}
			if($property_fac_category == 0){
				//$errmsg = base64_encode('Molimo izaberite sadržaj');
				$errmsg = base64_encode('Molimo izaberite sadr&#382;aj');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}
			
			 $sql_category= "UPDATE ".$tblprefix."room_facility_management 
														SET
														facility_name = '".$facility_name."',
														room_fac_category =".$property_fac_category."
														WHERE
														id=".$id;
														
				$rs_category = $db->Execute($sql_category);
					if($rs_category){
					   

$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'room_facility_mon' AND fld_type ='room_facility'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0){
 	$language_id=7;  // for Montenegrin language for offline
	  	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_mon',
				translation_text ='".addslashes($facility_name)."',
				translated_text ='".addslashes($_POST['room_facility_mon'])."',
				fld_type='room_facility', 
				page_id =".$id."   
				WHERE language_id=".$language_id." 
				AND field_name='room_facility_mon' 
				AND fld_type='room_facility'
				AND page_id =".$id."
				";

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}else{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_mon',
				translation_text ='".addslashes($facility_name)."',
				translated_text ='".addslashes($_POST['room_facility_mon'])."',
				fld_type='room_facility' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}
		
		
		
	// insert for montenegro language for offline
	//$last_id = mysql_insert_id();
  $property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` = 'room_facility_rus' AND fld_type ='room_facility'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Russian language for offline
	 	
	        $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_rus',
				translation_text ='".$facility_name."',
				translated_text ='".addslashes($_POST['room_facility_rus'])."',
				fld_type='room_facility',
				page_id =".$id."  
				WHERE language_id=".$language_id." 
				AND field_name='room_facility_rus' 
				AND fld_type='room_facility'
				AND page_id =".$id."
				";

	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
$language_id=5;  // for Russian language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='room_facility_rus',
				translation_text ='".$facility_name."',
				translated_text ='".addslashes($_POST['room_facility_rus'])."',
				fld_type='room_facility' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
}
			
						//$okmsg = base64_encode("Property Facility Updated successfully!");
						//$okmsg = base64_encode("Sadržaj objekta uspješno ažuriran");
						$okmsg = base64_encode("Sadr&#382;aj objekta uspje&scaron;no a&#382;uriran");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						//$okmsg = base64_encode("Property Facility Is Not Updated!");
						$okmsg = base64_encode("Sadržaj objekta nije ažuriran");
						$okmsg = base64_encode("Sadr&#382;aj objekta nije a&#382;uriran");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit; 
					}
			}
	} 
	
	 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_facility' && $_GET['act']=='manage_room_facility' && $_GET['request_page']=='room_facility_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."room_facility_management WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		//$okmsg = base64_encode("Room Facility  Deleted successfully. !");
		//$okmsg = base64_encode("Sadržaj objekta uspješno izbrisan");
		$okmsg = base64_encode("Sadr&#382;aj objekta uspje&scaron;no izbrisan");
		header("Location: admin.php?okmsg=$okmsg&act=manage_room_facility");
		exit;	  
} 

?>
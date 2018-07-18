<?php	
if($_POST['mode']=='add' && $_POST['act']=='manage_accomodation' && $_POST['request_page']=='accomodation_management'){
$post=$_POST;
$error='';

$accomm_name = addslashes(trim($post['accomm_name']));
if($accomm_name==''){
	//$error="Business type required<br>";
	$error="Vrsta objekta je obavezna<br>";
}

$slug=slugcreation($accomm_name);

if($post['price_period']==0){
	//$error.="Please define the price period <br>";
	$error.="Molimo definišite cjenovni period <br>";
}



if($error!=''){
	$msg=base64_encode($error);
	header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
	 $update_img_query = "INSERT ".$tblprefix."property_accommodation SET
														accomm_name = '".$accomm_name."',
														price_period= '".$post['price_period']."',
														per_person= '".$post['per_person']."',
														property_type_slug= '".$slug."',
														property_cat = ".$post['property_cat'];
							$run_query = $db->Execute($update_img_query);
							if($run_query){
							
							
	   // collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
	
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"accomm_name") and strlen($key)>strlen("accomm_name")){ 
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
				AND field_name='business_title' 
				AND fld_type='business_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='business_title',
				translation_text ='".addslashes($accomm_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='business_title',
				translation_text ='".addslashes($accomm_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='business_title'  
				AND fld_type='business_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
							
							
								$okmsg = base64_encode("Accommodation inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Accommodation in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
							
			}
}

if($_POST['mode']=='order_menu' && $_POST['act']=='manage_accomodation' && $_POST['request_page']=='accomodation_management'){
	$menu_order=$_POST['menu_order'];
	foreach($menu_order as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
	$sql_change_order= "UPDATE ".$tblprefix."property_accommodation  
													SET 
													cat_orderdering=".$val." 
													WHERE  
													id=".$id;
	$rs_change_order = $db->Execute($sql_change_order);
	}
	$okmsg = base64_encode(" Ordering Set Successfully. !");

					header("Location: admin.php?okmsg=$okmsg&act=manage_accomodation");
					exit;	
}

//Update Section

if($_POST['mode']=='update' && $_POST['act']=='editaccomm' && $_POST['request_page']=='accomodation_management'){
$post=$_POST;
$error='';
$id = base64_decode($_POST['id']);

$_SESSION[accomm_name]=$post['accomm_name'];
$_SESSION[price_period]=$post['price_period'];
$_SESSION[per_person]=$post['per_person'];
$_SESSION[property_cat]=$post['property_cat'];
$_SESSION[id]=$post['id'];
$accomm_name = addslashes(trim($post['accomm_name']));



if($post['accomm_name']==''){
	//$error="Accommodation  Name required<br>";
	$error="Accommodation  Name required<br>";
}
$slug=slugcreation($accomm_name);
if($post['price_period']==0){
	//$error.="Please define the price period <br>";
	$error.="Molimo definišite cjenovni period<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
						$update_img_query = "UPDATE ".$tblprefix."property_accommodation SET
														accomm_name = '".$accomm_name."',
														price_period= '".$post['price_period']."',
														per_person= '".$post['per_person']."',
														property_type_slug= '".$slug."',
														property_cat = ".$post['property_cat']."
														WHERE id=".base64_decode($_POST['id'])
														;
													
						$run_query = $db->Execute($update_img_query);
							if($run_query){
							
							
							// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"accomm_name") and strlen($key)>strlen("accomm_name")){ 
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
				AND field_name='business_title' 
				AND fld_type='business_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='business_title',
				translation_text ='".addslashes($accomm_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='business_title',
				translation_text ='".addslashes($accomm_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='business_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='business_title'  
				AND fld_type='business_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
							
								$okmsg = base64_encode("Business Type Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}							
}
	}
 
	   
######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_accomodation' && $_GET['request_page']=='accomodation_management'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT accomm_name FROM ".$tblprefix."property_accommodation WHERE id =".$id;
	
		$rs_select = $db->Execute($sel_qry);
		
		
		
		$delet_qry = "DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id;
	
		$rs_del = $db->Execute($delet_qry);
		
		
		$del_qry = " DELETE FROM ".$tblprefix."property_accommodation WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/accomm_upload/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		$okmsg = base64_encode("Business Type Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Unable to Delete .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	
	?>
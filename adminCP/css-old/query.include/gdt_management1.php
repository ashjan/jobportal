<?php
if($_POST['mode']=='add' && $_POST['act']=='manage_gdt1' && $_POST['request_page']=='gdt_management1'){

$post=$_POST;
$error='';

$gdt_page_title      = addslashes($post['gdt_page_title']);
$gdt_flag            = addslashes($post['gdt_flag']);
$gdt_description     = addslashes($post['gdt_description']);
$gdt_page_title_slug = slugcreation($gdt_page_title);


//regular exprission
$gdt_page_title_slug=preg_replace('/[^a-z0-9]/i', '', $gdt_page_title_slug);
				if($post['gdt_page_title']==''){
					$error="GDT Title Name is compulsory<br>";
				}
				
				
				if($post['gdt_description']==''){
					$error.="GDT Description is compulsory<br>";
				}
				
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{
					$insert_gdt_query  =  "INSERT INTO ".$tblprefix."site_gdt1 SET 
																gdt_page_title = '".$gdt_page_title."',
																gdt_description = '".$gdt_description."',
																gdt_flag = '0',
																gdt_slug = '".$gdt_page_title_slug."'
																"; 
					$run_query = $db->Execute($insert_gdt_query);
		if($run_query){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"gdt_page_title") and strlen($key)>strlen("gdt_page_title")){ 
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
				AND field_name='gdt_title' 
				AND fld_type='gdt_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='gdt_title',
				translation_text ='".addslashes($gdt_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='gdt_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld = "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='gdt_title',
				translation_text ='".addslashes($gdt_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='gdt_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='gdt_title'  
				AND fld_type='gdt_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"gdt_description") and strlen($key)>strlen("gdt_description")){ 
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
				AND field_name='gdt_description'  
				AND fld_type='gdtdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='gdt_description',
				translation_text ='".$gdt_description."',
				translated_text ='".$val."',
				fld_type='gdtdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='gdt_description',
				translation_text ='".$gdt_description."',
				translated_text ='".$val."',
				fld_type='gdtdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='gdt_description' 
				AND fld_type='gdtdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
								
		$okmsg = base64_encode("GDT inserted successfully.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;
	}else{
		$okmsg = base64_encode("Unable to add GDT in database.!");
		//header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;
	}
}
}




	


/****************************************************************************
*																			*
*                            Update Events 									*
*																			*
****************************************************************************/




if($_POST['mode']=='update' && $_POST['act']=='manage_gdt1' && $_POST['request_page']=='gdt_management1')
{

$post=$_POST;
$error='';
$id=$_POST[page_id];

$gdt_page_title  = addslashes($post['gdt_page_title']);
$gdt_flag        = addslashes($post['gdt_flag']);
$gdt_description = addslashes($post['gdt_description']);
$gdt_page_title_slug=slugcreation($gdt_page_title);
//regular exprission
$gdt_page_title_slug=preg_replace('/[^a-z0-9]/i', '', $gdt_page_title_slug);

				if($post['gdt_page_title']==''){
					$error="GDT Title Name is compulsory<br>";
				}
				
				
				if($post['gdt_description']==''){
					$error.="GDT Description is compulsory<br>";
				}

		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{
				 	$update_gdt_query  =  "UPDATE ".$tblprefix."site_gdt1 SET 
																gdt_page_title = '".$gdt_page_title."',
																gdt_description = '".$gdt_description."',
																gdt_flag = '0',
																gdt_slug = '".$gdt_page_title_slug."'
																where id=".$id; 
							$run_query = $db->Execute($update_gdt_query);
							if($run_query){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"gdt_page_title") and strlen($key)>strlen("gdt_page_title")){ 
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
				AND field_name='gdt_title' 
				AND fld_type='gdt_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='gdt_title',
				translation_text ='".addslashes($gdt_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='gdt_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='gdt_title',
				translation_text ='".addslashes($gdt_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='gdt_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='gdt_title'  
				AND fld_type='gdt_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"gdt_description") and strlen($key)>strlen("gdt_description")){ 
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
				AND field_name='gdt_description'  
				AND fld_type='gdtdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='gdt_description',
				translation_text ='".$gdt_description."',
				translated_text ='".$val."',
				fld_type='gdtdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='gdt_description',
				translation_text ='".$gdt_description."',
				translated_text ='".$val."',
				fld_type='gdtdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='gdt_description' 
				AND fld_type='gdtdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
								$okmsg = base64_encode("GDT updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to updated GDT in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}


}
}
	
	

/***************************************************************************
*
*                         Delete Events 
*
***************************************************************************/

if($_GET['mode']=='delete' && $_GET['act']=='manage_gdt1' && $_GET['request_page']=='gdt_management1')
{


 	$id=base64_decode($_GET['id']); 
	
	
		
		$del_qry = " DELETE FROM ".$tblprefix."site_gdt1 WHERE id =".$id;  
		$rs_delete = $db->Execute($del_qry);
		
			
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='gdtdescription_type' ";  
		$rs_delete = $db->Execute($del_qry);
		
		
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='gdt_type' ";  
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){	
			$okmsg = base64_encode("GDT Deleted successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
 	} 
} 
?>
<?php

/****************************************************************************
*																			*
*                            Add Events 									*
*																			*
****************************************************************************/
if($_POST['mode']=='add' && $_POST['act']=='manage_news' && $_POST['request_page']=='news_management'){
$post=$_POST;
$error='';
$news_page_title = addslashes($post['news_page_title']);
$news_flag = addslashes($post['news_flag']);
$news_description = addslashes($post['news_description']);
$news_page_title_slug=slugcreation($news_page_title);
$created_date= date("Y-m-d h:i:s",$post['created_date']);

//regular exprission
$news_page_title_slug=preg_replace('/[^a-z0-9]/i', '', $news_page_title_slug);

				if($post['news_page_title']==''){
					//$error="NEWS Title Name is compulsory<br>";
					$error="Naslov novosti je obavezan<br>";
				}
				
				
				if($post['news_description']==''){
					//$error.="NEWS Description is compulsory<br>";
					$error.="Opis novosti je oba<br>";
				}
				
				
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{
					$insert_news_query  =  "INSERT INTO ".$tblprefix."site_news SET 
																news_page_title = '".$news_page_title."',
																news_description = '".$news_description."',
																news_flag = '".$news_flag."',
																news_slug = '".$news_page_title_slug."',
																created_date = '".$created_date."'
																";
					
					
					$run_query = $db->Execute($insert_news_query);
			if($run_query)
			{
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"news_page_title") and strlen($key)>strlen("news_page_title")){ 
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
				AND field_name='news_title' 
				AND fld_type='news_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='news_title',
				translation_text ='".addslashes($news_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='news_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='news_title',
				translation_text ='".addslashes($news_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='news_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='news_title'  
				AND fld_type='news_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"news_description") and strlen($key)>strlen("news_description")){ 
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
				AND field_name='news_description'  
				AND fld_type='newsdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='news_description',
				translation_text ='".$news_description."',
				translated_text ='".$val."',
				fld_type='newsdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='news_description',
				translation_text ='".$news_description."',
				translated_text ='".$val."',
				fld_type='newsdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='news_description' 
				AND fld_type='newsdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
								
								//$okmsg = base64_encode("NEWS inserted successfully.!");
								$okmsg = base64_encode("Novosti uspješno dodate.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$okmsg = base64_encode("Unable to add NEWS in database.!");
								$errmsg = base64_encode("Nije moguće dodati novosti.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
							}
}
}

/****************************************************************************
*																			*
*                            Update Events 									*
*																			*
****************************************************************************/
if($_POST['mode']=='update' && $_POST['act']=='manage_news' && $_POST['request_page']=='news_management'){
$post=$_POST;
$error='';
$id=$_POST[page_id];


$news_page_title = addslashes($post['news_page_title']);
$news_flag = addslashes($post['news_flag']);
$news_description = addslashes($post['news_description']);
$news_page_title_slug=slugcreation($news_page_title);
$created_date= date("Y-m-d H:i:s",strtotime($post['created_date']));

//regular exprission
$news_page_title_slug=preg_replace('/[^a-z0-9]/i', '', $news_page_title_slug);
		if($post['news_page_title']==''){
					//$error="NEWS Title Name is compulsory<br>";
					$error="Naslov novosti je obavezan<br>";
				}
		if($post['news_description']==''){
					//$error.="NEWS Description is compulsory<br>";
					$error.="Opis novosti je obavezan<br>";
				}
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{
		$update_news_query  =  "UPDATE ".$tblprefix."site_news SET 
													 news_page_title = '".$news_page_title."',
													 news_description = '".$news_description."',
													 news_flag = '".$news_flag."',
													 news_slug = '".$news_page_title_slug."',
													 created_date = '".$created_date."'
													 WHERE  id=".$id;
		
		
													 
	    $run_query = $db->Execute($update_news_query);
		if($run_query){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
		     $language_id = substr($key,strpos($key,"_",15)+1);
			if(strstr($key,"news_page_title") and strlen($key)>strlen("news_page_title")){ 
			$language_id = substr($key,strpos($key,"_",15)+1);
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
				AND field_name='news_title' 
				AND fld_type='news_type'";
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='news_title',
				translation_text ='".addslashes($news_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='news_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='news_title',
				translation_text ='".addslashes($news_page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='news_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='news_title'  
				AND fld_type='news_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}   // END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"news_description") and strlen($key)>strlen("news_description")){ 
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
				AND field_name='news_description'  
				AND fld_type='newsdescription_type'";
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='news_description',
				translation_text ='".$news_description."',
				translated_text ='".$val."',
				fld_type='newsdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='news_description',
				translation_text ='".$news_description."',
				translated_text ='".$val."',
				fld_type='newsdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='news_description' 
				AND fld_type='newsdescription_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
								//$okmsg = base64_encode("NEWS updated successfully.!");
								$okmsg = base64_encode("Novosti uspješno ažurirane.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$errmsg = base64_encode("Unable to updated NEWS in database.!");
								$errmsg = base64_encode("Nije moguće ažurirati novosti.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
}
}	
/***************************************************************************
*																		   *
*                         Delete Events 								   *		
*																		   *	
***************************************************************************/

if($_GET['mode']=='delete' && $_GET['act']=='manage_news' && $_GET['request_page']=='news_management'){
 	$id=base64_decode($_GET['id']); 
		$del_qry = " DELETE FROM ".$tblprefix."site_news WHERE id =".$id;  
		$rs_delete = $db->Execute($del_qry);
			
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='newsdescription_type' ";  
		$rs_delete = $db->Execute($del_qry);
		
		
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='news_type' ";  
		$rs_delete = $db->Execute($del_qry);
		
		if($rs_delete){	
			//$okmsg = base64_encode("NEWS Deleted successfully. !");
			$okmsg = base64_encode("Novosti uspješno izbrisane. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}else{
			//$errmsg = base64_encode("Unable to Delete NEWS .!");
			$errmsg = base64_encode("Nije moguće izbrisati novosti.!");
			header("Location: admin.php?errmsg =$errmsg &act=".$_GET['act']);
			exit;			
 	} 
} 

?>
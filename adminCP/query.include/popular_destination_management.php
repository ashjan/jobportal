<?php
// ADDING PORTION
if($_POST['mode']=='add' && $_POST['act']=='manage_popular_destination' && $_POST['request_page']=='popular_destination_management'){
$_SESSION['popular_destination']= $_POST;

	$post=$_POST;
	$error='';
	$page_title = addslashes(trim($_POST['page_title'])); 
	$short_description = addslashes(trim($_POST['short_descriptions']));
	$popular_destination_cat_id = addslashes(trim($_POST['popular_destination_cat_id']));
	
	//creating slug
	$slug=slugcreation($page_title); 
	
	
	//validation
	
	
	if($page_title == ''){
				//$errmsg = base64_encode('Please Enter popular destination title');
				$errmsg = base64_encode('Molimo unesite naziv');
				header("Location: admin.php?act=manage_popular_destination&errmsg=$errmsg");
				exit;
			}
	
	if($short_description == ''){
				//$errmsg = base64_encode('Please Enter popular destination description');
				$errmsg = base64_encode('Molimo unesite opis');
				header("Location: admin.php?act=manage_popular_destination&errmsg=$errmsg");
				exit;
			}
			
	if($popular_destination_cat_id == ''){
				//$errmsg = base64_encode('Please Enter popular destination category');
				$errmsg = base64_encode('Molimo unesite kategoriju');
				header("Location: admin.php?act=manage_popular_destination&errmsg=$errmsg");
				exit;
			}	
			
	
	if($_FILES['popular_destination_thumbnail']['name']==NULL){
				$errmsg = base64_encode('Please Enter popular destination thumbnail');
				header("Location: admin.php?act=manage_popular_destination&errmsg=$errmsg");
				exit;
			}		
	

		       $qry_already_event= "SELECT ".$tblprefix."popular_destination.id 
				FROM
				".$tblprefix."popular_destination where popular_destination_slug='".$slug."' "; 
		 	
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				//$errmsg = base64_encode('This Popular Destination already exist.');
				$errmsg = base64_encode('Ova popularna destinacija već postoji.');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}
		
		  
					  
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['popular_destination_thumbnail']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			//$okmsg = base64_encode("image must be image format.!");
			$okmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['popular_destination_thumbnail']['tmp_name']);

				
					  if(move_uploaded_file($_FILES['popular_destination_thumbnail']['tmp_name'], $target_path.$imagename)){ 
					  
					  
					 $update_img_query = "INSERT ".$tblprefix."popular_destination SET
												popular_destination_title = '".$page_title."',
												popular_destination_description = '".$short_description."',
												popular_destination_thumbnail = '".$imagename."',
												popular_destination_cat_id = ".$popular_destination_cat_id.",
												popular_destination_slug = '".$slug."'
												"; 
					$run_query = $db->Execute($update_img_query);
					
		if($run_query)
		{
		
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
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
				AND field_name='page_title' 
				AND fld_type='popular_destination'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='popular_destination'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='popular_destination' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='page_title'  
				AND fld_type='popular_destination'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"short_descriptions") and strlen($key)>strlen("short_descriptions")){ 
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
				AND field_name='short_descriptions'  
				AND fld_type='popular_destination'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='short_descriptions',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='popular_destination'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='short_descriptions',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='popular_destination' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='short_descriptions' 
				AND fld_type='popular_destination'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
		
		
		
		
		
								$okmsg = base64_encode("Destination inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
	}else{
		
			//$msg=base64_encode("Destination could not be updated");
			$msg=base64_encode("Destinacija nije ažurirana");
			header("Location: admin.php?errmsg=$msg&lan=$lan_id&act=contentpage");
			unset($_SESSION['add_content_page']);
			
		}
				}else{
					//$errmsg.= base64_encode("Unable to upload ".$i." image!<br>");
					$errmsg.= base64_encode("Slika nije  ".$i." dodata!<br>");
					header("Location: admin.php?msg=$msg&errmsg=$errmsg&act=".$_POST['act']);
					exit;
				}
			}		
		header("Location: admin.php?msg=$msg&errmsg=$errmsg&act=".$_POST['act']);
		exit;
	
}


######################
#
# 	GET SECTION
#
######################


// update Function
	 	
if($_POST['mode']=='update' && $_POST['act']=='edit_popular_destination' && $_POST['request_page']=='popular_destination_management'){
	

	
	
	$id=base64_decode($_POST['id']);
	$post=$_POST;
	$error='';
	$page_title = addslashes(trim($_POST['page_title']));
	$short_description = addslashes(trim($_POST['short_descriptions']));
	$popular_destination_cat_id = addslashes(trim($_POST['popular_destination_cat_id']));
	
	//creating slug
	 $slug=slugcreation($page_title); 
	
	//Repeatition Check
		
	  $qry_already_event= "SELECT ".$tblprefix."popular_destination.id 
		FROM
		".$tblprefix."popular_destination where ".$tblprefix."popular_destination.id<>".$id." AND ".$tblprefix."popular_destination.popular_destination_slug='".$slug."' "; 
							
		$rs_already_event=$db->Execute($qry_already_event);
		$count_add =  $rs_already_event->RecordCount();
	
		if($count_add > 0){
		//$errmsg = base64_encode('This Popular Destination already exist.');
		$errmsg = base64_encode('Ova popularna destinacija već postoji.');
		header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
		exit;
		}
		

	
	if($page_title == ''){
				//$error = base64_encode('Please Enter popular destination title');
				$error = base64_encode('Molimo unesite naziv');
			}
	
	if($short_description == ''){
				//$error = base64_encode('Please Enter popular destination description');
				$error = base64_encode('Molimo unesite opis');
				
			}
			
			
	if($popular_destination_cat_id == ''){
				//$error = base64_encode('Please Enter popular destination category');
				$error = base64_encode('Molimo unesite kategoriju');
				
			}	
			

if($error!=''){
			$msg=$error;
			header("Location: admin.php?errmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit();
}else{

if(!empty($_FILES['popular_destination_thumbnail']['name'])){ 
							
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['popular_destination_thumbnail']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			//$okmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."media/images/".$imagename;
				$target_path = "media/images/";
				$info = getimagesize($_FILES['popular_destination_thumbnail']['tmp_name']);

					if(move_uploaded_file($_FILES['popular_destination_thumbnail']['tmp_name'], $target_path.$imagename)){
						
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
							
							// $_SESSION['image']= $imagename;
							
			 		  	$update_img_query = "UPDATE ".$tblprefix."popular_destination SET
												popular_destination_title = '".$page_title."',
												popular_destination_description = '".$short_description."',
												popular_destination_thumbnail = '".$imagename."',
												popular_destination_cat_id = ".$popular_destination_cat_id.",
												popular_destination_slug = '".$slug."'
												where id=".$id;   
						 								
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
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
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
				AND field_name='page_title' 
				AND fld_type='popular_destination'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='popular_destination'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='popular_destination' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='page_title'  
				AND fld_type='popular_destination'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"short_descriptions") and strlen($key)>strlen("short_descriptions")){ 
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
				AND field_name='short_descriptions'  
				AND fld_type='popular_destination'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='short_descriptions',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='popular_destination'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='short_descriptions',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='popular_destination' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='short_descriptions' 
				AND fld_type='popular_destination'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
			
			//$msg=base64_encode("Naziv strane uspješno ažuriran.");
			$msg=base64_encode("$pagename Contents Updated successfully.");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act2']."&id=".base64_encode($id));
		}else{
							
								//$errmsg = base64_encode("Unable to Update in database.!");
								$errmsg = base64_encode("Nije moguće ažurirati .!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}
						}else{
							
							
							//$okmsg = base64_encode("Unable to upload  Picture.!");
							$okmsg = base64_encode("Slika nije dodata.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
							exit;
						}		
			
		}
}else{
			$update_img_query = "UPDATE ".$tblprefix."popular_destination SET
			
												popular_destination_title = '".$page_title."',
											
												popular_destination_description = '".$short_description."',
												popular_destination_cat_id = ".$popular_destination_cat_id.",
												popular_destination_slug = '".$slug."'
												
												where id=".$id;   
														
														 
 

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
			if(strstr($key,"page_title") and strlen($key)>strlen("page_title")){ 
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
				AND field_name='page_title' 
				AND fld_type='popular_destination'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='popular_destination'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='page_title',
				translation_text ='".addslashes($page_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='popular_destination' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='page_title'  
				AND fld_type='popular_destination'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"short_descriptions") and strlen($key)>strlen("short_descriptions")){ 
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
				AND field_name='short_descriptions'  
				AND fld_type='popular_destination'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='short_descriptions',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='popular_destination'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='short_descriptions',
				translation_text ='".$short_description."',
				translated_text ='".$val."',
				fld_type='popular_destination' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='short_descriptions' 
				AND fld_type='popular_destination'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
		
		
		
		
			
			//$msg=base64_encode("Popular Destination Updated successfully.!");
			$msg=base64_encode("Ažuriranje uspješno.!");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act2']);
		}else{			
								//$okmsg = base64_encode("Unable to Update in database.!");
								$okmsg = base64_encode("Nije moguće ažurirati  .!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}							
}
	}


}


	
######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_popular_destination' && $_GET['request_page']=='popular_destination_management'){
 
 $id=base64_decode($_GET['id']);  
	
	$sel_qry = "SELECT popular_destination_thumbnail FROM ".$tblprefix."popular_destination WHERE id =".$id;
	
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['popular_destination_thumbnail'];
		
		$del_qry = " DELETE FROM ".$tblprefix."popular_destination WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "media/images/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
				
				
		$del_qry_cont = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='popular_destination' ";
		$rs_delete_cont = $db->Execute($del_qry_cont);
				
		
		//$okmsg = base64_encode("Destination Deleted successfully.!");
		$okmsg = base64_encode("Destinacija uspješno izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	
		
		}
		else{
		//$okmsg = base64_encode("Unable to Delete .!");
		$okmsg = base64_encode("UNije moguće izbrisati .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	

	
?>
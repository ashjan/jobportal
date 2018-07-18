<?php
if($_POST['mode']=='add' && $_POST['act']=='manage_events' && $_POST['request_page']=='events_manage'){
$post=$_POST;
/*echo '<pre>';
print_r($post);
exit;*/
$error='';

$imagename='';
$filename='';
$videoname='';
$vfilename='';
$video_url ='';

$event_name = addslashes($post['event_name']);
$event_start_date = addslashes($post['event_start_date']);
$event_start_date = date("Y-m-d",strtotime($event_start_date));
$event_end_date = addslashes($post['event_end_date']);
$event_end_date=date("Y-m-d",strtotime($event_end_date));
$event_category_name = addslashes($post['event_category_name']);
$event_region = addslashes($post['event_region']);
$event_town = addslashes($post['event_town']);
$venue = addslashes($post['venue']);
$event_description = addslashes($post['event_description']); 
$event_slug=slugcreation($event_name);

$event_description = addslashes($post['event_description']);
//regular exprission
$event_slug=preg_replace('/[^a-z0-9]/i', '', $event_slug);

$video_opts = $post['video_opts'];


				if($post['event_name']==''){
					$error="Event Name is compulsory<br>";
				}
				
				
				if($post['event_start_date']==''){
					$error.="Start Date is compulsory<br>";
				}
				
				if($post['event_end_date']==''){
					$error.="End Date is compulsory<br>";
				}
				
				if($post['event_region']==''){
					$error.="Event Region is compulsory<br>";
				}
				
				if($post['event_category_name']==''){
					$error.="Event Category Name is Compulsory<br>";
				}
				
				if($post['event_town']==''){
					$error.="Event Town Name is Compulsory<br>";
				}
				
				/*if($post['video_opts']==''){
					$error.="Please Select Video Options<br>";
				}*/
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}elseif($video_opts == 0){

				if($_FILES['video']["name"][$key] != "" ){
				
				$event_video = $_FILES['video'];
	 			$video_name_rand = generateRandomString(10);
				$vtype = explode(".", $_FILES['video']['name']);	
				$videoname = $video_name_rand.".".$vtype[1];
				$vfilename = "media/videos/".$videoname; 
				$vtarget_path = "media/videos/";
				$vinfo = getimagesize($_FILES['video']['tmp_name']);		
				
				if(!move_uploaded_file($_FILES['video']['tmp_name'], $vtarget_path.$videoname)){
					$okmsg = base64_encode("Unable to upload video!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;
				}
				}
				
				if($_FILES["image"]["name"][$key]!=""){
				$image= $_FILES['image'];
				$image_name_rand = generateRandomString(10);
				$type = explode(".", $_FILES['image']['name']);	
				$imagename = $image_name_rand.".".$type[1];
				$filename = "media/images/".$imagename; 
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);	
				
				if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
					$okmsg = base64_encode("Unable to upload image!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				}
				
				}


		

				
				
				$update_img_query  =  "INSERT ".$tblprefix."events SET 
																event_name = '".$event_name."',
																event_start_date = '".$event_start_date."',
																event_end_date = '".$event_end_date."',
																event_category_name = '".$event_category_name."',
																event_region = '".$event_region."',
																event_town = '".$event_town."',
																venue = '".$venue."',
																event_picture='".$imagename."',
																image_path='".$filename."',
																event_video='".$videoname."',
																video_full_path='".$vfilename."',
																video_url='".$video_url."',
																video_switcher ='".$video_opts."',
																event_description = '".$event_description."',
																event_slug = '".$event_slug."'"; 
	 						
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
			if(strstr($key,"event_name") and strlen($key)>strlen("event_name")){ 
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
				AND field_name='event_title' 
				AND fld_type='event_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_title'  
				AND fld_type='event_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"event_description") and strlen($key)>strlen("event_description")){ 
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
				AND field_name='event_description'  
				AND fld_type='eventdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_description' 
				AND fld_type='eventdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
										
		
								$okmsg = base64_encode("Event inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
	}
	else
	{
		$okmsg = base64_encode("Unable to add Event in database.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;
	}


// Switch_video occurs here, if We have URL

}elseif($video_opts = 1){

	
		$video_url = $post['video_embed_code'];
		
		if($_FILES["image"]["name"][$key]!=""){
				$image= $_FILES['image'];
				$image_name_rand = generateRandomString(10);
				$type = explode(".", $_FILES['image']['name']);	
				$imagename = $image_name_rand.".".$type[1];
				$filename = "media/images/".$imagename; 
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);	
				
				if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
					$okmsg = base64_encode("Unable to upload image!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				}
				
				}



					$update_img_query  =  "INSERT ".$tblprefix."events SET 
																event_name = '".$event_name."',
																event_start_date = '".$event_start_date."',
																event_end_date = '".$event_end_date."',
																event_category_name = '".$event_category_name."',
																event_region = '".$event_region."',
																event_town = '".$event_town."',
																venue = '".$venue."',
																event_picture='".$imagename."',
																image_path='".$filename."',
																event_video='".$videoname."',
																video_full_path='".$vfilename."',
																video_url='".$video_url."',
																video_switcher ='".$video_opts."',
																event_description = '".$event_description."',
																event_slug = '".$event_slug."'"; 
	 						
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
			if(strstr($key,"event_name") and strlen($key)>strlen("event_name")){ 
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
				AND field_name='event_title' 
				AND fld_type='event_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_title'  
				AND fld_type='event_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"event_description") and strlen($key)>strlen("event_description")){ 
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
				AND field_name='event_description'  
				AND fld_type='eventdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_description' 
				AND fld_type='eventdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
								
								
								
								
								
								$okmsg = base64_encode("Event inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
							else
							{
								$okmsg = base64_encode("Unable to add Event in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}


}

}




	


/****************************************************************************
*																			*
*                            Update Events 									*
*																			*
****************************************************************************/




if($_POST['mode']=='update' && $_POST['act']=='manage_events' && $_POST['request_page']=='events_manage')
{

$post=$_POST;
$error='';
$id=$_POST[page_id];
$qry_limit =  "SELECT * FROM  ".$tblprefix."events WHERE id=".$id;  		
$rs_limit = $db->Execute($qry_limit);

$imagename= $rs_limit->fields['event_picture'];
$filename = $rs_limit->fields['image_path'];
$videoname = $rs_limit->fields['event_video'];
$vfilename= $rs_limit->fields['video_full_path'];
$video_url = $rs_limit->fields['video_url'];

$event_name = addslashes($post['event_name']);
$event_start_date = addslashes($post['event_start_date']);
$event_start_date = date("Y-m-d",strtotime($event_start_date));
$event_end_date = addslashes($post['event_end_date']);
$event_end_date=date("Y-m-d",strtotime($event_end_date));
$event_category_name = addslashes($post['event_category_name']);
$event_region = addslashes($post['event_region']);
$event_town = addslashes($post['event_town']);
$venue = addslashes($post['venue']);
$event_description = addslashes($post['event_description']);
$event_slug=slugcreation($event_name);

//regular exprission
$event_slug=preg_replace('/[^a-z0-9]/i', '', $event_slug);



$video_opts = $post['video_opts'];


				if($post['event_name']==''){
					$error="Event Name is compulsory<br>";
				}
				
				
				if($post['event_start_date']==''){
					$error.="Start Date is compulsory<br>";
				}
				
				if($post['event_end_date']==''){
					$error.="End Date is compulsory<br>";
				}
				
				if($post['event_region']==''){
					$error.="Event Region is compulsory<br>";
				}
				
				if($post['event_category_name']==''){
					$error.="Event Category Name is Compulsory<br>";
				}
				
				if($post['event_town']=='' or $post['event_town']=='0'){
					$error.="Event Town Name is Compulsory<br>";
				}
				
				/*if($post['video_opts']==''){
					$error.="Please Select Video Options<br>";
				}*/
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}elseif($video_opts == 0){

				if($_FILES['video']["name"][$key] != "" ){
				$video_url = '';
				$event_video = $_FILES['video'];
	 			$video_name_rand = generateRandomString(10);
				$vtype = explode(".", $_FILES['video']['name']);	
				$videoname = $video_name_rand.".".$vtype[1];
				$vfilename = "media/videos/".$videoname; 
				$vtarget_path = "media/videos/";
				$vinfo = getimagesize($_FILES['video']['tmp_name']);		
				
				if(move_uploaded_file($_FILES['video']['tmp_name'], $vtarget_path.$videoname))
				{
																		
						if($_POST['old_video']!=""){
								if(file_exists($vtarget_path.$_POST['old_video'])){
									unlink($vtarget_path.$_POST['old_video']);
								}
							}
				}
				else
				{
					$okmsg = base64_encode("Unable to upload video!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				}
				}
				
				
				
				
				
				
				
				
				
				if($_FILES["image"]["name"][$key]!=""){
				$image= $_FILES['image'];
				$image_name_rand = generateRandomString(10);
				$type = explode(".", $_FILES['image']['name']);	
				$imagename = $image_name_rand.".".$type[1];
				$filename = "media/images/".$imagename; 
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);	
				
				if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
					if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
				}
				
				}


		

				
				
			 	$update_img_query  =  "UPDATE ".$tblprefix."events SET 
																event_name = '".$event_name."',
																event_start_date = '".$event_start_date."',
																event_end_date = '".$event_end_date."',
																event_category_name = '".$event_category_name."',
																event_region = '".$event_region."',
																event_town = '".$event_town."',
																venue = '".$venue."',
																event_picture='".$imagename."',
																image_path='".$filename."',
																event_video='".$videoname."',
																video_full_path='".$vfilename."',
																video_url='".$video_url."',
																video_switcher ='".$video_opts."',
																event_description = '".$event_description."',
																event_slug = '".$event_slug."'
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
			if(strstr($key,"event_name") and strlen($key)>strlen("event_name")){ 
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
				AND field_name='event_title' 
				AND fld_type='event_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_title'  
				AND fld_type='event_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"event_description") and strlen($key)>strlen("event_description")){ 
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
				AND field_name='event_description'  
				AND fld_type='eventdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_description' 
				AND fld_type='eventdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
							
								$okmsg = base64_encode("Event updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to updated Event in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}


// Switch_video occurs here, if We have URL
}elseif($video_opts = 1){

		$videoname='';
		$vfilename='';
		$video_url = $post['video_embed_code'];
		
		if($_FILES["image"]["name"][$key]!=""){
				$image= $_FILES['image'];
				$image_name_rand = generateRandomString(10);
				$type = explode(".", $_FILES['image']['name']);	
				$imagename = $image_name_rand.".".$type[1];
				$filename = "media/images/".$imagename; 
				$target_path = "media/images/";
				$info = getimagesize($_FILES['image']['tmp_name']);	
				
				if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
					if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
				}
				
				}
				
				
				
				
									 if($_POST['old_video']!=""){
											if(file_exists($target_path.$_POST['old_video'])){
												unlink($target_path.$_POST['old_video']);
														//for deleting values from db
														
														}
												}
									
				
				



					$update_img_query  =  "UPDATE ".$tblprefix."events SET 
																event_name = '".$event_name."',
																event_start_date = '".$event_start_date."',
																event_end_date = '".$event_end_date."',
																event_category_name = '".$event_category_name."',
																event_region = '".$event_region."',
																event_town = '".$event_town."',
																venue = '".$venue."',
																event_picture='".$imagename."',
																image_path='".$filename."',
																event_video='".$videoname."',
																video_full_path='".$vfilename."',
																video_url='".$video_url."',
																video_switcher ='".$video_opts."',
																event_description = '".$event_description."',
																event_slug = '".$event_slug."'
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
			if(strstr($key,"event_name") and strlen($key)>strlen("event_name")){ 
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
				AND field_name='event_title' 
				AND fld_type='event_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_title',
				translation_text ='".addslashes($event_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='event_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_title'  
				AND fld_type='event_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
			if(strstr($key,"event_description") and strlen($key)>strlen("event_description")){ 
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
				AND field_name='event_description'  
				AND fld_type='eventdescription_type'"
				;
          
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds<=0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='event_description',
				translation_text ='".$event_description."',
				translated_text ='".$val."',
				fld_type='eventdescription_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='event_description' 
				AND fld_type='eventdescription_type'
				";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
							
							
							
							
								$okmsg = base64_encode("Event updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to updated Event in database.!");
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

if($_GET['mode']=='delete' && $_GET['act']=='manage_events' && $_GET['request_page']=='events_manage')
{


 	$id=base64_decode($_GET['id']); 
	$sel_qry = "SELECT event_picture,event_video FROM ".$tblprefix."events WHERE id =".$id; 
	$rs_select = $db->Execute($sel_qry);
	$is_rs = $rs_select->RecordCount();
	if($is_rs > 0){
	
		$image_name=$rs_select->fields['event_picture'];
		$video_name=$rs_select->fields['event_video'];
		$target_path = "media/images/";
		$vtarget_path = "media/videos/";
		
		$del_qry = " DELETE FROM ".$tblprefix."events WHERE id =".$id;  
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			
			if(file_exists($target_path.$image_name)){
				unlink($target_path.$image_name);
			}
			
			if(file_exists($vtarget_path.$video_name)){
					unlink($vtarget_path.$video_name);
			}
			
			$del_qry = '';
			$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='eventdescription_type' ";  
		$rs_delete = $db->Execute($del_qry);
			
			$okmsg = base64_encode("Event Deleted successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
 	} 
} 






?>
<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------
	if($_POST['mode']=='add' && $_POST['act']=='manage_properties' && $_POST['request_page']=='properties_management'){
		$_SESSION["addproperty"] = $_POST;
	
	    $post=$_POST;
		################## Property code script ##################
		$pm_id = $_POST['first_name'];
		$type=$_POST['propertystatus'];
		$query = "select property_code from tbl_properties where pm_id = '".$pm_id."' order by id DESC LIMIT 1";
		$result_query = mysql_query($query);
		$total = mysql_num_rows($result_query);
		if($total != 0)
		{
			while($rws = mysql_fetch_array($result_query))
			{
				$ar[] = $rws['property_code'];
				$arr = explode("-",trim($rws['property_code']));
				$code_array[] = trim($arr[0]);
			}
			
			$maxval = max($code_array);
			if($type == 0){$offline = 2;}else{$offline = 1;}
			$fstval = substr($maxval,0,1);

			if($fstval == $offline){     
				$maxval = $maxval + 1;
				$year = substr(date('Y'),3,1);
				$code = $maxval."-".$year;
			}else{
				$sub = substr($maxval,1,4);
				$year = substr(date('Y'),3,1);
				$sub = $sub+1;
				$sub = sprintf('%04d',$sub);
				$code = $offline.$sub."-".$year;
			}
		}
		else
		{
			/*
			$sql = "select pm_type from tbl_properties where id = '".$pm_id."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$type1 = $row['pm_type'];
			*/
			if($type == 0){
				$year = substr(date('Y'),3,1); 
				$offline = 2;
				$code = $offline."0001-".$year;
			}
			else
			{
				$year = substr(date('Y'),3,1);
				$offline = 1;
				$code = $offline."0001-".$year;
			}
		}
		
		################## Property code script ##################
		$property_category = addslashes(trim($_POST['property_category']));
        $property_name = addslashes(trim($_POST['property_name']));
		$region = addslashes(trim($_POST['region']));
		$street = addslashes(trim($_POST['street']));
		$town = addslashes(trim($_POST['town']));
		$postcode = addslashes(trim($_POST['postcode']));
		$telephone = addslashes(trim($_POST['telephone']));
		$fax = addslashes(trim($_POST['fax']));
		$email = addslashes(trim($_POST['email']));
		$property_url = addslashes(trim($_POST['property_url']));
		$numbers_of_stars = addslashes(trim($_POST['numbers_of_stars']));
		$property_thumbnail = addslashes(trim($_FILES['property_thumbnail']['name']));
		$local_bank_account = addslashes(trim($_POST['local_bank_account']));
		if(($_FILES['property_thumbnail']['error']==0) and (!empty($_FILES['property_thumbnail']['name']))){
		            $image_name_rand = generateRandomString(10);
					//$type = explode(".", $_FILES['property_thumbnail']['name']);
					$type = pathinfo($_FILES['property_thumbnail']['name'], PATHINFO_EXTENSION);
					$imagename = $image_name_rand.".".$type;
							$filename = MYSURL."graphics/thumbnail_upload/".$imagename;
							$target_path = "graphics/thumbnail_upload/";
							$info = getimagesize($_FILES['property_thumbnail']['tmp_name']);
							if($info[0] > 1000) {
								$get_thumb = new Thumbnail($_FILES['property_thumbnail']['tmp_name'],800,600, $target_path.$imagename,100,'');
								$get_thumb->create();
								$image_upload_status = TRUE;
							}else{
								if(move_uploaded_file($_FILES['property_thumbnail']['tmp_name'], $target_path.$imagename)){
									$image_upload_status = true;
									$_SESSION["addproperty"]["property_thumbnail"] =$imagename;
								}else{
									$image_upload_status = false;
								}
							}
					
					
		
		
		}
		
		$business_type = $_POST['business_type'];
		$business_subtype = $_POST['business_subtype'];
		$latitude = addslashes(trim($_POST['latitude']));
		$longitude = addslashes(trim($_POST['longitude']));
		$no_property_rooms = addslashes(trim($_POST['no_property_rooms']));
		/*$room_type = addslashes(trim($_POST['room_type']));*/
		if($property_category!=24){
			$pmtype = 0;
		}else {
		$pmtype = addslashes(trim($_POST['propertystatus']));
		}
		
		//$code = '';
		$termms = $_POST['trmcond1'];
		
		$short_description = addslashes(trim($_POST['short_description']));
		$slug=slugcreation($property_name);
		//regular exprission
		$slug=preg_replace('/[^a-z0-9]/i', '', $slug);
		
		$contact_language = $_POST['contact_language'];
		
		$count = count($contact_language);

		$count_new=$count-1;
		for($i=0; $i<$count; $i++){
			if($count_new > $i){
				$data.= $contact_language[$i].", ";
				}else{
				$data.=$contact_language[$i];
				}
		}
		
		
		 //$data;
        //field validation.
		
		if($property_name == ''){
				//$errmsg = base64_encode('Please Enter Property Name');
				$errmsg = base64_encode('Molimo unesite naziv objekta');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}
						
								
		if($street == ''){
				//$errmsg = base64_encode('Please Enter Street Name');
				$errmsg = base64_encode('Molimo unesite ulicu');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}
							
		if($town == ''){
				//$errmsg = base64_encode('Please Enter Town Name');
				$errmsg = base64_encode('Molimo unesite ime grada');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}				
		if($postcode == ''){
				//$errmsg = base64_encode('Please Enter Postcode Name');
				$errmsg = base64_encode('Molimo unesite poštanski broj');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}				
		if($telephone == ''){
				//$errmsg = base64_encode('Please Enter Telephone Name');
				$errmsg = base64_encode('Molimo unesite telefonski broj');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}
		/*					
		if($fax == ''){
				$errmsg = base64_encode('Please Enter Fax  Name');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}				
		if($email == ''){
				$errmsg = base64_encode('Please Enter Email  Name');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}
								
							
						
		if($local_bank_account == ''){
				$errmsg = base64_encode('Please Enter Local Bank Account  Name');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}	*/			
			
		if($business_type == ''){
				//$errmsg = base64_encode('Please Select Business Type Name');
				$errmsg = base64_encode('Molimo izaberite vrstu objekta');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
		}
		if($business_type == 0){
				//$errmsg = base64_encode('Please Select Business Type Name');
				$errmsg = base64_encode('Molimo izaberite vrstu objekta');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
		}
		if(!isset($termms)){
				//$errmsg = base64_encode('You must Agree to the Terms and Condition of Property!!');
				$errmsg = base64_encode('Morate potvrditi da se slažete sa Uslovima i odredbam!');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
		}
		if($pmtype==2){
			
				//$errmsg = base64_encode('Please select Property Type');
				$errmsg = base64_encode('Molimo izaberite tip objekta');
				header("Location: admin.php?act=manage_properties&errmsg=$errmsg");
				exit;
			}
		
		if($no_property_rooms == '')
		{
			$no_property_rooms = 0;
			}
		//image upload code from here	
		$error='';
			if(empty($_SESSION["addproperty"]["property_thumbnail"])){
				//$error.="Image Field is Required"; 
				$error.="Slika je obavezna"; 
			}
			if($error!=''){
						$msg=base64_encode($error);
						header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
						exit();
			}else{
					/*
					$image_name_rand = generateRandomString(10);
					$type = pathinfo($_FILES['property_thumbnail']['name'], PATHINFO_EXTENSION);
					*/
					//if($type!="jpg" && $type!="jpeg" && $type!="gif" && $type!="png" && $type!="PNG"){
					//	$okmsg = base64_encode("image must be image format.!");
					//	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					//	exit();
					//}else{
							//$imagename = $image_name_rand.".".$type;
							//$filename = MYSURL."graphics/thumbnail_upload/".$imagename;
							//$target_path = "graphics/thumbnail_upload/";
							//$info = getimagesize($_FILES['property_thumbnail']['tmp_name']);
							//if($info[0] > 1000) {
							//	$get_thumb = new Thumbnail($_FILES['property_thumbnail']['tmp_name'],800,600, $target_path.$imagename,100,'');
							//	$get_thumb->create();
							//	$image_upload_status = TRUE;
							//}else{
							//	if(move_uploaded_file($_FILES['property_thumbnail']['tmp_name'], $target_path.$imagename)){
							//		$image_upload_status = true;
							//	}else{
							//		$image_upload_status = false;
							//	}
							//}
					if($image_upload_status){
					                if(!empty($_SESSION["addproperty"]["property_thumbnail"])){
									   $imagename = $_SESSION["addproperty"]["property_thumbnail"];
									}
									$update_img_query = "INSERT INTO ".$tblprefix."properties 
														SET
														pm_id = '".$pm_id."',
														property_name = '".$property_name."',
														property_code = '".$code."',
														property_category = '".$property_category."',
														region ='".$region."',
														street = '".$street."',
														town ='".$town."',
														postcode ='".$postcode."',
														telephone ='".$telephone."',
														fax ='".$fax."',
														email ='".$email."',
														pm_type = '".$pmtype."',
														property_url ='".$property_url."',
														numbers_of_stars ='".$numbers_of_stars."',
														property_thumbnail= '".$imagename."',
														local_bank_account ='".$local_bank_account."',
														business_type ='".$business_type."',
														business_subtype ='".$business_subtype."',
														total_number_rooms = '".$no_property_rooms."',
														properties_slug ='".$slug."',
														latitude ='".$latitude."',
														longitude ='".$longitude."',
														no_property_rooms ='".$no_property_rooms."',
														contact_language ='".$data."',
														short_description ='".$short_description."'
														";
		$run_query = $db->Execute($update_img_query);
		unset($_SESSION["addproperty"]);
		if($run_query){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"property_name") and strlen($key)>strlen("property_name")){ 
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
				AND field_name='property_name' 
				AND fld_type='property_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='property_name',
				translation_text ='".addslashes($property_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='property_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='property_name',
				translation_text ='".addslashes($property_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='property_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='property_name'  
				AND fld_type='property_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
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
		}  // foreach($my_post as $key=>$val)
			
											
											 
											//$okmsg = base64_encode("Property inserted successfully.!");
											$okmsg = base64_encode("Objekat uspješno dodat.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}else{
											//$okmsg = base64_encode("Unable to add Property in database.!");
											$okmsg = base64_encode("Nije moguće dodati nekretnina u bazi podataka.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}
									}else{
										//$okmsg = base64_encode("Unable to upload image, please try again!");
										$okmsg = base64_encode("Nije moguće učitati sliku, pokušajte ponovo!");
										header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
										exit;
									}		
					//}
			
				}
	}
    //---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='manage_properties' && $_POST['request_page']=='properties_management'){
	    
	    $property_name = addslashes(trim($_POST['property_name']));
		$id=base64_decode($_POST['id']);
		$encryptedid=$_POST['id'];
		$property_category = addslashes(trim($_POST['property_category']));
		$first_name = addslashes(trim($_POST['first_name']));
		$region = addslashes(trim($_POST['region']));
		$street = addslashes(trim($_POST['street']));
		$town= addslashes(trim($_POST['town']));
		$postcode = addslashes(trim($_POST['postcode']));
		$telephone = addslashes(trim($_POST['telephone']));
		$fax = addslashes(trim($_POST['fax']));
		$email = addslashes(trim($_POST['email']));
		$property_url = addslashes(trim($_POST['property_url']));
		$numbers_of_stars = addslashes(trim($_POST['numbers_of_stars']));
		$image_gallery = addslashes(trim($_POST['image_gallery']));
		$video_gallery = addslashes(trim($_POST['video_gallery']));
		$local_bank_account = addslashes(trim($_POST['local_bank_account']));
		$business_type = addslashes(trim($_POST['business_type']));
		$business_subtype = addslashes(trim($_POST['business_subtype']));
		$latitude = addslashes(trim($_POST['latitude']));
		$longitude = addslashes(trim($_POST['longitude']));
		$short_description = addslashes(trim($_POST['short_description']));
		$no_property_rooms = addslashes(trim($_POST['no_property_rooms']));
		/*$room_type = addslashes(trim($_POST['room_type']));*/
		if($property_category!=24){$pmtype = 0;}else{$pmtype = addslashes(trim($_POST['propertystatus']));}
		$slug=slugcreation($property_name);
		//regular exprission
		$slug=preg_replace('/[^a-z0-9]/i', '', $slug);
		
		
		$_SESSION['p_id']=$id;
		$_SESSION['first_name']= $first_name;
		$_SESSION['property_category']= $property_category; 
		$_SESSION['property_name']=$property_name;
		$_SESSION['business_type']=$business_type;
		$_SESSION['business_subtype']=$business_subtype;
		$_SESSION['accomm_name']= $accomm_name;
		$_SESSION['region']= $region;
		$_SESSION['region_name']= $region_name;
		$_SESSION['street']= $street;
		$_SESSION['town']= $town;
		$_SESSION['postcode']= $postcode;
		$_SESSION['telephone']= $telephone;
		$_SESSION['fax']= $fax;
		$_SESSION['email']= $email;
		$_SESSION['property_url']= $property_url;
		$_SESSION['no_property_rooms']= $no_property_rooms;
		$_SESSION['numbers_of_stars']= $numbers_of_stars;
		$_SESSION['property_thumbnail']= $property_thumbnail;
		$_SESSION['local_bank_account']= $local_bank_account;
		$_SESSION['latitude']= $latitude;
		$_SESSION['longitude']= $longitude;
		$_SESSION['Lan_name']= $Lan_name;
		$_SESSION['short_description']= $short_description;
		$_SESSION['no_property_rooms']= $no_property_rooms;
		/*$_SESSION['room_type']= $room_type;*/
		$_SESSION['propertystatus']= $pmtype;
		
		
		$contact_language = $_POST['contact_language'];
		$count = count($contact_language);
		$count_new=$count-1;
		for($i=0; $i<$count; $i++){
			if($count_new > $i){
				$data.= $contact_language[$i].", ";
				}else{
				$data.=$contact_language[$i];
				}
		}
		
	         
		if($property_name == ''){
				//$errmsg = base64_encode('Please Enter Property Name');
				$errmsg = base64_encode('Unesite naziv vlasništva');
				header("Location: admin.php?act=editproperties&id=$encryptedid&errmsg=$errmsg");
				exit;
			}
						
		if($street == ''){
				//$errmsg = base64_encode('Please Enter Street Name');
				$errmsg = base64_encode('Unesite naziv ulice');
				header("Location: admin.php?act=editproperties&errmsg=$errmsg&id=$encryptedid");
				exit;
			}
							
		if($town == ''){
				//$errmsg = base64_encode('Please Enter Town Name');
				$errmsg = base64_encode('Unesite naziv grada');
				header("Location: admin.php?act=editproperties&errmsg=$errmsg&id=$encryptedid");
				exit;
			}				
		if($postcode == ''){
				//$errmsg = base64_encode('Please Enter Postcode Name');
				$errmsg = base64_encode('Unesite Poštanski Ime');
				header("Location: admin.php?act=editproperties&errmsg=$errmsg&id=$encryptedid");
				exit;
			}				
		if($telephone == ''){
				//$errmsg = base64_encode('Please Enter Telephone Name');
				$errmsg = base64_encode('Unesite telefonski Ime');
				header("Location: admin.php?act=editproperties&errmsg=$errmsg&id=$encryptedid");
				exit;
			}
		if($business_type == '' or $business_type == 0 ){
				//$errmsg = base64_encode('Please Enter Business Type Name');
				$errmsg = base64_encode('Molimo unesite naziv tvrtke Vid');
				header("Location: admin.php?act=editproperties&errmsg=$errmsg&id=$encryptedid");
				exit;
			}
		if($no_property_rooms == ''){
			$no_property_rooms = 0;
		}		
			
			
			//upload in the edit form
			//image upload code from here	
			$error='';
			if($error!=''){
						$msg=base64_encode($error);
						header("Location: admin.php?okmsg=$msg&act=editproperties");
			}else{
		
					
					//mysql_set_charset('utf8');
                    //mysql_query("SET NAMES 'utf8'");
					if(!empty($_FILES['property_thumbnail']['name']))
					{
						$image_name_rand = generateRandomString(10);
						//$type = explode(".", $_FILES['property_thumbnail']['name']);
						$type = pathinfo($_FILES['property_thumbnail']['name'], PATHINFO_EXTENSION);

						if($type!="jpg" && $type!="jpeg" && $type!="gif" && $type!="png" && $type!="PNG")
						{
							//$okmsg = base64_encode("image must be image format!");
							$okmsg = base64_encode("Slika mora biti format slike!");							
							header("Location: admin.php?okmsg=$okmsg&act=editproperties");
							exit();
						}else{
								$imagename = $image_name_rand.".".$type;
								$filename = MYSURL."graphics/thumbnail_upload/".$imagename;
								$target_path = "graphics/thumbnail_upload/";
								$info = getimagesize($_FILES['property_thumbnail']['tmp_name']);
				
								if($info[0] > 2000){
									$get_thumb = new Thumbnail($_FILES['property_thumbnail']['tmp_name'],800,600, $target_path.$imagename,100,'');
									$get_thumb->create();
									$qryappend = " property_thumbnail='".$imagename."',";
								}else{
										if(move_uploaded_file($_FILES['property_thumbnail']['tmp_name'], $target_path.$imagename))
										{
											$qryappend = " property_thumbnail='".$imagename."',";
										}else{
											//$okmsg = base64_encode("Unable to upload image, please try again!");
											$okmsg = base64_encode("Nije moguće učitati sliku, pokušajte ponovo!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}
								}
						}
					}else{$qryappend = "";}
										$sql_update= "UPDATE ".$tblprefix."properties set
										property_name = '".$property_name."',
										property_category = '".$property_category."',
										region ='".$region."',
										street = '".$street."',
										town ='".$town."',
										postcode ='".$postcode."',
										telephone ='".$telephone."',
										fax ='".$fax."',
										email ='".$email."',
										property_url ='".$property_url."',
										numbers_of_stars ='".$numbers_of_stars."',
										".$qryappend."
										local_bank_account ='".$local_bank_account."',
										business_type ='".$business_type."',
										business_subtype ='".$business_subtype."',
										properties_slug ='".$slug."',
										latitude ='".$latitude."',
										longitude ='".$longitude."',
										no_property_rooms ='".$no_property_rooms."',
										total_number_rooms ='".$no_property_rooms."',
										pm_type ='".$pmtype."',
										contact_language ='".$data."',
										short_description ='".$short_description."'
										WHERE
										id=".$id;
										$run_query = $db->Execute($sql_update);
		if($run_query){
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"property_name") and strlen($key)>strlen("property_name")){ 
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
				AND field_name='property_name' 
				AND fld_type='property_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='property_name',
				translation_text ='".addslashes($property_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='property_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='property_name',
				translation_text ='".addslashes($property_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='property_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='property_name'  
				AND fld_type='property_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){
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
		}  // foreach($my_post as $key=>$val)
											//$okmsg = base64_encode("Property Updated successfully.!");
											$okmsg = base64_encode("Nekretnine Updated uspješno.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}else{
											//$okmsg = base64_encode("Unable to Update Property in database.!");
											$okmsg = base64_encode("Nije moguće ažurirati nekretnina u bazi podataka.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}
						}
			}
	   
######################
#
# 	GET SECTION
#
######################	

//---------Delete THe Category and its language contents---------
if($_GET['mode']=='delete' && $_GET['act']=='manage_properties' && $_GET['request_page']=='properties_management'){
		$id=base64_decode($_REQUEST['id']);
		if(empty($id)){
			$id = 0;
		}
		

		$sel_qry = "SELECT image_full_path FROM ".$tblprefix."mediaimages WHERE property_id =".$id;
		
		$rs_select = $db->Execute($sel_qry);
		$rs_select->MoveFirst();
		while(!$rs_select->EOF)
		{
			echo $rs_select->fields['image_full_path']."<br>";
			$rs_select->MoveNext();
		}
		
		
		$del_property = " DELETE FROM ".$tblprefix."properties WHERE id = ".$id." ";
		$rs_property = $db->Execute($del_property);
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."bedding WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."cancellation WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$sel_qry = "SELECT image_name FROM ".$tblprefix."mediaimages WHERE property_id =".$id;
		$rs_select = $db->Execute($sel_qry);
		
		while(!$rs_select->EOF)
		{
			$image_name=$rs_select->fields['image_name'];
			$target_path = "media/images/";
			
			if(file_exists($target_path.$image_name))
			{
				@unlink($target_path.$image_name);
			}
			$rs_select->MoveNext();
		}
		$del_property = " DELETE FROM ".$tblprefix."mediaimages WHERE property_id = '".$id."' ";
		$rs_property = $db->Execute($del_property);	
		
		
		$del_property = '';	
		$rs_property = '';
		$sel_qry = '';
		$rs_select = '';
		
		$sel_qry = "SELECT video_name FROM ".$tblprefix."mediaivideos WHERE property_id =".$id;
		$rs_select = $db->Execute($sel_qry);
	
				
		while(!$rs_select->EOF)
		{
			$image_name=$rs_select->fields['video_name'];
			$target_path = "media/videos/";
			
			if(file_exists($target_path.$image_name))
			{
				@unlink($target_path.$image_name);
			}
			$rs_select->MoveNext();
		}
		$del_property = " DELETE FROM ".$tblprefix."mediaivideos WHERE property_id = '".$id."' ";
		$rs_property = $db->Execute($del_property);	
		
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."property_facilities WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."property_manager_commission WHERE pt_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."property_minimum_stay WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."property_policy WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."related_properties WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."rooms WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."room_facility WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."standard_date WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."standard_rates WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."tariff_calculations WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."top_offers WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."vat_tax_charges WHERE property_id = ".$id." ";
		$rs_property = $db->Execute($del_property);	
		
		$del_property = '';	
		$rs_property = '';
		
		$del_property = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = ".$id." AND fld_type='property_type' ";
		$rs_property = $db->Execute($del_property);				
						
		//$okmsg = base64_encode("Property  Deleted successfully!");
		$okmsg = base64_encode("Nekretnina je uspješno izbrisana!");
		header("Location: admin.php?okmsg=$okmsg&act=manage_properties");
		exit;	  
 }
		
		
		//---------Delete THe Category and its language contents---------
if($_GET['mode']=='change_properystatus' && $_GET['act']=='manage_properties' && $_GET['request_page']=='properties_management'){
		$id=base64_decode($_GET['id']);
         
		 $status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		 $update_qry = " UPDATE ".$tblprefix."properties SET
		                                                  permission_status = '".$newstatus."'
														  WHERE id          = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);				

		//$okmsg = base64_encode("Property Status UPDATED successfully!");
		$okmsg = base64_encode("Nekretnine Status uspješno ažurirani!");
		header("Location: admin.php?okmsg=$okmsg&act=manage_properties");
		exit;	  
 }
		
//---------Service Provider Status---------		
		 
if($_GET['mode']=='topoffer_status' && $_GET['act']=='manage_properties' && $_GET['request_page']=='properties_management'){
		$id=base64_decode($_GET['id']);
         
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		 $update_qry = " UPDATE ".$tblprefix."properties SET
		                                                  topoffr_flag = '".$newstatus."'
														  WHERE id          = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);				
		if($rs_newsletter){
			$update_qry = " UPDATE ".$tblprefix."top_offer_program SET
		                                                  offer_status = '".$newstatus."'
														  WHERE proprty_id = '".$id."' "; 
														  
		$rs_newsletter = $db->Execute($update_qry);				
		
		}
		//$okmsg = base64_encode("Status UPDATED successfully!");
		$okmsg = base64_encode("Status uspješno ažurirani!");
		header("Location: admin.php?okmsg=$okmsg&act=manage_properties");
		exit;	  
 }	
 	
if($_GET['mode']=='goldoffer_status' && $_GET['act']=='manage_properties' && $_GET['request_page']=='properties_management'){

		$id=base64_decode($_GET['id']);
         
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		 $update_qry = " UPDATE ".$tblprefix."properties SET
		                                                  goldoffr_flag = '".$newstatus."'
														  WHERE id          = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);
		/*if($rs_newsletter){
			$update_qry = " UPDATE ".$tblprefix."top_offer_program SET
		                                                  offer_status = '".$newstatus."'
														  WHERE proprty_id = '".$id."' "; 
														  
		$rs_newsletter = $db->Execute($update_qry);				
		
		}				*/

		//$okmsg = base64_encode("Status UPDATED successfully!");
		$okmsg = base64_encode("Status je uspješno ažurirana!");
		header("Location: admin.php?okmsg=$okmsg&act=manage_properties");
		exit;	  
 }		
?>
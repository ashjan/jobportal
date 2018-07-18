<?php
    ###################### 
    #
    # 	POST SECTION
    #
    ######################
    //---------Edit Category---------
	if($_POST['mode']=='edit' && $_POST['act']=='omba_payment' && $_POST['request_page']=='omba_payment'){
		
 	 $server_name                   = $_POST['server_name'];
	 $server_path                   = $_POST['server_path']; 
	 $user_agent                    = $_POST['user_agent'];
	 $sender                        = $_POST['sender'];
	 $transaction_response          = $_POST['transaction_response'];  
	 $channel                       = $_POST['channel']; 
	 $transaction_mode              = $_POST['transaction_mode']; 
	 $user_password                 = $_POST['user_password'];
	 $user_id                       = $_POST['user_id']; 
	 $identification_transactionid  = $_POST['identification_transactionid']; 
	 $account_bank                  = $_POST['account_bank'];
	 $account_authorization         = $_POST['account_authorization'];
	 $payment_code                  = $_POST['payment_code']; 
	 $contact_ip                    = $_POST['contact_ip'];
	 $name_company                  = $_POST['name_company']; 
	 $response_url                  = $_POST['response_url'];
 
 
 
 if($server_name == ''){
	$errmsg = base64_encode('Server Name is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($server_path  == ''){
	$errmsg = base64_encode('Server Path is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($user_agent == ''){
	$errmsg = base64_encode('User Agent is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($sender == ''){
	$errmsg = base64_encode('Sender is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }


 if($transaction_response == ''){
	$errmsg = base64_encode('Transaction Response is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }
 
 if($channel == ''){
	$errmsg = base64_encode('Channel ID is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }
 
 if($transaction_mode == ''){
	$errmsg = base64_encode('Transaction Mode is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($identification_transactionid == ''){
	$errmsg = base64_encode('Identification Transaction ID is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

	
 
 if($payment_code == ''){
	$errmsg = base64_encode('Payment Code is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($contact_ip == ''){
	$errmsg = base64_encode('Contact IP is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }
 
 if($account_authorization == ''){
	$errmsg = base64_encode('Account Authorization Code is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($name_company == ''){
	$errmsg = base64_encode('Company Name is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }

 if($response_url == ''){
	$errmsg = base64_encode('Response URL is Missing');
	header("Location: admin.php?act=omba_payment&errmsg=$errmsg");
	exit;
 }
 
 
  $_SESSION['server_name']                  = $server_name;
  $_SESSION['server_path']                  = $server_path; 
  $_SESSION['user_agent']                   = $user_agent ;
  $_SESSION['sender']                       = $sender ;
  $_SESSION['transaction_response']         = $transaction_response; 
  $_SESSION['channel']                      = $channel; 
  $_SESSION['transaction_mode']             = $transaction_mode;
  $_SESSION['user_password']                = $user_password; 
  $_SESSION['user_id']                      = $user_id ; 
  $_SESSION['identification_transactionid'] = $identification_transactionid; 
  $_SESSION['account_bank']                 = $account_bank ;
  $_SESSION['account_authorization']        = $account_authorization;
  $_SESSION['payment_code']                 = $payment_code; 
  $_SESSION['contact_ip']                   = $contact_ip;
  $_SESSION['name_company']                 = $name_company; 
  $_SESSION['response_url']                 = $response_url ;

  
  
  $sql_update   = "UPDATE ".$tblprefix."omba_gateway 
                   SET
										server_name                  = '".$server_name."',
										server_path                  = '".$server_path."',
										user_agent                   = '".$user_agent."',
										sender                       = '".$sender."',
										transaction_response         = '".$transaction_response."',
										transaction_mode             = '".$transaction_mode."',
										user_password                = '".$user_password."',
										user_id                      = '".$user_id."',
										identification_transactionid = '".$identification_transactionid."',
										account_bank                 = '".$account_bank."',
										account_authorization        = '".$account_authorization."',
										channel                      = '".$channel."',
										payment_code                 = '".$payment_code."',
										contact_ip                   = '".$contact_ip."',
										name_company                 = '".$name_company."',
										response_url                 = '".$response_url."'
					WHERE
										id                           = 1";
	
	$run_query  = $db->Execute($sql_update);
	if($run_query){
		                                $okmsg = base64_encode("Payment Gateway Details Updated Succesfuly!");
										header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
										exit;
				  }else{
									  //$okmsg = base64_encode("Unable to Update Property in database.!");
										$okmsg = base64_encode("Unable to Update Payment Gateway Details!");
										header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
										exit;
	              }
   
	/*
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
											$okmsg = base64_encode("Nije moguce ucitati sliku, pokušajte ponovo!");
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
											$okmsg = base64_encode("Nije moguce ažurirati nekretnina u bazi podataka.!");
											header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
											exit;
										}
						}
						
		
	*/
	}

?>
<?php	
//  A D D     F U N C T I O N  
if($_POST['mode']=='add' && $_POST['act']=='manage_language' && $_POST['request_page']=='language'){
$post=$_POST;
$error='';
if($post['lan_name']==''){
	//$error="Language Name required<br>";
	$error="Potrebno je unijeti ime jezika<br>";
}
if($post['lan_code']==''){
	//$error.="Language code is required<br>";
	$error.="Potrebno je unijeti šifru jezika<br>";
}
if($post['lan_code']!='' and strlen($post['lan_code'])>3){
	//$error.="Language code must  be three characters<br>";
	$error.="Šifra za jezik mora sadržati 3 slova<br>";
}
if(empty($_FILES['image']['name']))
{
	$error.="Image Field is Required"; 
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			//$errmsg = base64_encode("image must be image format.!");
			$errmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/flags_uploads/".$imagename;
				$target_path = "graphics/flags_uploads/";
				$info = getimagesize($_FILES['image']['tmp_name']);

				if($info[0] > 100 and $info[1] > 50) {
						//$errmsg = base64_encode("image must be less then '100 X 50'");
						$errmsg = base64_encode("iVeličina slike mora biti manja od 100x50'");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
						exit;				
				}else{
						if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
						$update_img_query = "INSERT ".$tblprefix."language SET
														Lan_name = '".$post['lan_name']."',
														Lan_code = '".strtoupper($post['lan_code'])."',
														flag_name= '".$imagename."',
														flag_full_path= '".$filename."',
														Lan_default ='".$post['default_lang']."'
														";
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								//$okmsg = base64_encode("Language inserted successfully.!");
								$okmsg = base64_encode("Jezik uspješno dodat.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$errmsg = base64_encode("Unable to add Language in database.!");
								$errmsg = base64_encode("Nije moguće dodati jezik.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							//$errmsg = base64_encode("Unable to upload  image.!");
							$errmsg = base64_encode("Nije moguće dodati sliku.!");
							header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
							exit;
						}		
			}
		}

	}
} 

//  U P D A T E         F U N C T I O N  

if($_POST['mode']=='update' && $_POST['act']=='manage_language' && $_POST['request_page']=='language'){
$post=$_POST;
$error='';
if($post['lan_name']==''){
	//$error="Language Name required<br>";
	$error="Potrebno je unijeti ime jezika<br>";
}
if($post['lan_code']==''){
	//$error.="Language code is required<br>";
	$error.="Potrebno je unijeti šifru jezika<br>";
}
if($post['lan_code']!='' and strlen($post['lan_code'])>3){
	//$error.="Language code must  be three characters<br>";
	$error.="Šifra za jezik mora sadržati 3 slova<br>";
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
if(!empty($_FILES['image']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			//$errmsg = base64_encode("image must be image format.!");
			$errmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/flags_uploads/".$imagename;
				$target_path = "graphics/flags_uploads/";
				$info = getimagesize($_FILES['image']['tmp_name']);

				if($info[0] > 200 and $info[1] > 200) {
						//$errmsg = base64_encode("image must be less then '200 X 200'");
						$errmsg = base64_encode("Veličina slike mora biti manja od 200x200");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
						exit;				
				}else{
						if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
						
                        // BEFORE UPDATING WE NEED TO DEACTIVATE ALL THE CURRENT LANGUAGES
						$update_lang_query = "UPDATE ".$tblprefix."language SET
														Lan_default =0";
						$run_lang_query = $db->Execute($update_lang_query);
						
						$update_img_query = "UPDATE ".$tblprefix."language SET
														Lan_name = '".$post['lan_name']."',
														Lan_code = '".strtoupper($post['lan_code'])."',
														flag_name= '".$imagename."',
														flag_full_path= '".$filename."',
														Lan_default ='".$post['default_lang']."'
														WHERE id=".$_POST['id']
														;
						$run_query = $db->Execute($update_img_query);
							
							if($run_lang_query){
								//$okmsg = base64_encode("Language Updated successfully.!");
								$okmsg = base64_encode("Jezik uspješno dodat.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								//$errmsg = base64_encode("Unable to Update in database.!");
								$errmsg = base64_encode("Nije moguće ažurirati.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}
						}else{
							//$errmsg = base64_encode("Unable to upload  image.!");
							$errmsg = base64_encode("Nije moguće dodati sliku.!");
							header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
							exit;
						}		
			}
		}
}
else{
						
						// BEFORE UPDATING WE NEED TO DEACTIVATE ALL THE CURRENT LANGUAGES
						$update_lang_query = "UPDATE ".$tblprefix."language SET
														Lan_default =0";
						$run_lang_query = $db->Execute($update_lang_query);
						
						$update_img_query = "UPDATE ".$tblprefix."language SET
														Lan_name = '".$post['lan_name']."',
														Lan_code = '".strtoupper($post['lan_code'])."',
														Lan_default ='".$post['default_lang']."'
														WHERE id=".$_POST['id'];
						
						
						
						
						
						
						
						$run_query = $db->Execute($update_img_query);
							if($run_query){
								//$okmsg = base64_encode("Language Updated successfully.!");
								$okmsg = base64_encode("Jezik uspješno dodat.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								//$errmsg = base64_encode("Unable to Update in database.!");
								$errmsg = base64_encode("Nije moguće ažurirati  .!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}							
}
	}
} 

//  C H A N G E     S T A T U S       F U N C T I O N  
	//---------Change  Default Language Status---------
	if($_GET['mode']=='change_default' && $_GET['act']=='manage_language' && $_GET['request_page']=='language'){
	
	// First disable the default language status of all the languages  
	 
	$id=base64_decode($_GET['id']);
	  
	$qry_language= "UPDATE ".$tblprefix."language  
					SET 
					".$tblprefix."language.Lan_default=0";
		
    $rs_language=$db->Execute($qry_language);
	$total_language =  $rs_language->RecordCount();
	
	// Now activate the status of the currently selected default language 			
	$sql_language= "UPDATE ".$tblprefix."language 
														SET 
														".$tblprefix."language.Lan_default=1 
														WHERE  
													    ".$tblprefix."language.id=".$id;
				$rs_language = $db->Execute($sql_language);
				if($rs_language){
					//$okmsg = base64_encode("Language Updated successfully. !");
					$okmsg = base64_encode("Jezik uspješno dodat. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_language");
					exit;	  
				}
	}// END if($_POST['mode']=='change_default' && $_POST['act']=='manage_language' 


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_language' && $_GET['request_page']=='language'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT flag_name FROM ".$tblprefix."language WHERE id =".$id;
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['flag_name'];
		
		$del_qry = " DELETE FROM ".$tblprefix."language WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/flags_uploads/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		//$okmsg = base64_encode("Language Deleted successfully. !");
		$okmsg = base64_encode("Jezik uspješno izbrisan. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		//$errmsg = base64_encode("Unable to Delete .!");
		$errmsg = base64_encode("Nije moguće izbrisati.!");
					header("Location: admin.php?errmsg=$errmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	
	?>
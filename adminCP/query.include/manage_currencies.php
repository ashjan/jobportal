<?php	
// ADD
if($_POST['mode']=='add' && $_POST['act']=='manage_currencies' && $_POST['request_page']=='manage_currencies'){
$post=$_POST;
$error='';
 $countryname=$post['countryname'];

$qry_currencies_data = "SELECT * FROM ".$tblprefix."currencies_data WHERE id=".$countryname; 
$rs_currencies_data = $db->Execute($qry_currencies_data);

  $country = $rs_currencies_data->fields['countryname'];  

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
				
			 	$qry_already_event= "SELECT ".$tblprefix."currencies.id 
				FROM
				".$tblprefix."currencies WHERE id='".$countryname."' ";    
		 	
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				//$errmsg = base64_encode('This Currency Type already exist.');
				$errmsg = base64_encode('Currency already exist');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}	
					
					 	$update_cur_query = "INSERT ".$tblprefix."currencies SET
														id = ".$countryname.",
														countryname = '".$rs_currencies_data->fields['countryname']."',
														curr_name = '".$rs_currencies_data->fields['curr_name']."',
														curr_isocode= '".$rs_currencies_data->fields['curr_isocode']."',
														currency_status = 0
														";  
							$run_query = $db->Execute($update_cur_query);
							if($run_query){
								//$okmsg = base64_encode("Currency inserted successfully.!");
								$okmsg = base64_encode("Currency added successfully");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$errmsg = base64_encode("Unable to add Currency in database.!");
								$errmsg = base64_encode("Operation failed please try again");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
							}
						
		}

	}
 
if($_POST['mode']=='update' && $_POST['act']=='manage_currencies' && $_POST['request_page']=='manage_currencies'){
$post=$_POST;
$error='';
if($post['countryname']==''){
	//$error="Currency Name required<br>";
	$error="Potrebno je unijeti naziv valute<br>";
}
if($post['curr_name']==''){
	//$error.="Currency code is required<br>";
	$error.="Potrebno je unijeti šifru valute<br>";
}
if(strlen($post['curr_isocode'])>3){
	//$error.="Currency code must  be three characters<br>";
	$error.="Šifra valute treba sadržati 3 slova<br>";
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
		
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/flags_uploads/".$imagename;
				$target_path = "graphics/flags_uploads/";
				$info = getimagesize($_FILES['image']['tmp_name']);

				if($info[0] > 110 and $info[1] > 60) {
						//$errmsg = base64_encode("image must be less then '100 X 50'");
						$errmsg = base64_encode("Veličina slike mora biti manja od 100x50");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
						exit;				
				}else{
						if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path.$imagename)){
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
						$update_img_query = "UPDATE ".$tblprefix."language SET
														Lan_name = '".$post['lan_name']."',
														Lan_code = '".strtoupper($post['lan_code'])."',
														flag_name= '".$imagename."',
														flag_full_path= '".$filename."',
														Lan_default ='".$post['default_lang']."'
														WHERE id=".$_POST['id']
														;
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								//$okmsg = base64_encode("Language Updated successfully.!");
								$okmsg = base64_encode("Jezik uspješno dodat.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								//$errmsg = base64_encode("Unable to Update in database.!");
								$errmsg = base64_encode("Nije moguće ažurirati .!");
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
		
{
						$update_query = "UPDATE ".$tblprefix."currencies SET
														countryname = '".$post['countryname']."',
														curr_name = '".strtoupper($post['curr_name'])."',
														curr_isocode ='".$post['curr_isocode']."'
														WHERE id=".$_POST['id'];
							$run_query = $db->Execute($update_query);
							if($run_query){
								//$okmsg = base64_encode("Currency updated successfully.!");
								$okmsg = base64_encode("Valuta uspješno dodata.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								//$errmsg = base64_encode("Unable to update in database.!");
								$errmsg = base64_encode("Nije moguće dodati valutu .!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}							

	}
} 


}	   

	//---------Change  Default Language Status---------
	if($_GET['mode']=='change_default' && $_GET['act']=='manage_currencies' && $_GET['request_page']=='manage_currencies'){
	
	// First disable the default language status of all the languages  

	$id=base64_decode($_GET['id']);
	  
	$qry_currencies= "UPDATE ".$tblprefix."currencies  
					SET 
					".$tblprefix."currencies.currency_status=0";
		
    $rs_currencies=$db->Execute($qry_currencies);
	$total_currencies =  $rs_currencies->RecordCount();
	
	// Now activate the status of the currently selected default language 			
	$sql_currencies= "UPDATE ".$tblprefix."currencies 
														SET 
														".$tblprefix."currencies.currency_status=1 
														WHERE  
													    ".$tblprefix."currencies.id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				if($rs_currencies){
					//$okmsg = base64_encode("Currency updated successfully. !");
					$okmsg = base64_encode("Valuta uspješno dodata. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_currencies&pageNum=".$_GET['pageNum']);
					exit;	  
				}
	}// END if($_POST['mode']=='change_default' && $_POST['act']=='manage_language' 

// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_currencies' && $_GET['request_page']=='manage_currencies'){
	$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."currencies WHERE id =".$id; 
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
		//$okmsg = base64_encode("Currency deleted successfully. !");
		$okmsg = base64_encode("Currency deleted successfully !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}else{
		//$errmsg = base64_encode("Cijena nije izbrisana .!");
		$errmsg = base64_encode("Nije moguće izbrisati .!");
					header("Currency: admin.php?errmsg=$errmsg&act=".$_GET['act']);
					exit;			
		}
} 	
?>
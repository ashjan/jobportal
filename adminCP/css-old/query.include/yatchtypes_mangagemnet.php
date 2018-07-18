<?php	
if($_POST['mode']=='add' && $_POST['act']=='yatchtypes' && $_POST['request_page']=='yatchtypes_mangagemnet'){

$post=$_POST;
$error='';
$yatch_name = addslashes(trim($post['yatch_name']));
$number_yachts = trim($post['number_yachts']);
$destination = trim($post['destination']);
$yatch_picture=$_FILES['yatch_picture']['name'];

if($yatch_name==''){
	$error="Specify Yacht Model!!<br>";
	}
	
if($number_yachts=='' or !is_numeric($number_yachts)){
	$error="Specify Number Yacht with Numeric values !!<br>";
	}	
	

 $slug=slugcreation($yatch_name); 

 
if($post['first_name']=='' or $post['first_name']==0){
	$error.="PM Name is required<br>";
	}

 
if($post['agency_id'] =='' or $post['agency_id']==0){
	$error.="Agency name is required";
	}
if($destination==''){
$error="Specify Destination!!<br>";
}



if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit;
			}
			
//Get the uploaded file

if($_FILES['yatch_picture']['name']==NULL){
		$errmsg = base64_encode('Yacht Picture is Required!!');
		header("Location: admin.php?act=yatchtypes&errmsg=$errmsg");
		exit;
	}else{
	
	$image_name_rand = generateRandomString(10);
	$type = explode(".", $_FILES['yatch_picture']['name']);
	
	if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG" && $type[1]!="JPEG"){
	
	$okmsg = base64_encode("Invalid Image Format!!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit();
	
	}else{
	
		$imagename = $image_name_rand.".".$type[1];
		$filename = MYSURL."graphics/agency_logos/".$imagename;
		$target_path = "graphics/agency_logos/";
		$info = getimagesize($_FILES['yatch_picture']['tmp_name']);
		
		if(move_uploaded_file($_FILES['yatch_picture']['tmp_name'], $target_path.$imagename)){
	
	
	
	
			
								$update_img_query = "INSERT ".$tblprefix."yatchtypes SET
								yatch_agency ='".$post['agency_id']."',
								destination ='".$destination."',
								yatch_picture ='".$imagename."',
								number_yachts ='".$number_yachts."',
								pm_id ='".$post['first_name']."',
								yatch_name = '".$yatch_name."',
								built_year= '".$post['built_year']."',
								yatch_length = '".$post['yatch_length']."',
								yatch_cat = '".$post['yatcat']."',
								yatch_type_slug= '".$slug."',
								yatch_beam = '".$post['yatch_beam']."',
								yatch_draft = '".$post['yatch_draft']."',
								yatch_engine = '".$post['yatch_engine']."',
								yatch_fuel_tank = '".$post['yatch_fuel_tank']."',
								water_tank = '".$post['water_tank']."',
								cabins = '".$post['cabins']."',
								yathch_berths = '".$post['yathch_berths']."',
								yatch_seats = '".$post['yatch_seats']."',
								yatch_additional_berth = '".$post['yatch_additional_berth']."',
								yatch_wc = '".$post['yatch_wc']."',
								yatch_other = '".$post['yatch_other']."',
								yatch_showers = '".$post['yatch_showers']."',
								yatch_navigation_electronic = '".$post['yatch_navigation_electronic']."',
								sailanddeck = '".$post['sailanddeck']."',
								yatch_comfort = '".$post['yatch_comfort']."'";  
								
								$run_query = $db->Execute($update_img_query);
								if($run_query)
								{
									$okmsg = base64_encode("Yatch inserted successfully.!");
									header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
									exit;
								}else{
									$okmsg = base64_encode("Unable to add Yatch in database.!");
									header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
									exit;
								}
								}else{
									$okmsg = base64_encode("Unable to upload  Picture!!");
									header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
									exit;
								}
								
								}
								}
					
							
			}



//Update Section

if($_POST['mode']=='update' && $_POST['act']=='edityatchtypes' && $_POST['request_page']=='yatchtypes_mangagemnet'){
$post=$_POST;
$error='';
$_SESSION[yatch_name]=$post['yatch_name'];

$_SESSION[number_yachts]=$post['number_yachts'];

$_SESSION[price_period]=$post['price_period'];
$_SESSION[per_person]=$post['per_person'];
$_SESSION[property_cat]=$post['property_cat'];
$_SESSION[id]=$post['id'];
$yatch_name = addslashes(trim($post['yatch_name']));

$destination = trim($post['destination']);
$yatch_picture=$_FILES['yatch_picture']['name'];

if($post['yatch_name']==''){
	$error="Yacht Name required!!<br>";
}
if($post['number_yachts']=='' or !is_numeric($post['number_yachts'])){
	$error="Nuber yatch required with Numeric values!!<br>";
}

$slug=slugcreation($yatch_name);

if($post['first_name']==0){
	
	$error.="PM Name is required<br>";
}

if($post['agency_id']==0){
	
	$error.="Agency name is required";
}

if($destination==''){
$error="Specify Destination!!<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".$_POST['id']);
			exit;
}

//Get the uploaded file

if($_FILES['yatch_picture']['name']==NULL){
		$errmsg = base64_encode('Yacht Picture is Required!!');
		header("Location: admin.php?act=yatchtypes&errmsg=$errmsg");
		exit;
	}else{
	$image_name_rand = generateRandomString(10);
	$type = explode(".", $_FILES['yatch_picture']['name']);
	
	if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG" && $type[1]!="JPEG"){
$okmsg = base64_encode("Invalid Image Format!!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit();
	
	}else{
		$imagename = $image_name_rand.".".$type[1];
		$filename = MYSURL."graphics/agency_logos/".$imagename;
		$target_path = "graphics/agency_logos/";
		$info = getimagesize($_FILES['yatch_picture']['tmp_name']);
		
		if(move_uploaded_file($_FILES['yatch_picture']['tmp_name'], $target_path.$imagename)){



					 		$update_img_query = "UPDATE ".$tblprefix."yatchtypes SET
							yatch_agency ='".$post['agency_id']."',
							destination ='".$destination."',
							yatch_picture ='".$imagename."',
							pm_id ='".$post['first_name']."',
							yatch_name = '".$yatch_name."',
							number_yachts ='".$post['number_yachts']."',
							built_year= '".$post['built_year']."',
							yatch_length = '".$post['yatch_length']."',
							yatch_type_slug= '".$slug."',
							yatch_beam = '".$post['yatch_beam']."',
							yatch_draft = '".$post['yatch_draft']."',
							yatch_engine = '".$post['yatch_engine']."',
							yatch_fuel_tank = '".$post['yatch_fuel_tank']."',
							water_tank = '".$post['water_tank']."',
							cabins = '".$post['cabins']."',
							yathch_berths = '".$post['yathch_berths']."',
							yatch_seats = '".$post['yatch_seats']."',
							yatch_additional_berth = '".$post['yatch_additional_berth']."',
							yatch_wc = '".$post['yatch_wc']."',
							yatch_other = '".$post['yatch_other']."',
							yatch_showers = '".$post['yatch_showers']."',
							yatch_navigation_electronic = '".$post['yatch_navigation_electronic']."',
							sailanddeck = '".$post['sailanddeck']."',
							yatch_comfort = '".$post['yatch_comfort']."',
							yatch_cat = ".$post['yatcat']."
							WHERE id=".base64_decode($_POST['id'])
							;  
							$run_query = $db->Execute($update_img_query);
							if($run_query)
							{
								$okmsg = base64_encode("Yatch Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".$_POST['id']);
								exit;
							}
							else
							{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".$_POST['id']);
								exit;
							}
							}else{
									$okmsg = base64_encode("Unable to upload  Picture!!");
									header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
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

if($_GET['mode']=='delete' && $_GET['act']=='yatchtypes' && $_GET['request_page']=='yatchtypes_mangagemnet'){
		$id=base64_decode($_GET['id']); 
		$del_qry = " DELETE FROM ".$tblprefix."yatchtypes WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){			
		$okmsg = base64_encode("Yatch Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}else{
		$okmsg = base64_encode("Unable to Delete .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;
		}
  
} 	
	?>
<?php

//add car

if($_POST['mode']=='add' && $_POST['act']=='footer_banner' && $_POST['request_page']=='mng_footer_banner'){

		
		$first_name = addslashes(trim($_POST['first_name']));
		$property_name = addslashes(trim($_POST['property_name']));
		$price = addslashes(trim($_POST['price']));
		$image_title = addslashes(trim($_POST['image_title']));
		$image_status = addslashes(trim($_POST['image_status']));
		$image_ordering = addslashes(trim($_POST['image_ordering']));
		$slug=slugcreation($image_title);
		
		if($first_name == '' or $first_name== '0'){
			$errmsg = base64_encode('Please Selcet Property Manager');
			//$errmsg = base64_encode('Molimo Izaberite vlasnika objekta');
			header("Location: admin.php?act=footer_banner&errmsg=$errmsg");
			exit;
		}
		
		

		if($property_name == '' or $property_name== '0'){
			$errmsg = base64_encode('Please Select Property Name');
			//$errmsg = base64_encode('Molimo izaberite vlasnika objekta');
			header("Location: admin.php?act=footer_banner&errmsg=$errmsg");
			exit;
		}
		
		

		if($image_title == '' or $image_title== '0'){
			$errmsg = base64_encode('Please Enter Footer image Title');
			//$errmsg = base64_encode('Molimo unesite naziv slike');
			header("Location: admin.php?act=footer_banner&errmsg=$errmsg");
			exit;
		}
		
		
	 		$qry_already_event= "SELECT ".$tblprefix."footer_banner.id 
			FROM
			".$tblprefix."footer_banner where slug='".$slug."' ";  
		 	$rs_already_event=$db->Execute($qry_already_event);
			$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
			$errmsg = base64_encode('This Footer image already exist.');
			//$errmsg = base64_encode('Ova slika već postoji.');
			header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
			exit;
				}
	
		
		if($_FILES['image_name']['name']==NULL){
			$msg=base64_encode('Footer image File is Required');
			//$msg=base64_encode('Naziv slike je obavezan');
			header("Location: admin.php?okmsg=$msg&act=footer_banner&errmsg=$errmsg");
		
	     }// end if(empty($_FILES['car_picture']['name']))
/*if($error!=''){
			
}*/else{
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image_name']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$errmsg = base64_encode("image must be in image format.!");
			//$errmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."media/slider/footer_images/".$imagename;
				$target_path = "media/slider/footer_images/";
				$info = getimagesize($_FILES['image_name']['tmp_name']);

				/*if($info[0] > 100 and $info[1] > 50) {
						$okmsg = base64_encode("image must be less then '100 X 50'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;				
				}else{*/
						if(move_uploaded_file($_FILES['image_name']['tmp_name'], $target_path.$imagename)){
						
						
					 	$update_img_query = "INSERT ".$tblprefix."footer_banner SET
														
														pm_id = '".$first_name."',
														property_id = '".$property_name."',
														image_title = '".$image_title."',
														price = '".$price."',
														image_name = '".$imagename."',
														image_status  = ".$image_status.",
														image_ordering  = ".$image_ordering.",
														slug  = '".$slug."'
														";  
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Footer image inserted successfully.!");
								//$okmsg = base64_encode("Slika uspješno dodata.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$errmsg = base64_encode("Unable to add Footer image in database.!");
								//$errmsg = base64_encode("Nije moguće dodati sliku.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							$errmsg = base64_encode("Unable to upload  Footer image.!");
								//$errmsg = base64_encode("Nije moguće dadti footer sliku.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
						}
						
	  
		}

	}
		
	
		
}

//---------Update Car---------
	   
###############################################################################	 
	 
	 	
	 if($_POST['mode']=='update' && $_POST['act']=='edit_footer_banner' && $_POST['request_page']=='mng_footer_banner'){
$post=$_POST;
$error='';
$id=base64_decode($_POST['id']);

		
		
		$first_name = addslashes(trim($_POST['first_name']));
		$property_name = addslashes(trim($_POST['property_name']));
		$price = addslashes(trim($_POST['price']));
		$image_title = addslashes(trim($_POST['image_title']));
		$image_status = addslashes(trim($_POST['image_status']));
		$image_ordering = addslashes(trim($_POST['image_ordering']));
		$slug=slugcreation($image_title);

		
			if($first_name == '' or $first_name== '0'){
			$errmsg = base64_encode('Please Selcet Property Manager');
			//$errmsg = base64_encode('Molimo Izaberite vlasnika objekta');
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit;
		}
		
		

		if($property_name == '' or $property_name== '0'){
			$errmsg = base64_encode('Please Select Property Name');
			//$errmsg = base64_encode('Molimo izaberite vlasnika objekta');
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit;
		}
		

		
		
		if($image_title == '' or $image_title== '0'){
			$errmsg = base64_encode('Please Enter Footer image Title');
			//$errmsg = base64_encode('Molimo unesite naziv slike');
		header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit;
		}

if(!empty($_FILES['image_name']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['image_name']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$errmsg = base64_encode("image must be in image format.!");
			//$errmsg = base64_encode("Slika mora biti u odgovarajućem formatu.!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."media/slider/footer_images/".$imagename;
				$target_path = "media/slider/footer_images/";
				$info = getimagesize($_FILES['car_picture']['tmp_name']);

				/*if($info[0] > 200 and $info[1] > 200) {
						$okmsg = base64_encode("image must be less then '200 X 200'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
						exit;				
				}else{*/
						if(move_uploaded_file($_FILES['image_name']['tmp_name'], $target_path.$imagename)){
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
							
							
							// $_SESSION['image']= $imagename;
							
		 		  	$update_img_query = "UPDATE ".$tblprefix."footer_banner SET
														
														pm_id = '".$first_name."',
														property_id = '".$property_name."',
														image_title = '".$image_title."',
														price = '".$price."',
														image_name = '".$imagename."',
														image_status  = ".$image_status.",
														image_ordering  = ".$image_ordering.",
														slug  = '".$slug."'
														WHERE id=".base64_decode($_POST['id']);  
														 
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("footer Image Updated successfully.!");
								//$okmsg = base64_encode("Slika Nije moguće dodati sliku dodata.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($id));
								exit;
							}else{
							
								$errmsg = base64_encode("Unable to Update in database.!");
								//$errmsg = base64_encode("Nije moguće uspješno  sliku.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}
						}else{
							
							
							$errmsg = base64_encode("Unable to upload  Footer image.!");
							//$errmsg = base64_encode("Nije moguće dadti footer sliku.!");
							header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
							exit;
						}		
			//}
		}
}else{
		  	$update_img_query = "UPDATE ".$tblprefix."footer_banner SET
			
														pm_id = '".$first_name."',
														property_id = '".$property_name."',
														image_title = '".$image_title."',
														price = '".$price."',
														image_status  = ".$image_status.",
														image_ordering  = ".$image_ordering.",
														slug  = '".$slug."'
														WHERE id=".base64_decode($_POST['id'])
														; 
														 
														 
														 
			$run_query = $db->Execute($update_img_query);
			if($run_query){
			$okmsg = base64_encode("Footer image Updated successfully.!");
			//$okmsg = base64_encode("Slika uspješno dodata.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($id));
			exit;
			}else{			
								$errmsg = base64_encode("Unable to Update Footer image in database.!");
								//$errmsg = base64_encode("Nije moguće uspješno  sliku.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
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

if($_GET['mode']=='delete' && $_GET['act']=='footer_banner' && $_GET['request_page']=='mng_footer_banner'){
	$id=base64_decode($_GET['id']);
	
	$sel_qry = "SELECT image_title FROM ".$tblprefix."footer_banner WHERE id =".$id;
	
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['image_title'];
		
		$del_qry = " DELETE FROM ".$tblprefix."footer_banner WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/car_upload/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		$okmsg = base64_encode("Footer image Deleted successfully.!");
		//$okmsg = base64_encode("Slika uspješno izbrisana.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$errmsg = base64_encode("Unable to Delete Footer image.!"); 
		//$errmsg = base64_encode("Nije moguće uspješno footer sliku.!");
					header("Location: admin.php?errmsg=$errmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	


//---------UPDATE STAUS PROPERTY MANAGER ---------


if($_GET['mode']=='change_pmstatus' && $_GET['act']=='footer_banner' && $_GET['request_page']=='mng_footer_banner'){
		$id=base64_decode($_GET['id']);
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		$update_qry = " UPDATE ".$tblprefix."footer_banner SET
		                                                  image_status = '".$newstatus."'
														  WHERE id  = '".$id."' ";
		$rs_pmqry = $db->Execute($update_qry);			
		
			
		$okmsg = base64_encode("footer Image status Updated successfully!");
		//$okmsg = base64_encode("Slika uspješno status dodata!");
					header("Location: admin.php?okmsg=$okmsg&act=footer_banner");
					exit;	  
} 


//----------  Change Ordering Code     
if($_POST['mode']=='order_menu' && $_POST['act']=='footer_banner' && $_POST['request_page']=='mng_footer_banner'){
	
	$image_ordering=$_POST['menu_order'];
	foreach($image_ordering as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
   	$sql_change_order= "UPDATE ".$tblprefix."footer_banner  
													SET 
													image_ordering=".$val." 
													WHERE  
													id=".$id; 
	$rs_change_order = $db->Execute($sql_change_order);
	}
	$okmsg = base64_encode(" Ordering Set Successfully. !");
	//$okmsg = base64_encode(" Redosljed uspješno postavljen. !");
					header("Location: admin.php?okmsg=$okmsg&act=footer_banner");
					exit;	
}
?>
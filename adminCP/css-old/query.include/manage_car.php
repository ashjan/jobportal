<?php

//add car

if($_POST['mode']=='add' && $_POST['act']=='car' && $_POST['request_page']=='manage_car'){

		$pm_id = addslashes(trim($_POST['pm_id']));
		$agency = addslashes(trim($_POST['agency']));
		$car_type = addslashes(trim($_POST['car_type']));
		$category = addslashes(trim($_POST['category']));
		$remarks = addslashes(trim($_POST['remarks']));
		$price = addslashes(trim($_POST['car_price']));
		$supplier_id = addslashes(trim($_POST['supplier_id']));
		$produced = addslashes(trim($_POST['produced']));
		$doors = addslashes(trim($_POST['doors']));
		$passengers = addslashes(trim($_POST['passengers']));
		$num_of_car = addslashes(trim($_POST['num_of_car']));
		$min_day_for_rent = addslashes(trim($_POST['min_day_for_rent']));
		/* END: if($rs) */
		$slug=slugcreation($car_type);
		
		
		if($pm_id == '' or $pm_id== '0'){
			$errmsg = base64_encode('Please Select PM');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		if($agency=='' or $agency== '0' ){
			$errmsg = base64_encode('Please Select Agency');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		
		if($supplier_id=='' or $supplier_id== '0'){
			$errmsg = base64_encode('Car Supplier Name is Not Selected<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		if($car_type == ''){
			$errmsg = base64_encode('Car  Type required<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		if($category=='' or $category== '0'){
			$errmsg = base64_encode('Car  Category is Not Selected<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		
		if($doors==''){
			$errmsg = base64_encode('doors  field is required<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		
		if($passengers==''){
			$errmsg = base64_encode('passengers field is required<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		if($num_of_car==''){
			$errmsg = base64_encode('Number Of Cars field is required<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		if($min_day_for_rent==''){
			$errmsg = base64_encode('Minimum Number Of Days for Rent field is required<br>');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
	
		
		if($produced == '' || $produced == 0){
			$errmsg = base64_encode('Please Select Car Produced Year');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}
		
		if($category == ''){
			$errmsg = base64_encode('Please Enter Car category');
			header("Location: admin.php?act=car&errmsg=$errmsg");
			exit;
		}		
	
		
	 	$qry_already_event= "SELECT ".$tblprefix."car.supplier_id 
				FROM
				".$tblprefix."car where supplier_id='".$supplier_id."' AND agency='".$agency."' AND car_slug='".$slug."' ";  
		 	
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				$errmsg = base64_encode('This Car Type already exist.');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}
	
		
		if($_FILES['car_picture']['name']==NULL){
		$msg=base64_encode('Image Field is Required');
			header("Location: admin.php?okmsg=$msg&act=car&errmsg=$errmsg");
		
	     }// end if(empty($_FILES['car_picture']['name']))
/*if($error!=''){
			
}*/else{
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['car_picture']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/car_upload/".$imagename;
				$target_path = "graphics/car_upload/";
				$info = getimagesize($_FILES['car_picture']['tmp_name']);

				/*if($info[0] > 100 and $info[1] > 50) {
						$okmsg = base64_encode("image must be less then '100 X 50'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;				
				}else{*/
						if(move_uploaded_file($_FILES['car_picture']['tmp_name'], $target_path.$imagename)){
						
						
				 	  	$update_img_query = "INSERT ".$tblprefix."car SET
						
														pm_id = ".$pm_id.",
														agency = ".$agency.",
														supplier_id  = ".$supplier_id.",
														car_type  = '".$car_type."',
														category  = ".$category.",
														car_slug  = '".$slug."',
						 								produced = '".$produced."',
														doors  = '".$doors."',
														passengers  = '".$passengers."',
						 								num_of_car   = '".$num_of_car."',
														min_day_for_rent   = '".$min_day_for_rent."',
														car_picture= '".$imagename."'";    
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Car inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Car in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							$okmsg = base64_encode("Unable to upload  image.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
							exit;
						}
						
	  
		}

	}
		
	
		
}

//---------Update Car---------
	   
###############################################################################	 
	 
	 	
	 if($_POST['mode']=='update' && $_POST['act']=='edit_car' && $_POST['request_page']=='manage_car'){
$post=$_POST;
$error='';
$id=base64_decode($_POST['id']);

		$_SESSION['car_session']= $_POST;
		
		$pm_id = addslashes(trim($_POST['pm_id'])); 
		$agency = addslashes(trim($_POST['agency']));
		$car_type = addslashes(trim($_POST['car_type'])); 
		$category = addslashes(trim($_POST['category']));
		$remarks = addslashes(trim($_POST['remarks']));
		$price = addslashes(trim($_POST['car_price']));
		$produced = addslashes(trim($_POST['produced']));
		$doors = addslashes(trim($_POST['doors']));
		$passengers = addslashes(trim($_POST['passengers']));
		$num_of_car = addslashes(trim($_POST['num_of_car']));
		$min_day_for_rent = addslashes(trim($_POST['min_day_for_rent']));
		$supplier_id = addslashes(trim($_POST['supplier_id'])); 
		$slug=slugcreation($car_type);
		




if($pm_id=='' or $pm_id== '0' ){
	$error="PM Name is Not Selected<br>";
}

if($agency=='' or $agency== '0' ){
	$error="Car Agency Name is Not Selected<br>";
}

if($supplier_id=='' or $supplier_id== '0'){
	$error="Car Supplier Name is Not Selected<br>";
}
		
if($produced == '' || $produced == 0){
	$error="Car date on which produced is required<br>";
}

if($doors==''){
	$error="doors  field is required<br>";
}

if($passengers==''){
	$error="passengers field is required<br>";
}
if($num_of_car==''){
	$error="Number Of Cars field is required<br>";
}

if($min_day_for_rent==''){
	$error="Minimum Number Of Days for Rent field is required<br>";
}

if($car_type == ''){
	$error="Car  Type required<br>";
}

if($category=='' or $category== '0'){
	$error="Category  Type required<br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit();
}else{
if(!empty($_FILES['car_picture']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['car_picture']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/car_upload/".$imagename;
				$target_path = "graphics/car_upload/";
				$info = getimagesize($_FILES['car_picture']['tmp_name']);

				/*if($info[0] > 200 and $info[1] > 200) {
						$okmsg = base64_encode("image must be less then '200 X 200'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
						exit;				
				}else{*/
						if(move_uploaded_file($_FILES['car_picture']['tmp_name'], $target_path.$imagename)){
						if($_POST['old_image']!=""){
								if(file_exists($target_path.$_POST['old_image'])){
									unlink($target_path.$_POST['old_image']);
								}
							}
							
							
							// $_SESSION['image']= $imagename;
							
					 	$update_img_query = "UPDATE ".$tblprefix."car SET
														
														pm_id = ".$pm_id.",
														agency  = ".$agency.",
														supplier_id  = ".$supplier_id.",
														car_type  = '".$car_type."',
														category  = ".$category.",
														car_slug  = '".$slug."',
														produced = '".$produced."',
														doors  = ".$doors.",
														passengers  = ".$passengers.",
						 								num_of_car   = ".$num_of_car.",
														min_day_for_rent   = ".$min_day_for_rent.",
														car_picture = '".$imagename."'
														WHERE id=".base64_decode($_POST['id']); 
														
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Car Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($id));
								exit;
							}else{
							
								$errmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}
						}else{
							
							
							$okmsg = base64_encode("Unable to upload  Car Picture.!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
							exit;
						}		
			//}
		}
}
else{
		 	$update_img_query = "UPDATE ".$tblprefix."car SET
			
														pm_id = ".$pm_id.",
														agency  = ".$post['agency'].",
														supplier_id  = ".$supplier_id.",
														car_type  = '".$post['car_type']."',
														category  = ".$category.",
														car_slug  = '".$slug."',
						 								produced = '".$produced."',
														doors  = ".$doors.",
														passengers  = ".$passengers.",
						 								num_of_car   = ".$num_of_car.",
														min_day_for_rent   = ".$min_day_for_rent."
														WHERE id=".base64_decode($_POST['id'])
														; 
														 
 

			$run_query = $db->Execute($update_img_query);
			if($run_query){
			$okmsg = base64_encode("Car Updated successfully.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($id));
			exit;
			}else{			
								$okmsg = base64_encode("Unable to Update in database.!");
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

if($_GET['mode']=='delete' && $_GET['act']=='car' && $_GET['request_page']=='manage_car'){
	$id=base64_decode($_GET['id']);
	
	$sel_qry = "SELECT car_type FROM ".$tblprefix."car WHERE id =".$id; 
	
		$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['car_type'];
		
		$del_qry = " DELETE FROM ".$tblprefix."car WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/car_upload/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		$okmsg = base64_encode("Car Deleted successfully.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	

	
	   
?>
<?php
if($_POST['mode']=='add' && $_POST['act']=='agency' && $_POST['request_page']=='manage_agency'){



		$agency_name = addslashes(trim($_POST['agency_name']));
		$terms = addslashes(trim($_POST['terms']));
		
		
		/* END: if($rs) */

		
		if($agency_name == ''){
	
			$errmsg = base64_encode('Please Enter Agency Name!!');
			header("Location: admin.php?act=agency&errmsg=$errmsg");
			exit;
		}
		
		if($_POST['city'] == 0){
	
			$errmsg = base64_encode('Please select City!!');
			header("Location: admin.php?act=agency&errmsg=$errmsg");
			exit;
		}
		
		if($_POST['location'] == 0){
	
			$errmsg = base64_encode('Please select Location!!');
			header("Location: admin.php?act=agency&errmsg=$errmsg");
			exit;
		}
		
		
		if($terms == ''){
		$errmsg = base64_encode('Please Enter Terms and Condition!!');
		header("Location: admin.php?act=car&errmsg=$errmsg");
		exit;
		}		
		
		
		
		if($_FILES['car_picture']['name']==NULL){
		$msg=base64_encode('Agency logo is Required!!');
			header("Location: admin.php?okmsg=$msg&act=agency&errmsg=$errmsg");
		
	     }// end if(empty($_FILES['car_picture']['name']))
/*if($error!=''){
			
}*/else{
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['car_picture']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("Invalid Image Format!!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/agency_logos/".$imagename;
				$target_path = "graphics/agency_logos/";
				$info = getimagesize($_FILES['car_picture']['tmp_name']);
				
				

				/*if($info[0] > 100 and $info[1] > 50) {
						$okmsg = base64_encode("image must be less then '100 X 50'");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit;				
				}else{*/
						if(move_uploaded_file($_FILES['car_picture']['tmp_name'], $target_path.$imagename)){
						
						
						
						
						$update_img_query = "INSERT ".$tblprefix."agency SET
														agn_name = '".$agency_name."',
														country  = '".$_POST['country']."',
						 								city   = '".$_POST['city']."',
														location   = '".$_POST['location']."',
														agncy_terms   = '".$terms."',
														agncy_logo= '".$imagename."'";
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Agency inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Agency in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
						}else{
							$okmsg = base64_encode("Unable to upload  Logo!!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
							exit;
						}
						
						
						
						
								
			//}
		}

	}
		
	
		
}

//---------Update Car---------
	   
###############################################################################	 
	 
	 	
	 if($_POST['mode']=='update' && $_POST['act']=='agency' && $_POST['request_page']=='manage_agency'){
$post=$_POST;
$error='';

		$car_name = addslashes(trim($_POST['agency_name']));
		$remarks = addslashes(trim($_POST['terms']));

if($post['agency_name']==''){
	$error="Agency  Name required!!<br>";
}



if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
if(!empty($_FILES['car_picture']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['car_picture']['name']);
		if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG"){
			$okmsg = base64_encode("image must be image format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
				$imagename = $image_name_rand.".".$type[1];
				$filename = MYSURL."graphics/agency_logos/".$imagename;
				$target_path = "graphics/agency_logos/";
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
							
						
							
						$update_img_query = "UPDATE ".$tblprefix."agency SET
														agn_name = '".$post['agency_name']."',
														country  = '".$post['country']."',
														city   = '".$post['city']."',
														location   = '".$post['location']."',
														agncy_terms   = '".$post['terms']."',
														agncy_logo = '".$imagename."'
														WHERE agn_id=".base64_decode($_POST['id'])
														;
							 																																	
							
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Agency Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
							
								$errmsg = base64_encode("Unable to Update Agency in database.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}
						}else{
							
							
							$okmsg = base64_encode("Unable to upload  Agency logo!!");
							header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
							exit;
						}		
			//}
		}
}
else{
			$update_img_query = "UPDATE ".$tblprefix."agency SET
														agn_name = '".$post['agency_name']."',
														country  = '".$post['country']."',
														city   = '".$post['city']."',
														location   = '".$post['location']."',
														agncy_terms   = '".$post['terms']."' 
														WHERE agn_id=".base64_decode($_POST['id'])
														;
													


			$run_query = $db->Execute($update_img_query);
			if($run_query){
			$okmsg = base64_encode("Agency Updated successfully.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit;
			}else{			
								$okmsg = base64_encode("Unable to Update Agency in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
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

if($_GET['mode']=='delete' && $_GET['act']=='agency' && $_GET['request_page']=='manage_agency'){
	$id=base64_decode($_GET['id']);
	
	$sel_qry = "SELECT agncy_logo FROM ".$tblprefix."agency WHERE agn_id =".$id;
	$rs_select = $db->Execute($sel_qry);
		
		$image_name=$rs_select->fields['agncy_logo'];
		
		$del_qry = " DELETE FROM ".$tblprefix."agency WHERE agn_id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$target_path = "graphics/agency_logos/";
				if(file_exists($target_path.$image_name)){
						unlink($target_path.$image_name);
				}
		$okmsg = base64_encode("Agency Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
		else{
		$okmsg = base64_encode("Cijena nije izbrisana !!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 	

	
	   
?>
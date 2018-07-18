<?php
if($_POST['mode']=='add' && $_POST['act']=='caragency' && $_POST['request_page']=='manangecaragency'){



	$agency_name = addslashes(trim($_POST['agency_name']));
	$terms = addslashes(trim($_POST['trmcond']));
	$descagn = addslashes(trim($_POST['descagn']));



	/* END: if($rs) */

	if($_POST['first_name'] == '0'){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	
	if($agency_name == ''){

		$errmsg = base64_encode('Please Enter Agency Name!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}


	/*if(!isset($termms)){
				$errmsg = base64_encode('You must Agree to the Terms and Condition of Property!!');
				header("Location: admin.php?act=caragency&errmsg=$errmsg");
				exit;
		}
*/



	
	if($_POST['address'] == ''){

		$errmsg = base64_encode('Please Enter Address!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}

	if($_POST['postcode'] == '' OR !is_numeric($_POST['postcode'])){

		$errmsg = base64_encode('Please Enter post code!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['country'] == ''){

		$errmsg = base64_encode('Please Enter country!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['city'] == '' ){

		$errmsg = base64_encode('Please Enter city!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	

	if($_POST['phonefax'] == '' or  !is_numeric($_POST['phonefax'])){

		$errmsg = base64_encode('Please Enter phone/fax!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['mobile'] == '' or !is_numeric($_POST['mobile'])){

		$errmsg = base64_encode('Please Enter Mobile number!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['email'] == '' or !is_email($_POST['email'])){

		$errmsg = base64_encode('Please Enter Email!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['latitude'] == '' ){

		$errmsg = base64_encode('Please Enter Latitude!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['longitude'] == ''){

		$errmsg = base64_encode('Please Enter Longitude!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['bankaccount'] == ''){

		$errmsg = base64_encode('Please Enter Local Bank account!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}
	if($_POST['yatchnumbr'] == '' or !is_numeric($_POST['yatchnumbr'])){

		$errmsg = base64_encode('Please Enter Number of Car(s)!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}


	/*if($_POST['city'] == 0){

	$errmsg = base64_encode('Please select City!!');
	header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
	exit;
	}

	if($_POST['location'] == 0){

	$errmsg = base64_encode('Please select Location!!');
	header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
	exit;
	}*/


	if($terms == ''){
		$errmsg = base64_encode('Please Enter Terms and Condition!!');
		header("Location: admin.php?act=caragency&errmsg=$errmsg");
		exit;
	}



	if($_FILES['car_picture']['name']==NULL){
		$msg=base64_encode('Agency logo is Required!!');
		header("Location: admin.php?okmsg=$msg&act=caragency&errmsg=$errmsg");

	}// end if(empty($_FILES['car_picture']['name']))
	/*if($error!=''){

	}*/else{
	$image_name_rand = generateRandomString(10);
	$type = explode(".", $_FILES['car_picture']['name']);
	
	if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG" && $type[1]!="JPEG"){
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

				
				
				$qry_already_event= "SELECT ".$tblprefix."agency.agn_id 
				FROM
				".$tblprefix."agency where agn_name='".$agency_name."' ";  
			
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				$errmsg = base64_encode('This Agency Type already exist.');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}
				
				$slug=slugcreation($agency_name); 
			
				
	 			$update_img_query = "INSERT ".$tblprefix."agency SET
														agn_name = '".$agency_name."',
														slug = '".$slug."',
														pm_id = '".$_POST['first_name']."',													
														agncy_type= '".$_POST['agntype']."',
														address = '".$_POST['address']."',
														post_code = '".$_POST['postcode']."',
														phone = '".$_POST['phonefax']."',
														mobile_number = '".$_POST['mobile']."',
														email = '".$_POST['email']."',
														latitude = '".$_POST['latitude']."',
														longitude = '".$_POST['longitude']."',
														number_of_cars = '".$_POST['yatchnumbr']."',
														contact_language = '".$_POST['cntactlang']."',
														local_bank_account = '".$_POST['bankaccount']."',
														country = '".$_POST['country']."',
														city = '".$_POST['city']."',
														agncy_description = '".$descagn."',
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


if($_POST['mode']=='update' && $_POST['act']=='editcaragency' && $_POST['request_page']=='manangecaragency'){
	$post=$_POST;
	$error='';

	$car_name = addslashes(trim($_POST['agency_name']));
	$terms = $_POST['trmcond'];
	$$descagn = $_POST['$descagn'];

	if($post['agency_name']==''){
		$errmsg=base64_encode("Agency  Name required!!<br>");
	}

   
	if($_POST['first_name'] == '0'){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['address'] == ''){

		$errmsg = base64_encode('Please Enter Address!!');
		header("Location:admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}

	if($_POST['postcode'] == '' OR !is_numeric($_POST['postcode'])){

		$errmsg = base64_encode('Please Enter post code!!');
		header("Location:admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['country'] == ''){

		$errmsg = base64_encode('Please Enter country!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['city'] == '' ){

		$errmsg = base64_encode('Please Enter city!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	

	if($_POST['phonefax'] == '' or  !is_numeric($_POST['phonefax'])){

		$errmsg = base64_encode('Please Enter phone/fax!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['mobile'] == '' or !is_numeric($_POST['mobile'])){

		$errmsg = base64_encode('Please Enter Mobile number!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['email'] == '' or !is_email($_POST['email'])){

		$errmsg = base64_encode('Please Enter Email!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['latitude'] == '' ){

		$errmsg = base64_encode('Please Enter Latitude!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['longitude'] == ''){

		$errmsg = base64_encode('Please Enter Longitude!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['bankaccount'] == ''){

		$errmsg = base64_encode('Please Enter Local Bank account!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	if($_POST['yatchnumbr'] == '' or !is_numeric($_POST['yatchnumbr'])){

		$errmsg = base64_encode('Please Enter Number of Car(s)!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}

if($terms==''){
		$errmsg = base64_encode('Please Enter Terms and Conditions!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
}
	if($errmsg!=''){
		
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
	}else{
		if(!empty($_FILES['car_picture']['name'])){
			$image_name_rand = generateRandomString(10);
			$type = explode(".", $_FILES['car_picture']['name']);
			if($type[1]!="jpg" && $type[1]!="jpeg" && $type[1]!="gif" && $type[1]!="png" && $type[1]!="PNG" && $type[1]!="JPEG"){
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
														pm_id = '".$post['first_name']."',
														agn_name = '".$post['agency_name']."',
														agncy_type= '".$post['agntype']."',
														country  = '".$post['country']."',
														city   = '".$post['city']."',
														post_code   = '".$post['postcode']."',
														address   = '".$post['address']."',
														phone   = '".$post['phonefax']."',
														mobile_number   = '".$post['mobile']."',
														email   = '".$post['email']."',
														latitude   = '".$post['latitude']."',
														longitude   = '".$post['longitude']."',
														number_of_cars   = '".$post['yatchnumbr']."',
														contact_language   = '".$post['cntactlang']."',
														local_bank_account   = '".$post['bankaccount']."',
														agncy_terms   = '".$terms."',
														agncy_description = '".$$descagn."',
														agncy_logo = '".$imagename."'
														WHERE agn_id=".base64_decode($_POST['id'])
					;
                     

					$run_query = $db->Execute($update_img_query);
					if($run_query){
						$okmsg = base64_encode("Agency Updated successfully.!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($_POST['id']));
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
														pm_id = '".$post['first_name']."',
														agn_name = '".$post['agency_name']."',
														agncy_type= '".$post['agntype']."',
														country  = '".$post['country']."',
														city   = '".$post['city']."',
														post_code   = '".$post['postcode']."',
														address   = '".$post['address']."',
														phone   = '".$post['phonefax']."',
														mobile_number   = '".$post['mobile']."',
														email   = '".$post['email']."',
														latitude   = '".$post['latitude']."',
														longitude   = '".$post['longitude']."',
														number_of_cars   = '".$post['yatchnumbr']."',
														contact_language   = '".$post['cntactlang']."',
														local_bank_account   = '".$post['bankaccount']."',
														agncy_terms   = '".$terms."',
														agncy_description = '".$_POST['descagn']."'
														WHERE agn_id=".base64_decode($_POST['id'])
			;

         

			$run_query = $db->Execute($update_img_query);
			if($run_query){
				$okmsg = base64_encode("Agency Updated successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".base64_encode($_POST['id']));
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

if($_GET['mode']=='delete' && $_GET['act']=='caragency' && $_GET['request_page']=='manangecaragency'){
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
		$okmsg = base64_encode("Unable to Delete !!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;

	}

}



?>
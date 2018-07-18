<?php
if($_POST['mode']=='add' && $_POST['act']=='yatchagency' && $_POST['request_page']=='manangeyatchagency'){


	
	$_SESSION["agency"] = $_POST;
	// posting all the values start 
	$first_name = addslashes(trim($_POST['first_name']));
	$agency_name = addslashes(trim($_POST['agency_name']));
	$country = addslashes(trim($_POST['country']));
	$city = addslashes(trim($_POST['city']));
	$address = addslashes(trim($_POST['address']));
	$postcode = trim($_POST['postcode']);
	$phonefax = addslashes(trim($_POST['phonefax']));
	$mobile = addslashes(trim($_POST['mobile']));
	$email = addslashes(trim($_POST['email']));
	$latitude = addslashes(trim($_POST['latitude']));
	$longitude = addslashes(trim($_POST['longitude']));
	$yatchnumbr = addslashes(trim($_POST['yatchnumbr']));
	$cntactlang = addslashes(trim($_POST['cntactlang']));
	$bankaccount = trim($_POST['bankaccount']);
	$terms = addslashes(trim($_POST['terms']));
	$agntype = $_POST['agntype'];// radio button
	$descagn = addslashes(trim($_POST['descagn']));
	$termms = $_POST['trmcond1'];
	// posting all the values ends 
	
	//putting posted values into session.S T A R T      F R O M       H E R E
	$_SESSION['first_name']=$first_name;
	$_SESSION['agency_name']=$agency_name;
	$_SESSION['country']=$country;
	$_SESSION['city']=$city;
	$_SESSION['address']=$address;
	$_SESSION['postcode']=$postcode;
	$_SESSION['phonefax']=$phonefax;
	$_SESSION['mobile']=$mobile;
	$_SESSION['email']=$email;
	$_SESSION['latitude']=$latitude;
	$_SESSION['longitude']=$longitude;
	$_SESSION['yatchnumbr']=$yatchnumbr;
	$_SESSION['cntactlang']=$cntactlang;
	$_SESSION['bankaccount']=$bankaccount;
	$_SESSION['terms']=$terms;
	$_SESSION['agntype']=$agntype;
	$_SESSION['descagn']=$descagn;
	//putting posted values into session.E N D S       H E R E
	/* END: if($rs) */

	if($first_name == '0'){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	
	if($agency_name == ''){

		$errmsg = base64_encode('Please Enter Agency Name!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}

	if($address == ''){

		$errmsg = base64_encode('Please Enter Address!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}

	if($postcode == '' OR !is_numeric($postcode)){

		$errmsg = base64_encode('Please Enter post code!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($country == ''){

		$errmsg = base64_encode('Please Enter country!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	
	if($cntactlang == ''){

		$errmsg = base64_encode('Please Enter Contact Language!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	

	if($phonefax == '' or  !is_numeric($phonefax)){

		$errmsg = base64_encode('Please Enter phone/fax!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($mobile == '' or !is_numeric($mobile)){

		$errmsg = base64_encode('Please Enter Mobile number!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($email == '' or !is_email($email)){

		$errmsg = base64_encode('Please Enter Valid Email!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($latitude == '' ){

		$errmsg = base64_encode('Please Enter Latitude!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($longitude == ''){

		$errmsg = base64_encode('Please Enter Longitude!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($bankaccount == ''){

		$errmsg = base64_encode('Please Enter Local Bank account!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	if($yatchnumbr == '' or !is_numeric($yatchnumbr)){

		$errmsg = base64_encode('Please Enter Number of Yatch(s)!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}
	
	if(!isset($termms)){
				$errmsg = base64_encode('You must Agree to the Terms and Condition of yacht!!');
				header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
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
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
	}



	if($_FILES['car_picture']['name']==NULL){
		$errmsg = base64_encode('Agency logo is Required!!');
		header("Location: admin.php?act=yatchagency&errmsg=$errmsg");
		exit;
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


			

			$update_img_query = "INSERT ".$tblprefix."yatchagency SET
														agn_name = '".$agency_name."',
														pm_id = '".$_POST['first_name']."',
														address = '".$_POST['address']."',
														post_code = '".$_POST['postcode']."',
														phone = '".$_POST['phonefax']."',
														mobile_number = '".$_POST['mobile']."',
														email = '".$_POST['email']."',
														latitude = '".$_POST['latitude']."',
														longitude = '".$_POST['longitude']."',
														number_of_yatch = '".$_POST['yatchnumbr']."',
														contact_language = '".$_POST['cntactlang']."',
														local_bank_account = '".$_POST['bankaccount']."',
														country = '".$_POST['country']."',
														city = '".$_POST['city']."',
														agncy_type= '".$_POST['agntype']."',
														agncy_description = '".$_POST['descagn']."',
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


if($_POST['mode']=='update' && $_POST['act']=='edityatchagency' && $_POST['request_page']=='manangeyatchagency'){
	$post=$_POST;
	$error='';
	$agntype = $_POST['agntype'];// radio button
	$car_name = addslashes(trim($_POST['agency_name']));
	$remarks = addslashes(trim($_POST['terms']));
	$terms = addslashes(trim($_POST['terms']));
	
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

		$errmsg = base64_encode('Please Enter Number of Yatch(s)!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}

	if($_POST['cntactlang'] == ''){

		$errmsg = base64_encode('Please Enter Contact Languages!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}

	if($_POST['descagn'] == ''){

		$errmsg = base64_encode('Please Enter Description!!');
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".($_POST['id']));
		exit;
	}
	
if($terms == ''){
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



					$update_img_query = "UPDATE ".$tblprefix."yatchagency SET 
														pm_id = '".$post['first_name']."',
														agn_name = '".$post['agency_name']."',
														country  = '".$post['country']."',
														city   = '".$post['city']."',
														agncy_type= '".$post['agntype']."',
														post_code   = '".$post['postcode']."',
														address   = '".$post['address']."',
														phone   = '".$post['phonefax']."',
														mobile_number   = '".$post['mobile']."',
														email   = '".$post['email']."',
														latitude   = '".$post['latitude']."',
														longitude   = '".$post['longitude']."',
														number_of_yatch   = '".$post['yatchnumbr']."',
														contact_language   = '".$post['cntactlang']."',
														local_bank_account   = '".$post['bankaccount']."',
														agncy_terms   = '".$terms."',
														agncy_description = '".$_POST['descagn']."',
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
		 		$update_img_query = "UPDATE ".$tblprefix."yatchagency SET
														agn_name = '".$post['agency_name']."',
														country  = '".$post['country']."',
														city   = '".$post['city']."',
														agncy_type= '".$post['agntype']."',
														post_code   = '".$post['postcode']."',
														address   = '".$post['address']."',
														phone   = '".$post['phonefax']."',
														mobile_number   = '".$post['mobile']."',
														email   = '".$post['email']."',
														latitude   = '".$post['latitude']."',
														longitude   = '".$post['longitude']."',
														number_of_yatch   = '".$post['yatchnumbr']."',
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

if($_GET['mode']=='delete' && $_GET['act']=='yatchagency' && $_GET['request_page']=='manangeyatchagency'){
	$id=base64_decode($_GET['id']);

	$sel_qry = "SELECT agncy_logo FROM ".$tblprefix."yatchagency WHERE agn_id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$image_name=$rs_select->fields['agncy_logo'];

	$del_qry = " DELETE FROM ".$tblprefix."yatchagency WHERE agn_id =".$id;
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

//---------U P D A T E     S T A T U S      O F     T H E      Y A C H T  A G E N C Y---------
if($_GET['mode']=='change_yachtstatus' && $_GET['act']=='yatchagency' && $_GET['request_page']=='manangeyatchagency'){
		$id=base64_decode($_GET['id']);
         
		 $status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		  $update_qry = " UPDATE ".$tblprefix."yatchagency SET
		                                                  agncy_type = '".$newstatus."'
														  WHERE agn_id = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);				

		$okmsg = base64_encode("Yacht  Status UPDATED successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=yatchagency");
					exit;	  
 }
		
//---------Service Provider Status---------	


?>
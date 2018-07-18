<?php	
if($_POST['mode']=='add' && $_POST['act']=='vat_and_tax_charges_management1' && $_POST['request_page']=='manage_vat_and_tax_charges1'){
	
	$post=$_POST;
	$error='';
	
	$property_id = addslashes(trim($_POST['property_id']));
	$first_name = addslashes(trim($_POST['first_name']));

	if($post['vat_type_percent']==''){
		//$error="Vat Type Percent required<br>";
		$error="PDV Vrsta Postotak potrebna<br>";
	}
	if($post['vat_status']==''){
		//$error="Please  select vat status!<br>";
		$error="Molimo odaberite status PDV-a!<br>";
	}


	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$post['act']);

	}else{	
	if($post['vat_type_percent']== 1 && $post['vat_amount'] > 100){
		//$errmsg = base64_encode("Percentage amount should be less or equal to 100!<br>");
		$errmsg = base64_encode("Postotak iznos trebao biti manji ili jednak 100!<br>");
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
		exit;
	}

	$check_duplicate ="SELECT id FROM ".$tblprefix."vat_tax_charges WHERE property_id=".$property_id." AND pm_id=".$first_name;

	$rs_duplicate = $db->Execute($check_duplicate);
	$total_duplicate = $rs_duplicate->RecordCount();
	if($total_duplicate == 0){
		$update_img_query = "INSERT ".$tblprefix."vat_tax_charges
									                                SET
																	property_id = ".$property_id.",
																	pm_id = ".$first_name.",
																	vat_type_percent = '".$post['vat_type_percent']."',
																	vat_status= '".$post['vat_status']."',
																	vat_amount = '".$post['vat_amount']."',
																	city_tax_type = '".$post['city_tax_type']."',
																	city_tax_status = '".$post['city_tax_status']."',
																	service_status = '".$post['service_status']."',
																	city_tax_amount =  '".$post['city_tax_amount']."',
																	service_charges_type = '".$post['service_charges_type']."',
																	service_charge_amount = '".$post['service_charge_amount']."'";

		$run_query = $db->Execute($update_img_query);
		if($run_query){
			//$okmsg = base64_encode("Vat and Tax inserted successfully.!");
			$okmsg = base64_encode("PDV-a i poreza uspješno umetnute.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
		}else{
			//$errmsg = base64_encode("Unable to add Vat and Tax in database.!");
			$errmsg = base64_encode("Nije moguće dodati PDV i porez u bazi podataka.!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;
		}

	}else {
		//$errmsg = base64_encode("Sorry! you have already entered Vat and Tax for this property");
		$errmsg = base64_encode("Žao mi je! ste već ušli PDV-a i poreza na dobit za ove nekretnine");
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
		exit;
	}
	}
}

//Update Section

if($_POST['mode']=='update' && $_POST['act']=='vat_and_tax_charges_management1' && $_POST['request_page']=='manage_vat_and_tax_charges1'){
	$post=$_POST;
	$error='';
	if($post['vat_status']==''){
		//$error="Vat status required<br>";
		$error="PDV status zahtijeva<br>";
	}
	if($post['vat_amount']==''){
		//$error="Vat amount required<br>";
		$error="Iznos PDV-a zahtijeva<br>";
	}
	if($post['city_tax_type']==''){
		//$error="City Tax Type required<br>";
		$error="Grad poreza Tip zahtijeva<br>";
	}

	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$post['act']);
	}else{
		if($post['vat_type_percent']== 1 && $post['vat_amount'] >100){
			//$errmsg = base64_encode("Percentage amount should be less or equal to 100!<br>");
			$errmsg = base64_encode("Postotak iznos trebao biti manji ili jednak 100!<br>");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;
		}
		if(isset($_POST['property_name'])){
			$property_id = $_POST['property_name'];
		}else {
			$property_id = $_POST['property_id'];
		}
		$first_name = $_POST['first_name'];
		$id = base64_decode($_POST['id']);
		$check_duplicate ="SELECT id FROM ".$tblprefix."vat_tax_charges WHERE property_id=".$property_id." AND pm_id=".$first_name." AND id!=".$id;

		$rs_duplicate = $db->Execute($check_duplicate);
		$total_duplicate = $rs_duplicate->RecordCount();

		if($total_duplicate>0){
			//$errmsg = base64_encode("Sorry! you have already entered Vat and Tax for this property");
			$errmsg = base64_encode("Žao mi je! ste već ušli PDV-a i poreza na dobit za ove nekretnine");
			header("Location: admin.php?errmsg=$errmsg&act=edit_vat_and_tax_charges&id=".base64_encode($_POST['id']));
			exit;

		}else {

			$update_img_query = "UPDATE ".$tblprefix."vat_tax_charges
													  SET														                                                        property_id = ".$property_id.",
													  pm_id = ".$post['first_name'].",
													  vat_type_percent = '".$post['vat_type_percent']."',
													  vat_status= '".$post['vat_status']."',
													  vat_amount = '".$post['vat_amount']."',
													  city_tax_type = '".$post['city_tax_type']."',
													  city_tax_status = '".$post['city_tax_status']."',
													  service_status = '".$post['service_status']."',
													  city_tax_amount =  '".$post['city_tax_amount']."',
													  service_charges_type = '".$post['service_charges_type']."',
													  service_charge_amount = '".$post['service_charge_amount']."'
													  WHERE id=".base64_decode($_POST['id'])
			;


			$run_query = $db->Execute($update_img_query);

			if($run_query){
				//$okmsg = base64_encode("Vat and Tax Updated successfully!");
				$okmsg = base64_encode("PDV-a i poreza Updated uspješno!");
				header("Location: admin.php?okmsg=$okmsg&act=vat_and_tax_charges_management&id=".base64_encode($_POST['id']));
				exit;
			}else{
				//$okmsg = base64_encode("Unable to Update in database!");
				$okmsg = base64_encode("Nije moguće ažurirati");
				header("Location: admin.php?errmsg=$okmsg&act=edit_vat_and_tax_charges&id=".base64_encode($_POST['id']));
				exit;
			}

			$update_img_query = "UPDATE ".$tblprefix."vat_tax_charges SET
														vat_amount = '".$post['vat_amount']."'
														WHERE id=".$_POST['id']
			;
			$run_query = $db->Execute($update_img_query);
			if($run_query){
				//$okmsg = base64_encode("Vat Charges Updated successfully!");
				$okmsg = base64_encode("Iznosa PDV-a Updated uspješno!");	
				header("Location: admin.php?okmsg=$okmsg&act=vat_and_tax_charges_management&id=".base64_encode($_POST['id']));		
				exit;
			}else{
				//$okmsg = base64_encode("Unable to Update in database!");
				$okmsg = base64_encode("Nemoguće učitati u bazu podataka!");
				header("Location: admin.php?errmsg=$okmsg&act=edit_vat_and_tax_charges&id=".base64_encode($_POST['id']));
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

if($_GET['mode']=='delete' && $_GET['act']=='vat_and_tax_charges_management1' && $_GET['request_page']=='manage_vat_and_tax_charges1'){
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT vat_amount FROM ".$tblprefix."vat_tax_charges WHERE id =".$id;

	$rs_select = $db->Execute($sel_qry);
	$del_qry = " DELETE FROM ".$tblprefix."vat_tax_charges WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);

	//$okmsg = base64_encode("Vat Tax Charges Deleted successfully!");
	$okmsg = base64_encode("Naknade PDV-a je uspješno izbrisana!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
	exit;
}
else{
	//$okmsg = base64_encode("Unable to Delete!");
	$okmsg = base64_encode("Nije moguće izbrisati!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
	exit;

}
	?>
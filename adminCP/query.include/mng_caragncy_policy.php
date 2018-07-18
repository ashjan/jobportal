<?php
if($_POST['mode']=='add' && $_POST['act']=='mng_caragncy_policy' && $_POST['request_page']=='mng_caragncy_policy'){

	$_SESSION['add_sees'] = $_POST;
	
	$agency_name = addslashes(trim($_POST['agency_id']));
	$dcharges = addslashes(trim($_POST['charge_flag'])); 
	$post = $_POST;

	/* END: if($rs) */

	if($_POST['first_name'] == '' || $_POST['first_name'] == '0'){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));
		exit;
	}
	
	if($agency_name == '0'){

		$errmsg = base64_encode('Please Select Agency Name!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));
		exit;
	}


	if($_POST['cancldays'] == '0'){

		$errmsg = base64_encode('Please Enter Cancellation days!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));
		exit;
	}
	if($_POST['cancellation_charges_percent'] == ''){

		$errmsg = base64_encode('Please Enter Cancellation charges!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));
		exit;
	}
	
	
	if($_POST['no_show_policy'] == ''){

		$errmsg = base64_encode('Please Select No ShowPolicy!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));
		exit;
	}
	
	
	if($_POST['charge_flag'] == '1' and $_POST['dcharges'] == '' ){

		$errmsg = base64_encode('Please Enter Deposit Charges!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));
		exit;
	}
	

	if(count($_POST['optxtra']) > 1)
	{
		$optxtra = implode(",",$_POST['optxtra']);
	}
	elseif(count($_POST['optxtra']) == 1)
	{
		$optxtra = $_POST['optxtra'];
	}
	else
	{
		$optxtra = "";
	}

	
	
	// optxtra end
  
  
  
  
  // free included in price start
	
	if(count($_POST['inc_inprice']) > 1)
	{
		$inc_inprice = implode(",",$_POST['inc_inprice']);
	}
	elseif(count($_POST['inc_inprice']) == 1)
	{
		$inc_inprice = $_POST['inc_inprice'];
	}
	else
	{
		$inc_inprice = "";
	}

	
	// free included in price end 
  
  
  
	// free serviecs start
	
	if(count($_POST['freeser']) > 1)
	{
		$freeser = implode(",",$_POST['freeser']);
	}
	elseif(count($_POST['freeser']) == 1)
	{
		$freeser = $_POST['freeser'];
	}
	else
	{
		$freeser = "";
	}

	
	//2 free serviecs End
	
	


	//Credit card option start's here
	
	if(count($_POST['credit_card_accepted']) > 1)
	{
		$cardaccept = implode(",",$_POST['credit_card_accepted']);
	}
	elseif(count($_POST['credit_card_accepted']) == 1)
	{
		$cardaccept = $_POST['credit_card_accepted'];
	}
	else
	{
		$cardaccept = "";
	}

	

	//Credit card option end's here



// Removing comma from single value of "Included in Price"
	$conunt_inc_inprice = count($inc_inprice);
// $result == 3
	if($conunt_inc_inprice==1){
		
		$inc_inprice = implode(",", $inc_inprice);
	}
	
	
	// Removing comma from single value of "Optional Extra"
	$conunt_optxtra = count($optxtra);
// $result == 3
	if($conunt_optxtra==1){
		
		$optxtra = implode(",", $optxtra);
	}
	
	// Removing comma from single value of "Free Services"
	$conunt_freeser = count($freeser);
// $result == 3
	if($conunt_freeser==1){
		
		$freeser = implode(",", $freeser);
	}
	
	// Removing comma from single value of "Credit Card"
	$conunt_cardaccept = count($cardaccept);
// $result == 3
	if($conunt_cardaccept==1){
		
		$cardaccept = implode(",", $cardaccept);
	}
	
			$qry_already_event= "SELECT ".$tblprefix."caragncy_policy.pol_id 
				FROM
				".$tblprefix."caragncy_policy where agncy_id ='".$agency_name."'  ";  
			
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				$errmsg = base64_encode('This Agency Policy Already exist.');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}

			$update_img_query = "INSERT ".$tblprefix."caragncy_policy SET
														agncy_id = '".$agency_name."',
														pm_id = '".$_POST['first_name']."',													
														
														credit_card_accepted = '".$cardaccept."',
														depositcharge = '".$dcharges."',
														cancl_days = '".$_POST['cancldays']."',
														cancl_charges = '".$_POST['cancellation_charges_percent']."',
														noshow_pol = '".$_POST['no_show_policy']."',
														driver_age = '".$_POST['driverage']."',
														lst_extras = '".$optxtra."',
														inc_price = '".$inc_inprice."',
														free_services = '".$freeser."',
														imp_notice = '".addslashes($_POST['impnotice'])."'"; 
 
			$run_query = $db->Execute($update_img_query);
			
			//mysql_insert_id(connection);
			
			if($run_query)
			{
			
				$id= mysql_insert_id();
				foreach($_POST['freeser'] as $offer)
				{
					$update_ser = "INSERT ".$tblprefix."freeoffer_cagnpol SET
																car_agnpolicy_id = '".$id."',
																flag = '1',
																offer_id = '".$offer."'";
		
					$run_ser = $db->Execute($update_ser);
				}
				foreach($_POST['inc_inprice'] as $included)
				{
					$update_inc = "INSERT ".$tblprefix."included_cagnpol SET
																car_agnpolicy_id = '".$id."',
																flag = '1',
																included_id = '".$included."'";
		
					$run_inc = $db->Execute($update_inc);
				}
				foreach($_POST['notinc_inprice'] as $nincluded)
				{
					$update_ninc = "INSERT ".$tblprefix."nincluded_cagnpol SET
																car_agnpolicy_id = '".$id."',
																flag = '1',
																nincluded_id = '".$nincluded."'";
		
					$run_ninc = $db->Execute($update_ninc);
				}
				foreach($_POST['optxtra'] as $optxtra)
				{
					$update_opt = "INSERT ".$tblprefix."xtra_cagnpol SET
																car_agnpolicy_id = '".$id."',
																flag = '1',
																xtra_id = '".$optxtra."'";
		
					$run_opt = $db->Execute($update_opt);
				}
				unset($_SESSION['add_sees']);
				
				$okmsg = base64_encode("Agency Policy inserted successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
				exit;
			}else{
				$okmsg = base64_encode("Unable to add Agency Policy in database.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
				exit;
			}

  }


###############################################################################

//---------Update Car Agency Policy---------

###############################################################################

if($_POST['mode']=='edit' && $_POST['act']=='editcaragnpolicy' && $_POST['request_page']=='mng_caragncy_policy'){ 
	$id=base64_decode($_POST['id']);
 	$agency_name = addslashes(trim($_POST['agency_id']));  
	$dcharges = addslashes(trim($_POST['charge_flag']));

$_SESSION['add_sees'] = $_POST;
	/* END: if($rs) */

	if($_POST['first_name'] == '0' or $_POST['first_name'] =='' ){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		
		//header("Location: admin.php?act=mng_caragncy_policy&errmsg=$errmsg");
		exit;
	}
	
	if($agency_name == '0' or $agency_name ==''){

		$errmsg = base64_encode('Please Select Agency Name!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		exit;
	}


	if($_POST['cancldays'] == '0' or $_POST['cancldays'] ==''){

		$errmsg = base64_encode('Please Enter Cancellation days!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		exit;
	}
	if($_POST['cancellation_charges_percent'] == ''){

		$errmsg = base64_encode('Please Select Cancellation charges!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		exit;
	}
	
		if($_POST['no_show_policy'] == ''){

		$errmsg = base64_encode('Please Select No ShowPolicy!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		exit;
	}

	
	if($_POST['charge_flag'] == '1' and $_POST['dcharges'] == '' ){

		$errmsg = base64_encode('Please Enter Deposit Charges!!');
		header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		exit;
	}
	



	/*if($terms == ''){
		$errmsg = base64_encode('Please Enter Terms and Condition!!');
		header("Location: admin.php?act=mng_caragncy_policy&errmsg=$errmsg");
		exit;
	}


  else
  {*/
  
  
  // optxtra start
	
	if(count($_POST['optxtra']) > 1)
	{
		$optxtra = implode(",",$_POST['optxtra']);
	}
	elseif(count($_POST['optxtra']) == 1)
	{
		$optxtra = $_POST['optxtra'];
	}
	else
	{
		$optxtra = "";
	}

	
	
	// optxtra end
  
  
  // free included in price start
	
	if(count($_POST['inc_inprice']) > 1)
	{
		$inc_inprice = implode(",",$_POST['inc_inprice']);
	}
	elseif(count($_POST['inc_inprice']) == 1)
	{
		$inc_inprice = $_POST['inc_inprice'];
	}
	else
	{
		$inc_inprice = "";
	}

	
	// free included in price end 
  
  
  
	// free serviecs start
	
	if(count($_POST['freeser']) > 1)
	{
		$freeser = implode(",",$_POST['freeser']);
	}
	elseif(count($_POST['freeser']) == 1)
	{
		$freeser = $_POST['freeser'];
	}
	else
	{
		$freeser = "";
	}

	
	//2 free serviecs End

  
	

	if(count($_POST['credit_card_accepted']) > 1)
	{
		$cardaccept = implode(",",$_POST['credit_card_accepted']);
		$cardaccept = addslashes(trim($cardaccept));
	}
	elseif(count($_POST['credit_card_accepted']) == 1)
	{
		$cardaccept = $_POST['credit_card_accepted'];
	}
	else
	{
		$cardaccept = "";
	}

	// Removing comma from single value of "Included in Price"
	$conunt_inc_inprice = count($inc_inprice);
// $result == 3
	if($conunt_inc_inprice > 1){
		
		$inc_inprice = implode(",",$inc_inprice);
	}
	
	
	
	// Removing comma from single value of "Optional Extra"
	$conunt_optxtra = count($optxtra);
// $result == 3
	if($conunt_optxtra > 1){
		
		$optxtra = implode(",",$optxtra);
	}
	
	// Removing comma from single value of "Free Services"
	$conunt_freeser = count($freeser);
// $result == 3
	if($conunt_freeser > 1){
		
		$freeser = implode(",",$freeser);
	}
	
	
	
	// Removing comma from single value of "Credit Card"
	$conunt_cardaccept = count($cardaccept);
// $result == 3
	if($conunt_cardaccept > 1){
		
		$cardaccept = implode(",",$cardaccept);
	}
	

	 	$update_img_query = "UPDATE ".$tblprefix."caragncy_policy SET
														agncy_id = '".$agency_name."',
														pm_id = '".$_POST['first_name']."',													
														
														credit_card_accepted = '".$cardaccept."',
														depositcharge = '".$dcharges."',
														cancl_days = '".$_POST['cancldays']."',
														cancl_charges = '".$_POST['cancellation_charges_percent']."',
														noshow_pol = '".$_POST['no_show_policy']."',
														driver_age = '".$_POST['driverage']."',
														lst_extras = '".$optxtra."',
														inc_price = '".$inc_inprice."',
														free_services = '".$freeser."',
														imp_notice = '".addslashes($_POST['impnotice'])."'
														WHERE pol_id = '".$id."'";     

			$run_query = $db->Execute($update_img_query);
			
			//mysql_insert_id(connection);
			
			if($run_query)
			{
								
				$qry_free = "SELECT * FROM  ".$tblprefix."freeoffer_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
				$rs_free = $db->Execute($qry_free);
				$freeserarray = array();
				while(!$rs_free->EOF)
				{
					$freeserarray[] = $rs_free->fields['offer_id'];
					$rs_free->MoveNext();
				}
				
				
				
				$qry_inc = "SELECT * FROM  ".$tblprefix."included_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
				$rs_inc = $db->Execute($qry_inc);
				$incarray = array();
				while(!$rs_inc->EOF)
				{
					$incarray[] = $rs_inc->fields['included_id'];
					$rs_inc->MoveNext();
				}
				
				$qry_ninc = "SELECT * FROM  ".$tblprefix."nincluded_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
				$rs_ninc = $db->Execute($qry_ninc);
				$nincarray = array();
				while(!$rs_ninc->EOF)
				{
					$nincarray[] = $rs_ninc->fields['nincluded_id'];
					$rs_ninc->MoveNext();
				}
				
				$qry_xxtra = "SELECT * FROM  ".$tblprefix."xtra_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
				$rs_xxtra = $db->Execute($qry_xxtra);
				$xxtraarray = array();
				while(!$rs_xxtra->EOF)
				{
					$xxtraarray[] = $rs_xxtra->fields['xtra_id'];
					$rs_xxtra->MoveNext();
				}
				
				if($_POST['freeser'])
				{
					foreach($_POST['freeser'] as $offer)
					{
						if($freeserarray)
						{
							if(in_array($offer,$freeserarray))
							{
							
							}
							else
							{
								$update_ser = "INSERT ".$tblprefix."freeoffer_cagnpol SET
																			car_agnpolicy_id = '".$id."',
																			flag = '1',
																			offer_id = '".$offer."'";
								$run_ser = $db->Execute($update_ser);
							}
						}
						else
						{
							$update_ser = "INSERT ".$tblprefix."freeoffer_cagnpol SET
																			car_agnpolicy_id = '".$id."',
																			flag = '1',
																			offer_id = '".$offer."'";
							$run_ser = $db->Execute($update_ser);
						}
					}
				}
				if($freeserarray and !($_POST['freeser']))
				{
					foreach($freeserarray as $offer1)
					{
						
							$update_ser = "DELETE FROM ".$tblprefix."freeoffer_cagnpol WHERE 
																		car_agnpolicy_id = '".$id."' AND 
																		offer_id = '".$offer1."' AND flag='1'";
																		
																		
							$run_ser = $db->Execute($update_ser);
						
					}
				}
				
				
				
				if($_POST['inc_inprice'])
				{
					foreach($_POST['inc_inprice'] as $included)
					{
						
						if($incarray)
						{
							if(in_array($included,$incarray))
							{
							
							}
							else
							{
								$update_inc = "INSERT ".$tblprefix."included_cagnpol SET
																			car_agnpolicy_id = '".$id."',
																			flag = '1',
																			included_id = '".$included."'";
					
								$run_inc = $db->Execute($update_inc);
							}
						}
						else
						{
							$update_inc = "INSERT ".$tblprefix."included_cagnpol SET
																			car_agnpolicy_id = '".$id."',
																			flag = '1',
																			included_id = '".$included."'";
					
							$run_inc = $db->Execute($update_inc);
						}
					}
					
				
				}
				if($incarray and !($_POST['inc_inprice']))
				{
					foreach($incarray as $offer2)
					{
						
							$update_ser = "DELETE FROM ".$tblprefix."included_cagnpol WHERE 
																		car_agnpolicy_id = '".$id."' AND 
																		included_id = '".$offer2."' AND flag='1'";
																		
							$run_ser = $db->Execute($update_ser);
						
					}
				}
				
				if($_POST['notinc_inprice'])
				{
				foreach($_POST['notinc_inprice'] as $nincluded)
				{
					if($nincarray)
					{
						if(in_array($nincluded,$nincarray))
						{
						
						}
						else
						{
						$update_ninc = "INSERT ".$tblprefix."nincluded_cagnpol SET
																	car_agnpolicy_id = '".$id."',
																	flag = '1',
																	nincluded_id = '".$nincluded."'";
														
			
						$run_ninc = $db->Execute($update_ninc);
						}
					}
					else
					{
						$update_ninc = "INSERT ".$tblprefix."nincluded_cagnpol SET
																	car_agnpolicy_id = '".$id."',
																	flag = '1',
																	nincluded_id = '".$nincluded."'";
														
			
						$run_ninc = $db->Execute($update_ninc);
					}
				}
				}
				if($nincarray and !($_POST['notinc_inprice']))
				{
					foreach($nincarray as $offer3)
					{
						
							$update_ser = "DELETE FROM ".$tblprefix."nincluded_cagnpol WHERE 
																		car_agnpolicy_id = '".$id."' AND 
																		nincluded_id = '".$offer3."' AND flag='1'";
																		
							$run_ser = $db->Execute($update_ser);
						
					}
				}
				
				if($_POST['optxtra'])
				{
				foreach($_POST['optxtra'] as $optxtra)
				{
					if($xxtraarray)
					{
						if(in_array($optxtra,$xxtraarray))
						{
						
						}
						else
						{
						$update_opt = "INSERT ".$tblprefix."xtra_cagnpol SET
																	car_agnpolicy_id = '".$id."',
																	flag = '1',
																	xtra_id = '".$optxtra."' AND flag='1'";
			
						$run_opt = $db->Execute($update_opt);
						}
					}
					else
					{
						$update_opt = "INSERT ".$tblprefix."xtra_cagnpol SET
																	car_agnpolicy_id = '".$id."',
																	flag = '1',
																	xtra_id = '".$optxtra."'";
			
						$run_opt = $db->Execute($update_opt);
					}
				}
				}
				if($xxtraarray and !($_POST['optxtra']))
				{
					foreach($xxtraarray as $offer4)
					{
						$update_ser = "DELETE FROM ".$tblprefix."xtra_cagnpol WHERE 
																		car_agnpolicy_id = '".$id."' AND 
																		xtra_id = '".$offer4."' AND flag='1'";
																		
							$run_ser = $db->Execute($update_ser);
						
					}
				}
				//exit;
				
				unset($_SESSION['add_sees']);
				
				$okmsg = base64_encode("Agency Policy Updated successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
				exit;
			}else{
				$okmsg = base64_encode("Unable to Updated Agency Policy in database.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
				exit;
			}
		





		//}
	

  }


######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='del_policy' && $_GET['act']=='mng_caragncy_policy' && $_GET['request_page']=='mng_caragncy_policy')
{
	$id=base64_decode($_GET['id']);

	$del_qry = " DELETE FROM ".$tblprefix."caragncy_policy WHERE pol_id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete)
	{
			
			$del_qry1 = " DELETE FROM ".$tblprefix."freeoffer_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
			$rs_delete1 = $db->Execute($del_qry1);
			
			$del_qry2 = " DELETE FROM ".$tblprefix."included_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
			$rs_delete2 = $db->Execute($del_qry2);
			
			$del_qry3 = " DELETE FROM ".$tblprefix."nincluded_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
			$rs_delete3 = $db->Execute($del_qry3);
			
			$del_qry4 = " DELETE FROM ".$tblprefix."xtra_cagnpol WHERE car_agnpolicy_id =".$id." and flag='1'";
			$rs_delete4 = $db->Execute($del_qry4);
			
		
		
		$okmsg = base64_encode("Car Agency Policy Deleted successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}
	else
	{
		$okmsg = base64_encode("Unable to Delete !!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;

	}

}



?>
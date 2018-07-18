<?php
if($_POST['mode']=='add' && $_POST['act']=='mng_yatagncy_policy' && $_POST['request_page']=='mng_yatagncy_policy'){

	$_SESSION['add_sees'] = $_POST;
	
	$agency_name = addslashes(trim($_POST['agency_id']));


	/* END: if($rs) */

	if($_POST['first_name'] == '0'){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		exit;
	}
	
	if($agency_name == '0'){

		$errmsg = base64_encode('Please Select Agency Name!!');
		header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		exit;
	}


	if($_POST['cancldays'] == ''){

		$errmsg = base64_encode('Please Enter Cancellation days!!');
		header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		exit;
	}
	if($_POST['cancellation_charges_percent'] == 0){

		$errmsg = base64_encode('Please Enter Cancellation charges!!');
		header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
		exit;
	}

	
	if($_POST['early_booking'] == '1')
	{ 
		if($_POST['threshold'] == '' or $_POST['discount_percentage'] == '')
		{
			$errmsg = base64_encode('Please fill Early Booking Details!!');
			header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
			exit;
		}
	}


  else
  {
	

	
	if(in_array('0',$_POST['credit_card_accepted']))
	{
		$cardaccept = "0";
	}
	else
	{
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
	}
	

	if($_POST['early_booking'] == '0' and $_POST['threshold'] == '')
	{
		$threshold = "0";
	}
	elseif($_POST['early_booking'] == '0' and $_POST['threshold'] != '')
	{
		$threshold = "0";
	}
	else
	{
		$threshold = $_POST['threshold'];
	}
	
	if($_POST['early_booking'] == '0' and $_POST['discount_percentage'] == '')
	{
		$dcharges = "0";
	}
	elseif($_POST['early_booking'] == '0' and $_POST['discount_percentage'] != '')
	{
		$dcharges = "0";
	}
	else
	{
		$dcharges = $_POST['discount_percentage'];
	}

			$update_img_query = "INSERT ".$tblprefix."yatagncy_policy SET
														agncy_id = '".$agency_name."',
														pm_id = '".$_POST['first_name']."',
														creditcard = '".$cardaccept."',
														threshold = '".$threshold."',
														yatmodel = '".$_POST['ymodel']."',
														depositcharge = '".$dcharges."',
														cancl_days = '".$_POST['cancldays']."',
														prepayment = '".$_POST['prepayment']."',
														remaining = '".$_POST['remainingpay']."',
														security_deposit = '".$_POST['secdeposit']."',
														weeks_prior = '".$_POST['weeksprior']."',
														noshow_pol = '".$_POST['no_show_policy']."',
														cancl_charges = '".$_POST['cancellation_charges_percent']."',
														imp_note_skipper = '".$_POST['onlywidskpr']."',
														maximal_discount = '".$_POST['max_discount']."',
														disc_week0 = '".$_POST['discweek0']."',
														disc_week1 = '".$_POST['discweek1']."',
														disc_week2 = '".$_POST['discweek2']."',
														disc_week3 = '".$_POST['discweek3']."',
														disc_week4 = '".$_POST['discweek4']."',
														ofr_included_inprice = '".$_POST['inc_inprice']."',
														ofr_notincluded_inprice = '".$_POST['notinc_inprice']."',
														imp_note_crow = '".$_POST['onlywidcrow']."'"; 

			$run_query = $db->Execute($update_img_query);
			
			
			
			if($run_query)
			{
			
				$id= mysql_insert_id();
				foreach($_POST['freeser'] as $offer)
				{
					$update_ser = "INSERT ".$tblprefix."freeoffer_cagnpol SET
																car_agnpolicy_id = '".$id."',
																flag = '0',
																offer_id = '".$offer."'";
		
					$run_ser = $db->Execute($update_ser);
				}
				foreach($_POST['optxtra'] as $optxtra)
				{
				
					if($_POST[$optxtra]!='0')
					{
						$update_opt = "INSERT ".$tblprefix."xtra_cagnpol SET
																	car_agnpolicy_id = '".$id."',
																	flag = '0',
																	price = '".$_POST[$optxtra]."',
																	xtra_id = '".$optxtra."'";
			
						$run_opt = $db->Execute($update_opt);
					}
					
					
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
	

  }





//---------Update Car---------

###############################################################################
if($_POST['mode']=='edit' && $_POST['act']=='mng_yatagncy_policy' && $_POST['request_page']=='mng_yatagncy_policy'){


$id=base64_decode($_POST['id']);

	$agency_name = addslashes(trim($_POST['agency_id']));
	$terms = addslashes(trim($_POST['trmsncond']));


	/* END: if($rs) */

	if($_POST['first_name'] == '0'){

		$errmsg = base64_encode('Please Select PM!!');
		header("Location: admin.php?act=mng_yatagncy_policy&errmsg=$errmsg");
		exit;
	}
	
	if($agency_name == '0'){

		$errmsg = base64_encode('Please Select Agency Name!!');
		header("Location: admin.php?act=mng_yatagncy_policy&errmsg=$errmsg");
		exit;
	}


	if($_POST['cancldays'] == '0'){

		$errmsg = base64_encode('Please Enter Cancellation days!!');
		header("Location: admin.php?act=mng_yatagncy_policy&errmsg=$errmsg");
		exit;
	}
	if($_POST['cancellation_charges_percent'] == ''){

		$errmsg = base64_encode('Please Enter Cancellation charges!!');
		header("Location: admin.php?act=mng_yatagncy_policy&errmsg=$errmsg");
		exit;
	}

	
	if($_POST['charge_flag'] == '1' and $_POST['dcharges'] == '' ){

		$errmsg = base64_encode('Please Enter Deposit Charges!!');
		header("Location: admin.php?act=mng_yatagncy_policy&errmsg=$errmsg");
		exit;
	}
	


  else
  {
	
	if(in_array('0',$_POST['credit_card_accepted']))
	{
		$cardaccept = "0";
	}
	else
	{
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
	}
	

	if($_POST['early_booking'] == '0' and $_POST['threshold'] == '')
	{
		$threshold = "0";
	}
	elseif($_POST['early_booking'] == '0' and $_POST['threshold'] != '')
	{
		$threshold = "0";
	}
	else
	{
		$threshold = $_POST['threshold'];
	}
	
	if($_POST['early_booking'] == '0' and $_POST['discount_percentage'] == '')
	{
		$dcharges = "0";
	}
	elseif($_POST['early_booking'] == '0' and $_POST['discount_percentage'] != '')
	{
		$dcharges = "0";
	}
	else
	{
		$dcharges = $_POST['discount_percentage'];
	}

	 		$update_img_query = "UPDATE ".$tblprefix."yatagncy_policy SET
														agncy_id = '".$agency_name."',
														pm_id = '".$_POST['first_name']."',	
														creditcard = '".$cardaccept."',
														threshold = '".$threshold."',
														yatmodel = '".$_POST['ymodel']."',
														depositcharge = '".$dcharges."',
														cancl_days = '".$_POST['cancldays']."',
														prepayment = '".$_POST['prepayment']."',
														remaining = '".$_POST['remainingpay']."',
														noshow_pol = '".$_POST['no_show_policy']."',
														security_deposit = '".$_POST['secdeposit']."',
														weeks_prior = '".$_POST['weeksprior']."',
														cancl_charges = '".$_POST['cancellation_charges_percent']."',
														imp_note_skipper = '".$_POST['onlywidskpr']."',
														maximal_discount = '".$_POST['max_discount']."',
														disc_week0 = '".$_POST['discweek0']."',
														disc_week1 = '".$_POST['discweek1']."',
														disc_week2 = '".$_POST['discweek2']."',
														disc_week3 = '".$_POST['discweek3']."',
														disc_week4 = '".$_POST['discweek4']."',
														ofr_included_inprice = '".$_POST['inc_inprice']."',
														ofr_notincluded_inprice = '".$_POST['notinc_inprice']."',
														imp_note_crow = '".$_POST['onlywidcrow']."' 
														WHERE pol_id = '".$id."'";  
														

			$run_query = $db->Execute($update_img_query);
			
			//mysql_insert_id(connection);
			
			if($run_query)
			{
								
			 	$qry_free = "SELECT * FROM  ".$tblprefix."freeoffer_cagnpol WHERE car_agnpolicy_id =".$id." and flag='0'";  
				
				$rs_free = $db->Execute($qry_free);
				$freeserarray = array();
				$rs_free->MoveFirst(); 
				while(!$rs_free->EOF)
				{
					$freeserarray[] = $rs_free->fields['offer_id'];
					$rs_free->MoveNext();
				}
				
				
				
				$qry_xxtra = "SELECT * FROM  ".$tblprefix."xtra_cagnpol WHERE car_agnpolicy_id =".$id." and flag='0'";
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
																			flag = '0',
																			offer_id = '".$offer."'";
								$run_ser = $db->Execute($update_ser);
							}
						}
						else
						{
							$update_ser = "INSERT ".$tblprefix."freeoffer_cagnpol SET
																			car_agnpolicy_id = '".$id."',
																			flag = '0',
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
																		offer_id = '".$offer1."' AND flag='0'";
																		
																		
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
																	flag = '0',
																	price = '".$_POST[$optxtra]."',
																	xtra_id = '".$optxtra."'";
			
						$run_opt = $db->Execute($update_opt);
						}
					}
					else
					{
						$update_opt = "INSERT ".$tblprefix."xtra_cagnpol SET
																	car_agnpolicy_id = '".$id."',
																	flag = '0',
																	price = '".$_POST[$optxtra]."',
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
																		xtra_id = '".$offer4."' AND flag='0'";
																		
							$run_ser = $db->Execute($update_ser);
						
					}
				}
				//exit;
				
				$okmsg = base64_encode("Agency Policy Updated successfully.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
				exit;
			}else{
				$okmsg = base64_encode("Unable to Updated Agency Policy in database.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
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

if($_GET['mode']=='del_policy' && $_GET['act']=='mng_yatagncy_policy' && $_GET['request_page']=='mng_yatagncy_policy')
{
	$id=base64_decode($_GET['id']);

	$del_qry = " DELETE FROM ".$tblprefix."yatagncy_policy WHERE pol_id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete)
	{
			
			$del_qry1 = " DELETE FROM ".$tblprefix."freeoffer_cagnpol WHERE car_agnpolicy_id =".$id." and flag='0'";
			$rs_delete1 = $db->Execute($del_qry1);
			
				
			$del_qry4 = " DELETE FROM ".$tblprefix."xtra_cagnpol WHERE car_agnpolicy_id =".$id." and flag='0'";
			$rs_delete4 = $db->Execute($del_qry4);
			
		
		
		$okmsg = base64_encode("Yacht Agency Policy Deleted successfully. !");
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
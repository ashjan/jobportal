<?php	
if($_GET['mode']=='senmailtopm' && $_GET['act']=='top_offersmngmnt' && $_GET['request_page']=='topoffrmang')
{

$error='';

$ofrid = base64_decode($_GET['offerid']);

$qry_pickpm = "SELECT pm_email FROM ".$tblprefix."top_offer_program where pgm_id='".$ofrid."'"; 
$rs_pickpm = $db->Execute($qry_pickpm);


$qry_emconf = "SELECT * FROM ".$tblprefix."email_conf where email_type='top_offer'"; 
$rs_emconf = $db->Execute($qry_emconf);

$qryadmin = "SELECT * FROM ".$tblprefix."admin where id='1'"; 
$rsadmin = $db->Execute($qryadmin);

$qry_pm = "SELECT pm_id FROM ".$tblprefix."top_offer_program where pgm_id='".$ofrid."'"; 
$rs_pm = $db->Execute($qry_pm);	

$qry_pmname = "SELECT first_name,last_name FROM ".$tblprefix."users where id='".$rs_pm->fields['pm_id']."'"; 
$rsqry_pmname = $db->Execute($qry_pmname);	

$qry_definvice = "SELECT 
                   id,
				   invoice_defcharg 
                   FROM ".$tblprefix."invoicedef_charge WHERE id='1'"; 
$rs_definvice = $db->Execute($qry_definvice);		
			

if($error!='')
{
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
}else{
														
														
							$update_img_query = "UPDATE ".$tblprefix."top_offer_program SET
							emailsnt_flag ='1' WHERE pgm_id='".$ofrid."'";
														
				
				
							$run_query = $db->Execute($update_img_query);
							if($run_query)
							{
								
								
								$newsletter_body = $rs_emconf->fields['email_body'];
								$noreply_email = $rsadmin->fields['email'];
								$toemail = $rs_pickpm->fields['pm_email'];
								$newslettersubject = $rs_emconf->fields['subject'];
								$chrgdamnt = $rs_definvice->fields['invoice_defcharg']."€";
								
								$replace = $rsqry_pmname->fields['first_name']."&nbsp;".$rsqry_pmname->fields['last_name'].",";
								$accptlink = "admin.php?act=top_offersmngmnt&amp;l_status=1&amp;mode=offrresponse&amp;id=".base64_encode($ofrid)."&amp;request_page=topoffrmang";
								$rejcttlink = "admin.php?act=top_offersmngmnt&amp;l_status=0&amp;mode=offrresponse&amp;id=".base64_encode($ofrid)."&amp;request_page=topoffrmang";
								$newsletter_body = str_replace("%displayname%!",$replace,$newsletter_body);
								$newsletter_body = str_replace("%linkaccept%",$accptlink,$newsletter_body);
								$newsletter_body = str_replace("%chamount%",$chrgdamnt,$newsletter_body);
								$newsletter_body = str_replace("%linkreject%",$rejcttlink,$newsletter_body);
								
								
								echo $newslettersubject."<br>";
								echo $newsletter_body;
								exit;
								$mContact = new Mail;
								$mContact->ReplyTo($noreply_email);
								$mContact->To($toemail);
								$mContact->Subject($newslettersubject);
								//$mContact->Envelope('-f'.$notifyemail);
								$mContact->Body($newsletter_body);
								$mContact->Priority(2) ; 
								$mContact->Send();
							
								$okmsg = base64_encode("Email Sent Successfully!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']."&mailsentt=1");
								exit;
							}
							else
							{
								$okmsg = base64_encode("Unable to Send Mail!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
								exit;
							}
							
			}
}

 if($_GET['mode']=='offrresponse' && $_GET['act']=='top_offersmngmnt' && $_GET['request_page']=='topoffrmang'){
 
		$id=base64_decode($_GET['id']);
         
		 $status=$_GET['l_status'];
		
		if($status == 1)
		{
			 $update_qry = " UPDATE ".$tblprefix."top_offer_program SET
		                                                  ofr_accptdflag = '1'
														  WHERE pgm_id = '".$id."' ";
														 
														  
			 $rs_newsletter = $db->Execute($update_qry);
			 $okmsg = base64_encode("Offer Accepted by PM!");	
		}
		else
		{
			$update_qry = " UPDATE ".$tblprefix."top_offer_program SET
		                                                  ofr_accptdflag = '0'
														  WHERE pgm_id = '".$id."' ";
														  
			 $rs_newsletter = $db->Execute($update_qry);
			 $okmsg = base64_encode("Offer Rejected by PM!");
		}
					

					
					header("Location: admin.php?okmsg=$okmsg&act=top_offersmngmnt&mailsentt=1");
					exit;	  
 }	

//Update Section

if($_POST['mode']=='update' && $_POST['act']=='edityatchtypes' && $_POST['request_page']=='yatchtypes_mangagemnet'){
$post=$_POST;
$error='';
$_SESSION[yatch_name]=$post['yatch_name'];
$_SESSION[price_period]=$post['price_period'];
$_SESSION[per_person]=$post['per_person'];
$_SESSION[property_cat]=$post['property_cat'];
$_SESSION[id]=$post['id'];
$yatch_name = addslashes(trim($post['yatch_name']));



if($post['yatch_name']==''){
	$error="Accommodation  Name required<br>";
}
$slug=slugcreation($accomm_name);
/*if($post['price_period']==0){
	$error.="Please define the price period <br>";
}*/
if($post['first_name']==0){
	$error.="PM Name is required<br>";
}

if($post['agency_id']==0){
	$error.="Agency name is required";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".$_POST['id']);
}else{
												  		$update_img_query = "UPDATE ".$tblprefix."yatchtypes SET
														yatch_agency ='".$post['agency_id']."',
														pm_id ='".$post['first_name']."',
														yatch_name = '".$yatch_name."',
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
														yatch_week_day = '".$post['yatch_week_day']."',
														yatch_comfort = '".$post['yatch_comfort']."',
														yatch_comfort = '".$post['yatch_comfort']."',
														yatch_cat = ".$post['agency_id']."
														WHERE id=".base64_decode($_POST['id'])
														;
						$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Yatch Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&id=".$_POST['id']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".$_POST['id']);
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
if($_GET['mode']=='deloffr' && $_GET['act']=='top_offersmngmnt' && $_GET['request_page']=='topoffrmang'){
		$id = base64_decode($_GET['id']);
		$del_qry = "DELETE FROM ".$tblprefix."top_offer_program WHERE pgm_id=".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
			$okmsg = base64_encode("Offer Deleted successfully");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}else{
			$okmsg = base64_encode("Unable to Delete!!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}
} 

if($_GET['mode']=='change_pmstatus' && $_GET['act']=='top_offersmngmnt' && $_GET['request_page']=='topoffrmang'){
		$id=base64_decode($_GET['id']);
        $prop_id = base64_decode($_GET['prop_id']);
		$status=$_GET['m_status'];
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		 $update_qry = " UPDATE ".$tblprefix."top_offer_program SET
		                                                  offer_status = '".$newstatus."'
														  WHERE pgm_id = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);
		if($rs_newsletter){
		$update_qry = " UPDATE ".$tblprefix."properties SET
		                                                  topoffr_flag = '".$newstatus."'
														  WHERE id = '".$prop_id."' ";
		$rs_newsletter = $db->Execute($update_qry);
		}
		$okmsg = base64_encode("Status UPDATED successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=top_offersmngmnt&mailsentt=1");
					exit;	  
 }	
?>
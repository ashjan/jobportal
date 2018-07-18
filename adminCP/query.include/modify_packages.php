<?php

	   
######################
#
# 	GET SECTION
#
######################

//---------Approve Package---------
if($_GET['mode']=='approve' && $_GET['act']=='subscribed_packages' && $_GET['request_page']=='modify_packages'){
		$id=base64_decode($_GET['id']);
		
		$qr_update_status= "UPDATE ".$tblprefix."subscribed_packages 
													SET 
													status= 1
													WHERE
													sp_id=".$id." ";
		$rs_update_status = $db->Execute($qr_update_status);
		
		$qr_approval_notification = "SELECT * from tbl_email_conf
													WHERE
													id= 15";
		$rs_approval_notification = $db->Execute($qr_approval_notification);
			
			// getting package detail on order to umbed the package name into the order approval notification
		$qr_package_detail = "SELECT p.`package_name` ,c.`company_name`
								FROM tbl_packages p
								JOIN tbl_subscribed_packages sp ON sp.`package_id` = p.`package_id`
								JOIN tbl_companyy AS c ON c.`company_id` = sp.`company_id`
								WHERE sp.`sp_id` = ".$id." ";
		$rs_package_detail = $db->Execute($qr_package_detail);
		
			//echo "<pre>";
			//print_r($rs_package_detail->fields); exit;
			// replacting the template pcakge and display name to the company name and package name

			$message	=	str_replace('%displayname%',$rs_package_detail->fields['company_name'],$rs_approval_notification->fields['email_body']);
			$rs_package_detail->fields['package_name'] = '<strong>'.$rs_package_detail->fields['package_name'].'</strong>';
			$message	=	str_replace('%package%',$rs_package_detail->fields['package_name'],$message);
					
		if($rs_update_status){
			$qr_update_notification = "UPDATE tbl_notification SET tbl_notification.`response_message` = '".$message."'
										WHERE tbl_notification.`sp_id` = ".$id." ";
			$rs_update_notification = $db->Execute($qr_update_notification);
			
			$okmsg = base64_encode("Package Approved Successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=subscribed_packages");
			exit;
			}
		else{
			$errmsg = base64_encode("Package can not be approved please try again. !");
			header("Location: admin.php?errmsg=$errmsg&act=subscribed_packages");
			exit;
		}
			

}

		############ 
######## Reject Pack #######
 		############
		
if($_GET['mode']=='reject' && $_GET['act']=='subscribed_packages' && $_GET['request_page']=='modify_packages'){
		$id=base64_decode($_GET['id']);
		
		$qr_update_status= "UPDATE ".$tblprefix."subscribed_packages 
													SET 
													status= 2
													WHERE
													sp_id=".$id." ";
		$rs_update_status = $db->Execute($qr_update_status);
		$qr_approval_notification = "SELECT * from tbl_email_conf
													WHERE
													id= 16";
		$rs_approval_notification = $db->Execute($qr_approval_notification);
			
			// getting package detail on order to umbed the package name into the order approval notification
		$qr_package_detail = "SELECT p.`package_name` ,c.`company_name`
								FROM tbl_packages p
								JOIN tbl_subscribed_packages sp ON sp.`package_id` = p.`package_id`
								JOIN tbl_companyy AS c ON c.`company_id` = sp.`company_id`
								WHERE sp.`sp_id` = ".$id." ";
		$rs_package_detail = $db->Execute($qr_package_detail);
		
			//echo "<pre>";
			//print_r($rs_package_detail->fields); exit;
			// replacting the template pcakge and display name to the company name and package name

			$message	=	str_replace('%displayname%',$rs_package_detail->fields['company_name'],$rs_approval_notification->fields['email_body']);
			$rs_package_detail->fields['package_name'] = '<strong>'.$rs_package_detail->fields['package_name'].'</strong>';
			$message	=	str_replace('%package%',$rs_package_detail->fields['package_name'],$message);
			//echo $message; exit;
		
		if($rs_update_status){
			$qr_update_notification = "UPDATE tbl_notification SET tbl_notification.`response_message` = '".$message."'
										WHERE tbl_notification.`sp_id` = ".$id." ";
			$rs_update_notification = $db->Execute($qr_update_notification);
			$okmsg = base64_encode("Package request rejected Successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=subscribed_packages");
			exit;
			}
		else{
			$errmsg = base64_encode("Package request can not be rejected please try again. !");
			header("Location: admin.php?errmsg=$errmsg&act=subscribed_packages");
			exit;
		}
			

}

		############ 
######## Enable Package #######
 		############
		
if($_GET['mode']=='enable' && $_GET['act']=='subscribed_packages' && $_GET['request_page']=='modify_packages'){
		$id=base64_decode($_GET['id']);
		
		$qr_update_status= "UPDATE ".$tblprefix."subscribed_packages 
													SET 
													status= 1
													WHERE
													sp_id=".$id;
		$rs_update_status = $db->Execute($qr_update_status);
		if($rs_update_status){
			$okmsg = base64_encode("Package enabled Successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=subscribed_packages");
			exit;
			}
		else{
			$errmsg = base64_encode("Package can not be ebabled please try again. !");
			header("Location: admin.php?errmsg=$errmsg&act=subscribed_packages");
			exit;
		}
			

}


		############ 
######## Disable Package #######
 		############
		
if($_GET['mode']=='disable' && $_GET['act']=='subscribed_packages' && $_GET['request_page']=='modify_packages'){
		$id=base64_decode($_GET['id']);
		
		$qr_update_status= "UPDATE ".$tblprefix."subscribed_packages 
													SET 
													status= 4
													WHERE
													sp_id=".$id;
		$rs_update_status = $db->Execute($qr_update_status);
		if($rs_update_status){
			$okmsg = base64_encode("Package disabled Successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=subscribed_packages");
			exit;
			}
		else{
			$errmsg = base64_encode("Package can not be disabled please try again. !");
			header("Location: admin.php?errmsg=$errmsg&act=subscribed_packages");
			exit;
		}
			

}




	
?>
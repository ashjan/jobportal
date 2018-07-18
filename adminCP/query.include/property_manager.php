<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Property Manager---------
	if(!empty($_POST)){
	if($_POST['mode']=='add' && $_POST['act']=='managepropertymanager' && $_POST['request_page']=='users'){
	
	
		$password = addslashes(trim($_POST['password']));
		$first_name = addslashes(trim($_POST['first_name']));
		$last_name = addslashes(trim($_POST['last_name']));
		$email_address = addslashes(trim($_POST['email_address']));
		$business_email = addslashes(trim($_POST['business_email']));
		$business_type = addslashes(trim($_POST['business_type']));
		$town = addslashes(trim($_POST['town']));
		$phone_number = addslashes(trim($_POST['phone_number']));
		
		if($password == ''){
				$errmsg = base64_encode('Please enter password');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		
				$qry_manager_exist= "SELECT
							".$tblprefix."users 
							FROM
							".$tblprefix."users where email_address ='".$email_address."' ";
				$rs_manager_exist=$db->Execute($qry_manager_exist);
				$count_rec =  $rs_manager_exist->RecordCount();
				if($count_rec > 0){
					$errmsg = base64_encode('This manager Recorod already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
					exit;
				}	
				$sql_property= "INSERT INTO ".$tblprefix."users 
														SET 
														 first_name = '".$first_name."',
														 last_name  = '".$last_name ."',
														 email_address =".$email_address.",
														 email_address ='".$business_address."',
														 town ='".$town."',
														 phone_number ='".$phone_number."',
														 password = '".$password."'";
				$rs_ins_menu = $db->Execute($sql_property);
				if($rs_ins_menu){
					$okmsg = base64_encode("Manager Record Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				} 
			 
	} 
        }
//---------Edit Property Managers---------
        if(!empty($_POST)){
	if($_POST['mode']=='update' && $_POST['act']=='edit_users' && $_POST['request_page']=='users'){
		
		$first_name = addslashes(trim($_POST['first_name']));
		$last_name = addslashes(trim($_POST['last_name']));
		$email_address = addslashes(trim($_POST['email_address']));
		$business_email = addslashes(trim($_POST['business_email']));
		$password = addslashes(trim($_POST['password']));
		$password = password($password);
		
		$town = addslashes(trim($_POST['town']));
		$phone_number = addslashes(trim($_POST['phone_number']));
		$id=base64_decode($_POST['id']);
		
				
		$_SESSION['first_name']= $first_name;
		$_SESSION['last_name']= $last_name; 
		$_SESSION['email_address']=$email_address;
		$_SESSION['business_email']=$business_email;
		
		$_SESSION['town']= $town;
		$_SESSION['phone_number']= $phone_number;
		$_SESSION['id']= $id;
		
	
		if($first_name == ''){
				$errmsg = base64_encode('Please Enter First Name');
				header("Location: admin.php?act=edit_users&errmsg=$errmsg");
				exit;
		}
		
		if($last_name == ''){
				$errmsg = base64_encode('Please Enter Last Name');
				header("Location: admin.php?act=edit_users&errmsg=$errmsg");
				exit;
		}
		
		if($email_address == ''){
				$errmsg = base64_encode('Please Enter Email Address');
				header("Location: admin.php?act=edit_users&errmsg=$errmsg");
				exit;
		}
		
		if($password == ''){
		 $sql_update= "UPDATE ".$tblprefix."users  SET	
														first_name = '".$first_name."', 
														last_name = '".$last_name."', 
														email_address ='".$email_address."', 														
														town ='".$town."',
														phone_number ='".$phone_number."'																												                                                        WHERE
														id=".$id;
							}else{
		$sql_update= "UPDATE ".$tblprefix."users  SET	
														first_name = '".$first_name."', 
														last_name = '".$last_name."', 
														email_address ='".$email_address."',
														password ='".$password."', 														
														town ='".$town."',
														phone_number ='".$phone_number."'																																																			                                                        WHERE
														id=".$id;
							}							
														
		$rs_update = $db->Execute($sql_update);
		    if($rs_update){
				
			$okmsg = base64_encode(" Manager Record updated successfully. !");
			unset($_SESSION[$_POST]);
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
			exit;	  
				}
				
			else{
			$errmsg = base64_encode(" Property Manager Record not updated!");
			unset($_SESSION[$_POST]);
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;	  	
				
			} 
			
			} 
        }

	   
######################
#
# 	GET SECTION
#
######################

//---------Delete Service Provider---------
if($_GET['mode']=='delpage' && $_GET['act']=='managepropertymanager' && $_GET['request_page']=='users'){
		
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."users WHERE id = '".$id."' ";
		
		$rs_newsletter = $db->Execute($del_qry);				
		$okmsg = base64_encode("Manager Record successfully deleted. !");
					header("Location: admin.php?okmsg=$okmsg&act=managepropertymanager");
					exit;	  
} 

//---------UPDATE STAUS PROPERTY MANAGER ---------
if($_GET['mode']=='change_pmstatus' && $_GET['act']=='managepropertymanager' && $_GET['request_page']=='users'){
		$id=base64_decode($_GET['id']);
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		$update_qry = " UPDATE ".$tblprefix."users SET
		                                                  pm_status = '".$newstatus."'
														  WHERE id  = '".$id."' ";
		$rs_pmqry = $db->Execute($update_qry);			
		
		 $update_qry2 = " UPDATE ".$tblprefix."properties SET
		                                                  permission_status = '".$newstatus."'
														  WHERE pm_id = '".$id."' ";	
			$rs_propertyqry = $db->Execute($update_qry2);
			
		$okmsg = base64_encode("Manager Record successfully UPDATED And Properties Against Him Also. !");
					header("Location: admin.php?okmsg=$okmsg&act=managepropertymanager");
					exit;	  
} 

//update consultatnt status

if($_GET['mode']=='make_consultant' && $_GET['act']=='managepropertymanager' && $_GET['request_page']=='users'){
		$id=base64_decode($_GET['id']);
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 2;
		}elseif($status == 2){
		$newstatus = 1;
		}
		$update_qry = " UPDATE ".$tblprefix."users SET
		                                                  consultant_check = '".$newstatus."'
														  WHERE id  = '".$id."' ";
                
		$rs_pmqry = $db->Execute($update_qry);			
		
		 	
			
		$okmsg = base64_encode("Manager Record successfully UPDATED And Properties Against Him Also. !");
					header("Location: admin.php?okmsg=$okmsg&act=managepropertymanager");
					exit;	  
} 


//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='managepropertymanager' && $_GET['request_page']=='users'){
	
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	$status=$_GET['m_status'];
//if parent is disable 

	 $sql_first_name= "SELECT first_name FROM ".$tblprefix."users 
												WHERE
												id=".$id;
												
				$rs_sql_first_name = $db->Execute($sql_first_name);
				$first_name = $rs_sql_parent->fields['first_name'];

		if($first_name!=0){
				$sql_status= "SELECT menu_status FROM ".$tblprefix."users
													WHERE
													id=".$first_name;
													
				$rs_status = $db->Execute($sql_status);
				$status_parent = $rs_status->fields['menu_status'];
				if($status_parent==0){
						$errmsg = base64_encode("Status Could not be Acitvated.Activate Parent First. !");
						header("Location: admin.php?errmsg=$errmsg&act=managepropertymanager");
						exit;				
				}
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."users
													SET 
													first_name=".$first_name."
													WHERE
													id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				//to diable child
				if($status==0){
						$sql_parent= "UPDATE ".$tblprefix."users 
													SET 
													last_name=".$last_name."
													WHERE
													parent=".$id;
						$db->Execute($sql_parent);
				}
		
				if($rs_currencies){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=managepropertymanager");
						exit;	  
				}
		}else{
			$sql_currencies= "UPDATE ".$tblprefix."users 
												SET 
												email_address=".$email_address."
												WHERE
												id=".$id;
			$rs_currencies = $db->Execute($sql_currencies);

		//to diable child
		if($status==0){
	 			$sql_parent= "UPDATE ".$tblprefix."users 
												SET 
												business_type=".$business_type."
												WHERE
												parent=".$id;
					$db->Execute($sql_parent);
					}

				if($rs_currencies){
					$okmsg = base64_encode("Status updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=managepropertymanager");
					exit;	  
				}			
		}
	
	}
?>
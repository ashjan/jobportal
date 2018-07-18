<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Package Item---------
	if($_POST['mode']=='add' && $_POST['act']=='packages' && $_POST['request_page']=='packages'){
		
		
		$package_title = addslashes(trim($_POST['package_title']));
		if($package_title == ''){
				$errmsg = base64_encode('Please Enter Package Title ');
				header("Location: admin.php?act=packages&errmsg=$errmsg");
				exit;
			}
		$package_slug  = slugcreation($package_title);
		$package_currency = '';
		$package_price  = '';
		if(isset($_POST['package_currency'])){
			$package_currency = addslashes(trim($_POST['package_currency']));
		}
		if(isset($_POST['package_price'])){
			
			$package_price     = addslashes(trim($_POST['package_price']));
		}
		else{
			$package_price  = 'FREE';
			}
		//echo "dasdasdas"; exit;
		$package_description  = addslashes(trim($_POST['package_description']));
		$package_detail  = addslashes(trim($_POST['package_detail']));
		$package_type  = addslashes(trim($_POST['package_type']));
		
				$qry_package_exist= "SELECT
							".$tblprefix."packages.package_slug 
							FROM
							".$tblprefix."packages where package_slug ='".$package_slug."' ";
				$rs_package_exist=$db->Execute($qry_package_exist);
				$count_rec =  $rs_package_exist->RecordCount();
				if($count_rec > 0){
					$errmsg = base64_encode('This Package title already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
				}	
				$sql_package= "INSERT INTO ".$tblprefix."packages SET 
														 package_name = '".$package_title."',
														 package_type = '".$package_type."',
														 package_currency  = '".$package_currency ."',
														 package_price = '".$package_price."',
														 package_description ='".$package_description."',
														 package_detail='".$package_detail."',
														 package_creation_date='". date('d-m-y')."',
														 package_last_updated_date='". date('d-m-y')."',
														 package_status= 1 ,
														 package_slug ='".$package_slug."'
														 ";
				$rs_ins_package = $db->Execute($sql_package);
				
				if($rs_ins_package){
					$okmsg = base64_encode("Package Item Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
					$errmsg = base64_encode("Package Item Not Added. !");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;
				}
				
				
	} 
//---------Edit Package---------
	if($_POST['mode']=='update' && $_POST['act']=='packages' && $_POST['request_page']=='packages'){
	
		
			
		
		$package_title = addslashes(trim($_POST['package_title']));
		$package_currency = '';
		$package_price  = '';
		if(isset($_POST['package_currency'])){
			$package_currency = addslashes(trim($_POST['package_currency']));
		}
		if(isset($_POST['package_price'])){
			
			$package_price     = addslashes(trim($_POST['package_price']));
		}
		else{
			$package_price  = 'FREE';
			}
		$package_description  = addslashes(trim($_POST['package_description']));
		$package_detail  = addslashes(trim($_POST['package_detail']));
		$package_type  = addslashes(trim($_POST['package_type']));
		$package_slug  = slugcreation($package_title);
		
		$package_link = $package_slug;
		$id=base64_decode($_POST['id']);
		
		//validating the fields
		
		if($package_title == ''){
				$errmsg = base64_encode('Please Enter Package Title ');
				header("Location: admin.php?act=packages&errmsg=$errmsg");
				exit;
			}
												 $sql_update = "UPDATE ".$tblprefix."packages SET	
												 package_name = '".$package_title."',
												 package_type = '".$package_type."',
												 package_currency  = '".$package_currency ."',
												 package_price ='".$package_price."',
												 package_description ='".$package_description."',
												 package_detail='".$package_detail."',
												 package_last_updated_date='".date('d-m-y')."',
												 package_status= '1' ,
												 package_slug ='".$package_slug."'
												 WHERE
												 package_id=".$id." "; 
											
										
		    $rs_update = $db->Execute($sql_update);
		    //var_dump($rs_update); exit;
			if($rs_update){
			$okmsg = base64_encode(" Package item Updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;	  
				}else{
			$errmsg = base64_encode(" Package item not updated. !");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;	  	
			} 
			} 

	   
######################
#
# 	GET SECTION
#
######################

//---------Delete Service Provider---------
if($_GET['mode']=='del_package' && $_GET['act']=='packages' && $_GET['request_page']=='packages'){
		$id=base64_decode($_GET['id']);
		
		$del_qry = " DELETE FROM ".$tblprefix."packages WHERE package_id = ".$id;
		
		$rs_newsletter = $db->Execute($del_qry);
		if($rs_newsletter){
			$okmsg = base64_encode("Package Deleted Successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=packages");
			exit;
			}
		else{
			$errmsg = base64_encode("Package can not be deleted please try again. !");
			header("Location: admin.php?errmsg=$errmsg&act=packages");
			exit;
		}
			

}


//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='managemenues' && $_GET['request_page']=='managemenues'){
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	
	/*   if($id == 129){
				$errmsg = base64_encode('We are unable to change the Home menu Status!');
				header("Location: admin.php?act=managemenues&errmsg=$errmsg");
				exit;
			}  */
	
	$status=$_GET['m_status'];
//if parent is disable 
	 $sql_parent= "SELECT parent FROM ".$tblprefix."menu 
												WHERE
												id=".$id;
												
				$rs_sql_parent = $db->Execute($sql_parent);
				$parent = $rs_sql_parent->fields['parent'];

		if($parent!=0){
				$sql_status= "SELECT menu_status FROM ".$tblprefix."menu 
													WHERE
													id=".$parent;
													
				$rs_status = $db->Execute($sql_status);
				$status_parent = $rs_status->fields['menu_status'];
				/*if($status_parent==0){
						$errmsg = base64_encode("Status Could not be Acitvated.Activate Parent First. !");
						header("Location: admin.php?errmsg=$errmsg&act=managemenues");
						exit;				
				}*/
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."menu 
													SET 
													menu_status=".$status."
													WHERE
													id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				//to disable child
				if($status==0){
						$sql_parent= "UPDATE ".$tblprefix."menu 
													SET 
													menu_status=".$status."
													WHERE
													parent=".$id;
						$db->Execute($sql_parent);
				}
		
				if($rs_currencies){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=managemenues");
						exit;	  
				}
		}else{
			$sql_currencies= "UPDATE ".$tblprefix."menu 
												SET 
												menu_status=".$status."
												WHERE
												id=".$id;
			$rs_currencies = $db->Execute($sql_currencies);

		//to diable child
		if($status==0){
	 			$sql_parent= "UPDATE ".$tblprefix."menu 
												SET 
												menu_status=".$status."
												WHERE
												parent=".$id;
					$db->Execute($sql_parent);
					}

				if($rs_currencies){
					$okmsg = base64_encode("Status updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	  
				}			
		}
	
	}
	
	//*****************************************
	//---------footer menu Status Code---------	
	//*****************************************
		
if($_GET['mode']=='change_default' && $_GET['act']=='managemenues' && $_GET['request_page']=='managemenues'){}

	
?>
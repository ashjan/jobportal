<?php
######################
#
# 	POST SECTION
#
######################


//---------Edit Change Requests ---------

	if($_POST['mode']=='update' && $_POST['act']=='edit_change_request' && $_POST['request_page']=='mng_chage_request'){
		
		$pm_id = $_POST['pm_id'];
		$property_id = $_POST['property_id'];
		$request_text = addslashes(trim($_POST['request_text']));
		$request_date = addslashes(trim($_POST['request_date']));
		$id=base64_decode($_POST['id']);
		
	
		if($pm_id == ''){
				$errmsg = base64_encode('Please Select PM Name');
				header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));				
				exit();
		}
		
		if($property_id == ''){
				$errmsg = base64_encode('Molimo izaberite objekat');
				header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));				
				exit();
		}

		if($request_text == ''){
				$errmsg = base64_encode('Please Enter Request Text');
				header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));				
				exit();
		}
		if($request_date == ''){
				$errmsg = base64_encode('Please Enter Request Date');
				header("Location: admin.php?okmsg=$errmsg&act=".$post['act']."&id=".base64_encode($id));				
				exit();
		}
		
	
		 $sql_update= "UPDATE ".$tblprefix."change_request  SET	
														pm_id = '".$pm_id."', 
														property_id = '".$property_id."', 
														request_text ='".$request_text."',
														request_date ='".$request_date."'																																																			                                                        WHERE
														id=".$id;
														
												
		$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			$okmsg = base64_encode(" Change Request updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
			exit;	  
				}
				
			else{
			$errmsg = base64_encode(" Change Request not updated!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				
			} 
			
			} 

	   
######################
#
# 	GET SECTION
#
######################

//---------Delete Service Provider---------
if($_GET['mode']=='delpage' && $_GET['act']=='change_request' && $_GET['request_page']=='mng_chage_request'){ 
		
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."change_request WHERE id = '".$id."' ";
		
		$rs_newsletter = $db->Execute($del_qry);				
		$okmsg = base64_encode("Change Request successfully deleted. !");
					header("Location: admin.php?okmsg=$okmsg&act=change_request");
					exit;	  
} 

//---------UPDATE STAUS PROPERTY MANAGER ---------
if($_GET['mode']=='change_pmstatus' && $_GET['act']=='change_request' && $_GET['request_page']=='mng_chage_request'){
		$id=base64_decode($_GET['id']);
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		$update_qry = " UPDATE ".$tblprefix."change_request SET
		                                                  request_status = '".$newstatus."'
														  WHERE id  = '".$id."' ";
		$rs_pmqry = $db->Execute($update_qry);			
			
		$okmsg = base64_encode("Change Request updated  Successfully.!");
					header("Location: admin.php?okmsg=$okmsg&act=change_request");
					exit;	  
} 

?>
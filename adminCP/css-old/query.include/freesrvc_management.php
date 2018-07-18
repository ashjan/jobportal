<?php
if($_POST['mode']=='add' && $_POST['act']=='free_services' && $_POST['request_page']=='freesrvc_management')
	{        $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($event_category_name);
		
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Service Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
	 
					$qry_already_event= "SELECT ".$tblprefix."yatch_free_srvices.ser_id 
					FROM
					".$tblprefix."yatch_free_srvices where free_service='".$event_category_name."' ";
				
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Service already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
	 			
	 
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."yatch_free_srvices  
														SET
														free_service = '".$event_category_name."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Service Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Service Not Added .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_freeservice' && $_POST['request_page']=='freesrvc_management'){
	    $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = $_POST['pm_id'];
		$id=base64_decode($_POST['id']); 
//$_SESSION['id']=$id;
		 $_SESSION['event_category_name']= $event_category_name; 
			$slug=slugcreation($event_category_name);
			
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Event Category Name');
				header("Location: admin.php?act=update_events&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				 $sql_category= "UPDATE ".$tblprefix."yatch_free_srvices 
														SET
														free_service = '".$event_category_name."' 
														WHERE
														ser_id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Service Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Service Is Not Updated!");
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
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_service' && $_GET['act']=='free_services' && $_GET['request_page']=='freesrvc_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."yatch_free_srvices WHERE ser_id = ".$id; 
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Service Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>
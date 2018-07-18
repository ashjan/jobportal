<?php
if($_POST['mode']=='add' && $_POST['act']=='optional_extras' && $_POST['request_page']=='optionlxtra_management')
	{        $event_category_name = addslashes(trim($_POST['event_category_name']));
			 $price = addslashes(trim($_POST['price']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($event_category_name);
		
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Optional Extra');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
	 
					$qry_already_event= "SELECT ".$tblprefix."yatch_optional.ser_id 
					FROM
					".$tblprefix."yatch_optional where free_service='".$event_category_name."' ";
				
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Service already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
	 			
	 
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."yatch_optional  
														SET
														free_service = '".$event_category_name."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Optional Extra Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Optional Extra Not Added .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_optional' && $_POST['request_page']=='optionlxtra_management'){
	    $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = $_POST['pm_id'];
		$id=base64_decode($_POST['id']); 
		$price = addslashes(trim($_POST['price']));
//$_SESSION['id']=$id;
		 $_SESSION['event_category_name']= $event_category_name; 
			$slug=slugcreation($event_category_name);
			
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Optional Extra');
				header("Location: admin.php?act=update_events&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				 $sql_category= "UPDATE ".$tblprefix."yatch_optional 
														SET
														free_service = '".$event_category_name."' 
														WHERE
														ser_id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Optional Extra Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Optional Extra Is Not Updated!");
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
if($_GET['mode']=='del_xtra' && $_GET['act']=='optional_extras' && $_GET['request_page']=='optionlxtra_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."yatch_optional WHERE ser_id = ".$id; 
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Optional Extra Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>
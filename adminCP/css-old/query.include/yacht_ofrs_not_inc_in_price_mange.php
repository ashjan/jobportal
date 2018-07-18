<?php
if($_POST['mode']=='add' && $_POST['act']=='yacht_offers_not_included_in_price' && $_POST['request_page']=='yacht_ofrs_not_inc_in_price_mange')
	{        $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($event_category_name);
		
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Optional Extra');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
	 
					$qry_already_event= "SELECT ".$tblprefix."yacht_offers_not_included_in_price.ser_id 
					FROM
					".$tblprefix."yacht_offers_not_included_in_price where free_service='".$event_category_name."' ";
				
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Service already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
	 			
	 
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."yacht_offers_not_included_in_price  
														SET
														free_service = '".$event_category_name."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Offers Included In Price Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Offers Not Included In Price.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='yacht_update_offr_nt_inc_price' && $_POST['request_page']=='yacht_ofrs_not_inc_in_price_mange'){
	    $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = $_POST['pm_id'];
		$id=base64_decode($_POST['id']); 
//$_SESSION['id']=$id;
		 $_SESSION['event_category_name']= $event_category_name; 
			$slug=slugcreation($event_category_name);
			
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Optional Extra');
				header("Location: admin.php?act=yacht_update_offr_inc_price&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
			 	 $sql_category= "UPDATE ".$tblprefix."yacht_offers_not_included_in_price 
														SET
														free_service = '".$event_category_name."' 
														WHERE
														ser_id=".$id;
														
														
 
					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Offer is Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("offer Is Not Updated!");
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
if($_GET['mode']=='del_xtra' && $_GET['act']=='yacht_offers_not_included_in_price' && $_GET['request_page']=='yacht_ofrs_not_inc_in_price_mange'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."yacht_offers_not_included_in_price WHERE ser_id = ".$id; 
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Offer Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>
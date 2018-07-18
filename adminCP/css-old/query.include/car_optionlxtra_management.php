<?php
if($_POST['mode']=='add' && $_POST['act']=='car_opt_extras' && $_POST['request_page']=='car_optionlxtra_management')
	{        $event_category_name = addslashes(trim($_POST['event_category_name']));
		$price = addslashes(trim($_POST['price']));	
		$slug=slugcreation($event_category_name);
		
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Optional Extra');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}
	 
	 
			if($price == ''){
				$errmsg = base64_encode('Please Enter Price');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}
	 
	 
					$qry_already_event= "SELECT ".$tblprefix."car_optional.ser_id 
					FROM
					".$tblprefix."car_optional where free_service='".$event_category_name."' ";
				
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Service already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
	 			
	 
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."car_optional  
														SET
														free_service = '".$event_category_name."',
														price = '".$price."'
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
	if($_POST['mode']=='update' && $_POST['act']=='update_car_opt_extra' && $_POST['request_page']=='car_optionlxtra_management'){
	    $event_category_name = addslashes(trim($_POST['event_category_name']));
		$price = addslashes(trim($_POST['price']));	
		$id=base64_decode($_POST['id']); 
//$_SESSION['id']=$id;
		  
			$slug=slugcreation($event_category_name);
			
			
			if($price == ''){
				$errmsg = base64_encode('Please Enter Price');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}
			
			
			
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Optional Extra');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}else{
				 $sql_category= "UPDATE ".$tblprefix."car_optional 
														SET
														free_service = '".$event_category_name."', 
														price = '".$price."'
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
if($_GET['mode']=='del_xtra' && $_GET['act']=='car_opt_extras' && $_GET['request_page']=='car_optionlxtra_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."car_optional WHERE ser_id = ".$id; 
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Optional Extra Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>
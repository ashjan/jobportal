<?php

//Add Supplement Discount


if($_POST['mode']=='add' && $_POST['act']=='supplement_discount_managment' && $_POST['request_page']=='manage_supplement_discount'){
        $single_person_supplement = addslashes(trim($_POST['single_person_supplement']));
		$figure_in_percentage  = addslashes(trim($_POST['figure_in_percentage']));
		$charge_rate_value = addslashes(trim($_POST['charge_rate_value']));
				
			if($charge_rate_value > 100 || $charge_rate_value < 0){
				$errmsg = base64_encode('Please Enter Correct % of Charge Rate');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
		 		 						$insert_supplement_discount_equipment = "INSERT INTO ".$tblprefix."supplement_discount  
										SET
										single_person_supplement = '".									    						   			$single_person_supplement."',figure_in_percentage = '".$figure_in_percentage."',
										charge_rate_value = '".$charge_rate_value."'";
										
				$rs_insert = $db->Execute($insert_supplement_discount_equipment);
				$okmsg = base64_encode("Supplement Discount Added successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=supplement_discount_managment");
				exit;
				
	} 


//---------Update Car---------
	   
###############################################################################	 
	 
	
	
	
	if($_POST['mode'] == 'update' && $_POST['act'] == 'supplement_discount_managment'){
		$single_person_supplement = addslashes(trim($_POST['single_person_supplement']));
		$figure_in_percentage  = addslashes(trim($_POST['figure_in_percentage']));
		$charge_rate_value = addslashes(trim($_POST['charge_rate_value']));
		
			
			/*if($charge_rate_value > 100 || $charge_rate_value < 0){
				$errmsg = base64_encode('Please Enter Correct % of Charge Rate');
				header("Location: admin.php?act=".$_POST['id']."&errmsg=$errmsg");
				exit;
			}	*/
		
		if($charge_rate_value > 100 || $charge_rate_value < 0){
			$errmsg = base64_encode('Please Enter Correct % of Charge Rate');
			header("Location: admin.php?act=edit_supplement_discount&id=".$_POST['id']."&errmsg=$errmsg");
			exit;
		}
							$sql_update = "UPDATE ".$tblprefix."supplement_discount SET 
							single_person_supplement = '".$single_person_supplement."',
							figure_in_percentage = '".$figure_in_percentage."',
							charge_rate_value = '".$charge_rate_value."'
							WHERE id=".base64_decode($_POST['id']);
			
			
							
		$rs = $db->Execute($sql_update);
		
		
		if($rs){
		 $okmsg = base64_encode("Supplement Discount Updated successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;	  
	       }/* END: if($rs){ */
	
	   }
	

######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='del_discount' && $_GET['act']=='supplement_discount_managment' ){
		$id=base64_decode($_GET['id']);
		
 			

		  $del_qry = " DELETE FROM ".$tblprefix."supplement_discount WHERE id = ".$id." ";
		
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
			$okmsg = base64_encode("Supplement Discount Deleted successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=supplement_discount_managment");
			exit;	  
} 

?>
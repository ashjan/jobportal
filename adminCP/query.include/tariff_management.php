<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_tariff_calculation' && $_POST['request_page']=='tariff_management'){
	
       $price_period = addslashes(trim($_POST['price_period']));
		$per_person = addslashes(trim($_POST['per_person']));
		$wise_price = addslashes(trim($_POST['wise_price']));
		$threshold = addslashes(trim($_POST['threshold']));
		$discount_percentage = addslashes(trim($_POST['discount_percentage']));
		$refundable = addslashes(trim($_POST['refundable']));
		$lastminute_deal = addslashes(trim($_POST['lastminute_deal']));
		$lastminute_threshold = addslashes(trim($_POST['lastminute_threshold']));
		$lastminute_discount_rate = addslashes(trim($_POST['lastminute_discount_rate']));
		
       
			if($price_period == ''){
				$errmsg = base64_encode('Please Enter Price Period ');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			}
			if($wise_price == 0){
				$threshold = 0;
				$discount_percentage = 0;
			}else{
			if($wise_price !== 0 and $threshold == '' or !is_numeric($threshold) ){
				$errmsg = base64_encode('Please Enter Threshold with Integer Value');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			} 
			}
			if($lastminute_deal == 0){
				$lastminute_threshold = 0;
				$lastminute_discount_rate = 0;
			}else{
			if($lastminute_deal !== 0 and $lastminute_threshold == '' or !is_numeric($lastminute_threshold) ){
				$errmsg = base64_encode('Please Enter Lastminute Threshold With Numeric Value');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			}
			
			if($lastminute_discount_rate == '' or !is_numeric($lastminute_discount_rate) and $lastminute_deal !== 0 ){
				$errmsg = base64_encode('Please Enter Lastminute Discount Rate With Numeric Values');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			}
			}
			
			
              $insert_tariff_cal = "INSERT INTO ".$tblprefix."tariff_calculations  
										SET
										price_period ='".$price_period."',
										per_person =".$per_person.",
										wise_price =".$wise_price.",
										threshold =".$threshold.",
										discount_percentage =".$discount_percentage.",
											refundable =".$refundable.",
										lastminute_deal =".$lastminute_deal.",
										lastminute_threshold =".$lastminute_threshold.",
										lastminute_discount_rate =".$lastminute_discount_rate."
										";
										
				$rs_tariff = $db->Execute($insert_tariff_cal);
				
				$okmsg = base64_encode("Tariff Calculation Add successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_tariff_calculation");
					exit;				
	} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='manage_tariff_calculation' && $_POST['request_page']=='tariff_management'){
	    
		
        $price_period = addslashes(trim($_POST['price_period']));
		$per_person = addslashes(trim($_POST['per_person']));
		$wise_price = addslashes(trim($_POST['wise_price']));
		$threshold = addslashes(trim($_POST['threshold']));
		$discount_percentage = addslashes(trim($_POST['discount_percentage']));
		$refundable = addslashes(trim($_POST['refundable']));
		$lastminute_deal = addslashes(trim($_POST['lastminute_deal']));
		$lastminute_threshold = addslashes(trim($_POST['lastminute_threshold']));
		$lastminute_discount_rate = addslashes(trim($_POST['lastminute_discount_rate']));
        
		$id=$_POST['id'];
		if($price_period == ''){
				$errmsg = base64_encode('Please Enter Price Period ');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			}
			
			if($wise_price == 0){
				$threshold = 0;
				$discount_percentage = 0;
			}else{
			
			if($threshold == '' or !is_numeric($threshold)){
				$errmsg = base64_encode('Please Enter Threshold with Integer Value');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			 } 
			}
			
			if($lastminute_deal == 0){
				$lastminute_threshold = 0;
				$lastminute_discount_rate = 0;
			}else{
			
			if($lastminute_threshold == '' or !is_numeric($lastminute_threshold)){
				$errmsg = base64_encode('Please Enter Lastminute Threshold With Numeric Value');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
			}
			
			if($lastminute_discount_rate == '' or !is_numeric($lastminute_discount_rate)){
				$errmsg = base64_encode('Please Enter Lastminute Discount Rate With Numeric Values');
				header("Location: admin.php?act=manage_tariff_calculation&errmsg=$errmsg");
				exit;
	 	 	 }
	        }	
		
		
					$sql_tariff= "UPDATE ".$tblprefix."tariff_calculations 
														SET
															price_period ='".$price_period."',
															per_person =".$per_person.",
															wise_price =".$wise_price.",
															threshold =".$threshold.",
															discount_percentage =".$discount_percentage.",
															refundable =".$refundable.",
															lastminute_deal ='".$lastminute_deal."',
															lastminute_threshold =".$lastminute_threshold.",
															lastminute_discount_rate =".$lastminute_discount_rate."
															WHERE
															id=".$id;
															
				$rs_tariff = $db->Execute($sql_tariff);
				
					if($rs_tariff){
						$okmsg = base64_encode("Tariff Calculation Updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=manage_tariff_calculation");
						exit;	  
					}
			} 
	
	


	   
######################
#
# 	GET SECTION
#
######################

//---------Delete THe Tariff Calculation---------
if($_GET['mode']=='del_tariff' && $_GET['act']=='manage_tariff_calculation' && $_GET['request_page']=='tariff_management'){
		$id=base64_decode($_GET['id']);

		$del_qry = " DELETE FROM ".$tblprefix."tariff_calculations WHERE id = ".$id." ";
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Tariff Calculation Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_tariff_calculation");
					exit;	  
} 

?>
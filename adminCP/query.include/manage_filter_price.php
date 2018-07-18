<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='filter_price' && $_POST['request_page']=='manage_filter_price'){
        $price_rate = addslashes(trim($_POST['price_rate']));
				
			if($price_rate == ''){
				$errmsg = base64_encode('Please Enter Price Rate');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			
		 $insert_property_feature = "INSERT INTO ".$tblprefix."filter_price  
										SET
										price_rate = '".$price_rate."'
										";
				
		
		 		
				
										
				$rs_insert = $db->Execute($insert_property_feature);
				
				$okmsg = base64_encode("Price Rate Add successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				
	} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='edit_filter_price' && $_POST['request_page']=='manage_filter_price'){

	    $price_rate = addslashes(trim($_POST['price_rate']));
				
		$id=base64_decode($_POST['id']);
		$_SESSION[price_rate] = $price_rate;
		
		if($price_rate == ''){
				$errmsg = base64_encode('Please Enter Price Rate');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
		
		
				 	 	$sql_category= "UPDATE ".$tblprefix."filter_price 
														SET
									                    price_rate = '".$price_rate."'
														WHERE
														id=".$id;
														
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Price Rate Updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
			} 
	
	


	   
######################
#
# 	GET SECTION
#
######################

//---------Delete THe Category and its language contents---------
if($_GET['mode']=='delete' && $_GET['act']=='filter_price' && $_GET['request_page']=='manage_filter_price'){
		$id=base64_decode($_GET['id']);


		 $del_qry = " DELETE FROM ".$tblprefix."filter_price WHERE id = ".$id." "; 
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Price Rate Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 
		

?>
<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_region' && $_POST['request_page']=='region_management'){
        $region_name = addslashes(trim($_POST['region_name']));
				
			if($region_name == ''){
				//$errmsg = base64_encode('Please Enter Region Name');
				$errmsg = base64_encode('Molimo unesite naziv regiona');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
			
		 $insert_property_feature = "INSERT INTO ".$tblprefix."property_regions  
										SET
										region_name = '".$region_name."'
										";
				
		
		 		
				
										
				$rs_insert = $db->Execute($insert_property_feature);
				
				//$okmsg = base64_encode("Property Region Add successfully. !");
				$okmsg = base64_encode("Region uspješno dodat. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_region");
					exit;
				
	} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='editregion' && $_POST['request_page']=='region_management'){

	    $region_name = addslashes(trim($_POST['region_name']));
				
		$id=base64_decode($_POST['id']);
		$_SESSION[region_name] = $region_name;
		
		if($region_name == ''){
				//$errmsg = base64_encode('Please Enter Region Name');
				$errmsg = base64_encode('Molimo unesite naziv regiona');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
		
		
				 	 	$sql_category= "UPDATE ".$tblprefix."property_regions 
														SET
									                    region_name = '".$region_name."'
														WHERE
														id=".$id;
														
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						//$okmsg = base64_encode("Property Region Updated successfully. !");
						$okmsg = base64_encode("Region uspješno ažuriran. !");
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
if($_GET['mode']=='del_region' && $_GET['act']=='manage_region' && $_GET['request_page']=='region_management'){
		$id=base64_decode($_GET['id']);


		 $del_qry = " DELETE FROM ".$tblprefix."property_regions WHERE id = ".$id." ";
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		//$okmsg = base64_encode("Property Region Deleted successfully. !");
		$okmsg = base64_encode("Region uspješno izbrisan. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_region");
					exit;	  
} 
		
//---------Service Provider Status---------		
		 
		
		

?>
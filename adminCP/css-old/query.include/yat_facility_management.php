<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_yat_facility' && $_POST['request_page']=='yat_facility_management'){
	
	        $facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
			
		
		
			if($facility_name == ''){
				$errmsg = base64_encode('Please Enter Yacht Faclity  Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			if($property_fac_category == 0){
				$errmsg = base64_encode('Please Select The Category ');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	  $sql_category= "INSERT INTO ".$tblprefix."yatfacility_management 
														SET
														facility_name = '".$facility_name."',
														
														yat_fac_category =".$property_fac_category."
														";
           
			   
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					//$okmsg = base64_encode("Facility Added Successfully. !");
					$okmsg = base64_encode("Sadržaj uspješno dodat");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				      //$okmsg = base64_encode("Facility Not Added .!");
					  $okmsg = base64_encode("Sadržaj nije dodat");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='manage_yat_facility' && $_POST['request_page']=='yat_facility_management'){
			$facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
	 $id=base64_decode($_POST['id']);
	 	
			if($facility_name == ''){
				$errmsg = base64_encode('Please Enter Yacht Faclity  Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
			if($property_fac_category == 0){
				$errmsg = base64_encode('Please Select The Category ');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
		
			
			
			 $sql_category= "UPDATE ".$tblprefix."yatfacility_management 
														SET
														facility_name = '".$facility_name."',
														yat_fac_category =".$property_fac_category."
														WHERE
														id=".$id;
												
														
														
				$rs_category = $db->Execute($sql_category);
					if($rs_category){
						$okmsg = base64_encode("Facility Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=manage_yat_facility");
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Facility Is Not Updated!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_category' && $_GET['act']=='manage_yat_facility' && $_GET['request_page']=='yat_facility_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."yatfacility_management WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		$okmsg = base64_encode("Facility  Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_yat_facility");
					exit;	  
} 

?>
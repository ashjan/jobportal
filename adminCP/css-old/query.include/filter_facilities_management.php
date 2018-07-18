<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------


	if($_POST['mode']=='add' && $_POST['act']=='filter_facilities' && $_POST['request_page']=='filter_facilities_management'){
        $facilities_name = addslashes(trim($_POST['facilities_name']));
				
			if($facilities_name == ''){
				$errmsg = base64_encode('Please Enter Filter Facilities');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			
		  $insert_property_feature = "INSERT INTO ".$tblprefix."filter_facilities  
										SET
										facilities_name = '".$facilities_name."'
										";
				 
		$rs_insert = $db->Execute($insert_property_feature);
				
				
				if($rs_insert){
								$okmsg = base64_encode("Filter Facilities inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to add Filter Facilities in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
				
				
				
				
				} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='editfilter_facilities' && $_POST['request_page']=='filter_facilities_management'){

	    $facilities_name = addslashes(trim($_POST['facilities_name']));
				
		$id=base64_decode($_POST['id']);
		$_SESSION[facilities_name] = $facilities_name;
		
		if($facilities_name == ''){
				$errmsg = base64_encode('Please Enter Filter Facility Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
		
		
					 	$sql_category= "UPDATE ".$tblprefix."filter_facilities 
														SET
									                    facilities_name = '".$facilities_name."'
														WHERE
														id=".$id;
														
						$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
								$okmsg = base64_encode("Filter Facilities Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to Updated Filter Facilities in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
			} 
	
	


	   
######################
#
# 	GET SECTION
#
######################

//---------Delete THe Category and its language contents---------
if($_GET['mode']=='delete' && $_GET['act']=='filter_facilities' && $_GET['request_page']=='filter_facilities_management'){
		$id=base64_decode($_GET['id']);


		 $del_qry = " DELETE FROM ".$tblprefix."filter_facilities WHERE id = ".$id." ";
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Property Region Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 
		
	
		 
		
		

?>
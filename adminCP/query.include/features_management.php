<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='property_features' && $_POST['request_page']=='features_management'){
        $feature_title = addslashes(trim($_POST['feature_title']));
		$business_description = addslashes(trim($_POST['business_description']));
		$checkin_times = addslashes(trim($_POST['checkin_times']));
		$area_activities = addslashes(trim($_POST['area_activities']));
		$driving_directions = addslashes(trim($_POST['driving_directions']));
		$airports = addslashes(trim($_POST['airports']));
		$other_transports = addslashes(trim($_POST['other_transports']));
		$policies_disclaimer = addslashes(trim($_POST['policies_disclaimer']));
		
        if($feature_title == ''){
				$errmsg = base64_encode('Please Enter feature title');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
		
		
		
			if($business_description == ''){
				$errmsg = base64_encode('Please Enter Business Description Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			if($checkin_times == ''){
				$errmsg = base64_encode('Please Enter Ceckin Times Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			if($area_activities == ''){
				$errmsg = base64_encode('Please Enter Area Activities Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			if($driving_directions == ''){
				$errmsg = base64_encode('Please Enter Driving Directions Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			if($airports == ''){
				$errmsg = base64_encode('Please Enter Airports Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			} 
			if($other_transports == ''){
				$errmsg = base64_encode('Please Enter Other Transports Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			if($policies_disclaimer == ''){
				$errmsg = base64_encode('Please Enter Other Policies Disclaimer Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
		 $insert_property_feature = "INSERT INTO ".$tblprefix."property_features  
										SET
										feature_title = '".$feature_title."',
										business_description = '".$business_description."',
										checkin_times =".$checkin_times.",
										area_activities ='".$area_activities."',
										driving_directions ='".$driving_directions."',
										airports ='".$airports."',
										other_transports ='".$other_transports."',
										policies_disclaimer ='".$policies_disclaimer."'
										";
				
		
		 		
				
										
				$rs_insert = $db->Execute($insert_property_feature);
				
				$okmsg = base64_encode("Property Features Add successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=property_features");
					exit;
				
	} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='property_features' && $_POST['request_page']=='features_management'){

        $feature_title = addslashes(trim($_POST['feature_title']));
	    $business_description = addslashes(trim($_POST['business_description']));
		$checkin_times = addslashes(trim($_POST['checkin_times']));
		$area_activities = addslashes(trim($_POST['area_activities']));
		$driving_directions = addslashes(trim($_POST['driving_directions']));
		$airports = addslashes(trim($_POST['airports']));
		$other_transports = addslashes(trim($_POST['other_transports']));
		$policies_disclaimer = addslashes(trim($_POST['policies_disclaimer']));
		
		$id=base64_decode($_POST['id']);
		
		
		
		if($feature_title == ''){
				$errmsg = base64_encode('Please Enter feature title ');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
			
		if($business_description == ''){
				$errmsg = base64_encode('Please Enter Business Description Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			if($checkin_times == ''){
				$errmsg = base64_encode('Please Enter Ceckin Times Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			if($area_activities == ''){
				$errmsg = base64_encode('Please Enter Area Activities Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			if($driving_directions == ''){
				$errmsg = base64_encode('Please Enter Driving Directions Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			if($airports == ''){
				$errmsg = base64_encode('Please Enter Airports Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			} 
			if($other_transports == ''){
				$errmsg = base64_encode('Please Enter Other Transports Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			if($policies_disclaimer == ''){
				$errmsg = base64_encode('Please Enter Other Policies Disclaimer Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
		
		
				 	 	$sql_category= "UPDATE ".$tblprefix."property_features 
														SET
														feature_title = '".$feature_title."',
														business_description = '".$business_description."',
										                checkin_times ='".$checkin_times."',
														area_activities ='".$area_activities."',
														driving_directions ='".$driving_directions."',
														airports ='".$airports."',
														other_transports ='".$other_transports."',
														policies_disclaimer ='".$policies_disclaimer."'
														WHERE
														id=".$id;
														
														
				
					

				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Property Features Updated successfully. !");
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
if($_GET['mode']=='del_feature' && $_GET['act']=='property_features' && $_GET['request_page']=='features_management'){
		$id=base64_decode($_GET['id']);

		$del_qry = " DELETE FROM ".$tblprefix."property_features WHERE id = ".$id." ";
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Property Features Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=property_features");
					exit;	  
} 
		
//---------Service Provider Status---------		
		 
		
		

?>
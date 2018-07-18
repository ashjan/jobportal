<?php
error_reporting(E_ALL);
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act2']=='score_property' && $_POST['request_page']=='mngscore_property'){
	
        $resrvations = $_POST['resrvation_0'];
	 	$bookng = $_POST['bookingfreq_1'];
	 	$canclations = $_POST['canclfreg_2'];
	 	$availbility = $_POST['mavail_3'];
	 	$complaints = $_POST['custcomplain_4']; 
		
		$var0 = '0';
		$var1 = '1';
		$var2 = '2';
		$var3 = '3';
		$var4 = '4';
		
		
		$id= base64_decode($_POST['id']); 
		 
		if($resrvations == '' or !is_numeric($resrvations))
		{
				$errmsg = base64_encode('Please Enter valid rate for Resevations');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		  
		if($bookng == '' or !is_numeric($bookng))
		{
				$errmsg = base64_encode('Please Enter valid rate for Bookings');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		if($canclations == '' or !is_numeric($canclations))
		{
				$errmsg = base64_encode('Please Enter valid rate for Cancellations');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		if($availbility == '' or !is_numeric($availbility))
		{
				$errmsg = base64_encode('Please Enter valid rate for Availability');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		if($complaints == '' or !is_numeric($complaints))
		{
				$errmsg = base64_encode('Please Enter valid rate for Complaints');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		  
		  
		  
	  	$rs_query0 = "SELECT proprty_id FROM ".$tblprefix."admn_proprating where criteria_id = '".$var0."' and proprty_id='".$id."'"; 


		$rs_limit0=$db->execute($rs_query0);
		$count_add0 =  $rs_limit0->RecordCount(); 

		if($count_add0 == 0){  
							$insert_property_feature = "INSERT INTO ".$tblprefix."admn_proprating
							SET 										
							proprty_id = '".$id."',
							criteria_id = '0',
							rating = '".$resrvations."'"; 
							$rs_insert = $db->Execute($insert_property_feature);
							}else{
							$insert_property_feature = "UPDATE ".$tblprefix."admn_proprating  
							SET 										
							rating = '".$resrvations."' 
							where criteria_id = '0' AND proprty_id = '".$id."'"; 
							$insert_property_feature;
							$rs_insert = $db->Execute($insert_property_feature);
							}
					
		
		
		
		
		$rs_query1 = "SELECT proprty_id FROM ".$tblprefix."admn_proprating where criteria_id = '".$var1."' and proprty_id='".$id."'"; 
		$rs_limit1=$db->execute($rs_query1);
		$count_add1 =  $rs_limit1->RecordCount(); 
		
		
		if($count_add1 == 0){
							$insert_property_feature = "INSERT INTO ".$tblprefix."admn_proprating  													 							SET 										
							proprty_id = '".$id."',
							criteria_id = '1',
							rating = '".$bookng."'";
							$rs_insert = $db->Execute($insert_property_feature);
							}else{
							$insert_property_feature = "UPDATE ".$tblprefix."admn_proprating  
							SET 										
							rating = '".$bookng."' 
							where criteria_id = '1' AND proprty_id = '".$id."'"; 
							$rs_insert = $db->Execute($insert_property_feature);
							}
		$rs_query2 = "SELECT proprty_id FROM ".$tblprefix."admn_proprating where criteria_id = '".$var2."' and proprty_id='".$id."'"; 
		$rs_limit2=$db->execute($rs_query2);
		$count_add2 =  $rs_limit2->RecordCount();
		
		
		if($count_add2 == 0){
							$insert_property_feature2 = "INSERT INTO ".$tblprefix."admn_proprating
							SET 										
							proprty_id = '".$id."',
							criteria_id = '2',
							rating = '".$canclations."'"; 
							$rs_insert2 = $db->Execute($insert_property_feature2);
							}else{
							$insert_property_feature = "UPDATE ".$tblprefix."admn_proprating  
							SET 										
							rating = '".$canclations."' 
							where criteria_id = '2' AND proprty_id = '".$id."'";
							$rs_insert = $db->Execute($insert_property_feature);
							}
		$rs_query3 = "SELECT proprty_id FROM ".$tblprefix."admn_proprating where criteria_id = '".$var3."' and proprty_id='".$id."'"; 
		$rs_limit3=$db->execute($rs_query3);
		$count_add3 =  $rs_limit3->RecordCount();
		
		
		if($count_add3 == 0){
							$insert_property_feature = "INSERT INTO ".$tblprefix."admn_proprating
							SET 										
							proprty_id = '".$id."',
							criteria_id = '3',
							rating = '".$availbility."'"; 
							$rs_insert = $db->Execute($insert_property_feature);
							}else{
							$insert_property_feature = "UPDATE ".$tblprefix."admn_proprating  
							SET 										
							rating = '".$availbility."' 
							where criteria_id = '3' AND proprty_id = '".$id."'";  
							$rs_insert = $db->Execute($insert_property_feature);
							}
		$rs_query4 = "SELECT proprty_id FROM ".$tblprefix."admn_proprating where criteria_id = '".$var4."' and proprty_id=".$id."";
		$rs_limit4=$db->execute($rs_query4);
		$count_add4 =  $rs_limit4->RecordCount();
		
		
		if($count_add4 == 0){
							$insert_property_feature = "INSERT INTO ".$tblprefix."admn_proprating
							SET 										
							proprty_id = '".$id."',
							criteria_id = '4',
							rating = '".$complaints."'"; 
							$rs_insert = $db->Execute($insert_property_feature);
							}else{
							$insert_property_feature = "UPDATE ".$tblprefix."admn_proprating  
							SET 										
							rating = '".$complaints."' 
							where criteria_id = '4' AND proprty_id = '".$id."'"; 
							$rs_insert = $db->Execute($insert_property_feature);
							}
							
		$okmsg = base64_encode("Rating Added successfully!");
		header("Location: admin.php?okmsg=$okmsg&act=manage_properties");
		exit;
		} 
?>
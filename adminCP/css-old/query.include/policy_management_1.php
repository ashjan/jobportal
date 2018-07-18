<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

if($_POST['mode']=='add' && $_POST['act']=='manage_property_policy1' && $_POST['request_page']=='policy_management_1'){

	$_SESSION['add_sees'] = $_POST;
	
	$property_name = $_POST['property_name'];//changed property name to property id
	$first_name = $_POST['first_name'];
	$check_in_from = $_POST['check_in_from'];
	$check_in_until = $_POST['check_in_until'];
	$check_out_from = $_POST['check_out_from'];
	$check_out_until = $_POST['check_out_until'];

	if(strstr($check_in_from, "PM")=="PM"){
		$check_in_from1 = substr($check_in_from, 0, strlen($check_in_from)-3);
		$check_in_from1_minutes1 = explode(":", $check_in_from1);
		$check_in_from1 = $check_in_from+12;
		$check_in_from1 = $check_in_from1.':'.$check_in_from1_minutes1[1];
	}else{
		$check_in_from1 = substr($check_in_from, 0, strlen($check_in_from)-3);
	}


	if(strstr($check_in_until, "PM")=="PM"){
		$check_in_until1 = substr($check_in_until, 0, strlen($check_in_until)-3);
		$check_in_until1_minutes1 = explode(":", $check_in_until1);
		$check_in_until1 = $check_in_until+12;
		$check_in_until1 = $check_in_until1.':'.$check_in_until1_minutes1[1];
	}else{
		$check_in_until1 = substr($check_in_until, 0, strlen($check_in_until)-3);
	}




	if(strstr($check_out_until, "PM")=="PM"){
		$check_out_until1 = substr($check_out_until, 0, strlen($check_out_until)-3);
		$check_out_until1_minutes1 = explode(":", $check_out_until1);
		$check_out_until1 = $check_out_until+12;
		$check_out_until1 = $check_out_until1.':'.$check_out_until1_minutes1[1];
	}else{
		$check_out_until1 = substr($check_out_until, 0, strlen($check_out_until)-3);
	}


	if(strstr($check_out_from, "PM")=="PM"){
		$check_in_from1 = substr($check_out_from, 0, strlen($check_out_from)-3);
		$check_out_from1_minutes1 = explode(":", $check_out_from);
		$check_out_from1 = $check_out_from1+12;
		$check_out_from1 = $check_out_from1.':'.$check_out_from1_minutes1[1];
	}else{
		$check_out_from1 = substr($check_out_from, 0, strlen($check_out_from)-3);
	}


	$maximum_baby_cots = addslashes(trim($_POST['maximum_baby_cots']));
	$maximum_extra_beds = addslashes(trim($_POST['maximum_extra_beds']));
	//$children_capacity = addslashes(trim($_POST['children_capacity']));
	if($maximum_baby_cots == 0){
		$children_age = 0;
	}else {
		$children_age = addslashes(trim($_POST['children_age']));
	}


	if($maximum_extra_beds == 0){
		$children_age_beds=0;
		$extra_bed_charges = 0;
	}else {
		$extra_bed_charges = addslashes(trim($_POST['extra_bed_charges']));
		$children_age_beds = addslashes(trim($_POST['children_age_beds']));

	}
	$free_service = $_POST['free_services'];
	$count_free_service = count($free_service);
	if($count_free_service==0){

		$data_services = '';
	}else {
		$count_new_services=$count_free_service-1;
		for($i=0; $i<$count_free_service; $i++){
			if($count_new_services > $i){
				$data_services.= $free_service[$i].", ";
			}else{
				$data_services.=$free_service[$i];
			}
		}
	}

	$credit_card_accepted = $_POST['credit_card_accepted'];

	$count = count($credit_card_accepted);
	if(in_array(0,$credit_card_accepted)){
		$data = 0;
	}else {
		$count_new=$count-1;
		for($i=0; $i<$count; $i++){
			if($count_new > $i){
				$data.= $credit_card_accepted[$i].", ";
			}else{
				$data.=$credit_card_accepted[$i];
			}
		}
	}


//	$cancellation_charges_percent = addslashes(trim($_POST['cancellation_charges_percent']));
//	$cacellation_days = addslashes(trim($_POST['cacellation_days']));
	
	$cancellation_charges_percent = 0;
	$cacellation_days = 0;
	//$first_name = addslashes(trim($_POST['pm_id']));
	$no_show_policy = addslashes(trim($_POST['no_show_policy']));
	$break_fast = addslashes(trim($_POST['break_fast']));
	$meal_plan = addslashes(trim($_POST['meal_plan']));
	//$credit_card_accepted = addslashes(trim($_POST['credit_card_accepted']));
	$pay_deposit = addslashes(trim($_POST['pay_deposit']));
	$deposit_amount_percent = addslashes(trim($_POST['deposit_amount_percent']));
	$minimum_days_stay = addslashes(trim($_POST['minimum_days_stay']));
	$less_days_price = addslashes(trim($_POST['less_days_price']));
	$food_beverage = addslashes(trim($_POST['food_beverage']));
	
	$food_beverage_rus = addslashes(trim($_POST['food_beverage_rus']));
	$food_beverage_mon = addslashes(trim($_POST['food_beverage_mon']));
	
	$internetavailability = addslashes(trim($_POST['internet_available']));
		
	// Language internet type
	$internet_type = addslashes(trim($_POST['internet_type']));	
	$internet_type_rus = addslashes(trim($_POST['internet_type_rus']));
	$internet_type_mon = addslashes(trim($_POST['internet_type_mon']));
	
	$internet_cost = addslashes(trim($_POST['internet_cost']));
	
	// Language internet location
	$internet_location = addslashes(trim($_POST['internet_location']));
	$internet_location_rus = addslashes(trim($_POST['internet_location_rus']));
	$internet_location_mon = addslashes(trim($_POST['internet_location_mon']));
	
	$parking_available = addslashes(trim($_POST['parking_available']));
	
	// Language parking place
	$parking_place = addslashes(trim($_POST['parking_place']));	
	$parking_place_rus = addslashes(trim($_POST['parking_place_rus']));
	$parking_place_mon = addslashes(trim($_POST['parking_place_mon']));
	
	$parking_costs = addslashes(trim($_POST['parking_costs']));
	$pets_allowed = addslashes(trim($_POST['pets_allowed']));
	
	// Language important notice
	$important_notice = addslashes(trim($_POST['important_notice']));
	$important_notice_rus = addslashes(trim($_POST['important_notice_rus']));
	$important_notice_mon = addslashes(trim($_POST['important_notice_mon']));
	
	$check_in_from = mysql_real_escape_string( $check_in_from );
	$check_in_until = mysql_real_escape_string( $check_in_until );
	$check_out_from = mysql_real_escape_string( $check_out_from  );
	$check_out_untill = mysql_real_escape_string( $check_out_untill );
	
	
	if($property_name == ''){
			//$errmsg= base64_encode('Please Enter Property Name');
			$errmsg= base64_encode('Molimo unesite naziv objekta');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		
	if($first_name == ''){
			//$errmsg= base64_encode('Please Enter PM Name');
			$errmsg= base64_encode('Molim unesite ime vlasnika objekta');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		
	if($check_in_from == ''){
			//$errmsg= base64_encode('Please Enter Check IN From');
			$errmsg= base64_encode('Molimo unesite početno vrijeme prijavljivanja');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}		
		
	if($check_in_until == ''){
			//$errmsg= base64_encode('Please Enter Check IN Untill');
			$errmsg= base64_encode('Molimo unesite krajnje vrijeme prijavljivanja');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		
	if($check_out_from == ''){
			//$errmsg= base64_encode('Please Enter Check Out From');
			$errmsg= base64_encode('Molimo unesite početno vrijeme odjavljivanja');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		
	if($check_out_until == ''){
			//$errmsg= base64_encode('Please Enter Check Out Untill');
			$errmsg= base64_encode('Molimo unesite krajnje vrijeme odjavljivanja');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}			


	if($break_fast == '1')
	{
		/*if($meal_plan == '')
		{
		//$errmsg = base64_encode('Please select Meal Plan ');
		$errmsg = base64_encode('Dostupnost doručka ');
		header("Location: admin.php?act=manage_property_policy&errmsg=$errmsg");
		exit;
		}*/
	}
	else
	{
		$meal_plan = 1;
	}


	if($maximum_extra_beds !=0){
		if($extra_bed_charges == '' or !is_numeric($extra_bed_charges)){
			//$errmsg= base64_encode('Please Enter Extra Bed Charges with Integer Value');
			$errmsg= base64_encode('Cijena dodatnih kreveta mora biti numerička');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
	}
	if($pay_deposit==1)
	{
		if($deposit_amount_percent == '')
		{
			//$errmsg = base64_encode('Please Enter Deposit Amount Percent');
			$errmsg = base64_encode('Molimo unesite procenat depozita');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		elseif(!is_numeric($deposit_amount_percent))
		{
				//$errmsg = base64_encode('Please Enter Deposit Amount Percent Numeric Value ');
			$errmsg = base64_encode('Procenat depozita mora biti broj');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;

		}
		elseif($deposit_amount_percent<0 or $deposit_amount_percent>100)
		{
			//$errmsg = base64_encode('Please Enter Deposit Amount Percent Value Between 0 and 100');
			$errmsg = base64_encode('Procenat depozita mora biti od 0% do 100%');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
	}
	else
	{
		$deposit_amount_percent = "";
	}

	if($internetavailability == '1')
	{
		if($internet_type == '' or is_numeric($internet_type)){
			//$errmsg = base64_encode('Please Enter Internet Type With Character Value');
			$errmsg = base64_encode('Vrsta interneta ne može biti numerička');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		if($internet_cost == ''){
			//$errmsg = base64_encode('Please Enter Internet Cost');
			$errmsg = base64_encode('Molimo unesite cijenu interneta');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}elseif(!is_numeric($internet_cost))
		{
			//$errmsg = base64_encode('Please Enter Internet Cost Numeric Value');
			$errmsg = base64_encode('Cijena interneta mora da bude izražena brojevima');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;

		}
		if($internet_location == ''){
			//$errmsg = base64_encode('Please Enter Internet Location');
			$errmsg = base64_encode('Molimo unesite lokaciju interneta');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}elseif(is_numeric($internet_location))
		{
			//$errmsg = base64_encode('Please Enter Internet Location As Character Value');
			$errmsg = base64_encode('Lokacija internet ne može biti numerička');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;

		}

	}
	else
	{
		$internet_type = "";
		$internet_location = "";
		$internet_cost = "";
	}

	if($parking_available == '1')
	{
		if($parking_place == '' or is_numeric($parking_place)){
			//$errmsg = base64_encode('Please Enter Parking Place With Character Value');
			$errmsg = base64_encode('Mjesto parking ne može biti numerička');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
		if($parking_costs == '' or !is_numeric($parking_costs)){
			//$errmsg = base64_encode('Please Enter Parking Costs with Integer Value');
			$errmsg = base64_encode('Cijena parking mora biti numerička');
			header("Location: admin.php?act=manage_property_policy1&errmsg=$errmsg");
			exit;
		}
	}
	else
	{
		$parking_place = "";
		$parking_costs = "";
	}

	$check_in_from = mysql_real_escape_string( $check_in_from );
	$check_in_until = mysql_real_escape_string( $check_in_until );
	$check_out_from = mysql_real_escape_string( $check_out_from  );
	$check_out_until = mysql_real_escape_string( $check_out_until );



	if(strstr($check_in_from, "PM")=="PM"){
		$check_in_from1 = substr($check_in_from, 0, strlen($check_in_from)-3);
		$check_in_from1_minutes1 = explode(":", $check_in_from1);
		$check_in_from1 = $check_in_from+12;
		$check_in_from1 = $check_in_from1.':'.$check_in_from1_minutes1[1];
	}else{
		$check_in_from1 = substr($check_in_from, 0, strlen($check_in_from)-3);
	}







	if(strstr($check_in_until, "PM")=="PM"){
		$$check_in_until1 = substr($check_in_until, 0, strlen($check_in_until)-3);
		$check_in_until1_minutes1 = explode(":", $check_in_until1);
		$check_in_until1 = $check_in_until+12;
		$check_in_until1 = $check_in_until1.':'.$check_in_until1_minutes1[1];
	}else{
		$check_in_until1 = substr($check_in_until, 0, strlen($check_in_until)-3);
	}





	if(strstr($check_out_until, "PM")=="PM"){
		$$check_out_until1 = substr($check_out_until, 0, strlen($check_out_until)-3);
		$check_out_until1_minutes1 = explode(":", $check_out_until1);
		$check_out_until1 = $check_out_until+12;
		$check_out_until1 = $check_out_until1.':'.$check_out_until1_minutes1[1];
	}else{
		$check_out_until1 = substr($check_out_until, 0, strlen($check_out_until)-3);
	}








	if(strstr($check_out_from, "PM")=="PM"){
		$check_in_from1 = substr($check_out_from, 0, strlen($check_out_from)-3);
		$check_out_from1_minutes1 = explode(":", $check_out_from);
		$check_out_from1 = $check_out_from1+12;
		$check_out_from1 = $check_out_from1.':'.$check_out_from1_minutes1[1];
	}else{
		$check_out_from1 = substr($check_out_from, 0, strlen($check_out_from)-3);
	}





	if($check_in_from1>$check_in_until1){
		//$errmsg =base64_encode('Check-in-from must be less than check-in-untill');
		$errmsg =base64_encode('Početno vrijeme prijavljivanja mora biti manje od krajnjeg vremena za prijavljivanje');
	}


	if($check_in_from1 < $check_out_from1){
		//$errmsg =base64_encode('Check-out-from must be less than check-in-from');
		$errmsg =base64_encode('Početno vrijeme odjavljivanja mora biti manje od krajnjeg vremena odjavljivanja');
	}
	
	    $property_name_qry = "SELECT id,property_id,pm_id FROM ".$tblprefix."property_policy WHERE property_id=".$property_name." AND pm_id=".$first_name;
		$all_ready_exists = $db->Execute($property_name_qry);
		$rs_total_prop_exists=$all_ready_exists->RecordCount();
		if($rs_total_prop_exists >0){
		//$errmsg= base64_encode("This Property Policy All Ready Exists.Please Try Another One!");
		$errmsg= base64_encode("Politika objekta već postoji!");
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
		exit;
		
		}



	 	$insert_policy = "INSERT INTO ".$tblprefix."property_policy
										SET
										property_id = '".$property_name."',
										pm_id = ".$first_name.",
										check_in_from = '".$check_in_from."',
										check_in_until = '".$check_in_until."',
										check_out_from = '".$check_out_from."',
										free_service = '".$data_services."',
										check_out_until = '".$check_out_until."',
										maximum_baby_cots = '".$maximum_baby_cots."',
										maximum_extra_beds = '".$maximum_extra_beds."',
										cancellation_charges_percent = '".$cancellation_charges_percent."',
										cacellation_days = '".$cacellation_days."',
										no_show_policy = '".$no_show_policy."',
										children_age = '".$children_age."',
										extra_bed_charges = '".$extra_bed_charges."',
										break_fast = '".$break_fast."',
										meal_plan = '".$meal_plan."',
										credit_card_accepted = '".$data."',
										
										children_age_beds = ".$children_age_beds.",
										
										pay_deposit = '".$pay_deposit."',
										deposit_amount_percent = '".$deposit_amount_percent."',
										food_beverage ='".$food_beverage."',
										internet_available = '".$internetavailability."',
										internet_type ='".$internet_type."',
										internet_cost ='".$internet_cost."',
										internet_location ='".$internet_location."',
										parking_available = '".$parking_available."',
										parking_place = '".$parking_place."',
										parking_costs = '".$parking_costs."',
										pets_allowed = '".$pets_allowed."',
										important_notice ='".$important_notice."'
										";

 

	$rs_policy = $db->Execute($insert_policy);
	
	
	
	// insert for montenegro language
	$last_id = mysql_insert_id();

	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$last_id' AND `field_name` = 'food_beverage_mon' AND fld_type ='policy_foods'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
  $language_id=7;  // for montenegrin
		$update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_mon',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_mon)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id." 
				AND field_name='food_beverage_mon' 
				AND fld_type='policy_foods' 
				AND page_id='".$last_id."'
				";
				
		$rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}else{
 $language_id=7;  // for russian
		$insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_mon',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_mon)."',
				fld_type='policy_foods' ,
				language_id=".$language_id." ,
				page_id=".$last_id." 
				
				";
		$rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
	 
}

	
	
	// insert for russian language
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='".$last_id."' AND `field_name` = 'food_beverage_rus' AND fld_type ='policy_foods'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=5;  // for Russuan language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_rus',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_rus)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id."
				AND field_name='food_beverage_rus' 
				AND fld_type='policy_foods'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=5;  // for Russian language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_rus',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_rus)."',
				fld_type='policy_foods', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);		
}

	// insert for Russian language important notice
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='".$last_id."' AND `field_name` = 'important_notice_rus' AND fld_type ='policy_important_notice'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=5;  // for Russuan language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_rus',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_rus)."',
				fld_type='policy_important_notice' 
				WHERE language_id=".$language_id."
				AND field_name='important_notice_rus' 
				AND fld_type='policy_important_notice'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=5;  // for Russian language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_rus',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_rus)."',
				fld_type='policy_important_notice', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
		
}
	

	
	// insert for montenegro language important notice
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$last_id' AND `field_name` = 'important_notice_mon' AND fld_type ='policy_important_notice'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
  $language_id=7;  // for montenegrin
		$update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_mon',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_mon)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id." 
				AND field_name='important_notice_mon' 
				AND fld_type='policy_important_notice' 
				AND page_id='".$last_id."'
				";
				
		$rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}else{
 $language_id=7;  // for russian
		$insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_mon',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_mon)."',
				fld_type='policy_important_notice' ,
				language_id=".$language_id." ,
				page_id=".$last_id." 
				
				";
		$rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
	 
}
//-----------------------------------------------------------------

	
// insert for Russian language internet type
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='".$last_id."' AND `field_name` = 'internet_type_rus' AND fld_type ='policy_internet_type'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=5;  // for Russuan language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_rus',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_rus)."',
				fld_type='policy_internet_type' 
				WHERE language_id=".$language_id."
				AND field_name='internet_type_rus' 
				AND fld_type='policy_internet_type'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=5;  // for Russian language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_rus',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_rus)."',
				fld_type='policy_internet_type', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
		
}

// insert for montenegro language internet type
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='".$last_id."' AND `field_name` = 'internet_type_mon' AND fld_type ='policy_internet_type'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=7;  // for montenegro language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_mon',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_mon)."',
				fld_type='policy_internet_type' 
				WHERE language_id=".$language_id."
				AND field_name='internet_type_mon' 
				AND fld_type='policy_internet_type'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=7;  // for montenegro language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_rus',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_rus)."',
				fld_type='policy_internet_type', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
		
}

 
//-------------insert for Russian language internet location
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='".$last_id."' AND `field_name` = 'internet_location_rus' AND fld_type ='policy_internet_location'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=5;  // for Russuan language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_rus',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_rus)."',
				fld_type='policy_internet_location' 
				WHERE language_id=".$language_id."
				AND field_name='internet_location_rus' 
				AND fld_type='policy_internet_location'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=5;  // for Russian language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_rus',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_rus)."',
				fld_type='policy_internet_location', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
		
} 
 
// insert for montenegro language internet location
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='".$last_id."' AND `field_name` = 'internet_location_mon' AND fld_type ='policy_internet_location'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=7;  // for montenegro language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_mon',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_mon)."',
				fld_type='policy_internet_location' 
				WHERE language_id=".$language_id."
				AND field_name='internet_location_mon' 
				AND fld_type='policy_internet_location'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=7;  // for montenegro language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_mon',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_mon)."',
				fld_type='policy_internet_location', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
		
}
 
 
// --------------insert for Russian language parking place
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='".$last_id."' AND `field_name` = 'parking_place_rus' AND fld_type ='policy_parking_place'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
 	$language_id=5;  // for Russuan language
	 	$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_rus',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_rus)."',
				fld_type='policy_parking_place' 
				WHERE language_id=".$language_id."
				AND field_name='parking_place_rus' 
				AND fld_type='policy_parking_place'
				AND page_id='".$last_id."'
				";
	  
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}else{
 $language_id=5;  // for Russian language
	 	$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_rus',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_rus)."',
				fld_type='policy_parking_place', 
				language_id=".$language_id." ,
				page_id=".$last_id ." 
				
				";
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
		
} 
 
	// insert for montenegrin language
	$last_id = mysql_insert_id();

	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$last_id' AND `field_name` = 'parking_place_mon' AND fld_type ='policy_parking_place'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->totallang > 0){
  $language_id=7;  // for montenegrin
		$update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_mon',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_mon)."',
				fld_type='policy_parking_place' 
				WHERE language_id=".$language_id." 
				AND field_name='parking_place_mon' 
				AND fld_type='policy_parking_place' 
				AND page_id='".$last_id."'
				";
				
		$rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}else{

 $language_id=7;  // for montenegrin
		$insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_mon',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_mon)."',
				fld_type='policy_parking_place' ,
				language_id=".$language_id." ,
				page_id=".$last_id." 				
				";
		$rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
	 
} 
	
	
	
unset($_SESSION['add_sees']);

	if($rs_policy){
		//$okmsg = base64_encode("Property Policy Add successfully.!");
		$okmsg = base64_encode("Politika objekta uspješno dodata.!");
		header("Location: admin.php?okmsg=$okmsg&act=manage_property_policy1");
		exit;
	}else{
		//$errmsg.= base64_encode("Unable to Add Property Policy!");
		$errmsg.= base64_encode("Politika objekta nije dodata!");
		header("Location: admin.php?errmsg=$errmsg&act=manage_property_policy1");
		exit;

	}
}
//---------Edit Category---------
if($_POST['mode']=='update' && $_POST['act']=='manage_property_policy1' && $_POST['request_page']=='policy_management_1'){
	 
	$id = base64_decode($_POST['id']);
	if(isset($_POST['property_name'])){
		$property_name = $_POST['property_name'];
	}else {
	$property_name = $_POST['property_id'];
	}
	$first_name = addslashes(trim($_POST['pm_id']));
	$check_in_from = $_POST['check_in_from'];
	$check_in_until = $_POST['check_in_until'];
	$check_out_from = $_POST['check_out_from'];
	$check_out_until = $_POST['check_out_until'];

	if(strstr($check_in_from, "PM")=="PM"){
		$check_in_from1 = substr($check_in_from, 0, strlen($check_in_from)-3);
		$check_in_from1_minutes1 = explode(":", $check_in_from1);
		$check_in_from1 = $check_in_from+12;
		$check_in_from1 = $check_in_from1.':'.$check_in_from1_minutes1[1];
	}else{
		$check_in_from1 = substr($check_in_from, 0, strlen($check_in_from)-3);
	}




	if(strstr($check_in_until, "PM")=="PM"){
		$check_in_until1 = substr($check_in_until, 0, strlen($check_in_until)-3);
		$check_in_until1_minutes1 = explode(":", $check_in_until1);
		$check_in_until1 = $check_in_until+12;
		$check_in_until1 = $check_in_until1.':'.$check_in_until1_minutes1[1];
	}else{
		$check_in_until1 = substr($check_in_until, 0, strlen($check_in_until)-3);
	}





	if(strstr($check_out_until, "PM")=="PM"){
		$check_out_until1 = substr($check_out_until, 0, strlen($check_out_until)-3);
		$check_out_until1_minutes1 = explode(":", $check_out_until1);
		$check_out_until1 = $check_out_until+12;
		$check_out_until1 = $check_out_until1.':'.$check_out_until1_minutes1[1];
	}else{
		$check_out_until1 = substr($check_out_until, 0, strlen($check_out_until)-3);
	}








	if(strstr($check_out_from, "PM")=="PM"){
		$check_in_from1 = substr($check_out_from, 0, strlen($check_out_from)-3);
		$check_out_from1_minutes1 = explode(":", $check_out_from);
		$check_out_from1 = $check_out_from1+12;
		$check_out_from1 = $check_out_from1.':'.$check_out_from1_minutes1[1];
	}else{
		$check_out_from1 = substr($check_out_from, 0, strlen($check_out_from)-3);
	}




	$maximum_baby_cots = addslashes(trim($_POST['maximum_baby_cots']));
	$maximum_extra_beds = addslashes(trim($_POST['maximum_extra_beds']));
	
	if($maximum_baby_cots == 0){
		$children_age = 0;
	}else {
		$children_age = addslashes(trim($_POST['children_age']));
	}
	if($maximum_extra_beds == 0){
		$children_age_beds=0;
		$extra_bed_charges = 0;
	}else {
		$extra_bed_charges = addslashes(trim($_POST['extra_bed_charges']));
		$children_age_beds = addslashes(trim($_POST['children_age_beds']));
	}
	$free_service = $_POST['free_services'];
	$count_free_service = count($free_service);
	if($count_free_service==0){

		$data_services = '';
	}else {

		$count_new_services=$count_free_service-1;
		for($i=0; $i<$count_free_service; $i++){
			if($count_new_services > $i){
				$data_services.= $free_service[$i].", ";
			}else{
				$data_services.=$free_service[$i];
			}
		}
	}


	$credit_card_accepted = $_POST['credit_card_accepted'];

	$count = count($credit_card_accepted);

	if(in_array(0,$credit_card_accepted)){
		$data = 0;
	}else {
		$count_new=$count-1;
		for($i=0; $i<$count; $i++){
			if($count_new > $i){
				$data.= $credit_card_accepted[$i].", ";
			}else{
				$data.=$credit_card_accepted[$i];
			}
		}
	}


	//$children_capacity = addslashes(trim($_POST['children_capacity']));
	$cancellation_charges_percent =0;
//	 addslashes(trim($_POST['cancellation_charges_percent']));
	$cacellation_days = 0;
//	addslashes(trim($_POST['cacellation_days']));
	$no_show_policy = addslashes(trim($_POST['no_show_policy']));
	$break_fast = addslashes(trim($_POST['break_fast']));
	$meal_plan = addslashes(trim($_POST['meal_plan']));
	//$credit_card_accepted = addslashes(trim($_POST['credit_card_accepted']));
	$pay_deposit = addslashes(trim($_POST['pay_deposit']));
	$deposit_amount_percent = $_POST['deposit_amount_percent'];
	$food_beverage = addslashes(trim($_POST['food_beverage']));
	$food_beverage_mon = addslashes(trim($_POST['food_beverage_mon']));
	$food_beverage_rus = addslashes(trim($_POST['food_beverage_rus']));
	$internetavailability = addslashes(trim($_POST['internet_available']));
	$children_age_beds = addslashes(trim($_POST['children_age_beds']));

	// Language internet type
	$internet_type = addslashes(trim($_POST['internet_type']));
	$_SESSION['internet_type'] = trim($_POST['internet_type']);
	
	$internet_type_rus = addslashes(trim($_POST['internet_type_rus']));
	$_SESSION['internet_type_rus'] = trim($_POST['internet_type_rus']);
	
	$internet_type_mon = addslashes(trim($_POST['internet_type_mon']));
	$_SESSION['internet_type_mon'] = trim($_POST['internet_type_mon']);	
	
	$internet_cost = addslashes(trim($_POST['internet_cost']));
	
	// Language internet location
	$internet_location = addslashes(trim($_POST['internet_location']));
	$_SESSION['internet_location'] = trim($_POST['internet_location']);
		
	$internet_location_rus = addslashes(trim($_POST['internet_location_rus']));
	$_SESSION['internet_location_rus'] = trim($_POST['internet_location_rus']);
	
	$internet_location_mon = addslashes(trim($_POST['internet_location_mon']));
	$_SESSION['internet_location_mon'] = trim($_POST['internet_location_mon']);
	
	$parking_available = addslashes(trim($_POST['parking_available']));
	
	// Language parking place
	$parking_place = addslashes(trim($_POST['parking_place']));
	$_SESSION['parking_place'] = trim($_POST['parking_place']);
		
	$parking_place_rus = addslashes(trim($_POST['parking_place_rus']));
	$_SESSION['parking_place_rus'] = trim($_POST['parking_place_rus']);
	
	$parking_place_mon = addslashes(trim($_POST['parking_place_mon']));
	$_SESSION['parking_place_mon'] = trim($_POST['parking_place_mon']);
	
	$parking_costs = addslashes(trim($_POST['parking_costs']));
	$pets_allowed = addslashes(trim($_POST['pets_allowed']));
	$important_notice = addslashes(trim($_POST['important_notice']));
	
	// Language
	$important_notice_rus = addslashes(trim($_POST['important_notice_rus']));
	$important_notice_mon = addslashes(trim($_POST['important_notice_mon']));
	$id=base64_decode($_POST['id']);
	if($maximum_extra_beds !=0){
		if($children_age_beds == '' or !is_numeric($children_age_beds)){
			//$errmsg = base64_encode('Please Enter Children Age Extra Bed Charges with Integer Value');
			$errmsg = base64_encode('Molimo unesite djece od Dodatni ležaj naplaćuje s Integer Value');
			header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
			exit;
			if($extra_bed_charges == '' or !is_numeric($extra_bed_charges)){
				//$errmsg = base64_encode('Please Enter Extra Bed Charges with Integer Value');
				$errmsg = base64_encode('Cijena dodatnih kreveta mora biti numerička');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}
		}

}

		if($property_name == ''){
			//$errmsg = base64_encode('Please Enter Property Name');
			$errmsg = base64_encode('Molimo unesite naziv objekta');
			header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
			exit;
		}
		
	if($first_name == ''){
			//$errmsg = base64_encode('Please Enter PM Name');
			$errmsg = base64_encode('Molim unesite ime vlasnika objekta');
			header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
			exit;
		}
		
	if($check_in_from == ''){
			//$errmsg = base64_encode('Please Enter Check IN From');
			$errmsg = base64_encode('Molimo unesite početno vrijeme prijavljivanja');
			header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
			exit;
		}		
		
	if($check_in_until == ''){
			//$errmsg = base64_encode('Please Enter Check IN Untill');
			$errmsg = base64_encode('Molimo unesite krajnje vrijeme prijavljivanja');
			header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
			exit;
		}
		
	if($check_out_from == ''){
			//$errmsg = base64_encode('Please Enter Check Out From');
			$errmsg = base64_encode('Molimo unesite početno vrijeme odjavljivanja');
			header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
			exit;
		}
		
	if($check_out_until == ''){
			//$errmsg = base64_encode('Please Enter Check Out Untill');
			$errmsg = base64_encode('Molimo unesite početno vrijeme odjavljivanja');
			header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
			exit;
		}

		if($pay_deposit == '1'){
			if($deposit_amount_percent == ''){
			//$errmsg = base64_encode('Please Enter Deposit Amount Percent ');
				$errmsg = base64_encode('Molimo unesite procenat depozita');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}elseif(!is_numeric($deposit_amount_percent)){
				//$errmsg = base64_encode('Please Enter Deposit Amount Percent Numeric Value');
				$errmsg = base64_encode('Procenat depozita mora biti broj');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;

			}elseif($deposit_amount_percent < 0 or $deposit_amount_percent > 100){
				//$errmsg = base64_encode('Please Enter Deposit Amount Percent Value Between 0 and 100 ');
				$errmsg = base64_encode('Procenat depozita mora biti od 0% do 100%.');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;

			}


		}
		else
		{
			$deposit_amount_percent = "";
		}


		if($internetavailability == '1')
		{
			if($internet_type == '' or is_numeric($internet_type)){
				//$errmsg = base64_encode('Please Enter Internet Type With Character Value');
				$errmsg = base64_encode('Vrsta interneta ne može biti numerička');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}
			if($internet_cost == '' or !is_numeric($internet_cost)){
				//$errmsg = base64_encode('Please Enter Internet Cost With Integer Value');
				$errmsg = base64_encode('Molimo unesite cijenu interneta');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}
			if($internet_location == '' or is_numeric($internet_location)){
				//$errmsg = base64_encode('Please Enter Internet Location With Character Value');	
				$errmsg = base64_encode('Lokacija internet ne može biti numerička');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}

		}
		else
		{
			$internet_type = "";
			$internet_location = "";
			$internet_cost = "";
		}

		if($parking_available == '1')
		{
			if($parking_place == '' or is_numeric($parking_place)){
				//$errmsg = base64_encode('Please Enter Parking Place With Character Value');
				$errmsg = base64_encode('Mjesto parking ne može biti numerička');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}
			if($parking_costs == '' or !is_numeric($parking_costs)){
				//$errmsg = base64_encode('Please Enter Parking Costs with Integer Value');
				$errmsg = base64_encode('Cijena parking mora biti numerička');
				header("Location: admin.php?act=editpolicy1&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}
		}
		else
		{
			$parking_place = "";
			$parking_costs = "";
		}
		
		
		
		$property_name_qry = "SELECT id FROM ".$tblprefix."property_policy WHERE property_id=".$property_name." AND pm_id=".$first_name." AND id!=".$id;
		$all_ready_exists = $db->Execute($property_name_qry);
		$rs_total_prop_exists=$all_ready_exists->RecordCount();
		if($rs_total_prop_exists >0){
		//$errmsg.= base64_encode("This Property Policy All Ready Exists.Please Try Another One!");
		$errmsg.= base64_encode("Ova politika nekretnine Već Exists.Please Probajte još jedan!");
		header("Location:admin.php?act=editpolicy1&errmsg=".$errmsg."&id=".base64_encode($id));
		exit;
		
		}else{
		$sql_policy= "UPDATE ".$tblprefix."property_policy
															SET
															property_id = '".$property_name."',
															pm_id = '".$first_name."',
															check_in_from ='".$check_in_from."',
															free_service = '".$data_services."',
															check_in_until ='".$check_in_until."',
															check_out_from ='".$check_out_from."',
															check_out_until ='".$check_out_until."',
															maximum_baby_cots ='".$maximum_baby_cots."',
															maximum_extra_beds ='".$maximum_extra_beds."',
															cancellation_charges_percent = '".$cancellation_charges_percent."',
															cacellation_days = '".$cacellation_days."',
															no_show_policy = '".$no_show_policy."',
															children_age ='".$children_age."',
															children_age_beds ='".$children_age_beds."',
															extra_bed_charges ='".$extra_bed_charges."',
															break_fast ='".$break_fast."',
															meal_plan ='".$meal_plan."',
															credit_card_accepted ='".$data."',
															pay_deposit ='".$pay_deposit."',
															deposit_amount_percent ='".$deposit_amount_percent."',
															food_beverage ='".$food_beverage."',
															internet_available = '".$internetavailability."',
															internet_type ='".$internet_type."',
															internet_cost ='".$internet_cost."',
															internet_location ='".$internet_location."',
															parking_available ='".$parking_available."',
															parking_place ='".$parking_place."',
															parking_costs ='".$parking_costs."',
															pets_allowed ='".$pets_allowed."',
															important_notice ='".$important_notice."'
															WHERE
															id=".$id;
														
						$rs_policy = $db->Execute($sql_policy);
						
					
				
					
					
						
						
/*			$language_id=5;  // for russian
	 	 $update_russ_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_rus',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_rus)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='food_beverage_rus' 
				AND fld_type='policy_foods'
				";
		$rs_upd_russ_lang_fld = $db->Execute($update_russ_fld);
		
		
		$language_id=7;  // for Montenegrin language
		 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_mon',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_mon)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='food_beverage_mon' 
				AND fld_type='policy_foods'
				";

		$rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);	*/	
		
		
		
		
		
	

	
	
	// insert for montenegro language for offline
	//$last_id = mysql_insert_id();
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'food_beverage_mon' AND fld_type ='policy_foods'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0)
{
 	$language_id=7;  // for Montenegrin language for offline
	 	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_mon',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_mon)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id." 
				AND field_name='food_beverage_mon' 
				AND fld_type='policy_foods'
				";

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}
else
{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_mon',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_mon)."',
				fld_type='policy_foods' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}
		
		
		
	// insert for montenegro language for offline
	//$last_id = mysql_insert_id();
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` = 'food_beverage_rus' AND fld_type ='policy_foods'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Montenegrin language for offline
	 	
		 $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_rus',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_rus)."',
				fld_type='policy_foods' 
				WHERE language_id=".$language_id." 
				AND field_name='food_beverage_rus' 
				AND fld_type='policy_foods'
				";

	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}
else
{

 $language_id=5;  // for Montenegrin language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='food_beverage_rus',
				translation_text ='".addslashes($food_beverage)."',
				translated_text ='".addslashes($food_beverage_rus)."',
				fld_type='policy_foods' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";

				
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
	
	 
}

//------------------------- Waqas ------------------------------

	// insert for montenegro language for offline
	//$last_id = mysql_insert_id();
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'important_notice_mon' AND fld_type ='policy_important_notice'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0)
{
 	$language_id=7;  // for Montenegrin language for offline
	 	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_mon',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_mon)."',
				fld_type='policy_important_notice' 
				WHERE language_id=".$language_id." 
				AND field_name='important_notice_mon' 
				AND fld_type='policy_important_notice'
				";

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}
else
{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_mon',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_mon)."',
				fld_type='policy_important_notice' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}

// insert for Russian language for offline Russian
	//$last_id = mysql_insert_id();
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` = 'important_notice_rus' AND fld_type ='policy_important_notice'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Russian language for offline
	 	
		 $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_rus',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_rus)."',
				fld_type='policy_important_notice' 
				WHERE language_id=".$language_id." 
				AND field_name='important_notice_rus' 
				AND fld_type='policy_important_notice'
				";

	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}
else
{

 $language_id=5;  // for Russian language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='important_notice_rus',
				translation_text ='".addslashes($important_notice)."',
				translated_text ='".addslashes($important_notice_rus)."',
				fld_type='policy_important_notice' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";				
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);	 
}

//----------------------------------------------------------------------------


//-- insert for Russian language for offline Internet Type 
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` ='internet_type_rus' AND fld_type ='policy_internet_type'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Russian language for offline
	 	
		 $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_rus',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_rus)."',
				fld_type='policy_internet_type' 
				WHERE language_id=".$language_id." 
				AND field_name='internet_type_rus' 
				AND fld_type='policy_internet_type'
				";
			
	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}
else
{

 $language_id=5;  // for Russian language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_rus',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_rus)."',
				fld_type='policy_internet_type' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";				
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);	
}


//--- insert for montenegro language for offline Internet Type
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'internet_type_mon' AND fld_type ='policy_internet_type'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0)
{
 	$language_id=7;  // for Montenegrin language for offline
	 	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_mon',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_mon)."',
				fld_type='policy_internet_type' 
				WHERE language_id=".$language_id." 
				AND field_name='internet_type_mon' 
				AND fld_type='policy_internet_type'
				";
				
			

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}
else
{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_type_mon',
				translation_text ='".addslashes($internet_type)."',
				translated_text ='".addslashes($internet_type_mon)."',
				fld_type='policy_internet_type' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
				
			
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}

//-- insert for Russian language for offline Internet Location
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` = 'internet_location_rus' AND fld_type ='policy_internet_location'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Russian language for offline
	 	
		 $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_rus',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_rus)."',
				fld_type='policy_internet_location' 
				WHERE language_id=".$language_id." 
				AND field_name='internet_location_rus' 
				AND fld_type='policy_internet_location'
				";

	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}
else
{

 $language_id=5;  // for Russian language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_rus',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_rus)."',
				fld_type='policy_internet_location' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";				
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);	 
}


//--- insert for montenegro language for offline Internet Location
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'internet_location_mon' AND fld_type ='policy_internet_location'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0)
{
 	$language_id=7;  // for Montenegrin language for offline
	 	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_mon',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_mon)."',
				fld_type='policy_internet_location' 
				WHERE language_id=".$language_id." 
				AND field_name='internet_location_mon' 
				AND fld_type='policy_internet_location'
				";

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}
else
{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='internet_location_mon',
				translation_text ='".addslashes($internet_location)."',
				translated_text ='".addslashes($internet_location_mon)."',
				fld_type='policy_internet_location' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}

///

//-- insert for Russian language for offline Parking Place
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='5' AND  `page_id`='$id' AND `field_name` = 'parking_place_rus' AND fld_type ='policy_parking_place'";
$all_ready_exists = $db->Execute($property_name_qry);
if($all_ready_exists->fields['totallang'] > 0)
{
	$language_id=5;  // for Russian language for offline
	 	
		 $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_rus',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_rus)."',
				fld_type='policy_parking_place' 
				WHERE language_id=".$language_id." 
				AND field_name='parking_place_rus' 
				AND fld_type='policy_parking_place'
				";

	    $rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
}
else
{

 $language_id=5;  // for Russian language for offline
	
	 	 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_rus',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_rus)."',
				fld_type='policy_parking_place' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";				
	    $rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);	 
}


//--- insert for montenegro language for offline Parking Place
	
	$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE  
 `language_id`='7' AND  `page_id`='$id' AND `field_name` = 'parking_place_mon' AND fld_type ='policy_parking_place'";
$all_ready_exists = $db->Execute($property_name_qry);

if($all_ready_exists->fields['totallang'] > 0)
{
 	$language_id=7;  // for Montenegrin language for offline
	 	 $update_mon_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_mon',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_mon)."',
				fld_type='policy_parking_place' 
				WHERE language_id=".$language_id." 
				AND field_name='parking_place_mon' 
				AND fld_type='policy_parking_place'
				";

				
	    $rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
}
else
{
 $language_id=7;  // for Montenegrin language for offline
	 	 $insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
                SET
				field_name ='parking_place_mon',
				translation_text ='".addslashes($parking_place)."',
				translated_text ='".addslashes($parking_place_mon)."',
				fld_type='policy_parking_place' ,
				language_id=".$language_id." ,
				page_id=".$id."
				";
	    $rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
}


		
if($rs_policy ){
	
		//$okmsg = base64_encode("Property Policy Updated successfully. !");
		$okmsg = base64_encode("Politika objekta uspješno ažurirana. !");
		header("Location: admin.php?okmsg=$okmsg&act=manage_property_policy1 ");
		exit;

	}else{
			//$errmsg.= base64_encode("Unable to Update Property Policy!");
		$errmsg.= base64_encode("Politika objekta nije ažurirana!");
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
		exit;

	}
	}
}

######################
#
# 	GET SECTION
#
######################

//---------Delete THe Tariff Calculation---------
if($_GET['mode']=='del_policy' && $_GET['act']=='manage_property_policy1' && $_GET['request_page']=='policy_management_1'){
 	$id=base64_decode($_GET['id']);  

	$del_qry = " DELETE FROM ".$tblprefix."property_policy WHERE id = ".$id." ";
	$rs_del = $db->Execute($del_qry);

	$language_id=5;  // for russian
		 $del_qry1= "DELETE FROM ".$tblprefix."language_contents 
				WHERE language_id=".$language_id." 
				AND page_id=".$id."
				AND fld_type='policy_foods'
				";
	$rs_del1 = $db->Execute($del_qry1);

	
	$language_id=7; // Montenegro 
	$del_qry2= "DELETE FROM ".$tblprefix."language_contents  
		   WHERE language_id=".$language_id." 
			AND page_id=".$id." 
			AND fld_type='policy_foods'
			";
	$rs_del2 = $db->Execute($del_qry2);
	
	 //-------------------------- Important Notice ------------------------------
	 
	 $language_id=5;  // for Russian
	 $del_qry1= "DELETE FROM ".$tblprefix."language_contents 
		WHERE language_id=".$language_id." 
		AND page_id=".$id."
		AND fld_type='policy_important_notice'
		";
     $rs_del1 = $db->Execute($del_qry1);

	
	 $language_id=7; // Montenegro 
	 $del_qry2= "DELETE FROM ".$tblprefix."language_contents  
               WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND fld_type='policy_important_notice'
				";
      $rs_del2 = $db->Execute($del_qry2); 
	 
	  
	 //-------------------------- Internet type------------------------------
	 
	 $language_id=5;  // for Russian
	 $del_qry1= "DELETE FROM ".$tblprefix."language_contents 
		WHERE language_id=".$language_id." 
		AND page_id=".$id."
		AND fld_type='policy_internet_type'
		";
     $rs_del1 = $db->Execute($del_qry1);

	
	 $language_id=7; // Montenegro 
	 $del_qry2= "DELETE FROM ".$tblprefix."language_contents  
               WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND fld_type='policy_internet_type'
				";
      $rs_del2 = $db->Execute($del_qry2); 
	  
	  //-------------------------- Internet Location------------------------------
	 
	 $language_id=5;  // for Russian
	 $del_qry1= "DELETE FROM ".$tblprefix."language_contents 
		WHERE language_id=".$language_id." 
		AND page_id=".$id."
		AND fld_type='policy_internet_location'
		";
     $rs_del1 = $db->Execute($del_qry1);

	
	 $language_id=7; // Montenegro 
	 $del_qry2= "DELETE FROM ".$tblprefix."language_contents  
               WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND fld_type='policy_internet_location'
				";
      $rs_del2 = $db->Execute($del_qry2);  
	  
	
	 //-------------------------- Parking Place   ---------------------
	 
	 $language_id=5;  // for Russian
	 $del_qry1= "DELETE FROM ".$tblprefix."language_contents 
		WHERE language_id=".$language_id." 
		AND page_id=".$id."
		AND fld_type='policy_parking_place'
		";
     $rs_del1 = $db->Execute($del_qry1);

	
	 $language_id=7; // Montenegro 
	 $del_qry2= "DELETE FROM ".$tblprefix."language_contents  
               WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND fld_type='policy_parking_place'
				";
      $rs_del2 = $db->Execute($del_qry2);

		//$okmsg = base64_encode("Property Policy Deleted successfully. !");
		$okmsg = base64_encode("Politika objekta uspješno izbrisana!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
}else{
		//$errmsg.= base64_encode("Unable To Deleted Property Policy!");
		$errmsg.= base64_encode("Politika objekta nije izbrisana!");
		header("Location: admin.php?errmsg=$errmsg&act=".$_GET['act']);
		exit;

}

?>
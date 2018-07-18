<?php
// A D D      R O O M    R A T E S     M A N A G E M E N T
if($_POST['mode']=='overview_rates' && $_POST['act']=='manage_rates_overview' && $_POST['request_page']=='manage_rates_overview'){
	$post=$_POST;
	$error='';

	$start_date= base64_encode($post['start_date']);
	$end_date= base64_encode($post['end_date']);
	$property_id= base64_encode($post['property_id']);
	$pm_id= base64_encode($post['first_name']);

	$room_type= base64_encode($post['room_type']);

	if($post['first_name']==0){
		$error.='Please select PM.<br/>';
	}
	if($post['property_id']==0){
		//$error.='Please select Property<br/>';
		$error.='Molimo izaberite objekat<br/>';
	}


	/*if($post['start_date']==''){
	$error.="Please select the Start date<br/>";
	}
	if($post['end_date'] == ''){
	$error.="Please select the End Date<br/>";
	}*/
	$start_dates = strtotime($post['start_date']);
	$end_dates = strtotime($post['end_date']);
	if($end_dates<$start_dates){
		$error.='End date is less than start date<br/>';
	}


	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$post['act']);
	}else{
		$msg=base64_encode(" ");
		$standard_rate_from=base64_encode($_POST['standard_rate_from']);
		$standard_rate_to=base64_encode($_POST['standard_rate_to']);
		if($_POST['room_type']==0){
			header("Location: admin.php?okmsg=$msg&act=get_rates_overview2&id=$room_type&pm_id=$pm_id&stdt=$start_date&endt=$end_date"."&pr_id=".$property_id);
		}else {
		header("Location: admin.php?okmsg=$msg&act=get_rates_overview1&id=$room_type&pm_id=$pm_id&stdt=$start_date&endt=$end_date"."&pr_id=".$property_id);
		exit;
		}
	}
}

if($_POST['mode']=='update_room' && $_POST['act']=='manage_rates_overview' && $_POST['request_page']=='manage_rates_overview'){

	$post = $_POST;
	$pm_id = $_POST['value_pmi_d'];
	$property_id = $_POST['value_property_id'];
	$propertyroomid = $_POST['value_room_id'];
	$date_con = date("m/d/Y",($_POST['value_day']));
	$rate_id = $_POST['value_rate_id'];
	$rooms = $_POST['value_of_rooms'];
	$qry_select = "SELECT * FROM ".$tblprefix."standard_date WHERE standard_date='".$date_con."'
	AND pm_id='".$pm_id."' AND property_id='".$property_id."' AND room_type_id='".$propertyroomid."' AND rate_id=".$rate_id;
	if($post['value_pmi_d']==0){
		$error.='Please select PM.<br/>';
	}

	if($post['value_property_id']==0){
		//$error.='Please select Property<br/>';
		$error.='Molimo izaberite objekat<br/>';
	}

	/*if($post['start_date']==''){
	$error.="Please select the Start date<br/>";
	}


	if($post['end_date'] == ''){
	$error.="Please select the End Date<br/>";
	}*/
	$start_dates = strtotime($post['start_date']);
	$end_dates = strtotime($post['end_date']);
	if($end_dates<$start_dates){

		$error.='End date is less than start date<br/>';
	}

	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$post['act']);
	}else{

		$rs_select = $db->Execute($qry_select);
		$count_select =  $rs_select->RecordCount();
		if($count_select > 0){

			 $update_query = "UPDATE ".$tblprefix."standard_date
	                 SET
	                 no_of_rooms='".$rooms."'
	                 WHERE id='".$rs_select->fields['id']."' AND rate_id=".$rate_id."	                 
	                 ";


			$db->Execute($update_query);
		}else {
			//$date=date("m/d/Y",strtotime($date));
			 $insert_query = "INSERT ".$tblprefix."standard_date
	                 SET
	                 no_of_rooms='".$rooms."',
	                 standard_date='".$date_con."',
	                 room_type_id='".$propertyroomid."',
	                 property_id='".$property_id."',
	                 pm_id='".$pm_id."',
	                 rate_id=".$rate_id."
	                 ";

			$db->Execute($insert_query);
		}
		header("Location: admin.php?okmsg=$msg&act=get_rates_overview1&id=".base64_encode($propertyroomid)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}
}
if($_POST['mode']=='update_rate' && $_POST['act']=='manage_rates_overview' && $_POST['request_page']=='manage_rates_overview'){
	$error = '';
	$post = $_POST;
	
	$start_date = $_POST['change_rate_start_date'];
	$end_date = date("Y-m-d",strtotime($_POST['change_rate_end_date']));
	
	$rate_id = $post['change_standard_rate_id'];
	$propertyroomid = $post['change_room_id'];
	$property_id = $post['change_property_id'];
	$pm_id = $post['change_pm'];
    $ranges = DatesBetween($start_date,$end_date);
	$start_date =$post['change_date'];
	$end_date = $post['change_rate_end_date'];
	if($start_date=='')
	{
		$error='Start date is required<br/>';
	}
	if($end_date=='')
	{
		$error='End date is required<br/>';
	}
	
	$start_dates = strtotime($start_date);
	$end_dates = strtotime($end_date);
	if($end_dates<$start_dates){

		$error='End date is less than start date<br/>';
	}
	if($post['change_rate']=='')
	{
		$error = "Please enter price";
	}
	if($error!=''){

		$msg=base64_encode($error);

		header("Location: admin.php?okmsg=$msg&act=get_rates_overview1&id=".base64_encode($propertyroomid)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}else{

		$ranges = DatesBetween($start_date,$end_date);

		for($i=0;$i<count($ranges);$i++){
			   $query_update ="UPDATE ".$tblprefix."changed_standard_rates
	                 SET
	                 standard_rate_price=".$post['change_rate']."
	                 WHERE property_id=".$property_id."
	                 AND standard_date='".$ranges[$i]."'
	                 AND room_type_id=".$propertyroomid." 
	                 AND pm_id=".$pm_id."	                 
	                 ";
			  
			   $db->Execute($query_update);
		}

		//echo $insert_tariff_cal;exit();

		$rs_tariff = $db->Execute($insert_tariff_cal);
		$msg = base64_encode("You have successfully changed the rates");
		header("Location: admin.php?okmsg=$msg&act=get_rates_overview1&id=".base64_encode($propertyroomid)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}

}
if($_POST['mode']=='update_room' && $_POST['act']=='get_rates_overview1' && $_POST['request_page']=='manage_rates_overview'){
	$error = '';
	$post = $_POST;
	
	$no_of_rooms = $post['change_rooms_id'];
	$pm_id = $post['change_pm_id'];
	$propertyroomid = $post['change_room_type_id'];
	$property_id = $post['change_properties_id'];
	$rate_id = $post['change_rate_id'];
	$start_date = $post['change_room_start_date'];
	$end_date = date("Y-m-d",strtotime($post['change_room_end_date']));
	$start_dates = strtotime($start_date);
	$end_dates = strtotime($end_date);
	
	if($end_dates<$start_dates){

		$error='End date is less than start date<br/>';
	}
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	exit();*/
	/*for($i=0;$i<count($ranges);$i++)
	{
		$query = "INSERT INTO ".$tblprefix."changed_standard_rates (`property_id`, 
		`room_type_id`, 
		`pm_id`,
		`standard_date`,
		`standard_rate_price`,
		`standard_rate_id`)
		 VALUES ('173', '110', '172', '".$ranges[$i]."', '36', '181')";
		
		$db->Execute($query);
	}*/
	
	
	
	if($start_date=='')
	{
		$error='Start date is required<br/>';
	}
	if($end_date=='')
	{
		$error='End date is required<br/>';
	}
	
	
	
	if($no_of_rooms=='')
	{
		$error = "Please enter Number of rooms";
	}
	if($error!=''){

		$msg=base64_encode($error);

		header("Location: admin.php?okmsg=$msg&act=get_rates_overview1&id=".base64_encode($propertyroomid)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}else{
		
		$ranges = DatesBetween($start_date,$end_date);

		for($i=0;$i<count($ranges);$i++){
			   $query_update ="UPDATE ".$tblprefix."changed_standard_rates
	                 SET
	                 rooms_for_sale=".$no_of_rooms."
	                 WHERE property_id=".$property_id."
	                 AND standard_date='".$ranges[$i]."'
	                 AND room_type_id=".$propertyroomid."
	                 AND pm_id=".$pm_id." 	                 
	                 ";
			   $db->Execute($query_update);
		}

		
		$msg = base64_encode("You have successfully changed the rates");
		header("Location: admin.php?okmsg=$msg&act=get_rates_overview1&id=".base64_encode($propertyroomid)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}

}

/*** for all rooms***/
if($_POST['mode']=='update_rate1' && $_POST['act']=='manage_rates_overview' && $_POST['request_page']=='manage_rates_overview'){
	$error = '';
	$post = $_POST;
	
	$start_date = $_POST['change_rate_start_date'];
	$end_date = date("Y-m-d",strtotime($_POST['change_rate_end_date']));
	
	$rate_id = $post['change_standard_rate_id'];
	$propertyroomid = $post['change_room_id'];
	$property_id = $post['change_property_id'];
	$pm_id = $post['change_pm'];
    $ranges = DatesBetween($start_date,$end_date);
	$start_date =$post['change_date'];
	$end_date = $post['change_rate_end_date'];
	if($start_date=='')
	{
		$error='Start date is required<br/>';
	}
	if($end_date=='')
	{
		$error='End date is required<br/>';
	}
	
	$start_dates = strtotime($start_date);
	$end_dates = strtotime($end_date);
	if($end_dates<$start_dates){

		$error='End date is less than start date<br/>';
	}
	if($post['change_rate']=='')
	{
		$error = "Please enter price";
	}
	if($error!=''){

		$msg=base64_encode($error);
		$id = 0;

		header("Location: admin.php?okmsg=$msg&act=get_rates_overview2&id=".base64_encode($id)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}else{

		$ranges = DatesBetween($start_date,$end_date);

		for($i=0;$i<count($ranges);$i++){
			   $query_update ="UPDATE ".$tblprefix."changed_standard_rates
	                 SET
	                 standard_rate_price=".$post['change_rate']."
	                 WHERE property_id=".$property_id."
	                 AND standard_date='".$ranges[$i]."'
	                 AND room_type_id=".$propertyroomid." 
	                 AND pm_id=".$pm_id."	                 
	                 ";
		
			  
			   $db->Execute($query_update);
		}

		//echo $insert_tariff_cal;exit();

		$rs_tariff = $db->Execute($insert_tariff_cal);
		$id = 0;
		$msg = base64_encode("You have successfully changed the rates");
		header("Location: admin.php?okmsg=$msg&act=get_rates_overview2&id=".base64_encode($id)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}

}

if($_POST['mode']=='update_room1' && $_POST['act']=='get_rates_overview1' && $_POST['request_page']=='manage_rates_overview'){
	$error = '';
	$post = $_POST;
	
	$no_of_rooms = $post['change_rooms_id'];
	$pm_id = $post['change_pm_id'];
	$propertyroomid = $post['change_room_type_id'];
	$property_id = $post['change_properties_id'];
	$rate_id = $post['change_rate_id'];
	$start_date = $post['change_room_start_date'];
	$end_date = date("Y-m-d",strtotime($post['change_room_end_date']));
	$start_dates = strtotime($start_date);
	$end_dates = strtotime($end_date);
	
	if($end_dates<$start_dates){

		$error='End date is less than start date<br/>';
	}
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	exit();*/
	/*for($i=0;$i<count($ranges);$i++)
	{
		$query = "INSERT INTO ".$tblprefix."changed_standard_rates (`property_id`, 
		`room_type_id`, 
		`pm_id`,
		`standard_date`,
		`standard_rate_price`,
		`standard_rate_id`)
		 VALUES ('173', '110', '172', '".$ranges[$i]."', '36', '181')";
		
		$db->Execute($query);
	}*/
	
	
	
	if($start_date=='')
	{
		$error='Start date is required<br/>';
	}
	if($end_date=='')
	{
		$error='End date is required<br/>';
	}
	
	
	
	if($no_of_rooms=='')
	{
		$error = "Please enter Number of rooms";
	}
	if($error!=''){

		$msg=base64_encode($error);
		$id = 0;

		header("Location: admin.php?okmsg=$msg&act=get_rates_overview2&id=".base64_encode($id)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}else{
		
		$ranges = DatesBetween($start_date,$end_date);

		for($i=0;$i<count($ranges);$i++){
			   $query_update ="UPDATE ".$tblprefix."changed_standard_rates
	                 SET
	                 rooms_for_sale=".$no_of_rooms."
	                 WHERE property_id=".$property_id."
	                 AND standard_date='".$ranges[$i]."'
	                 AND room_type_id=".$propertyroomid."
	                 AND pm_id=".$pm_id." 	                 
	                 ";
			   
			   
			   $db->Execute($query_update);
		}
		
		$id = 0;

		
		$msg = base64_encode("You have successfully changed the rates");
		header("Location: admin.php?okmsg=$msg&act=get_rates_overview2&id=".base64_encode($id)."&pm_id=".base64_encode($pm_id)."&stdt=".$_POST['start_date']."&endt=".$_POST['end_date']."&pr_id=".base64_encode($property_id));
		exit();
	}

}

function DatesBetween($startDate, $endDate){

	$dateMonthYearArr = array();
	$fromDateTS = strtotime($startDate);
	$toDateTS = strtotime($endDate);

	for ($currentDateTS = $fromDateTS; $currentDateTS < $toDateTS; $currentDateTS += (60 * 60 * 24)) {
		// use date() and $currentDateTS to format the dates in between
		$currentDateStr = date('Y-m-d',$currentDateTS);
		$dateMonthYearArr[] = $currentDateStr;
		//print $currentDateStr.”<br />”;
	}


	return $dateMonthYearArr;
}



?>	
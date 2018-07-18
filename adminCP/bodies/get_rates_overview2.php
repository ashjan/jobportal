<?php

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$maxRows = 50;
$pageNum = $_GET['pageNum'];
if(isset($_GET['stdt']) && isset($_GET['stdt'])){
	$standard_rate_to=base64_decode($_GET['endt']);
	$standard_rate_from=base64_decode($_GET['stdt']);

}else{
	if ($pageNum == '') $pageNum=0;
	$startRow = $pageNum * $maxRows;
	$qry_rates = "SELECT ".$tblprefix."rooms.room_type,
					 ".$tblprefix."standard_rates.id,
					 ".$tblprefix."standard_rates.room_type_id,
					 ".$tblprefix."standard_rates.standard_start_date,
					 ".$tblprefix."standard_rates.standard_end_date,
					 ".$tblprefix."standard_rates.standard_rate_price,
					 ".$tblprefix."standard_rates.single_use_option,
					 ".$tblprefix."standard_rates.single_rate_price,
					 ".$tblprefix."standard_rates.rooms_for_sale
					 FROM
					 ".$tblprefix."rooms
				inner Join ".$tblprefix."standard_rates ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id" ;
	$rs_rates = $db->Execute($qry_rates);
	$rates_arr=array();
	$rates_arr[]=$rs_rates->fields;
	$qry_vat_tax ="SELECT ".$tblprefix."vat_tax_charges.id,
                      ".$tblprefix."vat_tax_charges.service_charges_type,
                      ".$tblprefix."vat_tax_charges.vat_amount,
					  ".$tblprefix."vat_tax_charges.city_tax_amount,
					  ".$tblprefix."vat_tax_charges.service_charge_amount 
					 FROM 
					 ".$tblprefix."vat_tax_charges  ";
	$rs_vat_tax = $db->Execute($qry_vat_tax);
	$rs_arr=array();
	$rs_arr[]=$rs_vat_tax->fields;

	$count_add =  $rs_rates->RecordCount();
	$totalRows = $count_add;
	$totalPages = ceil($totalRows/$maxRows);

	$qry_booking = "SELECT check_indate, check_outdate from ".$tblprefix."property_booking";
	$rs_booking = $db->Execute($qry_booking);
	$qry_cancel = "SELECT cancellation_charges_percent from ".$tblprefix."property_policy";
	$rs_cutting = $db->Execute($qry_cancel);


}


//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_room = $db->Execute($qry_region);
$count_region =  $rs_room->RecordCount();
$totalRegions = $count_region;


?>






<div id="propertyroom"  style="float:left;width:140%;">
<?php
$propertyroomid=base64_decode($_GET['id']);

$pm_id = base64_decode($_GET['pm_id']);


$cancellation_charges_percent = "SELECT cancellation_charges_percent FROM ".$tblprefix."property_policy WHERE property_id='".$rs_rates->fields['property_id']."'";

$cancellation_rs = $db->Execute($cancellation_charges_percent);


$qry_vat_tax ="SELECT ".$tblprefix."vat_tax_charges.id,
                      ".$tblprefix."vat_tax_charges.service_charges_type,
                      ".$tblprefix."vat_tax_charges.vat_amount,
					  ".$tblprefix."vat_tax_charges.city_tax_amount,
					  ".$tblprefix."vat_tax_charges.service_charge_amount 
					 FROM 
					 ".$tblprefix."vat_tax_charges  ";


$rs_vat_tax = $db->Execute($qry_vat_tax);
$rs_arr=array();
$rs_arr[]=$rs_vat_tax->fields;


/*$count_add =  $rs_rates->RecordCount();
$totalRows = $count_add;*/


$qry_cancel = "SELECT cancellation_charges_percent from ".$tblprefix."property_policy";
$rs_cutting = $db->Execute($qry_cancel);
$where = '';


	if($_SESSION[SESSNAME]['module_id']==2){

		$where.=$tblprefix."standard_rates.pm_id=" .$_SESSION[SESSNAME]['pm_id']." AND ".$tblprefix."standard_rates.property_id=".base64_decode($_GET['pr_id']);
	}else {

		$where.=$tblprefix."standard_rates.pm_id=".base64_decode($_GET['pm_id'])." AND ".$tblprefix."standard_rates.property_id=".base64_decode($_GET['pr_id']);
	}
	if(isset($_GET['stdt']) && isset($_GET['endt'])){
		$start_date = base64_decode($_GET['stdt']);
		$end_date = base64_decode($_GET['endt']);
		
		if($start_date!='' and $end_date!=''){
			$new_start_date = date("Y-m-d",strtotime($start_date));
			$new_end_date = date("Y-m-d",strtotime($end_date));
			
			$where.=" AND  ".$tblprefix."changed_standard_rates.standard_date BETWEEN '".$new_start_date."' AND '".$new_end_date."'";
			
		}
		
	}



$qry_limit = "SELECT DISTINCT 
					".$tblprefix."rooms.room_type,
					".$tblprefix."standard_rates.id,
					".$tblprefix."standard_rates.room_type_id,
					".$tblprefix."standard_rates.property_id,
					".$tblprefix."standard_rates.pm_id,
					".$tblprefix."standard_rates.standard_start_date,
					".$tblprefix."standard_rates.standard_end_date,
					".$tblprefix."standard_rates.standard_rate_price,
					".$tblprefix."standard_rates.single_use_option,
					".$tblprefix."standard_rates.single_rate_price,
					".$tblprefix."standard_rates.rooms_for_sale,".
                    $tblprefix."changed_standard_rates.standard_rate_id
					FROM
					".$tblprefix."standard_rates
					
					INNER JOIN ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id 
					INNER JOIN ".$tblprefix."changed_standard_rates ON ".$tblprefix."standard_rates.id=".$tblprefix."changed_standard_rates.standard_rate_id				
				WHERE ".$where." ORDER BY ".$tblprefix."standard_rates.id ASC";
//echo $qry_limit;exit();



$rs_limit = $db->Execute($qry_limit);
$totalOverviews = $rs_limit->RecordCount();

$slug_query = "SELECT properties_slug FROM ".$tblprefix."properties WHERE id='".$rs_limit->fields['property_id']."'";
$execute = $db->Execute($slug_query);

$price = "SELECT price FROM ".$tblprefix."property_booking WHERE property_id='".$execute->fields['properties_slug']."'";

$rs_price = $db->Execute($price);

$cancellation_charges = (float)($rs_price->fields['price']*($cancellation_rs->fields['cancellation_charges_percent']/100));

$qry_booking = "SELECT check_indate, check_outdate from ".$tblprefix."property_booking WHERE property_id='".$execute->fields['properties_slug']."'";


$rs_booking = $db->Execute($qry_booking);
//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_room = $db->Execute($qry_region);
$count_region =  $rs_room->RecordCount();
$totalRegions = $count_region;

if($propertyroomid==0){
	$qry_standard_rooms ="SELECT room_type_id,standard_date,no_of_rooms,rate_id FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." ORDER BY id ASC";
}else {
	$qry_standard_rooms ="SELECT room_type_id,standard_date,no_of_rooms,rate_id FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." ORDER BY id ASC";
}



$rs_standard_rooms = $db->Execute($qry_standard_rooms);

$count_standard_rooms = $rs_standard_rooms->RecordCount();


if($propertyroomid==0){
	$qry_changed_rates ="SELECT room_type_id,standard_date,standard_rate_price FROM ".$tblprefix."changed_standard_rates WHERE pm_id=".$pm_id." ORDER BY id ASC";
}else {
	$qry_changed_rates ="SELECT room_type_id,standard_date,standard_rate_price FROM ".$tblprefix."changed_standard_rates WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." ORDER BY id ASC";
}
$rs_standard_rates = $db->Execute($qry_changed_rates);

$count_changed_rates = $rs_standard_rates->RecordCount();

function get_cancellation_room($date='',$day='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	global $tblprefix;
	$month = date("m",strtotime($date));
	$year = date("Y",strtotime($date));
	$dates = $month."/".$day."/".$year;
	$new_date = date("m/d/Y",strtotime($dates));
	$qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."cancellation WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."')";
	$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);

	return $rs_tbl_cancellation->fields['cancelled'];


}

//new function for new logic
function get_cancellation_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."cancellation WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."')";
	$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);

	return $rs_tbl_cancellation->fields['cancelled'];


}
//function for new logic with giving date as argument and returning number of properties booked
function get_booking_count1($date='',$pm_id = 0,$propertyroomid = 0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_booking = "SELECT
	                 id,
					 room_id,
					 check_indate,
					 check_outdate 
					FROM ".$tblprefix."property_booking 
					WHERE pm_id=".$pm_id." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."') AND room_id=".$propertyroomid;
      


	$rs_booking = $db->Execute($qry_booking);
	$rs_booking->MoveFirst();
	while (!$rs_booking->EOF){
		$explode_values = explode(',',$rs_booking->fields['room_id']);
		if(in_array($propertyroomid,$explode_values)){
			$count++;
		}
		$rs_booking->MoveNext();
	}

	return $count;

}
function get_booking_count($date='',$day='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$month = date("m",strtotime($date));
	$year = date("Y",strtotime($date));
	$dates = $month."/".$day."/".$year;
	$new_date = date("m/d/Y",strtotime($dates));
	$qry_booking = "SELECT id,room_id,check_indate,check_outdate FROM ".$tblprefix."property_booking WHERE pm_id=".$pm_id." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."') AND room_id=".$propertyroomid."";

	$rs_booking = $db->Execute($qry_booking);
	$rs_booking->MoveFirst();
	while (!$rs_booking->EOF){
		$explode_values = explode(',',$rs_booking->fields['room_id']);

		if(in_array($propertyroomid,$explode_values)){
			$count++;
		}
		$rs_booking->MoveNext();
	}
	return $count;


}
function find_room($date='',$day='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$month = date("m",strtotime($date));
	$year = date("Y",strtotime($date));
	$dates = $month."/".$day."/".$year;
	$new_date = date("m/d/Y",strtotime($dates));
	
	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND standard_date='".$new_date."'";
	

	$rs_room = $db->Execute($qry_room);
	return $rs_room->fields['no_of_rooms'];

}
//new function for new logic
function find_room1($date='',$pm_id = 0,$propertyroomid=0,$rate_id=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));


	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND standard_date='".$new_date."' AND rate_id=".$rate_id;


	$rs_room = $db->Execute($qry_room);
	return $rs_room->fields['no_of_rooms'];

}
function get_days_changed_specific_rates($pm_id=0,$propertyroomid=0,$rate_id=0)
{
	global  $db;
	global $tblprefix;
	$first_day_changed = array();
	$new_date = date("m/d/Y",strtotime($date));

	$qry_room = "SELECT standard_date FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid."
	 AND rate_id=".$rate_id;


	$rs_room = $db->Execute($qry_room);
	$rs_room->MoveFirst();
	while (!$rs_room->EOF) {

		$first_day_changed[] = $rs_room->fields['standard_date'];
		$rs_room->MoveNext();

	}



	return $first_day_changed;

}


//
function dayofyear2date( $tDay, $tFormat = 'm/d/Y' ) {
	$day = intval( $tDay );
	$day = ( $day == 0 ) ? $day : $day - 1;$offset = intval( intval( $tDay ) * 86400 );
	$date = mktime( 0, 0, 0, 1, 1, date('Y') )+$offset;return( $date );
}



function DatesBetween($startDate, $endDate){

	$dateMonthYearArr = array();
	$fromDateTS = strtotime($startDate);
	$toDateTS = strtotime($endDate);

	for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
		// use date() and $currentDateTS to format the dates in between
		$currentDateStr = date('Y-m-d',$currentDateTS);
		$dateMonthYearArr[] = $currentDateStr;
		//print $currentDateStr.”<br />”;
	}


	return $dateMonthYearArr;
}

/*** get rooms change***/
function get_rooms_changed($day='',$pm_id=0,$room_id=0,$rate_id=0)
{
	$day_changed = array();
	global $db;
	global $tblprefix;

	$qry_rooms_changed = "SELECT standard_date FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$room_id."";

	$rs_rooms_change = $db->Execute($qry_rooms_changed);
	$total = $rs_rooms_change->RecordCount();
	if($total>0){
		$rs_rooms_change->MoveFirst();
		while (!$rs_rooms_change->EOF) {

			$day_changed[] = $rs_rooms_change->fields['standard_date'];

			$rs_rooms_change->MoveNext();
		}
	}
	return $day_changed;

}
function dateValues($dates =array()){
	$date_value = array();
	for($i=0;$i< count($dates);$i++){
		$date_value[]=date("d",strtotime($dates[$i]));
	}
	return $date_value;
}
function getBookingCount($property_id=0)
{
	$qry_booking = "SELECT count(id) AS booking FROM tbl_property_booking WHERE property_id=".$property_id;
	$rs_booking = mysql_fetch_array(mysql_query($qry_booking));
	return $rs_booking['booking'];

}

function get_changed_rate($day = '', $propertyroomid=0,$pm_id=0,$property_id=0)
{
	global $db;
	global $tblprefix;
	$qry_rates_changed = "SELECT rate FROM ".$tblprefix."changed_standard_rates WHERE pm_id=".$pm_id." AND room_id=".$propertyroomid." AND property_id=".$property_id;

	$rs_rates_changed = $db->Execute($qry_rates_changed);
	$total = $rs_rates_changed->RecordCount();

	return $rs_rates_changed->fields['rate'];

}


$qry_property_manag = "SELECT
                    ".$tblprefix."users.id,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name 
					FROM
					".$tblprefix."users"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();
/**** function for getting the values ****/
function date_changed($pm_id=0,$property_id=0,$room_id=0){
$day_changed = array();
global $db;
global $tblprefix;
$qry_standard_rooms ="SELECT standard_date,no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$room_id."  AND property_id=".$property_id." ORDER BY id ASC";


$rs_standard_rooms = $db->Execute($qry_standard_rooms);

$count_standard_rooms = $rs_standard_rooms->RecordCount();
$rs_standard_rooms->MoveFirst();
while(!$rs_standard_rooms->EOF){
							$day_changed[] = $rs_standard_rooms->fields['standard_date'];
							$rs_standard_rooms->MoveNext();
						}

return $day_changed;

}
/**** function for finding number of rooms for specific date from changed standard rates****/
function find_room2($date='',$pm_id=0,$propertyroomid=0,$property_id=0,$rate_id=0){
global $db;
global $tblprefix;
	$new_date = date("Y-m-d",strtotime($date));
	$qry_select_rooms = "SELECT rooms_for_sale FROM ".$tblprefix."changed_standard_rates 
	                    WHERE pm_id=".$pm_id."
	                    AND property_id=".$property_id."
	                    AND room_type_id=".$propertyroomid.
	                    " AND standard_rate_id=".$rate_id.
	                    " AND standard_date='".$new_date."'";  
	                   ;
	               
	  
	 $rs_select_rooms = $db->Execute($qry_select_rooms);
	 return $rs_select_rooms->fields['rooms_for_sale'];
}
/**** find rates and number of rooms for standard dates ****/
function find_rates_and_rooms($standard_rate_id=0,$property_id=0,$room_id=0,$pm_id=0,$day){
global $db;
global $tblprefix;
	$new_date = date("Y-m-d",strtotime($day));
	$qry_rates = "SELECT standard_rate_price FROM ".$tblprefix."changed_standard_rates 
	                  WHERE pm_id=".$pm_id." AND property_id=".$property_id."
	                  AND room_type_id=".$room_id." AND standard_rate_id=".$standard_rate_id.
	                 " AND standard_date='".$new_date."'";
	                 
	 $rs_rates = $db->Execute($qry_rates);
	 return $rs_rates->fields['standard_rate_price'];
	               
	
}

	

?>
<div id="rates_tip" class="tip">
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="left" valign="bottom">
    	&nbsp;
    	<!--<img src="<?php echo MYSURL?>graphics/_pointer2.gif">-->
    </td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><img src="<?php echo MYSURL?>graphics/topleftcurve.gif" width="13" height="11" /></td>
    <td align="left" valign="bottom" style="background-image:url(<?php echo MYSURL?>graphics/topbg.gif); background-position:bottom; background-repeat:repeat-x;">&nbsp;</td>
    <td align="left" valign="bottom"><img src="<?php echo MYSURL?>graphics/toprightcurve.gif" width="12" height="11" /></td>
  </tr>
  <tr>
    <td width="1%" align="right" valign="top" style="background-image:url(<?php echo MYSURL?>graphics/leftstyle.gif); background-position:right; background-repeat:repeat-y"><img src="<?php echo MYSURL?>graphics/leftstyle.gif" width="13" height="1" /></td>
    <td width="99%" align="left" valign="top" bgcolor="#FFFFFF">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="change_rate_ranges" id="change_rate_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">  
	<tr>
        <td height="35">
       
        	<input type="text" name="change_rate" value="" id="change_rate" />
        	
        	<input type="hidden" name="change_pm" id="change_pm" value=""/>
        	<input type="hidden" name="change_room_id" id="change_room_id" value=""/>
        	<input type="hidden" name="change_rates_id" id="change_rates_id" value=""/>
        	<input type="hidden" name="change_rates_rooms" id="change_rates_rooms" value=""/>
        	<input type="hidden" name="change_date" id="change_date" value=""/>
        	<input type="hidden" name="change_standard_rate_id" id="change_standard_rate_id"/>
        	<input type="hidden" name="change_property_id" id="change_property_id" value=""/>
        	<input type="hidden" name="start_date" value="<?php echo $_GET['stdt']?>" />
		    <input type="hidden" name="end_date" value="<?php echo $_GET['endt']?>" />
		    <input type="hidden" name="request_page" value="manage_rates_overview"/>
			<input type="hidden" name="act" value="manage_rates_overview" />
			<input type="hidden" name="mode" value="update_rate1" />
        	
        	
        	
        </td>
       <td class="txt">Start Date &nbsp;</td>
       <td><input type="text" name="change_rate_start_date" id="change_rate_start_date" value="" readonly>
       </td>
        <td class="txt">End date &nbsp;</td>
        <td><input type="text" name="change_rate_end_date" id="change_rate_end_date" size="20" value="" readonly>
			   <script language="JavaScript">

			   var o_cal = new tcal ({
			   	// form name
			   	'formname': 'change_rate_ranges',
			   	// input name
			   	'controlname': 'change_rate_end_date',
			   });

			   // individual template parameters can be modified via the calendar variable
			   o_cal.a_tpl.yearscroll = false;
             </script>
        </td>
       
        <td class="txt"><input type="submit" name="submit" value="Change" /></td>
      </tr>
      </form>
      <tr>
        <td colspan="6"align="right"><a href="#" onClick="popUp(event,'rates_tip')"><img src="<?php echo MYSURL?>graphics/close.gif" border="0"></a></td>
      </tr>
    </table>
	
	
	</td>
    <td width="0%" align="left" valign="top" style="background-image:url(<?php echo MYSURL?>graphics/rightstyle.gif); background-position:left; background-repeat:repeat-y"><img src="<?php echo MYSURL?>graphics/rightstyle.gif" width="12" height="1" /></td>
  </tr>
  <tr>
    <td align="right" valign="top"><img src="<?php echo MYSURL?>graphics/btmleftcurve.gif" width="13" height="13" /></td>
    <td align="left" valign="top" style="background-image:url(<?php echo MYSURL?>graphics/btmbg.gif); background-position:top; background-repeat:repeat-x"><img src="<?php echo MYSURL?>graphics/btmbg.gif" width="1" height="13" /></td>
    <td align="left" valign="top"><img src="<?php echo MYSURL?>graphics/btmrightcurve.gif" width="12" height="13" /></td>
  </tr>
</table>
</div>


<div id="rooms_tip" class="tip">
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="left" valign="bottom">
    	&nbsp;
    	<!--<img src="<?php echo MYSURL?>graphics/_pointer2.gif">-->
    </td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><img src="<?php echo MYSURL?>graphics/topleftcurve.gif" width="13" height="11" /></td>
    <td align="left" valign="bottom" style="background-image:url(<?php echo MYSURL?>graphics/topbg.gif); background-position:bottom; background-repeat:repeat-x;">&nbsp;</td>
    <td align="left" valign="bottom"><img src="<?php echo MYSURL?>graphics/toprightcurve.gif" width="12" height="11" /></td>
  </tr>
  <tr>
    <td width="1%" align="right" valign="top" style="background-image:url(<?php echo MYSURL?>graphics/leftstyle.gif); background-position:right; background-repeat:repeat-y"><img src="<?php echo MYSURL?>graphics/leftstyle.gif" width="13" height="1" /></td>
    <td width="99%" align="left" valign="top" bgcolor="#FFFFFF">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="change_room_ranges" id="change_room_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">  
	<tr>
        <td height="35">
       
        	<input type="text" name="change_rooms_id" value="" id="change_rooms_id" />
        	
        	<input type="hidden" name="change_pm_id" id="change_pm_id" value=""/>
        	<input type="hidden" name="change_room_type_id" id="change_room_type_id" value=""/>
        	<input type="hidden" name="change_properties_id" id="change_properties_id" value=""/>
        	<input type="hidden" name="change_rate_id" id="change_rate_id" value=""/>
        	<input type="hidden" name="start_date" value="<?php echo $_GET['stdt']?>" />
		    <input type="hidden" name="end_date" value="<?php echo $_GET['endt']?>" />
		    <input type="hidden" name="request_page" value="manage_rates_overview"/>
			<input type="hidden" name="act" value="get_rates_overview1" />
			<input type="hidden" name="mode" value="update_room1" />
        	
        	
        	
        </td>
       <td height="35"class="txt">Start Date&nbsp;</td>
       <td>
       <input type="text" name="change_room_start_date" id="change_room_start_date" value="" readonly>
       </td>
        <td height="35" class="txt">End date &nbsp;</td>
        <td><input type="text" name="change_room_end_date" id="change_room_end_date" size="20" value="" readonly>
			   <script language="JavaScript">

			   var o_cal = new tcal ({
			   	// form name
			   	'formname': 'change_room_ranges',
			   	// input name
			   	'controlname': 'change_room_end_date',
			   });

			   // individual template parameters can be modified via the calendar variable
			   o_cal.a_tpl.yearscroll = false;
             </script>
        </td>
       
        <td class="txt" height="35"><input type="submit" name="submit" value="Change" /></td>
      </tr>
      </form>
      <tr>
        <td colspan="6" align="right"><a href="#" onClick="popUp1(event,'rooms_tip')"><img src="<?php echo MYSURL?>graphics/close.gif" border="0"></a></td>
      </tr>
    </table>
	
	
	</td>
    <td width="0%" align="left" valign="top" style="background-image:url(<?php echo MYSURL?>graphics/rightstyle.gif); background-position:left; background-repeat:repeat-y"><img src="<?php echo MYSURL?>graphics/rightstyle.gif" width="12" height="1" /></td>
  </tr>
  <tr>
    <td align="right" valign="top"><img src="<?php echo MYSURL?>graphics/btmleftcurve.gif" width="13" height="13" /></td>
    <td align="left" valign="top" style="background-image:url(<?php echo MYSURL?>graphics/btmbg.gif); background-position:top; background-repeat:repeat-x"><img src="<?php echo MYSURL?>graphics/btmbg.gif" width="1" height="13" /></td>
    <td align="left" valign="top"><img src="<?php echo MYSURL?>graphics/btmrightcurve.gif" width="12" height="13" /></td>
  </tr>
</table>
</div>


<form name="date_ranges" id="date_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
			  <table cellpadding="5" cellspacing="5" class="txt" width="550" >
			   
			 <?php 

			 if($_GET['okmsg']!=''){ ?>
			 <tr>
			 <td></td>
			 <td class="errmsg"><font color="#FF0000"><?php echo base64_decode($_GET['okmsg']);?></font></td>
			 </tr>
        <?php } ?>
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
       <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_prop_name10('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name21.php"?>')">
					<option value="0">Select PM</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
							<option value="<?php echo $rs_property_manag->fields['id'];?>"
							<?php if(base64_decode($_GET['pm_id'])==$rs_property_manag->fields['id']){ echo "selected='selected'";}?>
							><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr> 
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields" onchange="get_room_type4('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type16.php"?>','<?php echo $_SESSION[SESSNAME]['pm_id']?>')">
					<option value="0">Select Property</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"
 <?php if($rs_property->fields['id']==base64_decode($_GET['pr_id'])){echo "selected='selected'";}?>
 ><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
			<?php }else {?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			  <?php 
			  if($_SESSION[SESSNAME]['pm_moduleid']==2){
			  	$manger_id = $_SESSION[SESSNAME]['pm_id'];
			  }else {
			  	$manager_id = base64_decode($_GET['pm_id']);
			  }

			  ?>
			    <select name="property_id" id="property_id" class="fields" onchange="get_room_type4('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type4.php"?>','<?php echo $manager_id?>')" />
			    <option value="0" <?php if(base64_decode($_GET['id'])==0){echo "selected='selected'";}?>>All Room</option>
			    <?php if(isset($_GET['id'])){

			    	$property_qr = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$manager_id." AND pm_type=1";
			    	$rs_prop = $db->Execute($property_qr);
			    }
			    $rs_prop->MoveFirst();
 			    while (!$rs_prop->EOF) {?>
 			    <option value="<?php echo $rs_prop->fields['id']?>" 
 			    <?php if($rs_prop->fields['id']==base64_decode($_GET['pr_id'])){
 			    	echo "selected='selected'";
 			    } ?>>
 			    <?php echo $rs_prop->fields['property_name'];?>
				</option>				
					<?php $rs_prop->MoveNext();}?>
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
			<tr>
	        <td>
  			Room/Property Type
		   	</td>
			<td>
	<div id="room_type">
			<select name="room_type" class="dropfields" >
			  <option value="0" <?php if(base64_decode($_GET['id'])==0){echo "selected='selected'";}?>>All Room</option>
			  <?php if(isset($_GET['id'])){
			  	if($_SESSION[SESSNAME]['pm_moduleid']==2){
			  		$manger_id = $_SESSION[SESSNAME]['pm_id'];
			  	}else {
			  		$manager_id = base64_decode($_GET['pm_id']);
			  	}
			  	$qry_room = "SELECT id,room_type FROM ".$tblprefix."rooms WHERE property_id=".base64_decode($_GET['pr_id']);

			  	$rs_room = $db->Execute($qry_room);
			  	$rs_room->MoveFirst();
			  	while (!$rs_room->EOF) {?>
			  	<option value="<?php echo $rs_room->fields['id']?>"
			  	<?php if($rs_room->fields['id']==base64_decode($_GET['id'])) {
			  		echo "selected='slected'";
			  	}?>>
			  	<?php echo $rs_room->fields['room_type']?></option>
			  		
			  	<?php $rs_room->MoveNext();}
			  }
			  	?>

			</select>
      </div>
			</td>
        </tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
		<tr>
			  <td>Start Date </td>
			  <td><input type="text" name="start_date" id="start_date" class="fields" value="<?php echo base64_decode($_GET['stdt']);?>">
			   <script language="JavaScript">

			   var o_cal = new tcal ({
			   	// form name
			   	'formname': 'date_ranges',
			   	// input name
			   	'controlname': 'start_date',
			   	
			   });

			   // individual template parameters can be modified via the calendar variable
			   o_cal.a_tpl.yearscroll = false;
             </script>
             </td>
			  </tr>
			  <tr>
			  <td>End Date </td>
			  <td><input type="text" name="end_date" id="end_date" class="fields" value="<?php echo base64_decode($_GET['endt']);?>">
			   <script language="JavaScript">

			   var o_cal = new tcal ({
			   	// form name
			   	'formname': 'date_ranges',
			   	// input name
			   	'controlname': 'end_date',
			   });

			   // individual template parameters can be modified via the calendar variable
			   o_cal.a_tpl.yearscroll = false;
			   o_cal.a_tpl.weekstart = 1;
									</script>
			</td>
			</tr>	
			
			<tr>
			<td colspan="2">
			  <div style="float:left; width:100%;">
			 <input type="submit" name="availability" value="Show Results[Prika&#382;i rezultate]"/>
			  </div>
			 </td>
			</tr>
			
		 </table>	
        <input type="hidden" name="mode" value="overview_rates" />
		<input type="hidden" name="request_page" value="manage_rates_overview" />
		<input type="hidden" name="act" value="manage_rates_overview" />
</form>	
	 
<div  style="display:block; width:1300px;">
    <div style="float:left; width:100%;"> 
<?php	
$day_arr = array();
$standard_day = array();//for original dates
if($totalOverviews >0){
				  $rs_limit->MoveFirst();
?>	
		<div  style="background-color:#0066FF; color:#FFFFFF; font-weight:bold; width:100%;float:left;">
             	 Standard Rates Availability
		</div>
				<?php 
					while(!$rs_limit->EOF){
					
		
					$original_day = array();
					$first_day_changed = array();
					$stdt =  base64_decode($_GET['stdt']);
					$endt =  base64_decode($_GET['endt']);
					if(!empty($stdt) && !empty($endt)){
						$start_month =  date("m",strtotime(base64_decode($_GET['stdt'])));
						$end_month =  date("m",strtotime(base64_decode($_GET['endt'])));
						$original_day = DatesBetween($stdt,$endt);
						
					}// if stdt and endt ends here
					
					else {
						
				$original_day = DatesBetween($rs_limit->fields['standard_start_date'],$rs_limit->fields['standard_end_date']);
					}
					
					//$first_day_changed = date_changed($rs_limit->fields['pm_id'],$rs_limit->fields['property_id'],$rs_limit->fields['room_type_id']);
					$date1 = $rs_limit->fields['standard_start_date'];
					$date2 = $rs_limit->fields['standard_end_date'];
					
					$convert_start_date = strtotime($date1);
					$convert_end_date = strtotime($date2);
					$convert_sel_end_date = strtotime($endt);
					$convert_sel_start_date = strtotime($stdt);
					
					
					
					$standard_day = DatesBetween($date1,$date2);
					
					
		if(!empty($original_day)){
					?>
					<?php    		
              	$curr_month='';
				$previous_month='';
				$curr_year = '';
				$previous_year = '';
				$current_year='';
				$previous_year ='';
				$inner_div='<div class="inner_div">
					<div class="single_div">Month[Mjesec]</div>
					<div class="single_div">'.$rs_limit->fields['room_type'].'</div>
					<div class="single_div">Status</div>
					<div class="single_div">Single use rate per night</div>
     				<div class="single_div">Rate per night</div>
     				<div class="single_div">Rooms to sell</div>
     				<div class="single_div">Booked</div>
     				<div class="single_div">Cancelled</div>
					</div>';
              	foreach ($original_day as $key=>$day){
              		$curr_month=date("M",strtotime($day));
              		$curr_year = date("Y",strtotime($day));
              		$day_arr[$curr_year][$curr_month][] =$day;
              	  	}
				
              	  		foreach ($day_arr as $key=>$year){
              	  	   foreach ($year as $keys =>$days){
              	  	   	
						$current_month = $keys;
						if($current_month!=$previous_month && array_intersect($days,$standard_day)){
						  $previous_month = $keys;?>
       			       <div class="outer_rates" style="width:100%;border:0px;float:left;padding:20px;">                           
                       <?php echo $inner_div;?>
                       <div style="width:100%;" >

                       
						<div class="single_div overview_heading month_style" >
                        <?php echo $previous_month." ".$key?>
                        <!-- div with width ends-->

                        </div>
                        <!-- div with single ends-->
                       

                        
                        <div class="single_div overview_heading">
                         <?php foreach($days as $day){
                         	
                         	if(in_array($day,$standard_day)){
                         	 $day_of_week =  date("D",strtotime($day));
                         	 if($day_of_week=='Sat' OR $day_of_week=='Sun')
                         	 {
                         	 	$bgcolor = "grey";
                         	 	$color = "#FFFFFF";
                         	 }else {
                         	 	$bgcolor = "#FFFFFF";
                         	 	$color = "black";
                         	 }
                         	
                         	?>
                         	
                         	
                         <?php 
                       
                         echo '<div  class="value_div" style=background-color:'.$bgcolor.';color:'.$color.';>'.date("d",strtotime($day)).'</div>'; ?>
                         <?php }}?>
                        <!-- overview headings for days ends-->
                        </div>
                        
                        <!-- div for status starts-->
                        <div class="single_div">
					<?php    		
              	foreach($days as $day){
					   if (in_array($day,$standard_day)) {
					   	    
					   	     
					   	    $total_booking = get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					   	    
							//$rooms_for_sale = $rs_limit->fields['rooms_for_sale'];
							$rooms_for_sale = find_room2($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['property_id'],$rs_limit->fields['id']);
							
							$cancelled = get_cancellation_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
							
							$remaining_rooms = ($rooms_for_sale+$cancelled)-$total_booking;
						
						
					   
					   $cancelled = get_cancellation_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					   
					   $remaining_rooms = ($rooms_for_sale+$cancelled)-$total_booking;
					   
							
							if($remaining_rooms<0){
					    	
					    	$remaining_rooms = 0;
					    }
					     switch ($remaining_rooms){
					    	
					    	case (0):?>
							 <div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single user rate per night=".$rs_limit->fields['single_rate_price'].",standard rate price=".$rs_limit->fields['standard_rate_price']?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_rooms>0):?>
					    	
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single rate price=".$rs_limit->fields['single_rate_price'].",standard rate price=".$rs_limit->fields['standard_rate_price']?>" border="0"/></div>
					    <?php 
					    		break;
					    	
					    		default:
					    			echo "";
					   				   
					    }?>
					    
					    <!-- div for displaying single rate price starts-->
					
					    
					    
					  <?php 
					    }else {?>
					   <!--	<div  class="value_div">N/A</div>-->
					   <?php 
					   }
					 }?>
                     
                     <!-- div for status ends-->
					</div>
					<div class="single_div overview_heading1">
					<?php    		
              	foreach($days as $day){?>
					<?php 
					$year = date("Y",strtotime($day));
					//if($year==$arr){
					if(in_array($day,$standard_day)){
						echo '<div  class="value_div">'.$rs_limit->fields['single_rate_price'].'</div>'; }
						else {
							//echo '<div class="value_div">N/A</div>';
						}
					?>
					<?php }//}?>
                    					<!-- div for displaying single rate ends-->
					</div>
                    <!-- standard rate price div starts-->
                    <div class="single_div overview_heading1">
     				<?php    		
              	foreach($days as $day){?>
              	<?php 

              	if(in_array($day,$standard_day)){
              		$rooms_for_sale = find_room2($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['property_id'],$rs_limit->fields['id']);
              		/**** get the standard rate price specific day for standard rate id****/
              		$rate_and_rooms = find_rates_and_rooms($rs_limit->fields['id'],$rs_limit->fields['property_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['pm_id'],$day);
              		
              		echo  '<div  class="value_div"><a style="cursor:pointer" onclick="popUp(event,\'rates_tip\','.$rate_and_rooms.','.$rs_limit->fields['pm_id'].','.$rs_limit->fields['room_type_id'].',\''.$day.'\','.$rs_limit->fields['property_id'].','.$rate_and_rooms.','.$rooms_for_sale.','.$rs_limit->fields['id'].')">'.$rate_and_rooms.'</a></div>';}
              		else {
              			//echo '<div class="value_div">N/A</div>';
              		}
              	?>

					<?php }//}?>
                    <!-- standard rate price div ends-->
     				</div>
     				
     				   <!-- div for displaying rooms for sale starts-->
     				<div class="single_div overview_heading1">
     				<?php    		
     				foreach($days as $day){



     						if(in_array($day,$standard_day)){
     		$rooms_for_sale = find_room2($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['property_id'],$rs_limit->fields['id']);
					   
					   echo  '<div  class="value_div"><a style="cursor:pointer;" onclick="popUp1(event,\'rooms_tip\','.$rs_limit->fields['pm_id'].','.$rs_limit->fields['room_type_id'].',\''.$day.'\','.$rs_limit->fields['property_id'].','.$rs_limit->fields['id'].','.$rooms_for_sale.')">'.$rooms_for_sale.'</a></div>';?>
					  <?php 

					     }else{
					   //	echo '<div class="value_div">N/A</div>';
					   }
					 }?>
     				<!-- div for displaying rooms for sale ends-->
     				</div>
     				
     				    <!-- div for displaying booked starts-->
     				<div class="single_div overview_heading1">
     				<?php    		
              	foreach($days as $day){?>
					<?php 
					/*$year = date("Y",strtotime($day));
					if($year==$arr){*/
					if(in_array($day,$standard_day)){
						echo '<div  class="value_div">'.get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']).'</div>';}
						else {
							//echo '<div class="value_div">N/A</div>';
						}

					?>

					<?php }//}?>
              <!-- div for displaying booked ends-->
     				</div>
     				
     				<div class="single_div overview_heading1">
     				<?php    		
     				foreach($days as $day){
     				
     					if(in_array($day,$standard_day)){
     						$cancelled = get_cancellation_room1(date("m/d/Y",strtotime($day)),$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
     						echo '<div  class="value_div">'.$cancelled.'</div>';
     					}else {
     						//echo '<div class="value_div">N/A</div>';
     					}
              	 }//}?>
                 					<!-- div for displaying cancelled ends-->
     				</div>
     				
     				</div>
					

					
					
					
</div>
                       
                       <!-- outer_rates end-->
                       </div>
						<?php 
						}
              	  		
              	  	}
              	  		
				?>
				
					
			<?php }
		}
				 
				?>
			<?php 
			unset($original_day);
			unset($day_arr);
			unset($year_arr);
			unset($standard_day);
			unset($first_day_changed);
			$rs_limit->MoveNext();
			
					}
			
		
			    ?>
<?php
				}else{
 ?>				<p class="errmsg">No rates found</p>
				</div>
                <?php
				}
				?>   
</div>				
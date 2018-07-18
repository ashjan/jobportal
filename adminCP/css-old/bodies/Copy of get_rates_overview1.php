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
if($propertyroomid ==0){

	if($_SESSION[SESSNAME]['module_id']==2){

		$where.=$tblprefix."changed_standard_rates.pm_id=" .$_SESSION[SESSNAME]['pm_id']." AND ".$tblprefix."changed_standard_rates.property_id=".base64_decode($_GET['pr_id']);
	}else {

		$where.=$tblprefix."changed_standard_rates.pm_id=".base64_decode($_GET['pm_id'])." AND ".$tblprefix."changed_standard_rates.property_id=".base64_decode($_GET['pr_id']);
	}

}else {

	if($_SESSION[SESSNAME]['module_id']==2){

		$where.=$tblprefix."changed_standard_rates.room_type_id=".$propertyroomid." AND ".$tblprefix."changed_standard_rates.pm_id=" .$_SESSION[SESSNAME]['pm_id']." AND ".$tblprefix."changed_standard_rates.property_id=".base64_decode($_GET['pr_id']);
	}else {

		$where.=$tblprefix."changed_standard_rates.room_type_id=".$propertyroomid." AND ".$tblprefix."changed_standard_rates.pm_id=".base64_decode($_GET['pm_id'])." AND ".$tblprefix."changed_standard_rates.property_id=".base64_decode($_GET['pr_id']);
	}
}

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."standard_rates.id,
					".$tblprefix."changed_standard_rates.room_type_id,
					".$tblprefix."changed_standard_rates.property_id,
					".$tblprefix."changed_standard_rates.standard_date,
					".$tblprefix."changed_standard_rates.standard_rate_id,
					".$tblprefix."changed_standard_rates.standard_rate_price,
					".$tblprefix."standard_rates.single_use_option,
					".$tblprefix."standard_rates.single_rate_price,
					".$tblprefix."changed_standard_rates.rooms_for_sale
					FROM
					".$tblprefix."standard_rates
					INNER JOIN ".$tblprefix."changed_standard_rates ON ".$tblprefix."standard_rates.id = ".$tblprefix."changed_standard_rates.standard_rate_id
					INNER JOIN ".$tblprefix."rooms ON ".$tblprefix."changed_standard_rates.room_type_id = ".$tblprefix."rooms.id 
					
				WHERE ".$where." ORDER BY ".$tblprefix."changed_standard_rates.standard_date ASC";


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
	$new_date = date("Y-m-d H:i:s",strtotime($date));
    $qry_booking = "SELECT
	                 id,
					 room_id,
					 check_indate,
					 check_outdate 
					FROM ".$tblprefix."property_booking 
					WHERE pm_id=".$pm_id." AND (check_indate<='".$new_date."' AND check_outdate > '".$new_date."') AND room_id=".$propertyroomid;
	//exit();
	
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
                    ".$tblprefix."property_manager.id,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name 
					FROM
					".$tblprefix."property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();
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
			<input type="hidden" name="mode" value="update_rate" />
        	
        	
        	
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
			<input type="hidden" name="mode" value="update_room" />
        	
        	
        	
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
	 
<!--<input type="hidden" name="propertyroomid" id="propertyroomid" value="<?php //echo $propertyroomid; ?>">-->
   <div style="float:left; width:1300px;"> 
<?php			
$day_arr = array();
$year_arr = array();
$standard_day = array();
$rate_id = array();
$start_month = '';
$end_month = '';
$changed_day = array();
$changed_rates_day = array();
$original_day = array();
$check_property_id = base64_decode($_GET['id']);
if($totalOverviews >0){

?>	
		<div  style="background-color:#0066FF; color:#FFFFFF; font-weight:bold; width:100%;float:left;">
             	 Standard Rates Overview
		</div>
				<?php 
				$single_rate_price = '';
				$standard_rate_price ='';
				$rooms_for_sale = '';
				$standard_rate_array = array();//for getting the rate for a specific date
				$standard_room_array = array();//for getting the rooms for sale on specific date
				$standard_rate_id_array = array();//for getting the standard rate id for specific date
				$single_rate_array = array();//for getting the single rate for specific date
				$standard_room_id = array();
				$standard_property_id = array();
				$standard_days = array();
				$new_dates = array();
			    $rs_limit->MoveFirst();
			    while (!$rs_limit->EOF) {
			    	$date = $rs_limit->fields['standard_date'];
			    	$single_rate_array[$date][] = $rs_limit->fields['single_rate_price'];
			    	$standard_rate_array[$date][] = $rs_limit->fields['standard_rate_price'];
			    	$standard_room_array[$date][] = $rs_limit->fields['rooms_for_sale'];
			    	$standard_rate_id_array[$date][] = $rs_limit->fields['standard_rate_id'];
			    	$standard_room_id[$date][] = $rs_limit->fields['room_type_id'];
			    	$standard_property_id[$date][] = $rs_limit->fields['property_id'];
			    	
			    	$new_dates[] = $rs_limit->fields['standard_date'];
			    	$standard_days[] = $rs_limit->fields['standard_date'];
			    	$rs_limit->MoveNext();
			    }
			   
			    $stdt = base64_decode($_GET['stdt']);
				$endt = base64_decode($_GET['endt']);
			    if(!empty($stdt) && !empty($endt)){

						$start_month =  date("m",strtotime(base64_decode($_GET['stdt'])));

						$end_month =  date("m",strtotime(base64_decode($_GET['endt'])));
						$original_day = DatesBetween($stdt,$endt);
					}// if stdt and endt ends here
					
					else {
						
						$original_day = $new_dates;
					}// if stdt and endt else  ends here
					
					
					/*echo "<pre>";
					print_r($original_day);
					echo "</pre>";
					exit();*/
				if(!empty($original_day)){
					    $curr_month='';
						$previous_month='';
						$curr_year = '';
						$previous_year = '';
						$current_year='';
						$previous_year ='';
						$inner_div='<div class="inner_div">
					<div class="single_div" style="background-color:grey;color:#FFFFFF;border:0px;">Month</div>
					<div class="single_div" style="padding:0px;">'.$rs_limit->fields['room_type'].'</div>
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
						}//foreach ends for getting days and years ends here
						
						foreach ($day_arr as $key=>$year){
							foreach ($year as $keys =>$days){
								//foreach ($month as $keyss=>$days){
								/*echo "<pre>";
								echo ($keys);
								exit();*/
								$current_month = $keys;
								$month =  date("M",strtotime($current_month));
								if($current_month!=$previous_month && array_intersect($days,$standard_days)){
									$previous_month = $keys;
									// if($month==$previous_month AND $year==$arr){
						  ?>
       			       <div class="outer_rates" style="width:100%;border:0px;float:left; padding-top:5px;">                           
                       <?php echo $inner_div;?>
                       <div style="width:100%;" >

						<div class="single_div overview_heading month_style" >
                        <?php echo $previous_month." ". $key;?>
                        <!-- div with width ends-->

                        </div>
                        <!-- div with single ends-->
                       

                        
                        <div class="single_div overview_heading" style="padding:0px;">
                         <?php foreach($days as $day){
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
                         	
                         <?php echo '<div  class="value_div" style=background-color:'.$bgcolor.';color:'.$color.';>'.date("d",strtotime($day)).'</div>'; ?>
                         <?php }?>
                        <!-- overview headings for days ends-->
                        </div>
                        
                        <!-- div for status starts-->
                        <div class="single_div">
					<?php  
					if($check_property_id==0){

						$changed_day = array();

						foreach ($days as $day){
							if(in_array($day,$new_dates) and in_array($day,$standard_days)){
								if($propertyroomid==0){
							$propertyroomid = $standard_room_id[$day][0];
						}//if property room id=0 ends here
								//get total booking for each day which is in array
								$total_booking = get_booking_count1($day,$pm_id,$propertyroomid);
								//$find_room = find_room1($day,$pm_id,$propertyroomid,$standard_rate_id_array[$day][0]);
                                $find_room = $standard_room_array[$day][0];

								$cancelled = get_cancellation_room1($day,$pm_id,$propertyroomid);
								$remaining_rooms = ($find_room+$cancelled)-$total_booking;

								if($remaining_rooms<0){
									$remaining_rooms = 0;
								}
								switch ($remaining_rooms){
					    	case (0):?>
					    	<div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single rate price=".$single_rate_array[$day][0].",standard rate price=".$standard_rate_array[$day][0]?>" border="0"/></div>
					    <?php 
					    break;
					    	case ($remaining_rooms>0):?>
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",remaining room=".$remaining_rooms.",single rate price=".$single_rate_array[$day][0].",standard rate price=".$standard_rate_array[$day][0]?>" border="0"/></div>
					    <?php 
					    break;
					    	default:
					    		echo "";
								}

							} else{?>
					   	 	<div  class="value_div">N/A</div>
					  <?php 
					   }
						}
						
					}
					else {
						
						foreach($days as $day){
							
							if(in_array($day,$new_dates) and in_array($day,$standard_days)){
								if($propertyroomid==0){
							$propertyroomid = $standard_room_id[$day][0];
						}
								//get total booking for each day which is in array
								$total_booking = get_booking_count1($day,$pm_id,$propertyroomid);
								$find_room = $standard_room_array[$day][0];
								 
								$cancelled = get_cancellation_room1($day,$pm_id,$propertyroomid);
								$remaining_rooms = ($find_room+$cancelled)-$total_booking;
								if($remaining_rooms<0){
									$remaining_rooms = 0;
								}
								switch ($remaining_rooms){
					    	case (0):?>
					    	<div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single rate price=".$single_rate_array[$day][0].",standard rate price=".$standard_rate_array[$day][0]?>" border="0"/></div>
					    <?php 
					    break;
					    	case ($remaining_rooms>0):?>
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",remaining room=".$remaining_rooms.",single rate price=".$single_rate_array[$day][0].",standard rate price=".$standard_rate_array[$day][0]?>" border="0"/></div>
					    <?php 
					    break;
					    	default:
					    		echo "";
								}
							} else{?>
					   	 	<div  class="value_div">N/A</div>
					  <?php 
					   }
					 }}?>
                     
                     <!-- div for status ends-->
					</div>
                        
                        <!-- div for displaying single rate price starts-->
					<div class="single_div overview_heading1">
					<?php    		
              	foreach($days as $day){?>
					<?php 
					$year = date("Y",strtotime($day));
					//if($year==$arr){
					if(in_array($day,$new_dates) and in_array($day,$standard_days)){
						echo '<div  class="value_div">'.$single_rate_array[$day][0].'</div>'; }
						else {
							echo '<div class="value_div">N/A</div>';
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

              	if(in_array($day,$new_dates) and in_array($day,$standard_days)){
              		echo  '<div  class="value_div"><a style="cursor:pointer" onclick="popUp(event,\'rates_tip\','.$standard_rate_array[$day][0].','.$pm_id.','.$propertyroomid.',\''.$day.'\','.$standard_property_id[$day][0].','.$standard_rate_array[$day][0].','.$standard_room_array[$day][0].','.$standard_rate_id_array[$day][0].')">'.$standard_rate_array[$day][0].'</a></div>';}
              		else {
              			echo '<div class="value_div">N/A</div>';
              		}
              	?>

					<?php }//}?>
                    <!-- standard rate price div ends-->
     				</div>
					

                     <!-- div for displaying rooms for sale starts-->
     				<div class="single_div overview_heading1">
     				<?php    		
     				if($check_property_id==0){
     					//$changed_day = get_days_changed_specific_rates($pm_id,$propertyroomid,$rs_limit->fields['id']);
     					/*echo "<pre>";
     					print_r($changed_day);
     					echo "</pre>";*/
     					
     					foreach ($days as $day){
     						if($propertyroomid==0){
							$propertyroomid = $standard_room_id[$day][0];
						}
     						if(in_array($day,$new_dates)and in_array($day,$standard_days)){

     							//$find_room = find_room1($day,$pm_id,$propertyroomid,$rs_limit->fields['id']);
     							$find_room = $standard_room_array[$day][0];
					   
					   echo  '<div  class="value_div"><a style="cursor:pointer;" onclick="popUp1(event,\'rooms_tip\','.$pm_id.','.$propertyroomid.',\''.$day.'\','.$standard_property_id[$day][0].','.$standard_rate_id_array[$day][0].','.$find_room.')">'.$find_room.'</a></div>';?>
					   <!--<div  class="value_div" >
					   <a  style="cursor:pointer;" onclick="return open_text_box('<?php echo $pm_id;?>','<?php echo $propertyroomid?>','<?php echo $find_room;?>','<?php echo strtotime($day);?>','<?php echo $standard_property_id[$day][0];?>','<?php echo $rs_limit->fields['id']?>')"><?php echo $find_room;?></a>-->
					   
					  <?php 
					   }else{
					   	echo '<div class="value_div">N/A</div>';
					   }
     					}
     					
     				}else {
     					foreach($days as $day){
     						if(in_array($day,$new_dates)and in_array($day,$standard_days)){
     							//$find_room = find_room1($day,$pm_id,$propertyroomid,$rs_limit->fields['id']);
     							$find_room = $standard_room_array[$day][0];
                                $booked    = get_booking_count1($day,$pm_id,$propertyroomid);
					            $find_room = $find_room-$booked; 
					   echo  '<div  class="value_div"><a style="cursor:pointer;" onclick="popUp1(event,\'rooms_tip\','.$pm_id.','.$propertyroomid.',\''.$day.'\','.$standard_property_id[$day][0].','.$standard_rate_id_array[$day][0].','.$find_room.')">'.$find_room.'</a></div>';?>
					   <!--
					   <div  class="value_div" >
					   <a style="cursor:pointer;" onclick="return open_text_box('<?php echo $pm_id;?>','<?php echo $propertyroomid;?>','<?php echo $find_room;?>','<?php echo strtotime($day);?>','<?php echo $standard_property_id[$day][0];?>','<?php echo $standard_rate_id_array[$day][0]?>')"><?php echo $find_room;?></a>>
					   </div>-->
					  <?php 

					     }else{
					   	echo '<div class="value_div">N/A</div>';
					   }
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
					if(in_array($day,$new_dates) && in_array($day,$standard_days)){
						echo '<div  class="value_div">'.get_booking_count1($day,$pm_id,$propertyroomid).'</div>';}
						else {
							echo '<div class="value_div">N/A</div>';
						}
                     }//}?>
              <!-- div for displaying booked ends-->
     				</div>
                        
					<div class="single_div overview_heading1">
     				<?php    		
     				foreach($days as $day){
     					if(in_array($day,$new_dates)and in_array($day,$standard_days)){
     						$cancelled = get_cancellation_room1(date("m/d/Y",strtotime($day)),$pm_id,$propertyroomid);
     						echo '<div  class="value_div">'.$cancelled.'</div>';
     					}else {
     						echo '<div class="value_div">N/A</div>';
     					}
              	 }//}?>
             <!-- div for displaying cancelled ends-->
     				</div>
     				</div>
						
                        
                        
				<?php }//if cureent month ends here
					}//foreach year ends here
				
						}//for each day_arr ends here
				}//if empty new_dates ends here
				else {
					?>
					<p class="errmsg">No rates found</p>
				</div>
				<?php }}else {?>
                <p class="errmsg">No rates found</p>
				</div>
				<?php 	
				}
				?>
				<div style="float:left; width:100%;">
				<form action="admin.php" method="POST" enctype="multipart/form-data">
				<table id="textbox" style="display:none">
				<tr>
				<td>
				<input type="text" name="value_of_rooms" value="" id="value_of_rooms" /></td>
				<td>
				<input type="submit" name="submit" value="Change room" />
				<!--<a onclick="return set_property_room_value('newroomvalues','<?php echo MYSURL."ajaxresponse/set_property_room_value.php"?>');">Change value</a>--></td>
				</tr>
				<input type="hidden" name="request_page" value="manage_rates_overview"/>
				<input type="hidden" name="act" value="manage_rates_overview" />
				<input type="hidden" name="mode" value="update_room" />
				<input type="hidden" name="start_date" value="<?php echo $_GET['stdt']?>" />
				<input type="hidden" name="end_date" value="<?php echo $_GET['endt']?>" />
				<input type="hidden" name="value_property_id" id="value_property_id" />
				<input type="hidden" name="value_pmi_d" id="value_pm_id"/>
				<input type="hidden" name="value_room_id" id="value_room_id"/>
				<input type="hidden" name="value_day" id="value_day"/>
				<input type="hidden" name="value_rate_id" id="value_rate_id"/>
				</table>
				</form>
                </div>
</div>	               				
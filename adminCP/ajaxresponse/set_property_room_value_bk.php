<?php
include('root.php');
include($root.'include/file_include.php');
$roomid=$_GET['room_type_id'];//property id for example serena view
$pm_id = $_GET['pm_id'];
$rooms = $_GET['rooms'];
$property_id = $_GET['property_id'];//rooms id for example 3 bed rooms
$date = date("m/d/Y",strtotime($_GET['date']));


$qry_select = "SELECT * FROM ".$tblprefix."standard_date WHERE standard_date='".$date."' AND pm_id='".$pm_id."' AND property_id='".$roomid."' AND room_type_id='".$property_id."'";
$rs_select = $db->Execute($qry_select);
$count_select =  $rs_select->RecordCount();

if($count_select > 0){

	$update_query = "UPDATE ".$tblprefix."standard_date
	                 SET
	                 no_of_rooms='".$rooms."'
	                 WHERE id='".$rs_select->fields['id']."'	                 
	                 ";

	$db->Execute($update_query);
}else {
	$date=date("m/d/Y",strtotime($date));
	$insert_query = "INSERT ".$tblprefix."standard_date
	                 SET
	                 no_of_rooms='".$rooms."',
	                 standard_date='".$date."',
	                 room_type_id='".$property_id."',
	                 property_id='".$roomid."',
	                 pm_id='".$pm_id."'
	                 ";
	$db->Execute($insert_query);
}

$qry_rates = "SELECT ".$tblprefix."rooms.room_type,
					 ".$tblprefix."standard_rates.id,
					 ".$tblprefix."standard_rates.room_type_id,
					 ".$tblprefix."standard_rates.property_id,
					 ".$tblprefix."standard_rates.standard_start_date,
					 ".$tblprefix."standard_rates.standard_end_date,
					 ".$tblprefix."standard_rates.standard_rate_price,
					 ".$tblprefix."standard_rates.single_use_option,
					 ".$tblprefix."standard_rates.single_start_date,
					 ".$tblprefix."standard_rates.single_end_date,
					 ".$tblprefix."standard_rates.single_rate_price,
					 ".$tblprefix."standard_rates.rooms_for_sale
					 FROM
					 ".$tblprefix."standard_rates
				inner Join ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id
				WHERE ".$tblprefix."standard_rates.room_type_id =".$property_id." and ".$tblprefix."standard_rates.pm_id=".$pm_id;

$rs_rates = $db->Execute($qry_rates);
$rates_arr=array();
$rates_arr[]=$rs_rates->fields;

$totalOverviews=$rs_rates->RecordCount();

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


$count_add =  $rs_rates->RecordCount();
$totalRows = $count_add;

$slug_query = "SELECT properties_slug FROM ".$tblprefix."properties WHERE id='".$rs_rates->fields['property_id']."'";
$execute = $db->Execute($slug_query);

$price = "SELECT price FROM ".$tblprefix."property_booking WHERE property_id='".$execute->fields['properties_slug']."'";
$rs_price = $db->Execute($price);

$cancellation_charges = (float)($rs_price->fields['price']*($cancellation_rs->fields['cancellation_charges_percent']/100));

$qry_booking = "SELECT check_indate, check_outdate from ".$tblprefix."property_booking WHERE property_id='".$execute->fields['properties_slug']."'";

$rs_booking = $db->Execute($qry_booking);
$qry_cancel = "SELECT cancellation_charges_percent from ".$tblprefix."property_policy";
$rs_cutting = $db->Execute($qry_cancel);

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."standard_rates.id,
					".$tblprefix."standard_rates.room_type_id,
					".$tblprefix."standard_rates.property_id,
					".$tblprefix."standard_rates.standard_start_date,
					".$tblprefix."standard_rates.standard_end_date,
					".$tblprefix."standard_rates.standard_rate_price,
					".$tblprefix."standard_rates.single_use_option,
					".$tblprefix."standard_rates.single_start_date,
					".$tblprefix."standard_rates.single_end_date,
					".$tblprefix."standard_rates.single_rate_price,
					".$tblprefix."standard_rates.rooms_for_sale
					FROM
					".$tblprefix."standard_rates
					inner Join ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id 
				WHERE ".$tblprefix."standard_rates.room_type_id =".$property_id." and ".$tblprefix."standard_rates.pm_id=".$pm_id;;
$rs_limit = $db->Execute($qry_limit);

//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_room = $db->Execute($qry_region);
$count_region =  $rs_room->RecordCount();
$totalRegions = $count_region;


$qry_standard_date ="SELECT standard_date,no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id='".$pm_id."' AND room_type_id='".$property_id."'";
$rs_standard_date =$db->Execute($qry_standard_date);

function DatesBetween($startDate, $endDate){
	// get the number of days between the two given dates.
	$days = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
	$startMonth = date("m", strtotime($startDate));
	$startDay = date("d", strtotime($startDate));
	$startYear = date("Y", strtotime($startDate));
	$dates;//the array of dates to be passed back
	for($i=0; $i<$days; $i++){
		$dates[$i] = date("n/j/Y", mktime(0, 0, 0, $startMonth , ($startDay+$i), $startYear));
	}
	return $dates;
}
function dateValues($dates =array()){
	$date_value = array();
	for($i=0;$i< count($dates);$i++){
		$date_value[]=date("d",strtotime($dates[$i]));
	}

	return $date_value;
}
function getBookingCount($property_id='')
{
	global $db;
	$qry_booking = "SELECT count(id) AS booking FROM tbl_property_booking WHERE property_id='".$property_id."'";
	$rs_booking = $db->Execute($qry_booking);
	return $rs_booking->fields['booking'];
}
function findRoom($month=0,$date=0,$year=0,$pm_id=0,$room_type_id=0){
	global $db;
	$value=$month."/".$date."/".$year;
	$value=date("m/d/Y",strtotime($value));
	$qry_room = "SELECT no_of_rooms FROM tbl_standard_date WHERE standard_date='".$value."' AND pm_id=".$pm_id." AND room_type_id=".$room_type_id;
    $rs_room = $db->Execute($qry_room);
	return $rs_room->fields['no_of_rooms'];
}
$qry_standard_rooms ="SELECT standard_date,no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$property_id;




$rs_standard_rooms = $db->Execute($qry_standard_rooms);

$count_standard_rooms = $rs_standard_rooms->RecordCount();
?>
<div id="newroomvalues">
<input type="hidden" name="propertyroomid" id="propertyroomid" value="<?php echo $propertyroomid; ?>">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
       
	  				<tr>
				<td colspan="13">
				<?php 
				if($totalOverviews >0){
					$rs_limit->MoveFirst();
				?>	
		<table cellpadding="1" cellspacing="0" cellpadding="0" width="100%" style="background-color:#0066FF; color:#FFFFFF; font-weight:bold;">
					<tr>
					<td>
					 Standard Rates Overview
					</td>
					</tr>
		</table>
					<?php 
					while(!$rs_limit->EOF){
					?>
					<table cellpadding="1" cellspacing="0" cellpadding="0" width="100%">
					<tr style="background-color:#999999; color:#FFFFFF; font-weight:bold;" >
			        <td>
                    <?php echo $rs_limit->fields['room_type']; 
                    echo "&nbsp;";
					?> 					
					</td> 
					<td><?php 
					$date=$rs_limit->fields['standard_start_date'];
					$today=date($date);
					$month = date ("M",strtotime($today));

					switch($month){
						case 'Jan':
							echo 'January';
							$month_value = 01;
							break;

						case 'Feb':
							echo "February";
							$month_value = 02;
							break;

						case 'Mar':
							echo "March";
							$month_value = 03;
							break;

						case 'apr':
							echo "April";
							$month_value = 04;
							break;


						case 'May':
							echo "May";
							$month_value = 05;
							break;


						case 'Jun':
							echo "June";
							$month_value = 06;
							break;


						case 'Jul':
							echo "July";
							$month_value = 07;
							break;


						case 'Aug':
							echo "August";
							$month_value = 08;
							break;


						case 'Sep':
							echo "September";
							$month_value = 09;
							break;


						case 'Oct':
							echo "October";
							$month_value = 10;
							break;


						case 'Nov':
							echo "November";
							$month_value = 11;
							break;

						case 'Dec':
							echo "December";
							$month_value = 12;
							break;

					}

?></td>
					</tr>
					</table>
					<table cellpadding="1" cellspacing="0" cellpadding="0" border="1" bordercolor="#666666" width="100%">
					<tr>
					<th></th>
					<?php
					
					for($i=1; $i<=31; $i++){
						echo '<td  class=\'txtnew\'>'.$i.'</td>';
					}
					?>
					</tr> 
					
					<tr>					
					<td class="txtnewb"><b>Status</b></td> <?php
					$k = 0;	
					$date=$rs_limit->fields['standard_start_date'];
					$today=date($date);
					$month = date ("M",strtotime($today));
					if($month='Dec'){
						for($j=1;$j<=31;$j++){
							$days[$j]=$j;
						}
					}elseif($month='Jan'){
						for($j=1;$j<=31;$j++){
							$days[$j]=$j;
						}
					}
					for($i=1; $i<=31;$i++){
						$sdate = $rs_limit->fields['standard_start_date'];
						$edate = $rs_limit->fields['standard_end_date'];
						$dates = DatesBetween($sdate,$edate);
						$values = dateValues($dates);

						$standard_start_date = $rs_rates->fields['standard_start_date'];
						$standard_end_date = $rs_rates->fields['standard_end_date'];
						$standard_dates = DatesBetween($standard_start_date,$standard_end_date);
						$s_b_date = $rs_booking->fields['check_indate'];
						$s_e_date = $rs_booking->fields['check_outdate'];
						$s_b_dates = DatesBetween($s_b_date,$s_e_date);
						$s_values = dateValues($s_b_dates);
						$first_day_changed=array();
						while(!$rs_standard_rooms->EOF){
							$first_day_changed[]= date("d",strtotime($rs_standard_rooms->fields['standard_date']));
							$rs_standard_rooms->MoveNext();
						}
						
                       
                        
						echo '<td class=\'txtnewbb\'>';
						
						if(in_array($i,$first_day_changed)){
							$find_room = findRoom($month_value,$first_day_changed[$k],date("Y"),$pm_id,$propertyroomid);
							$total_booking = getBookingCount($execute->fields['properties_slug']);
							$remaining_rooms = $find_room - $total_booking;

							if($remaining_rooms<0){
								$remaining_rooms = 0;
							}
							if($remaining_rooms==0){
								echo '<img src="graphics/red.jpg" title="Make Default" border="0"/>';
							}else {
								echo '<img src="graphics/green.jpg" title="Make Default" border="0"/>';
								echo '</td>';
							}

						}else {
							if(in_array($i,$s_values)){
								$total_booking = getBookingCount($execute->fields['properties_slug']);
								$remaining_rooms = $rooms_for_sale - $total_booking;
								if($remaining_rooms<0){
									$remaining_rooms = 0;
								}
								if($remaining_rooms==0){
									echo '<img src="graphics/red.jpg" title="Make Default" border="0"/>';
								}else {
									echo '<img src="graphics/green.jpg" title="Make Default" border="0"/>';
									echo '</td>';
								}
							}else {


								if(in_array($i,$values)){
									echo '<img src="graphics/green.jpg" title="Make Default" border="0" />';

								}else{
									echo '<img src="graphics/red.jpg" title="Make Default" border="0"/>';
									echo '</td>';
								}

							}
						}
					}

	?>
	</tr>

<tr>					
	<td class="txtnewb"><b>Single Use Rate Per Night</b></td>  
	
	<?php
	for($i=1; $i<=31; $i++){
		$sdate = $rs_limit->fields['standard_start_date'];
		$edate = $rs_limit->fields['standard_end_date'];
		$dates = DatesBetween($sdate,$edate);
		$values = dateValues($dates);

		if(in_array($i,$values)){
			echo'<td class=\'txtnew\'>'.$rs_limit->fields['single_rate_price'].'</td>' ;
		}else {
			echo '<td class=\'txtnew\'>0</td>';
		}
	}
	?>
<!--<td>NO</td>
	<td>50</td> 
	<td>50</td>  
	<td>NO</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	 <td>&nbsp;</td> -->
</tr>

<tr>					
	<td class="txtnewb"><b>Rate Per Night</b></td> 
	<?php
	for($i=1; $i<=31; $i++){
		$sdate = $rs_limit->fields['standard_start_date'];
		$edate = $rs_limit->fields['standard_end_date'];
		$dates = DatesBetween($sdate,$edate);
		$values = dateValues($dates);
		if(in_array($i,$values)){
			echo '<td class=\'txtnew\'>'.$rs_limit->fields['standard_rate_price'].'</td>' ;
		} else {
			echo '<td class=\'txtnew\'>0</td>';
		}
	}
	?>
	
	  
	<!--<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	 <td>&nbsp;</td>  -->
</tr>

<tr>					
<td class="txtnewb"><b>Rooms to sell</b></td>   
<?php  
$rooms_for_sale=$rs_limit->fields['rooms_for_sale'];
?>
<?php 
$j = 0;
for($i=1; $i<=31; $i++){
	$sdate = $rs_limit->fields['standard_start_date'];
	$edate = $rs_limit->fields['standard_end_date'];
	$dates = DatesBetween($sdate,$edate);
	$values = dateValues($dates);
	$standard_start_date = $rs_rates->fields['standard_start_date'];
	$standard_end_date = $rs_rates->fields['standard_end_date'];
	$standard_dates = DatesBetween($standard_start_date,$standard_end_date);
	$s_b_date = $rs_booking->fields['check_indate'];
	$s_e_date = $rs_booking->fields['check_outdate'];
	$s_b_dates = DatesBetween($s_b_date,$s_e_date);
	$s_values = dateValues($s_b_dates);

	$rs_standard_rooms->MoveFirst();
	$first_day_changed=array();
	while(!$rs_standard_rooms->EOF){
		$first_day_changed[]= date("d",strtotime($rs_standard_rooms->fields['standard_date']));
		$rs_standard_rooms->MoveNext();
	}

	if(in_array($i,$first_day_changed)){
		$find_room = findRoom($month_value,$first_day_changed[$j],date("Y"),$pm_id,$property_id);
		$total_booking = getBookingCount($execute->fields['properties_slug']);
		$remaining_rooms = $find_room - $total_booking;
		if($remaining_rooms <0){
			$remaining_rooms =0;
		}
		echo '<td class=\'txtnew\'><a onclick=\'open_text_box('.$pm_id.','.$property_id.','.$find_room.','.$i.','.$month_value.','.date("Y").');\'>'.$remaining_rooms.'</a></td>';
		$j++;

	}else {

		if(in_array($i,$s_values)){
			$total_booking = getBookingCount($execute->fields['properties_slug']);
			$remaining_rooms = $rooms_for_sale - $total_booking;
			if($remaining_rooms<0){
				$remaining_rooms = 0;
			}
			echo '<td class=\'txtnew\'><a onclick=\'open_text_box('.$pm_id.','.$property_id.','.$remaining_rooms.','.$i.','.$month_value.','.date("Y").');\'>'.$remaining_rooms.'</a></td>';
		}else {
			if(in_array($i,$values)){

				echo	'<td class=\'txtnew\'><a onclick=\'open_text_box('.$pm_id.','.$property_id.','.$rooms_for_sale.','.$i.','.$month_value.','.date("Y").');\'>'.$rooms_for_sale.'</a></td>' ;
			} else {
				echo '<td class=\'txtnew\'><a onclick=\'open_text_box('.$pm_id.','.$property_id.',0,'.$i.','.$month_value.','.date("Y").');\'>0</a></td>';
			}
		}
	}

}
	?>


	<!--<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	 <td>&nbsp;</td>  -->
</tr>
				

<tr>

	<td class="txtnewb"><b>Booked</b></td>  
		<?php 
		for($i=1; $i<=31; $i++){
			$standard_start_date = $rs_rates->fields['standard_start_date'];
			$standard_end_date = $rs_rates->fields['standard_end_date'];
			$standard_dates = DatesBetween($standard_start_date,$standard_end_date);
			$standard_values = dateValues($standard_dates);
			$sdate = $rs_booking->fields['check_indate'];
			$edate = $rs_booking->fields['check_outdate'];
			$dates = DatesBetween($sdate,$edate);
			$values = dateValues($dates);
			/*
			count($dates);
			echo '<pre>';
			print_r($dates);
			echo '</pre>';
			exit();*/
			if(in_array($i,$values)){
				echo '<td class=\'txtnew\'>'.getBookingCount($execute->fields['properties_slug']).'</td>';
			}else {
				echo '<td class=\'txtnew\'>0</td>';
			}
		}
	    ?>

	<!--<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td>  
	<td>&nbsp;</td> 
	<td>&nbsp;</td>  
	<td>&nbsp;</td> -->  
</tr>

<tr>
<td class="txtnewb"><b>Cancelled</b></td> 
<?php 
for($i=1; $i<=31; $i++){
	$standard_start_date = $rs_rates->fields['standard_start_date'];
	$standard_end_date = $rs_rates->fields['standard_end_date'];
	$standard_dates = DatesBetween($standard_start_date,$standard_end_date);
	$standard_values = dateValues($standard_dates);
	$sdate = $rs_booking->fields['check_indate'];
	$edate = $rs_booking->fields['check_outdate'];
	$dates = DatesBetween($sdate,$edate);
	$values = dateValues($dates);
	/*$rate = $rs_limit->fields['standard_rate_price'];
	(float)$percut = $rs_cutting->fields['cancellation_charges_percent'];
	(float)$cutting= rate*$percut/100; */
	if(in_array($i,$values)){
		echo	'<td class="txtnew">'.number_format($cancellation_charges,2).'</td>' ;
	}else {
		echo '<td class=\'txtnew\'>0</td>';
	}
}
	?>
</tr>


<!--<tr>
<td class="txtnewb"><b>Service Charges</b></td> 
<?php 
	/*for($i=1; $i<=31; $i++){
	if($rs_vat_tax->fields['service_charges_type']==1){
	$vat_tax_service=  $rs_vat_tax->fields['service_charge_amount'];
	//(float)$percut = $rs_cutting->fields['cancellation_charges_percent'];
	//(float)$cutting= rate*$percut/100;
	echo	'<td class=\'txtnew\'>'.round($vat_tax_service,0).'</td>' ;
	}else{
	echo	'<td class=\'txtnew\'>0</td>' ;
	}
	?>

	<?php
	}*/
	?>
</tr>-->



</table>					 
					<?php
					$rs_limit->MoveNext();
					}// while(!$rs_overview->EOF)
			    ?>
				</td>
				</tr>
<?php
				}else{
 ?>				
				<tr>
				<td colspan="13" class="errmsg">No Rates  Found</td>
				</tr>
                </table>
               
                <?php
				}
				?>
				<div id=""></div>
				<table id="textbox" style="display:none">
				<tr>
				<td><input type="text" name="value_of_rooms" value="" id="value_of_rooms" /></td>
				<td><a onclick="return set_property_room_value('newroomvalues','<?php echo MYSURL."ajaxresponse/set_property_room_value.php"?>');">Change value</a></td>
				</tr>
				<input type="hidden" name="value_pmi_d" id="value_pm_id">
				<input type="hidden" name="value_room_id" id="value_room_id">
				<input type="hidden" name="value_date_id" id="value_date_id">
				<input type="hidden" name="value_month_id" id="value_month_id">
				<input type="hidden" name="value_year_id" id="value_year_id">
				</table>
				

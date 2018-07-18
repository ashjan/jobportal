<?php
include('root.php');
include($root.'include/file_include.php');
$propertyroomid=$_GET['id'];

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
				WHERE ".$tblprefix."standard_rates.room_type_id =".$propertyroomid;

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
				WHERE ".$tblprefix."standard_rates.room_type_id =".$propertyroomid;
				$rs_limit = $db->Execute($qry_limit);
				//query for the room type drop down
				$qry_region = "SELECT * FROM ".$tblprefix."rooms";
				$rs_room = $db->Execute($qry_region);
				$count_region =  $rs_room->RecordCount();
				$totalRegions = $count_region;

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

?>

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
       break;

case 'Feb':
       echo "February";
       break;

case 'Mar':
        echo "March";
       break;

case 'apr':
        echo "April";
       break;


case 'May':
        echo "May";
       break;


case 'Jun':
        echo "June";
       break;


case 'Jul':
        echo "July";
       break;


case 'Aug':
        echo "August";
       break;


case 'Sep':
         echo "September";
       break;


case 'Oct':
        echo "October";
       break;


case 'Nov':
        echo "November";
       break;

case 'Dec':
        echo "December";
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
	echo '<td class=\'txtnewbb\'>';
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
for($i=1; $i<=31; $i++){
	$sdate  = $rs_limit->fields['standard_start_date'];
	$edate  = $rs_limit->fields['standard_end_date'];
	$dates  = DatesBetween($sdate,$edate);
	$values = dateValues($dates);
	$standard_start_date = $rs_rates->fields['standard_start_date'];
	$standard_end_date   = $rs_rates->fields['standard_end_date'];
	$standard_dates      = DatesBetween($standard_start_date,$standard_end_date);
	$s_b_date            = $rs_booking->fields['check_indate'];
	$s_e_date            = $rs_booking->fields['check_outdate'];
	$s_b_dates           = DatesBetween($s_b_date,$s_e_date);
	$s_values            = dateValues($s_b_dates);
	if(in_array($i,$s_values)){
		$total_booking = getBookingCount($execute->fields['properties_slug']);
		$remaining_rooms = $rooms_for_sale - $total_booking;
		if($remaining_rooms<0){
			$remaining_rooms = 0;
		}
		echo '<td class=\'txtnew\'>'.$remaining_rooms.'</td>';
	}else {
	if(in_array($i,$values)){
	echo	'<td class=\'txtnew\'>'.$rooms_for_sale.'</td>' ;
	} else {
		echo '<td class=\'txtnew\'>0</td>';
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
		$standard_end_date   = $rs_rates->fields['standard_end_date'];
		$standard_dates      = DatesBetween($standard_start_date,$standard_end_date);
		$standard_values     = dateValues($standard_dates);
		$sdate  = $rs_booking->fields['check_indate'];
		$edate  = $rs_booking->fields['check_outdate'];
		$dates  = DatesBetween($sdate,$edate);
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
		$standard_end_date   = $rs_rates->fields['standard_end_date'];
		$standard_dates      = DatesBetween($standard_start_date,$standard_end_date);
		$standard_values     = dateValues($standard_dates);
		$sdate  = $rs_booking->fields['check_indate'];
		$edate  = $rs_booking->fields['check_outdate'];
		$dates  = DatesBetween($sdate,$edate);
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
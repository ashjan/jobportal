<?php
include('root.php');
include($root.'include/file_include.php');
$propertyroomid=$_GET['id'];
$pm_id = $_GET['pm_id'];

$qry_rates = "SELECT ".$tblprefix."rooms.room_type,
					 ".$tblprefix."standard_rates.id,
					 ".$tblprefix."standard_rates.property_id,
					 ".$tblprefix."standard_rates.room_type_id,
					 ".$tblprefix."standard_rates.advance_start_date,
					 ".$tblprefix."standard_rates.advance_end_date,
					 ".$tblprefix."standard_rates.advance_rate_price,
					 ".$tblprefix."standard_rates.advance_use_option,
					 ".$tblprefix."standard_rates.single_adv_rate_price,
					 ".$tblprefix."standard_rates.adv_rooms_for_sale
					 FROM
					 ".$tblprefix."standard_rates
				inner Join ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id
				WHERE ".$tblprefix."standard_rates.room_type_id =".$propertyroomid." AND ".$tblprefix."standard_rates.advance_use_option=1";

$rs_rates = $db->Execute($qry_rates);
$rates_arr=array();
$rates_arr[]=$rs_rates->fields;

$totalOverviews=$rs_rates->RecordCount();


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


$qry_booking = "SELECT check_indate, check_outdate from ".$tblprefix."property_booking";
$rs_booking = $db->Execute($qry_booking);
$qry_cancel = "SELECT cancellation_charges_percent from ".$tblprefix."property_policy";
$rs_cutting = $db->Execute($qry_cancel);

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."standard_rates.id,
					".$tblprefix."standard_rates.room_type_id,
					".$tblprefix."standard_rates.property_id,
					".$tblprefix."standard_rates.advance_start_date,
					".$tblprefix."standard_rates.advance_end_date,
					".$tblprefix."standard_rates.advance_rate_price,
					".$tblprefix."standard_rates.advance_use_option,
					".$tblprefix."standard_rates.single_adv_rate_price,
					".$tblprefix."standard_rates.adv_rooms_for_sale
					FROM
					".$tblprefix."standard_rates
					inner Join ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id 
				WHERE ".$tblprefix."standard_rates.room_type_id =".$propertyroomid." AND ".$tblprefix."standard_rates.pm_id=".$pm_id." AND ".$tblprefix."standard_rates.advance_use_option=1";


$rs_limit = $db->Execute($qry_limit);
//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_room = $db->Execute($qry_region);
$count_region =  $rs_room->RecordCount();
$totalRegions = $count_region;

$slug_query = "SELECT properties_slug FROM ".$tblprefix."properties WHERE id='".$rs_rates->fields['property_id']."'";

$execute = $db->Execute($slug_query);

$price = "SELECT price FROM ".$tblprefix."property_booking WHERE property_id='".$execute->fields['properties_slug']."'";
$rs_price = $db->Execute($price);

$cancellation_charges = (float)($rs_price->fields['price']*($cancellation_rs->fields['cancellation_charges_percent']/100));

$qry_booking = "SELECT check_indate, check_outdate from ".$tblprefix."property_booking WHERE property_id='".$execute->fields['properties_slug']."'";

$rs_booking = $db->Execute($qry_booking);

$qry_advance_rooms ="SELECT advance_date,no_of_rooms FROM ".$tblprefix."advance_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." ORDER BY id ASC";

$rs_standard_rooms = $db->Execute($qry_advance_rooms);

$count_advance_rooms = $rs_standard_rooms->RecordCount();
$qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."cancellation WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid."";
$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);
//function for new logic
function get_cancellation_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."cancellation WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."')";
$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);
    
	return $rs_tbl_cancellation->fields['cancelled'];


}
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
//function for new logic
function get_booking_count1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
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
//function for new logic
function find_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."advance_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND advance_date='".$new_date."'";

    $rs_room = $db->Execute($qry_room);
    return $rs_room->fields['no_of_rooms'];

}
function find_room($date='',$day='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$month = date("m",strtotime($date));
	$year = date("Y",strtotime($date));
	$dates = $month."/".$day."/".$year;
	$new_date = date("m/d/Y",strtotime($dates));
	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."advance_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND advance_date='".$new_date."'";
    
    $rs_room = $db->Execute($qry_room);
    return $rs_room->fields['no_of_rooms'];

}

function DatesBetween($startDate, $endDate){
	// get the number of days between the two given dates.
	$days = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
	$startMonth = date("m", strtotime($startDate));
	$startDay = date("d", strtotime($startDate));
	$startYear = date("Y", strtotime($startDate));
	$dates;//the array of dates to be passed back
	for($i=0; $i<$days; $i++){
		$dates[$i] = date("m/d/Y", mktime(0, 0, 0, $startMonth , ($startDay+$i), $startYear));
	}
	return $dates;
}
function dateValues($dates = array()){
    $date_value = array();
	for($i=0;$i< count($dates);$i++){
		
		$date_value[]=date("d",strtotime($dates[$i]));
	}

	return $date_value;
}
function dateValues1($dates = array()){
	
    $date_value = array();
	foreach ($dates as $date){
		$date_value[] = date("d",strtotime($date));
	}

	return $date_value;
}
function monthValues($dates=array()){

	$month_value =array();
	for($i=0;$i< count($dates);$i++){
		$month_value[]=date("M",strtotime($dates[$i]));
	}
	return $month_value;
}

function yearValues($dates=array()){

	$year_value =array();
	for($i=0;$i< count($dates);$i++){
		$year_value[]=date("Y",strtotime($dates[$i]));
	}
	return $year_value;
}
function getBookingCount($property_id='')
{
	global $db;
	global $tblprefix;
	$qry_booking = "SELECT count(id) AS booking FROM ".$tblprefix."property_booking WHERE property_id='".$property_id."'";
	$rs_booking = $db->Execute($qry_booking);
	return $rs_booking->fields['booking'];
}
function findRoom($date=0,$pm_id=0,$room_type_id=0){
	global $db;
    global $tblprefix;
	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."advance_date WHERE advance_date='".$date."' AND pm_id=".$pm_id." AND room_type_id=".$room_type_id;

	$rs_room = $db->Execute($qry_room);
	return $rs_room->fields['no_of_rooms'];
}
function getBookingCountForDate($property_id='',$date = 0){
	global $db;
    global $tblprefix;
	$qry_booking = "SELECT count(id) AS booking FROM ".$tblprefix."property_booking WHERE property_id='".$property_id."' AND (check_indate='".$date."' OR check_outdate='".$date."')";
	$rs_booking = $db->Execute($qry_booking);
	return $rs_booking->fields['booking'];
}
function dayofyear2date( $tDay, $tFormat = 'm/d/Y' ) {

	$day = intval( $tDay );

	$day = ( $day == 0 ) ? $day : $day - 1;
	$offset = intval( intval( $tDay ) * 86400 );

	$date = mktime( 0, 0, 0, 1, 1, date('Y') )+$offset;
	// $str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
	return( $date );
}



?>
<div style="float:left; width:100%;"> 
<?php			
$day_arr = array();
$original_day = array();
if($totalOverviews >0){
				  $rs_limit->MoveFirst();
?>	
<div  style="background-color:#0066FF; color:#FFFFFF; font-weight:bold; width:100%;float:left;">
             	 Advance Rates Overview
		</div>
				<?php 
					while(!$rs_limit->EOF){
					$j = date("z",strtotime($rs_limit->fields['advance_start_date']))+1;//initializing for number of days in a year 

					$first_day_changed = array();
                    $start_day =  date("z",strtotime($rs_limit->fields['advance_start_date']));
					$end_day =  date("z",strtotime($rs_limit->fields['advance_end_date']));
					for($k = $start_day;$k<=$end_day;$k++){
						$original_day[] = date("m/d/Y",dayofyear2date($k));
					}
					while(!$rs_standard_rooms->EOF){
							$first_day_changed[] = $rs_standard_rooms->fields['advance_date'];
							$rs_standard_rooms->MoveNext();
						}
						
		if(!empty($original_day)){
					?>
					<?php    		
              	$curr_month='';
				$previous_month='';
				$my_counter=0;
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
              		$day_arr[$curr_month][] = $day;
              	  	}
				
              	  	foreach ($day_arr as $key=>$days){
              	  		
						$current_month = $key;
						if($current_month!=$previous_month){
						  $previous_month = $key;?>
       			       <div class="outer_rates" style="width:100%;border:0px;float:left;">                           
                       <?php echo $inner_div;?>
                       <div style="width:100%;" >

						<div class="single_div overview_heading" style="width:100%">
                        <?php echo $previous_month?>
                        <!-- div with width ends-->

                        </div>
                        <!-- div with single ends-->
                       

                        
                        <div class="single_div overview_heading">
                         <?php foreach($days as $day){?>
                         <?php echo '<div  class="value_div">'.date("d",strtotime($day)).'</div>'; ?>
                         <?php }?>
                        <!-- overview headings for days ends-->
                        </div>
                        
                        <!-- div for status starts-->
                        <div class="single_div">
					<?php    		
              	foreach($days as $day){
					   if(in_array($day,$first_day_changed)){
					   	//get total booking for each day which is in array
					   	
					    $total_booking = get_booking_count1($day,$pm_id,$propertyroomid);
					    
					    $find_room = find_room1($day,$pm_id,$propertyroomid);
					    
					    $cancelled = get_cancellation_room1($day,$pm_id,$propertyroomid);
					    
					    $remaining_rooms = ($find_room+$cancelled)-$total_booking;
					    
					    if($remaining_rooms<0){
					    	
					    	$remaining_rooms = 0;
					    }
					    
					    switch ($remaining_rooms){
					    	
					    	case (0):?>
					    	<div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single advance rate price=".$rs_limit->fields['single_adv_rate_price'].",advance rate price=".$rs_limit->fields['advance_rate_price']?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_rooms>0):?>
					    	
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",remaining room=".$remaining_rooms.",single advance rate price=".$rs_limit->fields['single_adv_rate_price'].",advance rate price=".$rs_limit->fields['advance_rate_price']?>" border="0"/></div>
					    <?php 
					    		break;
					    	
					    		default:
					    			echo "";
					   				   
					    }
					    
					   }else {
					   	    
					   	    $total_booking = get_booking_count1($day,$pm_id,$propertyroomid);
					   	    
							$rooms_for_sale = $rs_limit->fields['adv_rooms_for_sale'];
							
							$cancelled = get_cancellation_room1($day,$pm_id,$propertyroomid);
							
							$remaining_rooms = ($rooms_for_sale+$cancelled)-$total_booking;
							
							
							if($remaining_rooms<0){
					    	
					    	$remaining_rooms = 0;
					    }
					     switch ($remaining_rooms){
					    	
					    	case (0):?>
							 <div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single advance user rate per night=".$rs_limit->fields['single_adv_rate_price'].",advance rate price=".$rs_limit->fields['advance_rate_price']?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_rooms>0):?>
					    	
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",remaining rooms=".$remaining_rooms.",single advance rate price=".$rs_limit->fields['single_adv_rate_price'].",advance rate price=".$rs_limit->fields['advance_rate_price']?>" border="0"/></div>
					    <?php 
					    		break;
					    	
					    		default:
					    			echo "";
					   				   
					    }
					   }
					 }?>
                     
                     <!-- div for status ends-->
					</div>
                    
                    <!-- div for displaying single rate price starts-->
					<div class="single_div overview_heading1">
					<?php    		
              	foreach($days as $$day){?>
					<?php echo '<div  class="value_div">'.$rs_limit->fields['single_adv_rate_price'].'</div>'; ?>
					<?php }?>
                    					<!-- div for displaying single rate ends-->
					</div>
                    <!-- standard rate price div starts-->
                    <div class="single_div overview_heading1">
     				<?php    		
              	foreach($days as $day){?>
					<?php echo  '<div  class="value_div">'.$rs_limit->fields['advance_rate_price'].'</div>';?>

					<?php }?>
                    <!-- standard rate price div ends-->
     				</div>


                     <!-- div for displaying rooms for sale starts-->
     				<div class="single_div overview_heading1">
     				<?php    		
              	foreach($days as $day){
					   if(in_array($day,$first_day_changed)){
					   $find_room = find_room1($day,$pm_id,$propertyroomid);
					   ?>	
					   <div  class="value_div" >
					   <a onclick="return open_text_box('<?php echo $pm_id;?>','<?php echo $propertyroomid?>','<?php echo $find_room;?>','<?php echo strtotime($day);?>')"><?php echo $find_room;?></a>
					   </div>
					  <?php 
					   }else {?>
				<div  class="value_div">
				<a onclick="return open_text_box('<?php echo $pm_id;?>','<?php echo $propertyroomid?>','<?php echo $rs_limit->fields['adv_rooms_for_sale'];?>','<?php echo strtotime($day);?>')">
					   	<?php echo $rs_limit->fields['adv_rooms_for_sale'];?></a></div>
					   <?php }
					 }?>
     				<!-- div for displaying rooms for sale ends-->
     				</div>

<!-- div for displaying booked starts-->
     				<div class="single_div overview_heading1">
     				<?php    		
              	foreach($days as $day){?>
					<?php echo '<div  class="value_div">'.get_booking_count1($day,$pm_id,$propertyroomid).'</div>';?>

					<?php }?>
              <!-- div for displaying booked ends-->
     				</div>

<!-- div for displaying cancelled starts-->
     				<div class="single_div overview_heading1">
     				<?php    		
              	foreach($days as $day){
              	$cancelled = get_cancellation_room1($day,$pm_id,$propertyroomid);
              	echo '<div  class="value_div">'.$cancelled.'</div>';
              	 }?>
                 					<!-- div for displaying cancelled ends-->
     				</div>
</div>
                       
                       <!-- outer_rates end-->
                       </div>
						<?php 
						}
              	  		
              	  	}
				?>
				
					
			<?php }
				 
				?>
			<?php 
			unset($original_day);
			unset($day_arr);
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
                <div style="float:left;width:100%">
	<table id="textbox" style="display:none">
	<tr>
	<td><input type="text" name="value_of_rooms" value="" id="value_of_rooms" /></td>
	<td><a onclick="return set_property_room_value2('newroomvalues','<?php echo MYSURL."ajaxresponse/set_property_room_value2.php"?>');">Change value</a></td>
	</tr>
	<input type="hidden" name="value_pmi_d" id="value_pm_id">
	<input type="hidden" name="value_room_id" id="value_room_id">
	<input type="hidden" name="value_day" id="value_day">
	</table>
                </div>
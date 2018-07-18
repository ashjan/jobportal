<?php 
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
$maxRows = 25;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;


if(isset($_REQUEST['start_date'])){
	
	$start_date = base64_decode($_REQUEST['start_date']);
}else {
	
	$start_date = '';
}

if(isset($_REQUEST['end_date'])){
	
	$end_date = base64_decode($_REQUEST['end_date']);
}else {
	
	$end_date = '';
}
if($start_date!='' && $end_date!=''){
	$new_start_date = date("Y-m-d",strtotime($start_date));
	$new_end_date = date("Y-m-d",strtotime($end_date));
$qry_total = "SELECT DISTINCT
                        ".$tblprefix."standard_rates.id,
	                     ".$tblprefix."standard_rates.room_type_id,
	                     ".$tblprefix."standard_rates.pm_id,
	                     ".$tblprefix."standard_rates.single_adv_rate_price,
	                     ".$tblprefix."standard_rates.advance_rate_price,
	                     ".$tblprefix."standard_rates.property_id,".
                         $tblprefix."standard_rates.advance_start_date,
	                     ".$tblprefix."standard_rates.advance_end_date,"
	                     .$tblprefix."standard_rates.advance_use_option,"
	                     .$tblprefix."standard_rates.adv_rooms_for_sale,"
	                     .$tblprefix."rooms.room_type,
	                     ".$tblprefix."changed_advance_rates.standard_rate_id
	                     FROM ".$tblprefix."standard_rates 
	                     INNER JOIN ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id=".$tblprefix."rooms.id
	                     INNER JOIN ".$tblprefix."changed_advance_rates ON ".$tblprefix."standard_rates.id=".$tblprefix."changed_advance_rates.standard_rate_id
	                      WHERE ".$tblprefix."standard_rates.advance_use_option=1 AND 
	                      ".$tblprefix."standard_rates.pm_id=".base64_decode($_GET['pm_id'])."
	                       AND ".$tblprefix."changed_advance_rates.advance_date BETWEEN '".$new_start_date."'
	                       AND '".$new_end_date."'
	                       AND ".$tblprefix."standard_rates.property_id=".base64_decode($_GET['pr_id'])." ORDER BY ".$tblprefix."standard_rates.room_type_id DESC ";
	                     
	                     $rs_total = $db->Execute($qry_total);
	                     
	 $total = $rs_total->RecordCount();
	 $totalPages = ceil($total/$maxRows);
	                     
$qry_limit = "SELECT    DISTINCT 
                        ".$tblprefix."standard_rates.id,
	                     ".$tblprefix."standard_rates.room_type_id,
	                     ".$tblprefix."standard_rates.pm_id,
	                     ".$tblprefix."standard_rates.property_id,"
                         .$tblprefix."standard_rates.single_adv_rate_price,
	                     ".$tblprefix."standard_rates.advance_rate_price,".
                         $tblprefix."standard_rates.advance_start_date,
	                     ".$tblprefix."standard_rates.advance_end_date,"
	                     .$tblprefix."standard_rates.advance_use_option,"
	                     .$tblprefix."standard_rates.adv_rooms_for_sale,"
	                     .$tblprefix."rooms.room_type,
	                     ".$tblprefix."changed_advance_rates.standard_rate_id
	                     FROM ".$tblprefix."standard_rates 
	                     INNER JOIN ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id=".$tblprefix."rooms.id
	                     INNER JOIN ".$tblprefix."changed_advance_rates ON ".$tblprefix."standard_rates.id=".$tblprefix."changed_advance_rates.standard_rate_id
	                      WHERE ".$tblprefix."standard_rates.advance_use_option=1 AND ".$tblprefix."standard_rates.pm_id=".base64_decode($_GET['pm_id'])." AND 
	                      ".$tblprefix."changed_advance_rates.advance_date BETWEEN '".$new_start_date."'
	                       AND '".$new_end_date."' AND
	                      ".$tblprefix."standard_rates.property_id=".base64_decode($_GET['pr_id'])." ORDER BY ".$tblprefix."standard_rates.room_type_id DESC LIMIT ".$startRow.",".$maxRows;
             
$rs_limit = $db->Execute($qry_limit);
$totalcount = $rs_limit->RecordCount();
}
//Dropdown for parent
$users_qry = "SELECT ".$tblprefix."users.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_users = $db->Execute($users_qry);

function get_booking_count1($date='',$pm_id = 0,$propertyroomid = 0){
	global  $db;
	$count =0;
	global $tblprefix;
	//$new_date = date("m/d/Y",strtotime($date));
	$new_date = date("Y-m-d H:i:s",strtotime($date));
	$qry_booking = "SELECT id,room_id,check_indate,check_outdate FROM ".$tblprefix."property_booking WHERE pm_id=".$pm_id." AND (check_indate<='".$new_date."' AND check_outdate>'".$new_date."') AND room_id=".$propertyroomid."";
	
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
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	
	$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties  WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND property_category=24';
	$rs_properties = $db->Execute($property_qry);
	
}
elseif(isset($_REQUEST['pm_id'])){
	$pm_id = base64_decode($_REQUEST['pm_id']);
	     //Dropdown for parent
	$property_qry = "SELECT  id,property_name,property_category  FROM ".$tblprefix."properties  WHERE pm_id=".$pm_id.' AND property_category=24';
	$rs_properties = $db->Execute($property_qry);
}else {
	$pm_id = 0;
}

if(isset($_REQUEST['pr_id'])){
	$pr_id = base64_decode($_REQUEST['pr_id']);
}else {
	$pr_id = 0;
}
function date_changed($pm_id=0,$property_id=0,$room_id=0){
$day_changed = array();
global $db;
global $tblprefix;
$qry_standard_rooms ="SELECT advance_date,no_of_rooms FROM ".$tblprefix."advance_date WHERE pm_id=".$pm_id." AND room_type_id=".$room_id."  AND property_id=".$property_id." ORDER BY id ASC";


$rs_standard_rooms = $db->Execute($qry_standard_rooms);

$count_standard_rooms = $rs_standard_rooms->RecordCount();
$rs_standard_rooms->MoveFirst();
while(!$rs_standard_rooms->EOF){
							$day_changed[] = $rs_standard_rooms->fields['standard_date'];
							$rs_standard_rooms->MoveNext();
						}

return $day_changed;

}
function dayofyear2date( $tDay, $tFormat = 'm/d/Y' ) {

	$day = intval( $tDay );

	$day = ( $day == 0 ) ? $day : $day - 1;
	$offset = intval( intval( $tDay ) * 86400 );

	$date = mktime( 0, 0, 0, 1, 1, date('Y') )+$offset;
	// $str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
	return( $date );
}
function get_cancellation_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."cancellation WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."')";
$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);
    
	return $rs_tbl_cancellation->fields['cancelled'];


}
function find_room2($date='',$pm_id=0,$propertyroomid=0,$property_id=0,$rate_id=0){
global $db;
global $tblprefix;
	$new_date = date("Y-m-d",strtotime($date));
	$qry_select_rooms = "SELECT adv_rooms_for_sale FROM ".$tblprefix."changed_advance_rates 
	                    WHERE pm_id=".$pm_id."
	                    AND property_id=".$property_id."
	                    AND room_type_id=".$propertyroomid.
	                    " AND standard_rate_id=".$rate_id.
	                    " AND advance_date='".$new_date."'";  
	                   ;
	                 
	                
	 $rs_select_rooms = $db->Execute($qry_select_rooms);
	 return $rs_select_rooms->fields['adv_rooms_for_sale'];
}
function find_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."advance_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND advance_date='".$new_date."'";
    
    $rs_room = $db->Execute($qry_room);
    return $rs_room->fields['no_of_rooms'];

}
/*function DatesBetween($startDate, $endDate){
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
}*/
function DatesBetween($startDate, $endDate){	
$dateMonthYearArr = array();
$fromDateTS = strtotime($startDate);
$toDateTS = strtotime($endDate);

for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
// use date() and $currentDateTS to format the dates in between
$currentDateStr = date('m/d/Y',$currentDateTS);
$dateMonthYearArr[] = $currentDateStr;
//print $currentDateStr.”<br />”;
}

return $dateMonthYearArr;
}

function advance_rate($date='',$pm_id = 0,$room_id = 0, $rate_id = 0)
{
global $db;
global $tblprefix;
$new_date = date("Y-m-d",strtotime($date));
         $query = "SELECT advance_rate_price FROM " . $tblprefix . "changed_advance_rates WHERE pm_id=" . $pm_id . " AND
                   room_type_id=" . $room_id . " AND advance_date = '".$new_date. "' AND standard_rate_id=".$rate_id;
         $rs_query = $db->Execute($query);
         return $rs_query->fields['advance_rate_price'];
	
}
?>
<form name="date_ranges" id="date_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
<table border="0" width="500%" align="center" >
<tr>
<td>
  <!--<div style="display:block; position:absolute;display: block;float: left;  width: -moz-max-content; width: -webkit-max-content; width: -o-max-content;">-->
  <div style="display:block; position:absolute;display: block;float: left;  width:8000px;">
<div style="float:left; width:100%;"> 
			  <table cellpadding="5" cellspacing="5" class="txt" width="550" >
			  <tr>
    <td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
  </tr>
			  <tr>
			  <td>Start Date <br/>[Pocetni datum]</td>
			  <td><input type="text" name="start_date" id="start_date" class="fields" value="<?php echo $start_date;?>">
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
			  <td>End Date <br/>[Krajnji datum]</td>
			  <td><input type="text" name="end_date" id="end_date" class="fields" value="<?php echo $end_date;?>">
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
			  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id']?>" />
		<?php 
		}else {			
		?>
			  <tr>
			  
		<td>Select PM </td>
		<td>
		

		<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name19('pm_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name19.php"?>')">
	 	<option value="0">Izaberite objekat</option>
		<?php $rs_users->MoveFirst();
		while(!$rs_users->EOF){?>
		<option
		<?php 
		if(isset($_REQUEST['pm_id'])){
		   if($pm_id==$rs_users->fields['id']){
		   echo 'selected="selected"';
		   }
		}
		?> value="<?php echo $rs_users->fields['id'];?>" ><?php echo $rs_users->fields['first_name']."  ".$rs_users->fields['last_name'];  ?></option>
		<?php $rs_users->MoveNext();
		}?>			
		</select>
		<?php }?>
		</td>
		</tr>  
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		<tr>
		<td>Izaberite objekaty</td>
		<td>
		<select name="pr_id" class="dropfields" id="pr_id">
		<option value="0">Izaberite objekat</option>
		<?php $rs_properties->MoveFirst();
		      while (!$rs_properties->EOF) {?>
		      	
		      <option value="<?php echo $rs_properties->fields['id']?>"
		      <?php if(isset($_REQUEST['pr_id'])){
		   if($pr_id==$rs_properties->fields['id']){
		   echo 'selected="selected"';
		   }
		}?>>
		<?php echo $rs_properties->fields['property_name'];?>
		      
		      </option>
		      <?php  
		      $rs_properties->MoveNext();}
		?>
		</select>
		</td>
		</tr>
		
		<?php }else {?>
			<tr>
			  <td>Select Property <br/>[Izaberite objekat]</td><td>
			  <div id="pm_name">
			  <select name="pr_id" class="dropfields" id="pr_id">
			  <option value="0">Izaberite objekat</option>
		<?php 
		if(isset($_REQUEST['pm_id'])){
		$rs_properties->MoveFirst();
		while(!$rs_properties->EOF){?>
		<option
		<?php if(isset($_REQUEST['pr_id'])){
		   if($pr_id==$rs_properties->fields['id']){
		   echo 'selected="selected"';
		   }
		}
		?> value="<?php echo $rs_properties->fields['id'];?>" ><?php echo $rs_properties->fields['property_name'];?></option>
		<?php $rs_properties->MoveNext();
		}
		}
		?>	  
			  </select>
			  
			  </div></td>
			</tr>  
			<?php }?>
		
			  <tr>
			  <td>&nbsp;</td>
			  <td><input type="submit" name="availability" value="Provjeri raspolo&#382;ivost" class="button" /></td></tr>
			  <input type="hidden" name="mode" value="search">
			  <input type="hidden" name="act" value="availability_advance"/>
			  <input type="hidden" name="request_page" value="check_availability_advance" />
			  </table>
		</div>	   
			  </form>
			 <div  style="display:block; width:1300px;">
    <div style="float:left; width:100%;"> 
<?php			
$day_arr = array();
$advance_day = array();//for original dates
if($totalcount >0){
				  $rs_limit->MoveFirst();
?>	
		<div  style="background-color:#0066FF; color:#FFFFFF; font-weight:bold; width:100%;float:left;">
             	Raspolo&#382;ivost za napredne cijene cijene
		</div>
				<?php 
					while(!$rs_limit->EOF){
					
		
					$original_day = array();
					$first_day_changed = array();
					$start_day =base64_decode($_GET['start_date']);
					$end_day = base64_decode($_GET['end_date']);
					/*for($k = $start_day;$k<=$end_day;$k++){
						$original_day[] = date("m/d/Y",dayofyear2date($k));
					}*/
					$original_day = DatesBetween($start_day,$end_day);
					$date1 = $rs_limit->fields['advance_start_date'];
					$date2 = $rs_limit->fields['advance_end_date'];
					/*$advance_start_date = date("z",strtotime($date1));
					
					$advance_end_date = date("z",strtotime($date2));
					
					
					for($l=$advance_start_date;$l<=$advance_end_date;$l++){
						
						$advance_day[] = date("m/d/Y",dayofyear2date($l));
					}*/
					$advance_day = DatesBetween($date1,$date2);
					
					/*echo "<pre>";
					print_r($advance_day);					
					echo "</pre>";
					exit();*/
					$first_day_changed = date_changed($rs_limit->fields['pm_id'],$rs_limit->fields['property_id'],$rs_limit->fields['room_type_id']);
					
		if(!empty($original_day)){
					?>
					<?php    		
                $curr_month='';
				$previous_month='';
				$curr_year = '';
				$previous_year = '';
				$current_year='';
				$previous_year ='';
				$my_counter=0;
				$inner_div='<div class="inner_div">
					<div class="single_div">Mjesec</div>
					<div class="single_div">'.$rs_limit->fields['room_type'].'</div>
					<div class="single_div">Status</div>
					</div>';
              	foreach ($original_day as $key=>$day){
              		$curr_month=date("M",strtotime($day));
              		$curr_year = date("Y",strtotime($day));
              		$day_arr[$curr_year][$curr_month][] =$day;
              	  	}
				
              	  		foreach ($day_arr as $key=>$year){
              	  	   foreach ($year as $keys =>$days){
              	  		
						$current_month = $keys;
						if($current_month!=$previous_month and array_intersect($days,$advance_day)){
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
                         	if(in_array($day,$advance_day)){
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
                         <?php }}?>
                        <!-- overview headings for days ends-->
                        </div>
                        
                        <!-- div for status starts-->
                        <div class="single_div">
					<?php    		
              	foreach($days as $day){
					  /* if(in_array($day,$first_day_changed)){
					   	//get total booking for each day which is in array
					   	
					   $total_booking = get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					   				    
					   $find_room = find_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					   $cancelled = get_cancellation_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
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
					    			echo "<div class='value_div'>N/A</div>";
					   				   
					    }
					    
					   }else*/if(in_array($day,$advance_day)) {
					   	    
					   	     
					   	    $total_booking = get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					   	    
						   //$rooms_for_sale = $rs_limit->fields['adv_rooms_for_sale'];
						   $rooms_for_sale = find_room2($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['property_id'],$rs_limit->fields['id']);
						   
						   $cancelled = get_cancellation_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					       $remaining_rooms = ($rooms_for_sale+$cancelled)-$total_booking;
					    
					       $advance_rate_price = advance_rate($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['id']);
						   
							if($remaining_rooms<0){
					    	
					    	$remaining_rooms = 0;
					    }
					     switch ($remaining_rooms){
					    	
					    	case (0):?>
							 <div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",Preostale sobe=".$remaining_rooms.",single advance use rate per night=".$rs_limit->fields['single_adv_rate_price'].",advance rate price=".$advance_rate_price?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_rooms>0):?>
					    	
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",Preostale sobes=".$remaining_rooms.",single advance rate price=".$rs_limit->fields['single_adv_rate_price'].",advance rate price=".$advance_rate_price?>" border="0"/></div>
					    <?php 
					    		break;
					    	
					    		default:
					    			echo "<div  class='value_div'>N/A</div>";
					   				   
					    }
					   }else {?>
					   	<!--<div  class="value_div">N/A</div>-->
					  <?php 
					    }
					 }?>
                     
                     <!-- div for status ends-->
					</div>
                    
                  
</div>
                       
                       <!-- outer_rates end-->
                       </div>
						<?php 
						}
              	  		
              	  	}
              	  		}
				?>
				
					
			<?php }
				 
				?>
			<?php 
			unset($original_day);
			unset($day_arr);
			unset($year_arr);
			unset($advance_day);
			unset($first_day_changed);
			$rs_limit->MoveNext();
			
					}}else{
 ?>				<!--<p class="errmsg">No rates found</p>-->
 				<p class="errmsg">Cijene nisu pronadene</p>
				</div>
                <?php
				}
				?>   
</div>				


			    <table border="0" align="left" width="100%">
			  <tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							<div id="txt" align="center"> Showing <?php 
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $total) ?> of <?php echo $total ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;start_date=<?php echo $_GET['start_date'];?>&amp;end_date=<?php echo $_GET['end_date']; ?>" ><b>[Previous]</b></a>
							<?php }
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}
							else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPages){
							if($pageNum==0)
							$count= $count+10;
							else { $count= $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;start_date=<?php echo $_GET['start_date'];?>&amp;end_date=<?php echo $_GET['end_date']?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;start_date=<?php echo $_GET['start_date'];?>&amp;end_date=<?php echo $_GET['end_date']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							

							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;start_date=<?php echo $_GET['start_date'];?>&amp;end_date=<?php echo $_GET['end_date']?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;start_date=<?php echo $_GET['start_date'];?>&amp;end_date=<?php echo $_GET['end_date'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
	
			  </table>
			  
			    
			  
			  </div>
			  </div>
			  
</td>
</tr>
</table>

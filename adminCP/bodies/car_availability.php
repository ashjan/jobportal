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

if(isset($_REQUEST['start_date'])){$start_date = base64_decode($_REQUEST['start_date']);}else {$start_date = '';}
//Dropdown for parent
$qry_car = "SELECT * FROM ".$tblprefix."car";
$rs_car = $db->Execute($qry_car);
$count_car =  $rs_car->RecordCount();
$totalCars = $count_car;
///   List down all suppliers
$qry_supplier = "SELECT * FROM ".$tblprefix."carsupplier" ;
$rs_supplier = $db->Execute($qry_supplier);
$count_supplier =  $rs_supplier->RecordCount();
$totalSuppliers = $count_supplier;

$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users";  
$rs_pm = $db->Execute($qry_pm);
		
if(isset($_REQUEST['end_date'])){$end_date = base64_decode($_REQUEST['end_date']);}else {$end_date = '';}
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$car_qry = "SELECT * FROM ".$tblprefix."car  WHERE id=".$_SESSION[SESSNAME]['id'];
	$rs_car = $db->Execute($car_qry);
	$pm_id = $_SESSION[SESSNAME]['pm_id'];
}elseif(isset($_REQUEST['pm_id'])){
	$pm_id = base64_decode($_REQUEST['pm_id']);
	$car_qry = "SELECT * FROM ".$tblprefix."car  WHERE id=".$id;
	$rs_car = $db->Execute($car_qry);
}else{$pm_id = 0;}
if(isset($_REQUEST['pm_id'])){$pm_id = base64_decode($_REQUEST['pm_id']);}else {$pm_id = 0;}
if(isset($_REQUEST['ag_id'])){$ag_id = base64_decode($_REQUEST['ag_id']);}else {$ag_id = 0;}
if(isset($_REQUEST['cr_id'])){$cr_id = base64_decode($_REQUEST['cr_id']);}else {$cr_id = 0;}
if($start_date!='' && $end_date!=''){
    $qry_total = "SELECT ".$tblprefix."car_booking.id,
						 ".$tblprefix."car_booking.pm_id,
						 ".$tblprefix."car_booking.car_agency,
						 ".$tblprefix."car_booking.car_supplier,
						 ".$tblprefix."car.car_type,
	                     ".$tblprefix."car_booking.car_bk_stdare,
	                     ".$tblprefix."car_booking.car_bk_endate
	                     FROM ".$tblprefix."car_booking 
						INNER JOIN ".$tblprefix."car ON ".$tblprefix."car_booking.car_type_id=".$tblprefix."car.id 
						WHERE ".$tblprefix."car_booking.car_type=".$cr_id." ORDER BY ".$tblprefix."car_booking.car_type_id ASC";   
				$rs_total = $db->Execute($qry_total); 
				$total = $rs_total->RecordCount();
				$totalPages = ceil($total/$maxRows);
				
				$qry_limit = "SELECT ".$tblprefix."car_booking.id,
									 ".$tblprefix."car_booking.pm_id,
									 ".$tblprefix."car_booking.car_agency,
									 ".$tblprefix."car_booking.car_supplier,
									 ".$tblprefix."car.car_type,
									 ".$tblprefix."car_booking.car_bk_stdare,
									 ".$tblprefix."car_booking.car_bk_endate
									 FROM ".$tblprefix."car_booking 
									 INNER JOIN ".$tblprefix."car ON ".$tblprefix."car_booking.car_type_id=".$tblprefix."car.id 	 									 WHERE ".$tblprefix."car_booking.car_type=".$cr_id." ORDER BY ".$tblprefix.		  		  		 									 "car_booking.car_type_id ASC LIMIT ".$startRow.",".$maxRows;    
			$rs_limit = $db->Execute($qry_limit);
			$totalcount = $rs_limit->Recordcount();

}
function dayofyear2date( $tDay, $tFormat = 'm/d/Y' ) {
	$day = intval( $tDay );
	$day = ( $day == 0 ) ? $day : $day - 1;
	$offset = intval( intval( $tDay ) * 86400 );

	$date = mktime( 0, 0, 0, 1, 1, date('Y') )+$offset;
	// $str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
	return( $date );
}
function get_booking_count1($date='',$pm_id = 0,$agencycarid = 0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_booking = "SELECT id,car_type,car_bk_stdare,car_bk_endate FROM ".$tblprefix."car_booking WHERE pm_id=".$pm_id." AND (car_bk_stdare='".$new_date."' OR car_bk_endate='".$new_date."')"; 

	$rs_booking = $db->Execute($qry_booking);
	$rs_booking->MoveFirst();
	while (!$rs_booking->EOF){
		$explode_values = explode(',',$rs_booking->fields['car_id']);

		if(in_array($agencycarid,$explode_values)){
			$count++;
		}
		$rs_booking->MoveNext();
	}
	return $count;
	
}
function get_cancellation_car1($date='',$pm_id = 0,$carid=0){
	global  $db;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
		
	 $qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."car_cancellation WHERE pm_id=".$pm_id." AND car_type_id=".$car_type_id." AND (car_bk_stdare='".$new_date."' OR car_bk_endate='".$new_date."')";
$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);
    
	return $rs_tbl_cancellation->fields['cancelled'];


}
function find_car1($date='',$pm_id = 0,$agencycarid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	
	$qry_cars = "SELECT bk_no_car FROM ".$tblprefix."car_booking WHERE pm_id=".$pm_id." AND car_type_id=".$car_type_id." AND car_bk_stdare='".$new_date."'";
    
    $rs_cars = $db->Execute($qry_cars);
    return $rs_cars->fields['bk_no_car'];

}
function date_changed($pm_id=0,$agency_id=0,$car_id=0){
$day_changed = array();
global $db;
global $tblprefix;
$qry_cars ="SELECT car_bk_stdare FROM ".$tblprefix."car_booking WHERE pm_id=".$pm_id." AND car_type_id=".$car_id." ORDER BY id ASC"; 
$rs_cars = $db->Execute($qry_cars);

$count_cars = $rs_cars->RecordCount();
$rs_cars->MoveFirst();
while(!$rs_cars->EOF){
							$day_changed[] = $rs_cars->fields['car_bk_stdare'];
							$rs_cars->MoveNext();
						}

return $day_changed;

}

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
?>
<table border="0" width="100%" align="center" >
<tr>
<td>
  <!--<div style="display:block; position:absolute;display: block;float: left;  width: -moz-max-content; width: -webkit-max-content; width: -o-max-content;">-->
 <div style="display:block; position:absolute;display: block;float: left; width:1500px;">
 <div style="float:left; width:100%;"> 
 <form name="date_ranges" id="date_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
  <table cellpadding="5" cellspacing="5" class="txt"  >
	<tr>
    <td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
  </tr>
			  <tr>
			  <td>Start Date </td>
			  <td><input type="text" name="start_date" id="start_date" class="fields" value="<?php //echo $start_date;?>">
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
			  <td><input type="text" name="end_date" id="end_date" class="fields" value="<?php //echo $end_date;?>">
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
		 	<td class="txt1">Property Manager</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_car_agency('get_agency', this.value, '<?php echo MYSURL."ajaxresponse/get_car_agency.php"?>')">
				<option value="0">Izaberite objekat</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){
				echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>	
			</td><td> </td><td> </td>
			</tr> 
			<tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<div id="get_agency">
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
				<option value="0">Select Car Agency</option>
						
				</select>	
			</div>
			</td>
			</tr> 
		<tr>
	        <td class="txt1">
  			Supplier Name
		   	</td>
			<td>
		<div id="get_supplier"> 	
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type.php"?>')">
			<option value="0">Supplier Name</option>
		</select>
		</div>	
		</td>
        </tr>
		<tr>
		    <td class="txt1">
  			Car Type
		   	</td>
			<td>
			<div id="get_car">
			<select name="car_id" class="fields"   id="car_id">
				<option value="0">Select Car Type</option>					
			</select>		
			</div>
			</td>
        </tr>
			  <td colspan="2">
			  <div style="float:left; width:100%;">
			  <input type="submit" name="availability" value="Check Car Availability" class="button" />
			  </div>
			  </td></tr>
			  <input type="hidden" name="mode" value="search">
			  <input type="hidden" name="act" value="car_availability"/>
			  <input type="hidden" name="request_page" value="car_check_availability" />
			  </table>
			  </form>
  </div>
 <div  style="display:block; width:1300px;">
    <div style="float:left; width:100%;"> 
<?php			
$day_arr = array();
$standard_day = array();//for original dates
if($totalcount >0){
		$rs_limit->MoveFirst();
?>	
		<div  style="background-color:#0066FF; color:#FFFFFF; font-weight:bold; width:100%;float:left;">
             	Car Availability
		</div>
				<?php 
					while(!$rs_limit->EOF){
					$original_day = array();
					$first_day_changed = array();
					$start_day =  base64_decode($_GET['start_date']);
					$end_day =  base64_decode($_GET['end_date']);
					/*for($k = $start_day;$k<=$end_day;$k++){
						$original_day[] = date("m/d/Y",dayofyear2date($k));
					}*/
					$original_day = DatesBetween($start_day,$end_day);
					$first_day_changed = date_changed($rs_limit->fields['pm_id'],$rs_limit->fields['car_type_id']);
					$date1 = $rs_limit->fields['car_bk_stdate'];
					$date2 = $rs_limit->fields['car_bk_endate'];
					$standard_day = DatesBetween($date1,$date2);
					
		if(!empty($original_day)){
              	$curr_month='';
				$previous_month='';
				$curr_year = '';
				$previous_year = '';
				$current_year='';
				$previous_year ='';
				$inner_div='<div class="inner_div">
					<div class="single_div">Month[Mjesec]</div>
					<div class="single_div">'.$rs_limit->fields['car_type'].'</div>
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
						if($current_month!=$previous_month){
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
              	foreach($days as $day){
					   if(in_array($day,$first_day_changed)){
					   	//get total booking for each day which is in array
					   $total_booking = get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['car_agency'],$rs_limit->fields['car_supplier'],$rs_limit->fields['car_type_id']);
					   $find_car = find_car1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['car_agency'],$rs_limit->fields['car_supplier'],$rs_limit->fields['car_type_id']);
					   $cancelled = get_cancellation_car1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['car_type_id']);
					   $remaining_cars = ($find_cars+$cancelled)-$total_booking;
					    if($remaining_cars<0){
					    	$remaining_cars = 0;
					    }
					    
					    switch ($remaining_cars){
					    	
					    	case (0):?>
					    	<div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",remaining cars=".$remaining_cars.",Car Rent=".$rs_limit->fields['rent']?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_cars>0):?>
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",remaining car=".$remaining_cars.",Car Rent=".$rs_limit->fields['rent']?>" border="0"/></div>
					    <?php 
					    		break;
					    		default:
					    			echo "";
					   				   
					    }
					    
					   }else{?>
					   	<div  class="value_div"><img src="graphics/yellow.GIF" title="not available for this date" border="0"/></div>
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
 ?>				<p class="errmsg">No Car Booking found</p>
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
							<!-- END: Pagination Code -->
							
							</td>
					</tr>
			
	
			  </table>
			  
			    
			  
			  </div>
			  </div>
			  
</td>
</tr>
</table>

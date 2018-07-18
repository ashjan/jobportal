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



//Dropdown for parent
$property_manager_qry = "SELECT * FROM ".$tblprefix."property_manager";
$rs_property_manager = $db->Execute($property_manager_qry);

if(isset($_REQUEST['end_date'])){
	
	$end_date = base64_decode($_REQUEST['end_date']);
}else {
	$end_date = '';
}
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	
	$property_qry = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency  WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
	$rs_properties = $db->Execute($property_qry);
	$pm_id = $_SESSION[SESSNAME]['pm_id'];
	
}
elseif(isset($_REQUEST['pm_id'])){
	$pm_id = base64_decode($_REQUEST['pm_id']);
	     //Dropdown for parent
	$property_qry = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency  WHERE pm_id=".$pm_id;
	$rs_properties = $db->Execute($property_qry);
}else {
	$pm_id = 0;
}

if(isset($_REQUEST['pr_id'])){
	$pr_id = base64_decode($_REQUEST['pr_id']);
}else {
	$pr_id = 0;
}


if($start_date!='' && $end_date!=''){
	$new_start_date = date("Y-m-d",strtotime($start_date));
	$new_end_date = date("Y-m-d",strtotime($end_date));
	
	$qry_total = "SELECT DISTINCT "
	                     .$tblprefix."yatchagency.agn_name,"
	                     .$tblprefix."yatchtypes.yatch_name as model,"
	                      .$tblprefix."yatchtypes.id as model_id,"
	                      .$tblprefix."yatmng_price.start_date,
	                     ".$tblprefix."yatmng_price.end_date,
	                     ".$tblprefix."yatmng_price.price,
	                     ".$tblprefix."yatchtypes.yathch_berths as berths_for_sale
	                     
						 
						 
	                     FROM ".$tblprefix."yatmng_price 
						 INNER JOIN ".$tblprefix."yatchagency ON ".$tblprefix."yatmng_price.agn_id=".$tblprefix."yatchagency.agn_id 
						 INNER JOIN ".$tblprefix."yatchtypes ON ".$tblprefix."yatmng_price.yat_model=".$tblprefix."yatchtypes.id 
						  WHERE ".$tblprefix."yatmng_price.pm_id=".$pm_id." AND ".$tblprefix."yatmng_price.agn_id= ".$pr_id." AND ".$tblprefix."yatmng_price.start_date >='".$new_start_date."'
						  OR ".$tblprefix."yatmng_price.end_date <='".$new_end_date."'
						  AND ".$tblprefix."yatmng_price.day_weekflag=".base64_decode($_REQUEST['pr_style'])."
						  ORDER BY ".$tblprefix."yatmng_price.id DESC";
	                     
	             
	$rs_total = $db->Execute($qry_total);
	$total = $rs_total->RecordCount();
	$totalPages = ceil($total/$maxRows);
	$qry_limit ="SELECT DISTINCT "
	                     .$tblprefix."yatchagency.agn_name,"
	                     .$tblprefix."yatchtypes.yatch_name as model,"
	                     .$tblprefix."yatchtypes.id as model_id,"
	                     .$tblprefix."yatchtypes.number_yachts,"
	                     .$tblprefix."yatmng_price.start_date,
	                     ".$tblprefix."yatmng_price.pm_id,
	                     ".$tblprefix."yatmng_price.end_date,
	                     ".$tblprefix."yatmng_price.price,
	                     ".$tblprefix."yatmng_price.day_weekflag,
	                     ".$tblprefix."yatchtypes.yathch_berths as berths_for_sale
						 
						 
	                     FROM ".$tblprefix."yatmng_price 
						 INNER JOIN ".$tblprefix."yatchagency ON ".$tblprefix."yatmng_price.agn_id=".$tblprefix."yatchagency.agn_id 
						 INNER JOIN ".$tblprefix."yatchtypes ON ".$tblprefix."yatmng_price.yat_model=".$tblprefix."yatchtypes.id 
						  WHERE ".$tblprefix."yatmng_price.pm_id=".$pm_id." AND ".$tblprefix."yatmng_price.agn_id= ".$pr_id." AND ".$tblprefix."yatmng_price.start_date >='".$new_start_date."'
						  OR ".$tblprefix."yatmng_price.end_date <='".$new_end_date."'
						  AND ".$tblprefix."yatmng_price.day_weekflag=".base64_decode($_REQUEST['pr_style'])."
						  ORDER BY ".$tblprefix."yatmng_price.id DESC LIMIT ".$startRow.",".$maxRows;
	                      
	

	
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
function get_booking_count1($date='',$pm_id = 0,$model_id = 0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("Y-m-d H:i:s",strtotime($date));
	$qry_booking = "SELECT bkng_id,agncy_id FROM ".$tblprefix."yatbooking WHERE pm_id=".$pm_id." AND (pickup='".$new_date."' OR dropoff='".$new_date."') AND yacht_id=".$model_id."";

	$rs_booking = $db->Execute($qry_booking);
	$rs_booking->MoveFirst();
	while (!$rs_booking->EOF){
		
		if($agency_id==$model_id){
			$count++;
		}
		$rs_booking->MoveNext();
	}
	return $count;
	
}

function get_cancellation_yacht($day='',$end_day='',$pm_id = 0,$model_id=0){
	global  $db;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
		
	 $qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."yacht_cancellation WHERE pm_id=".$pm_id." AND model_id=".$model_id." AND (checkin_date>='".$day."' OR checkout_date='".$end_day."')";
$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);
    
	return $rs_tbl_cancellation->fields['cancelled'];


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
$currentDateStr = date('Y-m-d',$currentDateTS);
$dateMonthYearArr[] = $currentDateStr;
//print $currentDateStr.”<br />”;
}
return $dateMonthYearArr;
}

function start_dates_for_week($start='',$end='')
{
	$start_date = array();
	$start_day = '';
	
	
	
	$date_range = DatesBetween($start,$end);
	
	
	for($i=0;$i<count($date_range);$i++)
	{
	    	
		$str_st_day = strtotime($date_range[$i]);
		$str_end_day = strtotime($date_range[$i]);
		
		/*if($i==0){
			$start_day = date("Y-m-d",strtotime("Last Monday",$str_end_day));
					
		}else {*/
		
		$start_day = date("Y-m-d",strtotime("Monday",$str_end_day));
		/*}*/
		
	    
		
		if(!in_array($start_day,$start_date)){
			
			$start_date[]=$start_day;
		}
		
		
	}
	return $start_date;
	
}

function end_dates_for_week($start='',$end=''){
	$end_date = array();
	$end_day = array();
	$date_range = DatesBetween($start,$end);
	for($i=0;$i<count($date_range);$i++)
	{
	    	
	
		$str_end_day = strtotime($date_range[$i]);
		
	
		$end_day = date("Y-m-d",strtotime("Sunday",$str_end_day));
	if(!in_array($end_day,$end_date)){
			$end_date[] = $end_day;
		}
		
	}
	return $end_date;
}

function end_day($date=''){
	$end_date = array();
	$end_day = '';
	
	
	
		$str_end_day = strtotime($date);
		$end_day = date("Y-m-d",strtotime("Sunday",$str_end_day));
		return $end_day;
}
function get_availability($start_date='',$end_date='',$pm_id=0,$model_id=0){
	global  $db;
	global $tblprefix;
	$query_booking = "SELECT count(bkng_id) as counts FROM ".$tblprefix."yatbooking WHERE pickup >='".$start_date."' AND dropoff <='".$end_date."' AND pm_id=".$pm_id." AND yacht_id=".$model_id;
	$rs_booking = $db->Execute($query_booking);
	$counts = $rs_booking->fields['counts'];
	
	
	
	
}

?>
<table border="0" width="100%" align="center" >
<tr>
<td>
  <!--<div style="display:block; position:absolute;display: block;float: left;  width: -moz-max-content; width: -webkit-max-content; width: -o-max-content;">-->
  <div style="display:block; position:absolute;display: block;float: left;  width:1500px;">
  <div style="float:left; width:100%;"> 
         <form name="date_ranges" id="date_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
			  <table cellpadding="5" cellspacing="5" class="txt" width="50%"  >
			  <tr>
    <td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
  </tr>
			  <tr>
			  <td>Start Date </td>
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
			  <td>End Date </td>
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
		<select name="pm_id" class="fields" id="pm_id" onchange="get_yacht_agency('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_yacht_agency.php"?>')">
	 	<option value="0">Select Property Manager</option>
		<?php $rs_property_manager->MoveFirst();
		while(!$rs_property_manager->EOF){?>
		<option
		<?php 
		if(isset($_REQUEST['pm_id'])){
		   if($pm_id==$rs_property_manager->fields['id']){
		   echo 'selected="selected"';
		   }
		}
		?> value="<?php echo $rs_property_manager->fields['id'];?>" ><?php echo $rs_property_manager->fields['first_name']."  ".$rs_property_manager->fields['last_name'];  ?></option>
		<?php $rs_property_manager->MoveNext();
		}?>			
		</select>
		</td>
		</tr>
		<?php }?>  
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		<tr>
		<td>Select property</td>
		<td>
		<select name="pr_id" class="dropfields" id="pr_id">
		<option value="0">Select Property</option>
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
			  <td>Select Agency </td><td>
			  <div id="agency_name">
			  <select name="agency_id" class="dropfields" id="agency_id">
			  <option value="0">Select Agency</option>
		<?php 
		if(isset($_REQUEST['pm_id'])){
		$rs_properties->MoveFirst();
		while(!$rs_properties->EOF){?>
		<option
		<?php if(isset($_REQUEST['pr_id'])){
		   if($pr_id==$rs_properties->fields['agn_id']){
		   echo 'selected="selected"';
		   }
		}
		?> value="<?php echo $rs_properties->fields['agn_id'];?>" ><?php echo $rs_properties->fields['agn_name'];?></option>
		<?php $rs_properties->MoveNext();
		}
		}
		?>	  
			  </select>
			  
			  </div></td>
			</tr>  
			<tr>
			<td>Price</td>
			<td>
			<select name="price_style" class="fields">
			<option value="0"<?php if(base64_decode($_REQUEST['pr_style'])==0){echo 'selected="selected"';}?>>Per Day</option>
			<option value="1"<?php if(base64_decode($_REQUEST['pr_style'])==1){echo 'selected="selected"';}?>>Per Week</option>
			</select>
			
			</td>
			</tr>
			<?php }?>
			  
			  <tr>
			  
			  <td colspan="2">
			  <div style="float:left; width:100%;">
			  <input type="submit" name="availability" value="Check Availability" class="button" />
			  </div>
			  </td></tr>
			  <input type="hidden" name="mode" value="search">
			  <input type="hidden" name="act" value="yacht_rates_availability"/>
			  <input type="hidden" name="request_page" value="yatch_availability" />
			  </table>
			  </form>
  </div>
 <div  style="display:block; width:1300px;">
    <div style="float:left; width:100%;"> 
    <!--<div class="single_div" style="width:200px;">
					<div style="border:0px solid;float:left;width:100px;">
							 <img src="graphics/red.jpg" title="<?php echo $day.",remaining yachts=".$remaining_yacht?>" border="0"/></div>					 <div style="border:0px solid;float:left;width:100px;">
							 <img src="graphics/red.jpg" title="<?php echo $day.",remaining yachts=".$remaining_yacht?>" border="0"/></div>
					</div>--
					// for the dates 
					
					<div class="single_div" style="width:200px;">
					<div style="float:left;padding:5px;">'.$days.'</div>
					<div style="float:left;padding:5px;">'.$end_day.'</div></div>
					
					>-->
<?php			
$day_arr = array();
$standard_day = array();//for original dates
$original_dates = array();
$start_day='';
$end_day='';
$price_style = base64_decode($_REQUEST['pr_style']);
if($totalcount >0 and $price_style==1){
				  $rs_limit->MoveFirst();
?>	
		<div  style="background-color:#0066FF; color:#FFFFFF; font-weight:bold; width:100%;float:left;">
             	 Yacht  Availability
		</div>
				<?php 
                    $previous_id ='';
                    $current_id ='';
				    while (!$rs_limit->EOF) {
				   
				    	
				    
				    	
				    $start_day =  base64_decode($_GET['start_date']);//start date entered by PM
					$end_day =  base64_decode($_GET['end_date']);//end date entered by PM
				    $start_days_week = start_dates_for_week($start_day,$end_day);//start dates of weeks for the date range
				    //$end_days_week = end_dates_for_week($start_day,$end_day);
				    $original_dates = DatesBetween($start_day,$end_day);//total dates for the date range entered by the PM
				    $s_date = $rs_limit->fields['start_date'];//start_date in database
				    $e_date = $rs_limit->fields['end_date'];//end date in database
				    $standard_day = DatesBetween($s_date,$e_date);//original date range from the database
					
				     
				    $inner_div='<div class="inner_div" style="width:200px;">
				    <div class="single_div" style="border:0;"></div>
					<div class="single_div">Month[Mjesec]</div>
					<div class="single_div">Model &nbsp;'.$rs_limit->fields['model'].'</div>
					<div class="single_div">Status</div>
					</div>';
				  
				     $current_id = $rs_limit->fields['model_id'];
				     
				      foreach ($start_days_week as $key=>$days)
				     {
				     	//if($current_id!=$previous_id){
				     		//$previous_id = $current_id;
				     	$end_day = end_day($days);
				     	 if($current_id!=$previous_id){
				     	?>
				     	 <div class="outer_rates" style="width:auto;border:0px;float:left;padding:20px;">                                                     <?php }?>
				     	     <?php 
				     	     if($current_id!=$previous_id){
				     	     	$previous_id = $current_id;
				     	     echo $inner_div;
				     	     }
				     	     ?> 
				   
				   <div class="single_div overview_heading" style="float:left;">
                         <?php echo $days; ?>
                         <div class="single_div overview_heading" style="padding:5px;margin-top:29px;">
                         <?php if(in_array($days,$standard_day)){
                                echo $rs_limit->fields['price'];
                         }elseif((strtotime($s_date)>$days)and (strtotime($e_date)<strtotime($end_day))){
                         	echo $rs_limit->fields['price'];
                         }else {
                         	echo "N/A";
                         }
                         	?>

                         </div>
                         <div class="single_div overview_heading" style="padding:5px;margin-top:5px;">
                         <?php 
                           if(in_array($days,$standard_day)){
                      $booked = get_availability($days,$end_day,$rs_limit->fields['pm_id'],$rs_limit->fields['model_id']);
                      $cancellation = get_cancellation_yacht($days,$end_day,$rs_limit->fields['pm_id'],$rs_limit->fields['model_id']);
                      $total_yacht = $rs_limit->fields['number_yachts'];
                      
                      $remaining = ($total_yacht+$cancellation)-$booked;
                      if($remaining<0)
                      {
                      	$remaining=0;
                      }
                      if($remaining==0){?>
                     
					 <img src="graphics/red.jpg" title="<?php echo $days.",remaining yachts=".$remaining?>" border="0"/>
                      	
          <?php    }else {
          	?>
          	         
					 <img src="graphics/green.jpg" title="<?php echo $days.",remaining yachts=".$remaining?>" border="0"/>
          	<?php 
          }
                      
                      
                    }elseif((strtotime($s_date)>$days)and (strtotime($e_date)<strtotime($end_day))){
                         	$booked = get_availability($days,$end_day,$rs_limit->fields['pm_id'],$rs_limit->fields['model_id']);
                           $cancellation = get_cancellation_yacht($days,$end_day,$rs_limit->fields['pm_id'],$rs_limit->fields['model_id']);
                           $total_yacht = $rs_limit->fields['number_yachts'];
                      
                      $remaining = ($total_yacht+$cancellation)-$booked;
                      if($remaining<0)
                      {
                      	$remaining=0;
                      }
                      if($remaining==0){?>
                      
					 <img src="graphics/red.jpg" title="<?php echo $days.",remaining yachts=".$remaining?>" border="0"/>
                      	
          <?php    }else {
          	?>
          	          
					 <img src="graphics/green.jpg" title="<?php echo $days.",remaining yachts=".$remaining?>" border="0"/>
          	<?php 
          }
                            }else {
                            	echo "N/A";
                            }
                         ?>
                         </div>
                         </div>
                         
				   				   
					     <?php  if($current_id!=$previous_id){?>
				     	 </div>
				     	 <?php }?>
				     	
				     	
	<?php 
				     	//}
				     	
				     
				    
				     }
				     	
				
 
				     	
				     
				     $rs_limit->MoveNext();
				    }}elseif($price_style==0 && $totalcount>0){
				    // echo $inner_div;
				     
					while(!$rs_limit->EOF){
					$original_day = array();
					$first_day_changed = array();
					$start_day =  base64_decode($_GET['start_date']);
					$end_day =  base64_decode($_GET['end_date']);
					$original_day = DatesBetween($start_day,$end_day);
					//$first_day_changed = date_changed($rs_limit->fields['pm_id'],$rs_limit->fields['property_id'],$rs_limit->fields['room_type_id']);
					$date1 = $rs_limit->fields['start_date'];
					$date2 = $rs_limit->fields['end_date'];
					$standard_day = DatesBetween($date1,$date2);
					
					$start_days_week = start_dates_for_week($date1,$date2);
					$end_days_week = end_dates_for_week($date1,$date2);
					
					
		if(!empty($original_day)){
              	$curr_month='';
				$previous_month='';
				$curr_year = '';
				$previous_year = '';
				$current_year='';
				$previous_year ='';
				$inner_div='<div class="inner_div">
					<div class="single_div">Month[Mjesec]</div>
					<div class="single_div">'.$rs_limit->fields['model'].'</div>
					<div class="single_div">Status</div>
					</div>';
              	foreach ($original_day as $key=>$day){
              		$curr_month=date("M",strtotime($day));
              		$curr_year = date("Y",strtotime($day));
              		$day_arr[$curr_year][$curr_month][] =$day;
              	  	}
				
              	 foreach ($day_arr as $key=>$year){
				
				 foreach($year as $keys =>$days){
						$current_month = $keys;
						if($current_month!=$previous_month){
						$previous_month = $keys;
				 ?>
       			       <div class="outer_rates" style="width:100%;border:0px;float:left;padding:20px;">                           
                       <?php echo $inner_div; ?>
                       <div style="width:100%;">
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
       echo '<div  class="value_div" style=background-color:'.$bgcolor.';color:'.$color.';>'.date("d",strtotime($day)).'</div>'; ?>
                         <?php }?>
                        <!-- overview headings for days ends-->
                        </div>
       <!-- div for status starts-->
        <div class="single_div">
		<?php    foreach($days as $day){
					   if (in_array($day,$standard_day)) {
					   	    $total_booking = get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['model_id']);
					   	    $yatch_for_sale = $rs_limit->fields['number_yachts'];
						    $cancelled = get_cancellation_yacht($day,$rs_limit->fields['pm_id'],$rs_limit->fields['model_id']);
							$remaining_yacht = ($yatch_for_sale+$cancelled)-$total_booking;
					   
					   $remaining_yacht = ($yatch_for_sale+$cancelled)-$total_booking;
					   if($remaining_yacht<0){
					    	$remaining_yacht= 0;
					    }
					    switch ($remaining_yacht){
					    	case (0):?>
							 <div  class="value_div">
							 <img src="graphics/red.jpg" title="<?php echo $day.",remaining yachts=".$remaining_yacht?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_yacht>0):?>
					    	<div  class="value_div">
					    	<img src="graphics/green.jpg" title="<?php echo $day.",remaining yachts=".$remaining_yacht?>" border="0"/></div>
					    <?php 
					    		break;
					    		default:
					    		echo "";
					    }
					   }else {?>
	   	<div class="value_div">N/A</div>
					 <?php 
					   }
					 }  ?>
        <!-- div for status ends-->
		</div>
        </div>
         <!-- outer_rates end-->
        </div>
				<?php 
						}
              	  	}
		
         }
		}
			unset($original_day);
			unset($day_arr);
			unset($year_arr);
			unset($standard_day);
			unset($first_day_changed);
			$rs_limit->MoveNext();
					} // End while loop
		}else{
 ?>				<p class="errmsg">No rates found</p>
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

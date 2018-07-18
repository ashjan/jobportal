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
$users_qry = "SELECT ".$tblprefix."users.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_users = $db->Execute($users_qry);

if(isset($_REQUEST['end_date'])){
	$end_date = base64_decode($_REQUEST['end_date']);
}else {
	$end_date = '';
}
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	
	$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties  WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND
	pm_type=1 AND  property_category=24';
	$rs_properties = $db->Execute($property_qry);
	$pm_id = $_SESSION[SESSNAME]['pm_id'];
	
}
elseif(isset($_REQUEST['pm_id'])){
	$pm_id = base64_decode($_REQUEST['pm_id']);
	     //Dropdown for parent
	$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties  WHERE pm_id=".$pm_id.' AND pm_type=1 AND   property_category=24';
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
	                     .$tblprefix."rooms.room_type,"
	                     .$tblprefix."standard_rates.id,
	                     ".$tblprefix."standard_rates.room_type_id,
	                     ".$tblprefix."standard_rates.pm_id,
	                     ".$tblprefix."standard_rates.rooms_for_sale,
	                     ".$tblprefix."standard_rates.standard_start_date,
	                     ".$tblprefix."standard_rates.standard_end_date,
						 ".$tblprefix."changed_standard_rates.standard_rate_id,
						 ".$tblprefix."properties.property_name
	                     FROM ".$tblprefix."standard_rates 
						 INNER JOIN ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id=".$tblprefix."rooms.id 
						 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.id=".$tblprefix."standard_rates.property_id 
						 INNER JOIN ".$tblprefix."changed_standard_rates ON ".$tblprefix."standard_rates.id=".$tblprefix."changed_standard_rates.standard_rate_id
						 WHERE ".$tblprefix."standard_rates.pm_id=".$pm_id." AND ".$tblprefix."standard_rates.property_id= ".$pr_id." AND ".$tblprefix."changed_standard_rates.standard_date BETWEEN '".$new_start_date."'
						 AND '".$new_end_date."'
						 ORDER BY ".$tblprefix."standard_rates.room_type_id, ".$tblprefix."standard_rates.standard_start_date  DESC"; 
	
						 
	                     
	$rs_total = $db->Execute($qry_total);
	$total = $rs_total->RecordCount();
	$totalPages = ceil($total/$maxRows);
	$qry_limit = "SELECT DISTINCT "
	                     .$tblprefix."rooms.room_type,"
	                     .$tblprefix."standard_rates.id,
	                     ".$tblprefix."standard_rates.room_type_id,
	                     ".$tblprefix."standard_rates.pm_id,
	                     ".$tblprefix."standard_rates.standard_rate_price,
	                     ".$tblprefix."standard_rates.single_rate_price,
	                     ".$tblprefix."standard_rates.property_id,
	                     ".$tblprefix."standard_rates.rooms_for_sale,
	                     ".$tblprefix."standard_rates.standard_start_date,
	                     ".$tblprefix."standard_rates.standard_end_date,
						 ".$tblprefix."properties.property_name,
						 ".$tblprefix."changed_standard_rates.standard_rate_id
	                     FROM ".$tblprefix."standard_rates 
						 INNER JOIN ".$tblprefix."rooms ON ".$tblprefix."standard_rates.room_type_id=".$tblprefix."rooms.id 
						 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.id=".$tblprefix."standard_rates.property_id 
						 INNER JOIN ".$tblprefix."changed_standard_rates ON ".$tblprefix."standard_rates.id=".$tblprefix."changed_standard_rates.standard_rate_id
						 WHERE ".$tblprefix."standard_rates.pm_id=".$pm_id." AND ".$tblprefix."standard_rates.property_id= ".$pr_id." AND ".$tblprefix."changed_standard_rates.standard_date BETWEEN '".$new_start_date."' AND '".$new_end_date."' ORDER BY ".$tblprefix."standard_rates.room_type_id DESC LIMIT ".$startRow.",".$maxRows;
	

	
$rs_limit = $db->Execute($qry_limit);
$totalcount = $rs_limit->Recordcount();

$qry_standard_rooms ="SELECT standard_date,no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND property_id=".$pr_id." ORDER BY id ASC";

$rs_standard_rooms = $db->Execute($qry_standard_rooms);

$count_standard_rooms = $rs_standard_rooms->RecordCount();

}
function dayofyear2date( $tDay, $tFormat = 'm/d/Y' ) {

	$day = intval( $tDay );

	$day = ( $day == 0 ) ? $day : $day - 1;
	$offset = intval( intval( $tDay ) * 86400 );

	$date = mktime( 0, 0, 0, 1, 1, date('Y') )+$offset;
	// $str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
	return( $date );
}
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



function get_cancellation_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
		
	 $qry_tbl_cancellation = "SELECT count(id) as cancelled FROM ".$tblprefix."cancellation WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND (check_indate='".$new_date."' OR check_outdate='".$new_date."')";
$rs_tbl_cancellation = $db->Execute($qry_tbl_cancellation);
	return $rs_tbl_cancellation->fields['cancelled'];
}



function find_room1($date='',$pm_id = 0,$propertyroomid=0){
	global  $db;
	$count =0;
	global $tblprefix;
	$new_date = date("m/d/Y",strtotime($date));
	$qry_room = "SELECT no_of_rooms FROM ".$tblprefix."standard_date WHERE pm_id=".$pm_id." AND room_type_id=".$propertyroomid." AND standard_date='".$new_date."'";
    
    $rs_room = $db->Execute($qry_room);
    return $rs_room->fields['no_of_rooms'];
}


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

function standard_rate($date='',$pm_id = 0,$room_id = 0, $rate_id = 0)
{
global $db;
global $tblprefix;
$new_date = date("Y-m-d",strtotime($date));
         $query = "SELECT standard_rate_price FROM " . $tblprefix . "changed_standard_rates WHERE pm_id=" . $pm_id . " AND
                   room_type_id=" . $room_id . " AND standard_date = '".$new_date. "' AND standard_rate_id=".$rate_id;
         $rs_query = $db->Execute($query);
         return $rs_query->fields['standard_rate_price'];
	
}
?>
<table border="0" width="100%" align="center" >
<tr>
<td>
  <!--<div style="display:block; position:absolute;display: block;float: left;  width: -moz-max-content; width: -webkit-max-content; width: -o-max-content;">-->
  <div style="display:block; position:absolute;display: block;float: left;  width:1500px;">
  <div style="float:left; width:100%;"> 
         <form name="date_ranges" id="date_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
			  <table cellpadding="5" cellspacing="5" class="txt"  >
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
			  <td>End Date  <br/>[Krajnji datum]</td>
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
		</td>
		</tr>
		<?php }?>  
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		<tr>
		<td>Select property<br/>[Izaberite objekat]</td>
		<td>
		<select name="pr_id" class="dropfields" id="pr_id">
		<option value="0">Izaberite objekat </option>
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
			  <td>Select Property<br/>[Izaberite objekat] </td><td>
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
			  
			  <td colspan="2">
			  <div style="float:left; width:100%;">
			  <input type="submit" name="availability" value="Provjeri raspolo&#382;ivost" class="button" />
			  </div>
			  </td></tr>
			  <input type="hidden" name="mode" value="search">
			  <input type="hidden" name="act" value="availability"/>
			  <input type="hidden" name="request_page" value="check_availability" />
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
             	 Raspolo&#382;ivost za osnovne cijene
		</div>
			<?php 
			/* while(!$rs_limit->EOF){
					$original_day = array();
					$first_day_changed = array();
					$start_day =  base64_decode($_GET['start_date']);
					$end_day =  base64_decode($_GET['end_date']);
					$first_day_changed = date_changed($rs_limit->fields['pm_id'],$rs_limit->fields['property_id'],$rs_limit->fields['room_type_id']);
					$date1 = $rs_limit->fields['standard_start_date'];
					$date2 = $rs_limit->fields['standard_end_date'];
					$original_day = DatesBetween($start_day,$end_day);
					$standard_day = DatesBetween($date1,$date2);
			
			
			
			
			
					
			unset($original_day);
			unset($day_arr);
			unset($year_arr);
			unset($standard_day);
			unset($first_day_changed);
					
			$rs_limit->MoveNext();
			}  */ // End while loop  
			
			
			$rs_limit->MoveFirst();	   
			while(!$rs_limit->EOF){
			$original_day = array();
			$first_day_changed = array();
			$start_day =  base64_decode($_GET['start_date']);
			$end_day =  base64_decode($_GET['end_date']);
			$first_day_changed = date_changed($rs_limit->fields['pm_id'],$rs_limit->fields['property_id'],$rs_limit->fields['room_type_id']);
			$date1 = $rs_limit->fields['standard_start_date'];
			$date2 = $rs_limit->fields['standard_end_date'];
			$original_day = DatesBetween($start_day,$end_day);
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
					<div class="single_div">'.$rs_limit->fields['room_type'].'</div>
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
						if($current_month!=$previous_month and array_intersect($days,$standard_day)){
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
       echo '<div  class="value_div" style=background-color:'.$bgcolor.';color:'.$color.';>'.date("d",strtotime($day)).'</div>'; ?>
                         <?php }}?>
                        <!-- overview headings for days ends-->
                        </div>
       <!-- div for status starts-->
        <div class="single_div">
		<?php    foreach($days as $day){
					   if (in_array($day,$standard_day)) {
					   	    $total_booking = get_booking_count1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
							$rooms_for_sale = find_room2($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['property_id'],$rs_limit->fields['id']);
							$cancelled = get_cancellation_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					$standard_rate_price = standard_rate($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id'],$rs_limit->fields['id']);
							$remaining_rooms = ($rooms_for_sale+$cancelled)-$total_booking;
					   $cancelled = get_cancellation_room1($day,$rs_limit->fields['pm_id'],$rs_limit->fields['room_type_id']);
					   $remaining_rooms = ($rooms_for_sale+$cancelled)-$total_booking;
					   if($remaining_rooms<0){
					    	$remaining_rooms = 0;
					    }
						switch ($remaining_rooms){
					    	case (0):?>
							 <div  class="value_div"><img src="graphics/red.jpg" title="<?php echo $day.",Preostale sobe=".$remaining_rooms.",single user rate per night=".$rs_limit->fields['single_rate_price'].",Osnovna cijena=".$standard_rate_price?>" border="0"/></div>
					    <?php 
					    		break;
					    	case ($remaining_rooms>0):?>
					    	<div  class="value_div"><img src="graphics/green.jpg" title="<?php echo $day.",Preostale sobe=".$remaining_rooms.",Cijena za jednu osobu =".$rs_limit->fields['single_rate_price'].",Osnovna cijena=".$standard_rate_price?>" border="0"/></div>
					    <?php 
					    		break;
					    		default:
					    		echo "";
					    }
					   }else {?>
	   <!--	<div class="value_div"><img src="graphics/yellow.GIF" title="not available for this date" border="0"/></div>-->
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
<?php 
/*
function sortMonths($a, $b) {
    $a = strtotime($a->received_date);
    $b = strtotime($b->received_date);
    if ( $a == $b ) return 0;

    $ayear  = intval(date('m',$a)); // or idate('m', $a)
    $amonth = intval(date('Y',$a)); // or idate('Y', $a)

    $byear  = intval(date('m',$b));  // or idate('m', $b)
    $bmonth = intval(date('Y',$b));  // or idate('Y', $b)

    if ($amonth == $bmonth) { 
        return ($ayear > $byear) ? 1 : -1;
    } else {
        return ($amonth > $bmonth) ? 1 : -1;
    }
}
*/


?>
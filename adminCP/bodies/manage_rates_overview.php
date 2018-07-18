<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}

if(isset($_GET['standard_rate_from']) && isset($_GET['standard_rate_to'])){
		$standard_rate_to=base64_decode($_GET['standard_rate_to']);
		$standard_rate_from=base64_decode($_GET['standard_rate_from']);
		$standard_overview_query = "SELECT sr.*,rms.room_type FROM tbl_standard_rates AS sr
		INNER JOIN tbl_rooms as rms ON rms.id=sr.room_type_id 
		WHERE sr.standard_start_date>='".$standard_rate_from."' AND sr.standard_end_date<='".$standard_rate_to."'";
		$rs_limit = $db->Execute($standard_overview_query);
		$totalOverviewss = $rs_limit->RecordCount();
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

 $qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.property_id,
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
					inner Join ".$tblprefix."standard_rates ON ".$tblprefix."standard_rates.room_type_id = ".$tblprefix."rooms.id LIMIT $startRow,$maxRows";				

$rs_limit = $db->Execute($qry_limit);
$totalOverviewss =  $rs_limit->RecordCount();
}


//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_room = $db->Execute($qry_region);
$count_region =  $rs_room->RecordCount();
$totalRegions = $count_region;



function DatesBetween($startDate, $endDate){
    // get the number of days between the two given dates.
    $days = ((strtotime($endDate)-86400) - strtotime($startDate)) / 86400 + 1;
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
function getBookingCount($property_id=0)
{
  $qry_booking = "SELECT count(id) AS booking FROM tbl_property_booking WHERE property_id=".$property_id;
  $rs_booking = mysql_fetch_array(mysql_query($qry_booking));
  return $rs_booking['booking'];
  
}
$qry_property_manag ="SELECT ".$tblprefix."property_manager.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();

$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
				AND pm_type=1 
				AND property_category=24';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>


<form name="date_ranges" id="date_ranges" action="admin.php" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
			  <table cellpadding="5" cellspacing="5" class="txt" width="550" >
             
			 <?php if( isset($_REQUEST['okmsg'])) {?>
			 <tr>
			 <td></td>
			 <td><font color="#FF0000"><?php echo base64_decode($_REQUEST['okmsg']);?></font></td>
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
					<option value="0">Vlasnik objekta</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
							<option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr> 
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Property Name<br/>[Izaberite objekat]</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields" onchange="get_room_type4('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type16.php"?>','<?php echo $_SESSION[SESSNAME]['pm_id']?>')">
					<option value="0">Izaberite objekat</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
			<?php }else {?>
			<tr>
             <td>Property Name<br/>[Izaberite objekat]</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields"  />
			    

					<option value="0">Izaberite objekat</option>
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
			<tr>
	        <td>
  			Izaberite sobu
		   	</td>
			<td>
	<div id="room_type">
			<select name="room_type" class="dropfields" >
			  <option value="0">Izaberite sobu</option>
			</select>
    </div>
			</td>
        </tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
		<tr>
			  <td>Start Date <br/>[Početni datum]</td>
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
			<tr>
			<td colspan="2">
			  <div style="float:left; width:100%;">
			 <input type="submit" name="availability" value="Prika&#382;i" class="button"/>
			  </div>
			 </td>
			</tr>
		 </table>	
          <input type="hidden" name="mode" value="overview_rates" />
		  <input type="hidden" name="request_page" value="manage_rates_overview" />
		  <input type="hidden" name="act" value="manage_rates_overview" />
</form>		 
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	  	<tr>
		<td>
		<?php 
		if($totalOverviews >0){
		    $rs_limit->MoveFirst();
		?>	
		<div style="background-color:#0066FF; float:left; color:#FFFFFF; font-weight:bold; width:100%;">
					Pregled osnovnih cijena
		</div>
					<?php
					while(!$rs_limit->EOF){
					?>
					<table cellpadding="1" cellspacing="0"  width="100%">
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
					<table cellpadding="1" cellspacing="0"  border="1" bordercolor="#666666" width="100%">
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
		
	echo '<td class=\'txtnewbb\'>';
	if(in_array($days[$i],$values)){
	echo '<img src="graphics/green.jpg" title="Make Default" border="0" />';
		  }else{ 
	  echo '<img src="graphics/red.jpg" title="Make Default" border="0"/>';
	echo '</td>';
	}
	}
	
	?>
	</tr>

<tr>					
	<td class="txtnewb"><b>Cijena noćenja za jednu osobu</b></td>  
	
	<?php

	for($i=1; $i<=31; $i++){
	if(in_array($i,$values)){
	 echo'<td class=\'txtnew\'>'.$rs_limit->fields['single_rate_price'].'</td>' ;
	}else {
	echo'<td class=\'txtnew\'>0</td>' ;
	}
	}
	
	?>

</tr>

<tr>					
	<td class="txtnewb"><b>Cijena noćenja</b></td> 
	<?php
	for($i=1; $i<=31; $i++){
	if(in_array($i,$values)){
	echo '<td class=\'txtnew\'>'.$rs_limit->fields['standard_rate_price'].'</td>' ;
	}else{
	echo	'<td class=\'txtnew\'>0</td>' ;
	}
	}
	?>
	
</tr>

<tr>					
<td class="txtnewb"><b>Sobe za prodaju</b></td>   
<?php  
      $rooms_for_sale=$rs_limit->fields['rooms_for_sale'];
?>
<?php 
for($i=1; $i<=31; $i++){
    if(in_array($i,$values)){
	echo	'<td class=\'txtnew\'><a onclick=\'opentextbox();\'>'.$rooms_for_sale.'</a></td>' ;
	}else{
	echo	'<td class=\'txtnew\'>0</td>' ;
	}
	}
	?>
</tr>
<tr>
	<td class="txtnewb"><b>Rezervisano</b></td>  
		<?php 
		for($i=1; $i<=31; $i++){
		$sdate = $rs_booking->fields['check_indate'];
		$edate = $rs_booking->fields['check_outdate'];
		$dates = DatesBetween($sdate,$edate);
	
		if(in_array($i,$values)){
		$booking_count=getBookingCount($rs_limit->fields['property_id']);
		echo	'<td class=\'txtnew\'>'.$booking_count.'</td>';
		}else {
		echo	'<td class=\'txtnew\'>0</td>';
		}
		}
	    ?>

  
</tr>

<tr>
<td class="txtnewb"><b>Otkazano</b></td> 
<?php 
for($i=1; $i<=31; $i++){
$rate = $rs_limit->fields['standard_rate_price'];
(float)$percut = $rs_cutting->fields['cancellation_charges_percent'];
(float)$cutting= rate*$percut/100; 
	echo	'<td class=\'txtnew\'>'.$cutting.'</td>' ;
	}
	?>
</tr>
</table>					 
					<?php
					$rs_limit->MoveNext();
					}// while(!$rs_overview->EOF)
			    ?>
				</td>
				</tr>
		</table>		
        <?php
        }else{}
		?>
<!--<div id="propertyroom"  style="display:block; position:absolute;display: block;float: left; position: absolute; width: -moz-max-content;  max-width:  intrinsic; ">-->

<div id="propertyroom"  style="float:left;width:120%;">
        </div>
		<div id="newroomvalues">
		</div>
		</div>

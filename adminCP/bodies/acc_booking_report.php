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
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

function booking_status($booking_id=0,$propid=0){
	
	global $db;
	global $tblprefix;
	
	$qry_booking = "SELECT id,cancellation_date FROM ".$tblprefix."cancellation WHERE booking_id=".$booking_id;
	$rs_booking = $db->Execute($qry_booking);
	
	
							
	$count = $rs_booking->RecordCount();
	if($count>0)
	{
		$qry_bookingdate = "SELECT transaction_date FROM ".$tblprefix."property_booking WHERE id=".$booking_id;
		$rs_bookingdate = $db->Execute($qry_bookingdate);
		
		$qry_policy = "SELECT cacellation_days,cancellation_charges_percent FROM ".$tblprefix."property_policy WHERE property_id=".$propid;
		$rs_policy = $db->Execute($qry_policy);
		
		$start_ts = strtotime($rs_bookingdate->fields['transaction_date']);
		$end_ts = strtotime($rs_booking->fields['cancellation_date']);
		$diff = $end_ts - $start_ts;
		$numdays = round($diff / 86400);
		
		if($numdays > $rs_policy->fields['cacellation_days'])
		{
			return  "Cancelled without charges";
		}
		else
		{
			return  "Cancelled with ".$rs_policy->fields['cancellation_charges_percent']."% charges";
		}
	
		
	}
	else 
	{
		return "Successful";
	}
	
}
function get_commission($property_slug=NULL){
	global $db;
	global $tblprefix;
	
	$qry_property_id = "SELECT id FROM ".$tblprefix."properties WHERE properties_slug='".$property_slug."'";
	$rs_property_id = $db->Execute($qry_property_id);
	$count = $rs_property_id->RecordCount();
	if($count>0){
		$qry_commission = "SELECT commission FROM ".$tblprefix."users_commission WHERE pt_id=".$rs_property_id->fields['id'];
		$rs_commission = $db->Execute($qry_commission);
		$count_commission = $rs_commission->RecordCount();
		if($count_commission>0){
			return $rs_commission->fields['commission'];
		}else {
			return 0;
		}
	}else {
		return 0;
	}
}

//****** Query for Search **********************************************
//Search and Refining code




if(isset($_POST['sort']))
{
$where = "WHERE ".$tblprefix."property_booking.check_indate >='".$_POST['sort_order']."' AND ".$tblprefix."property_booking.check_outdate <='".$_POST['searchkeyword']."'";
}
else
{
$where=" ";
}

  $qry_state = "SELECT
			".$tblprefix."users.first_name,
			".$tblprefix."users.last_name,
			".$tblprefix."customer.customer_name,
			".$tblprefix."customer.customer_last_name,
			".$tblprefix."properties.property_name,
			".$tblprefix."rooms.room_type,
			".$tblprefix."property_booking.id,
			".$tblprefix."property_booking.confirmation_code,
			".$tblprefix."property_booking.pincode,
			".$tblprefix."property_booking.check_indate,
			".$tblprefix."property_booking.check_outdate,
			".$tblprefix."property_booking.guests,
			".$tblprefix."property_booking.transaction_date,
			".$tblprefix."property_booking.price,
			".$tblprefix."property_booking.room_id,
			".$tblprefix."property_booking.user_id,
			".$tblprefix."property_booking.property_id,
			".$tblprefix."property_booking.pm_id
			FROM
			".$tblprefix."property_booking
			Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_booking.room_id = ".$tblprefix."rooms.id
			Inner Join ".$tblprefix."customer ON ".$tblprefix."property_booking.user_id = ".$tblprefix."customer.id
			Inner Join ".$tblprefix."properties ON ".$tblprefix."property_booking.property_id = ".$tblprefix."properties.properties_slug
			Inner Join ".$tblprefix."users ON ".$tblprefix."property_booking.pm_id = ".$tblprefix."users.id ".$where ;
			
			$rs_state = $db->Execute($qry_state);
			           
		//echo $qry_state;
		
			
			
			$count_add =  $rs_state->RecordCount();
			              
			$totalRows = $count_add;
			$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT 
			".$tblprefix."users.first_name,
			".$tblprefix."users.last_name,
			".$tblprefix."customer.customer_name,
			".$tblprefix."customer.customer_last_name,
			".$tblprefix."properties.property_name,
			".$tblprefix."rooms.room_type,
			".$tblprefix."property_booking.id as booking_id,
			".$tblprefix."property_booking.confirmation_code,
			".$tblprefix."property_booking.pincode,
			".$tblprefix."property_booking.check_indate,
			".$tblprefix."property_booking.check_outdate,
			".$tblprefix."property_booking.guests,
			".$tblprefix."property_booking.transaction_date,
			".$tblprefix."property_booking.price,
			".$tblprefix."property_booking.room_id,
			".$tblprefix."property_booking.user_id,
			".$tblprefix."property_booking.property_id,
			".$tblprefix."property_booking.pm_id			
			FROM
			".$tblprefix."property_booking
			Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_booking.room_id = ".$tblprefix."rooms.id
			Inner Join ".$tblprefix."customer ON ".$tblprefix."property_booking.user_id = ".$tblprefix."customer.id
			Inner Join ".$tblprefix."properties ON ".$tblprefix."property_booking.property_id = ".$tblprefix."properties.properties_slug
			Inner Join ".$tblprefix."users ON ".$tblprefix."property_booking.pm_id = ".$tblprefix."users.id ".$where." LIMIT $startRow,$maxRows"; 
			$rs_limit = $db->Execute($qry_limit);
			$totalcountalpha =  $rs_limit->RecordCount();
	
		
//Query to load "From and To Dates in the Dropdown"
$qry_date = "SELECT * FROM ".$tblprefix."property_booking"; 
$rs_date = $db->Execute($qry_date);
$totalcountdate =  $rs_date->RecordCount();
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Property Statistic period
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
    
    <!--........................................Search ........................................-->
	<tr><td>
	<form name="testform" action="admin.php?act=acc_booking_report" method="post">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
	<tr>
	<td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		
			
       <!-- From Date:-->Od:
        <input style="width:100px;" class="fields" type="text" name="sort_order"  id="sort_order" value="" />
        <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'testform',
                                        // input name
                                        'controlname': 'sort_order'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
        
		<!-- calendar attaches to existing form element -->
		<!--To Date:-->Do:
         <input style="width:100px;" class="fields" type="text" name="searchkeyword"  id="searchkeyword" value="" />
        <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'testform',
                                        // input name
                                        'controlname': 'searchkeyword'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
		</script>
        <input type="hidden" name="act" value="acc_booking_report">
		<input type="submit" name="sort" value="Pretra&#382;i" class="button" />
	  
	</td>
	</tr>
	
	</table>
	</form>		
	</td>
	</tr>
<!--..............................................End of Search .................................-->
    
    
    
    
    
    
    
    
    
    
    
    
    
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Records Found: <?php echo $totalcountalpha ?></td>
	</tr>
    <!--Add Form start from here-->
	
     
    <!--Add Form Ends here-->     
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="3%">Sr#</th>
                <th width="9%">Booking Number</th>
                <th width="9%">Booked By</th>
				<th width="9%">Guest Name</th>
                <th width="9%">Arrival</th>
                <th width="9%">Departure</th>
				<th width="4%">Rooms</th>
				<th width="4%">Persons</th>
				<th width="4%">Room Nights</th>
				<th width="5%">Commission %</th>
				<th width="7%">Result</th>
                <th width="6%">Original Amount</th>
				<th width="6%">Final Amount</th>
				<th width="6%">Commission Amount</th>
                <th width="10%">Notes</th>
             </tr>
			
		<?php 
		if($totalcountalpha >0){
		
		$commarra = array();
		$originalamtarr = array();
		$finalamtarr = array();
		$commissionamtarr = array();
		
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
			   while(!$rs_limit->EOF){
		?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
                        <td valign="top"><?php echo $rs_limit->fields['pincode'];?></td>						
                        <td valign="top"><?php echo $rs_limit->fields['customer_name']."&nbsp;".$rs_limit->fields['customer_last_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['customer_name']."&nbsp;".$rs_limit->fields['customer_last_name']; ?></td>
						<td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['check_indate'])) ?></td>											
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['check_outdate'])); ?></td>
						<td valign="top"><?php echo "1"; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['guests']; ?></td>
						<?php
							$start_ts = strtotime($rs_limit->fields['check_indate']);
							$end_ts = strtotime($rs_limit->fields['check_outdate']);
							$diff = $end_ts - $start_ts;
							$numdays = round($diff / 86400);
						?>
						<td valign="top"><?php echo $numdays; ?></td>
						<?php
						$qry_propslug = "SELECT id FROM ".$tblprefix."properties where ".$tblprefix."properties.properties_slug='".$rs_limit->fields['property_id']."'"; 
						$rs_propslug = $db->Execute($qry_propslug);
						
						$qry_propcomm = "SELECT commission FROM ".$tblprefix."users_commission where ".$tblprefix."users_commission.pt_id='".$rs_propslug->fields['id']."'"; 
						$rs_propcom = $db->Execute($qry_propcomm);
						?>	
						<td valign="top">
						<?php 
						echo $rs_propcom->fields['commission']; 
						$commarra[] = $rs_propcom->fields['commission'];
						?></td>
						<td valign="top"><?php echo booking_status($rs_limit->fields['booking_id'],$rs_propslug->fields['id']); ?></td>
						<?php
						$qry_price = "SELECT standard_rate_price FROM ".$tblprefix."standard_rates where ".$tblprefix."standard_rates.room_type_id='".$rs_limit->fields['room_id']."'"; 
						$rs_price = $db->Execute($qry_price);
						
						$finalamountcalc = $rs_price->fields['standard_rate_price']*$rs_propcom->fields['commission']/100;
						$finalamount = $finalamountcalc+$rs_price->fields['standard_rate_price'];
						
						?>
						<td valign="top"><?php echo $rs_price->fields['standard_rate_price']."EUR"; 
						$originalamtarr[] = $rs_price->fields['standard_rate_price'];
						?></td>	
						<td valign="top"><?php echo $finalamount."EUR"; 
						$finalamtarr[] = $finalamount;
						?></td>	
						<td valign="top"><?php echo $finalamountcalc."EUR";
						$commissionamtarr[] = $finalamountcalc;
						 ?></td>	
						
						<td valign="top">&nbsp;</td>						
                        
						
						<!--<td valign="top">
							<a href="admin.php?act=editregion&amp;id=<?php //echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php //MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_region&amp;mode=del_region&amp;id=<?php //echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=region_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php //MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>-->
					</tr>
			<?php 
						$rs_limit->MoveNext();
					}
			?>
					<tr bgcolor="#E7DAE7">
						<td colspan="9">&nbsp;</td>
						<td><strong><?php echo array_sum($commarra);?></strong></td>
						<td>&nbsp;</td>
						<td><strong><?php echo array_sum($originalamtarr);?></strong></td>
						<td><strong><?php echo array_sum($finalamtarr);?></strong></td>
						<td><strong><?php echo array_sum($commissionamtarr);?></strong></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
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
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							

							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Result Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>
<?php //echo $where;?>

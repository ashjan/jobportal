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

function booking_status($booking_id=0){
	
	global $db;
	global $tblprefix;
	
	$qry_booking = "SELECT id FROM ".$tblprefix."cancellation WHERE booking_id=".$booking_id;
	$rs_booking = $db->Execute($qry_booking);
	$count = $rs_booking->RecordCount();
	if($count>0){
		return  "Cancelled";
	}else {
		return "OK";
	}
	
}
function get_commission($property_slug=NULL){
	global $db;
	global $tblprefix;
	
	$qry_property_id = "SELECT id FROM ".$tblprefix."properties WHERE properties_slug='".$property_slug."'";
	$rs_property_id = $db->Execute($qry_property_id);
	$count = $rs_property_id->RecordCount();
	if($count>0){
		$qry_commission = "SELECT commission FROM ".$tblprefix."property_manager_commission WHERE pt_id=".$rs_property_id->fields['id'];
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




if(isset($_POST['searchby'])){

	$time ="";
	switch ($_POST['period']){
		case 0:
		   $date = date("m/d/Y");
		   $new_date = strtotime('-1 month',strtotime($date));
		   $new_date = date("m/d/Y",$new_date);
			break;
		case 1:
		   $date = date("m/d/Y");
		   $new_date = strtotime('-1 week',strtotime($date));
		   $new_date = date("m/d/Y",$new_date);
			break;
		case 2:
			$time = "selected_month";
			break;
		default:
		   $date = date("m/d/Y");
		   $new_date = strtotime('-1 month',strtotime($date));
		   $new_date = date("m/d/Y",$new_date);
			break;
			
	}
	switch ($_POST['searchby']){
		
		case 'booking':
			$where = "WHERE ".$tblprefix."property_booking.check_indate >='".$_POST['sort_order']."' AND ".$tblprefix."property_booking.check_outdate <='".$_POST['searchkeyword']."'";
			break;
			
		case 'arriving':
			
			$where = "WHERE ".$tblprefix."property_booking.check_indate >='".$new_date."'";
			break;
		case 'departing':
			$where = "WHERE ".$tblprefix."property_booking.check_outdate <='".$new_date."'";
			break;
		case 'staying':
			$where = "WHERE ".$tblprefix."property_booking.check_indate >='".$new_date."' OR ".$tblprefix."property_booking.check_outdate <='".$new_date."'";
			break;
			default:
			$where = "WHERE ".$tblprefix."property_booking.check_indate >='".$new_date."'";	
		
	}
	
}else{
$where=" ";
}

  $qry_state = "SELECT
			".$tblprefix."property_manager.first_name,
			".$tblprefix."property_manager.last_name,
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
			Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_booking.pm_id = ".$tblprefix."property_manager.id ".$where ;
			
			$rs_state = $db->Execute($qry_state);
			           
		//echo $qry_state;
		
			
			
			$count_add =  $rs_state->RecordCount();
			              
			$totalRows = $count_add;
			$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT 
			".$tblprefix."property_manager.first_name,
			".$tblprefix."property_manager.last_name,
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
			Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_booking.pm_id = ".$tblprefix."property_manager.id ".$where." LIMIT $startRow,$maxRows"; 
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
	<form name="testform" action="admin.php?act=manage_statistic" method="post">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	<tr>
	<td width="10%">Period</td>
	<td align="left"><select name="period" class="fields">
	<option value="0" <?php echo ($_REQUEST['period']==0)?"selected='selected'":"";?>>Month</option>
	<option value="1" <?php echo ($_REQUEST['period']==1)?"selected='selected'":"";?>>Week</option>
	<option value="2" <?php echo ($_REQUEST['period']==2 OR $_REQUEST['period']=='')?"selected='selected'":"";?>>Selected Period</option>
	</select>
	</td>
	</tr>
	<tr>
	<td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		
		<!--Search By : <br/>-->[Pretra&#382;i po]:
		<select name="searchby" class="smallfields">
			<option value="booking"<?php echo ($_REQUEST['searchby']=="booking" OR $_REQUEST['searchby']=='')?"selected='selected'":"";?>>Booking</option>
            <option value="arriving" <?php echo ($_REQUEST['searchby']=="arriving")?"selected='selected'":"";?>>Guests arriving in</option>
            <option value="departing" <?php echo ($_REQUEST['searchby']=="departing")?"selected='selected'":"";?>>Guests departing in</option>
            <option value="staying" <?php echo ($_REQUEST['searchby']=="staying")?"selected='selected'":"";?>>Guests staying in</option>
		</select>
		&nbsp;&nbsp;
		
        <!--From Date:<br/>-->[Od]:
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
		<!--To Date:<br/>-->[Do]:
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
        <input type="hidden" name="act" value="manage_statistic">
		<!--<input type="submit" name="sort" value="Search" class="button" />-->
	  <input type="submit" name="sort" value="Pretra&#382;i " class="button" />
	</td>
	</tr>
	
	</table>
	</form>		
	</td>
	</tr>
<!--..............................................End of Search .................................-->
    
    
    
    
    
    
    
    
    
    
    
    
    
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Property Regions Found: <?php echo $totalcountalpha ?></td>
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
				<td width="3%">Sr#</td>
                <td width="9%">Booking Number<br/>[Broj rezervacije]</td>
                <td width="9%">Confirmation Code<br/>[Šifra potvrde]</td>
                <td width="9%">Booking Date<br/>[Datum rezervacije]</td>
                <td width="9%">Booker Name+Guests<br/>[Ime gosta]</td>
                <td width="9%">Arrival<br/>[Dolazak]</td>
                <td width="9%">Departure<br/>[Odlazak]</td>
                <td width="7%">Status<br/>[Status]</td>
                <td width="9%">Total<br/>[Ukupno]</td>
                <td width="9%">Commission<br/>[Provizija]</td>
                <td width="9%">Action<br/>[Akcija]</td>
                <!--<td width="10%">Options</td>-->
		    </tr>
			
		<?php 
		if($totalcountalpha >0){
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
                        <td valign="top"><?php echo $rs_limit->fields['pincode']?></td>						
                        <td valign="top"><?php echo $rs_limit->fields['confirmation_code']; ?></td>						
                        <td valign="top"><?php echo date("F j Y, g:i a",strtotime($rs_limit->fields['transaction_date'])); ?></td>						
                        <td valign="top"><?php echo ucwords($rs_limit->fields['customer_name'])." ".ucwords($rs_limit->fields['customer_last_name']).",".$rs_limit->fields['guests'];; ?></td>						
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['check_indate'])) ?></td>											
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['check_outdate'])); ?></td>						
                        <td valign="top"><?php echo booking_status($rs_limit->fields['booking_id']); ?></td>						
                        <td valign="top"><?php echo $rs_limit->fields['price']; ?></td>					
                        <td valign="top"><?php echo get_commission($rs_limit->fields['property_id']); ?></td>			
                        <td valign="top"></td>						
                        
						
						<!--<td valign="top">
							<a href="admin.php?act=editregion&amp;id=<?php //echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php //MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_region&amp;mode=del_region&amp;id=<?php //echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=region_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php //MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>-->
					</tr>
			<?php 
						$rs_limit->MoveNext();
					}
			?>
					<tr>
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

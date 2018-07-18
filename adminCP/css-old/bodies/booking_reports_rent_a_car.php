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





/*function booking_status($booking_id=0){
	
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
}*/

//****** Query for Search **********************************************
//Search and Refining code




if(isset($_POST['sort'])){

     $sort_order=date("Y-m-d",strtotime($_POST['sort_order']));
	 $searchkeyword=date("Y-m-d",strtotime($_POST['searchkeyword']));
	 
$where= " WHERE ".$tblprefix."car_booking.car_bk_stdare<='".$sort_order."' AND ".$tblprefix."car_booking.car_bk_endate>='".$searchkeyword."'";
}





 $qry_state = "SELECT
				".$tblprefix."car_booking.bk_no_car,
				".$tblprefix."car_booking.car_bk_stdare,
				".$tblprefix."car_booking.car_bk_endate,
				".$tblprefix."car_booking.rent,
				".$tblprefix."car_booking.car_type,
				".$tblprefix."car_commission.car_type,
				".$tblprefix."car_commission.commission,
				".$tblprefix."car_booking.customer_id,
				".$tblprefix."customer.id,
				".$tblprefix."customer.customer_name,
				".$tblprefix."customer.customer_last_name
				FROM
				".$tblprefix."car_booking
				Left Join ".$tblprefix."car_commission ON ".$tblprefix."car_booking.car_type = ".$tblprefix."car_commission.car_type
				Left Join ".$tblprefix."customer ON ".$tblprefix."car_booking.customer_id = ".$tblprefix."customer.id ".$where ;
			
			$rs_state = $db->Execute($qry_state);
			           
		//echo $qry_state;
		
			
			
			$count_add =  $rs_state->RecordCount();
			              
			$totalRows = $count_add;
			$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT
				".$tblprefix."car_booking.bk_no_car,
				".$tblprefix."car_booking.car_bk_stdare,
				".$tblprefix."car_booking.car_bk_endate,
				".$tblprefix."car_booking.rent,
				".$tblprefix."car_booking.car_type,
				".$tblprefix."car_commission.car_type,
				".$tblprefix."car_commission.commission,
				".$tblprefix."car_booking.customer_id,
				".$tblprefix."customer.id,
				".$tblprefix."customer.customer_name,
				".$tblprefix."customer.customer_last_name
				FROM
				".$tblprefix."car_booking
				Left Join ".$tblprefix."car_commission ON ".$tblprefix."car_booking.car_type = ".$tblprefix."car_commission.car_type
				Left Join ".$tblprefix."customer ON ".$tblprefix."car_booking.customer_id = ".$tblprefix."customer.id ".$where." LIMIT $startRow,$maxRows"; 
			$rs_limit = $db->Execute($qry_limit);
			$totalcountalpha =  $rs_limit->RecordCount();
	
		
//Query to load "From and To Dates in the Dropdown"
$qry_date = "SELECT * FROM ".$tblprefix."property_booking"; 
$rs_date = $db->Execute($qry_date);
$totalcountdate =  $rs_date->RecordCount();


?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Rent A Car  Statistic &nbsp;[Statistika]</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
    
    <!--........................................Search ........................................-->
	<tr><td>
	<form name="testform" action="admin.php?act=booking_reports_rent_a_car" method="post">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
	<tr>
	<td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		
		
		
     <!--   From Date:-->Od
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
		<!--To Date:-->Do
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
        <input type="hidden" name="act" value="booking_reports_rent_a_car">
		<input type="submit" name="sort" value="Search" class="button" />
	  
	</td>
	</tr>
	
	</table>
	</form>		
	</td>
	</tr>
<!--..............................................End of Search .................................-->
    
    
    
    
    
    
    
    
    
    
    
    
    
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Rent Car Statistics Found: <?php echo $totalcountalpha ?></td>
	</tr>
    
	
    <!--Add Form start from here-->
	
	
	<tr class="">
    	<td colspan="5" align="right">
	<form name="test1" action="admin.php" method="post">
 	<input type="hidden" name="my_qry" value="<?php echo base64_encode($qry_state);?>" />
	<input type="hidden" name="act" value="booking_yacht_report" />
	<input type="hidden" name="request_page" value="car_print" />
	<input type="submit" name="abc" value="pr_int" />
	<input type="hidden" name="mode" value="aaa"/>
	 </form> 
		
        </td>
    </tr>
   
    
    
     
    <!--Add Form Ends here-->     
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
                <td width="9%">Booking Number<br/>[Broj rezervacije]</td>
                <td width="9%">Booked by<br/>[Rezervaciju izvršio]</td>
                <td width="9%">Customer Name<br/>[Ime kli]</td>
                <td width="5%">Pick Up<br/>[Mjesto preuzimanja ]</td>
                <td width="5%">Drop Off<br/>[Mjesto ostavljanja]</td>
                <td width="9%">Car Days<br/>[Trajanje ]</td>
                <td width="7%">Commission %<br/>[Iznos ] </td>
                <td width="5%">Results<br/>[Rezultat]</td>
                <td width="9%">Orignal Amount &euro;<br/>[Iznos]</td>
                <td width="9%">Final Amount &euro;<br/>[Konačni iznos]</td>
                <td width="9%">Commission Amount &euro;<br/>[Iznos provizije]</td>
                <td width="9%">Notes<br/>[Zabilješka]</td>
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
                        <td valign="top"><?php echo $rs_limit->fields['bk_no_car']?></td>						
                        <td valign="top"><?php echo ucwords($rs_limit->fields['customer_name'])." ".ucwords($rs_limit->fields['customer_last_name']); ?></td>
                        <td valign="top"><?php echo ucwords($rs_limit->fields['customer_name'])." ".ucwords($rs_limit->fields['customer_last_name']); ?></td>											
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['car_bk_stdare'])); ?></td>											
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['car_bk_endate'])); ?></td>						
                        <td valign="top"><?php 
						$date1 = strtotime($rs_limit->fields['car_bk_stdare']);
						$date2 = strtotime($rs_limit->fields['car_bk_endate']);
						// Calculate the differences, they should be 43 & 11353
						echo count_days( $date1, $date2 );
						 ?></td>						
                        <td valign="top"><?php echo number_format($rs_limit->fields['commission'],2);
						        $sum_commission[]=$rs_limit->fields['commission'];
						 ?>%</td>											
                        <td valign="top"><?php //echo $rs_limit->fields['commission']; ?></td>	<!--here i will past the Result Code-->				
                        <td valign="top"><?php echo number_format($rs_limit->fields['rent'],2);
						$rent[]= $rs_limit->fields['rent'];//array
						 ?>&euro;</td>			
                        <td valign="top"><?php
						  $comm=(float) $rs_limit->fields['commission']/100;
						  $final=(float) ($comm*$rs_limit->fields['rent']);
						  $final_amount=$final+$rs_limit->fields['rent'];
						  echo number_format($final_amount,2);
						  $final_amount_i[]= $final_amount;//array
						  
						?>&euro;</td>	
                        <td valign="top"><?php
						  $comm=(float)$rs_limit->fields['commission']/100;
						  $comm=$comm*$rs_limit->fields['rent'];
						  echo number_format($comm,2);
						  $comm_i[] = $comm;//array
						?>&euro;</td>		
                        <td valign="top"></td>						
                         <td valign="top">&nbsp;</td><!--Note will come here-->			
						
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
						<td colspan="6">&nbsp;</td>
                        <td style="font-size:18px;"><strong>Sale</strong></td>
                        
						<td><strong><?php echo number_format(array_sum($sum_commission),2);?></strong>%</td>
						<td>&nbsp;</td>
						<td><strong><?php echo number_format(array_sum($rent),2);?>&euro;</strong></td>
						<td><strong><?php echo number_format(array_sum($final_amount_i),2);?>&euro;</strong></td>
						<td><strong><?php echo number_format(array_sum($comm_i),2);?>&euro;</strong></td>
						<td>&nbsp;</td>
                        <td>&nbsp;</td>
					</tr>
                    
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
<?php //echo $where;?>

<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		

 $qry_properties = "SELECT 
                   prop_booking.id,
                   prop_booking.pm_id,
				   prop_booking.user_id,
				   prop_booking.property_id,
				   prop_booking.room_id,
				   prop_booking.confirmation_code,
				   prop_booking.pincode,
				   prop_booking.check_indate,
				   prop_booking.check_outdate,
				   prop_booking.guests,
				   prop_booking.transaction_date,
				   prop_booking.price,
				   prop.id,
				   prop.property_code,
				   prop.property_category,
				   prop.property_name,
				   prop.region,
				   prop.street,
				   prop.town,
				   prop.postcode,
				   prop.telephone,
				   prop.fax,
				   prop.email,
				   prop.property_url,
				   prop.numbers_of_stars,
				   prop.pm_type,
				   prop.short_description,
				   prop.contact_language,
				   prop.property_thumbnail,
				   prop.total_number_rooms,
				   pm.first_name,
				   pm.last_name,
				   pm.email_address,
				   pm.town,
				   pm.phone_number,
				   pm.pm_status,
				   pmc.commission,
				   vtc.vat_type_percent
				   FROM ".$tblprefix."properties as prop  
				   INNER JOIN ".$tblprefix."property_booking as prop_booking ON prop.properties_slug=prop_booking.property_id 
				   INNER JOIN ".$tblprefix."users as pm ON pm.id=prop_booking.pm_id
				   INNER JOIN ".$tblprefix."users_commission as pmc ON prop.id = pmc.pt_id
				   INNER JOIN ".$tblprefix."vat_tax_charges as vtc ON prop.id = vtc.property_id
				   GROUP BY
				   prop.property_code ";
		
		//  WHERE prop.pm_type=1"; 
        $rs_properties = $db->Execute($qry_properties);
        $totalinvoices =  $rs_properties->RecordCount();  
		
	//query for total price	
	   $qry_total_price = "SELECT 
				   SUM(prop_booking.price) as total_prices 
                   FROM ".$tblprefix."property_booking as prop_booking 
				   INNER JOIN ".$tblprefix."properties as prop ON prop.properties_slug=prop_booking.property_id 
				   INNER JOIN ".$tblprefix."users as pm ON pm.id=prop_booking.pm_id LIMIT 1";
		//  WHERE prop.pm_type=1"; 
        $rs_total_price = $db->Execute($qry_total_price);
        $totalprices =  $rs_total_price->RecordCount();
		
		
		
		
		
		
		//query for Rent a Car
	         $qry_car = "SELECT
						SUM(".$tblprefix."car_commission.commission) as total_car_commission,
						".$tblprefix."car_booking.car_bk_stdare,
						".$tblprefix."car_booking.car_bk_endate,
						SUM(".$tblprefix."car_booking.rent) as total_car_rent,
						".$tblprefix."car_booking.pm_id,
						".$tblprefix."car_booking.id
						FROM
						".$tblprefix."car_booking
						Inner Join ".$tblprefix."car_commission ON ".$tblprefix."car_booking.pm_id = ".$tblprefix."car_commission.pm_id LIMIT 1";
		//  WHERE prop.pm_type=1"; 
        $rs_car = $db->Execute($qry_car);
        $totalcars =  $rs_car->RecordCount();
		
		
		
		
		//query for Yacht Charter
	    $qry_yacht = "SELECT
						SUM(".$tblprefix."yatbooking.amount) as total_yacht_amount,
						".$tblprefix."yatbooking.pm_id,
						SUM(".$tblprefix."yacht_commission.commission) as total_yacht_commission,
						".$tblprefix."yatbooking.pickup,
						".$tblprefix."yatbooking.dropoff
						FROM
						".$tblprefix."yatbooking
						Inner Join ".$tblprefix."yacht_commission ON ".$tblprefix."yatbooking.pm_id = ".$tblprefix."yacht_commission.pm_id LIMIT 1";
		//  WHERE prop.pm_type=1"; 
        $rs_yacht = $db->Execute($qry_yacht);
        $totalyacht =  $rs_yacht->RecordCount();
		
		
		$maxRows = 18;
		if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
		if ($pageNum == '') $pageNum=0;
		$startRow = $pageNum * $maxRows;
		$totalRows = $totalinvoices;
		$totalPages = ceil($totalRows/$maxRows);
		$qry_letter_head = "SELECT * FROM ".$tblprefix."montenegro_letter_head "; 
		$rs_letter_head = $db->Execute($qry_letter_head);
		$totalcountletterhead =  $rs_letter_head->RecordCount();
		?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Invoice Report</td>
  	</tr>
    <tr>
    	<td  align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td align="right">Total Invoices Found: <?php echo $totalinvoices; ?></td>
	</tr>
  <tr>
    <td >
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="7" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="15%">Invoice Number</td>
                <td width="15%">Manager</td>
				<td width="15%">Property</td>
				<td width="15%">Address</td>
				<td width="15%">Payment Due (date)</td>
				<td width="10%">Options</td>
		    </tr>
		<?php 
		if($totalinvoices >0){
		while(!$rs_properties->EOF){
		?>
		<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
		<td valign="top"><?php echo ++$i; ?></td>
		<td valign="top"><?php echo $rs_properties->fields['property_code']; ?></td>	
		<td valign="top"><?php echo $rs_properties->fields['first_name']."&nbsp;".$rs_properties->fields['last_name']; ?></td>	
		<td valign="top"><?php echo $rs_properties->fields['property_name']; ?></td>			
		<td valign="top"><?php 
		echo $rs_properties->fields['region']."  ".$rs_properties->fields['street']."  ".$rs_properties->fields['town']."  <br/>  ".$rs_properties->fields['postcode'];?></td>		
		<td valign="top"> <?php echo date("F j, Y"); ?> </td>
		<td valign="top"><a href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_properties->fields['id']; ?>').slideToggle('fast'); return false"  >
	<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />	</a> 
		 </td>
	    </tr>
    <style>
	#controls_<?php echo $rs_properties->fields['id'] ?>{
	display:none;
	}
	</style>
	<td colspan="7">
				<div  id="controls_<?php echo $rs_properties->fields['id']; ?>">		
				<table cellpadding="2"  border="1" bordercolor="#666666" bgcolor="#E7DAE7" class="txt">
				<tr class="txt tabheading">
				<td>
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <tr>
                <td colspan="3"><img src="<?php echo MYSURL; ?>graphics/logo.png" /> <hr /></td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" class="txt" border="0">
                <td><strong>Property:</strong></td>
                <td><?php echo $rs_properties->fields['property_name']; ?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Property Manager:</strong></td>
                <td><?php echo $rs_properties->fields['first_name']."&nbsp;".$rs_properties->fields['last_name']; ?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Address:</strong></td>
                <td><?php 
		echo $rs_properties->fields['region']."  ".$rs_properties->fields['street'];?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="3" border="0" class="txt">
                <td><strong>ZIPCode,Town:</strong></td>
                <td><?php echo $rs_properties->fields['postcode']." ". $rs_properties->fields['town'];?></td>
                </table>
                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Property No:</strong></td>
                <td><?php 
		echo $rs_properties->fields['property_code'];?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Date:</strong></td>
                <td><?php echo date("d.m.Y");?></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Period:</strong></td>
                <td><?php echo date("d.m.Y", strtotime($rs_properties->fields['check_indate']))."&nbsp;". date("d.m.Y",strtotime($rs_properties->fields['check_outdate']));?></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Payment due:</strong></td>
                <td><?php echo date("F j, Y"); ?></td>
                </tr>
                
                <tr>
                <td colspan="2">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                
                <td><strong>INNVOICE NO :</strong></td>
                <td><?php echo $rs_properties->fields['property_code'];?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
				 
				
				<tr>
				
				<td colspan="3">
				<table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%" >
                <tr>
                <td width="4%"><strong>NO</strong></td>
                <td width="16%"><strong>Description</strong></td>
                <td width="16%"><strong>Period</strong></td>
                <td width="16%"><strong>Sales &euro;</strong></td>
                <td width="16%"><strong>Commission &euro;</strong></td>
                <td width="14%"><strong>VAT %</strong></td>
                <td width="18%"><strong>Total For Payment &euro;</strong></td>
                </tr>
                </table>
				</td>
				</tr>
				
				
			
                <tr>
                <td colspan="3">
				<table cellpadding="2" cellspacing="2" border="1" class="txt" width="100%">
				<tr>
				
				<td width="4%"><strong>1</strong></td>
                <td width="16%"><strong>Accommodation </strong></td>
                <td width="16%"><?php echo date("d.m.Y", strtotime($rs_properties->fields['check_indate']))."-". date("d.m.Y",strtotime($rs_properties->fields['check_outdate']));?></td>
                <td width="16%"><?php echo $rs_total_price->fields['total_prices']; ?><strong> &euro;</strong></td>
                <td width="16%"><?php echo $rs_properties->fields['commission']; ?> <strong>&euro;</strong></td>
                <td width="14%"><?php echo $rs_properties->fields['vat_type_percent']; ?><strong> %</strong></td>
                
                <td width="18%"><?php  
				$commission=$rs_properties->fields['commission'];
				$vat = $rs_properties->fields['vat_type_percent'];
				$totalprice = $rs_total_price->fields['total_prices'];
				$payment = (int)($totalprice*$vat/100);
				$total_for_payment = $payment+$totalprice+$commission;
				echo $total_for_payment;
				?><strong> &euro;</strong></td>
                
                
                
                
                </tr>
                
				
				<tr>
                <td><strong>2</strong></td>
                <td><strong>Rent a Car</strong></td>
                <td><?php echo date("d.m.Y", strtotime($rs_car->fields['car_bk_stdare']))."-". date("d.m.Y",strtotime($rs_car->fields['car_bk_endate']));?></td>
                <td><?php echo $rs_car->fields['total_car_rent'];?> <strong>&euro;</strong></td>
                <td><?php echo $rs_car->fields['total_car_commission'];?><strong>&euro;</strong></td>
                <td>17 <strong>%</strong></td>
                <td>
                <?php
					$car_rent=$rs_car->fields['total_car_rent'];
					$car_commission=$rs_car->fields['total_car_commission'];
					$car_payment = (int)($car_rent*17/100);
					$total_car_payment=$car_payment+$car_rent+$car_commission;
					echo $total_car_payment;
				?>
                 <strong>&euro;</strong></td>
                </tr>
				
				
				
				<tr>
                <td><strong>3</strong></td>
                <td><strong>Yacht Charter</strong></td>
                <td><?php echo date("d.m.Y", strtotime($rs_yacht->fields['pickup']))."-". date("d.m.Y",strtotime($rs_yacht->fields['dropoff']));?></td>
                <td><?php echo $rs_yacht->fields['total_yacht_amount'];?> <strong>&euro;</strong></td>
                <td><?php echo $rs_yacht->fields['total_yacht_commission'];?> <strong>&euro;</strong></td>
                <td>17 <strong>%</strong></td>
                <td>
                <?php
					$yacht_amount = $rs_yacht->fields['total_yacht_amount'];
					$yacht_commission = $rs_yacht->fields['total_yacht_commission'];
					$yacht_payment = (int)($yacht_amount*17/100);
					$total_yacht_payment=$yacht_payment+$yacht_amount+$yacht_commission;
					echo $total_yacht_payment;
                ?> 
                <strong>&euro;</strong></td>
                </tr>
				
				
				
				
				</table>
				</td>
				</tr>
				
                
                
                
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%" >  
                <tr>
                <td width="4%">&nbsp;</td>
                <td width="10%"><strong>Total online</strong></td>
                <td width="26%">&nbsp;</td>
                <td width="17%"><?php 
				 $total_online_price=$totalprice+$car_rent+$yacht_amount;
				 echo $total_online_price;
				 ?></td>
                <td width="22%"><?php 
				$total_online_commission=$commission+$car_commission+$yacht_commission;
				echo $total_online_commission;
				?></td>
                <td width="16%"><?php 
				$total_online_vat=$payment+$car_payment+$yacht_payment;
				echo $total_online_vat;
				?></td>
                <td width="16%"><?php 
				$total_online_for_payment=$total_for_payment+$total_car_payment+$total_yacht_payment;
				echo $total_online_for_payment;
				?></td>
                </tr>
                </table>
				</td>
				</tr>
				
				
                <tr>
                <td>&nbsp;</td>
                <td><strong>Total amount for payment</strong></td>
                <td><strong><?php echo $total_online_for_payment;?>&euro;</strong></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>VAT total</strong></td>
                <td><strong><?php echo $total_online_vat;?>&euro;</strong></td>
                </tr>
                
                
                <tr>
                <td><strong>Note:</strong></td>
                </tr>
               
               	<tr>
                <td><em><?php echo $rs_properties->fields['short_description']; ?>.</em></td>
                </tr>
                
                
                
                <tr>
                <td><strong>Invoiced by:</strong></td>
                <td><strong>PM</strong></td>
                <td><strong>Manager</strong></td>
                </tr>
                
                <tr>
                <td>_____________</td>
                <td>&nbsp;</td>
                <td>_____________</td>
                </tr>
                
                <tr>
                <td>
                <br /><br /> <br /><br /> <br /><br />
                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%">
                 <td width="10%">&nbsp;</td>
                <td width="80%">
                <hr />
                </td>
                <td width="10%">&nbsp;</td>
                </table>
                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" width="100%" class="txt">
                <td width="10%">&nbsp;</td>
                <td width="80%"><strong><em><?php echo $rs_letter_head->fields['letter_head_details'];?><br /> Tel/Fax:<?php echo $rs_letter_head->fields['letter_head_telephone'];?>,E_mail:<?php echo $rs_letter_head->fields['letter_head_email'];?>,Web:<?php echo $rs_letter_head->fields['letter_head_website'];?>,<br />Z<?php echo $rs_letter_head->fields['letter_head_other_details'];?></em></strong> </td>
                <td width="10%">&nbsp;</td>
                </table>
                </td>
                </tr>
                
                
                
                
                </table>
				</td>
     		    </tr>
				</table>	
				</div>
	          </td>
		<?php $rs_properties->MoveNext();
		 }
		?>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="7">
						
						
						
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
							if($pageNum>6){	?>
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
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->
						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Invoices Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	
	</td>
  </tr>
</table>
<?php //echo $where;?>

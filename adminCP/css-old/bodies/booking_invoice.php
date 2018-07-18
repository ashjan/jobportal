<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		

  $qry_booking = "SELECT
					".$tblprefix."property_booking.pincode,
					".$tblprefix."property_booking.check_indate,
					".$tblprefix."property_booking.check_outdate,
					".$tblprefix."property_booking.guests,
					".$tblprefix."property_booking.transaction_date,
					SUM(".$tblprefix."property_booking.price) as booking_price,
					".$tblprefix."property_booking.confirmation_code,
					".$tblprefix."property_booking.room_id,
					".$tblprefix."property_booking.property_id,
					".$tblprefix."property_booking.user_id,
					".$tblprefix."property_booking.pm_id,
					".$tblprefix."property_booking.id,
					
				   ".$tblprefix."properties.id,
				   ".$tblprefix."properties.property_code,
				   ".$tblprefix."properties.property_category,
				   ".$tblprefix."properties.property_name,
				   ".$tblprefix."properties.region,
				   ".$tblprefix."properties.street,
				   ".$tblprefix."properties.town,
				   ".$tblprefix."properties.postcode,
				   ".$tblprefix."properties.telephone,
				   ".$tblprefix."properties.fax,
				   ".$tblprefix."properties.email,
				   ".$tblprefix."properties.property_url,
				   ".$tblprefix."properties.numbers_of_stars,
				   ".$tblprefix."properties.pm_type,
				   ".$tblprefix."properties.contact_language,
				   ".$tblprefix."properties.property_thumbnail,
				   ".$tblprefix."properties.total_number_rooms,
				   ".$tblprefix."properties.properties_slug,
				   ".$tblprefix."properties.short_description,
					
					".$tblprefix."customer.customer_name,
					".$tblprefix."customer.customer_last_name,
					".$tblprefix."customer.confirmation_code,
					".$tblprefix."rooms.number_resources_available,
					".$tblprefix."rooms.max_persons_per_resource,
					SUM(".$tblprefix."property_manager_commission.commission) as pmc_commission,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					
					".$tblprefix."cancellation.cancellation_date,
					".$tblprefix."cancellation.room_type_id,
					".$tblprefix."cancellation.check_indate,
					".$tblprefix."cancellation.check_outdate,
					".$tblprefix."cancellation.booking_id
					FROM
					".$tblprefix."property_booking
					Inner Join ".$tblprefix."properties ON ".$tblprefix."property_booking.property_id = ".$tblprefix."properties.properties_slug
					Inner Join ".$tblprefix."customer ON ".$tblprefix."property_booking.user_id = ".$tblprefix."customer.id
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_booking.room_id = ".$tblprefix."rooms.id
					Left Join ".$tblprefix."property_manager_commission ON ".$tblprefix."property_booking.property_id = ".$tblprefix."property_manager_commission.pt_id 
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_booking.pm_id = ".$tblprefix."property_manager.id 
					Left Join ".$tblprefix."cancellation ON ".$tblprefix."property_booking.id = ".$tblprefix."cancellation.booking_id ";
		
		//  WHERE prop.pm_type=1"; 
        $rs_booking_report = $db->Execute($qry_booking);
        $totalbookingreport =  $rs_booking_report->RecordCount();  
		
	//query for total price	
	   $qry_total_price = "SELECT 
				   SUM(prop_booking.price) as total_prices 
                   FROM ".$tblprefix."property_booking as prop_booking 
				   INNER JOIN ".$tblprefix."properties as prop ON prop.properties_slug=prop_booking.property_id 
				   INNER JOIN ".$tblprefix."property_manager as pm ON pm.id=prop_booking.pm_id LIMIT 1";
		//  WHERE prop.pm_type=1"; 
        $rs_total_price = $db->Execute($qry_total_price);
        $totalprices =  $rs_total_price->RecordCount();
		
		
		
		
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
    	<td id="heading">Manage Booking Report</td>
  	</tr>
    <tr>
    	<td  align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td align="right">Total Reports Found: <?php echo $totalinvoices; ?></td>
	</tr>
  <tr>
    <td >
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="7" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="15%">Report Number</td>
                <td width="15%">Manager</td>
				<td width="15%">Property</td>
				<td width="15%">Address</td>
				<td width="15%">Payment Due (date)</td>
				<td width="10%">Options</td>
		    </tr>
		<?php 
		if($totalbookingreport >0){
		
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
		while(!$rs_booking_report->EOF){
		?>
		<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
		<td valign="top"><?php echo ++$i; ?></td>
		<td valign="top"><?php echo $rs_booking_report->fields['property_code']; ?></td>	
		<td valign="top"><?php echo $rs_booking_report->fields['first_name']."&nbsp;".$rs_booking_report->fields['last_name']; ?></td>	
		<td valign="top"><?php echo $rs_booking_report->fields['property_name']; ?></td>			
		<td valign="top"><?php 
		echo $rs_booking_report->fields['region']."  ".$rs_booking_report->fields['street']."  ".$rs_booking_report->fields['town']."  <br/>  ".$rs_booking_report->fields['postcode'];?></td>		
		<td valign="top"> <?php echo date("F j, Y"); ?> </td>
		<td valign="top"><a href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_booking_report->fields['id']; ?>').slideToggle('fast'); return false"  >
	<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />	</a> 
		 </td>
	    </tr>
    <style>
	#controls_<?php echo $rs_booking_report->fields['id'] ?>{
	display:none;
	}
	</style>
	<td colspan="7">
				<div  id="controls_<?php echo $rs_booking_report->fields['id']; ?>">
                		
				<!--<table cellpadding="2"  border="1" bordercolor="#666666" bgcolor="#E7DAE7" class="txt">
				<tr class="txt tabheading">
				<td>
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <tr>
                <td colspan="3"><img src="<?php //echo MYSURL; ?>graphics/logo.png" /> <hr />
                  <p>&nbsp;</p>
                  <p>&nbsp;</p></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" class="txt" border="0">
                <td><strong>Property:</strong></td>
                <td><?php //echo $rs_booking_report->fields['property_name']; ?></td>
                <td>&nbsp;</td>
                </table>                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Property Manager:</strong></td>
                <td><?php //echo $rs_booking_report->fields['first_name']."&nbsp;".$rs_booking_report->fields['last_name']; ?></td>
                <td>&nbsp;</td>
                </table>                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Address:</strong></td>
                <td><?php 
		//echo $rs_booking_report->fields['region']."  ".$rs_booking_report->fields['street'];?></td>
                <td>&nbsp;</td>
                </table>                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="3" border="0" class="txt">
                <td><strong>ZIPCode,Town:</strong></td>
                <td><?php //echo $rs_booking_report->fields['postcode']." ". $rs_booking_report->fields['town'];?></td>
                </table>                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Property No:</strong></td>
                <td><?php 
		//echo $rs_booking_report->fields['property_code'];?></td>
                <td>&nbsp;</td>
                </table>                </td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Date:</strong></td>
                <td><?php //echo date("d.m.Y");?></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Period:</strong></td>
                <td><?php //echo date("d.m.Y", strtotime($rs_booking_report->fields['check_indate']))."&nbsp;". date("d.m.Y",strtotime($rs_booking_report->fields['check_outdate']));?></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Payment due:</strong></td>
                <td><?php //echo date("F j, Y"); ?></td>
                </tr>
                
                <tr>
                <td colspan="2">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                
                <td><strong>INNVOICE NO :</strong></td>
                <td><?php //echo $rs_booking_report->fields['property_code'];?></td>
                <td>&nbsp;</td>
                </table>                </td>
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
                </table>				</td>
				</tr>
				
				
			
                <tr>
                <td colspan="3">
				<table cellpadding="2" cellspacing="2" border="1" class="txt" width="100%">
				<tr>
				
				<td width="4%"><strong>1</strong></td>
                <td width="16%"><strong>Accommodation </strong></td>
                <td width="16%"><?php //echo date("d.m.Y", strtotime($rs_booking_report->fields['check_indate']))."-". date("d.m.Y",strtotime($rs_booking_report->fields['check_outdate']));?></td>
                <td width="16%"><?php //echo $rs_booking_report->fields['total_prices']; ?><strong> &euro;</strong></td>
                <td width="16%"><?php //echo $rs_booking_report->fields['commission']; ?> <strong>&euro;</strong></td>
                
                
                <td width="18%"><?php  
				/*$commission=$rs_booking_report->fields['commission'];
				$totalprice = $rs_total_price->fields['total_prices'];
				$payment = (int)($totalprice*17/100);
				$total_for_payment = $payment+$totalprice+$commission;
				echo $total_for_payment;*/
				?><strong> &euro;</strong></td>
                </tr>
				</table>				</td>
				</tr>
				
                
                
                
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%" >  
                <tr>
                <td width="4%">&nbsp;</td>
                <td width="10%"><strong>Total online</strong></td>
                <td width="26%">&nbsp;</td>
                <td width="17%"><?php 
				 /*$total_online_price=$totalprice;
				 echo $total_online_price;*/
				 ?></td>
                <td width="22%"><?php 
				/*$total_online_commission=$commission;
				echo $total_online_commission;*/
				?></td>
                <td width="16%"><?php 
				//echo 17;
				?></td>
                <td width="16%"><?php 
				/*$total_online_for_payment=$total_for_payment;
				echo $total_online_for_payment;*/
				?></td>
                </tr>
                </table>				</td>
				</tr>
				
				
                <tr>
                <td>&nbsp;</td>
                <td><strong>Total amount for payment</strong></td>
                <td><strong><?php //echo $total_online_for_payment;?>&euro;</strong></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>VAT total</strong></td>
                <td><strong><?php //echo 17;?>&euro;</strong></td>
                </tr>
                
                
                <tr>
                <td><strong>Note:</strong></td>
                </tr>
               
               	<tr>
                <td><em>The Note will come here if there is any note.</em></td>
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
                <br /><br /> <br /><br /> <br /><br />                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%">
                 <td width="10%">&nbsp;</td>
                <td width="80%">
                <hr />                </td>
                <td width="10%">&nbsp;</td>
                </table>                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" width="100%" class="txt">
                <td width="10%">&nbsp;</td>
                <td width="80%"><strong><em><?php //echo $rs_letter_head->fields['letter_head_details'];?><br /> Tel/Fax:<?php //echo $rs_letter_head->fields['letter_head_telephone'];?>,E_mail:<?php //echo $rs_letter_head->fields['letter_head_email'];?>,Web:<?php //echo $rs_letter_head->fields['letter_head_website'];?>,<br />Z<?php //echo $rs_letter_head->fields['letter_head_other_details'];?></em></strong> </td>
                <td width="10%">&nbsp;</td>
                </table>                </td>
                </tr>
                </table>
				</td>
     		    </tr>
				</table>-->	
                
                
                
                <!--Table for Accommodation Start-->
                
                <table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
                  <tr>
                    <td><img src="<?php echo MYSURL; ?>graphics/logo.png" /> <hr /></td>
                  </tr>
                </table>
                
                
				<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
                  <tr>
                    <td><div align="center"><strong>Booking</strong></div></td>
                  </tr>
                </table>
                
				<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
                  <caption align="left">
                    <strong>period</strong>
                  </caption>
				  <tr>
                    <td width="4%"><strong>From:</strong></td>
				    <td width="96%"><?php echo date("d.m.Y", strtotime($rs_booking_report->fields['check_indate']))?></td>
			      </tr>
                  <tr>
                    <td width="4%"><strong>To:</strong></td>
                    <td width="96%"><?php echo date("d.m.Y", strtotime($rs_booking_report->fields['check_outdate']))?></td>
                  </tr>
                </table>
                
                
				<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
                  <tr>
                    <td width="10%"><div align="left"><strong>INVOICE NO:</strong></div></td>
                    <td width="90%"><?php echo $rs_booking_report->fields['property_code'];?></td>
                  </tr>
                </table>
                
				<table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
                  <caption>
                    <strong>Accommodation</strong>
                  </caption>
				  <tr>
                    <td><strong>NO</strong></td>
				    <td><strong>Book NO</strong></td>
				    <td><strong>Booked by</strong></td>
				    <td><strong>Guest Name</strong></td>
				    <td><strong>Arrival</strong></td>
				    <td><strong>Departure</strong></td>
				    <td colspan="3"><strong>Rooms</strong></td>
				    <td><strong>Commission</strong></td>
				    <td><strong>Result</strong></td>
				    <td><strong>Orignal Amount &euro;</strong></td>
				    <td><strong>Final Amount &euro;</strong></td>
				    <td><strong>Commission Amount &euro;</strong></td>
				    <td><strong>Notes</strong></td>
			      </tr>
                  <tr>
                    <td>1</td>
                    <td><?php echo $rs_booking_report->fields['pincode'];?></td>
                    <td><?php echo $rs_booking_report->fields['customer_name']." ".$rs_booking_report->fields['customer_last_name'];?></td>
                    <td><?php echo $rs_booking_report->fields['guests'];?></td>
                    <td><?php echo date("Y.m.d", strtotime($rs_booking_report->fields['check_indate']));?></td>
                    <td><?php echo date("Y.m.d", strtotime($rs_booking_report->fields['check_outdate']));?></td>
                    <td><?php echo $rs_booking_report->fields['number_resources_available'];?></td>
                    <td><?php echo $rs_booking_report->fields['number_resources_available'];?></td>
                    <td><?php echo $rs_booking_report->fields['number_resources_available'];?></td>
                    <td>
					<?php
				    if($rs_booking_report->fields['pmc_commission']==0){
					echo "NO";
					}else{
					echo $rs_booking_report->fields['pmc_commission'];
					}
					?>
                    </td>
                    <td>
					<?php
						$cancellation_date=date("Y.m.d",strtotime($rs_booking_report->fields['cancellation_date']));
						$check_outdate=date("Y.m.d",strtotime($rs_booking_report->fields['check_outdate']));
						$check_indate=date("Y.m.d",strtotime($rs_booking_report->fields['check_indate']));
						$current_date=date("Y.m.d");
						if($cancellation_date='' and ($check_outdate<=$current_date and $check_indate>=$current_date)){
							echo "Stayed";
						}else{
							echo "Cancelled";
						}
					?>
                    </td>
                    <td><?php echo $rs_booking_report->fields['booking_price'];?></td>
                    <td>
					<?php  
					$pmc_commission=$rs_booking_report->fields['pmc_commission'];
					$booking_price=$rs_booking_report->fields['booking_price'];
					$final_amount = $pmc_commission+$booking_price;
					echo $final_amount;
					?>
                    </td>
                    <td><?php if($rs_booking_report->fields['pmc_commission']==0){
					echo "NO";
					}else{
					echo $rs_booking_report->fields['pmc_commission'];
					}?></td>
                    <td><?php echo $rs_booking_report->fields['short_description'];?></td>
                  </tr>
                </table>
                
                
				<table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
                  <tr>
                    <td width="44%">&nbsp;</td>
                    <td width="13%"><strong>SALES</strong></td>
                    <td width="12%"><?php echo $rs_booking_report->fields['booking_price'];?></td>
                    <td width="12%"><?php echo $final_amount; ?></td>
                    <td width="11%"><?php if($rs_booking_report->fields['pmc_commission']=0){
						echo 0;					
					}else{
						echo $rs_booking_report->fields['pmc_commission'];
					}
					?></td>
                    <td width="8%">&nbsp;</td>
                  </tr>
                </table>
                <!--Table for Accommodation ends here-->
                
                
                <!--Table for Rent a Car-->
                
                <table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
                  <caption>
                    <strong>Rent a Car</strong>
                  </caption>
				  <tr>
                    <td><strong>NO</strong></td>
				    <td><strong>Book NO</strong></td>
				    <td><strong>Booked by</strong></td>
				    <td><strong>Customer Name</strong></td><!--This is basically the Guest Name But the Client mentioned it as Customer Name which is already presient in  above field-->
				    <td><strong>Pick Up</strong></td>
				    <td><strong>Drop Off</strong></td>
				    <td><strong>Car Days</strong></td>
				    <td><strong>Commission</strong></td>
				    <td><strong>Result</strong></td>
				    <td><strong>Orignal Amount &euro;</strong></td>
				    <td><strong>Final Amount &euro;</strong></td>
				    <td><strong>Commission Amount &euro;</strong></td>
				    <td><strong>Notes</strong></td>
			      </tr>
                  <tr>
                    <td>1</td>
                    <td>4545</td>
                    <td>saad</td>
                    <td>khalid</td><!--This is basically the Guest Name But the Client mentioned it as Customer Name which is already presient in  above field.-->
                    <td>10.12.2011</td>
                    <td>10.01.2012</td>
                    <td>1</td>
                    <td>500</td>
                    <td>Used Or Cancelled</td>
                    <td>545454545454</td>
                    <td>78745485145584</td>
                    <td>5000</td>
                    <td>This was nice Car</td>
                  </tr>
                </table>
                
                <table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
                  <tr>
                    <td width="44%">&nbsp;</td>
                    <td width="13%"><strong>SALES</strong></td>
                    <td width="12%">54545454545454</td>
                    <td width="12%">78787878787878</td>
                    <td width="11%">5000</td>
                    <td width="8%">&nbsp;</td>
                  </tr>
                </table>
                
                <!--Table for Rent a Car Ends Here-->
                
                
                <!--Table for the Yacht Starts-->
                
                <table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
                  <caption>
                    <strong>Yacht</strong>
                  </caption>
				  <tr>
                    <td><strong>NO</strong></td>
				    <td><strong>Book NO</strong></td>
				    <td><strong>Booked by</strong></td>
				    <td><strong>Customer Name</strong></td><!--This is basically the Guest Name But the Client mentioned it as Customer Name which is already presient in  above field-->
				    <td><strong>Pick Up</strong></td>
				    <td><strong>Drop Off</strong></td>
				    <td><strong>Yacht/Days-Weeks</strong></td>
				    <td><strong>Commission</strong></td>
				    <td><strong>Result</strong></td>
				    <td><strong>Orignal Amount &euro;</strong></td>
				    <td><strong>Final Amount &euro;</strong></td>
				    <td><strong>Commission Amount &euro;</strong></td>
				    <td><strong>Notes</strong></td>
			      </tr>
                  <tr>
                    <td>1</td>
                    <td>4545</td>
                    <td>saad</td>
                    <td>khalid</td><!--This is basically the Guest Name But the Client mentioned it as Customer Name which is already presient in  above field.-->
                    <td>10.12.2011</td>
                    <td>10.01.2012</td>
                    <td>1</td>
                    <td>500</td>
                    <td>Used Or Cancelled</td>
                    <td>545454545454</td>
                    <td>78745485145584</td>
                    <td>5000</td>
                    <td>This was nice Yacht</td>
                  </tr>
                </table>
                
                <table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
                  <tr>
                    <td width="44%">&nbsp;</td>
                    <td width="13%"><strong>SALES</strong></td>
                    <td width="12%">54545454545454</td>
                    <td width="12%">78787878787878</td>
                    <td width="11%">5000</td>
                    <td width="8%">&nbsp;</td>
                  </tr>
                </table>
                
                <!--Table Yacht Ends Here-->
                
				<p>&nbsp;</p>
				</div>
          </td>
		<?php $rs_booking_report->MoveNext();
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
					<td colspan="14" class="errmsg"> No Reprot Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	
	</td>
  </tr>
</table>
<?php //echo $where;?>

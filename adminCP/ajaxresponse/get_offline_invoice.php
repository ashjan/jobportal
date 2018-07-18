<?php
	include('root.php');
    include($root.'include/file_include.php');
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
	
  $propid= $_GET['propid'];
  $pm_id= $_GET['pm_id'];
  
 $qry_offline_properties = "SELECT
					".$tblprefix."vat_tax_charges.pm_id,
					".$tblprefix."vat_tax_charges.property_id,
					".$tblprefix."vat_tax_charges.id,
					".$tblprefix."vat_tax_charges.vat_amount,
					".$tblprefix."vat_tax_charges.vat_type_percent,
					".$tblprefix."vat_tax_charges.service_charges_type,
					".$tblprefix."vat_tax_charges.city_tax_amount,
					".$tblprefix."vat_tax_charges.service_charge_amount,
					".$tblprefix."standard_rates.standard_start_date,
					".$tblprefix."standard_rates.standard_end_date,
					
					".$tblprefix."properties.property_code,
					".$tblprefix."properties.property_name,
					".$tblprefix."properties.property_category,
					".$tblprefix."properties.region,
					".$tblprefix."properties.street,
					".$tblprefix."properties.town,
					".$tblprefix."properties.postcode,
					".$tblprefix."properties.telephone,
					".$tblprefix."properties.fax,
					".$tblprefix."properties.email,
					".$tblprefix."properties.property_url,
					".$tblprefix."properties.numbers_of_stars,
					".$tblprefix."properties.total_number_rooms,
					".$tblprefix."properties.local_bank_account,
					".$tblprefix."properties.properties_slug,
					".$tblprefix."properties.id,
					".$tblprefix."properties.no_property_rooms,
					".$tblprefix."properties.contact_language,
					".$tblprefix."properties.short_description,
					".$tblprefix."properties.pm_type,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					
					".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_category.property_category_slug
					
					FROM
					".$tblprefix."vat_tax_charges
					Inner Join ".$tblprefix."standard_rates ON ".$tblprefix."vat_tax_charges.property_id = ".$tblprefix."standard_rates.property_id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."vat_tax_charges.property_id = ".$tblprefix."properties.id
                    Inner Join ".$tblprefix."property_manager ON ".$tblprefix."vat_tax_charges.pm_id = ".$tblprefix."property_manager.id
					Inner Join ".$tblprefix."property_category ON ".$tblprefix."properties.property_category = ".$tblprefix."property_category.id
					WHERE
                    ".$tblprefix."properties.pm_type =  '0' 
					AND
					".$tblprefix."vat_tax_charges.property_id =  $propid
					AND
					".$tblprefix."vat_tax_charges.pm_id =  $pm_id 
					GROUP BY
					".$tblprefix."properties.property_name";
	
					
		
		//  WHERE prop.pm_type=1"; 
        $rs_offline_properties = $db->Execute($qry_offline_properties);
        $totalofflineinvoices =  $rs_offline_properties->RecordCount(); 
		
		$maxRows = 18;
		if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
		if ($pageNum == '') $pageNum=0;
		$startRow = $pageNum * $maxRows;
		$totalRows = $totalofflineinvoices;
		$totalPages = ceil($totalRows/$maxRows);
		$qry_letter_head = "SELECT * FROM ".$tblprefix."montenegro_letter_head "; 
		$rs_letter_head = $db->Execute($qry_letter_head);
		$totalcountletterhead =  $rs_letter_head->RecordCount();
		?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
    <tr>
    	<td  align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td align="right">Total offline invoices found: <?php echo $totalofflineinvoices; ?></td>
	</tr>
  <tr>
    <td >
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="7" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="15%">Property Code<br/>[Code objekta]</td>
                <td width="15%">Manager<br/>[objekta]</td>
                <td width="15%">property Name</td>
				<td width="15%">Address<br/>[adresa]</td>
				<td width="15%">Current Date<br/>[Trenutni datum]</td>				
				<td width="10%">Options</td>
		    </tr>
		<?php 
		if($totalofflineinvoices >0){
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
		while(!$rs_offline_properties->EOF){
		?>
		<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
		<td valign="top"><?php echo ++$i; ?></td>
		<td valign="top"><?php echo $rs_offline_properties->fields['property_code']; ?></td>	
		<td valign="top"><?php echo $rs_offline_properties->fields['first_name']."&nbsp;".$rs_offline_properties->fields['last_name']; ?></td>	
		<td valign="top"><?php echo $rs_offline_properties->fields['property_name']; ?></td>			
		<td valign="top"><?php 
		echo $rs_offline_properties->fields['region']."  ".$rs_offline_properties->fields['street']."  ".$rs_offline_properties->fields['town']."  <br/>  ".$rs_offline_properties->fields['postcode'];?></td>		
		<td valign="top"> <?php echo date("F j, Y"); ?> </td>
		<td valign="top"><a href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_offline_properties->fields['id']; ?>').slideToggle('fast'); return false"  >
	<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />	</a> 
		 </td>
	    </tr>
    <style>
	#controls_<?php echo $rs_offline_properties->fields['id'] ?>{
	display:none;
	}
	</style>
	<td colspan="7">
				<div  id="controls_<?php echo $rs_offline_properties->fields['id']; ?>">		
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
                <td><?php echo $rs_offline_properties->fields['property_name']; ?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Property Manager:</strong></td>
                <td><?php echo $rs_offline_properties->fields['first_name']."&nbsp;".$rs_offline_properties->fields['last_name']; ?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Address:</strong></td>
                <td><?php 
		echo $rs_offline_properties->fields['region']."  ".$rs_offline_properties->fields['street'];?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
                <tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="3" border="0" class="txt">
                <td><strong>ZIPCode,Town:</strong></td>
                <td><?php echo $rs_offline_properties->fields['postcode']." ". $rs_offline_properties->fields['town'];?></td>
                </table>
                </td>
                </tr>
                
                
          	    <!--<tr>
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                <td><strong>Property No:</strong></td>
                <td><?php 
		//echo $rs_offline_properties->fields['property_code'];?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>-->     
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Date:</strong></td>
                <td><?php echo date("d.m.Y");?></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Period:</strong></td>
                <td><?php echo date("d.m.Y", strtotime($rs_offline_properties->fields['standard_start_date']))."&nbsp;". date("d.m.Y",strtotime($rs_offline_properties->fields['standard_end_date']));?></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>Payment due:</strong></td>
                <td><?php echo date("d.m.Y"); ?></td>
                </tr>
                
                <tr>
                <td colspan="2">
                <table cellpadding="2" cellspacing="2" border="0" class="txt">
                
                <td><strong>INNVOICE NO :</strong></td>
                <td><?php echo $rs_offline_properties->fields['property_code'];?></td>
                <td>&nbsp;</td>
                </table>
                </td>
                </tr>
                
				 
				<tr>
				
				<td colspan="3">
				<table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%" >
                <tr>
                <td width="4%"><strong>NO</strong></td>
                <td width="35%"><strong>Description Services</strong></td>
                <td width="16%"><strong>Period</strong></td>
                <td width="16%"><strong>Amount &euro;</strong></td>
                <td width="16%"><strong>VAT %</strong></td>
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
                
                
                
                
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%">
                <tr>
                <td width="6%"><strong>Advertising</strong></td>
                <td width="6%"><strong>services </strong></td>
                <td width="6%"><strong>Category </strong></td>
                </tr>
                
                
                <tr>
                <td width="6%"><?php echo $rs_offline_properties->fields['property_name']; ?></td>
                <td width="6%"><?php echo $rs_offline_properties->fields['service_charges_type']; ?></td>
                <td width="6%"><?php echo $rs_offline_properties->fields['property_category_name'];?></td>
                </tr>
                </table>
                </td>
                
                
                
                
                
                
                
                
                
                
                
                <td width="16%"><?php echo date("d.m.Y", strtotime($rs_offline_properties->fields['standard_start_date']))."-". date("d.m.Y",strtotime($rs_offline_properties->fields['standard_end_date']));?></td>
                <td width="16%"><?php echo $rs_offline_properties->fields['vat_amount']; ?><strong> &euro;</strong></td>
                <td width="14%"><?php echo $rs_offline_properties->fields['vat_type_percent']; ?><strong> %</strong></td>
                
                <td width="18%"><?php
				$vat_type_percent = $rs_offline_properties->fields['vat_type_percent'];
				$vat_amount = $rs_offline_properties->fields['vat_amount'];
				$payment = (int)($vat_amount*$vat_type_percent/100);
				$total_for_payment = $payment+$vat_amount;
				echo $total_for_payment;
				?><strong> &euro;</strong></td>
                
                
                
                
                </tr>
                
				
				<!--<tr>
                <td><strong>2</strong></td>
                <td><strong>Rent a Car</strong></td>
                <td><?php //echo date("d.m.Y", strtotime($rs_car->fields['car_bk_stdare']))."-". date("d.m.Y",strtotime($rs_car->fields['car_bk_endate']));?></td>
                <td><?php //echo $rs_car->fields['total_car_rent'];?> <strong>&euro;</strong></td>
                <td><?php //echo $rs_car->fields['total_car_commission'];?><strong>&euro;</strong></td>
                <td>17 <strong>%</strong></td>
                <td>
                <?php
					/*$car_rent=$rs_car->fields['total_car_rent'];
					$car_commission=$rs_car->fields['total_car_commission'];
					$car_payment = (int)($car_rent*17/100);
					$total_car_payment=$car_payment+$car_rent+$car_commission;
					echo $total_car_payment;*/
				?>
                 <strong>&euro;</strong></td>
                </tr>-->
				
				
				
				<!--<tr>
                <td><strong>3</strong></td>
                <td><strong>Yacht Charter</strong></td>
                <td><?php //echo date("d.m.Y", strtotime($rs_yacht->fields['pickup']))."-". date("d.m.Y",strtotime($rs_yacht->fields['dropoff']));?></td>
                <td><?php //echo $rs_yacht->fields['total_yacht_amount'];?> <strong>&euro;</strong></td>
                <td><?php //echo $rs_yacht->fields['total_yacht_commission'];?> <strong>&euro;</strong></td>
                <td>17 <strong>%</strong></td>
                <td>
                <?php
					/*$yacht_amount = $rs_yacht->fields['total_yacht_amount'];
					$yacht_commission = $rs_yacht->fields['total_yacht_commission'];
					$yacht_payment = (int)($yacht_amount*17/100);
					$total_yacht_payment=$yacht_payment+$yacht_amount+$yacht_commission;
					echo $total_yacht_payment;*/
                ?> 
                <strong>&euro;</strong></td>
                </tr>-->
				
				
				</table>
				</td>
				</tr>
				
                
                
                
                <td colspan="3">
                <table cellpadding="2" cellspacing="2" border="0" class="txt" width="100%" >  
                <tr>
                <td width="4%">&nbsp;</td>
                <td width="10%"><strong>Total Offline</strong></td>
                <td width="26%">&nbsp;</td>
                <td width="17%"><?php 
				 $total_offline_price=$vat_amount;
				 echo $total_offline_price;
				 ?> <strong>&euro;</strong></td>
                
                <td width="16%"><?php 
				$total_offline_vat=$vat_type_percent;
				echo $total_offline_vat;
				?><strong>&euro;</strong></td>
                <td width="16%"><?php 
				$total_offline_for_payment=$total_for_payment;
				echo $total_offline_for_payment;
				?><strong>&euro;</strong></td>
                </tr>
                </table>
				</td>
				</tr>
				
				
                <tr>
                <td>&nbsp;</td>
                <td><strong>Total amount for payment:</strong></td>
                <td><strong><?php echo $total_offline_for_payment;?>&euro;</strong></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td><strong>VAT total:</strong></td>
                <td><strong><?php echo $total_offline_vat;?>&euro;</strong></td>
                </tr>
                
                
                <tr>
                <td><strong>Note:</strong></td>
                </tr>
               
               	<tr>
                <td><em><?php echo $rs_offline_properties->fields['short_description']; ?>.</em></td>
                </tr>
                
                
                
                <tr>
                <td><strong>Invoiced by:</strong></td>
                <td><strong>PM:</strong></td>
                <td><strong>Manager:</strong></td>
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
		<?php $rs_offline_properties->MoveNext();
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
					<td colspan="14" class="errmsg"> Nema Invoices pronađeni</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	
	</td>
  </tr>
</table>
<?php //echo $where;?>

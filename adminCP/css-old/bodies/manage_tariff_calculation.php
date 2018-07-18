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

 $qry_faq = "SELECT
					".$tblprefix."tariff_calculations.*
					FROM
					".$tblprefix."tariff_calculations";
					
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 $qry_limit = "SELECT
					".$tblprefix."tariff_calculations.*
					FROM
					".$tblprefix."tariff_calculations
					LIMIT   $startRow,$maxRows"; 

$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

 $qry_property = "SELECT
                    
					".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties"; 
$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();



//pm id
$qry_property_manag = "SELECT
                    ".$tblprefix."property_manager.id,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name 
					FROM
					".$tblprefix."property_manager"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Property Features</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Property features Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
			  	

				<tr>
				<td class="txt1">Price Period</td>
				<td>
				<!--<input type="text" name="price_period" id="price_period" class="price_period" value="" >-->
				<select class="dropfields"  name="price_period" id="price_period">
				<option value="0">Select Price Period</option> 
				<option value="1">Price Per Night</option> 
				<option value="2">Price Per Week</option>
				<option value="3">Price Per Month</option>
        		</select>
				
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Per Person</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="per_person" id="per_person_yes" checked="checked" value="1" ><span> Yes</span>
				<input type="radio" name="per_person"  id="per_person_no" value="0"  ><span> No</span>
				</div>
				
				</td> 
				</tr>
				
				<tr>
				<td colspan="2">
				<div class="field_comments">
				  Activate/Deactivate the discount feature here. 
				</div>
				</td>
				</tr>
				
				
				<tr>
				<td class="txt1">Early Booking</td>
				<td>
				
				<div class="fields_checked">
				<input type="radio" name="wise_price" id="wise_price_yes" checked="checked" value="1" onClick="jQuery('#wise_price_parameters').show('fast');" ><span> Yes</span>
				<input type="radio" name="wise_price"  id="wise_price_no" value="0" onClick="jQuery('#wise_price_parameters').hide('fast');" ><span> No</span>
				</div>
				
				</td> 
				</tr>
				</table>
				<div id="wise_price_parameters" style="margin-left:-21px;">
				<table cellpadding="1" cellspacing="1" border="0" >	
				<tr>
				<td class="txt1">Threshold</td>
				<td>
				<input type="text" name="threshold" class="fields" id="threshold" value="" />
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Discount Percentage</td>
				<td>
				
				
			<select name="discount_percentage" class="fields"   id="discount_percentage">
				<option value="1">10 % Discount</option>
				<option value="2">25 % Discount</option>
				<option value="3">50 % Discount</option>
				<option value="4">75 % Discount</option>
			</select>
				
				</td> 
				</tr>
				</table>
				</div>
				<table cellpadding="1" cellspacing="1" border="0" style="margin-left:-174px;" >	
				<tr>
				<td class="txt1">Refundable</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="refundable" id="refundable_yes" checked="checked" value="1" ><span>Yes</span>
				<input type="radio" name="refundable"  id="refundable_no" value="0" ><span> No</span>
				</div>
				
				
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Lastminute Deal</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="lastminute_deal" id="lastminute_deal_yes" checked="checked" value="1" onClick="jQuery('#lastmint_threshold1').show('fast');"  ><span> Yes</span>
				<input type="radio" name="lastminute_deal"  id="lastminute_deal_no" value="0" onClick="jQuery('#lastmint_threshold1').hide('fast');"><span> No</span>
				</div>
				
				</td> 
				</tr>
				</table>
				<div id="lastmint_threshold1" style="margin-left:-21px;">
				<table cellpadding="1" cellspacing="1" border="0" >	
				<tr>
				<td class="txt1">Lastminute Threshold</td>
				<td>
				
				<input type="text" name="lastminute_threshold" class="fields" id="lastminute_threshold" value="" />
				
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Lastminute Discount_rate</td>
				<td>
				<input type="text" name="lastminute_discount_rate" class="fields" id="lastminute_discount_rate" value="" />
				</td> 
				</tr>
				</table>
				</div>
				<table cellpadding="1" cellspacing="1" border="0" >	
				
<?php 
				if($totallanguages>0){ 
					while(!$rs_language->EOF){
					echo '<tr>
					<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
					<td>
					<input name="categoryname_'.$rs_language->fields['id'].'" id="categoryname_'.$rs_language->fields['id'].'" value="" type="text" size="55"  maxlength="100" />
					</td>
					</tr>';
					$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Features" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="manage_tariff_calculation">
		<input type="hidden" name="act2" value="manage_tariff_calculation">
		<input type="hidden" name="request_page" value="tariff_management" />
					</td>
				</tr>
</form> 

  </div>  
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="4%">Sr#</td>
				<td width="8%">Price Period</td>
				<td width="8%">Early Booking</td>
				<td width="8%">Threshold</td>
				<td width="8%">Discount Percentage</td>
				<td width="8%">Refundable</td>
				<td width="8%">:astminute Deal</td>
				<td width="8%">lastminute threshold</td>
				<td width="8%">lastminute discount rate</td>
				<td width="8%">Options</td>
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
						<td valign="top"><?php if($rs_limit->fields['price_period'] == 1 ){ echo "Price Per Night";	}
						elseif($rs_limit->fields['price_period'] == 2 ){ echo "Price Per Week";}
						elseif($rs_limit->fields['price_period'] == 3 ){ echo "Price Per Month";}   ?></td>



						
						<td valign="top"><?php if($rs_limit->fields['wise_price'] == 0 ){ echo "On"; }else echo "Off"; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['threshold']; ?></td>
						<td valign="top"><?php 
						if($rs_limit->fields['discount_percentage'] == 0 ){ echo "0 % ";	}
						if($rs_limit->fields['discount_percentage'] == 1 ){ echo "10 % ";	}
						elseif($rs_limit->fields['discount_percentage'] == 2 ){ echo "25 % ";}
						elseif($rs_limit->fields['discount_percentage'] == 3 ){ echo "50 % ";}
						elseif($rs_limit->fields['discount_percentage'] == 4 ){ echo "75 % ";} ?></td>
						<td valign="top"><?php if($rs_limit->fields['refundable'] == 0 ){ echo "On"; }else echo "Off"; ?></td>
						<td valign="top"><?php if($rs_limit->fields['lastminute_deal'] == 0 ){ echo "On"; }else echo "Off"; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['lastminute_threshold']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['lastminute_discount_rate']; ?></td>
						
							
						<td valign="top">
							<a href="admin.php?act=edit_tariff&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;request_page=tariff_management""><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_tariff_calculation&amp;mode=del_tariff&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=tariff_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>
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
					<td colspan="14" class="errmsg"> No Tariff Calculation Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

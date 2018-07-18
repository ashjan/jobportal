<?php
$id=base64_decode($_GET['id']);


 $qry_limit = "SELECT 
                   id,
				   property_id,
                   pm_id,
				   price_period,
				   per_person,
				   wise_price,
				   threshold,
				   discount_percentage,
				   lastminute_deal,
				   lastminute_threshold,
				   lastminute_discount_rate
                   FROM ".$tblprefix."tariff_calculations WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

$qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					
					FROM
					tbl_properties
					";
$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id

$sel_qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					
					FROM
					tbl_properties
					where id = ".$rs_limit->fields['property_id']; 
$sel_rs_property = $db->Execute($sel_qry_property);
//pm id

$qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					
					FROM
					tbl_users"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();

$sel_qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					
					FROM
					tbl_users
					where id = ".$rs_limit->fields['pm_id'];
					 
$sel_rs_property_manag = $db->Execute($sel_qry_property_manag);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Tariff Section</td>
 	</tr>
 
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	

              
			  
			 
				
				<tr>
				<td class="txt1">Price Period</td>
				<td>
	<!--			<input type="text" name="price_period" id="price_period" class="price_period" value="<?php //echo date("m/d/Y",strtotime(price_period))?>" >-->
	
	
	 	<select class="dropfields"  name="price_period" id="price_period">
        <option value="<?php echo $rs_limit->fields['price_period']; ?>">
		<?php     if($rs_limit->fields['price_period'] == 1 ){ echo "Price Per Night";	}
		      elseif($rs_limit->fields['price_period'] == 2 ){ echo "Price Per Week";}
			  elseif($rs_limit->fields['price_period'] == 3 ){ echo "Price Per Month";} ?>
		</option> 
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
<input type="radio" name="per_person" value="1" id="per_person_yes"   <?php if($rs_limit->fields['per_person'] == 1 ){ ?> checked="checked" <?php } ?> ><span> Yes</span>
<input type="radio" name="per_person" value="0" id="per_person_no"  <?php if($rs_limit->fields['per_person'] == 0 ){ ?> checked="checked" <?php } ?> ><span> No</span>
</div>
				</td> 
				</tr>
				<tr>
				<td class="txt1">Early Booking</td>
				<td>
				<div class="fields_checked" style="float:left; width:100px;">
	<input type="radio" name="wise_price" value="1" id="wise_price_yes" <?php if($rs_limit->fields['wise_price'] == 1 ){ ?> checked="checked" <?php } ?>  onClick="jQuery('#wise_price_parameters').show('fast');" ><span> Yes</span>
	<input type="radio" name="wise_price" value="0" id="wise_price_no" <?php if($rs_limit->fields['wise_price'] == 0 ){ ?> checked="checked" <?php } ?> onClick="jQuery('#wise_price_parameters').hide('fast');" ><span> No</span>
				</div>
				<div class="field_comments">
				  Activate/Deactivate the discount feature here. 
				</div>
				</td> 
				</tr>
				</table>
				<div id="wise_price_parameters" style="margin-left:-118px; <?php if($rs_limit->fields['wise_price'] == 0 ){ ?>  display:none; <?php } ?>" >
				<table cellpadding="1" cellspacing="1" border="0" >	
				<tr>
				<td class="txt1">Threshold</td>
				<td>
				<input type="text" name="threshold" class="fields" id="threshold" value="<?php echo $rs_limit->fields['threshold']; ?>" />
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Discount Percentage</td>
				<td>
				
				
			<select name="discount_percentage" class="fields"   id="discount_percentage">
				<option value="<?php echo $rs_limit->fields['discount_percentage']; ?>">
				<?php     if($rs_limit->fields['discount_percentage'] == 1 ){ echo "10 % Discount";	}
		      elseif($rs_limit->fields['discount_percentage'] == 2 ){ echo "25 % Discount";}
			  elseif($rs_limit->fields['discount_percentage'] == 3 ){ echo "50 % Discount";}
			  elseif($rs_limit->fields['discount_percentage'] == 4 ){ echo "75 % Discount";}
			   ?>
				</option>
				<option value="1">10 % Discount</option>
				<option value="2">25 % Discount</option>
				<option value="3">50 % Discount</option>
				<option value="4">75 % Discount</option>
			</select>
				
				</td> 
				</tr>
				</table>
				</div>
				<table cellpadding="1" cellspacing="1" border="0" style="margin-left:-268px;" >
				<tr>
				<td class="txt1">Refundable</td>
				<td>
				<div class="fields_checked">
<input type="radio" name="refundable" value="1" id="refundable_yes" <?php if($rs_limit->fields['refundable'] == 1 ){ ?> checked="checked" <?php } ?> ><span>Yes</span>
<input type="radio" name="refundable" value="0" id="refundable_no"  <?php if($rs_limit->fields['refundable'] == 0 ){ ?> checked="checked" <?php } ?> ><span> No</span>
				</div>
				
				
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Lastminute Deal</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="lastminute_deal" id="lastminute_deal_yes" <?php if($rs_limit->fields['lastminute_deal'] == 1 ){ ?> checked="checked" <?php } ?> value="1" onClick="jQuery('#lastmint_threshold1').show('fast');" ><span> Yes</span>
				<input type="radio" name="lastminute_deal"  id="lastminute_deal_no"  <?php if($rs_limit->fields['lastminute_deal'] == 0 ){ ?> checked="checked" <?php } ?> value="0" onClick="jQuery('#lastmint_threshold1').hide('fast');"><span> No</span>
				</div>
				
				</td> 
				</tr>
				</table>
				<div id="lastmint_threshold1" style="margin-left:-118px; <?php if($rs_limit->fields['lastminute_deal'] == 0 ){ ?> display:none; <?php } ?>">
				<table cellpadding="1" cellspacing="1" border="0" >	
				<tr>
				<td class="txt1">Lastminute Threshold</td>
				<td>
				<input type="text" name="lastminute_threshold" class="fields" id="lastminute_threshold" value="<?php echo $rs_limit->fields['lastminute_threshold']; ?>" />
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Lastminute Discount_rate</td>
				<td>
				<input type="text" name="lastminute_discount_rate" class="fields" id="lastminute_discount_rate" value="<?php echo $rs_limit->fields['lastminute_discount_rate']; ?>" />
				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Tariff" class="button" />
		</td>
		</tr>
		</table>
</div>
<table cellpadding="1" cellspacing="1" border="0" >
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="manage_tariff_calculation">
		<input type="hidden" name="act2" value="manage_tariff_calculation">
		<input type="hidden" name="id" value="<?php echo $rs_limit->fields['id']; ?>">
		<input type="hidden" name="request_page" value="tariff_management" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>

</table>
</table>

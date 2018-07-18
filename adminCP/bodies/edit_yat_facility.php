<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."yatfacility_management WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

?>



<div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Facility Name</td>
				<td>
				<input type="text" name="facility_name" class="fields"  id="facility_name" value="<?php echo $rs_limit->fields['facility_name']; ?>"  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Kategorija sadr&#382;aja</td>
				<td>
				
				<select name="property_fac_category" class="fields"   id="property_fac_category">
				<option value="0">Select Category<?php echo $rs_limit->fields['yat_fac_category'];  ?></option>
				<option <?php if($rs_limit->fields['yat_fac_category']==1){ echo 'selected="selected"';}  ?> value="1">General</option>
				<option <?php if($rs_limit->fields['yat_fac_category']==2){ echo 'selected="selected"';}  ?> value="2">Activities  </option>
				<option <?php if($rs_limit->fields['yat_fac_category']==3){ echo 'selected="selected"';}  ?> value="3">Services</option>		
			</select>
				
 				</td> 
				</tr>
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Update Facility" class="button" />
                </td>
                </tr>
</table>				
</div>

<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="manage_yat_facility">
		<input type="hidden" name="act2" value="manage_yat_facility">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="yat_facility_management" />
	
					</td>
				</tr>
                
</form> 

  </div>
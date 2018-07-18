<?php
if(isset($_GET['id'])){
$id=base64_decode($_GET['id']);
		$qry_content = "SELECT * FROM  ".$tblprefix."supplement_discount WHERE id =".$id;
		$rs_content = $db->Execute($qry_content);

}
$sql_property = "select * from ".$tblprefix."supplement_discount where parent_id = 0";
$rs_property = $db->Execute($sql_property);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Add Discount Supplement</td>
 	</tr>
	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	<tr>
			<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>					</td>
	</tr>
	<tr>
		<td>	
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>						</td>
					</tr>
        		    <tr>
						<td>Single Person Supplement</td>
						<td><input type="text" name="single_person_supplement" id="single_person_supplement" value="<?php echo $rs_limit->fields['single_person_supplement']; ?>" />						</td>
					</tr>        
	   				
					<tr>
						<td>Figure In Percentage</td>
						<td><input type="text" name="figure_in_percentage" id="figure_in_percentage" value="<?php echo $rs_limit->fields['figure_in_percentage']; ?>" />						</td>
					</tr> 
					
					 
					<tr>
						<td>Charge Rate Value</td>
						<td><input  type="file" name="charge_rate_value" id="charge_rate_value" value="<?php echo $rs_limit->fields['charge_rate_value']; ?>" /> </td>
							
					</tr> 
					 
					
               
	        <td>&nbsp;</td>
			<td>
			<input type="submit" name="submit" value="Add Discount Rate"  />			</td>
        </tr>
			
	
			<tr>
				<td>&nbsp;</td>
				<td>
                    <input type="hidden" name="mode" value="add">
					<input type="hidden" name="act" value="supplement_discount_managment">
					<input type="hidden" name="request_page" value="manage_supplement_discount" />
				</td>
			</tr>
		
		
		<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
		</tr>
		</table>
	</td>
	</tr>
	</form>
</table>
<?php
if(isset($_GET['id'])){
$id=base64_decode($_GET['id']);
		$qry_content = "SELECT * FROM  ".$tblprefix."supplier WHERE id =".$id;
		$rs_content = $db->Execute($qry_content);

}
$sql_property = "select * from ".$tblprefix."supplier where parent_id = 0";
$rs_property = $db->Execute($sql_property);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Add Supplier</td>
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
						<td>Supplier Name</td>
						<td><input type="text" name="first_name" id="first_name" value="<?php echo $rs_limit->fields['supplier_name']; ?>" />						</td>
					</tr>        
	   				
					<tr>
						<td>Supplier Details</td>
						<td><input type="text" name="last_name" id="last_name" value="<?php echo $rs_limit->fields['supplier_details']; ?>" />						</td>
					</tr> 
					
	        <td>&nbsp;</td>
			<td>
			<input type="submit" name="submit" value="Add Supplier"  />			</td>
        </tr>
			
	
			<tr>
				<td>&nbsp;</td>
				<td>
                    <input type="hidden" name="mode" value="add">
					<input type="hidden" name="act" value="supplier_management">
					<input type="hidden" name="act2" value="supplier_management">
					<input type="hidden" name="request_page" value="manage_supplier" />
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
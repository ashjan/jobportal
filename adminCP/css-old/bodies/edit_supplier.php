<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."carsupplier WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);


$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Supplier Management Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
						</td>
					</tr>
        		    <tr>
						
						<tr>
						  <td>Car Agency*</td>
						  <td><select name="agency" class="fields"   id="agency">
							  <option value="0">Select Car Agency</option>
							  <?php 
									while(!$rs_agency->EOF){
									?>
							  <option value="<?php echo $rs_agency->fields['agn_id'];?>"
									<?php if($rs_agency->fields['agn_id']== $rs_limit->fields['agency_id']){echo 'Selected="Selected"';}
									?>><?php echo $rs_agency->fields['agn_name'];?></option>
							  <?php
									$rs_agency->MoveNext();
									}
									?>
							</select>
						  </td>
						</tr>
						
						
						
						<tr>
						<td>Supplier Name*</td>
						<td><input type="text" name="supplier_name" class="fields" id="supplier_name" value="<?php echo $rs_limit->fields['supplier_name']; ?>" />
						</td>
					</tr> 
					 <tr>
						<td>Supplier Details*</td>
						<td><input type="text" name="supplier_details" class="fields" id="supplier_details" value="<?php echo $rs_limit->fields['supplier_details']; ?>" />
						</td>
					</tr>  
					
					
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update Supplier Information" class="button" />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_supplier" />
			<input type="hidden" name="act2" value="supplier_management" />
			<input type="hidden" name="request_page" value="manage_supplier" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


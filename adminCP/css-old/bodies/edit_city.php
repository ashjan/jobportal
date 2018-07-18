<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."city WHERE city_id=".$id;
$rs_limit = $db->Execute($qry_limit);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">City Management Section</td>
 	</tr>
	
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?> </td>
					</tr>
					
					
					  
					  
					  <tr>
							  <td>City*</td>
							  <td>
							  
				<input type="text" name="city_name" class="fields" id="city_name" value="<?php echo $rs_limit->fields['city_name']?>"  />
				</td><td> </td><td> </td>
					  </tr>
			  	 
					
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update City" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_city" />
			<input type="hidden" name="act2" value="city" />
			<input type="hidden" name="request_page" value="manage_city" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['city_id']); ?>" />
			<input type="hidden" name="mode" value="update">
			
		</form>
		</td>
	</tr>
</table>


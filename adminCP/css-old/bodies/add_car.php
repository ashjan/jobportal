<?php
if(isset($_GET['id'])){
$id=base64_decode($_GET['id']);
		$qry_content = "SELECT * FROM  ".$tblprefix."car WHERE id =".$id;
		$rs_content = $db->Execute($qry_content);

}
$sql_property = "select * from ".$tblprefix."car where parent_id = 0";
$rs_property = $db->Execute($sql_property);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Add Car</td>
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
						<td>Car Name</td>
						<td><input type="text" name="first_name" id="first_name" value="<?php echo $rs_limit->fields['first_name']; ?>" />						</td>
					</tr>        
	   				
					<tr>
						<td>Car type</td>
						<td><input type="text" name="last_name" id="last_name" value="<?php echo $rs_limit->fields['last_name']; ?>" />						</td>
					</tr> 
					
					<tr>
						<td>Remarks</td>
						<td><input type="text" name="	email_address" id="	email_address" value="<?php echo $rs_limit->fields['email_address']; ?>" />	</td>
					</tr> 
					<tr>
						<td>Car Picture</td>
						<td><input  type="file" name="car_picture" id="car_picture" value="<?php echo $rs_limit->fields['car_picture']; ?>" /> </td>
							
					</tr> 
					 
					
               
	        <td>&nbsp;</td>
			<td>
			<input type="submit" name="submit" value="Add Car"  />			</td>
        </tr>
			
	
			<tr>
				<td>&nbsp;</td>
				<td>
                    <input type="hidden" name="mode" value="add">
					<input type="hidden" name="act" value="car">
					<input type="hidden" name="act2" value="add_car">
					<input type="hidden" name="request_page" value="manage_car" />
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
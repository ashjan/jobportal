<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."property_manager WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Property Manager</td>
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
						<td>First Name</td>
						<td>
						<?php 
			
						if(!empty($_SESSION['first_name'])){ ?> 
						<input type="text" name="first_name" id="first_name" value="<?php echo $_SESSION['first_name']; ?>" />
						<?php }else{ ?>
						<input type="text" name="first_name" id="first_name" value="<?php echo $rs_limit->fields['first_name']; ?>" />
						
						<?php } ?>
						
						
						</td>
					</tr>        
	   				
					<tr>
						<td>Last Name</td>
						<td>
						
						<?php 
			if(!empty($_SESSION['last_name'])){ ?> 
						<input type="text" name="last_name" id="last_name" value="<?php echo $_SESSION['last_name']; ?>" />
						<?php }else{ ?>
						<input type="text" name="last_name" id="last_name" value="<?php echo $rs_limit->fields['last_name']; ?>" />
						
						<?php } ?>
						
						</td>
					</tr> 
					
					<tr>
						<td>Email Address</td>
						<td>
						
						<?php 
			if(!empty($_SESSION['email_address'])){ ?> 
						<input type="text" name="email_address" id="email_address" value="<?php echo $_SESSION['email_address']; ?>" />
						<?php }else{ ?>
						<input type="text" name="email_address" id="email_address" value="<?php echo $rs_limit->fields['email_address']; ?>" />
						
						<?php } ?>
						
						</td>
					</tr>
					<tr>
						<td>Business Email </td>
						<td>
						<?php
						if(!empty($_SESSION['business_email'])){ ?> 
						<input readonly="value" type="text" name="business_email" id="business_email" value="<?php echo $_SESSION['business_email']; ?>" />
						<?php }else{ ?>
						<input readonly="value" type="text" name="business_email" id="business_email" value="<?php echo $rs_limit->fields['business_email']; ?>" />
						
						<?php } ?>
						
					</td>
					</tr> 
					
					
					<tr> 
				<!--
				<tr>
						<td>Business Type</td>
						<td>
						<?php 
						//if(!empty($_SESSION['business_type'])){ ?> 
						<?php //$opt= $_SESSION['business_type']; ?>
						<select name="business_type" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="0">Select Business Type</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Apartment</option>
				<option value="2" <?php if($opt == 2){ ?> selected="selected" <?php } ?>>Villa</option>
				<option value="3" <?php if($opt == 3){ ?> selected="selected" <?php } ?>>Hotel Motel</option>
				<option value="4" <?php if($opt == 4){ ?> selected="selected" <?php } ?>>Room</option>
				<option value="5" <?php if($opt == 5){ ?> selected="selected" <?php } ?>>Guest House</option>
				</select>
				<?php //}else{ ?>
				
				<?php //$opt=$rs_limit->fields['business_type']; ?>
						<select name="business_type" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="0">Select Business Type</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Apartment</option>
				<option value="2" <?php if($opt == 2){ ?> selected="selected" <?php } ?>>Villa</option>
				<option value="3" <?php if($opt == 3){ ?> selected="selected" <?php } ?>>Hotel Motel</option>
				<option value="4" <?php if($opt == 4){ ?> selected="selected" <?php } ?>>Room</option>
				<option value="5" <?php if($opt == 5){ ?> selected="selected" <?php } ?>>Guest House</option>
				</select>
				<?php // } ?>
				</td>
				<tr>
						</td>
					</tr> 
				-->
					
					
					 
					
					<tr>
						<td>Town</td>
						<td>
						<?php
						if(!empty($_SESSION['town'])){ ?> 
						<input type="text" name="town" id="town" value="<?php echo $_SESSION['town']; ?>" />
						<?php }else{ ?>
						<input type="text" name="town" id="town" value="<?php echo $rs_limit->fields['town']; ?>" />
						
						<?php } ?>
						
						</td>
					</tr>
					<tr>
						<td>Phone Number</td>
						<td>
						<?php
						if(!empty($_SESSION['phone_number'])){ ?> 
						<input type="text" name="phone_number" id="phone_number" value="<?php echo $_SESSION['phone_number']; ?>" />
						<?php }else{ ?>
						<input type="text" name="phone_number" id="phone_number" value="<?php echo $rs_limit->fields['phone_number']; ?>" />
						
						<?php } ?>
						</td>
					</tr> 
                    <tr>
                    <td>Password</td>
					<td>
						
						<?php 
			if(!empty($_SESSION['password'])){ ?> 
						<input type="text" name="password" id="password" value="<?php echo $_SESSION['password']; ?>" />
						<?php }else{ ?>
						<input type="text" name="password" id="password" value="<?php  ?>" />
						
						<?php } ?>
						
						</td>
                        <td>
                        	Note: Leave password field blank, If you don't want to change password. 
                        </td>
                        </tr>

	        <td>&nbsp;
			</td>
			<td>
			<input type="submit" name="submit" value="Update Details"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_property_manager1" />
			<input type="hidden" name="request_page" value="property_manager" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


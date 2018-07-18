<?php
if(isset($_GET['id'])){
$id=base64_decode($_GET['id']);
		$qry_content = "SELECT * FROM  ".$tblprefix."property_manager WHERE id =".$id;
		$rs_content = $db->Execute($qry_content);

}
$sql_property = "select * from ".$tblprefix."property_manager where parent_id = 0";
$rs_property = $db->Execute($sql_property);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Add Property Manager</td>
 	</tr>
	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	<tr>
			<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>					</td>
	</tr>
	<tr>
	<td colspan="2">
	<div class="border_div_categories">				
    <table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				
				<td class="txt2">				</td>
				<td>&nbsp;				</td>
				</tr>
				
				<tr>
					<td class="txt1"> </td>
				    <td>	
				</td>
				</tr>		
  
	</table>		
	</div>	</td>
	</tr>
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>						</td>
					</tr>
        		    <tr>
						<td>First Name</td>
						<td><input type="text" name="first_name" id="first_name" value="<?php echo $rs_limit->fields['first_name']; ?>" />						</td>
					</tr>        
	   				
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="last_name" id="last_name" value="<?php echo $rs_limit->fields['last_name']; ?>" />						</td>
					</tr> 
					
					<tr>
						<td>Email Address</td>
						<td><input type="text" name="	email_address" id="	email_address" value="<?php echo $rs_limit->fields['email_address']; ?>" />	</td>
					</tr> 
					<tr>
						<td>Business Email</td>
						<td><input  type="text" name="business_email" id="business_email" value="<?php echo $rs_limit->fields['business_email']; ?>" /></td>
					</tr> 
					<tr>
						<td>Business Type</td>
						<td><input type="text" name="business_type" id="business_type" value="<?php echo $rs_limit->fields['business_type']; ?>" /></td>
					</tr> 
					
					<tr>
						<td>Password</td>
						<td><input type="text" name="password" id="password" value="<?php echo $rs_limit->fields['password']; ?>" /></td>
					</tr> 
					
               
	        <td>&nbsp;</td>
			<td>
			<input type="submit" name="submit" value="Add Property Manager"  />			</td>
        </tr>
		</table>
</div>
	
	
	
	<tr>
	<td>&nbsp;</td>
	<td>
                            	<?php 
									if(isset($_GET['id'])){
								?>    
                                        	
                                        <input type="hidden" name="mode" value="update">
                                        <input type="hidden" name="act" value="managepropertymanager">
										<input type="hidden" name="act2" value="add_property_manager.php">
                                        <input type="hidden" name="request_page" value="property_manager" />
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />								
                               	<?php 
									}else{
								?>
								
								<input type="hidden" name="mode" value="add">
                                        <input type="hidden" name="act" value="managepropertymanager">
										<input type="hidden" name="act2" value="add_property_manager.php">
                                        <input type="hidden" name="request_page" value="property_manager" />
                                 <?php
                                 }
								 ?>					</td>
				</tr>
		
		
		<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
		</tr>
	</table>
	</form>
		</td>
	</tr>
</table>
<?php
	
	
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$messageid = base64_decode($_GET['messageid']);

$query_sql = "SELECT * FROM ".$tblprefix."short_message_service WHERE id = '".$messageid ."' "; 
$rs_message = $db->Execute($query_sql);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
  	<tr><td id="heading">Edit Short Message &nbsp; [Uredi kratkih poruka]</td></tr>
  	<tr>
		<td>
	<form name="addnewsfrm" action="admin.php?act=short_message_service" method="post" onsubmit="return validate_editnewsletter()">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>				</td>
				</tr>
			 	<tr>
			   		<td>&nbsp;</td>
			   		<td colspan="2" class="required_txt">* Required Fields <br/>[Obavezna polja]</td>
	      		</tr>
				
                <tr>
					<td class="fieldheading">User ID :<br/>[Korisnik ID]</td>
					<td><input name="user_id" id="user_id" type="text" class="fields" value="<?php echo stripslashes($rs_message->fields['user_id'])?>" /> * 
					</td>
				</tr>
                
                <tr>
					<td class="fieldheading">Password :<br/>[lozinka]</td>
					<td><input name="password" id="password" type="text" class="fields" value="<?php echo stripslashes($rs_message->fields['password'])?>" /> * 
					</td>
				</tr>
                
                <tr>
					<td class="fieldheading">Api ID :<br/>[Api ID]</td>
					<td><input name="api_id" id="api_id" type="text" class="fields" value="<?php echo stripslashes($rs_message->fields['api_id'])?>" /> * 
					</td>
				</tr>
                
                
				<tr>
					<td class="fieldheading">API url :<br/>[API url]</td>
					<td><input name="api_url" id="api_url" type="text" class="fields" value="<?php echo stripslashes($rs_message->fields['api_url'])?>" /> * 
					</td>
				</tr>
				
                
				<tr>
					<td>Default Message:<br/>[Default Poruka]</td>
					<td>
						<textarea id="default_message" name="default_message" rows="10" cols="52" ><?php echo trim($rs_message->fields['default_message']);?></textarea>				
					</td>
				</tr>
                
                <tr>
					<td>Success Message:<br/>[Uspjeh Poruka]</td>
					<td>
						<textarea id="success_message" name="success_message" rows="10" cols="52"><?php echo trim($rs_message->fields['success_message']); ?></textarea>				
					</td>
				</tr>
                
                <tr>
					<td>Failure Message:<br/>[Neuspjeh Poruka]</td>
					<td>
						<textarea id="failure_message" name="failure_message" rows="10" cols="52"><?php echo trim($rs_message->fields['failure_message']); ?></textarea>				
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="updatemessageSbt" id="updatemessageSbt" value="Update &nbsp; [A&#382;uriraj]" class="button"/>
						<input type="hidden" name="act" value="short_message_service" />
						<input type="hidden" name="messageid" value="<?php echo $messageid;?>" />
						<input type="hidden" name="mode" value="send" />
						<input type="hidden" name="request_page" value="manage_short_message_service" />			 
					</td>
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


<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Add Group Name </td>
 	</tr>
 
	<tr>
  		<td><h3>&nbsp;</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managenewsletterfrm" action="admin.php" method="post" onSubmit="return validate_newsletter()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
				
				<tr>
					<td class="fieldheading">Newsletter Name :</td>
					<td><input name="newsletter_name" id="newsletter_name" type="text" class="fields" /> * 
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<textarea id="description" name="description" rows="25" cols="90">
							
						</textarea>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="letterSbt" id="letterSbt" value=" Add Newsletter " />
						<input type="hidden" name="act" value="manageletter">
						<input type="hidden" name="mode" value="send">
						<input type="hidden" name="request_page" value="newsletter_management" />	
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

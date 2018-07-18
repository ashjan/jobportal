<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$newsid = base64_decode($_GET['newsid']);

$query_newsletter = "SELECT * FROM ".$tblprefix."newsletter WHERE id = '".$newsid ."' "; 
$rs_newsletter = $db->Execute($query_newsletter);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
  	<tr><td id="heading">Edit Newsletter</td></tr>
  	<tr>
		<td>
	<form name="addnewsfrm" action="admin.php?act=manageletter" method="post" onsubmit="return validate_editnewsletter()">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>				</td>
				</tr>
			 	<tr>
			   		<td>&nbsp;</td>
			   		<td colspan="2" class="required_txt">* Required Fields</td>
	      		</tr>
				
				<tr>
					<td class="fieldheading">Newsletter Name :</td>
					<td><input name="newsletter_name" id="newsletter_name" type="text" class="fields" value="<?php echo stripslashes($rs_newsletter->fields['letter_name'])?>" /> * 
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
						<textarea id="description" name="description" rows="25" cols="83">
							<?php echo stripslashes($rs_newsletter->fields['letter_description'])?>
						</textarea>				
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" class="button" name="updateletterSbt" id="updateletterSbt" value="Update Newsletter  " />
						<input type="hidden" name="act" value="manageletter" />
						<input type="hidden" name="newsid" value="<?php echo $rs_newsletter->fields['id'];?>" />
						<input type="hidden" name="mode" value="send" />
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


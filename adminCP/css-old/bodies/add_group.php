<script>
function validation()
{
	if(document.managenewsletterfrm.group_name_des.value=='')
	{
		alert("Please Enter the Group Name");
		document.managenewsletterfrm.group_name_des.focus();
		return false;
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Add Group Name </td>
 	</tr>
 
	<tr>
  		<td><h3>&nbsp;</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managenewsletterfrm" action="admin.php" method="post" onSubmit="return validation()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
				
				<tr>
					<td class="fieldheading">Group Name :</td>
					<td><input name="group_name_des" id="group_name_des" type="text" class="fields" /> * 
					</td>
				</tr>
				<tr>
					<td valign="top">Subscribers</td>
					<td>
					 <?php 
					
					 
						/*$qry_newsletter = "SELECT sub_email FROM tbl_newletter_subscriber  where id IN ($send_newsletter)";
*/				     $qry_newsletter = "SELECT * FROM tbl_newletter_subscriber";
					 $res_newsletter = $db->Execute($qry_newsletter);
					 while(!$res_newsletter->EOF){
					?>
                    <input type="checkbox" value="<?php echo $res_newsletter->fields['id'];?>" name="subscriber_list[]" id="subscriber_list[]" /><?php echo $res_newsletter->fields['sub_email'];?><BR/>
                    <?php
					$res_newsletter->MoveNext();
					}
					 ?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="letterSbt" id="letterSbt" value=" Add Group" onclick="" />
						<input type="hidden" name="act" value="news_letter_group_by_name">
						<input type="hidden" name="mode" value="send">
						<input type="hidden" name="request_page" value="news_letter_group_by_name" />	
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

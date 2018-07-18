<script>
function validation()
{
	if(document.addnewsfrm.group_name_des.value=='')
	{
		alert("Please Enter the Group Name");
		document.addnewsfrm.group_name_des.focus();
		return false;
	}
}
</script>
<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
} 

$newsid = base64_decode($_GET['newsid']);

$query_newsletter = "SELECT * FROM ".$tblprefix."newsletter_groups WHERE id = '".$newsid ."' "; 
$rs_newsletter = $db->Execute($query_newsletter);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
  	<tr><td id="heading">Edit Group Name</td></tr>
  	<tr>
		<td>
	<form name="addnewsfrm" action="admin.php?act=news_letter_group_by_name" method="post" onsubmit="return validation()">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>				</td>
				</tr>
			 	<tr>
			   		<td>&nbsp;</td>
			   		<td colspan="2" class="required_txt">* Required Fields</td>
	      		</tr>
				
				<tr>
					<td class="fieldheading">Group Name :</td>
					<td><input name="group_name_des" id="group_name_des" type="text" class="fields" value="<?php echo stripslashes($rs_newsletter->fields['group_name_des'])?>" /> * 
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
                    <?php 
					
					    $send_newsletter = $rs_newsletter->fields['subscriber_list'];
						$exp_send_newsletter = explode(',', $send_newsletter);
						/*$qry_newsletter = "SELECT sub_email FROM tbl_newletter_subscriber  where id IN ($send_newsletter)";
*/				       $qry_newsletter = "SELECT * FROM tbl_newletter_subscriber";
						$res_newsletter = $db->Execute($qry_newsletter);
					    while(!$res_newsletter->EOF){
					?>
                    <input type="checkbox" value="<?php echo $res_newsletter->fields['id'];?>" name="subscriber_list[]" id="subscriber_list[]" <?php if(in_array($res_newsletter->fields['id'], $exp_send_newsletter)){?> checked="checked"<?php }?> /><?php echo $res_newsletter->fields['sub_email'];?><BR>
					
                     <?php
					$res_newsletter->MoveNext();
					 }?>
                    	
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="updategroupSbt" id="updategroupSbt" value="Update Group Name  " />
						<input type="hidden" name="act" value="news_letter_group_by_name" />
						<input type="hidden" name="newsid" value="<?php echo $rs_newsletter->fields['id'];?>" />
						<input type="hidden" name="mode" value="send" />
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


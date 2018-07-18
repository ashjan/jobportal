<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$refid = base64_decode($_GET['refid']);
$query_refers_id = "SELECT * FROM ".$tblprefix."refers_reward WHERE id =".$refid ; 
$rs_refer_reward = $db->Execute($query_refers_id);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
  	<tr><td id="heading">Edit Refers Reward </td></tr>
  	<tr><td>
    <table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt" align="right" style="text-align:right;">
		<tr>
		<td>
		<strong><a href="admin.php?act=managedealscategories" title=" Click here to go back to Category listing " > Go back to Refers Reward List </a></strong>
		</td>
		</tr>
	</table>
    </td>
    </tr>
    
    <tr>
		<td>
	<form name="editrefersrewardfrm" action="admin.php?act=managerefersreward" method="post" onsubmit="return validate_editrefersreward()">
			<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>				</td>
				</tr>
			 	<tr>
			   		<td>&nbsp;</td>
			   		<td colspan="2" class="required_txt">* Required Fields</td>
	      		</tr>
				
				<tr>
					<td class="fieldheading">Refers Reward Amount :</td>
					<td>
                    <input name="refferer_reward_percentage" id="refferer_reward_percentage" type="text" class="fields" value="<?php echo stripslashes($rs_refer_reward->fields['refferer_reward_percentage'])?>" /> * 
					</td>
				</tr>
             
                
				
		<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" name="updaterefersrewardSbt" id="updaterefersrewardSbt" value="Update Refers Reward" />
			<input type="hidden" name="act" value="managerefersreward" />
			<input type="hidden" name="refid" value="<?php echo base64_encode($rs_refer_reward->fields['id']);?>" />
			<input type="hidden" name="mode" value="send" />
			<input type="hidden" name="request_page" value="managerefersreward" />			 
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
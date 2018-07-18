<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."property_comments WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Comment Management Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>						</td>
					</tr>
        		    <tr>
						<td>Comment Status </td>
						<td><select name="status" class="dropfields">
						<option value="0" <?php if($rs_limit->fields['status']==0){?> selected="selected"<?php }?>>In Active</option>
						<option value="1" <?php if($rs_limit->fields['status']==1){?> selected="selected"<?php }?>>Active</option>
						</select>		</td>
					</tr> 
					 <tr>
						<td>Comment Type </td>
						<td><select name="comment_type" class="dropfields">
						<option value="0" <?php if($rs_limit->fields['comment_type']==0){?> selected="selected"<?php }?>>Negative</option>
						<option value="1" <?php if($rs_limit->fields['comment_type']==1){?> selected="selected"<?php }?>>Positive</option>
						</select>						</td>
					</tr>  
					
					<tr>
						<td>Comment </td>
						<td><textarea name="comments" id="comments" rows="10" cols="30"><?php echo stripslashes($rs_limit->fields['comment_description'])?></textarea>		</td>
					</tr>
					
					
               
	        <td>&nbsp;			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update Comment" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="comments_management" />
			<input type="hidden" name="request_page" value="comment_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."montenegro_letter_head WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

?>



<div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Latter Head Details</td>
				<td>
				<textarea name="letter_head_details" id="letter_head_details" cols="20" rows="5" class="smalltxtareas"><?php echo trim($rs_limit->fields['letter_head_details']); ?></textarea>
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Telephone</td>
				<td>
				<input type="text" name="letter_head_telephone" id="letter_head_telephone" class="fields" value="<?php echo $rs_limit->fields['letter_head_telephone']; ?>" />
 				</td> 
				</tr>
                
                
                
                <tr>
				<td class="txt1">Email</td>
				<td>
				<input type="text" name="letter_head_email" id="letter_head_email" class="fields" value="<?php echo $rs_limit->fields['letter_head_email']; ?>" />
 				</td> 
				</tr>
                
                <tr>
				<td class="txt1">Website</td>
				<td>
				<input type="text" name="letter_head_website" id="letter_head_website" class="fields" value="<?php echo $rs_limit->fields['letter_head_website']; ?>" />
 				</td> 
				</tr>
                
                <tr>
				<td class="txt1">Other Details</td>
				<td>
<textarea name="letter_head_other_details" id="letter_head_other_details" cols="20" rows="5" class="smalltxtareas"><?php echo trim($rs_limit->fields['letter_head_other_details']); ?></textarea>
 				</td> 
				</tr>
                
                
                
                
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:150px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Update Latter Head" class="button" />
                </td>
                </tr>
</table>				
</div>

<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_latter_head">
		<input type="hidden" name="act2" value="manage_letter_head">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="letter_head_management" />
	
					</td>
				</tr>
                
</form> 

  </div>
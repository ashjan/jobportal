<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM  ".$tblprefix."car_optional WHERE ser_id=".$id;
$rs_limit = $db->Execute($qry_limit);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Car Optional Extras</td>
 	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php?act=manage_property" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >		
<tr><td colspan="2">&nbsp;</td></tr>		
				<tr>
				<td class="txt2">Optional Extra: </td>
				<td>
				<input name="event_category_name" id="event_category_name" value="<?php echo $rs_limit->fields['free_service']?>" type="text" size="55"  maxlength="30" />*
				</td>
				</tr>
				<tr>
				<td class="txt1">Price</td>
				<td>
				<input type="text" name="price" class="fields"  id="price" value="<?php echo $rs_limit->fields['price']?>"  />
 				</td> 
				</tr>
</table>				
<table class="txt" cellpadding="1" cellspacing="1" border="0" >		
</table>
<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_car_opt_extra">
		<input type="hidden" name="act2" value="car_opt_extras">
		<input type="hidden" name="request_page" value="car_optionlxtra_management" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
 ?>
 </form>
		</td>
	</tr>
</table>
<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."map_options WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Map Options</td>
 	</tr>
 <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Site URL<br/>[Internet adresa]</td>
				<td>
				<input type="text" name="site_name" class="fields"  id="site_name" value="<?php echo $rs_limit->fields['site_name']?>"/>
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Map Key<br/>[Ključ mape]</td>
				<td>
				<input type="text" name="map_key" class="fields"  id="map_key" value="<?php echo $rs_limit->fields['map_key']?>"/>
 				</td> 
				</tr>	
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:105px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Map options" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_map_options">
		<input type="hidden" name="act2" value="map_options">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="map_options_management" />
					</td>
				</tr>
</form> 

		
		</td>
	</tr>
</table>


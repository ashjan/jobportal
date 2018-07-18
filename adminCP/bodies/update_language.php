<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."language WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);
 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Content Managment Section &nbsp; &nbsp;[Upravljanje sadr&#382;ajima]</td>
 	</tr>
 
	<tr>
  		<td><h3><?php if(empty($rs_limit->fields['Lan_name']))
						echo 'Add New ';
						echo stripslashes($rs_limit->fields['Lan_name'])?> Page</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
			
        <tr>
	        <td>
  			Language Name<br/>[Ime jezika]
		   	</td>
			<td><input type="text" name="lan_name" class="fields" value="<?php echo $rs_limit->fields['Lan_name']; ?>" /></td>
        </tr>                    
        <tr>
	        <td>
  			Language Code<br/>[Šifra jezika]
		   	</td>
			<td><input type="text" name="lan_code" class="fields" value="<?php echo $rs_limit->fields['Lan_code']; ?>" /></td>
        </tr>
		<tr>
	        <td>
  			Default Language<br/>[Glavni jezik]
			</td>
			<td>
			<select name="default_lang" class="fields">
				<option <?php if($rs_limit->fields['Lan_default']==1){ echo 'selected="selected"';} ?>  value="1">Yes</option>
				<option <?php if($rs_limit->fields['Lan_default']==0){ echo 'selected="selected"';} ?> value="0" selected="selected">No</option>
			</select>
			</td>
        </tr>
		<tr>
	        <td>
  			old Image<br/>[Glavni bed&#382;]
		   	</td>
			
			
				<td valign="middle"><img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['flag_full_path']; ?> &w=50&h=50&zc=1" border="0"  /> </td>
			
			
			
        </tr>
		<tr>
	        <td>
  			Change Image <br/>[Zahtjev bed&#382;]
		   	</td>
			<td>
			
			<input type="file" name="image" class="fields" />
			</td>
        </tr>
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
			<input style="margin:5px; width:220px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Language &nbsp;[uspješno jezicima]" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_language" />
			<input type="hidden" name="request_page" value="language" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['flag_name']; ?>" />
			<input type="hidden" name="id" value="<?php echo $rs_limit->fields['id']; ?>" />
			<input type="hidden" name="mode" value="update">

		</form>
		
		</td>
	</tr>
</table>


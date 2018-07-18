<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."slider_config WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Slider Configuration&nbsp;[Podešavanje slajdera]</td>
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
				<td class="txt1">Duration<br/>[Trajanje]</td>
				<td>
				<input type="text" name="duration" class="fields" id="duration" value="<?php echo $rs_limit->fields['duration']?>"  />
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Sliding Effect<br/>[Efekat]</td>
				<td>
				<input type="text" name="sliding_effect" class="fields" id="sliding_effect" value="<?php echo $rs_limit->fields['sliding_effect']?>"  />
				</td> 
				</tr>
				
					
				
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:287px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Slider configuration &nbsp;[A&#382;uriraj podešavanje]" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_slider_configuration">
		<input type="hidden" name="act2" value="slider_configuration">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="mng_slider_configuration" />
					</td>
				</tr>
</form> 

		
		</td>
	</tr>
</table>


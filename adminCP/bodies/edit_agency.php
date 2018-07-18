<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."agency WHERE agn_id=".$id;
$rs_limit = $db->Execute($qry_limit);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Agency Management Section</td>
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
						<td>Agency Name </td>
						<td><input type="text" name="agency_name" class="fields" id="agency_name" value="<?php echo $rs_limit->fields['agn_name']; ?>" />						</td>
					</tr> 
					<tr>
								<td>Country*</td>
								<td>
								<select name="country" id="country">
								<option value="Montenegro">Montenegro</option>
								</select>
								</td>
							</tr> 
							
							<tr>
								<td>City*</td>
								<td>
								<?php
									$qry_city = "SELECT * FROM ".$tblprefix."city" ;
									$rs_city = $db->Execute($qry_city);
								?>
								<select name="city" id="city">
								<option value="0">Select City</option>
								<?php
								while(!$rs_city->EOF)
								{
								?>
								<option value="<?php echo $rs_city->fields['city_id'];?>"
								<?php
								if($rs_city->fields['city_id'] == $rs_limit->fields['city'])
								{
									echo 'selected="selected"';
								}
								?>
								><?php echo $rs_city->fields['city_name'];?></option>
								<?php
									$rs_city->MoveNext();
								}
								?>
								</select>
								</td>
							</tr> 
							
							
							
							
							<tr>
								<td>Location*</td>
								<td>
								<?php
									$qry_loc = "SELECT * FROM ".$tblprefix."location" ;
									$rs_loc = $db->Execute($qry_loc);
								?>
								<select name="location" id="location">
								<option value="0">Select Location</option>
								<?php
								while(!$rs_loc->EOF)
								{
								?>
								<option value="<?php echo $rs_loc->fields['loc_id'];?>"
								<?php
								if($rs_loc->fields['loc_id'] == $rs_limit->fields['location'])
								{
									echo 'selected="selected"';
								}
								?>
								><?php echo $rs_loc->fields['loc_name'];?></option>
								<?php
									$rs_loc->MoveNext();
								}
								?>
								</select>
								</td>
							</tr>
							
							
					<tr>
						<td>Terms and Conditions </td>
						<td>
						<textarea name="terms" id="terms" class="smalltxtareas" rows="10" cols="25">
						<?php echo $rs_limit->fields['agncy_terms']; ?>
						</textarea>
						</td>
					</tr>
					
					
					<tr>
						<td>Agency Logo </td>
						<td><input type="file" name="car_picture" class="fields" id="car_picture" value="<?php echo $rs_limit->fields['car_picture']; ?>" />
						 
						 
						  <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."graphics/agency_logos/".$rs_limit->fields['agncy_logo'];?>&w=50&h=40&zc=1" border="0" />
						 
				<!--		<img src="<?php //echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php //echo $rs_limit->fields['image_full_path']; ?>&w=100&h=80&zc=1" border="0" />
						 
						 
						 <img src="<?php //MYSURL ?>graphics/car_upload/<?php //echo $rs_limit->fields['car_picture']; ?>" width="100" height="50" />	
-->						</td>
					</tr> 
					     
	   				
               
	        <td>&nbsp;			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update agency" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="agency" />
			<input type="hidden" name="request_page" value="manage_agency" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['agn_id']); ?>" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['agncy_logo']; ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


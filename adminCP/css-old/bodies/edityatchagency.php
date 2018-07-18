<?php
$id=base64_decode($_GET['id']);
 $qry_limit = "SELECT * FROM ".$tblprefix."yatchagency WHERE agn_id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 $qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Yatch Agency Management Section</td>
 	</tr>
 	
	<tr>
  		<td> </td>
	</tr>
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>						</td>
					</tr>
					
					<tr>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">			</td></tr>
		<?php
			}else{?>
			<tr>
					<td class="txt1">PM Name*</td>
					<td>
					<select name="first_name" class="fields" id="first_name">
				 	<option value="0">Select PM</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							if($rs_property_manag->fields['id'] == $rs_limit->fields['pm_id']){
							   $is_manager_selected = 'selected="selected"';
							}
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php echo $is_manager_selected; ?>><?php echo $rs_property_manag->fields['first_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr> 
			
			
			
		<?php } ?>
		<tr>
				
        		    <tr>
						<td>Agency Name </td>
						<td><input type="text" name="agency_name" class="fields" id="agency_name" value="<?php echo $rs_limit->fields['agn_name']; ?>" />						</td>
					</tr> 
					 
							<tr>
								<td>Country*</td>
								<td>
								<input type="text" name="country" id="country" value="<?php echo $rs_limit->fields['country']?>" class="fields" />
								</td>
							</tr> 
							<tr>
								<td>City*</td>
								<td>
								<?php
									$qry_city = "SELECT * FROM ".$tblprefix."city" ;
									$rs_city = $db->Execute($qry_city);
								?>
								<select name="city" id="city" class="fields">
								<?php
								while(!$rs_city->EOF)
								{
								?>
								<option value="<?php echo $rs_city->fields['city_id'];?>"
								<?php
								if($rs_city->fields['city_id'] == $rs_limit->fields['city'])
								{
									echo 'select="select"';
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
								<td>Address*</td>
								<td>
								<textarea name="address" id="address"><?php echo $rs_limit->fields['address']?></textarea>
								</td>
							</tr> 
							
							<tr>
								<td>Post code*</td>
								<td>
								<input type="text" name="postcode" id="postcode" value="<?php echo $rs_limit->fields['post_code']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Phone number/fax*</td>
								<td>
								<input type="text" name="phonefax" id="phonefax" value="<?php echo $rs_limit->fields['phone']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Phone mobile*</td>
								<td>
								<input type="text" name="mobile" id="mobile" value="<?php echo $rs_limit->fields['mobile_number']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>E-mail*</td>
								<td>
								<input type="text" name="email" id="email" value="<?php echo $rs_limit->fields['email']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Latitude*</td>
								<td>
								<input type="text" name="latitude" id="latitude" value="<?php echo $rs_limit->fields['latitude']?>" class="fields" />
								
								</td>
							</tr> 
							
							<tr>
								<td>Longitude*</td>
								<td>
								<input type="text" name="longitude" id="longitude" value="<?php echo $rs_limit->fields['longitude']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>No.of Yachts (Boats)*</td>
								<td>
								<input type="text" name="yatchnumbr" id="yatchnumbr" value="<?php echo $rs_limit->fields['number_of_yatch']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Contact language</td>
								<td>
								<input type="text" name="cntactlang" id="cntactlang" value="<?php echo $rs_limit->fields['contact_language']?>" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Local bank Account</td>
								<td>
								<input type="text" name="bankaccount" id="bankaccount" value="<?php echo $rs_limit->fields['local_bank_account']?>" class="fields" />
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
								<td>Description</td>
								<td>
								<textarea name="descagn" id="descagn"><?php echo $rs_limit->fields['agncy_description']; ?></textarea>
								</td>
							</tr> 
							
					
					<tr>
						<td>Agency Logo </td>
						<td><input type="file" name="car_picture" class="fields" id="car_picture" value="<?php echo $rs_limit->fields['car_picture']; ?>" />
						 
						 
						  <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."graphics/agency_logos/".$rs_limit->fields['agncy_logo'];?>&w=50&h=40&zc=1" border="0" />
						 
				<!--<img src="<?php //echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php //echo $rs_limit->fields['image_full_path']; ?>&w=100&h=80&zc=1" border="0" />
						 
						 
						 <img src="<?php //MYSURL ?>graphics/car_upload/<?php //echo $rs_limit->fields['car_picture']; ?>" width="100" height="50" />	
-->						</td>
					</tr> 
					
					<tr>
								<td>Agency Type*</td>
								<td>
							<input name="agntype" type="radio" class="field_div" 
							<?php
							if($rs_limit->fields['agncy_type']=='0')
							{
								echo 'checked="checked"';
							}
							?>
							 id="agntype" value="0" /> OFFLINE 
							<input name="agntype" type="radio" 
							 <?php
							if($rs_limit->fields['agncy_type']=='1')
							{
								echo 'checked="checked"';
							}
							?> 
							class="field_div" id="agntype" value="1" /> ONLINE
							</td>
							</tr>
					     
	   				
               
	        <td>&nbsp;			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update agency" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edityatchagency" />
			<input type="hidden" name="act2" value="yatchagency"/>
			<input type="hidden" name="request_page" value="manangeyatchagency" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['agn_id']); ?>" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['agncy_logo']; ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


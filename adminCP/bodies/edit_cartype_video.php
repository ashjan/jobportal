<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT amf.*,agn.agn_name,amf.status,yat.car_type FROM `tbl_type_mediafiles` as amf,`tbl_car` as yat,`tbl_agency` as agn WHERE amf.mf_id='".$id."' and amf.agncy_id=agn.agn_id  and amf.car_yatch_id=yat.id and amf.which_type='1' and amf.aflag='1'";
$rs_limit = $db->Execute($qry_limit);

$qry_property_manag = "SELECT
                    tbl_agency.agn_id,
					tbl_agency.agn_name
					FROM
					tbl_agency"; 
$rs_property_manag = $db->Execute($qry_property_manag); 



$qry_cars = "SELECT
                    tbl_car.id,
					tbl_car.car_type  
					FROM
					tbl_car WHERE tbl_car.agency='".$rs_limit->fields['agncy_id']."'"; 
									
$rs_cars = $db->Execute($qry_cars);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Car Video media Section</td>
 	</tr>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
<tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
					<td class="txt1" style="color:#FF0000;">All fields are Required.</td>
					<td>&nbsp;
									
					</td>
				</tr>
					
		
				<!--<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
					<select name="agency_id" class="fields" id="agency_id" onchange="get_carsupplier('supplierdiv',this.value, '<?php //echo MYSURL."ajaxresponse/get_carsuppliers.php"?>')">
					<option value="0">Select Agency</option>
					<?php //while(!$rs_property_manag->EOF){
                     ?>
		  			<option value="<?php //echo $rs_property_manag->fields['agn_id'];?>" 
					<?php
					/*if($rs_property_manag->fields['agn_id'] == $rs_limit->fields['agncy_id'])
					{
						echo 'selected="selected"';
					}*/
					?>><?php //echo $rs_property_manag->fields['agn_name'] ;?>
					</option>
	                <?php //$rs_property_manag->MoveNext();
					//} ?>	
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Car/Brand Type</td>
					<td>
					<div id="supplierdiv">
						<select name="supplier_id" class="fields" id="supplier_id">
							
					<?php //while(!$rs_supplier->EOF)
					//{
					?>
						<option value="<?php //echo $rs_supplier->fields['id'];?>" 
						<?php 
						/*if($rs_supplier->fields['id'] == $rs_limit->fields['supplier_id'])
						{
							echo 'selected="selected"';
						}*/
						?>><?php //echo $rs_supplier->fields['supplier_name'] ;?>
						</option>
	                <?php //$rs_supplier->MoveNext();
					//} ?>			
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Car Model</td>
					<td>
					<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							
					<?php //while(!$rs_cars->EOF)
					//{
					?>
						<option value="<?php //echo $rs_cars->fields['id'];?>" 
						<?php 
						/*if($rs_cars->fields['id'] == $rs_limit->fields['car_yatch_id'])
						{
							echo 'selected="selected"';
						}*/
						?>><?php //echo $rs_cars->fields['car_type'] ;?>
						</option>
	                <?php //$rs_cars->MoveNext();
					//} ?>
						</select>
					</div>
					
					</td>
				</tr>
				-->
				
				
			<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
					<select name="agency_id" class="fields" id="agency_id" onchange="get_car_type1('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type1.php"?>')">
					<option value="0">Select Agency</option>
					<?php while(!$rs_property_manag->EOF){
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['agn_id'];?>" 
					<?php
					if($rs_property_manag->fields['agn_id'] == $rs_limit->fields['agncy_id'])
					{
						echo 'selected="selected"';
					}
					?>><?php echo $rs_property_manag->fields['agn_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>	
						</select>
					</div>
					
					</td>
				</tr>
				
				
				<tr>
					<td class="txt1">Type</td>
					<td>
					<div id="get_car">
					<select name="car_id" class="fields" id="car_id">
							
					<?php while(!$rs_cars->EOF)
					{
					?>
						<option value="<?php echo $rs_cars->fields['id'];?>" 
						<?php 
						if($rs_cars->fields['id'] == $rs_limit->fields['car_yatch_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_cars->fields['car_type'] ;?>
						</option>
	                <?php $rs_cars->MoveNext();
					} ?>
						</select>
					</div>
					
					</td>
				</tr>	
			
		<tr>
        <td class="txt1">Video</td>
		<td><input type="file" name="video" class="fields" /></td>
		</tr>
		
		<tr><td class="txt1"></td><td><!--video div-->
                  <!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE -->
	
	<div id="mediaplayer_<?php echo $rs_limit->fields['mf_id']; ?>"></div>
	<script type="text/javascript" src="<?php echo MYSURL; ?>media/videos/jwplayer.js"></script>
	<script type="text/javascript">
		jwplayer("mediaplayer_<?php echo $rs_limit->fields['mf_id']; ?>").setup({
			flashplayer: "<?php echo MYSURL; ?>media/videos/player.swf",
			file: "<?php echo $rs_limit->fields['fileurl']; ?>",
			image: "<?php echo MYSURL; ?>media/videos/preview.jpg",
			width:150,
			height:100
		});
	</script>
	<!-- END OF THE PLAYER EMBEDDING --> 
               <!--video div End-->
			   
			   </td>
			   </tr>
		
		
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Video" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="mng_cartype_video">
		<input type="hidden" name="act2" value="edit_cartype_video">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['fileurl']; ?>" />
		<input type="hidden" name="request_page" value="mngcartypvideos" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


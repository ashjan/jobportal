<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT amf.*,agn.agn_name,amf.status,yat.car_type FROM `tbl_type_mediafiles` as amf,`tbl_car` as yat,`tbl_agency` as agn, `tbl_car_manager` as pm WHERE amf.mf_id='".$id."' and amf.agncy_id=agn.agn_id and amf.car_yatch_id=yat.id and  amf.which_type='1'";



$rs_limit = $db->Execute($qry_limit);


$qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
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
					tbl_car"; 
									
$rs_cars = $db->Execute($qry_cars);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Car Type Image Section</td>
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
					
						<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
					<select name="agency_id" class="fields" id="agency_id" onchange="get_car_type1('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type1.php"?>')">
					<option value="0">Select Agency</option>
					<?php while(!$rs_property_manag->EOF){
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['agn_id'];?>" 
					
					<?php if($rs_property_manag->fields['agn_id'] == $rs_limit->fields['agncy_id'])
					{
						echo 'selected="selected"';
					} //echo $is_cat_selected;  ?>><?php echo $rs_property_manag->fields['agn_name'] ;?>
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
        <td class="txt1">Image</td>
		<td><input type="file" name="image" class="fields" /></td><td><a href="<?php echo $rs_limit->fields['fileurl']; ?>">
						<img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['fileurl']; ?>&w=50&h=40&zc=1" border="0"></a></td>
		</tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Image" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="mng_cartype_images">
		<input type="hidden" name="act2" value="edit_cartype_images">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['fileurl']; ?>" />
		<input type="hidden" name="request_page" value="mngcartypimages" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


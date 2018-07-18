<?php
$id=base64_decode($_GET['id']);

$qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
 $qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);


 
$qry_limit = "SELECT mi.*,pm.id as pid,pm.first_name,pr.agn_id as prid,pr.agn_name  FROM `tbl_mediaimages` as mi INNER JOIN tbl_agency as pr ON pr.agn_id=mi.property_id INNER JOIN tbl_property_manager as pm ON pm.id=mi.pm_id where mi.id=".$id; 

$rs_limit = $db->Execute($qry_limit);

$qry_agncy = "SELECT
                    tbl_agency.agn_id,
					tbl_agency.agn_name 
					FROM
					tbl_agency WHERE tbl_agency.pm_id='".$rs_limit->fields['pm_id']."'"; 
					
$rs_agncy = $db->Execute($qry_agncy);

/*$qry_image = "SELECT * from ".$tblprefix."mediaimages where id=".$id; 
$rs_iamge = $db->Execute($qry_image);*/


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Image media Section</td>
 	</tr>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
	<tr>
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_caragency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_caragencyy_name.php"?>')">
				 	<option value="0">Select PM</option>
					<?php while(!$rs_property_manag->EOF)
					{
					?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php 
					if($rs_property_manag->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>><?php echo $rs_property_manag->fields['first_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
				<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
						<select name="agency_id" class="fields" id="agency_id">
							
							
					<?php while(!$rs_agncy->EOF)
					{
					?>
						<option value="<?php echo $rs_agncy->fields['agn_id'];?>" 
						<?php 
						if($rs_agncy->fields['agn_id'] == $rs_limit->fields['agncy_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_agncy->fields['agn_name'] ;?>
						</option>
	                <?php $rs_agncy->MoveNext();
					} ?>			
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
				<td class="txt1">Title</td>
		<td><input type="text" name="image_title" class="fields" value="<?php echo $rs_limit->fields['image_title']; ?>" /></td>
		</tr>
		
		
		<tr>
        	<td class="txt1">Image</td>
			<td>
			<input type="file" name="image" class="fields" />
			</td><td valign="middle"><a href="<?php echo $rs_limit->fields['image_full_path']; ?>">
						<img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['image_full_path']; ?>&w=50&h=40&zc=1" border="0"></a></td>
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
		<input type="hidden" name="act" value="editinventory">
		<input type="hidden" name="act2" value="editinventory">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['image_name']; ?>" />
		<input type="hidden" name="request_page" value="car_inventory_management" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT amf.*,pm.first_name,agn.agn_name,suplr.supplier_name,amf.status,yat.yatch_name FROM `tbl_agncy_mediafiles` as amf,`tbl_supplier` as suplr,`tbl_yatch` as yat,`tbl_yatchagency` as agn, `tbl_users` as pm WHERE amf.mf_id='".$id."' and amf.pm_id=pm.id and amf.agncy_id=agn.agn_id and amf.supplier_id=suplr.id and amf.car_yatch_id=yat.id and yat.supplier=suplr.id and amf.which_agency='0'";

$qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
 $qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					FROM
					tbl_users"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_limit = $db->Execute($qry_limit);

$qry_agncy = "SELECT
                    tbl_yatchagency.agn_id,
					tbl_yatchagency.agn_name 
					FROM
					tbl_yatchagency WHERE tbl_yatchagency.pm_id='".$rs_limit->fields['pm_id']."'"; 
					
$rs_agncy = $db->Execute($qry_agncy);

$qry_supplier = "SELECT
                    tbl_supplier.id,
					tbl_supplier.supplier_name  
					FROM
					tbl_supplier WHERE tbl_supplier.agency_id='".$rs_limit->fields['agncy_id']."'"; 					
$rs_supplier = $db->Execute($qry_supplier);

$qry_cars = "SELECT
                    tbl_yatch.id,
					tbl_yatch.yatch_name  
					FROM
					tbl_yatch WHERE tbl_yatch.supplier='".$rs_limit->fields['supplier_id']."'"; 
									
$rs_cars = $db->Execute($qry_cars);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Yatch Image media Section</td>
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
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
				 	<option value="">Select Yatch Manager</option>
					<?php while(!$rs_property_manag->EOF)
					{
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php 
					if($rs_property_manag->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_property_manag->fields['first_name'] ;?>
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
					<td class="txt1">Yatch/Brand Type</td>
					<td>
					<div id="supplierdiv">
						<select name="supplier_id" class="fields" id="supplier_id">
					<?php while(!$rs_supplier->EOF)
					{
					?>
						<option value="<?php echo $rs_supplier->fields['id'];?>" 
						<?php 
						if($rs_supplier->fields['id'] == $rs_limit->fields['supplier_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_supplier->fields['supplier_name'] ;?>
						</option>
	                <?php $rs_supplier->MoveNext();
					} ?>	
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Yatch Model</td>
					<td>
					<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							
							
					<?php while(!$rs_cars->EOF)
					{
					?>
						<option value="<?php echo $rs_cars->fields['id'];?>" 
						<?php 
						if($rs_cars->fields['id'] == $rs_limit->fields['car_yatch_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_cars->fields['yatch_name'] ;?>
						</option>
	                <?php $rs_cars->MoveNext();
					} ?>
						</select>
					</div>
					
					</td>
				</tr>
		
		
		<tr>
        	<td class="txt1">Image</td>
			<td>
			<input type="file" name="image" class="fields" />
			</td>
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
		<input type="hidden" name="act2" value="edityatchagencyimages">
		<input type="hidden" name="act" value="yatchagencyimages">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['fileurl']; ?>" />
		<input type="hidden" name="request_page" value="manageyatchimages" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


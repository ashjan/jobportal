<?php
$id=base64_decode($_GET['id']);
//pm id
  $qry_property_manag = "SELECT
                    tbl_yatchagency.agn_id,
					tbl_yatchagency.agn_name
					FROM
					tbl_yatchagency";   
$rs_property_manag = $db->Execute($qry_property_manag);

 $qry_agn = "SELECT
                    *					 
					FROM
					tbl_type_mediafiles WHERE mf_id=".$id;  
									
$rs_agn = $db->Execute($qry_agn);

$qry_cars = "SELECT
                    tbl_yatch.id,
					tbl_yatch.yatch_name  
					FROM
					tbl_yatch";  
									
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
					<td class="txt1" style="color:#FF0000;">All fields are Required.</td>
					<td>&nbsp;
									
					</td>
				</tr>
					
		<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
					
                    
                    <select name="agency_id" class="fields" id="agency_id" onchange="get_yatches('yatchdiv', this.value, '<?php echo MYSURL."ajaxresponse/get_yatchess.php"?>')">
                    
					<option value="0">Select Agency</option>
					<?php while(!$rs_property_manag->EOF){
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['agn_id'];?>" 
					<?php
					if($rs_property_manag->fields['agn_id'] == $rs_agn->fields['agncy_id'])
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
				
				
				
				<!--<tr>
					<td class="txt1">Supplier</td>
					<td>
					<div id="supplierdiv">
						<select name="supplier_id" class="fields" id="supplier_id">
							
					<?php //while(!$rs_supplier->EOF)
					//{
					?>
						<option value="<?php //echo $rs_supplier->fields['id'];?>" 
						<?php /*
						if($rs_supplier->fields['id'] == $rs_limit->fields['supplier_id'])
						{
							echo 'selected="selected"';
						}*/
						?>><?php //echo $rs_supplier->fields['supplier_name'] ;?>
						</option>
	                <?php /*$rs_supplier->MoveNext();
					} */?>
						</select>
					</div>
					
					</td>
				</tr>-->
				
				<tr>
					<td class="txt1">Yacht Type</td>
					<td>
					<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							<?php while(!$rs_cars->EOF)
					{
					?>
						<option value="<?php echo $rs_cars->fields['id'];?>" 
						<?php 
						if($rs_cars->fields['id'] ==  $rs_agn->fields['car_yatch_id'])
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
		<td><input type="file" name="image" class="fields" /></td><td></td>
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
		<input type="hidden" name="act" value="edit_yatchtype_images">
		<input type="hidden" name="act2" value="yatchtypesimages">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['fileurl']; ?>" />
		<input type="hidden" name="request_page" value="mngyatchtypimages" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT 
                   id,
				   region_name
                   FROM ".$tblprefix."property_regions WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Property Region</td>
 	</tr>
 
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Region Name</td>
				<td>
				<?php
				if(!empty($_SESSION['region_name'])){ ?>
				<input type="text" name="region_name" id="region_name" value="<?php echo $_SESSION['region_name']; ?>" />
						<?php }else{ ?>
						<input type="text" name="region_name" id="region_name" value="<?php echo $rs_limit->fields['region_name']; ?>" />
						
						<?php } ?>
				
 				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:180px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Region" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="editregion">
		<input type="hidden" name="act2" value="manage_region">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="region_management" />
					</td>
				</tr>
</form> 

		
		</td>
	</tr>
</table>


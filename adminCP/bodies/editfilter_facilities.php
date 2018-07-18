<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT 
                   id,
				   facilities_name
                   FROM ".$tblprefix."filter_facilities WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Filter Facility Section</td>
 	</tr>
 
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Filter Facilities Name</td>
				<td>
				<?php
				if(!empty($_SESSION[$facilities_name])){ ?>
				<input type="text" name="facilities_name" id="facilities_name" value="<?php echo $_SESSION['facilities_name']; ?>" />
						<?php }else{ ?>
						<input type="text" name="facilities_name" id="facilities_name" value="<?php echo $rs_limit->fields['facilities_name']; ?>" />
						
						<?php } ?>
				
 				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Filter Facilities Name" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="editfilter_facilities">
		<input type="hidden" name="act2" value="filter_facilities">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="filter_facilities_management" />
					</td>
				</tr>
</form> 

		
		</td>
	</tr>
</table>


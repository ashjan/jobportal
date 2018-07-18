<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT 
                   id,
				   price_rate
                   FROM ".$tblprefix."filter_price WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Filter Price</td>
 	</tr>
 
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Price 	Rate</td>
				<td>
				<?php
				if(!empty($_SESSION[$region_name])){ ?>
				<input type="text" name="price_rate" id="price_rate" value="<?php echo $_SESSION['price_rate']; ?>" />
						<?php }else{ ?>
						<input type="text" name="price_rate" id="price_rate" value="<?php echo $rs_limit->fields['price_rate']; ?>" />
						
						<?php } ?>
				
 				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Filter Price" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_filter_price">
		<input type="hidden" name="act2" value="filter_price">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="manage_filter_price" />
					</td>
				</tr>
</form> 

		
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);


$qry_limit = "SELECT * FROM  ".$tblprefix."car_categories WHERE id =".$id;
$rs_limit = $db->Execute($qry_limit);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Car Category</td>
 	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php?act=manage_property" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt2">Car Category Name: </td>
				<td>&nbsp;  </td>
				</tr>
				<tr>
				<td class="txt1">(English)</td>
				<td>
				<?php 
			if(!empty($_SESSION['car_category_name'])){ ?> 
				<input name="car_category_name" id="car_category_name" value="<?php echo $_SESSION['car_category_name']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	}else{ ?>
				
				<input name="car_category_name" id="car_category_name" value="<?php echo $rs_limit->fields['car_category_name']?>" type="text" size="55"  maxlength="30" />*
				<?php } ?>
				</td>
				</tr>
</table>				
<table class="txt" cellpadding="1" cellspacing="1" border="0" >
				
				
</table>


<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Category" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_car_categories">
		<input type="hidden" name="act2" value="manage_car_categories">
		<input type="hidden" name="request_page" value="car_categories_management" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
				
</form>
		
		</td>
	</tr>
</table>


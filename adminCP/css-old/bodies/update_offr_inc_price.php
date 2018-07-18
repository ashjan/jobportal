<?php
$id=base64_decode($_GET['id']);

/*$qry_limit = "SELECT
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_category.pm_id,
					".$tblprefix."property_category.id
					FROM
					".$tblprefix."property_manager
					Inner Join ".$tblprefix."property_category ON ".$tblprefix."property_category.pm_id = ".$tblprefix. "property_manager.id WHERE ".$tblprefix."property_category.id=".$id;*/
 $qry_limit = "SELECT * FROM  ".$tblprefix."offers_included_in_price WHERE ser_id=".$id;
$rs_limit = $db->Execute($qry_limit);
//Dropdown for parent 
/*$category_qry = "select * from ".$tblprefix."property_manager ";
$rs_category = $db->Execute($category_qry);*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Offers Included In Price</td>
 	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php?act=manage_property" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >		
<tr><td colspan="2">&nbsp;</td></tr>		
				<tr>
				<td class="txt2">Offers included in price: </td>
				<td>
				<?php 
			if(!empty($_SESSION['event_category_name']))
			{ ?> 
				<input name="event_category_name" id="event_category_name" value="<?php echo $_SESSION['event_category_name']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			}else{ ?>
				
				<input name="event_category_name" id="event_category_name" value="<?php echo $rs_limit->fields['free_service']?>" type="text" size="55"  maxlength="30" />*
				<?php } ?>
				</td>
				</tr>
</table>				
<table class="txt" cellpadding="1" cellspacing="1" border="0" >
				
				
</table>


<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_offr_inc_price">
		<input type="hidden" name="act2" value="offers_included_in_price">
		<input type="hidden" name="request_page" value="ofrs_inc_in_price_mange" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
 $_SESSION['event_category_name']='';
 ?> 				
</form>
		
		</td>
	</tr>
</table>



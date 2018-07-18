<?php
$id=base64_decode($_GET['id']);

/*$qry_limit = "SELECT
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name,
					".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_category.pm_id,
					".$tblprefix."property_category.id
					FROM
					".$tblprefix."users
					Inner Join ".$tblprefix."property_category ON ".$tblprefix."property_category.pm_id = ".$tblprefix. "users.id WHERE ".$tblprefix."property_category.id=".$id;*/
 $qry_limit = "SELECT * FROM  ".$tblprefix."property_free_services WHERE id=".$id;
 $rs_limit = $db->Execute($qry_limit);
//Dropdown for parent 
/*$category_qry = "select * from ".$tblprefix."users ";
$rs_category = $db->Execute($category_qry);*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Property Free Services for sunnymontenegro.com Customer[A&#382;uriraj "Free								     for SunnyMontenegro" program]</td>
 	</tr>
 	<tr>

<?php if ($_REQUEST['errmsg']) {?>
<td colspan="3" class="errmsg" align="center"><?php echo base64_decode($_REQUEST['errmsg']);?></td>
	
<?php }?>
</td>
</tr>	
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >		
	
				<tr>
				<td class="txt2">Service<br/>[Usluge]: </td>
				<td>
				<?php 
			if(!empty($_SESSION['event_category_name']))
			{ ?> 
				<input name="event_category_name" id="event_category_name" value="<?php echo $_SESSION['event_category_name']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			}else{ ?>
				
				<input name="event_category_name" id="event_category_name" value="<?php echo $rs_limit->fields['service_name']?>" type="text" size="55"  maxlength="30" />*
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
		<input type="hidden" name="act" value="update_ppt_freeservice1">
		<input type="hidden" name="act2" value="property_free_service">
		<input type="hidden" name="request_page" value="freeppt_management" />
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



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
$qry_limit = "SELECT * FROM  ".$tblprefix."yatch_category WHERE id =".$id;
$rs_limit = $db->Execute($qry_limit);
//Dropdown for parent 
/*$category_qry = "select * from ".$tblprefix."property_manager ";
$rs_category = $db->Execute($category_qry);*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Property Category</td>
 	</tr>
 	<tr>
                 <?php if(isset($_GET['errmsg'])){?>
                 <td colspan="2" align="center" class="errmsg"><?php echo base64_decode($_GET['errmsg'])?></td>
                 <?php }?>
                 </tr>			
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >	
                 
				<tr>
				<td class="txt2">Category Name: </td>
				<td>&nbsp;  </td>
				</tr>
				<tr>
				<td class="txt1">(English)</td>
				<td>
			<!--	<?php /*
			if(!empty($_SESSION['yatch_category_name'])){ */?> 
				<input name="property_category_name" id="yatch_category_name" value="<?php //echo $_SESSION['yatch_category_name']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	//}else{ ?>-->
				
				<input name="yatch_category_name" id="yatch_category_name" value="<?php echo $rs_limit->fields['yatch_category_name']?>" type="text" size="55"  maxlength="30" />*
				<?php //} ?>
				</td>
				</tr>
</table>				
<table class="txt" cellpadding="1" cellspacing="1" border="0" >
				
				
</table>


<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Yatch Category" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edityatchcategory">
		<input type="hidden" name="act2" value="yatchcategory">
		<input type="hidden" name="request_page" value="yatchcategorymanagement" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
 //session_unset($_SESSION['property_category_name']); 
 ?> 				
</form>
		
		</td>
	</tr>
</table>


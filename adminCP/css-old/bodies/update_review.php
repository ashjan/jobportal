<?php
$id=base64_decode($_GET['id']);

$qry_select = "SELECT * FROM  ".$tblprefix."reviews WHERE id =".$id;
$rs_select = $db->Execute($qry_select);

?>
<table class="txt" cellpadding="1" cellspacing="1" border="0" >

				
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Review</td>
 	</tr>
 	<?php if(isset($_GET['okmsg'])){
$class = 'okmsg';
$msg = base64_decode($_GET['okmsg']);
}else {
	$class ='errmsg';
	$msg = base64_decode($_GET['errmsg']);
}
if(isset($_GET['errmsg']) OR isset($_GET['okmsg'])){
?>				
<tr>
<td colspan="3" align="center" class="<?php echo $class?>"><?php echo $msg;?></td>
</tr>
<?php }?>	
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >				
			
<tr>
				<td class="txt2">Review Name: </td>
				<td>&nbsp;  </td>
				</tr>
				<tr>
				<td class="txt1"></td>
				<td>
				<?php 
			if(!empty($_SESSION['review_name'])){ ?> 
				<input name="review_name" id="review_name" value="<?php echo $_SESSION['review_name']; ?>" type="text" size="55"  maxlength="100" />*
			<?php	}else{ ?>
				
				<input name="review_name" id="review_name" value="<?php echo $rs_select->fields['review_name']?>" type="text" size="55"  maxlength="100" />*
				<?php } ?>
				</td>
				</tr>
</table>				



<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Review" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_review">
		<input type="hidden" name="act2" value="manage_reviews">
		<input type="hidden" name="request_page" value="review_management" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
 $_SESSION['review_name']='';
 ?> 				
</form>
		
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);

$qry_select = "SELECT * FROM  ".$tblprefix."criteria WHERE id =".$id;
$rs_select = $db->Execute($qry_select);

?>
<table class="txt" cellpadding="1" cellspacing="1" border="0" >

				
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Criteria</td>
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
				<td class="txt2">Criteria Name: </td>
				<td>&nbsp;  </td>
				</tr>
				<tr>
				<td class="txt1"></td>
				<td>
				<?php 
			if(!empty($_SESSION['criteria_name'])){ ?> 
				<input name="criteria_name" id="criteria_name" value="<?php echo $_SESSION['criteria_name']; ?>" type="text" size="55"  maxlength="100" />*
			<?php	}else{ ?>
				
				<input name="criteria_name" id="criteria_name" value="<?php echo $rs_select->fields['criteria_name']?>" type="text" size="55"  maxlength="100" />*
				<?php } ?>
				</td>
				</tr>
</table>				



<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Criteria" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_criteria">
		<input type="hidden" name="act2" value="manage_criteria">
		<input type="hidden" name="request_page" value="criteria_management" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
 $_SESSION['criteria_name']='';
 ?> 				
</form>
		
		</td>
	</tr>
</table>


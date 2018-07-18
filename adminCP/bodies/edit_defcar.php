<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT 
                   id,
				   default_commission_rate
                   FROM ".$tblprefix."cardef_commission WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Car Default Commission</td>
 	</tr>
 <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Default Commission</td>
				<td>
				<?php 
			if(!empty($_SESSION['default_commission_rate'])){ ?> 
				<input name="default_commission_rate" id="default_commission_rate" value="<?php echo $_SESSION['default_commission_rate']; ?>" type="text" size="45"  maxlength="30" /><?php echo "%"; ?>
			<?php	}else{ ?>
				
				<input type="text" name="default_commission_rate" class="fields" id="default_commission_rate" value="<?php echo $rs_limit->fields['default_commission_rate']?>"  /><?php echo "%"; ?>
				<?php } ?>
				
				
 				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:105px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Commission" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_defcar">
		<input type="hidden" name="act2" value="cardefault_commission">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="default_commission_car" />
					</td>
				</tr>
				<?php $_SESSION['default_commission_rate']=''; ?>
</form> 

		
		</td>
	</tr>
</table>


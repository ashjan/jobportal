<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT 
                   id,
				   invoice_defcharg 
                   FROM ".$tblprefix."invoicedef_charge WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Invoice Charges</td>
 	</tr>
 <tr>
    	<td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
    </tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Default Charge<br/>[Osnovno zadu&#382;enje]</td>
				<td>
				<?php 
			if(!empty($_SESSION['default_commission_rate'])){ ?> 
				<input name="default_commission_rate" id="default_commission_rate" value="<?php echo $_SESSION['default_commission_rate']; ?>" type="text" size="45"  maxlength="30" /><?php echo "%"; ?>
			<?php	}else{ ?>
				
				<input type="text" name="default_commission_rate" class="fields" id="default_commission_rate" value="<?php echo $rs_limit->fields['invoice_defcharg']?>"  />�
				<?php } ?>
				
				
 				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update &nbsp;[A&#382;uriraj]" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="updateinvchrg">
		<input type="hidden" name="act" value="edit_invoicecharge">
		<input type="hidden" name="act2" value="default_invchrges">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="default_commission_management" />
					</td>
				</tr>
				<?php $_SESSION['default_commission_rate']=''; ?>
</form> 

		
		</td>
	</tr>
</table>


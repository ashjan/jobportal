<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."supplement_discount WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Supplement Discount Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	
		<td>
				
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
						</td>
					</tr>
        		    <tr>
						<td>Single Person Supplement </td>
							<td>									
					<?php $single_person_supplement=$rs_limit->fields['single_person_supplement']; ?>
					 <input type="radio" name="single_person_supplement" <?php if($single_person_supplement==1){echo 'checked="checked"';} ?>    id="single_person_supplement_on" value="1"/>Yes
							<input type="radio" name="single_person_supplement" <?php if($single_person_supplement==0){echo 'checked="checked"';} ?>  id="single_person_supplement_off"value="0"/>No  							
							
					</tr> 
					 <tr>
						<td>Figure In Percentage</td>
						
									
						
						<td>
						<?php   $figure_in_percentage=$rs_limit->fields['figure_in_percentage']; ?>
						 <input type="radio" name="figure_in_percentage" <?php if($figure_in_percentage==1){echo 'checked="checked"';} ?>   id="figure_in_percentage_on" value="1"/>Yes
							<input type="radio" name="figure_in_percentage" <?php if($figure_in_percentage==0){echo 'checked="checked"';} ?>    id="figure_in_percentage_off" value="0" />No  							
						</td>
						
					</tr>  
					
					
					</tr>
					
					<tr>
						<td>Charge Rate Value</td>
						<td><input type="text" name="charge_rate_value" class="fields" id="charge_rate_value" value="<?php echo $rs_limit->fields['charge_rate_value']; ?>" />%
						</td>
					</tr> 
					     
	   				
               
	        <td>&nbsp;
			</td>
			<td><input type="submit" name="submit" value="Edit Discount Rate"  /></td>
        </tr>
		</table>
			<input type="hidden" name="act" value="supplement_discount_managment" />
			<input type="hidden" name="request_page" value="manage_supplement_discount" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


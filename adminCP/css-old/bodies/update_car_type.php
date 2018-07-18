<?php
 $id=base64_decode($_GET['id']);
$qry_cat= "SELECT car_category_name,id FROM ".$tblprefix."car_categories"; 
$rs_cat= $db->Execute($qry_cat);

 $qry_limit = "SELECT * FROM  ".$tblprefix."car_types WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

$qry_room = "SELECT agn_name,agn_id from ".$tblprefix."agency";  
$rs_car = $db->Execute($qry_room);


?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Car Types</td>
 	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php?act=manage_property" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >		
<tr><td colspan="2">&nbsp;</td></tr>
	
				
				
				
				<tr>
				<td class="txt2">Car Agency</td>
				<td>
			
		<select name="car_agency" class="fields" id="car_agency" onchange="">
				 	<option value="0">Select Car Agency</option>
					<?php
					$rs_car->MoveFirst();
					while(!$rs_car->EOF){		
								?>
		  			<option value="<?php echo $rs_car->fields['agn_id'];?>" <?php if($rs_car->fields['agn_id']== $rs_limit->fields['car_agency']){ echo 'selected="selected"'; } ?> ><?php echo $rs_car->fields['agn_name'];  ?></option>
					<?php
					$rs_car->MoveNext();
					}
					?>			
					</select>					
					
	
		<!--		<input type="text" name="car_types" class="fields"  id="car_types" value=""  />-->
 				</td> 	
				</tr>				
				<tr>
				<td class="txt2">Car type</td>
				<td>
				<?php 
			if(!empty($_SESSION['post']['car_types']))
			{ ?> 
				<input name="car_types" id="car_types" value="<?php echo $_SESSION['post']['car_types']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			}else{ ?>
				
				<input name="car_types" id="car_types" value="<?php echo $rs_limit->fields['car_types']?>" type="text" size="55"  maxlength="30" />*
				<?php } ?> 
				
				
								
				
				</td>
				</tr>
				
				<tr>
				<td class="txt2">Car Category</td>
				<td>
			<!--	<?php 
			//if(!empty($_SESSION['post']['category']))
			//{ ?> 
				<input name="category" id="category" value="<?php //echo $_SESSION['post']['category']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			//}else{ ?>
				
				<input name="category" id="category" value="<?php //echo $rs_limit->fields['category']?>" type="text" size="55"  maxlength="30" />*
				
				
				<?php //} ?>	-->
				
					<select name="category" id="category"  class="dropfields"  onchange="">
				<option value="0">Select  Car category</option>
	  <?php while(!$rs_cat->EOF){ ?>
		<option value="<?php echo $rs_cat->fields['id'];?>" 
		<?php if($rs_cat->fields['id'] == $rs_limit->fields['category']){ echo 'selected="selected"'; } ?> > <?php echo $rs_cat->fields['car_category_name'];?>
		</option>
	    <?php $rs_cat->MoveNext();
		} ?>			
	</select>
				
			
				
				
				
				
				</td>
				</tr>
				
				
				<tr>
				<td class="txt2">Produced</td>
				<td>
				<?php 
			if(!empty($_SESSION['post']['produced']))
			{ ?> 
				<input name="produced" id="produced" value="<?php echo $_SESSION['post']['produced']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			}else{ ?>
				
				<input name="produced" id="produced" value="<?php echo $rs_limit->fields['produced']?>" type="text" size="55"  maxlength="30" />*
				<?php } ?>
				</td>
				</tr>
				
				
				
				<tr>
				<td class="txt2">Car Doors</td>
				<td>
				<?php 
			if(!empty($_SESSION['post']['doors']))
			{ ?> 
				<input name="doors" id="doors" value="<?php echo $_SESSION['post']['doors']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			}else{ ?>
				
				<input name="doors" id="doors" value="<?php echo $rs_limit->fields['doors']?>" type="text" size="55"  maxlength="30" />*
				<?php } ?>
				</td>
				</tr>
				
				
				
				<tr>
				<td class="txt2">Passengers</td>
				<td>
				<?php 
			if(!empty($_SESSION['post']['passengers']))
			{ ?> 
				<input name="passengers" id="passengers" value="<?php echo $_SESSION['post']['passengers']; ?>" type="text" size="55"  maxlength="30" />*
			<?php	
			}else{ ?>
				
				<input name="passengers" id="passengers" value="<?php echo $rs_limit->fields['passengers']?>" type="text" size="55"  maxlength="30" />*
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
		<input type="hidden" name="act" value="update_car_type">
		<input type="hidden" name="act2" value="car_types">
		<input type="hidden" name="request_page" value="car_types_management" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
 $_SESSION['post']='';
 ?> 				
</form>
		
		</td>
	</tr>
</table>



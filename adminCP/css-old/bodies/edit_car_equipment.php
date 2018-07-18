<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."car_equipment WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

///   List down all cars 

$qry_car = "SELECT * FROM ".$tblprefix."car" ; 
$rs_car = $db->Execute($qry_car);



$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);

///   List down all suppliers

$qry_carsupplier = "SELECT * FROM ".$tblprefix."carsupplier" ;
$rs_carsupplier = $db->Execute($qry_carsupplier);

/*echo '<pre>';
print_r($_SESSION['car_price']);
die;*/

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."property_manager";  
$rs_pm = $db->Execute($qry_pm);





?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Car Equipment Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
						</td>
					</tr>
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
          
			
			
			<tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
			
			<option value="0">Select Car Agency</option>	
	<?php while(!$rs_agency->EOF){
				
				$is_cat_selected = '';
				if($rs_agency->fields['agn_id']==$rs_limit->fields['agency']){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_agency->fields['agn_id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_agency->fields['agn_name'] ;?></option>
	<?php $rs_agency->MoveNext();
	}
	
?>
</select>
			
		</td>
			</tr> 	
			
			
			
		<?php	}else{?>
		
						<tr>
		 	<td class="txt1">Property Manager</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_car_agency('get_agency', this.value, '<?php echo MYSURL."ajaxresponse/get_car_agency.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){
				echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>	
			</td><td> </td><td> </td>
			</tr> 		
		
			<tr>
		 		<td class="txt1">Car Agency*</td>
				<td>
			<div id="get_agency">
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
				<?php $rs_agency->Movefirst(); ?>
				<?php while(!$rs_agency->EOF){ ?>
				<option value="<?php echo $rs_agency->fields['agn_id']; ?>"
  				<?php if($rs_agency->fields['agn_id']==$rs_limit->fields['agency']){
				echo 'selected="selected"';
				} ?>>
				<?php echo $rs_agency->fields['agn_name'];?></option>				
				<?php
				$rs_agency->MoveNext();
				}
				?>
			</select>
			
			</div>
			
					</td>
			</tr> 
		<?php
		}?>
		<tr>
			        <td class="txt1">
  			
			Supplier Name
		   			</td>
					<td>
		<div id="get_supplier"> 	
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type.php"?>')">
				<?php $rs_carsupplier->Movefirst(); ?>
				<?php while(!$rs_carsupplier->EOF){ ?>
				<option value="<?php echo $rs_carsupplier->fields['id']; ?>"
  				<?php if($rs_carsupplier->fields['id']==$rs_limit->fields['supplier_id']){
				echo 'selected="selected"';
				} ?>>
				<?php echo $rs_carsupplier->fields['supplier_name'];?></option>				
				<?php
				$rs_carsupplier->MoveNext();
				}
				?>
		</select>
		</div>	
						</td>
        </tr>
		<tr>
						<td>Car Type </td>
						<td>
			<div id="get_car">
			<select name="car_id" class="fields"   id="car_id">
				<?php $rs_car->Movefirst(); ?>
				<?php while(!$rs_car->EOF){ ?>
				<option value="<?php echo $rs_car->fields['id']; ?>"
  				<?php if($rs_car->fields['id']==$rs_limit->fields['car_id']){
				echo 'selected="selected"';
				} ?>>
				<?php echo $rs_car->fields['car_type'];?></option>				
				<?php
				$rs_car->MoveNext();
				}
				?>
			</select>		
			</div>
			
					</td>
					</tr> 
				<tr>			
				<td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;" >Equipments Names</td>
			<?php $explode_values=explode(',',$rs_limit->fields['equipments']);

			?>
			<td class="txt">
	<input type="checkbox" name="equipments[]" value="0" id="equipments" onclick="return is_checked();" <?php //if($_SESSION['add_sees']['dont_accept_credit_card']==0){ echo 'checked="checked"';} 
	
	if(in_array(0,$explode_values)){
	?> checked="checked"<?php }?>/>Don't Have any Equipment<br/>
	
	<div id="equipments" style="display:block;">
	<input type="checkbox" name="equipments[]" value="1" id="equipments" <?php 
	if(in_array(1,$explode_values)){
	?> checked="checked"<?php }?>/>Air condition <br/> 
	
	<input type="checkbox" name="equipments[]" value="2" id="equipments" <?php 
	if(in_array(2,$explode_values)){
	?> checked="checked"<?php }?> />Manual<br/> 	
		 
	<input type="checkbox" name="equipments[]" value="3" id="equipments" <?php 
	if(in_array(3,$explode_values)){
	?> checked="checked"<?php }?> />Automatic<br/> 
			 
	<input type="checkbox" name="equipments[]" value="4" id="equipments" <?php 
	if(in_array(4,$explode_values)){
	?> checked="checked"<?php }?> >Radio/cd<br/> 
					 
	<input type="checkbox" name="equipments[]" value="5" id="equipments" <?php if(in_array(4,$explode_values)){
	?> checked="checked"<?php }?> />ABS<br/>
	
	<input type="checkbox" name="equipments[]" value="6" id="equipments" <?php if(in_array(5,$explode_values)){
	?> checked="checked"<?php }?>/>Servo steering-wheel<br/> 		
	</div>
		    </td>
		</tr>
				
				
			<!--	<td class="txt">
				<input type="checkbox" name="equipments[]" value="1" id="equipments"  <?php //if($_SESSION['add_sees']['equipments']==1){ echo 'checked="checked"';} ?>/>Air condition <br/>
				<input type="checkbox" name="equipments[]" value="2" id="equipments"  <?php //if($_SESSION['add_sees']['equipments']==2){ echo 'checked="checked"';} ?>/>Manual <br/>
				<input type="checkbox" name="equipments[]" value="3" id="equipments"  <?php //if($_SESSION['add_sees']['equipments']==3){ echo 'checked="checked"';} ?>/>Automatic<br/>
				<input type="checkbox" name="equipments[]" value="4" id="equipments"  <?php //if($_SESSION['add_sees']['equipments']==4){ echo 'checked="checked"';} ?>/>Radio/cd<br/>
				<input type="checkbox" name="equipments[]" value="5" id="equipments"  <?php //if($_SESSION['add_sees']['equipments']==5){ echo 'checked="checked"';} ?>/>ABS <br/>
				<input type="checkbox" name="equipments[]" value="6" id="equipments"  <?php //if($_SESSION['add_sees']['equipments']==6){ echo 'checked="checked"';} ?>/>Servo steering-wheel<br/></td></tr>-->
	        
	   				
               
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update Equipment" class="button" />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_car_equipment" />
			<input type="hidden" name="act2" value="manage_car_equipment" />
			<input type="hidden" name="request_page" value="management_car_equipment" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


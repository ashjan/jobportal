<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."car_doors WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);


///   List down all cars 

$qry_car = "SELECT * FROM ".$tblprefix."car" ;


$rs_car = $db->Execute($qry_car);
$count_car =  $rs_car->RecordCount();
$totalCars = $count_car;


///   List down all suppliers

$qry_supplier = "SELECT * FROM ".$tblprefix."supplier" ;


$rs_supplier = $db->Execute($qry_supplier);
$count_supplier =  $rs_supplier->RecordCount();
$totalSuppliers = $count_supplier;

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
        		    
					
					<tr>
						<td>No of Doors/Passengers </td>
						<td><input type="text" name="equipment_name" class="fields" id="equipment_name" value="<?php echo $rs_limit->fields['number_doors']; ?>" />
						</td>
					</tr>
					
				
						
				<tr>
				<td class="txt1">Supplier Name</td>
				<td>
				<select name="supplier_id" class="fields" id="supplier_id" >
				<option value="0" > Select Supplier Name</option>
                
                <?php 
   	while(!$rs_supplier->EOF){?>
	<option value="<?php echo $rs_supplier->fields['id'];?>" <?php if($rs_supplier->fields['id']==$rs_limit->fields['supplier_id']){echo 'selected="selected"';} ?>><?php echo $rs_supplier->fields['supplier_name']; ?></option>
	<?php $rs_supplier->MoveNext();
	}?>
                
				</select>
				
 				</td> 
				</tr>
					
					
				<tr>
				<td class="txt1">Car Name</td>
				<td>
				<select name="car_id" class="fields" id="car_id" >
				<option value="0" > Select Car Name</option>
               
                 <?php 
   	while(!$rs_car->EOF){?>
	<option value="<?php echo $rs_car->fields['id'];?>" <?php if($rs_car->fields['id']==$rs_limit->fields['car_id']){echo 'selected="selected"';} ?>><?php echo $rs_car->fields['car_type']; ?></option>
	<?php $rs_car->MoveNext();
	}?>
                
     
				</select>
				
 				</td> 
				</tr>
				
		
					
					        
	   				
               
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update Equipment" class="button" />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="manage_car_doors" />
			<input type="hidden" name="request_page" value="management_car_doors" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


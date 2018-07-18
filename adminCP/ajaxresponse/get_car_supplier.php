<?php
include('root.php');
include($root.'include/file_include.php');
$agn_id=$_GET['agn_id'];
//   List down all Agencies
 $qry_supplier = "SELECT * FROM ".$tblprefix."carsupplier WHERE agency_id=".$agn_id;
 $rs_supplier = $db->Execute($qry_supplier);
 $count_supplier =  $rs_supplier->RecordCount();
 $totalsupplier = $count_supplier;
?>
<div id="get_supplier"> 	                                                  
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value,'<?php echo $agn_id; ?>', '<?php echo MYSURL."ajaxresponse/get_car_type.php"?>')">
<?php
if($totalsupplier<=0){?>
<option value="0">Select Car Supplier</option>
<?php
}else{?>
		 <option value="0">Select Car Supplier</option>
		 <?php  while(!$rs_supplier->EOF){?>
         <option value="<?php  echo $rs_supplier->fields['id']; ?>" 
         <?php  if($rs_supplier->fields['id']==$sup_id){ echo 'selected="selected"';}?>>
	     <?php  echo  $rs_supplier->fields['supplier_name']; ?></option>
	     <?php  $rs_supplier->MoveNext();
	     }  
		 }
		 ?>	
		 </select> 
		 </div>	






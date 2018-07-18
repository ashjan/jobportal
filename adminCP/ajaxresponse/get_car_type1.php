<?php
include('root.php');
include($root.'include/file_include.php');
 $agn_id=$_GET['agn_id']; 
//   List down all Agencies
 $qry_car = "SELECT * FROM ".$tblprefix."car WHERE agency=".$agn_id;
 $rs_car = $db->Execute($qry_car);
 $count_car =  $rs_car->RecordCount();
 $totalcar = $count_car; 
?>

<div id="get_car">
<select name="car_id" class="fields"   id="car_id" >
<?php
if($totalcar <= 0){?>
<option value="0">Select Car type</option>
<?php
}else{?>
	   <option value="0">Select Car Type</option>
		<?php  while(!$rs_car->EOF){?>
       <option value="<?php  echo $rs_car->fields['id']; ?>" 
       <?php  if($rs_car->fields['id']==$id){ echo 'selected="selected"';}?>>
	   <?php  echo  $rs_car->fields['car_type']; ?></option>
	   <?php  $rs_car->MoveNext();
	    } 
		?>	
		</select> 
		<?php } ?>
</div>	

<?php
include('root.php');
include($root.'include/file_include.php');
$id=$_GET['id'];


//   List down all Accommudation
$qry_car = "SELECT * FROM ".$tblprefix."car WHERE id=".$id; 
 $rs_car = $db->Execute($qry_car);
 $count_car =  $rs_car->RecordCount();
 $totalcar = $count_car;
?>
<select name="car_id" class="fields" id="car_id" onchange="get_car_equipment('car_id', this.value, '<?php echo MYSURL."ajaxresponse/get_car_equipment.php"?>')">
<?php
if($totalcar<=0){?>
<option value="0">Select Car</option>
<?php
}else{?>
<option value="0">Select Car</option>	
	<?php while(!$rs_car->EOF){
				$is_cat_selected = '';
				if($rs_car->fields['id']==$id){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_car->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_car->fields['car_type'] ;?></option>
	<?php $rs_car->MoveNext();
	}
	}
    ?>
</select>







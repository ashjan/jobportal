<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$car_name=$_GET['car_id'];
	    $qry_car = "SELECT * FROM  ".$tblprefix."car WHERE id=".$id; 
		$rs_car = $db->Execute($qry_car);
		$count_add =  $rs_car->RecordCount();
		?>

<div id="pm_name"> 

<select name="cr_id" class="dropfields" id="cr_id">
<?php
if($count_add<=0){?>
<option value="0">Select Car</option>
<?php }else{?>
<option value="0">Select Car</option>	
	<?php while(!$rs_car->EOF){ ?>
<option value="<?php echo $rs_car->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_car->fields['car_type'] ;?></option>
	<?php $rs_car->MoveNext();
	}
	}
    }
?>
</select>

</div>
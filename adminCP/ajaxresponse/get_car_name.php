<?php
include('root.php');
include($root.'include/file_include.php');


if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_name'];
	    $qry_content = "SELECT * FROM  ".$tblprefix."car_equipment WHERE supplier_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>

<select name="car_id" class="fields" id="car_id">
<?php
if($count_add<=0){?>
<option value="">No Car Name Exists</option>
<?php
}else{?>
<option value="">No Car Name Exists</option>	
	<?php while(!$rs_content->EOF){
				$is_cat_selected = '';
				if($rs_content->fields['supplier_id']==$id){
				$is_cat_selected = 'selected="selected"';
				}else{
				$is_cat_selected = '';
				}
	?>
<option value="<?php echo $rs_content->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
			}
	}

?>
</select>
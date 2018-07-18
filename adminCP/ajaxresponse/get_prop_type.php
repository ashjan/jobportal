<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_name'];
	    $qry_content = "SELECT * FROM  ".$tblprefix."rooms WHERE property_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>

<select name="room_type_id" class="fields"   id="room_type_id">
<?php
if($count_add<=0){?>
<option value="0">No Room Type Exists</option>
<?php
}else{?>
<option value="0">Izaberite sobu</option>	
	<?php while(!$rs_content->EOF)
	{
				/*$is_cat_selected = '';
				if($rs_content->fields['pm_id']==$id){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}*/
?>
<option value="<?php echo $rs_content->fields['id'];?>" <?php //echo $is_cat_selected; ?>><?php echo $rs_content->fields['room_type'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>	
<?php
include('root.php');
include($root.'include/file_include.php');
if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_id'];
	    $qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>

<select name="property_id" class="fields1" id="property_id">
<?php
if($count_add<=0){?>
<option value="">No Property Name Exists</option>
<?php
}else{?>
<option value="">Izaberite objekat</option>	
	<?php while(!$rs_content->EOF){
				$is_cat_selected = '';
				/*if($rs_content->fields['pm_id']==$id)
				{
					$is_cat_selected = 'selected="selected"';
				}
				else
				{
					$is_cat_selected = '';
				}*/
				
				if($rs_content->fields['id'] == $_SESSION["sessdiscount"]["property_name"])
				{
					$is_cat_selected = 'selected="selected"';
				}
				else
				{
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
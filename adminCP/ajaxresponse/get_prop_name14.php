<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];

	    $qry_content = "SELECT id,property_name FROM  ".$tblprefix."properties WHERE pm_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		
<div id="property_id">		
<select name="property_id" class="fields" id="property_id" onchange="get_pm_criteria('properties_facilities', this.value, '<?php echo MYSURL."ajaxresponse/get_pm_criteria.php"?>','<?php echo $id;?>')" >
<?php
if($count_add<=0){?>
<option value="0">Izaberite objekat</option>
<?php
}else{?>
<option value="0">Izaberite objekat</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>	
</div>
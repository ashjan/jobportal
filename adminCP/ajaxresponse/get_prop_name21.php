<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_id'];
	    $qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$id." AND pm_type=1";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>

<div id="property_name"> 
<select name="property_id" class="dropfields" id="property_id" onchange="get_room_type4('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type16.php"?>','<?php echo $id; ?>')">
<?php
if($count_add<=0){?>
<option value="0">Izaberite objekat</option>
<?php
}else{?>
<option value="0">Izaberite objekat</option>	
	<?php while(!$rs_content->EOF){
				
?>
<option value="<?php echo $rs_content->fields['id'];?>" ><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>

</div>
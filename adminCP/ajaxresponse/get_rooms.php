<?php 
include('root.php');
include($root.'include/file_include.php');
if(isset($_GET['id'])){ 
 $propid=$_GET['id'];
 $pm_id=$_GET['pm_id']; 
        $property_name=$_GET['property_id'];
	    $qry_content = "SELECT id, room_type FROM  ".$tblprefix."rooms 
						WHERE  ".$tblprefix."rooms.property_id=".$propid."  
						AND ".$tblprefix."rooms.pm_id=".$pm_id.""; 
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
<div id="rooms_id1">		
<select name="room_id" class="fields" id="room_id" onChange="get_rates('get_rates', this.value,<?php echo $propid;?>,<?php echo $pm_id;?> ,'<?php echo MYSURL."ajaxresponse/get_rates.php"?>')">
<?php
if($count_add<=0){?>
<option value="0">Izaberite sobu</option>
<?php
}else{?>
<option value="0">Izaberite sobu</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['room_type'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
?>
</select>	
</div>
<?php 	
    }
?>

<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
       $property_name=$_GET['property_id'];
	   $qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$id." 
	   					AND ".$tblprefix."properties.pm_type=0 
						AND ".$tblprefix."properties.property_category=24";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		
<div id="property_id2">		
<select name="property_id" class="fields" id="property_id" onChange="get_rooms1('rooms_id2', this.value,<?php echo $id;?>, '<?php echo MYSURL."ajaxresponse/get_rooms2.php"?>')">
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
?>
</select>	
</div>
<?php 	
    }
?>

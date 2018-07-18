<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_name'];
	    $qry_content = "SELECT prop.* FROM  ".$tblprefix."properties AS prop,".$tblprefix."property_policy AS pol  
		WHERE prop.pm_id=".$id." AND prop.pm_type=0 AND prop.property_category=24 AND pol.property_id<>prop.id GROUP BY prop.id";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
<div id="property_name">
	<select name="property_name" class="dropfields"  onchange="get_room_type1('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type1.php"?>')">
	<?php if($count_add<=0){?>
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
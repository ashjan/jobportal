<?php
include('root.php');
include($root.'include/file_include.php');
$roomid=$_GET['id'];
$pm_id = $_GET['pm_id'];

//   List down all Accommudation
 $qry_rooms = "SELECT * FROM ".$tblprefix."rooms WHERE property_id=".$roomid;
 $rs_rooms = $db->Execute($qry_rooms);
 $count_rooms =  $rs_rooms->RecordCount();
 $totalrooms = $count_rooms;
?>
<div id="room_type">
					<!--<select name="room_type" class="dropfields" onchange="get_rates_overview2('propertyroom', this.value, '<?php //echo MYSURL."ajaxresponse/get_advance_rates_overview.php"?>','<?php //echo $pm_id; ?>')" >-->
					<select name="room_type" class="dropfields">
					<option value="0">Odaberite soba</option>
					<?php	
					$rs_rooms->MoveFirst();
					while(!$rs_rooms->EOF){
					echo '<option value="'.$rs_rooms->fields['id'].'">'.$rs_rooms->fields['room_type'].'</option>';
					$rs_rooms->MoveNext();
					}
					?>					
					</select>
<input type="hidden" name="room_type_id" id="room_type_id" value="<?php echo $roomid; ?>">
</div>
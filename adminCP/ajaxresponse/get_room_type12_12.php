<?php
include('root.php');
include($root.'include/file_include.php');
$roomid=$_GET['id']; 


//   List down all Accommudation
 $qry_rooms = "SELECT * FROM ".$tblprefix."rooms WHERE property_id=".$roomid; 
 $rs_rooms = $db->Execute($qry_rooms);
 $count_rooms =  $rs_rooms->RecordCount();
 $totalrooms = $count_rooms;
?>
<div id="room_type1">
					<select name="room_type1" class="dropfields" onchange="get_room_facilities1('propertyroom', this.value, '<?php echo MYSURL."ajaxresponse/get_room_facilities1_1.php"?>','<?php echo $roomid; ?>')" >
					<option value="0">Vrsta sobe</option>
					<?php	
					$rs_rooms->MoveFirst();
					while(!$rs_rooms->EOF){
					echo '<option value="'.$rs_rooms->fields['id'].'">'.$rs_rooms->fields['room_type'].'</option>';
					$rs_rooms->MoveNext();
					}
					?>					
					</select>
</div>
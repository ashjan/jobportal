<?php
include('root.php');
include($root.'include/file_include.php');
$roomid=$_GET['id'];


//   List down all Accommudation
 $qry_rooms = "SELECT * FROM ".$tblprefix."car WHERE agency=".$roomid;
 $rs_rooms = $db->Execute($qry_rooms);
 $count_rooms =  $rs_rooms->RecordCount();
 $totalrooms = $count_rooms;
?>

					<select name="yatch_id" class="dropfields"   id="yatch_id">
					<option value="0">Select Car</option>
					<?php	
					$rs_rooms->MoveFirst();
					while(!$rs_rooms->EOF){
					echo '<option value="'.$rs_rooms->fields['id'].'">'.$rs_rooms->fields['car_type'].'</option>';
					$rs_rooms->MoveNext();
					}
					?>					
					</select>

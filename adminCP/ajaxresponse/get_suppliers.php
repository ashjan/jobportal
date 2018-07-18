<?php
include('root.php');
include($root.'include/file_include.php');
$roomid=$_GET['id'];
//   List down all Accommudation
 $qry_rooms = "SELECT id,yatch_name FROM ".$tblprefix."yatchtypes WHERE yatch_agency=".$roomid;
 $rs_rooms = $db->Execute($qry_rooms);
 $count_rooms =  $rs_rooms->RecordCount();
 $totalrooms = $count_rooms;
?><select name="supplier_id" class="dropfields"   id="supplier_id" onchange="get_yatches('yatchdiv', this.value, '<?php echo MYSURL."ajaxresponse/get_yatchess.php"?>')">
					<option value="0">Select Model</option>
					<?php	
					$rs_rooms->MoveFirst();
					while(!$rs_rooms->EOF){
					echo '<option value="'.$rs_rooms->fields['id'].'">'.$rs_rooms->fields['yatch_name'].'</option>';
					$rs_rooms->MoveNext();
					}
					?>					
					</select>

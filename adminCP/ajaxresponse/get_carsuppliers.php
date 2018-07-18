<?php
include('root.php');
include($root.'include/file_include.php');
$roomid=$_GET['id'];


//   List down all Accommudation
 $qry_rooms = "SELECT * FROM ".$tblprefix."carsupplier WHERE agency_id=".$roomid;
/* echo $qry_rooms;
 exit;
*/ $rs_rooms = $db->Execute($qry_rooms);
 $count_rooms =  $rs_rooms->RecordCount();
 $totalrooms = $count_rooms;
?>

					<select name="supplier_id" class="dropfields"   id="supplier_id" onchange="get_cars('yatchdiv', this.value, '<?php echo MYSURL."ajaxresponse/get_carss.php"?>')">
					<option value="0">Select Supplier</option>
					<?php	
					$rs_rooms->MoveFirst();
					while(!$rs_rooms->EOF){
					echo '<option value="'.$rs_rooms->fields['id'].'">'.$rs_rooms->fields['supplier_name'].'</option>';
					$rs_rooms->MoveNext();
					}
					?>					
					</select>

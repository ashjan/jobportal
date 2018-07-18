<?php
include('root.php');
include($root.'include/file_include.php');
$agencyid=$_GET['id'];

//   List down all Accommudation
 $qry_rooms = "SELECT * FROM ".$tblprefix."yatchtypes WHERE yatch_agency=".$agencyid;
 $rs_yachtes = $db->Execute($qry_rooms);
 $count_yachtes =  $rs_yachtes->RecordCount();
 $totalrooms = $count_yachtes;
?>

					<div id="yatchdiv" >
                    <select name="yatch_id" class="dropfields"   id="yatch_id">
					<option value="0">Select Yatch</option>
					<?php	
					$rs_yachtes->MoveFirst();
					while(!$rs_yachtes->EOF){
					echo '<option value="'.$rs_yachtes->fields['id'].'">'.$rs_yachtes->fields['yatch_name'].'</option>';
					$rs_yachtes->MoveNext();
					}
					?>					
					</select>
                    </div>

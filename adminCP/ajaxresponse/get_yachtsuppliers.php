<?php
include('root.php');
include($root.'include/file_include.php');
$id=$_GET['id'];

 $qry_limit = "SELECT * From ".$tblprefix."type_mediafiles WHERE mf_id=".$id; 
$rs_limit = $db->Execute($qry_limit);

//   List down all Accommudation
 $qry_rooms = "SELECT * FROM ".$tblprefix."supplier WHERE agency_id=".$id;
/* echo $qry_rooms;
 exit;
*/ $rs_rooms = $db->Execute($qry_rooms);
 $count_rooms =  $rs_rooms->RecordCount();
 $totalrooms = $count_rooms;
?>

					<select name="supplier_id" class="dropfields"   id="supplier_id" onchange="get_yachts('yatchdiv', this.value, '<?php echo MYSURL."ajaxresponse/get_yachts.php"?>')">
					<option value="0">Select Supplier</option>
					<?php	
					$rs_rooms->MoveFirst();
					while(!$rs_rooms->EOF){
					//echo '<option value="'.$rs_rooms->fields['id'].'">'.$rs_rooms->fields['supplier_name'].'</option>';
					
					
					?>
		  			<option value="<?php echo $rs_rooms->fields['id'];?>" 
					<?php
					
					if($rs_limit->fields['supplier_id'] == $rs_rooms->fields['id'] )
					{
						echo 'selected="selected"';
					}
					?> > <?php echo $rs_rooms->fields['supplier_name'] ;?>
					</option>
					
					
					<?php
					$rs_rooms->MoveNext();
					}
					?>					
					</select>


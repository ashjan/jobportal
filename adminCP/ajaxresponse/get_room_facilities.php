<?php
include('root.php');
include($root.'include/file_include.php');
$propertyroomid=$_GET['id'];
$qry_room = "SELECT room_type from tbl_rooms"; 
$rs_room = $db->Execute($qry_room);

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."room_facility" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT rf.*,rm.id as rid,rm.room_type  FROM `tbl_room_facility` as rf  INNER JOIN tbl_rooms as rm ON rm.id=rf.rm_id";

/*$qry_limit = "SELECT * FROM ".$tblprefix."room_facility LIMIT $startRow,$maxRows"; */
$rs_limit = $db->Execute($qry_limit);

$qry_limit1 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=1"; 
$rs_limit1 = $db->Execute($qry_limit1);

$qry_limit2 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=2 "; 
$rs_limit2 = $db->Execute($qry_limit2);

$qry_limit3 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=3 "; 
$rs_limit3 = $db->Execute($qry_limit3);


$qry_limit4 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=4 "; 
$rs_limit4 = $db->Execute($qry_limit4);
$totalcountalphar =  $rs_room->RecordCount();
$totalcountalpha  =  $rs_limit->RecordCount();
$totalcountalpha1 =  $rs_limit1->RecordCount();
$totalcountalpha2 =  $rs_limit2->RecordCount();
$totalcountalpha3 =  $rs_limit3->RecordCount();
$totalcountalpha4 =  $rs_limit4->RecordCount();

?>


	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
			<tr height="5%">
			<td colspan="4" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Room Ameneties</td>
				<td width="8%">Media and Technology</td>
				<td width="5%">Kitchen</td>
				<td width="5%">Bathroom</td>
				
		    </tr>
					
			<tr><td colspan="4">		
					<table cellpadding="2" cellspacing="2" border="0" width="100%">
					
					<tr>
					<td class="txt" width="35%"> Add Remove</td>
					<td class="txt" width="25%"> Add Remove</td>
					<td class="txt" width="25%"> Add Remove</td>
					<td class="txt" width="25%"> Add Remove</td>
					</tr>
					 <div id = $propertyroom> 
				<tr>
				<td valign="top" width="25%" height="300">
				<form action="admin.php" method="post" name="genrl" enctype="multipart/form-data">
					<table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					 <?php 
					if($totalcountalpha1 >0){
					$rs_limit1->MoveFirst();
					while(!$rs_limit1->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit1->fields['room_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					if( $rs_limit1->fields['room_facility_status']==1){
					$value1='checked="checked"'; }
					else{
					$value1='';
					}
					
		echo  '<input type= radio value = "1" '.$value1.'id="room_facility_status_on_'.$rs_limit1->fields['id'].'"   name="room_facility_status_'.$rs_limit1->fields['id'].'" />';
		echo  '<input type=radio value = "0" '.$value.' id="room_facility_status_off_'.$rs_limit1->fields['id'].'" name="room_facility_status_'.$rs_limit1->fields['id'].'" />';
					 echo '<a href="admin.php?act=edit_room_facility&amp;id='.base64_encode($rs_limit1->fields['id']).' ">'.$rs_limit1->fields['facility_name'].'</a><br/>';
					 
					echo '</td></tr>';
					 $rs_limit1->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
			<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Room Ameneties" class="button"  /></td></tr>
					<input type="hidden" name="act" value="room_facility_management"  />
			        <input type="hidden" name="request_page" value="manage_room_facility" />
					<input type="hidden" name="mode" value="update_room_ameneties">
					
					
					</table></form>
				</td>
				
				<!--Code for the second column of radio button-->
				<td valign="top" width="25%"  height="300">
				<form action="admin.php" method="post" enctype="multipart/form-data">
					    <table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					
					<?php 
					if($totalcountalpha2 >0){
					$rs_limit2->MoveFirst();
					while(!$rs_limit2->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit2->fields['room_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					
					if( $rs_limit2->fields['room_facility_status']==1){
					$value2='checked="checked"'; }
					else{
					$value2='';
					}
					echo  '<input type= radio value = "1" '.$value2.'id="room_facility_status_on_'.$rs_limit2->fields['id'].'"   
					 name="room_facility_status_'.$rs_limit2->fields['id'].'" />';
					   
					echo '<input type=radio value = "0"'.$value.' id="room_facility_status_off_'.$rs_limit2->fields['id'].'" name="room_facility_status_'.$rs_limit2->fields['id'].'"/>';
					
					 echo '<a href="admin.php?act=edit_room_facility&amp;id='.base64_encode($rs_limit2->fields['id']).' ">'.$rs_limit2->fields['facility_name'].'</a><br/>';;
					 
					 echo '</td></tr>';
					 $rs_limit2->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" ><td valign="bottom">
					<input style="margin:5px; width:145px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Media n Technology" class="button"  />
					</td></tr>
					<input type="hidden" name="act" value="room_facility_management"  />
			        <input type="hidden" name="request_page" value="manage_room_facility" />
					<input type="hidden" name="mode" value="update_media_n_tech">
					</table>
					</form>
				</td>
				
				
<!--Code for the third column of radio button-->
					 <td valign="top" width="25%" height="300"><form action="admin.php" method="post" enctype="multipart/form-data">
					 <table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					<?php 
					if($totalcountalpha3 >0){
					$rs_limit3->MoveFirst();
					while(!$rs_limit3->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit3->fields['room_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					if( $rs_limit3->fields['room_facility_status']==1){
					$value3='checked="checked"'; }
					else{
					$value3='';
					}
					  
					echo  '<input type= radio  value = "1"'.$value3.'id="room_facility_status_on_'.$rs_limit3->fields['id'].'"   
					 name="room_facility_status_'.$rs_limit3->fields['id'].'" />';
					 
					 echo '<input type=radio value = "0"  '.$value.' id="room_facility_status_off_'.$rs_limit3->fields['id'].'" name="room_facility_status_'.$rs_limit3->fields['id'].'"/>';
					 
					 echo '<a href="admin.php?act=edit_room_facility&amp;id='.base64_encode($rs_limit3->fields['id']).' ">'.$rs_limit3->fields['facility_name'].'</a><br/>';;
					
					echo '</td></tr>'; 
					 $rs_limit3->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
		<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Kitchen" class="button"  /></td></tr>
					<input type="hidden" name="act" value="room_facility_management"  />
			        <input type="hidden" name="request_page" value="manage_room_facility" />
					<input type="hidden" name="mode" value="food_n_drinks">
					
					
					</table></form>
					</td>
					
				<td valign="top" width="25%" height="300"><form action="admin.php" method="post" enctype="multipart/form-data">
					<table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					<?php 
					if($totalcountalpha4 >0){
					$rs_limit4->MoveFirst();
					while(!$rs_limit4->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit4->fields['room_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					
					if( $rs_limit4->fields['room_facility_status']==1){
					$value4='checked="checked"'; }
					else{
					$value4='';
					}
					
					echo  '<input type= radio  value = "1"'.$value4.'id="room_facility_status_on_'.$rs_limit4->fields['id'].'"   
					 name="room_facility_status_'.$rs_limit4->fields['id'].'" />';
					 
					 echo '<input type=radio value = "0"  '.$value.' id="room_facility_status_off_'.$rs_limit4->fields['id'].'" name="room_facility_status_'.$rs_limit4->fields['id'].'"/>';
					 
					 echo '<a href="admin.php?act=edit_room_facility&amp;id='.base64_encode($rs_limit4->fields['id']).' ">'.$rs_limit4->fields['facility_name'].'</a><br/>';
					
					echo '</td></tr>'; 
					 $rs_limit4->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
		<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Bath Room" class="button"/>
				</td></tr>
					<input type="hidden" name="act" value="room_facility_management"  />
			        <input type="hidden" name="request_page" value="manage_room_facility" />
					<input type="hidden" name="mode" value="update_bathroom">
					
					</table>
					</td></form>
					</tr>
				
				
					</div>
</table>
</td></tr>
</table>


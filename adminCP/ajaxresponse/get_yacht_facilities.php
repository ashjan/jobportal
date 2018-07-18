<?php
include('root.php');
include($root.'include/file_include.php');
$yatchid=$_GET['id'];

$qry_room = "SELECT yatch_name from tbl_yatchtypes"; 
$rs_room = $db->Execute($qry_room);

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."yacht_facility" ; 
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

//$qry_limit = "SELECT rf.*,rm.id as rid,rm.yatch_name  FROM `tbl_yacht_facility` as rf  INNER JOIN tbl_yatchtypes as rm ON rm.id=rf.rm_id";

/*$qry_limit = "SELECT * FROM ".$tblprefix."yacht_facility LIMIT $startRow,$maxRows"; */
//$rs_limit = $db->Execute($qry_limit);

$qry_limit1 = "SELECT * FROM ".$tblprefix."yacht_facility WHERE ".$tblprefix."yacht_facility.facility_type=1 AND yatch_id='".$yatchid."'"; 

$rs_limit1 = $db->Execute($qry_limit1);

$qry_limit2 = "SELECT * FROM ".$tblprefix."yacht_facility WHERE ".$tblprefix."yacht_facility.facility_type=2 AND yatch_id='".$yatchid."'"; 
$rs_limit2 = $db->Execute($qry_limit2);

$qry_limit3 = "SELECT * FROM ".$tblprefix."yacht_facility WHERE ".$tblprefix."yacht_facility.facility_type=3 AND yatch_id='".$yatchid."'"; 
$rs_limit3 = $db->Execute($qry_limit3);


$qry_limit4 = "SELECT * FROM ".$tblprefix."yacht_facility WHERE ".$tblprefix."yacht_facility.facility_type=4 AND yatch_id='".$yatchid."'"; 
$rs_limit4 = $db->Execute($qry_limit4);

//$totalcountalpha =  $rs_limit->RecordCount();
$totalcountalpha1 =  $rs_limit1->RecordCount();
$totalcountalpha2 =  $rs_limit2->RecordCount();
$totalcountalpha3 =  $rs_limit3->RecordCount();
$totalcountalpha4 =  $rs_limit4->RecordCount();

?>


	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Yatch Ameneties</td>
				<td width="8%">Media and Technology</td>
				<td width="5%">Kitchen</td>
				<td width="5%">Bathroom</td>
				
		    </tr>
					
					
					<table cellpadding="2" cellspacing="2" border="0" width="100%">
					
					<tr>
					<td class="txt" width="35%"> Add Remove</td>
					<td class="txt" width="25%"> Add Remove</td>
					<td class="txt" width="25%"> Add Remove</td>
					<td class="txt" width="25%"> Add Remove</td>
					</tr>
					 <div id ="yacht"> 
				<tr>
				<td valign="top" width="25%" height="300">
					<table cellpadding="0" cellspacing="0" border="0" height="300">
					 <form action="admin.php" method="post" enctype="multipart/form-data">
					 <?php 
					if($totalcountalpha1 >0){
					
					while(!$rs_limit1->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit1->fields['yacht_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					if( $rs_limit1->fields['yacht_facility_status']==1){
					$value1='checked="checked"'; }
					else{
					$value1='';
					}
					
		echo  '<input type= radio value = "1" '.$value1.'id="room_facility_status_on_'.$rs_limit1->fields['id'].'"   name="room_facility_status_'.$rs_limit1->fields['id'].'" />';
		echo  '<input type=radio value = "0" '.$value.' id="room_facility_status_off_'.$rs_limit1->fields['id'].'" name="room_facility_status_'.$rs_limit1->fields['id'].'" />';
					 echo '<a href="admin.php?act=edityatchfacility&amp;id='.base64_encode($rs_limit1->fields['id']).' ">'.$rs_limit1->fields['facility_name'].'</a><br/>';
					 
					echo '</td></tr>';
					 $rs_limit1->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
			<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Room Ameneties" class="button"  /></td></tr>
					<input type="hidden" name="act" value="yatchfacility"  />
			        <input type="hidden" name="request_page" value="yatchfacilitymanagement" />
					<input type="hidden" name="mode" value="update_room_ameneties">
					<input type="hidden" name="yatch_type" value="<?php echo $yatchid;?>">
					</form>
					
					</table>
				</td>
				
				<!--Code for the second column of radio button-->
				<td valign="top" width="25%"  height="300">
					    <table cellpadding="0" cellspacing="0" border="0" height="300">
					 <form action="admin.php" method="post" enctype="multipart/form-data">
					
					<?php 
					if($totalcountalpha2 >0){
					
					while(!$rs_limit2->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit2->fields['yacht_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					
					if( $rs_limit2->fields['yacht_facility_status']==1){
					$value2='checked="checked"'; }
					else{
					$value2='';
					}
					echo  '<input type= radio value = "1" '.$value2.'id="room_facility_status_on_'.$rs_limit2->fields['id'].'"   
					 name="room_facility_status_'.$rs_limit2->fields['id'].'" />';
					   
					echo '<input type=radio value = "0"'.$value.' id="room_facility_status_off_'.$rs_limit2->fields['id'].'" name="room_facility_status_'.$rs_limit2->fields['id'].'"/>';
					
					 echo '<a href="admin.php?act=edityatchfacility&amp;id='.base64_encode($rs_limit2->fields['id']).' ">'.$rs_limit2->fields['facility_name'].'</a><br/>';;
					 
					 echo '</td></tr>';
					 $rs_limit2->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" ><td valign="bottom">
					<input style="margin:5px; width:145px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Media n Technology" class="button"  />
					</td></tr>
					<input type="hidden" name="act" value="yatchfacility"  />
			        <input type="hidden" name="request_page" value="yatchfacilitymanagement" />
					<input type="hidden" name="mode" value="update_media_n_tech">
					<input type="hidden" name="yatch_type" value="<?php echo $yatchid;?>">
					</form>
					
					</table>
					
				</td>
				
				
<!--Code for the third column of radio button-->
					 <td valign="top" width="25%" height="300">
					 <table cellpadding="0" cellspacing="0" border="0" height="300">
					 <form action="admin.php" method="post" enctype="multipart/form-data">
					<?php 
					if($totalcountalpha3 >0){
					
					while(!$rs_limit3->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit3->fields['yacht_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					if( $rs_limit3->fields['yacht_facility_status']==1){
					$value3='checked="checked"'; }
					else{
					$value3='';
					}
					  
					echo  '<input type= radio  value = "1"'.$value3.'id="room_facility_status_on_'.$rs_limit3->fields['id'].'"   
					 name="room_facility_status_'.$rs_limit3->fields['id'].'" />';
					 
					 echo '<input type=radio value = "0"  '.$value.' id="room_facility_status_off_'.$rs_limit3->fields['id'].'" name="room_facility_status_'.$rs_limit3->fields['id'].'"/>';
					 
					 echo '<a href="admin.php?act=edityatchfacility&amp;id='.base64_encode($rs_limit3->fields['id']).' ">'.$rs_limit3->fields['facility_name'].'</a><br/>';;
					
					echo '</td></tr>'; 
					 $rs_limit3->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
		<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Kitchen" class="button"  /></td></tr>
					<input type="hidden" name="act" value="yatchfacility"  />
			        <input type="hidden" name="request_page" value="yatchfacilitymanagement" />
					<input type="hidden" name="mode" value="food_n_drinks">
					<input type="hidden" name="yatch_type" value="<?php echo $yatchid;?>">
					</form>
					
					</table>
					</td>
					
				<td valign="top" width="25%" height="300">
					<table cellpadding="0" cellspacing="0" border="0" height="300">
					 <form action="admin.php" method="post" enctype="multipart/form-data">
					<?php 
					if($totalcountalpha4 >0){
					
					while(!$rs_limit4->EOF){
					echo '<tr height="15"><td>';
					if( $rs_limit4->fields['yacht_facility_status']==0){
					$value='checked="checked"'; }
					else{
					$value='';
					}
					
					if( $rs_limit4->fields['yacht_facility_status']==1){
					$value4='checked="checked"'; }
					else{
					$value4='';
					}
					
					echo  '<input type= radio  value = "1"'.$value4.'id="yacht_facility_status_on_'.$rs_limit4->fields['id'].'"   
					 name="yacht_facility_status_'.$rs_limit4->fields['id'].'" />';
					 
					 echo '<input type=radio value = "0"  '.$value.' id="yacht_facility_status_off_'.$rs_limit4->fields['id'].'" name="yacht_facility_status_'.$rs_limit4->fields['id'].'"/>';
					 
					 echo '<a href="admin.php?act=edityatchfacility&amp;id='.base64_encode($rs_limit4->fields['id']).' ">'.$rs_limit4->fields['facility_name'].'</a><br/>';
					
					echo '</td></tr>'; 
					 $rs_limit4->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
		<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Bath Room" class="button"/>
				</td></tr>
					<input type="hidden" name="act" value="yatchfacility"  />
			        <input type="hidden" name="request_page" value="yatchfacilitymanagement" />
					<input type="hidden" name="mode" value="update_bathroom">
					<input type="hidden" name="yatch_type" value="<?php echo $yatchid;?>">
					</form>
					
					</table>
					</td></tr>
				
				
					</div>
</table>
</table>


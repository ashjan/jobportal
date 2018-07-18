<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."room_facility_management WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

?>



<div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
	<tr>
  		<td id="heading" colspan="4">Manage Room Facilities &nbsp;[Upravljanje sadr&#382;ajima sobe]</td>
 	</tr>			
 <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>				
                <tr>
				<td class="txt1">
				Facility Name (English)<br/>[Izaberite sadr&#382;aj (English)] 
				</td>
				<td>
		<input type="text" name="facility_name" class="fields"  id="facility_name" value="<?php echo $rs_limit->fields['facility_name']; ?>"  />
 				</td> 
				</tr>
<?php 
$query ="SELECT * FROM `tbl_language_contents` WHERE `page_id` ='$id' AND language_id ='5' AND `fld_type` = 'room_facility' AND `field_name`= 'room_facility_rus'";
$result =mysql_fetch_object( mysql_query($query));	
?>
				<tr>
				<td class="txt1">Facility Name (Russian)</td>
				<td>
	<input type="text" name="room_facility_rus" class="fields"  id="room_facility_rus" value="<?php echo $result->translated_text; ?>"  />
 				</td> 
				</tr>
<?php 
$query_mon ="SELECT * FROM `tbl_language_contents` WHERE `page_id` ='$id' AND language_id ='7' AND `fld_type` = 'room_facility' AND `field_name`= 'room_facility_mon'";
$result_mon =mysql_fetch_object( mysql_query($query_mon));	
?>
				<tr>
				<td class="txt1">Facility Name (MON)<br/>[Izaberite sadr&#382;aj (Crnogorski)]</td>
				<td>
	<input type="text" name="room_facility_mon" class="fields"  id="room_facility_mon" value="<?php echo $result_mon->translated_text; ?>"  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Facility Category Type<br/>[Izaberite kategoriju sadr&#382;aja]</td>
				<td>
			<select name="property_fac_category" class="fields"   id="property_fac_category">
			<option value="0">Izaberite kategoriju sadr&#382;aja</option>
			<option <?php if($rs_limit->fields['room_fac_category']==1){ echo 'selected="selected"';}  ?> value="1">Room Amenities</option>
			<option <?php if($rs_limit->fields['room_fac_category']==2){ echo 'selected="selected"';}  ?> value="2">Media and technology</option>
			<option <?php if($rs_limit->fields['room_fac_category']==3){ echo 'selected="selected"';}  ?> value="3">Kitchen</option>		
			<option <?php if($rs_limit->fields['room_fac_category']==4){ echo 'selected="selected"';}  ?> value="4">Bathroom</option>		
			</select>
 				</td> 
				</tr>
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="A&#382;uriraj sadr&#382;aj" class="button" />
                </td>
                </tr>
</table>				
</div>
<tr>
					<td>&nbsp;</td>
					<td>
					<input type="hidden" name="mode"         value="update">
					<input type="hidden" name="act"          value="edit_room_facility_management">
					<input type="hidden" name="act2"         value="manage_room_facility">
					<input type="hidden" name="id"           value="<?php echo base64_encode($id); ?>">
					<input type="hidden" name="request_page" value="room_facility_management" />
					</td>
</tr>
</form> 

  </div>
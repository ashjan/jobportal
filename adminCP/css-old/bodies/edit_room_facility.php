<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."room_facility WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Room Facility Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		
		
		<tr>
	        <td>
  			Facility Name
		   	</td>
			<td>
			<input type="text" name="facility_name" class="fields" id="facility_name" value="<?php echo $rs_limit->fields['facility_name']; ?>" />
			</td>
        </tr>
		
		<tr>
	        <td>
  		Facility Name (Rus)
		   	</td>
			<td>
<?php
$query_rus ="SELECT * FROM `tbl_language_contents` WHERE `page_id` ='$id' AND language_id ='5' AND `fld_type` = 'room_facility' AND `field_name`= 'room_facility_mon '";
			$result_rus=mysql_fetch_object( mysql_query($query_rus));
?>										
			
<input type="text" name="facility_name_rus" class="fields" id="facility_name_rus" value="<?php echo $result_rus; ?>" />
			</td>
        </tr>
		
		
		<tr>
	        <td>
  		Facility Name (Mon)
		   	</td>
			<td>
<?php 
$query_mon ="SELECT * FROM `tbl_language_contents` WHERE `page_id` ='$id' AND language_id ='7' AND `fld_type` = 'room_facility' AND `field_name`= 'room_facility_mon'";
			$result_mon=mysql_fetch_object( mysql_query($query_mon));	
?>			
<input type="text" name="facility_name_mon" class="fields" id="facility_name_mon" value="<?php echo $result_mon; ?>" />
			</td>
        </tr>
		<tr><td>Room Facility Status</<br />
			   <td>
			   <?php if($rs_limit->fields['room_facility_status'] == 0) {?>
			    <select name="room_facility_status">
				<option value="0" selected="selected">No</option>
				<option value="1">Yes</option>
				</select>
				<?php }else{ ?>
				 <select name="room_facility_status">
				<option value="0" >No</option>
				<option value="1" selected="selected">Yes</option>
				</select>
				<?php } ?>
				</td>
		 </tr> 
		 
			 <tr>
	        <td>
  			Facility Type
		   	</td>
			<td>
			<select name="facility_type" id="facility_type" class="">
			<option value="0">Please Select Category Type </option> 
			<option value="1" <?php   if($rs_limit->fields['facility_type']==1){ echo 'selected="selected"';}  ?>>Room Ameneties</option> 
			<option value="2"  <?php   if($rs_limit->fields['facility_type']==2){ echo 'selected="selected"';}  ?>>Media and Technology</option> 
			<option value="3" <?php   if($rs_limit->fields['facility_type']==3){ echo 'selected="selected"';}  ?>>Food and Drinks</option> 
			</select>
			</td>
        </tr> 
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Facility" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="room_facility_management" />
          <input type="hidden" name="request_page" value="manage_room_facility" />
	 <input type="hidden" name="id" value="<?php  echo base64_encode ($rs_limit->fields['id']); ?>"/>
          <input type="hidden" name="mode" value="update">
        </form>
		
	
		</td>
	</tr>
</table>


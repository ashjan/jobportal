<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."yacht_facility WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Yatch Facility Section</td>
 	</tr>
 	<tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
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
		<tr><td>Yatch Facility Status</<br />
			   <td>
			   <?php if($rs_limit->fields['yacht_facility_status'] == 0) {?>
			    <select name="yacht_facility_status">
				<option value="0" selected="selected">No</option>
				<option value="1">Yes</option>
				</select>
				<?php }else{ ?>
				 <select name="yacht_facility_status">
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
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Yatch Facility" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="edityatchfacility" />
		  <input type="hidden" name="act2" value="yatchfacility" />
          <input type="hidden" name="request_page" value="yatchfacilitymanagement" />
	 <input type="hidden" name="id" value="<?php  echo base64_encode ($rs_limit->fields['id']); ?>"/>
          <input type="hidden" name="mode" value="update">
        </form>
		
	
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT mi.*,pm.id as pid,pm.first_name,pr.id as prid,pr.property_name  FROM `tbl_mediaimages` as mi INNER JOIN tbl_properties as pr ON pr.id=mi.property_id INNER JOIN tbl_property_manager as pm ON pm.id=mi.pm_id where mi.id=".$id;

$qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
 $qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_limit = $db->Execute($qry_limit);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Yatch Type Image  Section</td>
 	</tr>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onSubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
	<tr>
	<td class="txt1">Yatch Manager</td>
	<td>
	<select name="first_name" class="dropfields" id="first_name" onChange="get_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
	<option value="">Select Yatch Manager</option>
<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
?>	<option value="<?php echo $rs_property_manag->fields['id'];?>" >
		    <?php echo $rs_property_manag->fields['first_name'] ;?>
			</option>
	        <?php $rs_property_manag->MoveNext();
			} ?>			
			</select>					
			</td>
			</tr>
			<tr>
			<td class="txt1">Yatch Type</td>
			<td>
			<div id="property_name">
			<select name="property_name" class="dropfields" id="property_name">
			<option value="0">First Select Yatch Manager</option>
			</select>
			</div>
					
					</td>
				</tr>
				
				<tr>
				<td class="txt1">Title</td>
		<td><input type="text" name="image_title" class="fields" value="<?php echo $rs_limit->fields['image_title']; ?>" /></td>
		</tr>
		
		
		<tr>
        	<td class="txt1">Image</td>
			<td>
			<input type="file" name="image" class="fields" />
			</td>
        </tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Image" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edityatchtypesimages">
		<input type="hidden" name="act2" value="yatchtypesimages">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['image_name']; ?>" />
		<input type="hidden" name="request_page" value="manageyatchtypeimages" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>

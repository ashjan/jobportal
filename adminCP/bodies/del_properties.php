<?php

$id=base64_decode($_GET['id']);

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' AND pr.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}

$qry_limit = "SELECT pr.*,pm.id as pid,pm.first_name,pm.last_name  
              FROM `tbl_properties` as pr  
			  INNER JOIN tbl_users as pm ON pm.id=pr.pm_id 
			  WHERE pr.id=".$id." $module_pm_where ";
			
$rs_limit = $db->Execute($qry_limit);
$qry_pmsel = "SELECT * FROM ".$tblprefix."users where id =".$rs_limit->fields['pm_id']." $module_pm_where ";
$rs_pmsel = $db->Execute($qry_pmsel);

//List down all regions
$qry_region = "SELECT * FROM ".$tblprefix."property_regions" ;
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;

$qry_regionsel = "SELECT * FROM ".$tblprefix."property_regions where id = '".$rs_limit->fields['region']."' " ;
$rs_regionsel = $db->Execute($qry_regionsel);


//List down all features
$qry_feature = "SELECT * FROM ".$tblprefix."property_features" ;
$rs_feature = $db->Execute($qry_feature);
$count_feature =  $rs_feature->RecordCount();
$totalFeature = $count_feature;

//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation WHERE ".$tblprefix."property_accommodation.property_cat=24" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;

//   List down all Project Manager

//   List Room Types
if($_SESSION[SESSNAME]['pm_moduleid']==2){
$qry_pm = "SELECT * FROM ".$tblprefix."users WHERE id = ".$_SESSION[SESSNAME]['pm_id'];
}else{
$qry_pm = "SELECT * FROM ".$tblprefix."users ";
}


$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;

//   List down all Property category 
$qry_category = "SELECT * FROM ".$tblprefix."property_category WHERE ".$tblprefix."property_category.id=24" ;
$rs_category = $db->Execute($qry_category);
$count_property_category =  $rs_category->RecordCount();
$totalCategory = $count_property_category;

//   List down all Language
$qry_lang = "SELECT * FROM ".$tblprefix."language" ;
$rs_lang = $db->Execute($qry_lang);
$count_lang =  $rs_lang->RecordCount();
$totalPM = $count_lang;

//   List Business Sub  Types

/*$qry_sub_type = "SELECT * FROM ".$tblprefix."business_subtype WHERE business_type_id=".$rs_limit->fields['business_type']; */$qry_sub_type = "SELECT * FROM ".$tblprefix."business_subtype WHERE ".$tblprefix."business_subtype.business_category_id=24";
$rs_sub_type = $db->Execute($qry_sub_type);
$count_sub_type =  $rs_sub_type->RecordCount();
$totalsubtype = $count_sub_type;



//   List Room Types
if($_SESSION[SESSNAME]['pm_moduleid']==2){
$qry_roomtype = "SELECT * FROM ".$tblprefix."rooms WHERE pm_id = ".$_SESSION[SESSNAME]['pm_id'];
}else{
$qry_roomtype = "SELECT * FROM ".$tblprefix."rooms ";
}

$rs_roomtype = $db->Execute($qry_roomtype);
$count_room_type =  $rs_roomtype->RecordCount();
$totalRoomTypes = $count_room_type;
?>
<script language="javascript">
$(document).ready(function() {
    $("#txtboxToFilter").keydown(function(event) {
        // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Properties Management Section</td>
 	</tr>
	
	<tr>
  		<td>&nbsp;</td>
	</tr>
	
	
	<form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
		<tr>
		<td><table width="100%"  align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
		
		
		<?php
			if($_SESSION[SESSNAME]['pm_moduleid']==2){
			?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
		    <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
		  </td>
		  </tr>
		  <?php
			}else{
			?>
		
		<?php } ?>
		
		
			
		
		
		<tr>
	        <td>
  			<strong>Naziv objekta</strong>
		   	</td>
			<td>
			<?php echo $rs_limit->fields['property_name']; ?></td>
        </tr>        
		
		
		
		
		<tr>
		<td>
		<strong>Note:</strong>
		</td>
		<td style="color:#FF0000;">
		By deleting this property, Information related to this property in database, directory and panels mentioned below will be deleted forever.
		</td>
		</tr>
		
		<tr>
		<td>
		<strong>Panels:</strong>
		</td>
		<td>
		Bedding Types<br />
		Property Policy<br />
		Media Manager<br />
		Property Facility<br />
		Property Commission<br />
		Property Room Minimum Stay<br />
		Property Policy<br />
		Related Properties<br />
		Room Management<br />
		Room Facility<br />
		Standard Rates<br />
		Standard Rates Overview<br />
		Advance Rates Overview<br />
		Top Offers<br />
		VAT and TAX Charges <br />
		
		</td>
		</tr>
		<tr>
		<td colspan="2" style="font-size:14px;">
		Do you want to continue??
		</td>
		
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<a class="button" href="admin.php?act=manage_properties&amp;mode=delete&amp;id=<?php echo $_REQUEST['id']; ?>&amp;request_page=properties_management" onClick="return confirm('Are you sure you want to Delete?')">Delete Property</a>
			
			<!--<input style="margin:5px; width:100px; float:none; text-align:center;" onClick="return confirm('Are you sure you want to Delete?')" type="submit" name="submit" id="submit"  value="Delete Property" class="button" />-->
			</td>
        </tr>
		</table></td>
	</tr>
<input type="hidden" name="act" value="manage_properties" />
<input type="hidden" name="request_page" value="properties_management" />
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<input type="hidden" name="mode" value="delete">
		
		</form>
		
</table>

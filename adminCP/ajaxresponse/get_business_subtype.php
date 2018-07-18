<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];
//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation  WHERE property_cat=".$propertymanagerid;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;
?>
<div id="business_type_id" name="business_type_id">
<select name="business_type_id" class="dropfields"   id="business_type_id">
<?php 

$rs_accommodation->MoveFirst();
	while(!$rs_accommodation->EOF){
	echo '<option value="'.$rs_accommodation->fields['accomm_name'].'">'.$rs_accommodation->fields['accomm_name'].'</option>';
	$rs_accommodation->MoveNext();
	}
?>
</select>
</div>
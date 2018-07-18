<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];
//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."business_subtype  WHERE ".$tblprefix."business_subtype.business_type_id=".$propertymanagerid;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;
?>
<div id="business_subtype" >
<select name="business_subtype" class="dropfields" id="business_subtype">
<option value="0">Izaberite podvrstu objekta</option>
<?php 
    $rs_accommodation->MoveFirst();
	while(!$rs_accommodation->EOF){
	echo '<option value="'.$rs_accommodation->fields['id'].'">'.$rs_accommodation->fields['business_subtype'].'</option>';
	$rs_accommodation->MoveNext();
	}
?>
</select>
</div>
<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];

//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;

?><select name="business_type" class="dropfields"   id="business_type" >
<?php	
    $rs_accommodation->MoveFirst();
	while(!$rs_accommodation->EOF){
	echo '<option value="'.$rs_accommodation->fields['accomm_name'].'">'.$rs_accommodation->fields['accomm_name'].'</option>';
	$rs_accommodation->MoveNext();
	}
?>					
</select>
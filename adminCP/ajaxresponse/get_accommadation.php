<?php
include('root.php');
include($root.'include/file_include.php');
$catid=$_GET['id'];
//   List down all Accommudation
$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation 
						WHERE ".$tblprefix."property_accommodation.property_cat=".$catid;
$rs_accommodation = $db->Execute($qry_accommodation);

$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;
?>
<div id="business_type">
<select name="business_type" class="dropfields"   id="business_type" onchange="get_businesssubtype('business_subtype', this.value,'<?php echo MYSURL."ajaxresponse/get_businesssubtype.php"?>')">
<option value="0">Poslovni Tip</option>
<?php	
    $rs_accommodation->MoveFirst();
	while(!$rs_accommodation->EOF){
	echo '<option value="'.$rs_accommodation->fields['id'].'">'.$rs_accommodation->fields['accomm_name'].'</option>';
	$rs_accommodation->MoveNext();
}
?>					
</select>
</div>	
			
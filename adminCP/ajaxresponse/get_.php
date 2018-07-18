<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];

//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;

?>
	<select name="accomm_name" class="dropfields"   id="accomm_name">
<?php	
if($propertymanagerid=='accommodation'){	?>			
				
				<option value="Apartment">Apartment</option>
				<option value="Villa">Villa</option>
				<option value="Hotel Motel">Hotel Motel</option>
				<option value="Room">Room</option>
				<option value="Guest House">Guest House</option>
				<?php

}elseif($propertymanagerid=='wine_and_dine'){
?>
	
				<option value="Restuarant">Restuarant</option>
				<option value="Cafe">Cafe</option>
				<option value="Wine Routes">Wine Routes</option>
<?php

}else{

    $rs_accommodation->MoveFirst();
	while(!$rs_accommodation->EOF){
	echo '<option value="'.$rs_accommodation->fields['accomm_name'].'">'.$rs_accommodation->fields['accomm_name'].'</option>';
	$rs_accommodation->MoveNext();
	}
}
?>					
</select>
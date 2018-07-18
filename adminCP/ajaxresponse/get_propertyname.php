<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];

//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;

//   List down all Project Manager

?>
<table>
<tr>
<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			
			
<select name="business_type" class="fields"   id="business_type">
	<?php $bzi_type = stripslashes($rs_limit->fields['business_type']); 
		if( $bzi_type == 1 ){ $bzi_type_name = "Apartment";}else
		if( $bzi_type == 2 ){ $bzi_type_name = "Villa";}else
		if( $bzi_type == 3 ){ $bzi_type_name = "Hotel Motel";}else
		if( $bzi_type == 4 ){ $bzi_type_name = "Room";}else
		if( $bzi_type == 5 ){ $bzi_type_name = "Guest House";}
	?>
		<option value="<?php echo $rs_pmsel->fields['business_type'] ?>"><?php echo $bzi_type_name; ?></option>
	<?php 
		while(!$rs_accommodation->EOF){
		echo '<option value="'.$rs_accommodation->fields['id'].'">'.$rs_accommodation->fields['accomm_name'].'</option>';
		$rs_accommodation->MoveNext();
		}
	?>					
			</select>
			
			
			
			</td> </tr></table>
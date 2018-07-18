<?php
include('root.php');
include($root.'include/file_include.php');
$fac_cat_id=$_GET['id'];
if($fac_cat_id!=0){
$qry_limit1 = "SELECT * FROM ".$tblprefix."yatfacility_management WHERE yat_fac_category=".$fac_cat_id; 
}else{
$qry_limit1 = "SELECT * FROM ".$tblprefix."yatfacility_management"; 
}
$rs_facility = $db->Execute($qry_limit1);
$totalfacility =  $rs_facility->RecordCount();
?>

<div id="facility_name">
    <select  name="fac_id[]" multiple="multiple" size="8" style="height:100px;" id="fac_id" class="fields">
		<option value="0">Izaberite sadr&#382;aj</option>
		 <?php  while(!$rs_facility->EOF){ ?>
         <option value="<?php echo $rs_facility->fields['id'];?>"><?php echo $rs_facility->fields['facility_name'];?></option>
	     <?php $rs_facility->MoveNext();
	 }  ?>
	</select>
</div> 
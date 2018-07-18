<?php
include('root.php');
include($root.'include/file_include.php');
$fac_cat_id=$_GET['id'];
if($fac_cat_id!=0){
$qry_limit1 = "SELECT * FROM ".$tblprefix."room_facility_management WHERE room_fac_category=".$fac_cat_id; 
}else{
$qry_limit1 = "SELECT * FROM ".$tblprefix."room_facility_management"; 
}
$rs_facility = $db->Execute($qry_limit1);
$totalfacility =  $rs_facility->RecordCount();
?>

<div id="facility_name">
    <select  name="fac_id[]" multiple="multiple" size="8" style="height:100px;" id="fac_id" class="fields">
		<option value="0">Izaberite sadr&#382;aj</option>
		 <?php  while(!$rs_facility->EOF){ 
		$qry_mon= "SELECT  
               lan.translated_text  
			   FROM ".$tblprefix."language_contents AS lan 
			   WHERE 
			   lan.page_id = '".$rs_facility->fields['id']."'   
			    AND 
			   lan.fld_type = 'room_facility' 
			    AND 
			   lan.field_name = 'room_facility_mon' 
			    AND 
			   lan.language_id = '7' ";
		 $rs_mon   = $db->Execute($qry_mon);
		 $totalmon = $rs_mon->RecordCount();
		 $translated_mon ="";
		 if($totalmon >0){while(!$rs_mon->EOF){ $translated_mon = $rs_mon->fields['translated_text'];$rs_mon->MoveNext();}} 
		 if($translated_mon=="" or $translated_mon ==' ' or $translated_mon == NULL){$translated_mon = $rs_facility->fields['facility_name'];}
		?> 
         <option value="<?php echo $rs_facility->fields['id'];?>"><?php echo $translated_mon; ?></option>
	     <?php $rs_facility->MoveNext();
	 }  ?>
	</select>
</div> 
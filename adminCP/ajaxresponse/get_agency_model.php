<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$agency_id=$_GET['id'];
$pm_id = $_GET['pm_id'];

	    $qry_content = "SELECT id,yatch_name FROM  ".$tblprefix."yatchtypes WHERE pm_id=".$pm_id." AND yatch_agency=".$agency_id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		
<div id="property_id">		
<select name="model" class="fields" id="model" >
<?php
if($count_add<=0){?>
<option value="0">Select Model</option>
<?php
}else{?>
<option value="0">Select Model</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['yatch_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>	
</div>
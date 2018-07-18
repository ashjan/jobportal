<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];

	    $qry_content = "SELECT agn_id,agn_name FROM  ".$tblprefix."yatchagency WHERE pm_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		
<div id="agency_name">		
<select name="agency" class="fields" id="agency" onchange="get_agency_model('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_agency_model.php"?>','<?php echo $id?>')" >
<?php
if($count_add<=0){?>
<option value="0">Select Agency</option>
<?php
}else{?>
<option value="0">Select Agency</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['agn_id'];?>"><?php echo $rs_content->fields['agn_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>	
</div>
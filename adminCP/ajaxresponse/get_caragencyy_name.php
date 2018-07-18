<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_id'];
	    $qry_content = "SELECT * FROM  ".$tblprefix."agency WHERE pm_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		

<select name="agency_id" class="fields" id="agency_id" onchange="get_carsupplier('supplierdiv',this.value, '<?php echo MYSURL."ajaxresponse/get_carsuppliers.php"?>')" >
<?php
if($count_add<=0){?>
<option value="0">Select Car Agency</option>
<?php
}else{?>
<option value="0">Select Car Agency</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['agn_id'];?>"><?php echo $rs_content->fields['agn_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>
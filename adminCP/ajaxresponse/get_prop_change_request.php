<?php
include('root.php');
include($root.'include/file_include.php');


if(isset($_GET['id'])){
$id=$_GET['id'];
       
	 $qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$id."";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		
<div id="property_id1">		
<select name="property_id" class="fields" id="property_id" onChange="get_change_request('get_change_requests', this.value,<?php echo $id;?>, '<?php echo MYSURL."ajaxresponse/get_change_request.php"?>')">
<?php
if($count_add<=0){?>
<option value="0">Izaberite objekat</option>
<?php
}else{?>
<option value="0">Izaberite objekat</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
?>
</select>	
</div>
<?php 	
    }
?>

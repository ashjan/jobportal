<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_id'];
	    $qry_content = "SELECT * FROM  ".$tblprefix."agency WHERE car_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
 <div id="property_id">		

<select name="property_id" class="fields1" id="property_id" >
<?php
if($count_add<=0){?>
<option value="0">Select Car Agency</option>
<?php
}else{?>
<option value="0">Select Car Agency</option>	
	<?php while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>	

</div>
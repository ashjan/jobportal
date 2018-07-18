<?php
	include('root.php');
	include($root.'include/file_include.php');
	?>
<div id="property_id">
<?php 
if(isset($_GET['id'])){

	$id=$_GET['id'];
    $qry_content = "SELECT prop.* FROM  tbl_properties AS prop   
					WHERE prop.pm_id=".$id." 
					AND prop.property_category<>24 ";

	
	
	$rs_prop = $db->Execute($qry_content);
	$count_add =  $rs_prop->RecordCount();
?>
		
    
				<select name="property_name" class="fields" id="property_name">
                    <option value="">Izaberite objekta</option>
                    <?php 
                        $rs_prop->MoveFirst();
                        while(!$rs_prop->EOF){
                        echo "<option value=".$rs_prop->fields['id'].">".$rs_prop->fields['property_name'].'</option>';
                        $rs_prop->MoveNext();
                    }
                    ?>  
                </select>
<?php } ?>
</div>
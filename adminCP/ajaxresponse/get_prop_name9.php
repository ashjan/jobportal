<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_id'];

		
	    $qry_content = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pt.property_name FROM `".$tblprefix."property_manager_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id INNER JOIN tbl_properties as pt ON pt.id=pmc.pt_id=".$id;
		
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		$pt_id = $rs_content->fields['pt_id'];
		
		$qry_prop ="SELECT * FROM ".$tblprefix." properties WHERE id=".$pt_id ;
		$rs_prop = $db->Execute($qry_prop);
		
		
		?>
		
<select name="property_id" class="fields" id="property_id" onchange="get_room_type1('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name9.php"?>')">
<?php
if($count_add<=0){?>
<option value="0">Izaberite objekat</option>
<?php
}else{?>
<option value="0">Izaberite objekat</option>	
	<?php while(!$rs_content->EOF){
				$is_cat_selected = '';
				
				
				<?php if($rs_supplier->fields['id']==$rs_limit->fields['supplier_id']){ echo 'selected="selected"';}?>>
	   <?php echo  $rs_supplier->fields['supplier_name'];
				
				
				
				if($rs_content->fields['pt_id']==$rs_prop->fields['id']){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_content->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>
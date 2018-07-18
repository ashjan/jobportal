<?php
include('root.php');
include($root.'include/file_include.php');
$pm_id=$_GET['pmid'];
//   List down all Agencies
 $qry_agency = "SELECT * FROM ".$tblprefix."agency WHERE pm_id=".$pm_id;
 $rs_agency = $db->Execute($qry_agency);
 $count_agency =  $rs_agency->RecordCount();
 $totalagency = $count_agency;
?>

<div id="get_agency">
<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
<?php
if($totalagency<=0){?>
<option value="0">Select Car Agency</option>
<?php
}else{?>
<option value="0">Select Car Agency</option>	
	<?php while(!$rs_agency->EOF){
				
				$is_cat_selected = '';
				if($rs_agency->fields['agn_id']==$id){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_agency->fields['agn_id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_agency->fields['agn_name'] ;?></option>
	<?php $rs_agency->MoveNext();
	}
	}
?>
</select>
</div>







<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$property_name=$_GET['property_id'];
	    $qry_content = "SELECT id,property_name FROM  ".$tblprefix."properties WHERE pm_id=".$id." AND pm_type=0";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
		
<div id="property_name1"> 
	
<select name="pr_id" class="fields" id="pr_id" onchange="get_room_type2('room_type1', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type11_11.php"?>')">
<?php
if($count_add<=0){?>
<option value="0">Izaberite objekat</option>
<?php
}else{?>
<option value="0">Izaberite objekat</option>	

<?php 
	     $rs_content->MoveFirst();
		 while(!$rs_content->EOF){
?>
<option value="<?php echo $rs_content->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_content->fields['property_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    }
?>
</select>
</div>
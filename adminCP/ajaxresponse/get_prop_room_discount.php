<?php
include('root.php');
include($root.'include/file_include.php');
if(isset($_GET['pm_id'])){
	$pm_id=$_GET['pm_id'];
	$propid=$_GET['propid'];
    $qry_content = "SELECT * FROM  ".$tblprefix."rooms WHERE pm_id=".$pm_id." and property_id =".$propid;
	
	$rs_content = $db->Execute($qry_content);
	$count_add =  $rs_content->RecordCount();
?>
    <div id="rooms_id1">		
        <select name="property_id" class="fields" id="property_id" onChange="get_discount_management('get_prop_room_discount',this.value,<?php echo $propid;?>,<?php echo $pm_id;?>, '<?php echo MYSURL."ajaxresponse/get_discount_management.php"?>')">
        <?php
        if($count_add<=0){?>
        <option value="0">Izaberite sobu</option>
        <?php
        }else{?>
        <option value="0">Izaberite sobu</option>	
            <?php while(!$rs_content->EOF){
        ?>
        <option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['room_type'] ;?></option>
            <?php $rs_content->MoveNext();
            }
            }
        ?>
        </select>	
    </div>
<?php } ?>

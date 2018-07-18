<?php
	include('root.php');
	include($root.'include/file_include.php');
if(isset($_GET['pm_id'])){
	
	$pm_id		=$_GET['pm_id'];
	$propid		=$_GET['propid'];
	$room_id	= $_GET['rooms_id1'];	
	
    
	$qry_content = "SELECT * FROM  ".$tblprefix."rooms 
					WHERE pm_id=".$pm_id." and property_id =".$propid;	
	$rs_content = $db->Execute($qry_content);
	$count_add =  $rs_content->RecordCount();
?>
    <div id="rooms_id1">		
        <select name="room_id" class="fields" id="room_id" onChange="get_manage_bedding('get_prop_bedding_types',this.value,<?php echo $propid;?>,<?php echo $pm_id;?>, '<?php echo MYSURL."ajaxresponse/get_manage_bedding.php"?>')">
        <?php
        if($count_add<=0){?>
        <option value="0">Izaberite objekat</option>
        <?php
        }else{?>
        <option value="0">Izaberite objekat</option>	
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

<?php
$id=base64_decode($_GET['id']); 

 $qry_limit = "SELECT mi.*,pm.id as pid,pm.first_name,pr.id as prid,pr.property_name  
               FROM `tbl_mediaimages` as mi INNER JOIN ".$tblprefix."properties as pr ON pr.id=mi.property_id 
			   LEFT JOIN ".$tblprefix."rooms ON ".$tblprefix."rooms.id = mi.room_id  
			   INNER JOIN ".$tblprefix."property_manager as pm ON pm.id=mi.pm_id 
			   WHERE mi.id=".$id;

$rs_limit = $db->Execute($qry_limit);
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$qry_property = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
					AND ".$tblprefix."properties.pm_type=1
					AND ".$tblprefix."properties.property_category=24";
}else {
$qry_property = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties WHERE pm_id=".$rs_limit->fields['pm_id']." 
					AND ".$tblprefix."properties.pm_type=1 
					AND ".$tblprefix."properties.property_category=24";
}

$rs_property = $db->Execute($qry_property);
 
 $qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
							".$tblprefix."properties.property_name ,
							".$tblprefix."properties.pm_type ,
							".$tblprefix."properties.property_category 
							FROM ".$tblprefix."property_manager 
							INNER JOIN	 ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
							WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
							GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_limit = $db->Execute($qry_limit);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading" colspan="2">Edit Image media Section &nbsp;[Izmjeni]</td>
 	</tr>
 	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
	<tr>
	<td class="txt1">Propery Manager</td>
	<td>
	<select name="first_name" class="dropfields" id="first_name" onchange="get_media_pn_online('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_media_pn_online.php"?>')">
	<option value="0">Izaberite vlasnika objekta</option>
<?php while(!$rs_property_manag->EOF){
?>	<option value="<?php echo $rs_property_manag->fields['id'];?>" 
		    <?php
			 if($rs_property_manag->fields['id']== $rs_limit->fields['pm_id'] ){
			 echo 'selected="selected"';
			 }
			 ?>><?php echo $rs_property_manag->fields['first_name']." ".$rs_property_manag->fields['last_name'];?>
			</option>
	        <?php $rs_property_manag->MoveNext();
			} ?>			
			</select>					
			</td>
			</tr>
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
			<td class="txt1"> Property Name</td>
			<td>
			<select name="property_id" class="dropfields" id="property_id">
			<?php
				while(!$rs_property->EOF){
				if($rs_property->fields['id']==$rs_limit->fields['property_id']){
				$property_name_dd_selected_id = $rs_property->fields['id'];
				$sel='selected="selected"';
				}else{
				$sel='';
				}
            ?>
            <option <?php echo $sel; ?> value="<?php echo $rs_property->fields['id'];?>"><?php echo $rs_property->fields['property_name'];  ?></option>
                <?php
                $rs_property->MoveNext();
                }?>		
			</select>
			</td>
			</tr>
			<?php } else {?>
			<tr>
			<td class="txt1">Property Name</td>
			<td>
			<div id="property_name">
			<select name="property_id" class="dropfields" id="property_id" onchange="get_room_media('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_media.php"?>')" >
			<option value="0">Izaberite vlasnika objekta</option>
				<?php  
				while(!$rs_property->EOF){
                if($rs_property->fields['id']==$rs_limit->fields['property_id']){
                    $property_name_dd_selected_id = $rs_property->fields['id'];
                    $sel='selected="selected"';
                }else{
                    $sel='';
                }
                ?>
<option <?php echo $sel; ?> value="<?php echo $rs_property->fields['id'];?>"><?php echo $rs_property->fields['property_name'];  ?></option>
				<?php
                $rs_property->MoveNext();
                }?>		
			</select>
			</div>
				</td>
				</tr>
				<?php }?>
			<tr>
	        <td class="txt1">
  			Room/Property Type<br/>[Tip sobe/objekta]
		   	</td>
			<td>
			 
			<?php 
            //Room type dropdown
                $qry_region = "SELECT * FROM ".$tblprefix."rooms
							   WHERE property_id = " . $property_name_dd_selected_id; 
                $rs_region = $db->Execute($qry_region);
                $count_region =  $rs_region->RecordCount();
                $totalRegions = $count_region;
            ?>		
			
	<div id="room_id">
			<select name="room_id" class="dropfields" >
			  <option value="0000">All Rooms</option>
			  <?php 
					while(!$rs_region->EOF){ 
						if($rs_region->fields['id']==$rs_limit->fields['room_id']){
							$sel = 'selected="selected"';
						}else{
							$sel='';
						}
						echo '<option '.$sel.' value="'.$rs_region->fields['id'].'">'.$rs_region->fields['room_type'].'</option>';
					$rs_region->MoveNext();
					}
				?> 
			
			</select>
      </div>
			</td>
        </tr>	
				
				<tr>
				<td class="txt1">TitleTitle<br/>[naziv]</td>
		<td><input type="text" name="image_title" class="fields" value="<?php echo $rs_limit->fields['image_title']; ?>" /></td>
		</tr>
		
		
		<tr>
        	<td class="txt1">Image<br/>[sliku]</td>
			<td>
			<input type="file" name="image" class="fields" />
            	<!--imge will come here-->
                <?php 
					  if($rs_limit->fields['image_full_path']!=NULL){
					   ?>
					   
					   <img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['image_full_path']; ?>&w=50&h=40&zc=1" border="0">	

					   <?php 
					  }
					  
					  ?>
            	<!--imge upto here-->
			</td>
           
        </tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:180px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Image &nbsp;[Upload slike]" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="mediaimages">
		<input type="hidden" name="act2" value="editmediaimages">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['image_name']; ?>" />
		<input type="hidden" name="request_page" value="media_upload" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


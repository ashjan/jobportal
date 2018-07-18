<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT mv.*,pm.id as pid,pm.first_name,pr.id as prid,pr.property_name  FROM `".$tblprefix."mediaivideos` as mv INNER JOIN ".$tblprefix."properties as pr ON pr.id=mv.property_id INNER JOIN tbl_users as pm ON pm.id=mv.pm_id where mv.id=".$id;

$rs_limit = $db->Execute($qry_limit);
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$qry_property = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND pm_type=1"; 
}else {
$qry_property = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties WHERE pm_type=1"; 
}

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
 $qry_property_manag = "SELECT
                    ".$tblprefix."users.id,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name
					FROM
					".$tblprefix."users"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_limit = $db->Execute($qry_limit);

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$qry_property = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND pm_type=1"; 
}else {
$qry_property = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties WHERE pm_id=".$rs_limit->fields['pm_id']." AND pm_type=1"; 
}
$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Video Section</td>
 	</tr>
 	<tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
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
	<select name="first_name" class="dropfields" id="first_name" onchange="get_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
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
			<select name="property_id" class="dropfields" id="property_id" onchange="get_room_type1('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type12.php"?>')">
            <option value="0">Select Property</option>
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
            
            <!--Select All Room Start-->
            
            
            
            <!--ALL Room Ends -->
            
            
			<tr>
			<td class="txt1">Property Name</td>
			<td>
			<div id="property_name">
			<select name="property_id" class="dropfields" id="property_id" onchange="get_room_type1('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type12.php"?>')">
			<option value="0">Izaberite vlasnika objekta</option>
			<?php  while(!$rs_property->EOF){
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
                
                <tr><td class="txt1">
                <!--room type dropdown start from here-->
    
  	<div class="image_div_title">Room/Property Type</div></td>
	<td class="txt1"><div class="image_div_title_text">
	 <div id="room_id">
			<select name="room_id" class="dropfields" >
			  <option value="0">All Rooms</option>
              
			</select>
     </div>
      </div>
	<div class="clear"></div>	
	
     <!--room type dropdown upto here-->
                </td></tr>
                
                
				<tr>
				<td class="txt1">Title</td>
		<td><input type="text" name="video_title" class="fields" value="<?php echo $rs_limit->fields['video_title']; ?>" /></td>
		</tr>
		<br />
		
		<tr>
        	<td class="txt1">Video</td>
			<td>
			<input type="file" name="video" class="fields" /> <br /><br />
            	<!--imge will come here-->
               
			   
			   <!--video div-->
                  <!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE -->
				  
	<?php 
					  if($rs_limit->fields['video_full_path']!=NULL){
					   ?>
					   
	<div id="mediaplayer_<?php echo $rs_limit->fields['id']; ?>"></div>
	<script type="text/javascript" src="<?php echo MYSURL; ?>media/videos/jwplayer.js"></script>
	<script type="text/javascript">
		jwplayer("mediaplayer_<?php echo $rs_limit->fields['id']; ?>").setup({
			flashplayer: "<?php echo MYSURL; ?>media/videos/player.swf",
			file: "<?php echo $rs_limit->fields['video_full_path']; ?>",
			image: "<?php echo MYSURL; ?>media/videos/preview.jpg",
			width:150,
			height:100
		});
	</script>
			   
			   
			   <?php 
					  }
					  
					  ?>
			   
			   
			    
					   
					 <!-- <video height="100" src="<?php //echo $rs_limit->fields['video_full_path']; ?>" width="200" controls>-->
  <a href="/static/bunny.mp4">Download the video</a> for local playback.
</video> 

					   
            	<!--imge upto here-->
			</td>
           
        </tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Video" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="mediaivideos">
		<input type="hidden" name="act2" value="editmediavideos">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_video" value="<?php echo $rs_limit->fields['video_name']; ?>" />
		<input type="hidden" name="request_page" value="media_upload" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


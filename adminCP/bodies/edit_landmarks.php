<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$id=base64_decode($_GET['id']);


	$qry_regions = "SELECT * from ".$tblprefix."property_regions";  
	$rs_regions = $db->Execute($qry_regions);
	
	$qry_lndmaktyp = "SELECT * from ".$tblprefix."landmark_type";  
	$rs_lndmaktyp = $db->Execute($qry_lndmaktyp);
	
	$qry_limit = "SELECT * FROM ".$tblprefix."landmarks WHERE id=".$id;
	$rs_limit = $db->Execute($qry_limit);

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Landmarks</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	
	
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber" style="display:block;">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >		
	
			
			
			<tr>
	        <td class="txt2">
  			Region
		   	</td>
			<td>
				
					<?php if(!empty($_SESSION['add_sees']['region_id'])){ ?>
				
				
				<select name="region_id" class="fields" id="region_id" onchange="">
				 	<option value="0"></option>
					<?php
					$rs_regions->MoveFirst();
					while(!$rs_regions->EOF){
										?>
			
			<option value="<?php echo $rs_regions->fields['id'];?>"
					<?php 
					if($rs_regions->fields['id'] == $_SESSION['add_sees']['region_id'])
					{
						 echo 'selected="selected"';
					}
					?>
					 ><?php echo $rs_regions->fields['region_name'];  ?></option>
					<?php
					$rs_regions->MoveNext();
					}
					?>			
					</select>
												
			<?php }else{ ?>
									
			
			<select name="region_id" class="fields" id="region_id" onchange="">
				 	<option value="0">Select Region</option>
					<?php
					$rs_regions->MoveFirst();
					while(!$rs_regions->EOF){
										?>
				<option value="<?php echo $rs_regions->fields['id'];?>"
					<?php 
					if($rs_regions->fields['id'] == $rs_limit->fields['region_id'])
					{
						 echo 'selected="selected"';
					}
					?>
					 ><?php echo $rs_regions->fields['region_name'];  ?></option>
					<?php
					$rs_regions->MoveNext();
					}
					?>			
					</select>
			
			<?php } ?>
			
			
			
			
			</td>
        </tr>                    
        <tr>
	        <td class="txt2">
  			Landmark Name
		   	</td>
			<td><!--<input type="text" name="landmark_name" class="fields" value="<?php //echo $rs_limit->fields['landmark_name'];?>" />-->
       
	   
	   
	   <?php if(!empty($_SESSION['add_sees']['landmark_name'])){ ?>
					
			<input type="text" name="landmark_name" class="fields" value="<?php echo $_SESSION['add_sees']['landmark_name']; ?>" />	<?php }else{ ?>
			
			<input type="text" name="landmark_name" class="fields" value="<?php echo $rs_limit->fields['landmark_name']; ?>" /> <?php } ?>
	   
	   </td>
	   
	    </tr>
		<tr>
	        <td class="txt2">
  			Landmark Type
			</td>
			<td>
			
			<?php if(!empty($_SESSION['add_sees']['landmark_type'])){ ?>
				
				
				<select name="landmark_type" class="fields" id="landmark_type" onchange="">
				 	<option value="0">Select Landmark Type</option>
					<?php
					$rs_lndmaktyp->MoveFirst();
					while(!$rs_lndmaktyp->EOF){
										?>
			
			<option value="<?php echo $rs_lndmaktyp->fields['id'];?>"
					<?php 
					if($rs_lndmaktyp->fields['id'] == $_SESSION['add_sees']['landmark_type'])
					{
						 echo 'selected="selected"';
					}
					?>
					 ><?php echo $rs_lndmaktyp->fields['landmark_type_name'];  ?></option>
					<?php
					$rs_lndmaktyp->MoveNext();
					}
					?>			
					</select>
												
			<?php }else{ ?>
									
			
			<select name="landmark_type" class="fields" id="landmark_type" onchange="">
				 	<option value="0">Select Landmark Type</option>
					<?php
					$rs_lndmaktyp->MoveFirst();
					while(!$rs_lndmaktyp->EOF){
										?>
				<option value="<?php echo $rs_lndmaktyp->fields['id'];?>"
					<?php 
					if($rs_lndmaktyp->fields['id'] == $rs_limit->fields['landmark_type'])
					{
						 echo 'selected="selected"';
					}
					?>
					 ><?php echo $rs_lndmaktyp->fields['landmark_type_name'];  ?></option>
					<?php
					$rs_lndmaktyp->MoveNext();
					}
					?>			
					</select>
			
			<?php } ?>
			
			
			</td>
        </tr>
		<tr>
	        <td class="txt2">
  			Landmark Latitude
		   	</td>
			<td>
			<!--<input type="text" name="landmark_lat" class="fields" value="<?php //echo $rs_limit->fields['landmark_lat'];?>" />-->
			
			
			
			
			
			<?php if(!empty($_SESSION['add_sees']['landmark_lat'])){ ?>
					
			<input type="text" name="landmark_lat" class="fields" value="<?php echo $_SESSION['add_sees']['landmark_lat']; ?>" />	<?php }else{ ?>
			
			<input type="text" name="landmark_lat" class="fields" value="<?php echo $rs_limit->fields['landmark_lat']; ?>" /> <?php } ?>
			
			
			
			
			
			</td>
        </tr>
		
		
		<tr>
	        <td class="txt2">
  			Landmark Longtitude
		   	</td>
			<td>
			
			<?php if(!empty($_SESSION['add_sees']['landmark_long'])){ ?>
					
			<input type="text" name="landmark_long" class="fields" value="<?php echo $_SESSION['add_sees']['landmark_long']; ?>" />	<?php }else{ ?>
			
			<input type="text" name="landmark_long" class="fields" value="<?php echo $rs_limit->fields['landmark_long']; ?>" /> <?php } ?>
			
			<!--
			<input type="text" name="landmark_long" class="fields" value="<?php //echo $rs_limit->fields['landmark_long'];?>" />-->
			</td>
        </tr>
		
		<tr>
	        <td class="txt2">
  			Landmark Status
		   	</td>
			<td>
			
			
		<?php	
			if(!empty($_SESSION['add_sees']['landmark_status'])){ ?>
					
				<select name="landmark_status" class="fields">
				<option value="1"<?php if($_SESSION['add_sees']['landmark_status']=='1')echo 'selected="selected"'; ?>>Yes</option>
				<option value="0" <?php if($_SESSION['add_sees']['landmark_status']=='0')echo 'selected="selected"'; ?>>No</option>
			</select>
				
				<?php }else{ ?>
				
				<select name="landmark_status" class="fields">
				<option value="1"<?php if($rs_limit->fields['landmark_status']=='1')echo 'selected="selected"'; ?>>Yes</option>
				<option value="0" <?php if($rs_limit->fields['landmark_status']=='0')echo 'selected="selected"'; ?>>No</option>
			</select>
				
			
			
			 <?php } ?>
			
			
			
			</td>
        </tr>
			
		
				<!--  changes ends here -->
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
	<?php	unset($_SESSION['add_sees']); ?>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_landmarks">
		<input type="hidden" name="act2" value="manage_landmarks">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="request_page" value="landmarks_management" />
</form> 

  </div>  
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  
</table>
<?php //echo $where;?>

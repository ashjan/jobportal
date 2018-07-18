<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."property_facilities WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

//Dropdown for parent 
$category_qry = "select * from ".$tblprefix."users ";
$rs_category = $db->Execute($category_qry);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Facility Management Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
        
		
		<tr>
				<td class="txt2">Select Property Manager:</td>
					<td>
					
					
					
					<select name="pm_id" class="fields" id="pm_id">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>"
					<?php
					if($rs_category->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?></option>
					<?php
					$rs_category->MoveNext();
					}
					?>			
					</select>					
					
					
					</td>
				</tr>
		<tr>
	        <td>
  			Facility Name
		   	</td>
			<td>
			
			
			
			
			
			<?php 
			if(!empty($_SESSION[facility_name])){ ?>
			<input type="text" name="facility_name" id="facility_name" value="<?php echo $_SESSION['facility_name']; ?>" />
						<?php }else{ ?>
						<input type="text" name="facility_name" id="facility_name" value="<?php echo $rs_limit->fields['facility_name']; ?>" />
						
						<?php } ?>
			
			</td>
        </tr>                    
   <tr>
		<tr><td>Kategorija sadr&#382;aja</<br />
			   <td>
			   <?php 
			   if(!empty($_SESSION['property_fac_category'])){ ?> 
			   <?php $opt= $_SESSION['property_fac_category']; ?>
			   <select name="property_fac_category" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>Select Category</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>General</option>
				<option value="2" <?php if($opt ==2){ ?> selected="selected" <?php } ?>>Activities</option>
				<option value="3" <?php if($opt == 3){ ?> selected="selected" <?php } ?>>Services</option>
				</select>
				<?php }else{ ?>
				<?php $opt=$rs_limit->fields['property_fac_category']; ?>
				<select name="property_fac_category" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>Select Category</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>General</option>
				<option value="2" <?php if($opt ==2){ ?> selected="selected" <?php } ?>>Activities</option>
				<option value="3" <?php if($opt == 3){ ?> selected="selected" <?php } ?>>Services</option>
				</select>
				<?php } ?>
			   
				</td>
				<tr>
				<tr><td>Facility Status</<br />
			   <td>
			   <?php 
			   if(!empty($_SESSION['property_status'])){ ?> 
			   
			   
			   <?php $opt= $_SESSION['property_status']; ?>
			   <select name="property_status" id="<?php echo $rs_limit->fields['id']; ?>">
				
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>No</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Yes</option>
				</select>
				<?php }else{ ?>
				
				<?php $opt=$rs_limit->fields['property_status']; ?>
						<select name="property_status" id="<?php echo $rs_limit->fields['id']; ?>">
				
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>No</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Yes</option>
				
				</select>
				<?php } ?>
			   
			   
				
				</td></td>
				<!--<tr>
		
					<td class="fieldheading"> Facility Icon: </td>
					 <td>
					  <input type="file" name="facility_icon" class="fields" id="facility_icon" /> 
					  <?php 
					 //if($rs_limit->fields['facility_icon']!=NULL){
					   ?>
					   
					   <img src="<?php //MYSURL ?>graphics/facility_upload/<?php //echo $rs_limit->fields['facility_icon']; ?>" width="100" height="50" />	

					   <?php 
					  //}
					  
					  ?>
					  
                     </td>
		      </tr>-->
             <tr></tr>  
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Facility" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="manage_facility" />
			<input type="hidden" name="request_page" value="facility_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<!--<input type="hidden" name="old_image" value="<?php //echo $rs_limit->fields['facility_icon']; ?>" />-->
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."property_accommodation WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);




$qry_manage = "SELECT * FROM ".$tblprefix."property_category as pc";
$rs_property_manag = $db->Execute($qry_manage);



$qry_facility = "SELECT * FROM ".$tblprefix."property_facilities"; 
$rs_facility = $db->Execute($qry_facility);
$totalcountalfacility =  $rs_facility->RecordCount();

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Property Types</td>
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
				<td class="txt1">Property Category</td>
				<td>
				<!--<input type="text" name="price_period" id="price_period" class="price_period" value="" >-->
				<!--***********************************************************-->
				<select name="property_cat" class="fields" id="property_cat">
				 	<option value="">Select Category facility</option>
					<?php $rs_property_manag->MoveFirst();
					while(!$rs_property_manag->EOF){$is_manager_selected = '';
						if($rs_property_manag->fields['id']==$rs_limit->fields['property_cat']){
							   $is_manager_selected = 'selected="selected"';
							}else{
							   $is_manager_selected = '';
							}
					 ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>"  
					<?php echo $is_manager_selected; ?>><?php echo $rs_property_manag->fields['property_category_name'];?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
				</select>
		</td>
		<tr>
	        <td>
  			Business Type(English)
		   	</td>
			<!--<td><input type="text" name="accomm_name" class="fields" id="accomm_name" value="" /></td> --> 
				<td>
				<?php 
			if(!empty($_SESSION['accomm_name'])){ ?> 
				<input name="accomm_name" id="accomm_name" value="<?php echo $_SESSION['accomm_name']; ?>" type="text" class="fields" size="35"  maxlength="30" />
			<?php	}else{ ?>
				<input name="accomm_name" id="accomm_name" value="<?php echo $rs_limit->fields['accomm_name']?>" type="text" class="fields" size="35"  maxlength="30" />
				<?php } ?>
				</td>
		</tr>   
		
		<?php 
				if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
                // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				
					$language_qry = "SELECT id,
					language_id,
					page_id,
					field_name,
					translation_text,
					translated_text,
					fld_type 
					FROM 
					".$tblprefix."language_contents 
					WHERE   
					language_id=".$language_id." 
					AND page_id='".$id."'  
					AND field_name='business_title' 
					AND fld_type='business_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
//			echo '<tr>
//			<td class="txt1">Business Type('.$rs_language->fields['Lan_name'].') </td>
//			<td >
//			<input  class="fields" name="accomm_name_'.$rs_language->fields['id'].'" id="accomm_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
//			</td>
//			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		
		
		
		
		               
              
      <tr>
				<td class="txt1">Price Period</td>
				<td>
				<!--<input type="text" name="price_period" id="price_period" class="price_period" value="" >-->
<select class="dropfields"  name="price_period" id="price_period">
<option value="0" <?php if($rs_limit->fields['price_period']==0){ echo 'selected="selected"';} ?>>Select Price Period</option> 
<option value="1" <?php if($rs_limit->fields['price_period']==1){ echo 'selected="selected"';} ?>>Price Per Night</option> 
<option value="2" <?php if($rs_limit->fields['price_period']==2){ echo 'selected="selected"';} ?>>Price Per Week</option>
<option value="3" <?php if($rs_limit->fields['price_period']==3){ echo 'selected="selected"';} ?>>Price Per Month</option>
</select>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Per Person</td>
				<td>
				<div class="fields_checked">
			<input  type="radio" name="per_person"  id="per_person_no" value="0" 
			<?php 
			if($rs_limit->fields['per_person']==0)
			{ 
			echo 'checked="checked"';
			} 
			?>>
			<span>No</span>
			<input type="radio" name="per_person" 
			<?php 
			if($rs_limit->fields['per_person']==1)
			{ 
			echo 'checked="checked"';
			} 
			?> id="per_person_yes" value="1" ><span>Yes</span>
				</div>
			    </td> 
   </tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:260px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Accommodation" class="button"  />
			</td>
        </tr>
		</table>
		
			<?php $_SESSION['accomm_name'] = ''; ?>
			<input type="hidden" name="act" value="editaccomm" />
			<input type="hidden" name="act2" value="manage_accomodation" />
			<input type="hidden" name="request_page" value="accomodation_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


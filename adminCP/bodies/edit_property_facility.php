<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."facility_management WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

?>



<div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Facility Name(English)<br/>[Naziv sad]</td>
				<td>
				<input type="text" name="facility_name" class="fields"  id="facility_name" value="<?php echo $rs_limit->fields['facility_name']; ?>"  />
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
					AND field_name='facility_title' 
					AND fld_type='facility_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
			echo '<tr>
			<td class="txt1">Facility Name('.$rs_language->fields['Lan_name'].') </td>
			<td >
			<input  class="fields" name="facility_name_'.$rs_language->fields['id'].'" id="facility_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
				
				<tr>
				<td class="txt1">Facility Category Type<br/>[Izaberite kategoriju sadr&#382;aja]</td>
				<td>
				
				<select name="property_fac_category" class="fields"   id="property_fac_category">
				<option value="0">Select Category<?php echo $rs_limit->fields['property_fac_category'];  ?></option>
				<option <?php if($rs_limit->fields['property_fac_category']==1){ echo 'selected="selected"';}  ?> value="1">General</option>
				<option <?php if($rs_limit->fields['property_fac_category']==2){ echo 'selected="selected"';}  ?> value="2">Activities  </option>
				<option <?php if($rs_limit->fields['property_fac_category']==3){ echo 'selected="selected"';}  ?> value="3">Services</option>		
			</select>
				
 				</td> 
				</tr>
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:200px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Update Facility &nbsp;[A&#382;uriraj sadr&#382;aj]" class="button" />
                </td>
                </tr>
</table>				
</div>

<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_property">
		<input type="hidden" name="act2" value="manage_property_facility">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="property_facility_management" />
	
					</td>
				</tr>
                
</form> 

  </div>
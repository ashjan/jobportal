<?php
$id=base64_decode($_GET['id']);

$qry_facility = "SELECT * FROM ".$tblprefix."property_facilities"; 
$rs_facility = $db->Execute($qry_facility);
$totalcountalfacility =  $rs_facility->RecordCount();



//   List down all catgegories 

$qry_category      = "SELECT * FROM ".$tblprefix."property_category" ;
$rs_property_manag = $db->Execute($qry_category);
$count_cat         =  $rs_property_manag->RecordCount();
$totalCategories   = $count_cat;




//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;



$qry_business_subtype = "SELECT 
                         ".$tblprefix."business_subtype.id,
						 ".$tblprefix."business_subtype.business_subtype,
						 ".$tblprefix."business_subtype.business_type_id,
						 ".$tblprefix."business_subtype.business_category_id, 
						 ".$tblprefix."property_accommodation.accomm_name, 
						 ".$tblprefix."property_category.property_category_name 
						 FROM ".$tblprefix."business_subtype 
						 INNER JOIN ".$tblprefix."property_accommodation ON ".$tblprefix."property_accommodation.id=".$tblprefix."business_subtype.business_type_id 
						 INNER JOIN ".$tblprefix."property_category ON ".$tblprefix."property_category.id=".$tblprefix."business_subtype.business_category_id WHERE ".$tblprefix."business_subtype.id=".$id; 
$rs_business_subtype = $db->Execute($qry_business_subtype);


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();



?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Business Subtype</td>
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
		<td>
  		Property Category
		</td>
			<td >
	<select name="business_category_id" id="business_category_id"  class="dropfields"  onchange="get_business_subtype('business_type_id', this.value, '<?php echo MYSURL."ajaxresponse/get_business_type.php"?>')">
	  <option value="0">Select  Category</option>
	  <?php while(!$rs_property_manag->EOF)
	  {  $is_manager_selected = ''; 
		 if($rs_property_manag->fields['id']==$rs_business_subtype->fields['business_category_id'])
		 $is_manager_selected='selected="selected"';
		 ?>
		<option value="<?php echo $rs_property_manag->fields['id'];?>" 
		<?php echo $is_manager_selected; ?>><?php echo $rs_property_manag->fields['property_category_name'];?>
		</option>
	    <?php $rs_property_manag->MoveNext();
		} ?>			
	</select>
			</td>
        </tr>
		
		
			
		<tr>
		<td>
  			Business Type
		</td>
			<td >
			<div id="business_type_id">
	<select name="business_type_id" class="dropfields"   id="business_type_id">
		<option value="0">Select Business Type</option>
		 <?php 
		 while(!$rs_accommodation->EOF)
		 {$is_manager_selected = ''; 
		 if($rs_accommodation->fields['id']==$rs_business_subtype->fields['business_type_id'])
		 $is_manager_selected='selected="selected"';
		 ?>
		<option value="<?php echo $rs_accommodation->fields['id'];?>" 
		<?php echo $is_manager_selected; ?>><?php echo $rs_accommodation->fields['accomm_name'];?>
		</option>
	    <?php $rs_accommodation->MoveNext();
		} ?>			
	</select>
			</div>
			</td>
        </tr>
		
		
		
		<tr>
			<td>
  			Business Subtype(English)
			</td>
			<td >
			<input name="business_subtype" id="business_subtype" value="<?php echo $rs_business_subtype->fields['business_subtype']?>" type="text" class="fields" size="35"  maxlength="30" />
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
					AND field_name='business_subtype_title' 
					AND fld_type='business_subtype_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
			echo '<tr>
			<td class="txt1">Business Subtype('.$rs_language->fields['Lan_name'].') </td>
			<td >
			<input  class="fields" name="business_subtype_'.$rs_language->fields['id'].'" id="business_subtype_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		
		
		
			
		<tr><td>
		
			<input style="margin:5px; width:150px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Edit Business Subtype" class="button"  align="middle"/>
			</td>
        </tr>
		
		</table>
		
			<?php //$_SESSION['business_subtype'] = ''; ?>
			<input type="hidden" name="act" value="edit_business_subtype" />
			<input type="hidden" name="act2" value="business_subtype" />
			<input type="hidden" name="request_page" value="business_subtype_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


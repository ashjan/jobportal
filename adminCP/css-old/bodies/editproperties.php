<?php
$id=base64_decode($_GET['id']);
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' AND pr.pm_id = '.$_SESSION[SESSNAME]['pm_id']." 
						 AND pr.pm_type=1";
}else{
	$module_pm_where = ' AND pr.pm_type=1';
}

$qry_limit = "SELECT pr.*,pm.id as pid,pm.first_name,pm.last_name
              FROM `tbl_properties` as pr  
			  INNER JOIN tbl_property_manager as pm ON pm.id=pr.pm_id 
			  WHERE pr.id=".$id." $module_pm_where ";

$rs_limit = $db->Execute($qry_limit);
$qry_pmsel = "SELECT * FROM ".$tblprefix."property_manager where id =".$rs_limit->fields['pm_id']." $module_pm_where ";
$rs_pmsel = $db->Execute($qry_pmsel);

//List down all regions
$qry_region = "SELECT * FROM ".$tblprefix."property_regions" ;
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;

$qry_regionsel = "SELECT * FROM ".$tblprefix."property_regions WHERE id = '".$rs_limit->fields['region']."' " ;
$rs_regionsel = $db->Execute($qry_regionsel);


//List down all features
$qry_feature = "SELECT * FROM ".$tblprefix."property_features" ;
$rs_feature = $db->Execute($qry_feature);
$count_feature =  $rs_feature->RecordCount();
$totalFeature = $count_feature;

//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation WHERE ".$tblprefix."property_accommodation.property_cat=24" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;

//   List down all Project Manager

//   List Room Types
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$qry_pm = "SELECT * FROM ".$tblprefix."property_manager WHERE id = ".$_SESSION[SESSNAME]['pm_id'];
}else{
	$qry_pm = "SELECT ".$tblprefix."property_manager.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
}


$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;

//   List down all Property category
$qry_category = "SELECT * FROM ".$tblprefix."property_category " ;
$rs_category = $db->Execute($qry_category);
$count_property_category =  $rs_category->RecordCount();
$totalCategory = $count_property_category;

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();



//   List down all Language
$qry_lang = "SELECT * FROM ".$tblprefix."language" ;
$rs_lang = $db->Execute($qry_lang);
$count_lang =  $rs_lang->RecordCount();
$totalPM = $count_lang;

//   List Business Sub  Types

/*$qry_sub_type = "SELECT * FROM ".$tblprefix."business_subtype WHERE business_type_id=".$rs_limit->fields['business_type']; */$qry_sub_type = "SELECT * FROM ".$tblprefix."business_subtype WHERE ".$tblprefix."business_subtype.business_category_id=24";
$rs_sub_type = $db->Execute($qry_sub_type);
$count_sub_type =  $rs_sub_type->RecordCount();
$totalsubtype = $count_sub_type;



//   List Room Types
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$qry_roomtype = "SELECT * FROM ".$tblprefix."rooms WHERE pm_id = ".$_SESSION[SESSNAME]['pm_id'];
}else{
	$qry_roomtype = "SELECT * FROM ".$tblprefix."rooms ";
}

$rs_roomtype = $db->Execute($qry_roomtype);
$count_room_type =  $rs_roomtype->RecordCount();
$totalRoomTypes = $count_room_type;
?>
<script language="javascript">
$(document).ready(function() {
	$("#txtboxToFilter").keydown(function(event) {
		// Allow only backspace and delete
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
			// let it happen, don't do anything
		}
		else {
			// Ensure that it is a number and stop the keypress
			if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault();
			}
		}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
			$("#no_property_roomss").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Properties &nbsp;[Podešavanje objekta] </td>
 	</tr>
	
	<tr>
  		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td>
	<form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data" accept-charset="utf-8" >
			<table width="100%"  align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
		<tr>
<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Property Owner</td>
		</tr>
		
		<?php
		if($_SESSION[SESSNAME]['pm_moduleid']==2){
			?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
		    <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
		  </td>
		  </tr>
		  <?php
		}else{
			?>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Property Manager<br/>[vlasnika objekta]
		   	</td>
			<td style="border-right:1px solid #999999;">
			
			
			
			<select name="first_name" class="fields"   id="first_name" >
				<?php 
				while(!$rs_pm->EOF){
					?>
					<option value="<?php echo $rs_pm->fields['id'];?>"
					<?php 
					if($rs_pm->fields['id'] == $rs_limit->fields['pm_id']){
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'] ;?>								 	  				</option>
					<?php
					$rs_pm->MoveNext();
				}
				?>					
			</select>				
			</td>
        </tr>
		<?php } ?>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Property Category<br/>[Izaberite objekta]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<select name="property_category" class="fields"   id="property_category" onchange="get_accommadation('business_type', this.value, '<?php echo MYSURL."ajaxresponse/get_accommadation.php"?>')">
				<?php 
				while(!$rs_category->EOF){
					?>
					<option value="<?php echo $rs_category->fields['id'];?>"
					<?php 
					if($rs_category->fields['id'] == $rs_limit->fields['property_category']){
						echo 'selected="selected"';
					}
					?>><?php echo $rs_category->fields['property_category_name'];?></option>
					<?php
					$rs_category->MoveNext();
				}
				?>					
			</select>					
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999; border-bottom:0px solid #999999;">
  			Business Type<br/>[Vrsta objekta]
		   	</td>
			<td style="border-right:1px solid #999999; border-bottom:0px solid #999999;">
			
			<div id="business_type">
			<select name="business_type" class="fields"   id="business_type" onchange="get_businesssubtype('business_subtype', this.value,'<?php echo MYSURL."ajaxresponse/get_businesssubtype.php"?>')">
			 
			<?php $bzi_type = stripslashes($rs_limit->fields['business_type']); ?>
			
			<?php 
			while(!$rs_accommodation->EOF){
			?>
			<option value="<?php echo $rs_accommodation->fields['id'];?>"
			<?php
			if($rs_accommodation->fields['id'] == $bzi_type){
				echo 'selected="selected"';
			}
			?>><?php echo $rs_accommodation->fields['accomm_name'];?></option>
			<?php
			$rs_accommodation->MoveNext();
			}
			?>					
			</select>
			</div>
			</td>
        </tr>
			<tr>
	        <td style="border-left:1px solid #999999; border-bottom:1px solid #999999;">
  			Business Sub Type<br/>[Podvrsta objekta]
            </td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<div id="business_subtype">
			<select name="business_subtype" class="fields"   id="business_subtype">
				<option value="0">Izaberite podvrstu objekta</option>
				<?php 
				if($rs_accommodation->fields['id']==24){
					echo '<option value="0">select</option>';
				}else{
					$rs_sub_type->MoveFirst();
					while(!$rs_sub_type->EOF){
					?>
					<option value="<?php echo $rs_sub_type->fields['id'];?>"
					<?php
					$business_subtype= (int) $rs_limit->fields['business_subtype'];
					if($rs_sub_type->fields['id'] == $business_subtype){echo 'selected="selected"';}
					?>
					><?php 
					echo $rs_sub_type->fields['business_subtype'];
					?></option>
					<?php
					$rs_sub_type->MoveNext();
}
}
?>
</select>
</div>
</td>
</tr>
<tr><td width="1px;"></td></tr>
<tr>
<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Property Details<br/>[Detalji o objektu]</td>
</tr>
<tr>
<td style="border-left:1px solid #999999;">
Property Name
</td>
<td style="border-right:1px solid #999999;">
<input type="text" name="property_name" class="fields" id="property_name" value="<?php echo $rs_limit->fields['property_name']; ?>" /></td>
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
					AND field_name='property_name' 
					AND fld_type='property_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
			echo '<tr>
			<td class="txt1" style="border-left:1px solid #999999;">('.$rs_language->fields['Lan_name'].') </td>
			<td style="border-right:1px solid #999999;">
			<input  class="fields" name="property_name_'.$rs_language->fields['id'].'" id="property_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>

<tr>
<td style="border-left:1px solid #999999;">
City<br/>
</td>
<td style="border-right:1px solid #999999;">


<select name="region" class="fields" id="region">
<option value="<?php echo $rs_regionsel->fields['id']; ?>"><?php echo $rs_regionsel->fields['region_name']; ?></option>
<?php
while(!$rs_region->EOF)
{
	?>
	<option value="<?php echo $rs_region->fields['id'];?>"
	<?php
	if($rs_region->fields['id'] == $rs_limit->fields['region'])
	{
		echo 'selected="selected"';
	}
	?>
	><?php echo $rs_region->fields['region_name'];?></option>
	<?php
	$rs_region->MoveNext();
}
?>
</select>



</td>
</tr>

<tr>
<td style="border-left:1px solid #999999;">
Street<br/>[ulica]
</td>
<td style="border-right:1px solid #999999;">

<input type="text" name="street" class="fields" id="street" value="<?php echo $rs_limit->fields['street']; ?>" /></td>


</tr>

<tr>
<td style="border-left:1px solid #999999;">
Town<br/>
</td>
<td style="border-right:1px solid #999999;"s>
<?php $town=$rs_limit->fields['town']; ?>
<input   type="text" name="town" class="fields" id="town" value="<?php echo $town; ?>" />
</td>
</tr>

<tr>
<td style="border-left:1px solid #999999;">
Postcode
</td>
<td style="border-right:1px solid #999999;">



<input type="text" name="postcode" class="fields" id="postcode" value="<?php echo $rs_limit->fields['postcode']; ?>" />



</td>
</tr>

<tr>
<td style="border-left:1px solid #999999;">
Telephone<br/>[Telefon]
</td>
<td style="border-right:1px solid #999999;">
<input type="text" name="telephone" class="fields" id="telephone" value="<?php echo $rs_limit->fields['telephone']; ?>" /></td>

</tr>
<tr>
<td style="border-left:1px solid #999999;">
Fax
</td>
<td style="border-right:1px solid #999999;">

<input type="text" name="fax" class="fields" id="fax" value="<?php echo $rs_limit->fields['fax']; ?>" />


</td>
</tr>

<tr>
<td style="border-left:1px solid #999999;">
Email
</td>
<td style="border-right:1px solid #999999;">
<input type="text" name="email" class="fields" id="email" value="<?php echo $rs_limit->fields['email']; ?>" />
</td>
</tr>

<tr>
<td style="border-left:1px solid #999999; border-bottom:1px solid #999999;">
Property URL<br/>[Web adresa]
</td>
<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
<input type="text" name="property_url" class="fields" id="property_url" value="<?php echo $rs_limit->fields['property_url']; ?>" />
</td>


</tr>
<tr><td width="1px;"></td></tr>
<tr>
<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Property Type Details<br/>[Tip nekretnine Brodu]</td>
</tr>


<?php if($rs_limit->fields['property_category']=='24'){$stdisplay = 'block';}else{$stdisplay = 'none';} ?>
<tr>
<td colspan="2" style="border-left:1px solid #999999; border-right:1px solid #999999;">
<div id="stardiv" style="display:<?php echo $stdisplay;?>;">
<table cellpadding="1" cellspacing="0" border="0" class="txt" width="100%" >
<tr>



<td width="28%">
No. Of Property Rooms<br/>[Broj soba u objektu]
</td>
<td width="72%">
<input type="text" name="no_property_rooms" id="no_property_roomss" class="field2"  maxlength="4" size="10" value="<?php echo $rs_limit->fields['no_property_rooms']; ?>"/> Rooms[Sobe]
</td>
</tr>
<tr>
<td>
Numbers Of Stars<br/>[Kategorija]
</td>
<td>
<select name="numbers_of_stars" class="fields"   id="numbers_of_stars">
<option value="0">No Categorization</option>
<option <?php if($rs_limit->fields['numbers_of_stars'] == '1'){ echo 'selected="selected"';}?> value="1">1</option>
<option <?php if($rs_limit->fields['numbers_of_stars'] == '2'){ echo 'selected="selected"';}?> value="2">2</option>
<option <?php if($rs_limit->fields['numbers_of_stars'] == '3'){ echo 'selected="selected"';}?> value="3">3</option>
<option <?php if($rs_limit->fields['numbers_of_stars'] == '4'){ echo 'selected="selected"';}?> value="4">4</option>
<option <?php if($rs_limit->fields['numbers_of_stars'] == '5'){ echo 'selected="selected"';}?> value="5">5</option>
</select>

</td>
</tr>

</table>
</div></td>

</tr>


<tr>
<td style="border-left:1px solid #999999; border-bottom:1px solid #999999;">
Thumbnail<br/>[Glavna slika]
</td>
<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;" valign="middle">
<input type="file" name="property_thumbnail" class="fields"  id="property_thumbnail"  />
<?php
if($rs_limit->fields['property_thumbnail']!=NULL){
?>
	<img src="<?php MYSURL ?>graphics/thumbnail_upload/<?php echo $rs_limit->fields['property_thumbnail']; ?>" width="100" height="50" />
<?php
}
?>
</td>
</tr>
<tr><td height="1px;"></td></tr>
<tr>
<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Location<br/>[Lokacija]</td>
</tr>
<tr>
<td style="border-left:1px solid #999999;">
Local Bank Account<br/>[Bankovni račun]
</td>
<td style="border-right:1px solid #999999;">
<input type="text" name="local_bank_account" class="fields" id="local_bank_account" value="<?php echo $rs_limit->fields['local_bank_account']; ?>" />
</td>
</tr>


<tr>
<td style="border-left:1px solid #999999;">
Latitude<br/>[Geografska širina]
</td>
<td style="border-right:1px solid #999999;">
<input type="text" name="latitude" class="fields" id="latitude" value="<?php echo $rs_limit->fields['latitude']; ?>" />
</td>
</tr>

<tr>
<td style="border-left:1px solid #999999;">
Longitude<br/>[Geografska du&#382;ina]
</td>
<td style="border-right:1px solid #999999;">
<input type="text" name="longitude" class="fields" id="longitude" value="<?php echo $rs_limit->fields['longitude']; ?>" />
</td>
</tr>



<tr>
<td style="border-left:1px solid #999999; border-bottom:1px solid #999999; ">
Contact languages<br/>[Jezici za kontakt]
</td>
<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
<?php	if($count_lang >0){
	$contact_lang_array = array();
	if($rs_limit->fields['contact_language']!=""){
		if(strpos($rs_limit->fields['contact_language'], ",") > 0){
			$isolate_to_arr = explode(",", $rs_limit->fields['contact_language']);
			foreach($isolate_to_arr as $key=>$value){
				$contact_lang_array[] = trim($value);
			}
		}else{
			$contact_lang_array[] = $rs_limit->fields['contact_language'];
		}
	}

	while(!$rs_lang->EOF){
		?>
		<input type="checkbox" name="contact_language[]"
		<?php
		if(in_array($rs_lang->fields['id'], $contact_lang_array))
		{
			echo 'checked="checked"';
		}
		?>
		value="<?php echo $rs_lang->fields['id'] ?>" /><?php echo $rs_lang->fields['Lan_name']?><br />
		<?php
		$rs_lang->MoveNext();
	}}?>
</td>
</tr>

<tr>
<td height="1px;"></td>
</tr>
<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Description<br/>[opis]</td>

<tr>
<td style="border-left:1px solid #999999; border-bottom:1px solid #999999; ">
Short Description<br/>[Kratki opis objekta]
</td>

<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
<textarea rows="8" cols="45" name="short_description" id="short_description" class="smalltxtareas"><?php echo $rs_limit->fields['short_description']; ?></textarea>


</td>
</tr>

<!--short property description for Russian and montenegrin languages start here-->
<tr>
		
					
				<td>
						
<?php     if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				//$id=$rs_content->fields['id'];
				
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
				AND page_id=".$id." 
				AND field_name='short_description' 
				AND fld_type='property_type'"
				;
				
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{
			$value='';
			}
			echo '<tr>
			<td class="txt1" style="border-left:1px solid #999999; border-bottom:1px solid #999999;">('.$rs_language->fields['Lan_name'].') </td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<textarea id="short_description_'.$rs_language->fields['id'].'" name="short_description_'.$rs_language->fields['id'].'" rows="8" cols="45">'.stripslashes($value).'</textarea>
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
				
?>					</td>
		</tr>
<!--short property description for Russian and montenegrin languages ends here-->		
<input type="hidden" name="propertystatus" id="propertystatus"  value="1" />
<tr>
<td>&nbsp;
</td>
<td>
<input style="margin:5px; width:187px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Update Property &nbsp;[A&#382;uriraj Naziv]" class="button" />
</td>
</tr>
</table>
<input type="hidden" name="act" value="manage_properties" />
<input type="hidden" name="request_page" value="properties_management" />
<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
<input type="hidden" name="old_property_thumbnail" value="<?php echo $rs_limit->fields['property_thumbnail']; ?>" />
<input type="hidden" name="mode" value="update">

</form>
</td>
</tr>
</table>

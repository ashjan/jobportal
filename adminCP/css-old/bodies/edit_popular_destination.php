<?php
$id=base64_decode($_GET['pageid']);

if(isset($_GET['pageid'])){
$page = base64_decode($_GET['pageid']); 
		
		$qry_limit = "SELECT * FROM ".$tblprefix."popular_destination WHERE id=".$page; 
		$rs_limit = $db->Execute($qry_limit); 
		
$mode='update';
}else{
$page='send';
$mode='send';
}

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'"; 
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

$qry_popular_des = "SELECT * FROM ".$tblprefix."popular_dest_cat";  
$rs_popular_des = $db->Execute($qry_popular_des);

?>



<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Popular Destination Section</td>
 	</tr>
	
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?> </td>
					</tr>
					
					<!--<tr>
					<td class="txt1">Popular Destination Title</td>
					<td>
					<input type="text" name="popular_destination_title" class="fields" id="popular_destination_title" value="<?php //echo $rs_limit->fields['popular_destination_title']?>" />					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Popular Destination Description</td>
					<td>
					<textarea name="popular_destination_description" id="popular_destination_description" rows="7" cols="25" >
                    <?php //echo $rs_limit->fields['popular_destination_description'];?>
					</textarea>
					</td>
				</tr>-->
				
				
				
				
				<tr>
					<td>
			      Title:(English) 			
				</td>
					<td >
<input style="width:250px;" name="page_title" id="page_title" class="fields" type="text" value="<?php echo $rs_limit->fields['popular_destination_title']?>" />					
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
					AND field_name='page_title' 
					AND fld_type='popular_destination'"
					;   

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount(); 
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
				
			echo '<tr>
			<td class="txt1"> Title:('.$rs_language->fields['Lan_name'].') </td>
			<td>
		<input style="width:250px;" class="fields" name="page_title_'.$rs_language->fields['id'].'" id="page_title_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text" size="55"  maxlength="100" />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
				
				
					<tr>
						<td>Description:(English)</td>
					
						<td>
							<textarea id="short_descriptions" name="short_descriptions" rows="25" cols="80"><?php echo $rs_limit->fields['popular_destination_description'];?></textarea>					
							</td>
					</tr>
                    
                    <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				<td>
						
<?php           if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				$id=$rs_limit->fields['id'];    
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
				AND field_name='short_descriptions' 
				AND fld_type='popular_destination'"
				;  
				
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount(); 
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{
			$value='';
			}
			echo '<tr>
			<td class="txt1">Description:('.$rs_language->fields['Lan_name'].') </td>
			<td>
			<textarea id="short_descriptions_'.$rs_language->fields['id'].'" name="short_descriptions_'.$rs_language->fields['id'].'" rows="25" cols="80">'.stripslashes($value).'</textarea>
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
				
?>					</td>
				</tr>
				
				
				
				
				
				
				<tr>
					<td class="txt1">Popular Destination Category</td>
					<td>
					
						<select name="popular_destination_cat_id" class="fields" id="popular_destination_cat_id">
							<option value="0">Select Popular Destination</option>
                            <?php
							while(!$rs_popular_des->EOF){
							?>
                            <option value="<?php echo $rs_popular_des->fields['id']; ?>"<?php if($rs_popular_des->fields['id'] ==$rs_limit->fields['popular_destination_cat_id']){echo 'selected="selected"';} ?> ><?php echo $rs_popular_des->fields['popular_category_name']; ?></option>
                            <?php
								$rs_popular_des->MoveNext();
								}
							?>
						</select>
					
					</td>
				</tr>
				
				 
					<tr>
						<td>Popular Destination Image</td>
						<td><input type="file" name="popular_destination_thumbnail" class="fields" id="popular_destination_thumbnail" value="<?php echo $rs_limit->fields['popular_destination_thumbnail']; ?>" />
						 </td><td> </td>
						 
					<tr><td></td>
						<td> 
			<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."media/images/".$rs_limit->fields['popular_destination_thumbnail'];?>&w=50&h=40&zc=1" border="0" />
					 </td><td></td><td> </td><td> </td>
					</tr> 
					     
	   				
               
	        <td>&nbsp;			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update Destination" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_popular_destination" />
			<input type="hidden" name="act2" value="manage_popular_destination" />
			<input type="hidden" name="request_page" value="popular_destination_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['popular_destination_thumbnail']; ?>" />
			<input type="hidden" name="mode" value="update">
			
		</form>
		</td>
	</tr>
</table>
<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

 $id=base64_decode($_GET['id']); 
 


	$qry_feature_list = "SELECT * from ".$tblprefix."feature_list WHERE id=".$id;   
	$rs_feature_list = $db->Execute($qry_feature_list);
	
	// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Feature List</td>
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
  			Feature Description<br/>[Opis pogodnosti]
		   	</td>
			<td>
			
		<input type="text" name="feature_description" id="feature_description" class="fields" value="<?php echo $rs_feature_list->fields['feature_description']; ?>" /> 
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
					AND field_name='feature_title' 
					AND fld_type='feature_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
			echo '<tr>
			<td class="txt1" >Feature Description('.$rs_language->fields['Lan_name'].') </td>
			<td >
			<input  class="fields" name="feature_description_'.$rs_language->fields['id'].'" id="feature_description_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		
		
		
		
		
		<tr>
	        <td class="txt2">
  			Feature Status<br/>[Opis pogodnosti]
		   	</td>
			<td>
			<select name="feature_status" class="fields">
				<option value="1"<?php if($rs_feature_list->fields['feature_status']=='1'){echo 'selected="selected"'; }?>>Yes</option>
				<option value="0" <?php if($rs_feature_list->fields['feature_status']=='0'){echo 'selected="selected"'; } ?>>No</option>
			</select>
				
			</td>
        </tr>
			
		
				<!--  changes ends here -->
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:220px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Feature &nbsp;[A&#382;uriraj pogodnost]" class="button" />
		</td>
		</tr>
		</table>
</div>
	<?php	unset($_SESSION['add_sees']); ?>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_feature_list">
		<input type="hidden" name="act2" value="feature_list">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="request_page" value="feature_list_management" />
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

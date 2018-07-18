<?php
if(isset($_GET['pageid'])){
$gdt_flag = $_GET['dgt_flag'];

$page = base64_decode($_GET['pageid']); 
		$qry_content = "SELECT * FROM  ".$tblprefix."site_gdt1 WHERE id = '".$page."'"; 
		$rs_content = $db->Execute($qry_content);
$mode='update';
}else{
$page='send';
$mode='send';
}

 $qry_site_gdt_list = "SELECT site.* 
                       FROM  ".$tblprefix."site_gdt1 AS site  
					   WHERE site.id = '".$page."'"; 
 $rs_pm = $db->Execute($qry_site_gdt_list);

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry   =  "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language    =  $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage GDT (Offline PMs)[Upravljanje opštim uslovima (Offline)]</td>
 	</tr>
	<tr>
  		<td><h3><?php if(empty($rs_content->fields['gdt_page_title']))
						echo 'Add New ';
				 ?>
			</h3>
		</td>
	</tr>
	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
				<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
                </tr>
                <tr>
                <td>
			    Page Title:			
				</td>
				<td>
			
<input style="width:250px;" name="gdt_page_title" id="gdt_page_title" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['gdt_page_title']);?>" />					
                  
				</td>
				</tr>
                
                <?php 
				if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
                // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				if($mode == "update"){
					
					$id = $page; 
					
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
					AND field_name='gdt_title' 
					AND fld_type='gdt_type'"
					; 

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				}else{
					$value='';
				}
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
				<tr>
					<td>GDT Description:	<br/>[događaje Opis]</td>
					<td>
						<textarea id="gdt_description" name="gdt_description" rows="25" cols="90"><?php echo stripslashes($rs_content->fields['gdt_description']);?></textarea>					
					</td>
				</tr>
                <tr>
					<td>&nbsp;</td>
				<td>
						
<?php           if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				$id=$rs_content->fields['id'];    
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
				AND field_name='gdt_description' 
				AND fld_type='gdtdescription_type'"
				;
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{
			$value='';
			}
			$rs_language->MoveNext();
			} // END  while(!$rs_language->EOF)
            } // END if($totallanguages>0 	
				
?>					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" class="button" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Insert GDT';}else {echo 'GDT Events  [uslovi događaje]'; }?> " />						
						<input type="hidden" name="act"          value="manage_gdt1"             />
						<input type="hidden" name="act2"         value="edit_gdt1"               />
				        <input type="hidden" name="request_page" value="gdt_management1"         />	
						<input type="hidden" name="page_id"      value="<?php echo $page; ?>"    />	
						<input type="hidden" name="mode"         value="<?php echo $mode; ?>"    />
                        <input type="hidden" name="gdt_flag"     value="<?php echo $gdt_flag; ?>"/>					
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
	</form>
		</td>
	</tr>
</table>



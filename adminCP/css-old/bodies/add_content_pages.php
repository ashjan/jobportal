<?php
if(isset($_GET['id'])){
	$page = base64_decode($_GET['id']);
	$qry_content = "SELECT * FROM  ".$tblprefix."pagecontent WHERE cat_id = '".$page."'";
	$rs_content = $db->Execute($qry_content);
	$isrs_contents =  $rs_content->RecordCount();
	if($isrs_contents > 0){
		$mode='update';
		$pageid = $rs_content->fields['id'];
		$lat = $rs_content->fields['latitude'];
		$long = $rs_content->fields['longitude'];
	}else{
		$mode='send';
		$lat = '';
		$long = '';
	}
}else{
	$page='send';
	$mode='send';
	$lat = '';
	$long = '';
}

if($_GET['menuname']!=""){
	$menuname = stripslashes($_GET['menuname']);
}else{
	$menuname = 'Unknown menu name';
}

$category_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id = 0";
$rs_category = $db->Execute($category_qry);


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();
?>

<style>
#long_lat{
 display:none;
}
</style>

<script language="javascript">
 /*function show_long_lat(div_id, content_type){
   if(content_type==1){
   document.getElementById(div_id).style.display = 'table';
   }
   if(content_type!=1){
   document.getElementById(div_id).style.display = 'none';
   }
  
 }*/
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Content Management for ( <?php echo $menuname;?> )</td>
 	</tr>
 
	<tr>
  		
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
				</tr>
				<tr>
				<td colspan="2" class="txt2">
			      Page Title:				</td>
				</tr>
				<tr>
				<td colspan="2">
				<table width="422" height="26" cellpadding="0" cellspacing="2" style="border:#666666 1px dotted; width:445px;">
				<tr >
					<td width="59" class="txt1"> (English)  </td>
					<td width="430">
<input style="width:356px;" name="page_title" id="page_title" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['page_title'])?>" />					</td>
				</tr>
<?php 
				if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
                // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				if($mode == "update"){
					
					$id = $pageid;
					
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
					AND fld_type='content_type'"
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
				
			echo '<tr>
			<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
			<td>
			<input style="width:356px;" class="fields" name="page_title_'.$rs_language->fields['id'].'" id="page_title_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text" size="55"  maxlength="100" />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
				</table>				</td>
				</tr>
	

	<tr>
	      		<td class="fieldheading">Meta Title </td>
		      		<td>
					<input name="meta_title" id="meta_title" type="text" value="<?php echo stripslashes($rs_content->fields['meta_title'])?>" class="fields" />
		      		Select search engine friendly title here for this page to be searched.</td>
	     		</tr>
				<tr>
					<td class="fieldheading">Meta Keywords:</td>
				  <td>
				  <textarea name="meta_keyword" id="meta_keyword" class="smalltxtareas" cols="45" rows="8"><?php echo stripslashes($rs_content->fields['meta_keyword'])?></textarea>
					Suggest	multiple	words	seperated	by commas which may help to search this page.	</td>
				</tr>
				<tr>
					<td class="fieldheading">Meta Phrase: </td>
				  <td>
				  <textarea name="meta_phrase" id="meta_phrase" class="smalltxtareas" cols="45" rows="8"><?php echo stripslashes($rs_content->fields['meta_phrase'])?></textarea>
				    A simple phrase which help to search out this content page. </td>
				</tr>
				<tr>
			  		<td class="fieldheading">Meta Description:</td>
		  		  <td><textarea name="meta_description" id="meta_description" class="smalltxtareas" cols="45" rows="8"><?php echo stripslashes($rs_content->fields['meta_description'])?></textarea>A small and brief description explaining the purpose of this content page may be helpfull to search engine.					</td>
		  		</tr>
                <tr>
    
    <td>&nbsp;</td>
    
	<td>
    <tr>
		<td class="fieldheading">Latitude:*</td>
		<td>
			<input class="fields" type="text" value="<?php echo $lat;?>" name="latitude" id="latitude" />
        </td>
	</tr>
    
	<tr>
		<td class="fieldheading">Longitude:*</td>
		<td>
		    <input class="fields" type="text" value="<?php echo $long;?>" name="longitude" id="longitude" />
		</td>
	</tr>
	
    </td>
	</tr>
				<tr>
					<td class="txt2">Description:</td>
					<td></td>
				</tr>
				<tr>
					<td>(English)</td>
					<td><textarea id="description" name="description" rows="25" cols="90"><?php echo stripslashes($rs_content->fields['description'])?></textarea></td>
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
				AND field_name='description' 
				AND fld_type='content_type'"
				;
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{
			$value='';
			}
			echo '<tr>
			<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
			<td>
			<textarea id="description_'.$rs_language->fields['id'].'" name="description_'.$rs_language->fields['id'].'" rows="25" cols="90">'.stripslashes($value).'</textarea>
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
				
?>					</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>
			    <input type="submit" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Insert Contents';}else {echo 'Update Contents'; }?> " />						
				<input type="hidden" name="act" value="manage_third_level_categories">
				<input type="hidden" name="act2" value="add_content_pages">
				<input type="hidden" name="request_page" value="content_management" />	
				<input type="hidden" name="page_id" value="<?php echo $pageid; ?>">	
				<input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo base64_encode($page); ?>">
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

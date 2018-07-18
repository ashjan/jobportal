<?php
if(isset($_GET['pageid'])){
	$page = base64_decode($_GET['pageid']);
	$qry_content = "SELECT * FROM  ".$tblprefix."pagecontent WHERE id = '".$page."'";  
	$rs_content = $db->Execute($qry_content);
	$isrs_contents =  $rs_content->RecordCount(); 
	if($isrs_contents > 0){
		$mode='update';
		$pageid = $rs_content->fields['id'];
	}else{
		$mode='send';
	}
}else{
	$page='send';
	$mode='send';
}

if($_GET['menuname']!=""){
	$menuname = stripslashes($_GET['menuname']);
}else{
	$menuname = 'Unknown menu name';
}

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users";  
$rs_pm = $db->Execute($qry_pm);

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

if(!$_GET['okmsg'] && !$_GET['errmsg'])
{
	unset($_SESSION['add_content_page']);
}

?>
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
<input style="width:356px;" name="page_title" id="page_title" class="fields" type="text" value="<?php 
if(isset($_SESSION['add_content_page']['page_title'])){
	echo $_SESSION['add_content_page']['page_title'];
}
?>" />					</td>
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
				
				if(isset($_SESSION['add_content_page']['page_title_'.$rs_language->fields['id']]))
				{
					$value = $_SESSION['add_content_page']['page_title_'.$rs_language->fields['id']];
				}else {
					$value = '';
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
	

<tr><td>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">			</td></tr>
			
            <?php
			}else{?>
			<tr>
			<td class="txt1">Property Manager</td>
			<td>
			<?php 
			
			?>
			<select name="pm_id" class="fields"   id="pm_id" >
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				
				if(isset($_SESSION['add_content_page'])and $_SESSION['add_content_page']['pm_id']== $rs_pm->fields['id'])
				{echo 'selected="selected"';}
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>
			</td>
			</tr> 
			
		<?php } ?>
    </td>
	</tr>
	<tr>
	<td>Content Type:</td>
	<td>
	<select name="content_type" id="content_type" class="fields">
	<option value="pub_pro_page" <?php if($_SESSION['add_content_page']['content_type']=='pub_pro_page'){echo 'selected="selected"';}?>>Public Property Page</option>
	<option value="sitegdt"<?php if($_SESSION['add_content_page']['content_type']=='sitegdt'){echo 'selected="selected"';} ?>>Site GDT</option>
	<option value="newsforagncy"<?php if($_SESSION['add_content_page']['content_type']=='newsforagncy')
	{echo 'selected="selected"';} ?>>News For Agency</option>
	</select>
	</td>
	</tr>
			
				<tr>
					<td>(English)</td>
					<td><textarea id="sitegdt" name="sitegdt" rows="25" cols="90">
					<?php if(isset($_SESSION['add_content_page']['sitegdt'])){echo $_SESSION['add_content_page']['sitegdt'];}?>
					</textarea></td>
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
				AND field_name='sitegdt' 
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
			<textarea id="sitegdt_'.$rs_language->fields['id'].'" name="sitegdt_'.$rs_language->fields['id'].'" rows="25" cols="90">'.stripslashes($value).'</textarea>
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
?>				</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>
			    <input type="submit" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Update Contents';}else {echo 'Update Contents'; }?> " />						
				<input type="hidden" name="act" value="add_content_pages">
				<input type="hidden" name="request_page" value="content_pm_management" />	
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

<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."menu WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

$qry_parent = "SELECT  menu_slug FROM ".$tblprefix."menu WHERE id=".$rs_limit->fields['parent'];
$rs_parent = $db->Execute($qry_parent);
$parent_slug = $rs_parent->fields['menu_slug'];
							
//page contents
$qry_getcontent = "SELECT * FROM ".$tblprefix."pagecontent";
$rs_getcontent  = $db->Execute($qry_getcontent);
$count_contents = $rs_getcontent->RecordCount();
$totalContents  = $count_contents;

//menu
$qry_getmenues = "SELECT * FROM ".$tblprefix."menu";
$rs_getmenues = $db->Execute($qry_getmenues);
$count_menues =  $rs_getmenues->RecordCount();
$totalmenues = $count_menues;


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Menu Management Section</td>
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
  			Menu Order
		   	</td>
			<td><input type="text" name="menu_order" class="fields" id="menu_order" value="<?php echo $rs_limit->fields['menu_order']; ?>" /></td>
        </tr>  
<tr>
<td colspan="2"><strong>Menu Title</strong></td>	
</tr>
<tr>
	        <td>
  			(English)
		   	</td>
			<td><input type="text" name="menu_title" class="fields" id="menu_title" value="<?php echo $rs_limit->fields['menu_title']; ?>" /></td>
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
					AND field_name='menu_title' 
					AND fld_type='menu_footer_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
			echo '<tr>
			<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
			<td >
			<input  class="fields" name="menu_title_'.$rs_language->fields['id'].'" id="menu_title_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>





   <tr>
					<td class="fieldheading"> Menu Content : </td>
					 <td>
					 <select name="content_id" class="fields" id="content_id" >
					 <option value="0">Select Content Page</option>
					 <?php
					while(!$rs_getcontent->EOF){
					 $sel=''; 
					 if($rs_getcontent->fields['id']==$rs_limit->fields['content_id']){$sel='selected';}
			 echo '<option value="'.$rs_getcontent->fields['id'].'"  '.$sel.'>'.$rs_getcontent->fields['page_title'].'</option>';
					 $rs_getcontent->MoveNext();
					 }
					 ?>
					 </select>
                     </td>
			   </tr>
              <!-- <tr>
					<td class="fieldheading">Parent :</td>
					 <td>
					<select name="parent" class="fields" id="parent">
					<option value="0">Select Parent Menu</option>
					<?php
					/*$sel='';
					while(!$rs_getmenues->EOF){
					 $mid=$rs_getmenues->fields['id'];
						if($rs_getmenues->fields['menu_slug']==$parent_slug){
							echo '<option value="'.$mid.'"  selected="selected">'.$rs_getmenues->fields['menu_title'].'</option>';
						}
					 echo '<option value="'.$mid.'" >'.$rs_getmenues->fields['menu_title'].'</option>';
					 $rs_getmenues->MoveNext();
					 }*/
					?>
					</select>
				</tr>-->
				
				<tr><td class="fieldheading">Position</td><td><select name="footer_menu" class="field" id="footer_menu">
				
				<option value="footer" <?php if($rs_limit->fields['footer_menu']=="footer") { echo 'selected="selected"'; }?>>Footer</option>
				<option value="widget1" <?php if($rs_limit->fields['footer_menu']=="widget1") { echo 'selected="selected"'; }?>>Widget 1</option>
				<option value="widget2" <?php if($rs_limit->fields['footer_menu']=="widget2") { echo 'selected="selected"'; }?>>Widget 2</option>
				<option value="widget3" <?php if($rs_limit->fields['footer_menu']=="widget3") { echo 'selected="selected"'; }?>>Widget 3</option>
				</select></td></tr>
				<tr>
				
				
				<!--<tr><td class="fieldheading">Main Menu</td><td><select name="main_menu" class="field" id="main_menu">
				<option value="1">Yes</option>
				<option value="0">NO</option>
				</select></td></tr>-->
				
				
				
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Menu" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="managemenues" />
			<input type="hidden" name="request_page" value="managemenues" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>
<?php
if(isset($_GET['id'])){
$id=base64_decode($_GET['id']);
		$qry_content = "SELECT * FROM  ".$tblprefix."content_category WHERE id =".$id;
		$rs_content = $db->Execute($qry_content);

}
$category_qry = "select * from ".$tblprefix."content_category where parent_id = 0";
$rs_category = $db->Execute($category_qry);



// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Categories Managment Section</td>
 	</tr>
	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	<tr>
			<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
	</tr>
	<tr>
	<td colspan="2">
	<div class="border_div_categories">				
    <table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				
				<td class="txt2">
				Category Name:
				</td>
				<td>&nbsp; 
				
				</td>
				</tr>
				
				<tr>
					<td class="txt1">(English) </td>
				    <td>	
<input name="categoryname" id="categoryname" value="<?php echo $rs_content->fields['category_title'];  ?>" type="text" size="55"  maxlength="255"/>
					</td>
				</tr>		
     <?php  if($totallanguages>0){ 
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
				AND field_name='category_title' 
				AND fld_type='category_type'"
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
					<input name="categoryname_'.$rs_language->fields['id'].'" id="categoryname_'.$rs_language->fields['id'].'" value="'.$value.'" type="text" size="55"  maxlength="100" />
					</td>
					</tr>';
					$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 ?>
	</table>		
	</div>		
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<div class="border_div_categories">				
    <table cellpadding="1" cellspacing="1" border="0" >	
	<tr>
	<td class="txt2">Select Parent Category:</td>
	<td>
					<select name="cat_parent" class="fields" id="page_parent">
				 	<option value="0">Parent</option>
					<?php
					while(!$rs_category->EOF){
					$is_cat_selected = '';
					if($rs_category->fields['id']==$rs_content->fields['parent_id']){
					$is_cat_selected = 'selected="selected"';
					}else{
					$is_cat_selected = '';
					}
					?>
		  			<option value="<?php echo $rs_category->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_category->fields['category_title'];  ?></option>
										<?php
											$rs_category->MoveNext();
											}?>			
					</select>					
	</td>
	</table>		
	</div>
	
	<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td>
		<input name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		
		<!--<input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Category" class="button" />-->
		</td>
		</tr>
		</table>
</div>
	
	
	</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>
                            	<?php 
									if(isset($_GET['id'])){
								?>    
                                        	
                                        <input type="hidden" name="mode" value="update">
                                        <input type="hidden" name="act" value="managecategories">
										<input type="hidden" name="act2" value="add_categories">
                                        <input type="hidden" name="request_page" value="categories_management" />
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />								
                               	<?php 
									}else{
								?>
                                        <input name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add" class="button" />	
                                        <input type="hidden" name="mode" value="add">
                                        <input type="hidden" name="act" value="managecategories">
										<input type="hidden" name="act2" value="add_categories">
                                        <input type="hidden" name="request_page" value="categories_management" />
                                 <?php
                                 }
								 ?>  

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
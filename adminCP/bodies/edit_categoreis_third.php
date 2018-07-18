<?php
if(isset($_GET['id'])){
$id = base64_decode($_GET['id']);
 
		$qry_content = "SELECT * FROM  ".$tblprefix."thirdlevel_content_category WHERE id =".$id;
		$rs_second_level = $db->Execute($qry_content);
		$is_second_level_found =  $rs_second_level->RecordCount();
		if($is_second_level_found > 0){
			if($rs_second_level->fields['parent_id']!=0){
				$second_level_id = $rs_second_level->fields['parent_id'];
				$catname_edit = $rs_second_level->fields['category_title'];
			}else{
				$second_level_id = 0;
				$catname_edit = $rs_second_level->fields['category_title'];
			}
		}else{
			$second_level_id = 0;
			$catname_edit = '';
		}
		
		$qry_parent_id = "SELECT * FROM  ".$tblprefix."thirdlevel_content_category WHERE id = ".$second_level_id;
		$rs_parent_id = $db->Execute($qry_parent_id);
		$is_parent_id_found =  $rs_parent_id->RecordCount();
		
		if($is_parent_id_found > 0){
			if($rs_parent_id->fields['parent_id']!=0){
				$parent_level_id = $rs_parent_id->fields['parent_id'];
			}else{
				$parent_level_id = 0;
			}
		}else{
			$parent_level_id = 0;
		}
}else{
	//Redirect Back
	$okmsg = base64_encode("Can Not Be Edited. !");
	header("Location: admin.php?okmsg=$okmsg&act=manage_third_level_categories ");
	exit;
	
}


$qry_generate_second_level_dd = "select * from ".$tblprefix."thirdlevel_content_category where parent_id = " . $parent_level_id;
$rs_generate_second_level_dd = $db->Execute($qry_generate_second_level_dd);
$isrs_generate_second_level_dd =  $rs_generate_second_level_dd->RecordCount();

$qry_generate_first_level_dd = "select * from ".$tblprefix."thirdlevel_content_category where parent_id = 0";
$rs_generate_first_level_dd = $db->Execute($qry_generate_first_level_dd);
$isrs_generate_first_level_dd =  $rs_generate_first_level_dd->RecordCount();


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Categories Management Section</td>
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
	<td class="txt2">Select Parent Category:</td>
	<td>
					<select name="cat_parent" class="fields" id="page_parent" onchange="get_sub_cat('sub_category', this.value, '<?php echo MYSURL."ajaxresponse/sub_category.php"?>')">
				 	<option value="0">Parent</option>
					<?php
					if($isrs_generate_first_level_dd > 0){
					while(!$rs_generate_first_level_dd->EOF){
					$is_cat_selected = '';
					
					if($rs_generate_first_level_dd->fields['id'] == $parent_level_id){
						$is_cat_selected = 'selected="selected"';
					}else{
						$is_cat_selected = '';
					}
					?>
		  			<option value="<?php echo $rs_generate_first_level_dd->fields['id'];?>" <?php echo $is_cat_selected;?>>
						<?php echo $rs_generate_first_level_dd->fields['category_title']; ?>
                    </option>
					<?php
						$rs_generate_first_level_dd->MoveNext();
					}
					}
					?>
					</select>					
	</td>
	</table>		
	</div>
    
    
    <div class="border_div_categories"   id="sub_category">				
<table cellpadding="1" cellspacing="1" border="0" >
				
				<tr style="margin-top:15px;"  >
					<td class="txt2">Select Second Level Category :</td>
					<td>
					<select name="page_sub_category" class="fields"  id="page_parent" >
						<option value="0">Second Level Category</option>
						<?php
						if($isrs_generate_second_level_dd > 0){
							while(!$rs_generate_second_level_dd->EOF){
								$is_subcat_selected = '';
								
								if($rs_generate_second_level_dd->fields['id'] == $second_level_id){
									$is_subcat_selected = 'selected="selected"';
								}else{
									$is_subcat_selected = '';
								}
						?>
                            <option value="<?php echo $rs_generate_second_level_dd->fields['id'];?>" <?php echo $is_subcat_selected;?>>
                                <?php echo stripslashes($rs_generate_second_level_dd->fields['category_title']); ?>
                            </option>
                        <?php
							$rs_generate_second_level_dd->MoveNext();
							}
						}
						?>
								
					</select>
                    
					</td>
				</tr>
</table>
</div>
    </td>
    </tr>
	<tr>
	<td colspan="2">
	<div class="border_div_categories">				
    <table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				
				<td class="txt2">
				
				</td>
				<td>&nbsp; 
				
				</td>
				</tr>
				
				<tr>
					<td class="txt1">Category Name: </td>
				    <td>	
<input name="categoryname" id="categoryname" value="<?php echo $rs_second_level->fields['category_title'];  ?>" type="text" size="55"  maxlength="255"/>
					</td>
				</tr>		
     <?php  if($totallanguages>0){ 
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				$id=$rs_second_level->fields['id'];    
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
//					echo '<tr>
//					<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
//					<td>
//					<input name="categoryname_'.$rs_language->fields['id'].'" id="categoryname_'.$rs_language->fields['id'].'" value="'.$value.'" type="text" size="55"  maxlength="100" />
//					</td>
//					</tr>';
					$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 ?>
	</table>		
	</div>		
	</td>
	</tr>
	<tr>
	<td colspan="2">
	
	
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
                                        <input type="hidden" name="act" value="manage_third_level_categories">
										<input type="hidden" name="act2" value="edit_categoreis_third">
                                        <input type="hidden" name="request_page" value="thirdlevel_cate_management" />
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />								
                               	<?php 
									}else{
								?>
                                        <input name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add" class="button" />	
                                        <input type="hidden" name="mode" value="add">
                                        <input type="hidden" name="act" value="manage_third_level_categories">
										<input type="hidden" name="act2" value="edit_categoreis_third">
                                        <input type="hidden" name="request_page" value="thirdlevel_cate_management" />
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
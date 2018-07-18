<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
if(isset($_GET['mode']))
{
    $modee = $_GET['mode'];
}
else {
$modee = "";   
}

if($modee =='edit' && $_GET['id']!=''){
	$is_edit = TRUE;
	$menuid = base64_decode($_GET['id']);
	$parentid = base64_decode($_GET['parentid']);
	$mode = 'update';
	$submit_btn = 'Edit Category';
	
	$id = base64_decode($_GET['id']);
	
	$qry_limit = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE id = " . $id;
	$rs_limit = $db->Execute($qry_limit);
	
}else{
	$is_edit = FALSE;
	$menuid = '';
	$parentid = '';
	$mode = 'add';
	$submit_btn = 'Add Category';
}

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

//  LOAD ALL PARENT CATEGORIES
$category_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id =0 ";
$rs_category = $db->Execute($category_qry);

?>

<table width="100%" border="0"  class="table table-hover" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Categories</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
	<td colspan="6">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
 
 <div class="border_div_categories"  align="center">				
<table cellpadding="1" cellspacing="1" border="0" >

				<tr style="margin-top:15px;"  >
					<td class="txt2">Select a category object:</td>
					<td>
					<select name="cat_parent" class="fields"  id="page_parent">
						<option value="0">Parent</option>
						<?php
						while(!$rs_category->EOF){
						
						$is_selected = '';
						if($rs_category->fields['id'] == $parentid){
							$is_selected = 'selected="selected"';
						}else{
							$is_selected = '';
						}
						?>
							<option value="<?php echo $rs_category->fields['id'];?>" <?php echo $is_selected; ?> >
								<?php echo $rs_category->fields['category_title'];  ?>
                            </option>
						<?php
						$rs_category->MoveNext();
						}?>			
					</select>					
					</td>
				</tr>
</table>
</div>
 
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt2"> </td>
				<td>&nbsp;  </td>
				</tr>
				<tr>
				<td class="txt1">The category name:</td>
				<td>
                                    <input name="categoryname" id="categoryname" value="<?php if(isset($rs_limit)){echo $rs_limit->fields['category_title'];}  ?>" type="text" size="55"  maxlength="45" />*
				</td>
				</tr>
<?php 
				if($totallanguages>0){ 
					while(!$rs_language->EOF){
					if($is_edit){
						// Get the currently selected translated text if exist in language content table 
						$language_id = $rs_language->fields['id'];
						$id = $menuid;    
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
						$totallang_flds =  $rs_lang_text->RecordCount();
						
						if($totallang_flds > 0){
							$value = $rs_lang_text->fields['translated_text'];
						}else{
							$value='';
						}
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
                } // END if($totallanguages>0 
?>
</table>				
</div>
			
			
				


<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td>
        <input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="<?php echo $submit_btn; ?>" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
        <input type="hidden" name="mode" value="<?php echo $mode;?>">        
		<input type="hidden" name="act" value="managecategories">
		<input type="hidden" name="act2" value="add_categories">
		<input type="hidden" name="request_page" value="categories_management" />
        <?php
		if($modee =='edit' && $_GET['id']!=''){
		?>
        <input type="hidden" name="id" value="<?php echo $id?>" />
        <?php
		}
		?>
					</td>
				</tr>
</form> 


  </td>
  </tr>     
  </table>

		 </td>
		 </tr>
  
</table>
<?php //echo $where;?>

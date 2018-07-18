<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."landmark_type WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();
 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Landmark Types</td>
 	</tr>
 
	<tr>
  		<td><h3><?php if(empty($rs_limit->fields['landmark_type_name']))
						echo 'Add New ';
						echo stripslashes($rs_limit->fields['landmark_type_name'])?> Page</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
				<tr>
                    <td>
                    Landmark Type Category
                    </td>
                    <td>
                        <?php
                            $sql_cat	=	" SELECT * FROM tbl_property_category ";
                            $rs_cat		=	$db -> Execute($sql_cat);
                        ?>
                            <select name="landmark_type_cat" id="landmark_type_cat">
                                <?php
                                    while(!$rs_cat -> EOF){
                                ?>
                                        <option value="<?php echo $rs_cat->fields['id'];?>" <?php if($rs_limit->fields['cat_id'] == $rs_cat->fields['id']){?> selected="selected" <?php } ?>>
											<?php echo $rs_cat->fields['property_category_name'];?>
                                        </option>
                                 <?php
                                        $rs_cat -> MoveNext();
                                    }
                                ?>
                            </select>
                    </td>
                </tr>  
        <tr>
	        <td>
  		Landmark Types Name(English)
		   	</td>
			<td>
			 
					<?php if(!empty($_SESSION['landmark_type_name'])){ ?>
					
			<input type="text" name="landmark_type_name" id="landmark_type_name" class="fields" value="<?php echo $_SESSION['landmark_type_name']; ?>" />	<?php }else{ ?>
			
			<input type="text" name="landmark_type_name" id="landmark_type_name" class="fields" value="<?php echo $rs_limit->fields['landmark_type_name']; ?>" /> <?php } ?>
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
					AND field_name='landmark_type_name' 
					AND fld_type='landmark_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				
				
			echo '<tr>
			<td class="txt1" >Landmark Type Name('.$rs_language->fields['Lan_name'].') </td>
			<td >
			<input  class="fields" name="landmark_type_name_'.$rs_language->fields['id'].'" id="landmark_type_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		
		                    
       
		
		<tr>
	        <td>
  			old Image 
			</td>
			<?php if(!empty($_SESSION['landmark_icon'])){ ?>
					
			<td valign="middle"><img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL; ?>graphics/thumbnail_upload/<?php echo $_SESSION['landmark_icon']; ?>&w=50&h=50&zc=1" border="0"/>	<?php }else{ ?>
			
			<td valign="middle"><img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL; ?>graphics/thumbnail_upload/<?php echo $rs_limit->fields['landmark_icon']; ?>&w=50&h=50&zc=1" border="0"/> <?php } ?>
			
			</td>
			
        </tr>
		<tr>
	        <td>
  			Change Image
		   	</td>
			<td>
			
			<input type="file" name="landmark_icon" class="fields" />
			</td>
        </tr>
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Landmark Type" class="button" />
			</td>
        </tr>

		</table>
			<?php $_SESSION['landmark_type_name'] = '';
				  $_SESSION['landmark_icon'] = '';
			?>
			
			<input type="hidden" name="act" value="edit_landmark_type" />
			<input type="hidden" name="act2" value="manage_landmark_type" />
			<input type="hidden" name="request_page" value="landmark_type_management" />
			<input type="hidden" name="landmark_icon_old" value="<?php echo $rs_limit->fields['landmark_icon']; ?>" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['landmark_icon']; ?>" />
			<input type="hidden" name="id" value="<?php echo $rs_limit->fields['id']; ?>" />
			<input type="hidden" name="mode" value="update">

		</form>
		
		</td>
	</tr>
</table>


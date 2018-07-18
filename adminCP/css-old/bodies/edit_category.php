<?php
if(isset($_GET['pageid'])){
$page = base64_decode($_GET['pageid']); 


		$qry_content = "SELECT * FROM  ".$tblprefix."category WHERE id = '".$page."'"; 
                $rs_content = $db->Execute($qry_content);
$mode='update';
}else{
$page='send'; 
$mode='send';
}

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();



$query_region = "SELECT * FROM ".$tblprefix."property_regions";
$rs_region = $db->Execute($query_region);
$totallanguages =  $rs_region->RecordCount();


$query_category_town = "SELECT DISTINCT town FROM ".$tblprefix."properties ORDER BY town ASC";
$rs_category_town = $db->Execute($query_category_town);
$totalcategorytown =  $rs_category_town->RecordCount();

$category=$tblprefix."category";
$qry_limit =  "SELECT * FROM  ".$tblprefix."category WHERE id=".$page;
$rs_limit = $db->Execute($qry_limit);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">category Management Section</td>
 	</tr>
 
	<tr>
  		<td><h3><?php if(empty($rs_content->fields['category_name']))
						echo 'Add New ';
						//echo stripslashes($rs_content->fields['category_name']);?> <!--Page</h3>--></td>
	</tr>
	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
				<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
				</tr>
				
				<tr>
				<td class="txt2">
			      category Title:				
				</td>
                
                <td>
			
<input style="width:250px;" name="category_name" id="category_name" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['category_name']);?>" />					
                  
				</td>
				</tr>
                
				 <tr>
						<td>Picture</td>
						<td valign="middle">
						
						<?php
						if(!empty($rs_limit->fields['image'])){
						$image_name =$rs_limit->fields['image'];
						
						}else{
						$image_name ="noimg.jpg";
						}
						?>
						<input  type="file" name="image" id="image" value="<?php echo $rs_limit->fields['image']; ?>" />
						<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."media/images/".$image_name.""; ?> &w=50&h=50&zc=1" border="0"  /> 
						</td>
							
					</tr>
					
					
<!--					<tr>
						<td>Video option:</td>
						<td>
                        	<select name="video_opts" id="video_opts" onchange="category_open_video_opts(this.value)">
                            	<option value="none">Select option to set/upload video</option>
                            	<option value="1">3rd Party Embed URL</option>
                                <option value="0">Upload</option>
                            </select>
                       
					   
					   <img src="<?php //echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php //echo MYSURL."media/videos/Video_icon.png" ?> &w=50&h=50&zc=1" border="0"  /> 
					   
					   
					    </td>
							
					</tr>-->
<!--				 	<tr>
                    	<td colspan="2">
                        	
                            <div id="video_panel_upload" style="display:none;">
                            	<table cellpadding="5" cellspacing="2" border="0" class="txt" width="100%">
                                	<tr>
                                        <td width="50%" align="left" valign="top">Upload Video:</td>
                                      <td width="50%" align="left" valign="top"><input  type="file" name="video" id="video" value="" /> </td>
                                  </tr>
                                </table>
                            </div>
                            
                            <div id="video_panel_url" style="display:none;">
                            	<table cellpadding="5" cellspacing="2" border="0" class="txt" width="100%">
                                	<tr>
                                        <td width="50%" align="left" valign="top">3rd party video embded code:</td>
                                      <td width="50%" align="left" valign="top">
										<textarea id="video_embed_code" name="video_embed_code" rows="8" cols="20"></textarea>
                                      </td>
                                  </tr>
                                </table>
                            </div>
                            
                        </td>
                    </tr>-->
					
					
					
					
					
					
					
						   
			<tr>
					<td class="txt2"> category Description:</td>
					<td>
						<textarea id="description" name="description" rows="25" cols="90"><?php echo stripslashes($rs_content->fields['description']);?></textarea>					
						</td>
			</tr>
                
                
                
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Insert category';}else {echo 'Update category'; }?> " />						
						<input type="hidden" name="act" value="edit_category">
						<input type="hidden" name="act2" value="category">
				        <input type="hidden" name="request_page" value="manage_category" />	
						<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['image']; ?>" />
						<input type="hidden" name="old_video" value="<?php //echo $rs_limit->fields['category_video']; ?>" />
						<input type="hidden" name="page_id" value="<?php echo $page; ?>">	
						<input type="hidden" name="mode" value="<?php echo $mode; ?>">					
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



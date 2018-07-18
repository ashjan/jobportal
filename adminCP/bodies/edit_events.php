<?php
if(isset($_GET['pageid'])){
$page = base64_decode($_GET['pageid']); 


		$qry_content = "SELECT * FROM  ".$tblprefix."events WHERE id = '".$page."'"; 
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

$query_event_category = "SELECT * FROM ".$tblprefix."event_categories";
$rs_event_categories = $db->Execute($query_event_category);
$totaleventcategory =  $rs_event_categories->RecordCount();

$query_region = "SELECT * FROM ".$tblprefix."property_regions";
$rs_region = $db->Execute($query_region);
$totallanguages =  $rs_region->RecordCount();


$query_event_town = "SELECT DISTINCT town FROM ".$tblprefix."properties ORDER BY town ASC";
$rs_event_town = $db->Execute($query_event_town);
$totaleventtown =  $rs_event_town->RecordCount();

$events=$tblprefix."events";
$qry_limit =  "SELECT * FROM  ".$tblprefix."events WHERE id=".$page;  		
$rs_limit = $db->Execute($qry_limit);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Event Management Section</td>
 	</tr>
 
	<tr>
  		<td><h3><?php if(empty($rs_content->fields['event_name']))
						echo 'Add New ';
						//echo stripslashes($rs_content->fields['event_name']);?> <!--Page</h3>--></td>
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
			      Event Title:				
				</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                <td>
			     (English) 			
				</td>
				<td>
			
<input style="width:250px;" name="event_name" id="event_name" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['event_name']);?>" />					
                  
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
					AND field_name='event_title' 
					AND fld_type='event_type'"
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
			<input style="width:250px;" class="fields" name="event_name_'.$rs_language->fields['id'].'" id="event_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text" size="55"  maxlength="100" />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
				
				<tr>
				<td class="fieldheading">Event Start Date:</td>
				
				
				
			  <td width="200">
			  <input type="text" name="event_start_date"  id="event_start_date"  value="<?php
			  $event_start_date=date("m/d/Y",strtotime($rs_limit->fields['event_start_date']));
			  echo $event_start_date; ?>"/>
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'event_start_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
             </script>
			   </td>
			   </tr>
			   
			   
			   
			   <tr>
				<td class="fieldheading">Event End Date:</td>
				<td><input type="text" name="event_end_date"  id="event_end_date"  value="<?php 
				$event_end_date=date("m/d/Y",strtotime($rs_limit->fields['event_end_date']));
			    echo $event_end_date;
				
				?>"/>
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'event_end_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>

               </td>
			   </tr>
			   
			   <tr>
				<td class="fieldheading">Event Category:</td>
				<td>
			<select name="event_category_name" class="fields" id="event_category_name">
			<option value="0" >Select Event Category</option>
			<?php 
			$rs_event_categories->MoveFirst();
			while(!$rs_event_categories->EOF){
			?>
<option value="<?php echo $rs_event_categories->fields['event_category_name'];?>"
<?php
 if( $rs_event_categories->fields['event_category_name']== $rs_limit->fields['event_category_name'] ){echo 'selected=="selected"';} ?>>
 <?php echo $rs_event_categories->fields['event_category_name']; ?></option>
			<?php
			$rs_event_categories->MoveNext();
			}
			?>
			</select> 
               </td>  </tr>
			   <tr>
				<td class="fieldheading">Event Region:</td>
				<td>
<!--<input style="width:356px;" name="event_region" id="event_region" class="fields" type="text" value="<?php //echo stripslashes($rs_region->fields['event_region']);?>" />-->

<select name="event_region" class="fields" id="event_region">
			<option value="0" >Select Event Region</option>
			<?php 
			$rs_region->MoveFirst();
			while(!$rs_region->EOF)
			{
			?>
			<option value="<?php echo $rs_region->fields['region_name']; ?>"
			<?php
			if($rs_region->fields['region_name']==$rs_content->fields['event_region'])
			{
				echo 'selected="selected"';
			}
			?>
			><?php echo $rs_region->fields['region_name']; ?></option>
						<?php
						$rs_region->MoveNext();
						}
						?>
			</select> 
               </td>
			   </tr>
			   
			   
			   
			   <tr>
				<td class="fieldheading">Event Town/City:</td>
				 <td>
			<select name="event_town" id="event_town">
			
			
			<option value="0" >Select Event Town</option>
			<?php 
			$rs_event_town->MoveFirst();
			while(!$rs_event_town->EOF){
			?>
<option value="<?php echo $rs_event_town->fields['town']; ?>"
<?php
			if($rs_event_town->fields['town']==$rs_content->fields['event_town'])
			{
				echo 'selected="selected"';
			}
			?>
><?php echo $rs_event_town->fields['town']; ?></option>
			<?php
			$rs_event_town->MoveNext();
			}
			?>
			</select> 
               </td>
			   </tr>
			   
			    <tr>
					<td class="txt2">
			      Event Venue				
				</td>
					<td >
			   <input style="width:250px;" name="venue" id="venue" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['venue']);?>" />
			    </td>
				</tr>
				
				
				 <tr>
						<td>Picture</td>
						<td valign="middle">
						
						<?php
						if(!empty($rs_limit->fields['event_picture'])){
						$image_name =$rs_limit->fields['event_picture'];
						
						}else{
						$image_name ="media/noimg.jpg";
						}
						?>
						<input  type="file" name="image" id="image" value="<?php echo $rs_limit->fields['event_picture']; ?>" />
						<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL.																	 						"media/images/".$image_name.""; ?> &w=50&h=50&zc=1" border="0"  /> 
						</td>
							
					</tr>
					<!--<tr>
						<td>Video</td>
						<td><input  type="file" name="video" id="video" value="<?php //echo $rs_limit->fields['event_video']; ?>"  />
						  
						 <img src="<?php //echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php //echo MYSURL."media/videos/Video_icon.png" ?> &w=50&h=50&zc=1" border="0"  /> 

</td>
							
					</tr>-->
				
					
					
					
					<tr>
						<td>Video option:</td>
						<td>
                        	<select name="video_opts" id="video_opts" onchange="event_open_video_opts(this.value)">
                            	<option value="none">Select option to set/upload video</option>
                            	<option value="1">3rd Party Embed URL</option>
                                <option value="0">Upload</option>
                            </select>
                       
					   
					   <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."media/videos/Video_icon.png" ?> &w=50&h=50&zc=1" border="0"  /> 
					   
					   
					    </td>
							
					</tr>
				 	<tr>
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
                    </tr>
					
					
					
					
					
					
					
						   
			   <tr>
					<td class="txt2"> Event Description:</td>
					<td>
					
					</td>
				</tr>
				<tr>
					
					<td>(English)</td>
					<td>
						<textarea id="event_description" name="event_description" rows="25" cols="90"><?php echo stripslashes($rs_content->fields['event_description']);?></textarea>					
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
				AND field_name='event_description' 
				AND fld_type='eventdescription_type'"
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
			<textarea id="event_description_'.$rs_language->fields['id'].'" name="event_description_'.$rs_language->fields['id'].'" rows="25" cols="90">'.stripslashes($value).'</textarea>
			</td>
			</tr>';
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
						<input type="submit" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Insert Events';}else {echo 'Update Events'; }?> " />						
						<input type="hidden" name="act" value="manage_events">
						<input type="hidden" name="act2" value="edit_events">
				        <input type="hidden" name="request_page" value="events_manage" />	
						<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['event_picture']; ?>" />
						<input type="hidden" name="old_video" value="<?php echo $rs_limit->fields['event_video']; ?>" />
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



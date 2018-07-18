<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
$mode = '';
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
$startRow = $pageNum * $maxRows;

 $qry_faq = "SELECT * FROM ".$tblprefix."events" ; 

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5

$events=$tblprefix."events";
$qry_limit ="SELECT * FROM ".$tblprefix."events" ; 
		
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



//Edit Query
$is_edit_form = false;
if(isset($_REQUEST['pagid'])){
	$is_edit_form = true;
	$categoryid = base64_decode($_GET['cateid']);// send frm edit section
	$update_query_category = "SELECT * FROM ".$tblprefix."events WHERE id = '".$_REQUEST['pagid']."' ";  
	$rs_update_category = $db->Execute($update_query_category);
	$row_update_category = $rs_update_category->GetRows();
}


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'"; 
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

$query_event_category = "SELECT * FROM ".$tblprefix."event_categories";
$rs_event_categories = $db->Execute($query_event_category);
$totaleventcategory =  $rs_event_categories->RecordCount();



$query_event_town = "SELECT DISTINCT town FROM ".$tblprefix."properties ORDER BY town ASC";
$rs_event_town = $db->Execute($query_event_town);
$totaleventtown =  $rs_event_town->RecordCount();



$query_region = "SELECT * FROM ".$tblprefix."property_regions"; 
$rs_region = $db->Execute($query_region);
$totallanguages =  $rs_region->RecordCount();

 $qry_limit1 = "SELECT ev.*,ec.id as pm_idd ,ec.event_category_name,pr.region_name FROM `".$tblprefix."events` as ev INNER JOIN tbl_event_categories as ec ON ec.id=ev.ec_id INNER JOIN tbl_property_regions as pr ON pr.id=ev.pr_id"; 

$rs_limit1 = $db->Execute($qry_limit1);
?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Event Calendar</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    	<td colspan="5" align="right">Total Number of Event Found: <?php echo $totalcountalpha ?></td>
	</tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6"> <div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		  
		 <tr>
					<td class="txt2">
			      Event Title:				
				</td>
					<td >&nbsp;		
                  </td>
				</tr>
		 <tr>
					<td>
			     (English) 			
				</td>
					<td >
<input style="width:250px;" name="event_name" id="event_name" class="fields" type="text" value="<?php echo stripslashes($rs_limit->fields['event_name']);?>" />					
                  </td>
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
				
//			echo '<tr>
//			<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
//			<td>
//			<input style="width:250px;" class="fields" name="event_name_'.$rs_language->fields['id'].'" id="event_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text" size="55"  maxlength="100" />
//			</td>
//			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		 
		 	  <td class="fieldheading">Event Start Date:</td>
              <td width="200">
			  <input type="text" name="event_start_date"  id="event_start_date" />
			  <script language="JavaScript">
                                    
                                    $(document).ready(function() {

                                // assuming the controls you want to attach the plugin to 
                                // have the "datepicker" class set
                                $('#event_start_date').Zebra_DatePicker();

                             });
             </script>
			   </td>
            </tr>
			
			  <tr>
				<td class="fieldheading">Event End Date:</td>
				<td><input type="text" name="event_end_date"  id="event_end_date" />
			  <script language="JavaScript">
                                   $(document).ready(function() {

                                        // assuming the controls you want to attach the plugin to 
                                        // have the "datepicker" class set
                                        $('#event_end_date').Zebra_DatePicker();

                                     });
									</script>

               </td>
			   </tr>
			   <tr>
				<td class="fieldheading">Event Category:</td>
				<td>
			<select name="event_category_name" id="event_category_name">
			<option value="0" >Select Event Category</option>
			<?php 
			$rs_event_categories->MoveFirst();
			while(!$rs_event_categories->EOF){
			?>
<option value="<?php echo $rs_event_categories->fields['event_category_name']; ?>"><?php echo $rs_event_categories->fields['event_category_name']; ?></option>
			<?php
			$rs_event_categories->MoveNext();
			}
			?>
			</select> 
               </td>  </tr>
			   
			   <tr>
				<td class="fieldheading">Event Region:</td>
				 <td>
			<select name="event_region" id="event_region">
			
			
			<option value="0" >Select Event Region</option>
			<?php 
			$rs_region->MoveFirst();
			while(!$rs_region->EOF){
			?>
<option value="<?php echo $rs_region->fields['region_name']; ?>"><?php echo $rs_region->fields['region_name']; ?></option>
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
<option value="<?php echo $rs_event_town->fields['town']; ?>"><?php echo $rs_event_town->fields['town']; ?></option>
			<?php
			$rs_event_town->MoveNext();
			}
			?>
			</select> 
               </td>
			   </tr>
			   
			   
			   
				 <tr>
					<td class="txt2">
			      Event Venue:				
				</td>
					<td >
<input style="width:250px;" name="venue" id="venue" class="fields" type="text" value="" />					
                  </td>
				</tr>
				 
				 <tr>
						<td>Picture:</td>
						<td><input  type="file" name="image" id="image" value="" /> </td>
							
					</tr> 
				 
					<tr>
						<td>Video option:</td>
						<td>
                        	<select name="video_opts" id="video_opts" onchange="event_open_video_opts(this.value)">
                            	<option value="none">Select option to set/upload video</option>
                            	<option value="1">3rd Party Embed URL</option>
                                <option value="0">Upload</option>
                            </select>
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
					</tr>
					<tr>
						<td>(English)</td>
					
						<td>
							<textarea id="event_description" name="event_description" rows="25" cols="90">
							<?php echo stripslashes($rs_limit->fields['event_description'])?>
                            </textarea>					
							</td>
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
				$id=$rs_limit->fields['id'];    
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
			
						
				<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Events" class="button" />
				<input type="hidden" name="act" value="manage_events">
				<input type="hidden" name="request_page" value="events_manage" />
				<input type="hidden" name="mode" value="add">
						
	
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
  <form name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
    <td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	  
	    <td width="5%">Sr#</td>
				<td width="5%">Event Name</td>
				<td width="10%">Start Date</td>
				<td width="10%">End Date</td>
				<td width="10%">Event Category</td>
				<td width="10%">Event Region </td>
				<td width="10%">Event Venue</td>
				<td width="10%">Event Picture</td>
				<td width="10%">Event Video</td>
				<td width="20%">Event Description</td>
				<td width="10%">Options</td>
		</tr>
					
						<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					  
					  <td valign="top"><?php echo ++$i; ?></td>
					  <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['event_name']); ?></td>
						<td valign="top">
						<?php echo $rs_limit->fields['event_start_date'];?>
						</td>
						<td valign="top">
						<?php	echo $rs_limit->fields['event_end_date'];?>
						</td>
						
						<td valign="top">
						<?php	echo $rs_limit->fields['event_category_name'];?>
						</td>
						
						<td valign="top">
						<?php	echo $rs_limit->fields['event_region'];?>
						</td>
						
						<td valign="top">
						<?php	echo $rs_limit->fields['venue'];?>
						</td>
						
						<td valign="middle">
						
						<?php
						if(!empty($rs_limit->fields['event_picture'])){
						$image_name =$rs_limit->fields['event_picture'];
						
						}else{
						$image_name ="media/images/noimg.jpg";
						}
						?>
						 <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL.														"media/images/".$image_name.""; ?> &w=50&h=50&zc=1" border="0"  />  </td>
					
					
					<td valign="middle">
					<?php if(!empty($rs_limit->fields['event_video']) or !empty($rs_limit->fields['video_url'])){?> 
					
					<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL.														"media/videos/Video_icon.png" ?> &w=50&h=50&zc=1" border="0"  />
					 </td> 
					 <?php  }  ?>
					
					
					<td valign="top">
						<?php 
							if($rs_limit->fields['event_description']!=""){
								if(strlen($rs_limit->fields['event_description']) > 200){
									echo substr($rs_limit->fields['event_description'], 0, 200) . ' [...]';
								}else{
									echo $rs_limit->fields['event_description'];
								}
							}else{
								echo '&nbsp;';
							}
						?>
						</td>
						
						
						<td valign="top">
                
				<a href="admin.php?act=edit_events&pageid=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				
				
				<a href="admin.php?act=manage_events&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=events_manage" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
	
		   
                        </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						
						}
						
						//}
						
						?>
						
						<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}
							else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPages){
							if($pageNum==0)
							$count= $count+10;
							else { $count = $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0'; ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							
							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<!--<?php
				//}else{
			?>
				<tr>
					<td colspan="13" class="errmsg"> No Property Manager Found</td>
				</tr>
			<?php
				//}// end if($totalcount > 0)
			?>-->
						
						

  
</table>
</td>
</tr>
</table>


<?php 
$mode='add';

$lang_qry = "select * from ".$tblprefix."language"; 
$rs_language = $db->Execute($lang_qry);

$qry_page_cont = "SELECT * FROM ".$tblprefix."pagecontent" ; 
$rs_page_cont = $db->Execute($qry_page_cont);

$qry_category = "SELECT * FROM ".$tblprefix."content_category"; 
$rs_category= $db->Execute($qry_category);

$qry_popular_dest = "SELECT id,popular_destination_title FROM " . $tblprefix . "popular_destination";
$rs_popular_dest = $db->Execute($qry_popular_dest);

$qry_popular_dest = "SELECT id,popular_destination_title FROM " . $tblprefix . "popular_destination";
$rs_popular_dest = $db->Execute($qry_popular_dest);

$qry_facility = "SELECT id,facility_name FROM " . $tblprefix . "facility_management";  
$rs_facility = $db->Execute($qry_facility);

$qry_events = "SELECT id,event_name FROM " . $tblprefix . "events"; 
$rs_events = $db->Execute($qry_events);

$qry_prop_cat = "SELECT id,property_category_name FROM " . $tblprefix . "property_category"; 
$rs_prop_cat = $db->Execute($qry_prop_cat);


$qry_property = "SELECT * FROM " . $tblprefix . "properties";
$rs_property = $db->Execute($qry_property);

$qry_landmarks = "SELECT * FROM " . $tblprefix . "landmarks";
$rs_landmarks = $db->Execute($qry_landmarks);

$qry_menus = "SELECT * FROM " . $tblprefix . "menu";
$rs_menus = $db->Execute($qry_menus);

$qry_feature = "SELECT * FROM " . $tblprefix . "feature_list";
$rs_feature = $db->Execute($qry_feature);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Language Content Management Section :</td>
 	</tr>
 
	<tr>
  		<td><h3>Add New Page:</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
                                    <td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>					</td>
				</tr>			
				<tr>
					<td class="fieldheading">Select Language:</td>
					<td>
					<select name="language_id" class="fields" id="language_id" >
				 		<option value="">--Select Language--</option>
									<?php
										while(!$rs_language->EOF){
                                                                                    $is_cat_selected = '';
									?>
						<option value="<?php echo $rs_language->fields['id'];?>" <?=$is_cat_selected?> ><?php echo $rs_language->fields['Lan_name'] ;?>	</option>
										<?php
												$rs_language->MoveNext();
											}
										?>	
					</select>					</td>
				</tr>
				
				<tr>
					<td class="fieldheading">Select Page:</td>
					<td>
					<?php 
					$arr_fields="array('page_title','description')";
					$is_content_page_type = "";
					?>
					
					<select name="page_id" class="fields" id="page_id" >
				 	<option value="">Izaberite stranu</option>
								  	<?php
										while(!$rs_page_cont->EOF){
													$is_cat_selected = '';
											?>
					<option value="<?php echo $rs_page_cont->fields['id'];?>" onclick="page_type('content_type')" ><?php echo $rs_page_cont->fields['page_title'].' (content_type)';?> </option>
								
								<?php
								
									$rs_page_cont->MoveNext();
									}
								?>	
								  	<?php
									
									while(!$rs_popular_dest->EOF){
									
				?>
									
                                    
       <option value="<?php echo $rs_popular_dest->fields['id'];?>"  onclick="page_type('popular_destination')" ><?php echo $rs_popular_dest->fields['popular_destination_title'].' (popular_destination)';?>					</option>
									
									
									<?php 
									$rs_popular_dest->MoveNext();
									}
								
								
									while(!$rs_category->EOF){
									
															?>
									
       <option value="<?php echo $rs_category->fields['id'];?>"  onclick="page_type('category_type')" ><?php echo $rs_category->fields['category_title'].' (category_title)';?>					</option>
									
									
									<?php 
									$rs_category->MoveNext();
									}
								
								
								while(!$rs_events->EOF){
								
								
								?>
                                    
       <option value="<?php echo $rs_events->fields['id'];?>" onclick="page_type('event_type')" ><?php echo $rs_events->fields['event_name'].' (event_name)';?>					</option>
									<?php 
									$rs_events->MoveNext();
									}
								
								while(!$rs_facility->EOF){
								 
								?>
       <option value="<?php echo $rs_facility->fields['id'];?>"  onclick="page_type('facility_type')" ><?php echo $rs_facility->fields['facility_name'].' (facility_name)';?>					</option>
									
									
									<?php 
									$rs_facility->MoveNext();
									}
								
								
								
								while(!$rs_prop_cat->EOF){
								
                                    ?>
       <option value="<?php echo $rs_prop_cat->fields['id'];?>"  onclick="page_type('cate_type')" ><?php echo $rs_prop_cat->fields['property_category_name'].' (cate_type)';?>					</option>
									
									
									<?php 
									$rs_prop_cat->MoveNext();
									}
								
								
								
								
								while(!$rs_property->EOF){
                                    ?>
       <option value="<?php echo $rs_property->fields['id'];?>"  onclick="page_type('property_type')" ><?php echo $rs_property->fields['property_name'].' (property_type)';?>					</option>
									<?php 
									$rs_property->MoveNext();
									}
								
								
								
								
								
								
								
								
								while(!$rs_landmarks->EOF){
									
                                    ?>
       <option value="<?php echo $rs_landmarks->fields['id'];?>"  onclick="page_type('landmark_type')" ><?php echo $rs_landmarks->fields['landmark_name'].' (landmark_type)';?>					</option>
									
									<?php 
									$rs_landmarks->MoveNext();
									}
									
								
								while(!$rs_menus->EOF){
									
                                    ?>
       <option value="<?php echo $rs_menus->fields['id'];?>"  onclick="page_type('menu_footer_type')" ><?php echo $rs_menus->fields['menu_title'].' (menu_footer_type)';?>					</option>
									
									
									<?php 
									$rs_menus->MoveNext();
									}
								
								while(!$rs_feature->EOF){		
                                    ?>
       <option value="<?php echo $rs_feature->fields['id'];?>" onclick="page_type('feature_type')" ><?php echo $rs_feature->fields['feature_description'].' (menu_footer_type)';?>					</option> 						<?php 
									$rs_feature->MoveNext();
									}
								 ?>	
                                
					</select>					</td>
				</tr>
				
				
				<tr>
					<td class="fieldheading">Field Name:</td>
					<td>
<!--<input name="field_name" id="field_name" readonly="readonly" type="text" value="<?php //echo stripslashes($rs_content->fields['field_name']);?>" class="fields" />-->
<select name="field_name" id="field_name"  class="fields">
<option value="field_name">Izaberite Ime polja</option>
</select>
</td>
				</tr>
				
				<tr >
					<td class="fieldheading">Translated Text:</td>
					<td>
			<textarea name="translated_text" id="translated_text" cols="50" rows="10" ></textarea>					</td>
				</tr>
				<tr>
					<td class="fieldheading">Page Type:</td>
					<td>
<input name="page_type" id="page_type" readonly="readonly" type="text" value="" class="fields" />	</td>
				</tr>
			
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="contentSbt" id="contentSbt" value="Insert Contents" class="button" />						
						<input type="hidden" name="act" value="lang_cont_managment">
						<input type="hidden" name="act2" value="add_lang_cont_managment">
				        <input type="hidden" name="request_page" value="language_content" />	
						<input type="hidden" name="mode" value="<?php echo $mode; ?>">			</td>
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

    <script language="javascript">
    page_type('<?php echo $is_content_page_type; ?>');
    </script>	
   
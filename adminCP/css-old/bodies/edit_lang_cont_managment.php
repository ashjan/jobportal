<?php 
if(isset($_GET['id'])){
$id = base64_decode($_GET['id']);
 $type=base64_decode($_GET['type']); 
        $qry_content = "SELECT * FROM  ".$tblprefix."language_contents WHERE id = '".$id."'"; 
		$rs_content = $db->Execute($qry_content);
		$mode='update';

}else{
$mode='add';
}
$is_cat_selected_cont = '';
$is_cat_selected_pop = '';
$is_cat_selected_catg = '';
$is_cat_selected_event = '';
$is_cat_selected_facilty = '';
$is_cat_selected_cate = '';
$is_cat_selected_property = '';
$is_cat_selected_land = '';
$is_cat_selected_menu = '';
$is_cat_selected_feature = '';

$lang_qry = "select * from ".$tblprefix."language"; 
$rs_language = $db->Execute($lang_qry);

$qry_page_cont = "SELECT * FROM ".$tblprefix."pagecontent" ; 
$rs_page_cont = $db->Execute($qry_page_cont);

$qry_category = "SELECT * FROM ".$tblprefix."content_category"; 
$rs_category= $db->Execute($qry_category);

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
  		<td id="heading">Language Content Managment </td>
 	</tr>
 
	<tr>
  		<td><h3><?php if(empty($rs_content->fields['field_name']))
						echo stripslashes($rs_content->fields['field_name'])?>Page</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>					</td>
				</tr>
			
				<tr>
					<td class="fieldheading">Select Language:* </td>
					<td>
					<select name="language_id" class="fields" id="language_id" >
				 		<option value="">--Select Language--</option>
									<?php
										while(!$rs_language->EOF){
														$is_cat_selected = '';
														if($rs_language->fields['id']==$rs_content->fields['language_id']){
															$is_cat_selected = 'selected="selected"';

														}else{
															$is_cat_selected = '';
														}										
									?>
						<option value="<?php echo $rs_language->fields['id'];?>" <?=$is_cat_selected?> ><?php echo $rs_language->fields['Lan_name'] ;?></option>
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
														if($type=="content_type"){
															if($rs_page_cont->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_cont = 'selected="selected"';
																$is_content_page_type = 'content_type';
																}
														}
											?>
					<option value="<?php echo $rs_page_cont->fields['id'];?>" <?=$is_cat_selected_cont?> onclick="page_type_edit('content_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_page_cont->fields['page_title'].' (content_type)';?> </option>
								
								<?php
								
									$rs_page_cont->MoveNext();
									}
								?>	
								  	<?php
									
									while(!$rs_popular_dest->EOF){
									if($type=="popular_destination"){ 
									if($rs_popular_dest->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_pop = 'selected="selected"';
																$is_content_page_type = 'popular_destination';
															}
															 }
															?>
									
                                    
       <option value="<?php echo $rs_popular_dest->fields['id'];?>" <?=$is_cat_selected_pop?> onclick="page_type_edit('popular_destination','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_popular_dest->fields['popular_destination_title'].' (popular_destination)';?>					</option>
									
									
									<?php 
									$rs_popular_dest->MoveNext();
									}
								
								
									while(!$rs_category->EOF){
                                    if($type=="category_type"){ 
									if($rs_category->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_catg = 'selected="selected"';
																$is_content_page_type = 'category_type';
															} 
															}
															?>
									
       <option value="<?php echo $rs_category->fields['id'];?>" <?=$is_cat_selected_catg?> onclick="page_type_edit('category_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_category->fields['category_title'].'(category_type)';?>	</option>
									
									
									<?php 
									$rs_category->MoveNext();
									}
								
								
								while(!$rs_events->EOF){
								if($type=="event_type"){ 
								if($rs_events->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_event = 'selected="selected"';
																$is_content_page_type = 'event_type';
															}
															}
								?>
                                    
       <option value="<?php echo $rs_events->fields['id'];?>" <?=$is_cat_selected_event?> onclick="page_type_edit('event_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_events->fields['event_name'].' (event_name)';?>					</option>
									<?php 
									$rs_events->MoveNext();
									}
								
								
								
								while(!$rs_facility->EOF){
								if($type=="facility_type"){ 
                                    if($rs_facility->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_facilty = 'selected="selected"';
																$is_content_page_type = 'facility_type';
															}
															}
								?>
       <option value="<?php echo $rs_facility->fields['id'];?>" <?=$is_cat_selected_facilty?> onclick="page_type_edit('facility_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_facility->fields['facility_name'].' (facility_name)';?>					</option>
									
									
									<?php 
									$rs_facility->MoveNext();
									}
								
								while(!$rs_prop_cat->EOF){
									
											if($type=="cate_type"){
								                                    if($rs_prop_cat->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_cate = 'selected="selected"';
																$is_content_page_type = 'cate_type';
															}
															}
                                    ?>
       <option value="<?php echo $rs_prop_cat->fields['id'];?>" <?=$is_cat_selected_cate?> onclick="page_type_edit('cate_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_prop_cat->fields['property_category_name'].' (cate_type)';?>					</option>
									
									
									<?php 
									$rs_prop_cat->MoveNext();
									}
								
								
								
								
								while(!$rs_property->EOF){
									
											if($type=="property_type"){
								                                    if($rs_property->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_property = 'selected="selected"';
																$is_content_page_type = 'property_type';
															}
															}
                                    ?>
       <option value="<?php echo $rs_property->fields['id'];?>" <?=$is_cat_selected_property?> onclick="page_type_edit('property_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_property->fields['property_name'].' (property_type)';?>					</option>
									
									
									<?php 
									$rs_property->MoveNext();
									}
								
								
								while(!$rs_landmarks->EOF){
									
											if($type=="landmark_type"){
								                                    if($rs_landmarks->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_land = 'selected="selected"';
																$is_content_page_type = 'landmark_type';
															}
															}
                                    ?>
       <option value="<?php echo $rs_landmarks->fields['id'];?>" <?=$is_cat_selected_land?> onclick="page_type_edit('landmark_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_landmarks->fields['landmark_name'].' (landmark_type)';?>					</option>
									
									
									<?php 
									$rs_landmarks->MoveNext();
									}
								
								
								while(!$rs_menus->EOF){
									
											if($type=="menu_footer_type"){
								                                    if($rs_menus->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_menu = 'selected="selected"';
																$is_content_page_type = 'menu_footer_type';
															}
															}
                                    ?>
       <option value="<?php echo $rs_menus->fields['id'];?>" <?=$is_cat_selected_menu?> onclick="page_type_edit('menu_footer_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_menus->fields['menu_title'].' (menu_footer_type)';?>					</option>
									
									
									<?php 
									$rs_menus->MoveNext();
									}
								
								while(!$rs_feature->EOF){
									
											if($type=="feature_type"){
								                                    if($rs_feature->fields['id']==$rs_content->fields['page_id']){
																$is_cat_selected_feature = 'selected="selected"';
																$is_content_page_type = 'feature_type';
															}
															}
                                    ?>
       <option value="<?php echo $rs_feature->fields['id'];?>" <?=$is_cat_selected_feature?> onclick="page_type_edit('feature_type','<?php echo $rs_content->fields['field_name']; ?>')" ><?php echo $rs_feature->fields['feature_description'].' (feature_type)';?>					</option>
									
									
									<?php 
									$rs_feature->MoveNext();
									}
								?>	
                                
                                
					</select>					</td>
				</tr>
				
				
				<tr>
					<td class="fieldheading">Field Name:</td>
					<td>
<select name="field_name" id="field_name"  class="fields">
<option value="field_name">Izaberite Ime polja</option>
</select>
</td>
				</tr>
				
				<tr >
					<td class="fieldheading">Translated Text:</td>
					<td>
			<textarea name="translated_text" id="translated_text" cols="50" rows="10" ><?php echo $rs_content->fields['translated_text']; ?></textarea>					</td>
				</tr>
				<tr>
					<td class="fieldheading">Page Type:</td>
					<td>
<input name="page_type" id="page_type" readonly="readonly" type="text" value="<?php echo stripslashes($rs_content->fields['fld_type']);?>" class="fields" />	</td>
				</tr>
			
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="contentSbt" id="contentSbt" value="Update Contents" class="button" />						
						<input type="hidden" name="act" value="edit_lang_cont_managment">
						<input type="hidden" name="act2" value="lang_cont_managment">
				        <input type="hidden" name="request_page" value="language_content" />	
						<input type="hidden" name="mode" value="update">
						<input type="hidden" name="id" value="<?php echo $id;?>" />					</td>
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

<?php
if($rs_content->fields['page_id']!=""){
	?>
    <script language="javascript">
    page_type('<?php echo $is_content_page_type; ?>');
    </script>	
    <?php
}
?>
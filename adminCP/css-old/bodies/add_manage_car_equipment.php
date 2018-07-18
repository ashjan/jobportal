<?php
if(isset($_GET['pageid'])){
$page = base64_decode($_GET['pageid']);
		$qry_content = "SELECT * FROM  ".$tblprefix."tbl_car_equipment WHERE id = '".$page."'";
		$rs_content = $db->Execute($qry_content);
$mode='update';
}else{
$page='send';
$mode='send';
}
$category_qry = "SELECT * FROM ".$tblprefix."content_category WHERE parent_id = 0";
$rs_category = $db->Execute($category_qry);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Car Equipment</td>
 	</tr>
 
	<tr>
  		<td><h3><?php if(empty($rs_content->fields['page_title']))
						echo 'Add New ';
						echo stripslashes($rs_content->fields['page_title'])?> Page</h3></td>
	</tr>
	<tr>
		<td>
	<form name="managecarequipmentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
				<tr>
				<td colspan="2" class="txt2">
			      Page Title: 	
				</td>
				</tr>
				<tr>
				<td colspan="2">
				</td>
				</tr>
				<tr>
					<td class="fieldheading">Select Category:</td>
					<td>
					<select name="page_category" class="fields" id="page_parent" onchange="get_sub_cat('sub_category', this.value, '<?php echo MYSURL."ajaxresponse/sub_category.php"?>')">
				 	<option value="">Select Category</option>
											  	<?php
													while(!$rs_category->EOF){
														$is_cat_selected = '';
														if($rs_category->fields['id']==$rs_content->fields['page_category']){
															$is_cat_selected = 'selected="selected"';
													}
												?>
		  			<option value="<?php echo $rs_category->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_category->fields['category_title'] ;?></option>
	                <?php
					$rs_category->MoveNext();
					}
					?>			
					</select>					
					</td>
				</tr>
				<tr id="">
					<td class="fieldheading">Select Sub Category:</td>
					<td>
					<div id="sub_category">
						<select name="page_sub_category" class="fields" id="page_parent">
							<option value="0">First Select Category</option>
						</select>
					</div>
					<?php if($mode=='update'){
						?><script language="javascript">
						get_sub_cat('sub_category', '<?php echo $rs_content->fields['page_category']?>&subcat=<?php echo $rs_content->fields['page_sub_category']?>', '<?php echo MYSURL."ajaxresponse/sub_category.php"?>');
						</script><?php }
					 ?>
					</td>
				</tr>
				<tr>
					<td class="fieldheading">Page Type:</td>
					<td>
					<?php	$type = $rs_content->fields['page_type'];?>
					<select name="page_type" id="page_type" class="fields">
						<option value="">Select an option</option>
						<option value="1" <?php if($type==1) {echo 'selected="selected"';} ?> >Commercial</option>
						<option value="2" <?php if($type==2) {echo 'selected="selected"';} ?>>Non Commercial</option>
					</select>
					</td>
				</tr>
			
				<tr>
		      		<td class="fieldheading">Meta Title </td>
		      		<td><input name="meta_title" id="meta_title" type="text" value="<?php echo stripslashes($rs_content->fields['meta_title'])?>" class="fields" /></td>
	     		</tr>
				<tr>
					<td class="fieldheading">Meta Keywords:</td>
					<td><textarea name="meta_keyword" id="meta_keyword" class="smalltxtareas" cols="45" rows="8"><?php echo stripslashes($rs_content->fields['meta_keyword'])?></textarea>
					</td>
				</tr>
				<tr>
					<td class="fieldheading">Meta Phrase: </td>
					<td><textarea name="meta_phrase" id="meta_phrase" class="smalltxtareas" cols="45" rows="8"><?php echo stripslashes($rs_content->fields['meta_phrase'])?></textarea>
					</td>
				</tr>
				<tr>
			  		<td class="fieldheading">Meta Description:</td>
			  		<td><textarea name="meta_description" id="meta_description" class="smalltxtareas" cols="45" rows="8"><?php echo stripslashes($rs_content->fields['meta_description'])?></textarea>
					</td>
		  		</tr>
				<tr>
					<td class="txt2">Description:</td>
					<td></td>
				</tr>
				<tr>
					<td>(English)</td>
					<td>
						<textarea id="description" name="description" rows="25" cols="90">
							<?php echo stripslashes($rs_content->fields['description'])?>
						</textarea>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				<td>
						
<?php 
		   
				
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Insert Contents';}else {echo 'Update Contents'; }?> " />						
						<input type="hidden" name="act" value="manage_car_equipment.php">
						<input type="hidden" name="act2" value="add_manage_car_equipment">
				        <input type="hidden" name="request_page" value="management_car_equipment" />	
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

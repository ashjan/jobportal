<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
$sub_cat=$_GET['subcat'];
		$qry_content = "SELECT * FROM  ".$tblprefix."thirdlevel_content_category WHERE parent_id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
?>

<table cellpadding="1" width="620" cellspacing="1" border="0" >
				
				<tr style="border: 1px solid #666666; margin-top:15px;"  >
					<td class="txt2">Select Second Level Category :</td>
					<td>


<select name="page_sub_category" class="fields" id="page_sub_category" onchange="get_sub_cat('third_category', this.value, '<?php echo MYSURL."ajaxresponse/third_category.php"?>')" >
<?php
if($count_add<=0){?>
<option value="">No Sub Category Exits</option>
<?php }else{ ?>
<option>Select Sub Category</option>	
	<?php while(!$rs_content->EOF){
				$is_cat_selected = '';
				if($rs_content->fields['id']==$sub_cat){
				$is_cat_selected = 'selected="selected"';
				}else{
				$is_cat_selected = '';
				}
	?>
<option value="<?php echo $rs_content->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_content->fields['category_title'] ;?></option>
			<?php $rs_content->MoveNext();
			}
	}
}
?>
</select>
</td>
</tr> 
</table>

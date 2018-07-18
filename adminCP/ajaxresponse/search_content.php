<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
		$qry_content = "SELECT ".$tblprefix."pagecontent.page_title 
		                FROM   ".$tblprefix."pagecontent 
						WHERE id=".$id;
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
 } 
 ?>
 
<div id="content_listing" class="content_listing">
<?php
$maxRows = 20;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."pagecontent" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5

$content=$tblprefix."pagecontent";
$category=$tblprefix."content_category";
$qry_limit = "SELECT 
					".$content.".id,
					".$content.".page_title,
					".$content.".description,
					category.category_title as category,
					subcategory.category_title as subcategory
					FROM ".$content."
					LEFT JOIN $category category ON $content.page_category = category.id
					LEFT JOIN $category subcategory ON $content.page_sub_category = subcategory.id 
					WHERE ".$content.".page_category = ".$id." 
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
?>
     
	 
	 <table cellpadding="0" cellspacing="0" border="0" class="txt" > 
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="25%">Page Title</td>
				<td width="25%">Category</td>
				<td width="25%">Sub Category</td>
				<td width="15%">Options</td>
		    </tr>
			<?php 
				if($totalcountalpha >0){
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
					  <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['page_title']); ?></td>
							<td valign="top">
							<?php	echo $rs_limit->fields['category'];?>
							</td>
						<td valign="top">
		<?php if(empty($rs_limit->fields['subcategory'])){ echo 'No Sub-Category found';}else{echo $rs_limit->fields['subcategory'];}?>
						</td>
						<td >
						<a href="admin.php?act=add_content_pages&pageid=<?php echo base64_encode($rs_limit->fields['id']);?>">							<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=contentpage&amp;mode=delpage&amp;pageid=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=content_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        <a class="tabheading" href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"><img src="<?php MYSURL?>graphics/data.gif" width="15" height="18" border="0" title=" Click here to view the Answer " /></a>			
		   </td>
					</tr>
<tr class="tabheading">
          <td colspan="5">
          <div id="controls_<?php echo $rs_limit->fields['id']; ?>" class="add_subscriber txt" >
           <table cellpadding="5" cellspacing="5" border="0" >
                <tr>
                    <td width="50%" class="txt">
                       <?php echo $rs_limit->fields['description']; ?>
                    </td>
               </tr>                    
           </table>                     
          </div>
          </td>
      </tr>					
			<?php $rs_limit->MoveNext();
			}?>
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
							else { $count= $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
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
			<?php
				}else{
			?>
			
			
				<tr>
					<td colspan="13" class="errmsg"> No Content Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
	</table>		
</div>


<div id="contents" class="contents">
</div>

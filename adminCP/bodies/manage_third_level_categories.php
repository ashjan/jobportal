<?php 
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
                $is_cat_selected = "";
                $where = "";
$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT id FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id =0 ORDER BY category_title ASC" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
$qry_limit = "SELECT 
              * 
			  FROM ".$tblprefix."thirdlevel_content_category 
              WHERE
              ".$tblprefix."thirdlevel_content_category.parent_id=0  
              ORDER BY content_order ASC LIMIT $startRow,$maxRows";
$rs_limit = $db->Execute($qry_limit);
 $totalcountalpha =  $rs_limit->RecordCount(); 
// $totalRows = $totalcountalpha; 
//$totalPages = ceil($totalRows/$maxRows);


$qry_parents = "SELECT * 
               FROM ".$tblprefix."thirdlevel_content_category 
               WHERE
			   ".$tblprefix."thirdlevel_content_category.parent_id=0  ORDER BY content_order ASC"; 

$rs_parents = $db->Execute($qry_parents);
$totalcountparents =  $rs_parents->RecordCount();


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

//  LOAD ALL PARENT CATEGORIES
$category_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id =0 ORDER BY content_order ASC ";
$rs_category = $db->Execute($category_qry);

$srch=FALSE;
// Searching Algorithm 
if(isset($_POST['search_keyword'])){
 $search_value=$_POST['search_keyword'];
  if($search_value!=NULL and $search_value!=''){
	 $srch=TRUE;
  }
}

if($srch){
?>
<table width="100%" border="1" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">
		    Manage Pages Content
		</td>
  	</tr>
	<tr>
    	<td colspan="8" align="center" >
		  <form name="frm_search"  action="admin.php?act=manage_third_level_categories" method="POST">
		  <table width="90%" border="0" cellspacing="2" cellpadding="2" class="txt">
		  <tr>
		  <td>
		  <input type="text" name="search_keyword" value="" size="90" />
		  </td>
		  <td>
		  <input type="submit" name="Find" />
		  </td>
		  </tr>
		  </table>
		  </form>
		</td>
	</tr>	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Pages content Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false">
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	
  <tr>
    <td>
		<form name="managecontentfrm" action="admin.php?act=thirdlevel_cate_management" method="POST" onsubmit="return validate_contant()" enctype="multipart/form-data">
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="2" class="txt">
			<tr class="tabheading">
				<td>
					<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="5%">Menu Order</td>
						<td width="5%">
						<input type="submit" title="Save Ordering" name="sbt_ordering" value="" class="save_icon" />
						</td>
					</tr>
					</table>
				</td>
			  <td width="65%">Category Name</td>
			  <td width="12%">Options</td>
	      </tr>
		<?php if($totalcountalpha >0){
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   }
while(!$rs_limit->EOF){
// Searching Algorithm 
/*
if(isset($_POST['search_keyword'])){
 $search_value=$_POST['search_keyword'];
  if($search_value!=NULL and $search_value!=''){
  $second_level_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category 
  WHERE 
  parent_id = ".$rs_limit->fields['id']." 
  AND 
  category_title LIKE '%".$search_value."%' 
  ORDER BY 
  content_order ASC";
  }else{
*/
  $second_level_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id = ".$rs_limit->fields['id']." ORDER BY content_order ASC";
  /*
  }	
  }	
  */	
	$second_level_rs = $db->Execute($second_level_qry);
	$second_level_counter =  $second_level_rs->RecordCount();
  	     if($second_level_counter > 0){
             while(!$second_level_rs->EOF){
             // Searching Algorithm 
                if(isset($_POST['search_keyword'])){
 $search_value=$_POST['search_keyword'];
  if($search_value!=NULL and $search_value!=''){
  $third_level_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category 
  WHERE 
  parent_id = " . $second_level_rs->fields['id']." 
  AND  
  category_title LIKE '".$search_value."%'  
  ORDER BY  
  content_order ASC";
  }else{
  $third_level_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id = " . $second_level_rs->fields['id']." ORDER BY content_order ASC";

  }	
  }
					$third_level_rs = $db->Execute($third_level_qry);
					$third_level_counter =  $third_level_rs->RecordCount();
                if($third_level_counter > 0){
									while(!$third_level_rs->EOF){
									?>
                                    <tr bgcolor="#EDEDED" onmouseover="this.style.backgroundColor = '#fff'" onmouseout="this.style.backgroundColor = '#EDEDED'">
                                    <td>
									<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order2[<?php echo $third_level_rs->fields['id']; ?>]" id="menu_order2[<?php echo $third_level_rs->fields['id']; ?>]" type="text" value="<?php echo $third_level_rs->fields['content_order'];?>"/>
									</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-&nbsp;<?php 
									echo $third_level_rs->fields['category_title'];
									?> (3rd Level)</td>
                                    
                                    <td>
                                    <a href="admin.php?act=add_content_pages&amp;id=<?php echo base64_encode($third_level_rs->fields['id']);?>&amp;request_page=thirdlevel_cate_management&menuname=<?php echo addslashes($rs_limit->fields['category_title']) . '->' . addslashes($second_level_rs->fields['category_title']) .'->'. addslashes($third_level_rs->fields['category_title']);?>"><img src="<?php MYSURL?>graphics/contents.gif" border="0" title="content categories" /></a>&nbsp;&nbsp;<a href="admin.php?act=edit_categoreis_third&amp;id=<?php echo base64_encode($third_level_rs->fields['id']);?> &amp;request_page=thirdlevel_cate_management"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;<a href="admin.php?act=manage_third_level_categories&amp;mode=del_category&amp;id=<?php echo base64_encode($third_level_rs->fields['id']); ?>&amp;request_page=thirdlevel_cate_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a></td>
                                    </tr>
                                    <?php
									$third_level_rs->MoveNext();
									}
								}
					$second_level_rs->MoveNext();
					}
					}
					$rs_limit->MoveNext();
					}
	?>
	<tr>
	<td>&nbsp;</td>
	</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Content Page Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
		<input type="hidden" name="mode" value="change_ordering" />
		<input type="hidden" name="act" value="manage_third_level_categories" />
		<input type="hidden" name="request_page" value="thirdlevel_cate_management" />
		</form>
	</td>
  </tr>
</table>
<?php }else{ ?>
<table width="100%"  class="table table-hover" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">
		    Manage Content Pages	</td>
  	</tr>
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Content pages Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false">
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
 <form name="managecontentfrm" action="admin.php?act=thirdlevel_cate_management" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
 <div class="border_div_categories"  align="center">				
<table cellpadding="1" cellspacing="1" border="0" >
				
				<tr style="margin-top:15px;"  >
					<td class="txt2">Select Parent Content Title :</td>
					<td>
					<select name="cat_parent" class="fields"  id="page_parent" onchange="get_sub_cat('sub_category', this.value, '<?php echo MYSURL."ajaxresponse/sub_category.php"?>')">
						<option value="0">Parent Content Title</option>
						<?php
						while(!$rs_category->EOF){?>
							<option value="<?php echo $rs_category->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_category->fields['category_title'];  ?></option>
						<?php
						$rs_category->MoveNext();
						}?>			
					</select>					
					</td>
				</tr>
</table>
</div>

	<!--2nd level category start from -->
	<div class="border_div_categories"  align="center" id="sub_category">				
		
	</div>
<!--2nd level category upto here-->
 
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt2">Content Name: </td>
				<td>&nbsp;  </td>
				</tr>
				<tr>
                                    <td class="txt1">&nbsp;</td>
				<td>
				<input name="categoryname" id="categoryname" value="" type="text" size="55"  maxlength="100" />*
				</td>
				</tr>
<?php 
				if($totallanguages>0){ 
					while(!$rs_language->EOF){
//					echo '<tr>
//					<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
//					<td>
//					<input name="categoryname_'.$rs_language->fields['id'].'" id="categoryname_'.$rs_language->fields['id'].'" value="" type="text" size="55"  maxlength="100" />
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
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Content" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="manage_third_level_categories">
		<input type="hidden" name="act2" value="manage_third_level_categories">
        <input type="hidden" name="id" value="<?php	echo base64_encode($rs_limit->fields['id']); ?>" />
		<input type="hidden" name="request_page" value="thirdlevel_cate_management" />
					</td>
				</tr>
</form> 
  </div>  
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<form name="managecontentfrm" action="admin.php?act=thirdlevel_cate_management" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="2" class="txt">
			<tr class="tabheading">
				<td>
					<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="5%">Menu Order</td>
						<td width="5%">
						<input type="submit" title="Save Ordering" name="sbt_ordering" value="Save order" class="save_icon" />
						</td>
					</tr>
					</table>
				</td>
			  <td width="65%">Category Name</td>
			  <td width="12%">Options</td>
	      </tr>
		<?php if($totalcountalpha >0){
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
			   while(!$rs_limit->EOF){
		       if($rs_limit->fields['parent_id']==0){
		?><tr bgcolor="#E7DAE7" onmouseover="this.style.backgroundColor = '#D8BDD8'" onmouseout="this.style.backgroundColor = '#E7DAE7'">
					    <td valign="top">
					<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['id']; ?>]" id="menu_order[<?php echo $rs_limit->fields['id']; ?>]" type="text" value="<?php echo $rs_limit->fields['content_order'];?>"/>
					</td>
						<td <?php if($rs_limit->fields['parent_id']==0){ echo 'class="txt_bold" ';} ?> valign="top">
						<?php 
						if($rs_limit->fields['parent_id']!=0){$space="|-&nbsp;";}else{$space="";}
							echo $space.$rs_limit->fields['category_title'];
						?> (1st Level)
						</td>
						<td valign="top">
						<a href="admin.php?act=add_content_pages&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;request_page=thirdlevel_cate_management&menuname=<?php echo addslashes($rs_limit->fields['category_title']);?>">
						<img src="<?php MYSURL?>graphics/contents.gif" border="0" title="content categories" />
						</a>
						
						
						<a href="admin.php?act=edit_categoreis_third&amp;mode=edit&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=thirdlevel_cate_management">
						<img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" />
						</a>
						
						&nbsp;
				<?php if($rs_limit->fields['id']!= 240){ ?>			
				<a href="admin.php?act=manage_third_level_categories&amp;mode=del_category&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=thirdlevel_cate_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
						<?php }  ?>
                       </td>
					</tr>
	<?php 
	}
	
	
	$second_level_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id = ".$rs_limit->fields['id']." ORDER BY content_order ASC";
	$second_level_rs = $db->Execute($second_level_qry);
	$second_level_counter =  $second_level_rs->RecordCount();
	if($second_level_counter > 0){
	while(!$second_level_rs->EOF){
	?>
                            <tr bgcolor="#DBDBDB" onmouseover="this.style.backgroundColor = '#CBC1C1'" onmouseout="this.style.backgroundColor = '#DBDBDB'">
                            <td><input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order2[<?php echo $second_level_rs->fields['id']; ?>]" id="menu_order2[<?php echo $second_level_rs->fields['id']; ?>]" type="text" value="<?php echo $second_level_rs->fields['content_order'];?>"/></td>
							
                            <td>|-&nbsp;<?php 
							echo $second_level_rs->fields['category_title'];
							?> (2nd Level)</td>
                            <td>
							<a href="admin.php?act=add_content_pages&amp;id=<?php echo base64_encode($second_level_rs->fields['id']);?>&amp;request_page=thirdlevel_cate_management&menuname=<?php echo addslashes($rs_limit->fields['category_title']) . '->' . addslashes($second_level_rs->fields['category_title']);?>">
							<img src="<?php MYSURL?>graphics/contents.gif" border="0" title="content categories" />
							</a>&nbsp;&nbsp;
                            
                            <a href="admin.php?act=managecategories&amp;mode=edit&amp;id=<?php echo base64_encode($second_level_rs->fields['id']);?>&amp;parentid=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=thirdlevel_cate_management"  >
							<img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" />
							</a>&nbsp;
							<a href="admin.php?act=manage_third_level_categories&amp;mode=del_category&amp;id=<?php echo base64_encode($second_level_rs->fields['id']); ?>&amp;request_page=thirdlevel_cate_management" onClick="return confirm('Are you sure you want to Delete?')">
							<img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" />
							</a>
							</td>
                            </tr>
    <?php
$third_level_qry = "SELECT * FROM ".$tblprefix."thirdlevel_content_category WHERE parent_id = " . $second_level_rs->fields['id']." ORDER BY content_order ASC";
					$third_level_rs = $db->Execute($third_level_qry);
					$third_level_counter =  $third_level_rs->RecordCount();
				    if($third_level_counter > 0){
									while(!$third_level_rs->EOF){
									?>
                                    <tr bgcolor="#EDEDED" onmouseover="this.style.backgroundColor = '#fff'" onmouseout="this.style.backgroundColor = '#EDEDED'">
                                    <td>
									<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order2[<?php echo $third_level_rs->fields['id']; ?>]" id="menu_order2[<?php echo $third_level_rs->fields['id']; ?>]" type="text" value="<?php echo $third_level_rs->fields['content_order'];?>"/>
									</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-&nbsp;<?php 
									echo $third_level_rs->fields['category_title'];
									?> (3rd Level)</td>
                                    
                                    <td>
                                    <a href="admin.php?act=add_content_pages&amp;id=<?php echo base64_encode($third_level_rs->fields['id']);?>&amp;request_page=thirdlevel_cate_management&menuname=<?php echo addslashes($rs_limit->fields['category_title']) . '->' . addslashes($second_level_rs->fields['category_title']) . '->' . addslashes($third_level_rs->fields['category_title']);?>"><img src="<?php MYSURL?>graphics/contents.gif" border="0" title="content categories" /></a>&nbsp;&nbsp;
                                    <a href="admin.php?act=edit_categoreis_third&amp;id=<?php echo base64_encode($third_level_rs->fields['id']);?> &amp;request_page=thirdlevel_cate_management"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_third_level_categories&amp;mode=del_category&amp;id=<?php echo base64_encode($third_level_rs->fields['id']); ?>&amp;request_page=thirdlevel_cate_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a></td>
                                    </tr>
                                    <?php
									$third_level_rs->MoveNext();
									}
								}
								$second_level_rs->MoveNext();
							}
						}
						$rs_limit->MoveNext();
					}
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							
							<?php if ($pageNum  > 0) {?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							<?php }
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
                                                        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							if ($pageNum < $totalPages - 1){
							?>
                                                        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php if(isset($_GET['search'])){echo $_GET['search'];}?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Category Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
		<input type="hidden" name="mode" value="change_ordering" />
		<input type="hidden" name="act" value="manage_third_level_categories" />
		<input type="hidden" name="request_page" value="thirdlevel_cate_management" />
		</form>
	</td>
  </tr>
</table>
<?php }

//echo $where;?>

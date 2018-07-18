<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$mode = '';
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."jobs job  ORDER BY job.job_id ASC " ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT 
              job.*,
              cont.Country as cnt_name,
              stat.Region,
              city.name as city_name,
              comp.company_name
              FROM 
              ".$tblprefix."jobs job
              LEFT JOIN
              ".$tblprefix."countries cont
              ON
              job.country = cont.CountryId
              LEFT JOIN
              ".$tblprefix."state stat
              ON
              stat.RegionId = job.state 
              LEFT JOIN
              ".$tblprefix."city city
              ON
              city.id = job.city
              LEFT JOIN
              ".$tblprefix."company comp
              ON
              comp.company_id = job.company
              ORDER BY 
              job.job_id ASC
              LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//echo "<pre>"; print_r($rs_limit); exit;
// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Jobs
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number Of Jobs Found: <?php echo $totalcountalpha ?></td>
	</tr>
<!--	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>-->
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
<!--				<tr>
				<td class="txt1">Profile Category</td>
				<td>
				<input type="text" name="property_category_name" class="fields"  id="property_category_name" value=""  />
 				</td> 
				</tr>-->
				
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
					AND field_name='cate_title' 
					AND fld_type='cate_type'"
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
//			<td class="txt1" >('.$rs_language->fields['Lan_name'].') </td>
//			<td >
//			<input  class="fields" name="property_category_name_'.$rs_language->fields['id'].'" id="property_category_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
//			</td>
//			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
</table>				
</div>
<div class="border_div_categories"  align="center">				
<!--		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Profile Category" class="button" />
		</td>
		</tr>
		</table>-->
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="manage_property">
		<input type="hidden" name="act2" value="manage_property">
<!--		<input type="hidden" name="id" value="<?phpecho  echo base_en64code($id); ?>">-->
		<input type="hidden" name="request_page" value="property_management" />
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
 <form name="ordering_menu" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data"> 
	<td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="15%">
					<table class="txt" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="5%">Jobs Order
						<input type="submit" title="Save Ordering" name="sbt_ordering" value="" class="save_icon" />
						</td>
					</tr>
					</table>
				</td>
                <th width="30%">Job Title</th>
                <th>Description</th>
                <th>Company</th>
                <th>Country</th>
                <th>state</th>
                <th>city</th>
<!--				<th width="5%">Options</th>-->
		    </tr>
		<?php 
		if($totalcountalpha >0){
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
			   while(!$rs_limit->EOF){
		?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					    <td valign="top">
					<?php if($rs_limit->fields['job_id']==24){ ?>
 <input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['id']; ?>]" id="menu_order[<?php echo $rs_limit->fields['id']; ?>]" type="text" value="0"/>
 					<?php }else{ ?>
					<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['job_id']; ?>];" id="menu_order[<?php echo $rs_limit->fields['job_id']; ?>]" type="text" value="<?php echo $rs_limit->fields['job_orderdering'];?>"/>
				<?php	} ?>
					</td>
                        <td valign="top"><?php echo $rs_limit->fields['job_title']; ?></td>
                        <td><?php echo $rs_limit->fields['job_description']; ?></td>
                        <td><?php echo $rs_limit->fields['company_name']; ?></td>
                        <td><?php echo $rs_limit->fields['cnt_name']; ?></td>
                        <td><?php echo $rs_limit->fields['Region']; ?></td>
                        <td><?php echo $rs_limit->fields['city_name']; ?></td>
<!--						<td valign="top">
							<a href="admin.php?act=update_property&amp;id=<?php echo base64_encode($rs_limit->fields['job_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_property&amp;mode=del_category&amp;id=<?php echo base64_encode($rs_limit->fields['job_id']); ?>&amp;request_page=property_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>-->
					</tr>
			<?php 
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
					<td colspan="14" class="errmsg"> No Property type Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
	    <input type="hidden" name="mode" value="order_menu">
		<input type="hidden" name="act" value="manage_property">
<!--		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">-->
		<input type="hidden" name="request_page" value="property_management" />
		</form>
		
  </tr>
</table>
</div></div>
<?php //echo $where;?>


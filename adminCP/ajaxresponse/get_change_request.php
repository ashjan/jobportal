<?php
include('root.php');
include($root.'include/file_include.php');

 
	  $pm_id=$_GET['pm_id'];
      $propid=$_GET['propid'];
     
	  	
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}

if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."change_request WHERE property_id=".$propid." AND pm_id=".$pm_id; 
$rs_faq = $db->Execute($qry_faq);

$totalcountalpha = $rs_faq ->RecordCount();

$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5
?>



<div id="get_change_requests">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="7" align="right">Total Change Requests Found: <?php echo $totalcountalpha ?></td>
		  </tr>
		<tr class="tabheading">
		  <td colspan="7" align="right">
          <!--<a href="<?php MYSURL?>admin.php?act=add_property_manager&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /></a>-->
          
          </td>
		  </tr>

		  
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="15%">Property Manager</td>
				<td width="15%">Property</td>
				<td width="20%">Request Text</td>
				<td witth="20%">Request Date</td>
				<td witth="15%">Options</td>
			
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_faq->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
					  <td  valign="top"><?php 
					  $qry_limit = "SELECT * FROM ".$tblprefix."property_manager WHERE id=".$rs_faq->fields['pm_id'];
$rs_limit = $db->Execute($qry_limit);
					  echo $rs_limit->fields['first_name']; echo '&nbsp;';  echo $rs_limit->fields['last_name'];  ?></td>
					  <td valign="top">
					  <?php 
					  $qry_limit1 = "SELECT * FROM ".$tblprefix."properties WHERE id=".$rs_faq->fields['property_id'];
                      $rs_limit1 = $db->Execute($qry_limit1);
					  echo $rs_limit1->fields['property_name']; ?></td>
						<td valign="top"><?php echo stripslashes($rs_faq->fields['request_text']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_faq->fields['request_date']); ?></td>
						<td >
						<?php if($rs_faq->fields['request_status']==0){ 
					  ?>
					  <a href="admin.php?act=change_request&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_faq->fields['id']); ?>&amp;request_page=mng_chage_request">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=change_request&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_faq->fields['id']); ?>&amp;request_page=mng_chage_request">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
					<a href="admin.php?act=edit_change_request&amp;id=<?php  echo base64_encode($rs_faq->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				
				<a href="admin.php?act=change_request&amp;mode=delpage&amp;id=<?php echo base64_encode($rs_faq->fields['id']); ?>&amp;request_page=mng_chage_request" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
		   </td>
					</tr>
					
			<?php $rs_faq->MoveNext();
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
					<td colspan="13" class="errmsg"> No Change Request Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
</div>


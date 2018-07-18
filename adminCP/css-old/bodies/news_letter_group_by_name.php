<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."newsletter_groups" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."newsletter_groups LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<form action="admin.php" enctype="multipart/form-data" method="post" name="delete_form" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Newsletter Group Name </td>
  	</tr>
	<tr class="tabheading" align="right">
		<td colspan="10">
			<a href="admin.php?act=add_group"><img src="<?php MYSURL?>graphics/add.png" border="0" title="Add News Letter" /></a>		</td>
	</tr>
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td></tr>
  
 
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			
		
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="3%">Sr#</td>
				<td width="26%">Group Name</td>
				<td width="11%">Options</td>
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
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['group_name_des']); ?></td>
					
						<td valign="top">
							<a href="admin.php?act=edit_news_letter_group_by_name&amp;newsid=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=news_letter_group_by_name"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit NewsLetter" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=news_letter_group_by_name&amp;mode=delletter&amp;newsid=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=news_letter_group_by_name" onclick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>											</td>
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
							<input type="hidden" name="act" value="news_letter_group_by_name">		
							<input type="hidden" name="mode" value="delete">						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=news_letter_group_by_name&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
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
							<a id="<?php echo '0' ?>" href="admin.php?act=news_letter_group_by_name&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=news_letter_group_by_name&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							
							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=news_letter_group_by_name&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
							 <a href="admin.php?act=news_letter_group_by_name&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Newsletter Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	
    </td>
  </tr>
</table>
<?php //echo $where;?>
</form>
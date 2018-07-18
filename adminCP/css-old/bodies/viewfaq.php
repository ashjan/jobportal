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

$qry_faq = "SELECT * FROM ".$tblprefix."faq" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."faq LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<form action="admin.php" enctype="multipart/form-data" method="post" name="delete_form" >
<table width="100%" border="0" cellspacing="5" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage FAQ's </td>
  	</tr>
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td></tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr class="tabheading">
			  <td colspan="2">
			   </td>
			  
			  <td colspan="5" align="right">Total FAQ's Found: <?php echo $totalcountalpha ?></td>
		    </tr>
		
		    <tr height="5%">
			  <td colspan="7" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="10%">Sr#</td>
			  <td width="70%">Question</td>
			  <td width="20%" align="right">Options</td>
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
						<td valign="top">
						     <?php echo stripslashes(setWarp($rs_limit->fields['question'],95)); ?>	</td>
						<td valign="top" class="tabheading" align="right">
														
							<a href="admin.php?act=addfaq&amp;faqid=<?php echo base64_encode($rs_limit->fields['id']);?>" ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit FAQ" /></a>&nbsp;&nbsp;
							
							<?php if($rs_limit->fields['status'] == '0'){?>
								<a href="admin.php?act=viewfaq&amp;mode=updatefaqstatus&amp;faqid=<?php echo base64_encode($rs_limit->fields['id']); ?>&status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=faq_get" ><img src="<?php MYSURL?>graphics/deactivate.gif" title="Click to Approve " border="0" /></a>&nbsp;&nbsp;
							<?php }else{?>
								<a href="admin.php?act=viewfaq&amp;mode=updatefaqstatus&amp;faqid=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;status=<?php echo $rs_limit->fields['status']; ?> &amp;request_page=faq_get" ><img src="<?php MYSURL?>graphics/activate.gif" title="Click to Deactivate " border="0" /></a>&nbsp;&nbsp;
							<?php }?>
							
							<a href="admin.php?act=viewfaq&amp;mode=delfaq&amp;faqid=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=faq_get" onclick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>	
		                   
                            <a class="tabheading" href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"><img src="<?php MYSURL?>graphics/data.gif" width="15" height="18" border="0" title=" Click here to view the Answer " /></a>
	    </td>
	  </tr>
      <tr class="tabheading">
          <td colspan="7">
          <div id="controls_<?php echo $rs_limit->fields['id']; ?>" class="add_subscriber txt" >
           <table cellpadding="5" cellspacing="5" border="0" >
                <tr>
                    <td width="50%" class="txt">
                       <?php echo $rs_limit->fields['answer']; ?>
                    </td>
               </tr>                    
           </table>                     
          </div>
          </td>
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
							<input style="cursor:pointer;display:none;" type="submit" name="delete" id="close" value="Delete All" />
							<input type="hidden" name="act" value="viewfaq">		
							<input type="hidden" name="mode" value="delete">
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
					<td colspan="13" class="errmsg"> No FAQ's Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </tr>
</table><?php //echo $where;?>
</form>
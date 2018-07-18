<?php
include('root.php');
include($root.'include/file_includes.php');
    $type_id = $_GET['id'];
    $maxRows = 20;


if(isset($_GET['sortby']))
	{
		if($_GET['orderby']=='ASC'){
			$orderby = 'ASC';
			
		}
		$orderbypag = $_GET['orderby'];
		$sortby = $_GET['sortby'];
	}
	else
	{
		$orderbypag = 'ASC';
		$orderby    = 'ASC';
		$sortby     = 'id';
	}	




if (empty($_GET['pageNum'])){ $pageNum=0;}else{if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}}
$startRow = $pageNum * $maxRows;
if($type_id != ''){
	$qry_faq = "SELECT * FROM ".$tblprefix."users WHERE pm_status= ".$type_id."  ORDER BY ".$sortby." " ;
}
else {
	$qry_faq = "SELECT * FROM ".$tblprefix."users ORDER BY ".$sortby." " ;
	}
$rs_faq = $db->Execute($qry_faq);
if($rs_faq)
{
    $count_add =  $rs_faq->RecordCount();
}
else
{
    $count_add = 0;
}
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
$vpropertymanager=$tblprefix."users";
if($type_id != ''){					
$qry_limit = "SELECT *
					FROM ".$vpropertymanager." 
					WHERE pm_status= ".$type_id." 
					ORDER BY ".$sortby." 
					LIMIT $startRow,$maxRows"; 
} else {
	$qry_limit = "SELECT *
					FROM ".$vpropertymanager." 
					ORDER BY ".$sortby." 
					LIMIT $startRow,$maxRows";
	}
//echo $qry_limit; exit;						
$rs_limit = $db->Execute($qry_limit);

if($rs_limit)
{
    $totalcountalpha =  $rs_limit->RecordCount();
}
else
{
    $totalcountalpha = 0;
}

?>
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		  <tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=managepropertymanager&amp;sortby=<?php echo "first_name"; ?>"><b style="color:#000">First Name;</b></a></td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=managepropertymanager&amp;sortby=<?php echo "last_name"; ?>"><b style="color:#000">Last Name;
                </b></a></td>
				<td width="20%">Email Address</td>
                <td width="20%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=managepropertymanager&amp;sortby=<?php echo "town"; ?>"><b style="color:#000">Town<br/>&nbsp;&nbsp;&nbsp;&nbsp;
                </b></a></td>
				<td witth="15%">Phone Number</td>
				<td width="10%">Options</td>
		    </tr>
		  <?php 
		  if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					  <td valign="top"><?php echo ++$i; ?></td>
					  <td  valign="top">
					  <?php 
					  echo stripslashes($rs_limit->fields['first_name']); 
					  ?>
					  </td>
					  <td valign="top"><?php echo stripslashes($rs_limit->fields['last_name']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['email_address']); ?></td>
					
						<td valign="top"><?php echo stripslashes($rs_limit->fields['town']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['phone_number']); ?></td>
						<td >
                                                    
                                                    <?php if($rs_limit->fields['consultant_check']==1){ 
					  ?>
                                                    <a href="admin.php?act=managepropertymanager&amp;m_status=<?php echo $rs_limit->fields['consultant_check'];?>&amp;mode=make_consultant&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=managepropertymanager&amp;m_status=<?php echo $rs_limit->fields['consultant_check'];?>&amp;mode=make_consultant&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
                                                    
						<?php if($rs_limit->fields['pm_status']==0){ 
					  ?>
					  <a href="admin.php?act=managepropertymanager&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=managepropertymanager&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
						<a href="admin.php?act=edit_users&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=managepropertymanager&amp;mode=delpage&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
							
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
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;sortby=<?php echo $sortby; ?>&amp;orderby=<?php echo $orderbypag; ?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
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
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;sortby=<?php echo $sortby; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;filter=enable&amp;statusid=<?php echo $type_id; ?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=managepropertymanager&amp;pageNum=<?php echo $i; ?>&amp;sortby=<?php echo $sortby; ?>&amp;filter=enable&amp;statusid=<?php echo $type_id; ?>"><?php echo $i+1; ?></a>
							<?php 

							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							
							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=managepropertymanager&amp;pageNum=<?php echo $totalPages-1;?>&amp;sortby=<?php echo $sortby; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;filter=enable&amp;statusid=<?php echo $type_id; ?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=managepropertymanager&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;sortby=<?php echo $sortby; ?>&amp;filter=enable&amp;statusid=<?php echo $type_id; ?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="13" class="errmsg"> No User Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
		  ?>
		</table>
	
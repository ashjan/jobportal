<?php
if(!isset($_GET['okmsg']) and !isset($_GET['errmsg'])){
	unset($_SESSION["addproperty"]);
}

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



if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE '.$tblprefix.'property_comments.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = '';
}


$qry_prop = "SELECT ".$tblprefix."users.first_name,
					".$tblprefix."users.last_name,
					".$tblprefix."properties.id,
					".$tblprefix."customer.customer_name,
					".$tblprefix."customer.customer_last_name,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_comments.comment_type,
					".$tblprefix."property_comments.status
					FROM
					".$tblprefix."property_comments
					INNER Join ".$tblprefix."properties ON ".$tblprefix."property_comments.property_id = ".$tblprefix."properties.id
					INNER Join ".$tblprefix."customer ON ".$tblprefix."property_comments.customer_id = ".$tblprefix."customer.id 
					INNER Join ".$tblprefix."users ON ".$tblprefix."property_comments.pm_id = ".$tblprefix."users.id".$module_pm_where."";

$rs_prop = $db->Execute($qry_prop);
$count_add =  $rs_prop->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
 $qry_limit = "SELECT ".$tblprefix."users.first_name,
					".$tblprefix."users.last_name,
					".$tblprefix."properties.id as property_id,
					".$tblprefix."property_comments.id ,
					".$tblprefix."customer.customer_name,
					".$tblprefix."customer.customer_last_name,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_comments.comment_type,
					".$tblprefix."property_comments.status
					FROM
					".$tblprefix."property_comments
					INNER Join ".$tblprefix."properties ON ".$tblprefix."property_comments.property_id = ".$tblprefix."properties.id
					INNER Join ".$tblprefix."customer ON ".$tblprefix."property_comments.customer_id = ".$tblprefix."customer.id 
					INNER Join ".$tblprefix."users ON ".$tblprefix."property_comments.pm_id = ".$tblprefix."users.id
					$module_pm_where
					
					ORDER BY ".$tblprefix."property_comments.id DESC LIMIT $startRow,$maxRows";
					
	
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
	<tr>
    	<td id="heading">Manage Comments</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Comments Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<!--Add New Code from here -->
		
		</td>
	</tr>
	<tr>
 <td colspan="6">
 
   
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
        
 <!--Add New Code from here -->
 <tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="9" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
                <td width="5%">Customer Name </td>
                <td width="5%">PM Name</td>
				<td width="5%">Naziv objekta</td>
				<td width="5%">Comment Status</td>
				<td width="8%">Options</td>
		    </tr>
		<?php 
		if($totalcountalpha >0){
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
		
			   $rs_limit->MoveFirst();
			   while(!$rs_limit->EOF){
		?>
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
	<td  valign="top"><?php echo ++$i; ?></td>
	<td valign="top"><?php echo $rs_limit->fields['customer_name']." ".$rs_limit->fields['customer_last_name']; ?></td>
	<td valign="top"><?php echo $rs_limit->fields['first_name'];?>  <?php echo $rs_limit->fields['last_name']; ?> 
	</td>
	<td valign="top"><?php echo $rs_limit->fields['property_name']; ?></td>
	
	
	<td valign="top"><?php if($rs_limit->fields['status']==0){echo '<span style="color:#ff0000">Inactive</span>';}else{echo '<span style="color:#0000ff"> Active </span> ';} ?></td>
	<td valign="top">
	<?php 
	if($_SESSION[SESSNAME]['pm_moduleid']!=2){
	if($rs_limit->fields['status']==0){ 
					  
					  ?>
					  <a href="admin.php?act=comments_management&amp;m_status=0&amp;mode=change_commentstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=comment_management">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Set Active" border="0" />					  </a>
					  <?php }else{ ?>
                        <a href="admin.php?act=comments_management&amp;m_status=1&amp;mode=change_commentstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=comment_management">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Set Inactive" border="0" />						</a>
						<?php }} ?>
	<a href="admin.php?act=editcomments&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;request_page=comment_management">
	<img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" />	</a>
	<a href="admin.php?mode=del_comments&act=comments_management&request_page=comment_management&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>" onclick="return confirm('Are you sure you want to delete this comment?')">
	<img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" />	</a>
	
	
		</td>
	</tr>		
	          </td>
					</tr>
			<?php $rs_limit->MoveNext();
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
					<td colspan="14" class="errmsg"> No Data  Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>


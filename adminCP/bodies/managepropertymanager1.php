<?php

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

if(isset($_GET['sortby']))
	{
		if($_GET['orderby']=='ASC'){
			$orderby='ASC';
			
		}
		$orderbypag=$_GET['orderby'];
		$sortby=$_GET['sortby'];
	}
	else
	{
		$orderbypag='ASC';
		$orderby='ASC';
		$sortby='id';
		
	}	

$maxRows = 20;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."users ORDER BY ".$sortby." " ;
$rs_faq = $db->Execute($qry_faq);

$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5
$vpropertymanager=$tblprefix."users";
$qry_limit = "SELECT *
					FROM ".$vpropertymanager."
					ORDER BY ".$sortby."
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>
<form action="admin.php" enctype="multipart/form-data" method="post" name="add_category">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Property Managers</td>
  	</tr>
  <tr><td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td></tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="7" align="right">Total Property Managers Found: <?php echo $totalcountalpha ?></td>
		  </tr>
		<tr class="tabheading">
		  <td colspan="7" align="right">
          <!--<a href="<?php MYSURL?>admin.php?act=add_users&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /></a>-->
          
          </td>
		  </tr>

		  
			<tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=managepropertymanager&amp;sortby=<?php echo "first_name"; ?>"><b style="color:#000">First Name</b></a></td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=managepropertymanager&amp;sortby=<?php echo "last_name"; ?>"><b style="color:#000">Last Name</b></a></td>
				<td width="20%">Email Address</td>
                <td width="20%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=managepropertymanager&amp;sortby=<?php echo "town"; ?>"><b style="color:#000">Town</b></a></td>
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
					  <td  valign="top"><?php echo stripslashes($rs_limit->fields['first_name']); ?></td>
					  <td valign="top"><?php echo stripslashes($rs_limit->fields['last_name']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['email_address']); ?></td>
						<!--<td  valign="top"><?php //echo stripslashes($rs_limit->fields['business_email']); ?> </td>-->
						<!--<td  valign="top">
						<?php/* $bzi_type = stripslashes($rs_limit->fields['business_type']); 
						if( $bzi_type == 1 ){ echo "Apartment";}else
						if( $bzi_type == 2 ){ echo "Villa";}else
						if( $bzi_type == 3 ){ echo "Hotel Motel";}else
						if( $bzi_type == 4 ){ echo "Room";}else
						if( $bzi_type == 5 ){ echo "Guest House";}*/
						?>
						</td>-->
						<td valign="top"><?php echo stripslashes($rs_limit->fields['town']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['phone_number']); ?></td>
						<td >
						<?php if($rs_limit->fields['pm_status']==0){ 
					  ?>
					  <a href="admin.php?act=managepropertymanager1&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users1">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=managepropertymanager1&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users1">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
						<a href="admin.php?act=edit_users1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=managepropertymanager1&amp;mode=delpage&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=users1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        
						<!--<a class="tabheading" href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"><img src="<?php MYSURL?>graphics/data.gif" width="15" height="18" border="0" title=" Click here to view the Answer " /></a>-->			
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
					<td colspan="13" class="errmsg"> No Property Manager Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </tr>
</table><?php //echo $where;?>
</form>

<?php
// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid']))
{
?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php 
}
?>

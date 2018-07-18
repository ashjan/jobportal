
<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	//var_dump($rs); exit;
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
if(isset($_GET['sortby']))
	{
		
		
		$sortby=$_GET['sortby'];
	}
	else
	{
		
		$sortby='sp_id';
	}	
		
$mode = "";
$maxRows = 40;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
// getting packages record and showing it in the grid


 $qry_packages = "	SELECT sp.`sp_id`, p.`package_name`,p.`package_type`, sp.`amount`, sp.`subscription_date`,
				  	sp.`status`,sp.`expiry_date`,sp.`payment_status`, c.`logo`, emp.`first_name`,
					emp.`last_name` 
					FROM ".$tblprefix."packages p
					JOIN ".$tblprefix."subscribed_packages AS sp ON sp.`package_id` = p.`package_id`
					JOIN ".$tblprefix."companyy AS c ON c.`company_id` = sp.`company_id`
					JOIN ".$tblprefix."users AS emp ON emp.`id` = sp.`emp_id`
					ORDER BY ".$sortby." DESC 
					LIMIT $startRow,$maxRows";
//echo $qry_packages; exit;
$rs_packages = $db->Execute($qry_packages);
//var_dump($rs_packages); exit;
$count_add =  $rs_packages->RecordCount();
  $totalRows = $count_add; 
$totalPages = ceil($totalRows/$maxRows);

$rs_limit = $db->Execute($qry_packages);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Subscribed Packages
</div></div>
<form action="admin.php" enctype="multipart/form-data" method="post" name="add_category">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']);}
		if(!empty($_GET['okmsg'])){ echo base64_decode($_GET['okmsg']);}  ?></td></tr>
  <tr>
  <tr>
    <td >
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="8" align="right">Total Subscribed Packages Items::<?php echo $totalcountalpha ?><br/>
			  </td>
		  </tr>
		

		  
			<tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=subscribed_packages&amp;sortby=<?php echo "package_name"; ?>"><b style="color:#000">Package;</b></a></td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=subscribed_packages&amp;sortby=<?php echo "amount"; ?>"><b style="color:#000">Price;
                </b></a></td>
				
                <td width="20%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=subscribed_packages&amp;sortby=<?php echo "package_type"; ?>"><b style="color:#000">Type<br/>&nbsp;&nbsp;&nbsp;&nbsp;
                </b></a></td>
				<td width="30">Emp:Name</td>
                <td width="30">Company</td>
                <td width="30">Pay: Status</td>
                <td width="30">Pack: Status</td>
                <td width="30">Sub: date</td>
                <td width="30">Exp: date</td>
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
					   <td valign="top"><?php  echo $rs_limit->fields['package_name']; ?></td>
                    <td valign="top"><?php echo $rs_limit->fields['amount']; ?></td>
                    <td valign="top"><?php  echo ucwords($rs_limit->fields['package_type']); ?></td>
                    <td valign="top"><?php  echo ucwords($rs_limit->fields['first_name']." ".$rs_limit->fields['last_name']); ?></td>
                    <td valign="top"><img src="<?php echo MYSURL; ?>../uploads/profile_images/<?php echo $rs_limit->fields['logo']; ?>" /></td>
                    
                    <td valign="top"><?php if($rs_limit->fields['payment_status'] == 0){ echo "Pending";
						} elseif($rs_limit->fields['payment_status'] == 1){ echo "Paid";
						}elseif($rs_limit->fields['payment_status'] == 2) {echo "Part: Paid";} ?></td>
					
                    <td valign="top"><?php if($rs_limit->fields['status'] == 0){ echo "Pend: Approve";
						} elseif($rs_limit->fields['status'] == 1){ echo "Active";
						}elseif($rs_limit->fields['status'] == 2) {echo "Req: Rejected";}
						elseif($rs_limit->fields['status'] == 3) {echo "Expired";}
						elseif($rs_limit->fields['status'] == 4) {echo "Disbable";} ?></td>
                        
                    <td valign="top"><?php  echo $rs_limit->fields['subscription_date']; ?></td>
                    <td valign="top"><?php  echo $rs_limit->fields['expiry_date']; ?></td>
                    <td valign="top">
                    <?php 			##############
		#####  Chceck for current status if pending than will show options for approve reject #######
									##############
					if($rs_limit->fields['status'] == 0){
						// request is made for the first time than show approve and reject link
						?>
						<a href="admin.php?act=subscribed_packages&amp;mode=approve&amp;id=<?php echo base64_encode($rs_limit->fields['sp_id']); ?>&amp;request_page=modify_packages"><img src="<?php MYSURL?>graphics/approve.png" title="Approve" border="0" style="width:31%;" /></a>	&nbsp;&nbsp;
							<a href="admin.php?act=subscribed_packages&amp;mode=reject&amp;id=<?php echo base64_encode($rs_limit->fields['sp_id']); ?>&amp;request_page=modify_packages"><img src="<?php MYSURL?>graphics/Erase.png" title="Reject" border="0" style="width:24%;"/></a>				
					 <?php } elseif($rs_limit->fields['status'] != 3 and $rs_limit->fields['status'] != 2 ) { 
					            if($rs_limit->fields['status'] == 4) {
					 // request is not made for first time so thus show enable disbable   ?>
					 
                     <a href="admin.php?act=subscribed_packages&amp;mode=enable&amp;id=<?php echo base64_encode($rs_limit->fields['sp_id']); ?>&amp;request_page=modify_packages"><img src="<?php MYSURL?>graphics/activate.gif" title="Enable" border="0" /></a>	&nbsp;&nbsp;
                     <?php } else { ?>
							<a href="admin.php?act=subscribed_packages&amp;mode=disable&amp;id=<?php echo base64_encode($rs_limit->fields['sp_id']); ?>&amp;request_page=modify_packages"><img src="<?php MYSURL?>graphics/deactivate.gif" title="Disable" border="0" /></a>
					 <?php }
					  }?>
                    
							
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
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?php echo $_GET['act']; ?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="13" class="errmsg"> No Subscribed Packages Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
        			<input type="hidden" name="act" value="subscribed_packages">
					<input type="hidden" name="request_page" value="subscribed_packages" />
		
	</td>
  </tr>
</table><?php //echo $where;?>
</form>
</div>
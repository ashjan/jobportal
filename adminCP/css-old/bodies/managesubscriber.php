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

$qry_faq = "SELECT * FROM ".$tblprefix."newletter_subscriber";
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."newletter_subscriber LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<script language="javascript">


function outputSelected(){
var chks = document.getElementsByName('cc[]');
var hasChecked = false;
var vvv=new Array();
var y=0;
for (var i = 0; i < chks.length; i++)
{

 if (chks[i].checked){
  hasChecked=true;
  vvv[y]=chks[i].value;
  y++;
 }
}

    if (hasChecked == false){
	alert("Please select at least one.");
	return false;
	}else{
	for(i=0;i<vvv.length;i++){
	 alert(vvv[i]);
	 changestatus(vvv[i]);
	}
	return vvv;
    }

         }
</script>  




<form action="admin.php" enctype="multipart/form-data" method="post" name="delete_form" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Newsletter Subscribers</td>
  	</tr>
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td></tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		<!--<tr class="tabheading">
			  <td colspan="3">SELECT: <a href="javascript:;" onclick="SetAllCheckBoxes('delete_form', 'cc[]', true);"> All </a>
			  		&nbsp;  <a href="javascript:;" onclick="SetAllCheckBoxes('delete_form', 'cc[]', false);"> None </a></td>
			  
			  <td width="50%" align="right"></td>
			  <td colspan="2" align="right">Total Subscriber Found: <?php //echo $totalcountalpha ?></td>
		  </tr>-->
		<tr class="tabheading">
		  <td colspan="6" align="right">
		  <a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false">
		  <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add Subscriber" />
		  </a>
		  </td>
		  </tr>
			<?php
				$newsletter_qry = "SELECT * FROM ".$tblprefix."newsletter ORDER BY id ASC ";
				$rs_newsletter = $db->Execute($newsletter_qry);
			?>
		<tr class="tabheading">
				  		<td colspan="6" align="center">
							<div id="controls" class="add_subscriber"> 
								<table cellpadding="2" cellspacing="2">
									<tr>
										<td class="subscriber_txt">
											Subscriber Email: &nbsp;
											<input name="sub_email" class="fields" id="sub_email" type="text" size="33"  maxlength="30" />								&nbsp;&nbsp;
											<input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add" class="button"   />	
											<input type="hidden" name="mode" value="send">
											<input type="hidden" name="act" value="managesubscriber">
											<input type="hidden" name="request_page" value="subscriber_management"/>									 	
										</td>
									</tr>
					  			</table>
				  			</div> </td>
					</tr>
		    <tr height="5%">
			  <td colspan="6" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td>&nbsp;</td>
				<td colspan="3">Subscriber Email </td>
				<td width="9%">Options</td>
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
					  <td width="2%" valign="top">
					  
					 <!-- <input type="checkbox"  name="cc[]" value="<?php //echo $rs_limit->fields['id']; ?>" />-->
					  
					  </td>
						<td colspan="3" valign="top"><?php echo stripslashes($rs_limit->fields['sub_email']); ?></td>
						<td >
							
							<?php if($rs_limit->fields['status'] == '0'){?>
						<a href="admin.php?act=managesubscriber&amp;mode=updatenewsletterstatus&amp;subid=<?php echo base64_encode($rs_limit->fields['id']); ?>&status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=subscriber_management&amp;" >
							<img src="<?php MYSURL?>graphics/deactivate.gif" title="Click to Approve " border="0" /></a>&nbsp;&nbsp;
							<?php }else{?>
						<a href="admin.php?act=managesubscriber&mode=updatenewsletterstatus&amp;subid=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=subscriber_management" >
							<img src="<?php MYSURL?>graphics/activate.gif" title="Click to Deactivate " border="0" /></a>&nbsp;&nbsp;
							<?php }?>
						<a href="admin.php?act=managesubscriber&amp;request_page=subscriber_management&amp;mode=delsubscriber&amp;subid=<?php echo base64_encode($rs_limit->fields['id']); ?>" onClick="return confirm('Are you sure you want to Delete?')">
							<img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>						</td>
					</tr>
			<?php 
						$rs_limit->MoveNext();
					}
			?>
					<!--<tr>
						<td colspan="5">
							<input style="cursor:pointer;display:none;" type="submit" name="active" id="active" value="Activate All" />
							<input style="cursor:pointer;display:none;" type="submit" name="deactive" id="deactive" value="Deactivate All" />
							<a href="javascript:;" onclick="vvv=outputSelected();" >Activate All</a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="javascript:;" onclick="vvv=outputSelected();" >Deactivate All</a>						</td>
					</tr>
					-->
					<tr>
						<td colspan="9">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=managenewsletter&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
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
							<a id="<?php echo '0' ?>" href="admin.php?act=managenewsletter&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=managenewsletter&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							
							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=managenewsletter&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
							 <a href="admin.php?act=managenewsletter&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="12" class="errmsg"> No Subscriber Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </tr>
</table><?php //echo $where;?>
</form>
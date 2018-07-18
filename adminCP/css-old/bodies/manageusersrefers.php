<?php
	 
// NOT TO BE  CHANGE USE FOR ADMIN ACCESS 

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

//....... query to select the Refferer Reward Amount  from tbl_refers_reward to disply with all users.........
$rerrerer_awardamount="SELECT * FROM tbl_refers_reward WHERE id='1'";
$result = $db->Execute($rerrerer_awardamount);



/*
 $qry_refer_reward = "SELECT  "
					.$tblprefix."refers_reward.id,"
					.$tblprefix."refers_reward.refferer_reward_percentage
					FROM  
					".$tblprefix."refers_reward   LIMIT 1";
		
		$rs_refer_reward = $db->Execute($qry_refer_reward);
		$count_add =  $rs_refer_reward->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);
*/


// Pagination Query 

// $qry_limit = "SELECT * FROM ".$tblprefix."categories  LIMIT $startRow,$maxRows";
   $qry_limit = "SELECT
tbl_refers.referral_id,
tbl_customer.customer_name,
tbl_customer.customer_last_name,
tbl_customer.customer_email,
tbl_customer.customer_password
FROM
tbl_refers
Inner Join tbl_customer ON tbl_customer.id = tbl_refers.referrer_id   
					 LIMIT $startRow,$maxRows";

  $rs_limit = $db->Execute($qry_limit);
  $totalcountalpha =  $rs_limit->RecordCount();
  
  
  //  F U N C T I O N      T O    C O N V E R T    C U R R E N C Y          R A T E 
 /*  function get_currency($from_Currency, $to_Currency, $amount) {
				$amount = urlencode($amount);
				$from_Currency = urlencode($from_Currency);
				$to_Currency = urlencode($to_Currency);
				$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
				$ch = curl_init();
				$timeout = 0;
				curl_setopt ($ch, CURLOPT_URL, $url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$rawdata = curl_exec($ch);
				curl_close($ch);
				$data = explode('bld>', $rawdata);
				$data = explode($to_Currency, $data[1]);
				return round($data[0], 2);
} *///  F  U N C T I O N    T O    C O N V E R T    C U R R E N C Y        R A T E      E N D S
?>


<form action="admin.php" enctype="multipart/form-data" method="post" name="dispaly_referers_reward" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">List of customers Refered </td>
  	</tr>
    

    
  <tr>
      <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
      </td>
  </tr>



 <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			
		
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="7%">Sr#</td>
				<td width="20%">First Name</td>
                
			  <td width="12%">Last Name</td>
                <td width="18%">Email</td>
				<!--<td width="18%">Contact Number</td>-->
				<td width="18%">Refferer Reward (%) </td>
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
					
					 /*$from_Currency="SAR"; 
					 $to_Currency="USD";
					 $amount=$rs_limit->fields['refferer_reward_percentage'];
					 $referer_reward_usd=get_currency($from_Currency, $to_Currency, $amount)*/
					
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['customer_name']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['customer_last_name']); ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['customer_email']); ?></td>
					<!--	<td valign="top"><?php //echo stripslashes($rs_limit->fields['contact_number']); ?></td>-->
						<td valign="top"><?php echo stripslashes($result->fields['refferer_reward_percentage']); ?>&nbsp;(%)</td>
						<td width="7%" valign="top"><?php echo $referer_reward_usd; ?></td>
						
					</tr>
			<?php $rs_limit->MoveNext();
				}
			?>		<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
                          <input type="hidden" name="act" value="manageusersrefers">
                          <input type="hidden" name="mode" value="send">						
                         </td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=managerefersreward&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
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
							<a id="<?php echo '0' ?>" href="admin.php?act=managerefersreward&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=managerefersreward&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=managerefersreward&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?>				    
							<?php }
							if ($pageNum < $totalPages - 1){
							?>
							<a href="admin.php?act=managerefersreward&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
				</tr>
		   <?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Refer Reward Info Found</td>
				</tr>
			<?php
				} // end if($totalcount > 0) 
            
            ?>

     </table>
   </td>   
 </tr>
 </table>



</form>
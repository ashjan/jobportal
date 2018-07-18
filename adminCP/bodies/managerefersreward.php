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


//  T O       A C C E S S       T H E         R e f e r e d     R e w a r d          L I S T

 $qry_refer_reward = "SELECT  "
					.$tblprefix."refers_reward.id,"
					.$tblprefix."refers_reward.refferer_reward_percentage
					FROM  
					".$tblprefix."refers_reward   LIMIT 1";
		
		$rs_refer_reward = $db->Execute($qry_refer_reward);
		$count_add =  $rs_refer_reward->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);



// Pagination Query 

// $qry_limit = "SELECT * FROM ".$tblprefix."categories  LIMIT $startRow,$maxRows";
   $qry_limit = "SELECT "
					.$tblprefix."refers_reward.id," 
					.$tblprefix."refers_reward.refferer_reward_percentage 
					FROM "
					.$tblprefix."refers_reward     
					 LIMIT $startRow,$maxRows";
  $rs_limit = $db->Execute($qry_limit);
  $totalcountalpha =  $rs_limit->RecordCount();
  

?>


<form action="admin.php" enctype="multipart/form-data" method="post" name="dispaly_referers_reward" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Referrers Reward for Deals </td>
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
				<td width="5%">Sr#</td>
				<td width="35%">Refer Reward Percentage (%)</td>
				<td width="25%">Options</td>
           <?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_limit->EOF){
					
					
					 $amount=$rs_limit->fields['refferer_reward_percentage'];
					 $referer_reward_usd=$amount;
					
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['refferer_reward_percentage']); ?> % </td>
						<td valign="top">
						<a href="admin.php?act=editrefersreward&amp;refid=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=managerefersreward"  >
                        <img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit Refers Reward"/></a>&nbsp;&nbsp;
					<!--
					<a href="admin.php?act=managedealscategories&amp;mode=delcategory&amp;catid=<?php 
					// echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=managerefersreward" onclick="return confirm('Are you sure you want to delete this Refers Reward?')"><img src="<?php  //MYSURL ?>graphics/delete.gif" title="Delete" border="0" />
					</a>
					-->
					 </td>
					</tr>
			<?php $rs_limit->MoveNext();
				}
			?>		<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
                          <input type="hidden" name="act" value="managerefersreward">
                          <input type="hidden" name="mode" value="send">						
                         </td>
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
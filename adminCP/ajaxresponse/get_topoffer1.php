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
		
$qry_definvice = "SELECT 
                   id,
				   invoice_defcharg 
                   FROM ".$tblprefix."invoicedef_charge WHERE id='1'"; 
$rs_definvice = $db->Execute($qry_definvice);

if(isset($_GET['mailsentt']))
{

}
else
{ 	
$qry_avgrating1 = "SELECT AVG(rating) as proprating,property_id,pm_id FROM ".$tblprefix."property_reviews GROUP BY property_id ORDER BY proprating DESC LIMIT 0,5"; 
$rs_avgrating1 = $db->Execute($qry_avgrating1);
$totalprops =  $rs_avgrating1->RecordCount();

//echo $qry_avgrating1."<br>";



/*$qry_trunc = "truncate table ".$tblprefix."top_offer_program"; 
$rs_trunc = $db->Execute($qry_trunc);*/

if($totalprops >0)
{
//$countr = 1;
		
   while(!$rs_avgrating1->EOF)
   {

		$qry_pickpm = "SELECT email_address FROM ".$tblprefix."property_manager where id='".$rs_avgrating1->fields['pm_id']."'"; 
		$rs_pickpm = $db->Execute($qry_pickpm);
		
		
		$qryinsrttpoffr = "INSERT INTO ".$tblprefix."top_offer_program SET
													 pm_id='".$rs_avgrating1->fields['pm_id']."',
													 proprty_id = '".$rs_avgrating1->fields['property_id']."',
													 pm_email = '".$rs_pickpm->fields['email_address']."',
													 rating = '".$rs_avgrating1->fields['proprating']."',
													 emailsnt_flag='0',
													 ofr_accptdflag = '0',
													 invoic_charg_amnt = '',
													 invoic_chargdflag = '0',
													 offer_status = '0',
													 timeinserted = '".date("Y-m-d H:i:s")."'
											";
			//echo $qryinsrttpoffr."<br>";							
		$rs_insrttpoffr = $db->Execute($qryinsrttpoffr);
		//$countr++;
   		$rs_avgrating1->MoveNext();
   
   }
}

}

/*$qry_topoffr = "SELECT tpofr.*,pm.first_name,pm.last_name,prop.property_name FROM `tbl_top_offer_program` as tpofr,`tbl_property_manager` as pm,`tbl_properties` as prop WHERE tpofr.proprty_id=prop.id and tpofr.pm_id=pm.id ORDER BY tpofr.timeinserted desc LIMIT 0,5" ;*/
$qry_topoffr = "SELECT top_offer.*,AVG(rev.rating) AS avg_rating,pm.first_name,pm.last_name,prop.property_name  
FROM tbl_top_offer_program AS top_offer
INNER JOIN tbl_property_reviews AS rev ON rev.property_id=top_offer.proprty_id 
INNER JOIN tbl_property_manager AS pm ON pm.id=top_offer.pm_id 
INNER JOIN tbl_properties AS prop ON prop.id=top_offer.proprty_id
  
WHERE top_offer.offer_status=1 AND prop.id=".$propid."

GROUP BY top_offer.proprty_id 
ORDER BY avg_rating DESC 
LIMIT 0 , 18";

$rs_topoffr = $db->Execute($qry_topoffr);
$totoffers =  $rs_topoffr->RecordCount();

//echo $qry_topoffr."<br>";

$maxRows = 18;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$totalRows = $totoffers;
$totalPages = ceil($totalRows/$maxRows);
?>

<div id="get_rates"> 
	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="10%">Property Manager</td>
				<td width="10%">Property<br/>[Vlasnik]</td>
				<td width="10%">Rating<br/>[Ocjena]</td>
				<td width="10%">Email Status</td>
				<td width="10%">Offer Status</td>
				<td width="15%">Invoice Charged Amount<br/>[Iznos zadu&#382;enja]</td>				
				<td width="10%">Options</td>
		    </tr>
			
		<?php 
		if($totoffers >0)
		{
		if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
		
			   while(!$rs_topoffr->EOF)
			   {
			   ?>
			   		<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo $rs_topoffr->fields['first_name']."&nbsp;".$rs_topoffr->fields['last_name']; ?></td>	
						<td valign="top"><?php echo $rs_topoffr->fields['property_name']; ?></td>			
						<td valign="top"><?php 
						$rattodisplay = $rs_topoffr->fields['avg_rating']/2;
						echo number_format($rattodisplay,2);?></td>		
						<td valign="top"><?php 
						if($rs_topoffr->fields['emailsnt_flag']==0)
						{
							
							?>
					   <a href="admin.php?act=top_offersmngmnt1&amp;mode=senmailtopm&amp;offerid=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang1">Send Email</a>
							<?php
						}
						else
						{
							echo 'Sent';
						}
						 ?></td>			
						<td valign="top"><?php 
						if($rs_topoffr->fields['ofr_accptdflag']=='0')
						{
							echo 'Not Accepted';
						}
						else
						{
							echo 'Accepted';
						}
						 ?></td>			
						<td valign="top"><?php 
						if($rs_topoffr->fields['invoic_charg_amnt']!="")
						{
							echo $rs_topoffr->fields['invoic_charg_amnt'];
						}
						else
						{
							echo $rs_definvice->fields['invoice_defcharg'];
						}
						?>€</td>						
						
						<td valign="top">
						<?php if($rs_topoffr->fields['offer_status']==0){ 
					  ?>
					  <a href="admin.php?act=top_offersmngmnt1&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang1">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Activate" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=top_offersmngmnt1&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang1">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Deactivate" border="0" />
						</a>
					  <?php } ?>
							<!--<a href="#"><img src="<?php //MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;-->
							&nbsp;&nbsp;<a href="admin.php?act=top_offersmngmnt1&amp;mode=deloffr&amp;id=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>
					</tr>
					
				<?php
					$rs_topoffr->MoveNext();
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
					<td colspan="14" class="errmsg"> No Offers Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
</div>
<?php //}  // End if ?>

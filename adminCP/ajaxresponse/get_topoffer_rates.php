<?php	
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

/*if(isset($_GET['mailsentt']))
{
}else{*/
 	
//$qry_avgrating1 = "SELECT AVG(rating) as proprating,property_id,pm_id FROM ".$tblprefix."property_reviews GROUP BY property_id ORDER BY proprating DESC LIMIT 0,5";


					$qry_avgrating1 ="SELECT
									".$tblprefix."properties.property_code,
									".$tblprefix."properties.pm_id,
									".$tblprefix."properties.property_name,
									".$tblprefix."properties.region,
									".$tblprefix."properties.street,
									".$tblprefix."properties.town,
									".$tblprefix."properties.postcode,
									".$tblprefix."properties.telephone,
									".$tblprefix."properties.property_url,
									".$tblprefix."properties.numbers_of_stars,
									".$tblprefix."properties.property_thumbnail,
									".$tblprefix."properties.local_bank_account,
									".$tblprefix."properties.properties_slug,
									".$tblprefix."properties.business_type,
									".$tblprefix."properties.latitude,
									".$tblprefix."properties.no_property_rooms,
									".$tblprefix."properties.contact_language,
									".$tblprefix."properties.short_description,
									".$tblprefix."properties.permission_status,
									Avg(".$tblprefix."admn_proprating.rating) AS rating_sum,
									".$tblprefix."properties.id,
									Avg(".$tblprefix."property_reviews.rating) as proprating
									FROM
									".$tblprefix."properties
									Left Join ".$tblprefix."admn_proprating ON ".$tblprefix."admn_proprating.proprty_id = ".$tblprefix."properties.id
									left Join ".$tblprefix."property_reviews ON ".$tblprefix."property_reviews.property_id = ".$tblprefix."properties.id
									WHERE ".$tblprefix."properties.permission_status=1 and ".$tblprefix."properties.topoffr_flag=1 or ".$tblprefix."properties.goldoffr_flag=1
									group by  ".$tblprefix."properties.id order by proprating DESC, rating_sum DESC LIMIT 0,5";

 //echo $qry_avgrating1."<br><br>"; 
 
$rs_avgrating1 = $db->Execute($qry_avgrating1);
$totalprops =  $rs_avgrating1->RecordCount();

//echo $qry_avgrating1."<br>";


if($totalprops >0)
{
//$countr = 1;
   while(!$rs_avgrating1->EOF)
   {
		$qry_pickpm = "SELECT email_address FROM ".$tblprefix."property_manager where id='".$rs_avgrating1->fields['pm_id']."'"; 
		$rs_pickpm = $db->Execute($qry_pickpm);
		 $qryinsrttpoffr = "INSERT INTO ".$tblprefix."top_offer_program SET
													 pm_id='".$rs_avgrating1->fields['pm_id']."',
													 proprty_id = '".$rs_avgrating1->fields['id']."',
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

/*}*/


$qry_topoffr = "SELECT top_offer.*,
AVG( rev.rating ),
pm.first_name,
pm.last_name,
prop.property_name,
tbl_admn_proprating.rating,
prop.pm_type,
((IFNULL(Avg(tbl_admn_proprating.rating), 0 ) + IFNULL((AVG(rev.rating)/2), 0 ))/2) as avg_rate
FROM tbl_top_offer_program AS top_offer
LEFT JOIN tbl_property_reviews AS rev ON rev.property_id = top_offer.proprty_id
LEFT JOIN tbl_property_manager AS pm ON pm.id = top_offer.pm_id
LEFT JOIN tbl_properties AS prop ON prop.id = top_offer.proprty_id
LEFT JOIN tbl_admn_proprating ON tbl_admn_proprating.proprty_id = prop.id
WHERE prop.permission_status=1 and (prop.topoffr_flag=1 or prop.goldoffr_flag=1)
GROUP BY top_offer.proprty_id
ORDER BY avg_rate DESC
LIMIT 0 , 18";

//echo $qry_topoffr; die;
								  
//echo $qry_topoffr;
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
				<td width="10%">Property</td>
				<td width="10%">Rating</td>
				<!--<td width="10%">Email Status</td>-->
				<!--<td width="15%">Offer Status</td>-->
				<td width="15%">Invoice Charged Amount</td>
				<!--<td width="15%">Picture</td>-->
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
						$rattodisplay = $rs_topoffr->fields['avg_rate'];
						//$rattodisplay = $rs_topoffr->fields['ratingss'];
						echo number_format($rattodisplay,2);?></td>		
						<!--<td valign="top"><?php 
						/*if($rs_topoffr->fields['emailsnt_flag']==0)
						{
							
							?>
					   <a href="admin.php?act=top_offersmngmnt&amp;mode=senmailtopm&amp;offerid=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang">Send Email</a>
							<?php
						}else{ ?>
						<a href="admin.php?act=top_offersmngmnt&amp;mode=senmailtopm&amp;offerid=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang"><?php echo 'Sent';?></a>
						<?php } */?>
						
						
						</td>-->			
						<!--<td valign="top"><?php 
						/*if($rs_topoffr->fields['ofr_accptdflag']=='0'){
							echo 'Not Accepted';
						}else{
							echo 'Accepted';
						}
						 */?></td>-->			
						<td valign="top"><?php 
						if($rs_topoffr->fields['invoic_charg_amnt']!=""){
							echo $rs_topoffr->fields['invoic_charg_amnt'];
						}else{
							echo $rs_definvice->fields['invoice_defcharg'];
						}
						?></td>						
						<!--<td valign="top">
						   <img src="<?php //echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php //echo MYSURL."graphics/".$rs_topoffr->fields['img_topoffer'];?>&w=50&h=40&zc=1" border="0" />
					  </td>-->
						<td valign="top">
						<?php if($rs_topoffr->fields['offer_status']==0){ 
					  ?>
					  <a href="admin.php?act=top_offersmngmnt&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;prop_id=<?php echo base64_encode($rs_topoffr->fields['proprty_id']);  ?>&amp;request_page=topoffrmang">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Activate" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=top_offersmngmnt&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;prop_id=<?php echo base64_encode($rs_topoffr->fields['proprty_id']);  ?>&amp&amp;request_page=topoffrmang">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Deactivate" border="0" />
						</a>
					  <?php } ?>
							<!--<a href="#"><img src="<?php //MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;-->
							&nbsp;&nbsp;<a href="admin.php?act=top_offersmngmnt&amp;mode=deloffr&amp;id=<?php echo base64_encode($rs_topoffr->fields['pgm_id']); ?>&amp;request_page=topoffrmang" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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

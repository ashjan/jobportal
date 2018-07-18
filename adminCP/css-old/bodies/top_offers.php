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

/*echo 

"SELECT ca.*,ag.agn_name,ag.country, ag.city as city_id, ag.location, ag.agncy_logo,csr.standard_start_date,csr.standard_rate_price,csr.passengers,csr.doors,csr.conditioner,csr.small_suitcase,csr.large_suitcase,csr.standard_end_date

 FROM ".$tblprefix."car as ca inner JOIN 
".$tblprefix."car_standard_rates as csr ON csr.id=ca.car_standard_rate 

inner JOIN  ".$tblprefix."agency as ag ON ag.agn_id=ca.agency inner JOIN ".$tblprefix."city ON 

city_id=ca.city";
exit();*/

$qry_faq = "SELECT tof.*,pm.first_name,pm.last_name,pr.property_name,
dc.default_commission_rate, pb.id,ca.id FROM ".$tblprefix."top_offers as tof LEFT JOIN 
".$tblprefix."property_manager as pm ON pm.id=tof.pmid LEFT JOIN  ".$tblprefix."properties as pr ON pr.id=tof.property_id LEFT JOIN  ".$tblprefix."default_commission	as dc ON dc.id=tof.dc_id LEFT JOIN  ". $tblprefix."property_booking as pb ON pb.id= tof.pb_id LEFT JOIN ".$tblprefix. "cancellation as ca ON ca.id=tof.ca_id";


$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
										
										
$qry_limit = "SELECT tof.*,pm.first_name,pm.last_name,pr.property_name,dc.default_commission_rate,
pb.id,ca.id FROM ".$tblprefix."top_offers as tof LEFT JOIN  ".$tblprefix."property_manager
as pm ON pm.id=tof.pmid LEFT JOIN  ".$tblprefix."properties as pr ON pr.id=tof.property_id
LEFT JOIN  ".$tblprefix."default_commission	as dc ON dc.id=tof.dc_id LEFT JOIN  ".					 										$tblprefix."property_booking as pb ON pb.id= tof.pb_id LEFT JOIN  ".$tblprefix.
"cancellation as ca ON ca.id=tof.ca_id LIMIT $startRow,$maxRows";
	

$rs_limit = $db->Execute($qry_limit);
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Top Offers</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Top Offers Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<!--<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php //MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>-->
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Default Commission</td>
				<td>
				<input type="text" name="default_commission_rate" class="fields"  id="default_commission_rate" value=""  />
 				</td> 
				</tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Commission" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="default_commission">
		<input type="hidden" name="act2" value="default_commission">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="default_commission_management" />
					</td>
				</tr>
</form> 

  </div>  
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
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="10%">Sr#</td>
               <td width="25%">Property Mangaer</td>
			   <td width="20%">Properties</td>
			   <td width="10%">Commission</td>
			   <td width="10%">Booking</td>
			   <td width="10%">Cancellation</td>
				
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
                        <td valign="top"><?php echo $rs_limit->fields['']."%"; ?></td><!-- pm name-->						
						<td valign="top"><?php echo $rs_limit->fields['']."%"; ?></td><!-- property-->						
						<td valign="top"><?php echo $rs_limit->fields['default_commission_rate']."%"; ?></td><!-- commission-->						
						<td valign="top"><?php echo $rs_limit->fields['']."%"; ?></td><!-- booking-->						
						<td valign="top"><?php echo $rs_limit->fields['']."%"; ?></td><!-- cancellation-->	
						
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
					<td colspan="14" class="errmsg"> No Top offer Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

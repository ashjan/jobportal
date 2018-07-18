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



/*
$qry_topoffr = "SELECT top_offer.*,AVG(rev.rating) AS avg_rating,pm.first_name,pm.last_name,prop.property_name,propcost.standard_rate_price 
FROM tbl_offer_of_week AS top_offer
INNER JOIN tbl_property_reviews AS rev ON rev.property_id=top_offer.property_id 
INNER JOIN tbl_property_manager AS pm ON pm.id=top_offer.pm_id 
INNER JOIN tbl_properties AS prop ON prop.id=top_offer.property_id  
INNER JOIN tbl_standard_rates AS propcost ON propcost.property_id=top_offer.property_id  
GROUP BY top_offer.property_id 
ORDER BY avg_rating DESC 
LIMIT 0 , 18";

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."property_manager";  
$rs_pm = $db->Execute($qry_pm);

$qry_topoffr = "SELECT top_offer.*,pm.first_name,pm.last_name,prop.property_name,propcost.standard_rate_price 
FROM tbl_offer_of_week AS top_offer
LEFT JOIN tbl_property_manager AS pm ON pm.id=top_offer.pm_id 
LEFT JOIN tbl_properties AS prop ON prop.id=top_offer.property_id  
LEFT JOIN tbl_standard_rates AS propcost ON propcost.property_id=top_offer.property_id  
LIMIT 0 , 18"; 
$rs_topoffr = $db->Execute($qry_topoffr);
$totoffers =  $rs_topoffr->RecordCount();
*/


$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."property_manager";  
$rs_pm = $db->Execute($qry_pm);

$qry_topoffr = "SELECT top_offer.*,pm.first_name,pm.last_name,prop.property_name   
FROM tbl_offer_of_week AS top_offer
LEFT JOIN tbl_property_manager AS pm ON pm.id=top_offer.pm_id 
LEFT JOIN tbl_properties AS prop ON prop.id=top_offer.property_id  
LIMIT 0 , 200"; 
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

<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Deal of Week
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
<tr>
  <td  align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
  </td>
</tr>
<tr>
  <td>
  <table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="txt">
    <tr class="tabheading">
     <td colspan="5" align="right">Total Records Found: <?php echo $totoffers ?></td> 
    </tr>
    <tr class="tabheading">
      <td colspan="13" align="right"></td>
      <td  align="right"><a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"> <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /></a></td>
    </tr>
	
      <tr>
      <td colspan="13">
	  <div id="controls" <?php if($_SESSION['record_add_edit']=='Yes'){ ?> style="display:block;" <?php } ?> class="add_subscriber">
<form action="admin.php" enctype="multipart/form-data" method="post" name="testform" >
  <table width="98%" border="0" align="center" cellpadding="13" cellspacing="0" class="txt">
   <tr>
     <td width="30%"></td>
	 <td width="70%"></td>
   </tr>
   
					  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
		  <?php } else {?>
		   <tr>
				<td  >Select Property Manager:</td>
					<td>
					<select name="pm_id" class="fields"   id="pm_id" onchange="get_prop_name_weekoffer('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_weekoffer.php"?>')">
				<option value="0">izaberite vlasnika objekat</option>
				<?php 
   	while(!$rs_pm->EOF){
	echo '<option value="'.$rs_pm->fields['id'].'">'.$rs_pm->fields['first_name'].'  '.$rs_pm->fields['last_name'].'</option>';
	$rs_pm->MoveNext();
					}
				?>					
			</select>						
					</td>
		</tr>  
		<?php }?>
		  
		  
		   <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		  <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
			
<div id="property_id"> 			
<select name="property_id" class="fields"   id="property_id">
	<option value="0">Naziv objekta</option>
		<?php 
		$qry_property = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
		                $rs_property = $db->Execute($qry_property);
						$count_property =  $rs_property->RecordCount();
						$totalproperty = $count_property;
						$rs_property->MoveFirst();
						while(!$rs_property->EOF){
						?>
						<option value="<?php echo $rs_property->fields['id'];?>"> <?php echo $rs_property->fields['property_name']; ?></option>
						<?php
						$rs_property->MoveNext();
						} 
						 ?>				
 </select>				
 </div>	
</td>
        </tr>
		  <?php } else {?>
		  
		  
		  <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
			
<div id="property_id"> 			
<select name="property_id" class="fields"   id="property_id">
	<option value="0">Naziv objekta</option>
						
 </select>				
 </div>	
 
</td>
        </tr>
        <?php }?>
               
				<tr>
				<td class="txt1">Date:<br/>[Datum] </td>
				<td>
				<?php 
				$deal_end_date=date("m/d/Y");
				?>
				<input type="text" name="deal_end_date" id="deal_end_date" value="<?php echo $deal_end_date; ?>" />
				<script language="JavaScript">
			   var o_cal = new tcal ({
			   	// form name
			   	'formname': 'testform',
			   	// input name
			   	'controlname': 'deal_end_date',
			   });

			   // individual template parameters can be modified via the calendar variable
			   o_cal.a_tpl.yearscroll = false;
             </script>
				</td>
				</tr>
				
				<tr>
				<td>Discount Price<br/>[Cijena sa popustom] </td>
				<td>
				<input type="text" name="dprice" class="fields"  id="dprice" value="<?php echo $rs_limit->fields['discount_price']?>"  /> EUR
 				</td> 
				</tr>
	<tr>
    <td>&nbsp;</td>
      <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Submit" class="button" />
      </td>
    </tr>
    <tr>
    
      <td>
	  	<input type="hidden" name="pprice" value="0" />
	  	<input type="hidden" name="mode" value="add">
        <input type="hidden" name="act" value="deal_of_week">
        <input type="hidden" name="act2" value="deal_of_week">
        <input type="hidden" name="request_page" value="dealofweek" />
      </td>
    </tr>
    
  </table>
</form>
 </div>
	  </td>
	  </tr>
<tr height="5%">
  <td colspan="13" ></td>
</tr>


<tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="25%">Property Manager</td>
				<td width="25%">Property<br/>[Kategorije ]</td>
				<td width="15%">Discount<br/>[Popust]</td>			
				<td width="15%">Deal End Date<br/>[Datum završetka ponude]</td>		
				<td width="15%" nowrap="nowrap">Set Deal of Week<br/>[Postavi ponudu nedelje]</td>
		    </tr>
				<?php 
		if($totoffers >0){
				if($pageNum==0){
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   }
			   while(!$rs_topoffr->EOF){
			   ?>
			   		<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo $rs_topoffr->fields['first_name']."&nbsp;".$rs_topoffr->fields['last_name']; ?></td>
						<td valign="top"><?php echo $rs_topoffr->fields['property_name']; ?></td>
						<td valign="top"><?php echo $rs_topoffr->fields['discount_price']; ?> EUR</td>
						<td valign="top"><?php 
						$datetime	= strtotime($rs_topoffr->fields['deal_end_date']);
						echo date("d-m-Y",$datetime); ?></td>
						<td valign="top">
						<?php if($rs_topoffr->fields['deals_status']==0){ 
					  ?>
					  <a href="admin.php?act=deal_of_week&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_topoffr->fields['id']); ?>&amp;request_page=dealofweek">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Activate" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=deal_of_week&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_topoffr->fields['id']); ?>&amp;request_page=dealofweek">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Deactivate" border="0" />
						</a>
					  <?php } ?>
                      
                      
					  &nbsp;&nbsp;&nbsp;&nbsp;
							<a href="admin.php?act=editdeal_of_week&amp;id=<?php echo base64_encode($rs_topoffr->fields['id']); ?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>
                       	<?php if($rs_topoffr->fields['deals_status']==0){ 
					   	  ?>
					 		&nbsp;&nbsp;<a href="admin.php?act=deal_of_week&amp;mode=deloffr&amp;id=<?php echo base64_encode($rs_topoffr->fields['id']); ?>&amp;request_page=dealofweek" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
					  
					  <?php }?>
                       
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
  <td colspan="13"><!-- START: Pagination Code -->
    <div class="txt">
      <div id="txt" align="center"> Showing
        <?php echo ($startRow + 1) ?>
        to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />
        Pages ::
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
        <a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a> &nbsp;
        <?php } 		
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
        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
        <?php } ?>
      </div>
    </div>
    <!-- END: Pagination Code -->
  </td>
</tr>
<?php
	}else{
?>
<tr>
  <td colspan="13" class="errmsg"> No Record Found</td>
</tr>
<?php
				}// end if($totalcount > 0)
?>
</table>
</td>
</tr>
</table>
</div></div>
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

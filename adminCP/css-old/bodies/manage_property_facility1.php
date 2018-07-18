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

$qry_faq = "SELECT * FROM ".$tblprefix."facility_management" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."facility_management "; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



$qry_limit1 = "SELECT * FROM ".$tblprefix."facility_management WHERE property_fac_category=1"; 
$rs_limit1 = $db->Execute($qry_limit1);
$totalcountalpha1 =  $rs_limit1->RecordCount();

$qry_limit2 = "SELECT * FROM ".$tblprefix."facility_management WHERE property_fac_category=2"; 
$rs_limit2 = $db->Execute($qry_limit2);
$totalcountalpha2 =  $rs_limit2->RecordCount();

$qry_limit3 = "SELECT * FROM ".$tblprefix."facility_management WHERE property_fac_category=3"; 
$rs_limit3 = $db->Execute($qry_limit3);
$totalcountalpha3 =  $rs_limit3->RecordCount();



?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Property Facilities</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number Property Facilities Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
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
				<td class="txt1">Facility Name<br/>[Naziv sad]</td>
				<td>
				<input type="text" name="facility_name" class="fields"  id="facility_name" value=""  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Facility Category Type<br/>[Izaberite kategoriju sadr&#382;aja ]</td>
				<td>
				
				<select name="property_fac_category" class="fields"   id="property_fac_category">
				<option value="0">Select Category</option>
				<option value="1">General</option>
				<option value="2">Activities</option>
				<option value="3">Services</option>		
			</select>
				
 				</td> 
				</tr>
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:200px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Insert Facility &nbsp;[Unesite sadr&#382;aj]" class="button" />
                </td>
                </tr>
</table>				
</div>

<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="manage_property_facility1">
		<input type="hidden" name="act2" value="manage_property_facility1">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="property_facility_management1" />
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
				<td width="4%">Sr#</td>
                <td width="15%">Property Facility<br/>[naziv sadr&#382;aja]</td>
				<td width="25%">Facility Category Type<br/>[Izaberite kategoriju sadr&#382;aja]</td>
				<td width="5%">Options</td>
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
                        <td valign="top"><?php echo $rs_limit->fields['facility_name']; ?></td>						
                        <td valign="top"><?php 
						if($rs_limit->fields['property_fac_category']==1){
						echo "General";
						}
						if($rs_limit->fields['property_fac_category']==2){
						echo "Activities";
						}
						if($rs_limit->fields['property_fac_category']==3){
						echo "Services";
						}
						 ?></td>						
						<td valign="top">
							<a href="admin.php?act=edit_property_facility1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_property_facility1&amp;mode=del_category&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=property_facility_management1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>
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
					<td colspan="14" class="errmsg"> No Property type Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

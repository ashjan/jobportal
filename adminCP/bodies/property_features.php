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

$qry_faq = "SELECT * FROM ".$tblprefix."property_features" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."property_features LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Property Features</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Property features Found: <?php echo $totalcountalpha ?></td>
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
				<td class="txt1">Feature title</td>
				<td>
				<input type="text" class="fields" name="feature_title" id="feature_title" />
				</td> 
				</tr>
				
							
				<tr>
				<td class="txt1">Business Description</td>
				<td>
				<textarea rows="2" cols="20" name="business_description" class="smalltxtareas" id="business_description" /></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Checking Times</td>
				<td>
				<input type="text" name="checkin_times" id="checkin_times" class="checkin_times" value="" >
				<script language="JavaScript">
                                var o_cal = new tcal ({
                                    // input name
                                    'controlname': 'checkin_times'
                                });
                                // individual template parameters can be modified via the calendar variable
                                o_cal.a_tpl.yearscroll = false;
                                o_cal.a_tpl.weekstart = 1;
                                </script>
				</td>  
				</tr>
				
				<tr>
				<td class="txt1">Area Activities</td>
				<td>
				<textarea rows="2" cols="20" name="area_activities" class="smalltxtareas" id="area_activities" /></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Driving Directions</td>
				<td>
				<textarea rows="2" cols="20" name="driving_directions" class="smalltxtareas" id="driving_directions" /></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Airports</td>
				<td>
				<textarea rows="2" cols="20" name="airports" class="smalltxtareas" id="airports" /></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Other Transports</td>
				<td>
				<textarea rows="2" cols="20" name="other_transports" class="smalltxtareas" id="other_transports" /></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Policies Disclaimer</td>
				<td>
				<textarea rows="2" cols="20" name="policies_disclaimer" class="smalltxtareas" id="policies_disclaimer" /></textarea>
				</td> 
				</tr>
<?php 
				if($totallanguages>0){ 
					while(!$rs_language->EOF){
					echo '<tr>
					<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
					<td>
					<input name="categoryname_'.$rs_language->fields['id'].'" id="categoryname_'.$rs_language->fields['id'].'" value="" type="text" size="55"  maxlength="100" />
					</td>
					</tr>';
					$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Features" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="property_features">
		<input type="hidden" name="act2" value="property_features">
		<input type="hidden" name="request_page" value="features_management" />
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
				<td width="12%">Feature Title</td>
                <td width="12%">Business Description</td>
				<td width="12%">Checkin Times</td>
				<td width="12%">Area Activities</td>
				<td width="12%">Driving Directions</td>
				<td width="12%">Airports</td>
				<td width="12%">Other Transports</td>
				<td width="12%">Policies Disclaimer</td>
				<td width="11%">Options</td>
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
						<td valign="top"><?php echo $rs_limit->fields['feature_title']; ?></td>
                        <td valign="top"><?php echo $rs_limit->fields['business_description']; ?></td>
						<td valign="top"><?php echo  date("d-M-Y",strtotime(checkin_times)) ?></td>
						<td valign="top"><?php echo $rs_limit->fields['area_activities']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['driving_directions']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['airports']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['other_transports']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['policies_disclaimer']; ?></td>
						
							
						<td valign="top">
							<a href="admin.php?act=editfeatures&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=property_features&amp;mode=del_feature&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=features_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Category Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

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

$qry_faq = "SELECT * FROM ".$tblprefix."room_facility_management ORDER BY id DESC" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

  $qry_limit = "SELECT ".$tblprefix."room_facility_management.*  
                FROM ".$tblprefix."room_facility_management   
                ORDER BY id DESC LIMIT ".$startRow.",".$maxRows;
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_limit1 = "SELECT ".$tblprefix."facility_management.*
  FROM ".$tblprefix."facility_management 
  WHERE property_fac_category=1";
  
$rs_limit1 = $db->Execute($qry_limit1);
$totalcountalpha1 =  $rs_limit1->RecordCount();

$qry_limit2 = "SELECT ".$tblprefix."facility_management.* FROM ".$tblprefix."facility_management WHERE property_fac_category=2"; 
$rs_limit2 = $db->Execute($qry_limit2);
$totalcountalpha2 =  $rs_limit2->RecordCount();

$qry_limit3 = "SELECT ".$tblprefix."facility_management.* FROM ".$tblprefix."facility_management WHERE property_fac_category=3"; 
$rs_limit3 = $db->Execute($qry_limit3);
$totalcountalpha3 =  $rs_limit3->RecordCount();



?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Room Facilities
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
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
     <table cellpadding="1" cellspacing="1" border="0" width="100%" class="table" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Facility Name
				                                    
				</td>
				<td>
				<input type="text" name="facility_name" class="fields"  id="facility_name" value=""  />
 				</td> 
				</tr>
				
				
				<tr>
				<td class="txt1">Facility Name (RUS)</td>
				                            
				<td>
				<input type="text" name="facility_name_rus" class="fields"  id="facility_name_rus" value=""  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Facility Name (MON)</td>
				<td>
				<input type="text" name="facility_name_mon" class="fields"  id="facility_name_mon" value=""  />
 				</td> 
				</tr>
				
				
				<tr>
				<td class="txt1">Facility Category Type</td>
				<td>
				<select name="property_fac_category" class="fields"   id="property_fac_category">
				<option value="0">Izaberite kategoriju sadr&#382;aja</option>
				<option value="1">Pogodnosti u sobi</option>
				<option value="2">Mediji i tehnika</option>
				<option value="3">Kuhinja</option> 
				<option value="4">Kupatilo</option>	
			</select>
				
 				</td> 
				</tr>
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:176px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Submit" class="button" />
                </td>
                </tr>
</table>				
</div>

<tr>
				<td>&nbsp;</td>
				<td>
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act"  value="manage_room_facility">
		<input type="hidden" name="act2" value="manage_room_facility">
		<input type="hidden" name="request_page" value="room_facility_management" />
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
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="4%">Sr#</th>
                <th width="15%">Room Facility</th>
				<th width="25%">Facility Category Type</th>
				<th width="5%">Options</th>
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
                        <td valign="top">
					     <table cellpadding="1" cellspacing="1" border="0" class="txt">
						
						<tr><td>
						<?php echo $rs_limit->fields['facility_name']; ?>
						</td></tr>
						<tr><td>
						<?php 
	$qry_rus=	"SELECT ".$tblprefix."language_contents.translated_text 
			             FROM ".$tblprefix."language_contents 
	WHERE  ".$tblprefix."language_contents.fld_type= 'room_facility' 
    AND ".$tblprefix."language_contents.field_name='room_facility_rus'
	AND ".$tblprefix."language_contents.page_id=".$rs_limit->fields['id'];
						$rs_rus = $db->Execute($qry_rus);
                        $total_rus =  $rs_rus->RecordCount();
						
						if($rs_rus>0){
						$rs_rus->MoveFirst();
						 while(!$rs_rus->EOF){
						   echo " (".$rs_rus->fields['translated_text']." )";
						   $rs_rus->MoveNext();
						 }
						}
						?>
						</td></tr>
						<tr><td>
						<?php 
	$qry_mon=	"SELECT ".$tblprefix."language_contents.translated_text 
			             FROM ".$tblprefix."language_contents 
	WHERE  ".$tblprefix."language_contents.fld_type= 'room_facility' 
    AND ".$tblprefix."language_contents.field_name='room_facility_mon'
	AND ".$tblprefix."language_contents.page_id=".$rs_limit->fields['id'];
						$rs_mon = $db->Execute($qry_mon);
                        $total_mon =  $rs_mon->RecordCount();
						
						if($rs_mon>0){
						$rs_mon->MoveFirst();
						 while(!$rs_mon->EOF){
						   echo " (".$rs_mon->fields['translated_text']." )";
						   $rs_mon->MoveNext();
						 }
						}
						?>
						</td></tr>
						</table>
						</td>						
                        <td valign="top"><?php
                        $room_facility = $rs_limit->fields['room_fac_category']; 
                        switch ($room_facility){
                        	
                        	case 1:
                        		echo "Room Amenities";
                        		break;
                        	case 2:
                        		echo "Media and Technology";
                        		break;
                        	case 3:
                        		echo "Kitchen";
                        		break;
                        	case 4;
                        	echo "Bathroom";
                        	break;
                        	default:
                        		echo "No facility found";
                        }
						
						 ?></td>						
						<td valign="top">
							<a href="admin.php?act=edit_room_facility_management&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_room_facility&amp;mode=del_facility&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=room_facility_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Room type Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>
<?php //echo $where;?>

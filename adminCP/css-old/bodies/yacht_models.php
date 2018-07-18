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

$qrlinit = "SELECT 
            ym.*, 
			agn.agn_name, 
			cat.yatch_category_name 
            FROM " 
			.$tblprefix."yachtmodel as ym 
			INNER JOIN ".$tblprefix."yatch_category as cat ON cat.id=ym.categry 
			INNER JOIN ".$tblprefix."yatchagency as agn ON  agn.agn_id=ym.agncy_id 
			";
			
$rs_limit = $db->Execute($qrlinit);

$totalcountalpha =  $rs_limit->RecordCount();

$qry_room = "SELECT * from ".$tblprefix."yatchagency";   
$rs_car = $db->Execute($qry_room);

$qry_cat= "SELECT * FROM ".$tblprefix."yatch_category"; 
$rs_cat= $db->Execute($qry_cat);

$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);

$totalcountpropertymanag =  $rs_property_manag->RecordCount();


 $qry_yatch = "SELECT * FROM ".$tblprefix."yatch"; 
$rs_yatch = $db->Execute($qry_yatch);
$totalcountalpha2 =  $rs_yatch->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yacht Models</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number of Models Found: <?php echo $totalcountalpha ?></td>
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
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">			</td></tr>

		<tr>
		<td class="txt1">Agency Name</td>
		<td>
			 <?php    $qry_content = "SELECT * FROM  ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
<select name="agency_id" class="fields" id="agency_id" onchange="">
<?php
if($count_add<=0){?>
<option value="0">No Agency Found</option>
<?php
}else{?>
<option value="0">Select Agency</option>	
	<?php while(!$rs_content->EOF)
	{
	?>
<option value="<?php echo $rs_content->fields['agn_id'];?>"><?php echo $rs_content->fields['agn_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    
?>
</select>
</td></tr>
		<?php
			}else{?>
	<tr>
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
				 	<option value="0">Select Yatch Manager</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php //echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['first_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Agency</td>
					<td>
					<div id="agency_name">
						<select name="agency_id" class="fields" id="agency_id">
							<option value="0">First Select PM</option>
						</select>
					</div>
					
					</td>
				</tr>
				
				<?php } ?>
		
				<tr>
				<td class="txt1">Yacht Category</td>
				
				<td>
				<select name="category" id="category"  class="dropfields"  onchange="">
				<option value="0">Select Yacht category</option>
	  <?php while(!$rs_cat->EOF){ ?>
		<option value="<?php echo $rs_cat->fields['id'];?>" ><?php echo $rs_cat->fields['yatch_category_name'];?>
		</option>
	    <?php $rs_cat->MoveNext();
		} ?>			
	</select>
				
				
				
				
				<!--<input type="text" name="category" class="fields"  id="category" value=""  />-->
 				</td> 
				</tr>
				<tr>
				<td class="txt1">Yacht Model</td>
				<td>
				<input type="text" name="yatchmodel" class="fields" id="yatchmodel" value="" />
				 </td> 
				
				<!-- we have to make changes -->
				</tr>
				
				
				
				
				<tr>
				<td class="txt1">Base</td>
				<td>
					<input type="text" name="basey" class="fields"  id="basey" value=""  />
					</td> 
				</tr><tr>
				<td class="txt1">Alternate Base</td>
				<td>
				<input type="text" name="altbasey" class="fields"  id="altbasey" value=""  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">No. of Yachts</td>
				<td>
				<input type="text" name="numy" class="fields"  id="numy" value=""  />
 				</td> 
				</tr>
				
				<!--  changes ends here -->
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add" class="button" />
		</td>
		</tr>
		</table>
</div>

		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="yacht_models">
		<input type="hidden" name="act2" value="yacht_models">
		<input type="hidden" name="request_page" value="yachtmodel_management" />
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
				<td width="5%">Sr#</td>
				 
				<td width="15%">Agency</td>
				<td width="15%">Model</td>
				<td width="15%">Category</td>
				<td width="15%">Base</td>
				<td width="15%">Alternate Base</td>
				<td width="15%">No. of Yachtes</td>
				<td width="5%">Options</td>
		    </tr>
			
		<?php 
		if($totalcountalpha > 0){
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
						<?php  echo $rs_limit->fields['agn_name']; ?>
						
						</td>	
                        
						<td valign="top"><?php echo $rs_limit->fields['model']; ?></td>	
											
						<td valign="top"><?php echo $rs_limit->fields['yatch_category_name']; ?></td>
						
						<td valign="top"><?php echo $rs_limit->fields['basey']; ?></td>						
						
						<td valign="top"><?php echo $rs_limit->fields['alt_base']; ?></td>
						
						<td valign="top"><?php echo $rs_limit->fields['numb_yacht']; ?></td>
						
						<td valign="top">
							<a href="admin.php?act=update_yachtmodel&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=yacht_models&amp;mode=del_model&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=yachtmodel_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Record Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

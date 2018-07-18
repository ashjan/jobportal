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

$qry_room = "SELECT agn_name,agn_id from ".$tblprefix."agency";  
$rs_car = $db->Execute($qry_room);

$qry_cat= "SELECT car_category_name,id FROM ".$tblprefix."car_categories"; 
$rs_cat= $db->Execute($qry_cat);

$qry_faq = "SELECT * FROM ".$tblprefix."car_types" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."car_types LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage car types</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number of car types Found: <?php echo $totalcountalpha ?></td>
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
				<td class="txt1">Car Agency</td>
				<td>
			
		<select name="car_agency" class="fields" id="car_agency" onchange="">
				 	<option value="0">Select Car Agency</option>
					<?php
					$rs_car->MoveFirst();
					while(!$rs_car->EOF){
							echo $rs_car->fields['agn_id'];			
								?>
		  			<option value="<?php echo $rs_car->fields['agn_id'];?>"><?php echo $rs_car->fields['agn_name'];  ?></option>
					<?php
					$rs_car->MoveNext();
					}
					?>			
					</select>					
					
	
		<!--		<input type="text" name="car_types" class="fields"  id="car_types" value=""  />-->
 				</td> 	
				</tr>
				
				<tr>
				<td class="txt1">Car type</td>
				<td>
				<input type="text" name="car_types" class="fields"  id="car_types" value=""  />
 				</td> 
				
				<!-- we have to make changes -->
				</tr>
				
				
				<tr>
				<td class="txt1">Car Category</td>
				
				<td>
				<select name="category" id="category"  class="dropfields"  onchange="">
				<option value="0">Select  Car category</option>
	  <?php while(!$rs_cat->EOF){ ?>
		<option value="<?php echo $rs_cat->fields['id'];?>" 
		<?php //echo $is_cat_selected; ?>><?php echo $rs_cat->fields['car_category_name'];?>
		</option>
	    <?php $rs_cat->MoveNext();
		} ?>			
	</select>
				
				
				
				
				<!--<input type="text" name="category" class="fields"  id="category" value=""  />-->
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Produced</td>
				<td>
					<input type="text" name="produced" class="fields"  id="produced" value=""  />
					</td> 
				</tr><tr>
				<td class="txt1">Car Doors</td>
				<td>
				<input type="text" name="doors" class="fields"  id="doors" value=""  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Passengers</td>
				<td>
				<input type="text" name="passengers" class="fields"  id="passengers" value=""  />
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
		<input type="hidden" name="act" value="car_types">
		<input type="hidden" name="act2" value="car_types">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="car_types_management" />
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
				 
				<td width="15%">Car Agency</td>
				<td width="15%">Car Type</td>
				<td width="15%">Car Category</td>
				<td width="15%">Produced</td>
				<td width="15%">Car Doors</td>
				<td width="15%">Passengers</td>
				<td width="5%">Options<br/>[Opcije]</td>
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
						<?php  $car_id = $rs_limit->fields['car_agency']; ?>
						<?php 
						$qry_agn= "SELECT * from ".$tblprefix."agency WHERE agn_id=".$car_id;  
						$rs_agn= $db->Execute($qry_agn);
						echo $rs_agn->fields['agn_name'];
						?>
						</td>	
                        
						<td valign="top"><?php echo $rs_limit->fields['car_types']; ?></td>	
											
						<td valign="top">
						
						
						
						
						<?php  $cat_id = $rs_limit->fields['category']; ?>
						<?php 
						$qry_ct = "SELECT * from ".$tblprefix."car_categories WHERE id=".$cat_id;   
						$rs_ct= $db->Execute($qry_ct);
						echo $rs_ct->fields['car_category_name'];
						?>
						
						
						</td>
						
						<td valign="top"><?php echo $rs_limit->fields['produced']; ?></td>						
						
						<td valign="top"><?php echo $rs_limit->fields['doors']; ?></td>
						
						<td valign="top"><?php echo $rs_limit->fields['passengers']; ?></td>
						
						<td valign="top">
							<a href="admin.php?act=update_car_type&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=car_types&amp;mode=del_xtra&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=car_types_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Service Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

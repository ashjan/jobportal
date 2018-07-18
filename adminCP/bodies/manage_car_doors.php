<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT ce.* ,c.car_type,s.supplier_name FROM ".$tblprefix."car_doors as ce INNER JOIN ".$tblprefix."car as c ON ce.car_id=c.id 
INNER JOIN ".$tblprefix."supplier as s ON  ce.supplier_id=s.id " ;

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5
$equipment=$tblprefix."car_equipment";
//$category=$tblprefix."content_category";
$qry_limit = "SELECT ce.* ,c.car_type,s.supplier_name FROM ".$tblprefix."car_doors as ce INNER JOIN ".$tblprefix."car as c ON ce.car_id=c.id 
INNER JOIN ".$tblprefix."supplier as s ON  ce.supplier_id=s.id 
					LIMIT $startRow,$maxRows"; 
					
					
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

///   List down all cars 

$qry_car = "SELECT * FROM ".$tblprefix."car" ;


$rs_car = $db->Execute($qry_car);
$count_car =  $rs_car->RecordCount();
$totalCars = $count_car;


///   List down all suppliers

$qry_supplier = "SELECT * FROM ".$tblprefix."supplier" ;


$rs_supplier = $db->Execute($qry_supplier);
$count_supplier =  $rs_supplier->RecordCount();
$totalSuppliers = $count_supplier;
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Car Doors/Passengers </td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Doors/Passsengers Found: <?php echo $totalcountalpha ?></td>
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
				<td class="txt1">No of Doors/Passengers</td>
				<td>
				<input type="text" name="equipment_name" class="fields" id="equipment_name" value=""  />
 				</td> 
				</tr>
				
				
				<tr>
				<td class="txt1">Supplier Name</td>
				<td>
				<select name="supplier_id" class="fields" id="supplier_id" >
				<option value="0" > Select Supplier Name</option>
				<?php 
			     	while(!$rs_supplier->EOF){
					echo '<option value="'.$rs_supplier->fields['id'].'">'.$rs_supplier->fields['supplier_name'].'</option>';
					$rs_supplier->MoveNext();
					}
				?>
				</select>
				
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Car Type</td>
				<td>
				<select name="car_id" class="fields" id="car_id" >
				<option value="0" > Select Car Type</option>
				<?php 
			     	while(!$rs_car->EOF){
					echo '<option value="'.$rs_car->fields['id'].'" >'.$rs_car->fields['car_type'].'</option>';
					$rs_car->MoveNext();
					}
				
				?>
				</select>
				
 				</td> 
				</tr>
				
				
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Equipment" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="manage_car_doors">
		
		<input type="hidden" name="act2" value="manage_car_doors">
		<input type="hidden" name="request_page" value="management_car_doors" />
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
				<!--<td width="3%">Sr#</td>-->
				<td width="8%">Id</td>
                <td width="28%">Supplier Name</td>
				<td width="28%">Car Name</td>
				<td width="28%"><span class="txt1">Doors/Passengers</span></td>
				<td width="8%">Options</td>
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
						<td  valign="top"><?php echo stripslashes($rs_limit->fields['supplier_name']); ?></td> 
					  <td  valign="top"><?php echo stripslashes($rs_limit->fields['car_type']); ?></td>
                      <td  valign="top"><?php echo stripslashes($rs_limit->fields['number_doors']); ?></td>						
							
						<td valign="top">
							<a href="admin.php?act=edit_car_doors&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;request_page=management_car_doors">							<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_car_doors&amp;mode=del_doors&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=management_car_doors" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Doors/Passengers Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

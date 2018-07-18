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

 $qry_faq = "SELECT ce.* ,c.car_type,s.supplier_name FROM ".$tblprefix."car_equipment as ce LEFT JOIN ".$tblprefix."car as c ON ce.car_id=c.id 
INNER JOIN ".$tblprefix."carsupplier as s ON  ce.supplier_id=s.id " ;  

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5
$equipment=$tblprefix."car_equipment";
//$category=$tblprefix."content_category";
 $qry_limit = "SELECT 
 ce.* ,c.car_type,s.supplier_name 
 FROM ".$tblprefix."car_equipment as ce 
 LEFT JOIN ".$tblprefix."car as c ON ce.car_id=c.id 
 INNER JOIN ".$tblprefix."carsupplier as s ON  ce.supplier_id=s.id 
 LIMIT $startRow,$maxRows"; 
				
					
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."property_manager";  
$rs_pm = $db->Execute($qry_pm);

///   List down all cars 

 $qry_car = "SELECT * FROM ".$tblprefix."car";


$rs_car = $db->Execute($qry_car);
$count_car =  $rs_car->RecordCount();
$totalCars = $count_car;



$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);
///   List down all suppliers

$qry_supplier = "SELECT * FROM ".$tblprefix."carsupplier";


$rs_supplier = $db->Execute($qry_supplier);
$count_supplier =  $rs_supplier->RecordCount();
$totalSuppliers = $count_supplier;
?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Car Equipment</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Car Equipment Found: <?php echo $totalcountalpha ?></td>
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
			  	
		
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
           
		   <tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
			
			<option value="0">Select Car Agency</option>	
	<?php while(!$rs_agency->EOF){
				
				$is_cat_selected = '';
				if($rs_agency->fields['agn_id']==$rs_limit->fields['agency']){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_agency->fields['agn_id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_agency->fields['agn_name'] ;?></option>
	<?php $rs_agency->MoveNext();
	}
	
?>
</select>
			
		</td>
			</tr> 	
		   
		   
		   <?php
			}else{
			?>
		<tr>
		
		 	<td class="txt1">Property Manager</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_car_agency('get_agency', this.value, '<?php echo MYSURL."ajaxresponse/get_car_agency.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){
				echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>	
			</td><td>		
		</td><td> </td>
			</tr> 
			
			
			<tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<div id="get_agency">
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
				<option value="0">Select Car Agency</option>
						
				</select>	
			</div>
			
			</td>
			</tr> 
		<?php
		}?> 
		<tr>
	        <td class="txt1">
  			
			Supplier Name
		   	</td>
			<td>
		<div id="get_supplier"> 	
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type.php"?>')">
			<option value="0">Supplier Name</option>
		</select>
		</div>	
		</td>
        </tr>
		
		   <tr>
		    <td class="txt1">
  			Car Type
		   	</td>
			<td>
			<div id="get_car">
			<select name="car_id" class="fields"   id="car_id">
				<option value="0">Select Car Type</option>					
			</select>		
			</div>
			</td>
        </tr>
		
						
		<tr>
	        <td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;">
  			Equipments Names
		   	</td>
			
			
			<td class="txt">			
	<input type="checkbox" name="equipments[]" value="0" id="equipments" onclick="return is_checked();"/>Don't Have any Equipment <br/>
	<div id="credit_card" style="display:block;">
	<input type="checkbox" name="equipments[]" value="1" id="equipments"/>Air condition<br/> 
	<input type="checkbox" name="equipments[]" value="2" id="equipments"/>Manual <br/> 				 
	<input type="checkbox" name="equipments[]" value="3" id="equipments"/>Automatic <br/>
	<input type="checkbox" name="equipments[]" value="4" id="equipments"/>Radio/cd<br/>
	<input type="checkbox" name="equipments[]" value="5" id="equipments"/>ABS <br/>
	<input type="checkbox" name="equipments[]" value="6" id="equipments"/>Servo steering-wheel <br/>
	 		
	</div>
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
		<input type="hidden" name="act" value="manage_car_equipment">
		
		<input type="hidden" name="act2" value="manage_car_equipment">
		<input type="hidden" name="request_page" value="management_car_equipment" />
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
				<td width="5%">Id</td>
				<td width="15%">Property Manager</td>
				<td width="15%">Car Agency Name</td>
				<td width="15%">Car Supplier Name</td>
				<td width="15%">Car Type</td>
				<td width="30%">Equipments Names</td>
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
						<!-- <td  valign="top"><?php //echo stripslashes($rs_limit->fields['equipment_name']); ?></td>-->
					  
					    <td width="3%" valign="top"><?php $qry_agn = "SELECT first_name , last_name FROM 
					  ".$tblprefix."property_manager where id=".$rs_limit->fields['pm_id']; 
					   $rs_agn= $db->Execute($qry_agn);
					   echo $rs_agn->fields['first_name']; echo '&nbsp;'; echo $rs_agn->fields['last_name'];
					   ?>
  </td>
					   
					  <td width="3%" valign="top"><?php $qry_agn = "SELECT agn_name FROM 
					  ".$tblprefix."agency where agn_id=".$rs_limit->fields['agency']; 
					   $rs_agn= $db->Execute($qry_agn);
					   echo $rs_agn->fields['agn_name'];
					   ?></td>
					   
					  <td  valign="top"><?php echo stripslashes($rs_limit->fields['supplier_name']); ?></td>					
					  <td  valign="top"><?php 
					  $qry_car1 = "SELECT * FROM ".$tblprefix."car WHERE id=".$rs_limit->fields['car_id']; 
					  $rs_car1 = $db->Execute($qry_car1);
					  
					   echo $rs_car1->fields['car_type']; 
					   ?></td>
					   	
						
					  <td  valign="top">												
						
						 <?php $explode_values=explode(',',$rs_limit->fields['equipments']); ?>
								
						 <?php  
						
						if(in_array(0,$explode_values)){
						?>Don't Have any Equipment<?php }?>
						
						<div id="equipments" style="display:block;">
						<?php 
						if(in_array(1,$explode_values)){
						?>Air condition<?php }?>  
						
						<?php 
						if(in_array(2,$explode_values)){
						?> Manual<?php }?> 	
							 
						 <?php 
						if(in_array(3,$explode_values)){
						?> Automatic<?php }?> 
								 
						 <?php 
						if(in_array(4,$explode_values)){
						?> Radio/cd<?php }?> 
										 
						 <?php if(in_array(4,$explode_values)){
						?> ABS <?php }?> 
						
						<?php if(in_array(5,$explode_values)){
						?> Servo steering-wheel<?php }?> 		
						</div>
						</td>
		
						<td valign="top">
							<a href="admin.php?act=edit_car_equipment&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;request_page=management_car_equipment">							<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_car_equipment&amp;mode=del_equipment&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=management_car_equipment" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Car Equipment Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

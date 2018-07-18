<?php 
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'property_minimum_stay.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}	

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
 $qry_faq = "SELECT
				".$tblprefix."car.car_type,
				".$tblprefix."car.id,
				".$tblprefix."property_manager.id,
				".$tblprefix."property_manager.first_name,
				".$tblprefix."property_manager.last_name,
				".$tblprefix."car_rates.id,
				".$tblprefix."car_rates.agency,
				".$tblprefix."car_rates.supplier,				
				".$tblprefix."car_rates.car_id,
				".$tblprefix."car_rates.number_cars,
				".$tblprefix."car_rates.starting_days,
				".$tblprefix."car_rates.ending_days,
				".$tblprefix."car_rates.days_extra,
				".$tblprefix."car_rates.per_month,
				".$tblprefix."car_rates.car_rate
				FROM
				".$tblprefix."car_rates
				Inner Join ".$tblprefix."car ON ".$tblprefix."car_rates.car_id = ".$tblprefix."car.id
				Left Join ".$tblprefix."property_manager ON ".$tblprefix."car_rates.pm_id = ".$tblprefix."property_manager.id
			"; 
												
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 $qry_limit = "SELECT
				".$tblprefix."car.car_type,
				".$tblprefix."car.id,
				".$tblprefix."property_manager.id,
				".$tblprefix."property_manager.first_name,
				".$tblprefix."property_manager.last_name,
				".$tblprefix."car_rates.id,
				".$tblprefix."car_rates.agency,
				".$tblprefix."car_rates.supplier,				
				".$tblprefix."car_rates.car_id,
				".$tblprefix."car_rates.number_cars,
				".$tblprefix."car_rates.starting_days,
				".$tblprefix."car_rates.ending_days,
				".$tblprefix."car_rates.days_extra,
				".$tblprefix."car_rates.per_month,
				".$tblprefix."car_rates.car_rate
				FROM
				".$tblprefix."car_rates
				Inner Join ".$tblprefix."car ON ".$tblprefix."car_rates.car_id = ".$tblprefix."car.id
				Left Join ".$tblprefix."property_manager ON ".$tblprefix."car_rates.pm_id = ".$tblprefix."property_manager.id
			    ORDER BY ".$tblprefix."car_rates.id DESC
				LIMIT $startRow,$maxRows";
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_cars = "SELECT
                    ".$tblprefix."car.id,
					".$tblprefix."car.car_type
					FROM
					".$tblprefix."car"; 
$rs_cars = $db->Execute($qry_cars);
$totalcountpropertymanag =  $rs_cars->RecordCount();

$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_prop = $db->Execute($property_qry);
$totalproperties =  $rs_prop->RecordCount();

$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);

$qry_cat = "SELECT * FROM ".$tblprefix."car_categories" ;
$rs_cat = $db->Execute($qry_cat);

$qry_carsupplier = "SELECT * FROM ".$tblprefix."carsupplier" ;
$rs_carsupplier = $db->Execute($qry_carsupplier);


$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."property_manager";  
$rs_pm = $db->Execute($qry_pm);

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Car Rates</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total car rates Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
          <?php } else {?>
          
		  
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
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
			</td><td> </td><td> </td>
			</tr> 
			<?php
		}?>
			
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
	        <td>
  			Number Cars
		   	</td>
			<td>
            <input id="number_cars" class="fields" type="text" value="" name="number_cars"> 					
           </td>
        </tr><b></b>
              <tr>
             
			 
			 <tr>
			
			
		
			
			 <td>Starting Days</td>
			 <td><input type="text" name="starting_days" id="starting_days" class="fields" value="">
		
		
			 
			   <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'starting_days',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			</td>
			</tr>
			
			
			 <tr>
			  <td> Ending Days </td>
			  <td><input type="text" name="ending_days" id="ending_days" class="fields" value="">
			   <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'ending_days',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			</td>
			</tr>
			
			
			
			<tr>
              <td> Days Extra </td>
              <td> 
                <input id="days_extra" class="fields" type="text" value="" name="days_extra">
			  </td>
            </tr>
            
            <tr>
              <td> Per Month </td>
              <td> 
                <input id="per_month" class="fields" type="text" value="" name="per_month">
			  </td>
            </tr>
			 
            <tr>
              <td> Car Rates </td>
              <td> 
                <input id="car_rate" class="fields" type="text" value="" name="car_rate"> &euro;
			  </td>
            </tr>
			<?php } ?>
            <tr>
              <td>&nbsp;</td>
              <td><input style="margin:2px; width:142px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Car Rate" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_car_rates" />
          <input type="hidden" name="request_page" value="car_rates_management" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div>
	  </td>
  </tr>
  <form name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
    <td>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	   <td width="5%">Sr#</td>
	   <td width="10%">PM Name</td>
	    <td width="10%">Car Agency</td>
	    <td width="10%">Car Supplier</td> 
	    <td width="10%">Car Type</td>
		<td width="5%">Number Of Cars</td>
		<td width="10%">Starting Days</td>
		<td width="10%"> Ending Days</td>
       	<td width="10%">Days Extra</td>
        <td width="10%">Per Month</td>
		 <td width="5%">Car Rate</td>
		<td width="5%">Option</td>
		</tr>
      <?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
					
					
					<td valign="top"><?php echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name']; ?></td>
					<td valign="top">
					  <?php 
					$qry_agency = "SELECT * FROM ".$tblprefix."agency WHERE agn_id=".$rs_limit->fields['agency']; 
					$rs_agency= $db->Execute($qry_agency);

					echo $rs_agency->fields['agn_name'];
					  ?>
					  </td>
					
					<td valign="top">
					  <?php 
					  
					$qry_carsupplier = "SELECT * FROM ".$tblprefix."carsupplier WHERE id=".$rs_limit->fields['supplier'];
					$rs_carsupplier = $db->Execute($qry_carsupplier);
					  
					  echo $rs_carsupplier->fields['supplier_name'];
					  ?>
					  </td>
					 <td valign="top">
					  <?php 
					  echo $rs_limit->fields['car_type'];
					  ?>
					  </td>
					  
		 <td  valign="top" ><?php  echo stripslashes($rs_limit->fields['number_cars']); ?></td>
					  <td  valign="top"><?php  echo stripslashes($rs_limit->fields['starting_days']); ?></td>
					  
					  <td valign="top"><?php echo stripslashes($rs_limit->fields['ending_days']);?></td>
					  <td valign="top" text align="center"><?php  echo stripslashes($rs_limit->fields['days_extra']); ?></td>
                      <td valign="top" text align="center"><?php  echo stripslashes($rs_limit->fields['per_month']); ?></td>
					  
					  <td valign="top" text align="center"><?php  echo stripslashes($rs_limit->fields['car_rate']); echo'&euro;'; ?></td>
					  
					  
            	<td valign="top">
                <a href="admin.php?act=edit_car_rates&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>
				"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_car_rates&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=car_rates_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						}
						?>
      <input type="hidden" name="act" value="manage_car_rates" />
      <input type="hidden" name="request_page" value="car_rates_management" />
      <input type="hidden" name="mode" value="add">
  </form>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="hidden" name="act" value="manageletter">
      <input type="hidden" name="mode" value="delete">
    </td>
  </tr>
</table>
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
</table>
<?php //echo $where;?>

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

$qry_faq = "SELECT pa.* FROM `".$tblprefix."property_accommodation` as pa ";
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_manage = "SELECT * FROM ".$tblprefix."property_category as pc"; 
$rs_property_manag = $db->Execute($qry_manage);


$qry_facility = "SELECT * FROM ".$tblprefix."property_facilities";
$rs_facility = $db->Execute($qry_facility);
$totalcountalfacility =  $rs_facility->RecordCount();

  				$qry_limit = "SELECT pa.*,pc.property_category_name,property_cat
				FROM ".$tblprefix."property_accommodation as pa
				INNER JOIN  ".$tblprefix."property_category as pc ON pc.id=pa.property_cat 
				LIMIT $startRow,$maxRows"; 

$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();


//echo $rs_property_manag->fields['property_cat']; 
//exit();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Property Types&nbsp;[Upravljanje tipovima objekata]</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Accommoddation Found: <?php echo $totalcountalpha ?></td>
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
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
        <table cellpadding="1" cellspacing="1" border="0" class="txt" >
        		<tr>
				<td class="txt1">Property Category<br/>[kategoriju objekta]</td>
				<td>
				<!--<input type="text" name="price_period" id="price_period" class="price_period" value="" >-->
				
				<!--***********************************************************-->
				
				<select name="property_cat"  class="dropfields"  id="property_cat" onchange="get_accommadation('acc_name', this.value, '<?php echo MYSURL."ajaxresponse/get_accommadation.php"?>')">
				<option value="">Izaberite  Kategorija objekta</option>
				    <?php 
					while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['property_category_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();} ?>			
					</select>
		</td>
		<tr>
	        <td>
  			Business Type
		   	</td>
			<!--<td><input type="text" name="accomm_name" class="fields" id="accomm_name" value="" /></td> --> 
				<td>
				<input name="accomm_name" id="accomm_name" value="<?php echo $rs_limit->fields['accomm_name']?>" type="text" size="35"  maxlength="30" />
				</td>
        </tr>                    
		<tr>
				<td class="txt1">Price Period<br/>[Cjenovni period]</td>
				<td>
				<!--<input type="text" name="price_period" id="price_period" class="price_period" value="" >-->
				<select class="dropfields"  name="price_period" id="price_period">
				<option value="0">Select Price Period</option> 
				<option value="1">Price Per Night</option> 
				<option value="2">Price Per Week</option>
				<option value="3">Price Per Month</option>
        		</select>
				</td> 
		</tr>
		<tr>
				<td class="txt1">Per Person<br/>[Po osobi]</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="per_person" id="per_person_yes" checked="checked" value="1" ><span> Yes</span>
				<input type="radio" name="per_person"  id="per_person_no" value="0"  ><span> No</span>
				</div>
				</td> 
		</tr>
		
		
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:230px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Accomodation &nbsp;[Unesite Smještaj]" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_accomodation1" />
			<input type="hidden" name="request_page" value="accomodation_management1" />
			<input type="hidden" name="mode" value="add">

		</form>
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
				<td width="3%">Sr#</td>
                <td width="20%">Business Type<br/>[Vrsta objekta]</td> 
              	<td width="20%">Price Period<br/>[Cjenovni period]</td>
				<td width="20%">Per Person<br/>[Po osobi]</td>
				<td width="20%">Property Category<br/>[]</td>
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
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td valign="middle">
						<?php echo $rs_limit->fields['accomm_name'];
						
						
						
						?>
					</td>
					<td valign="middle">
						<?php 
						if ($rs_limit->fields['price_period']==0){$price_period='N/A';}
                        if ($rs_limit->fields['price_period']==1){$price_period='Price per night';}
                        if ($rs_limit->fields['price_period']==2){$price_period='Price per week';}
						if ($rs_limit->fields['price_period']==3){$price_period='Price per month';}
					echo $price_period;?>
					</td>
					<td valign="middle">
					<?php 
					$per_person=$rs_limit->fields['per_person'];
					if ($rs_limit->fields['per_person']==0){$per_person='No';}
                    if ($rs_limit->fields['per_person']==1){$per_person='Yes';}
					echo $per_person;
					?>
					</td>
					<td valign="middle"><?php echo $rs_limit->fields['property_category_name'];?></td>		
				    <td valign="middle">
							<a href="admin.php?act=editaccomm1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=accomodation_management1"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_accomodation1&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=accomodation_management1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							<input type="hidden" name="act" value="manage_accomodation1">		
							<input type="hidden" name="mode" value="delete">
							<input type="hidden" name="request_page" value="accomodation_management1">
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
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No business type found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

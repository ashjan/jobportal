<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$mode = "";
$is_cat_selected = "";
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
				ORDER BY pc.id ASC
				LIMIT $startRow,$maxRows"; 
  				

$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();


//echo $rs_property_manag->fields['property_cat']; 
//exit();
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
   Manage Profile Types
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Accommodation Found: <?php echo $totalcountalpha ?></td>
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
				<td class="txt1">Profile Category</td>
				<td>
				<!--<input type="text" name="price_period" id="price_period" class="price_period" value="" >-->
				
				<!--***********************************************************-->
				
				<select name="property_cat"  class="dropfields"  id="property_cat" onchange="get_accommadation('acc_name', this.value, '<?php echo MYSURL."ajaxresponse/get_accommadation.php"?>')">
				<option value="">--Select Category--</option>
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
  			Business Type(English)
		   	</td>
			<!--<td><input type="text" name="accomm_name" class="fields" id="accomm_name" value="" /></td> --> 
				<td>
				<input name="accomm_name" id="accomm_name" value="<?php echo $rs_limit->fields['accomm_name']?>" type="text" size="35"  maxlength="30" />
				</td>
        </tr>
		
		<?php 
				if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
                // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				if($mode == "update"){
					$id = $pageid;
					
					$language_qry = "SELECT id,
					language_id,
					page_id,
					field_name,
					translation_text,
					translated_text,
					fld_type 
					FROM 
					".$tblprefix."language_contents 
					WHERE   
					language_id=".$language_id." 
					AND page_id='".$id."'  
					AND field_name='business_title' 
					AND fld_type='business_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				}else{
				
					$value='';
				}
				
//			echo '<tr>
//			<td class="txt1" >Business Type('.$rs_language->fields['Lan_name'].') </td>
//			<td >
//			<input  class="fields" name="accomm_name_'.$rs_language->fields['id'].'" id="accomm_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text"  />
//			</td>
//			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		                    
		<tr>
				<td class="txt1">Price Period</td>
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
				<td class="txt1">Per Person</td>
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
			<input style="margin:5px; width:230px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Accomodation" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_accomodation" />
			<input type="hidden" name="request_page" value="accomodation_management" />
			<input type="hidden" name="mode" value="add">

		</form>
</div>
		 </td>
		 </tr>
		 <form name="ordering_menu" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data"> 
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="10%">Menu Order<input type="submit" title="Save Ordering" name="sbt_ordering" value="" class="save_icon" />
				</th>
				<th width="20%">Parent Category</th>
                <th width="20%">Business Type</th> 
              	<th width="20%">Price Period</th>
				<th width="20%">Per Person</th>				
				<th width="11%">Options</th>
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
						<!--<td valign="middle"><?php //echo ++$i; ?></td>-->
						 <td valign="top">
					
					<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['id']; ?>];" id="menu_order[<?php echo $rs_limit->fields['id']; ?>]" type="text" value="<?php echo $rs_limit->fields['cat_orderdering'];?>" />
				
					</td>
					<td valign="middle"><?php echo $rs_limit->fields['property_category_name'] ?></td>
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
					
				    <td valign="middle">
							<a href="admin.php?act=editaccomm&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=accomodation_management"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_accomodation&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=accomodation_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							<input type="hidden" name="act" value="manage_accomodation">		
							<input type="hidden" name="mode" value="delete">
							<input type="hidden" name="request_page" value="accomodation_management">
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
		 <input type="hidden" name="mode" value="order_menu">
		<input type="hidden" name="act" value="manage_accomodation">
<!--		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">-->
		<input type="hidden" name="request_page" value="accomodation_management" />
		</form>
  </tr>
</table>
</div></div>
<?php //echo $where;?>

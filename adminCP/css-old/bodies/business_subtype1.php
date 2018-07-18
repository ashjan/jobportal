<?php
	
if(!isset($_GET['okmsg']) and !isset($_GET['errmsg']))
{
	unset($_SESSION["addproperty"]);
}

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

//Business Sub Type
$qry_business_subtype = "SELECT 
                         ".$tblprefix."business_subtype.id,
						 ".$tblprefix."business_subtype.business_subtype,
						 ".$tblprefix."business_subtype.business_type_id,
						 ".$tblprefix."business_subtype.business_category_id, 
						 ".$tblprefix."property_accommodation.accomm_name, 
						 ".$tblprefix."property_category.property_category_name 
						 FROM ".$tblprefix."business_subtype 
						 INNER JOIN ".$tblprefix."property_accommodation ON ".$tblprefix."property_accommodation.id=".$tblprefix."business_subtype.business_type_id 
						 INNER JOIN ".$tblprefix."property_category ON ".$tblprefix."property_category.id=".$tblprefix."business_subtype.business_category_id";



$rs_business_subtype = $db->Execute($qry_business_subtype);
$count_business_subtype =  $rs_business_subtype->RecordCount();
$totalAccommodation = $count_business_subtype;
//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation" ; 
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;
$qry_business_subtype = "SELECT * FROM ".$tblprefic."business_subtype";
$qry_manage = "SELECT * FROM ".$tblprefix."property_category as pc"; 
$rs_property_manag = $db->Execute($qry_manage);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Business Subtypes</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Business Subtypes Found: <?php echo $count_business_subtype ?></td>
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
			  <td>
			  Property Category
			 </td>
		<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
	<select name="business_category_id" id="business_category_id"  class="dropfields"  onchange="get_business_subtype('business_type_id', this.value, '<?php echo MYSURL."ajaxresponse/get_business_type.php"?>')">
	  <option value="0">Select  Category</option>
	  <?php while(!$rs_property_manag->EOF){$is_manager_selected = ''; ?>
		<option value="<?php echo $rs_property_manag->fields['id'];?>" 
		<?php echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['property_category_name'];?>
		</option>
	    <?php $rs_property_manag->MoveNext();
		} ?>			
	</select>
			</td>
        </tr>
		<tr>
			<td>
  			Business Type</td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<div id="business_type_id">
			<select name="business_type_id" class="dropfields"   id="business_type_id">
			 <option value="0">Select  Business Type</option>
			</select>
			</div>
			</td>
        </tr>
		<tr>
			<td>
			Business Subtype
			</td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<input type="text" name="business_subtype" class="fields"  id="business_subtype" value="" />
	</td>
     
	<td>&nbsp;</td>
	</tr>	
		
		
		<tr><td>
		
			<input style="margin:5px; width:150px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Add Business Subtype" class="button"  align="middle"/>
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="business_subtype1" />
			<input type="hidden" name="request_page" value="business_subtype_management1" />
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
				<td width="10%">Sr#</td>
                <td width="25%">Business Subtypes </td> 
				<td width="25%">Business Types  </td> 
				<td width="25%">Properties Categories</td> 
              	<td width="10%">Options</td>
		    </tr>
			<?php 
				if($totalAccommodation >0){
				
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
				
				$rs_business_subtype->MoveFirst();
					while(!$rs_business_subtype->EOF){
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td valign="middle">
						<?php echo $rs_business_subtype->fields['business_subtype'];
						?>
					</td>
						
					<td valign="middle">
						<?php echo $rs_business_subtype->fields['accomm_name'];
						?>
					</td>	
					
					<td valign="middle">
						<?php echo $rs_business_subtype->fields['property_category_name'];
						?>
					</td>	
					
					
				    <td valign="middle">
							<a href="admin.php?act=edit_business_subtype1&amp;id=<?php echo base64_encode($rs_business_subtype->fields['id']);?> &amp;request_page=business_subtype_management1"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=business_subtype1&amp;mode=delete&amp;id=<?php echo base64_encode($rs_business_subtype->fields['id']); ?>&amp;request_page=business_subtype_management1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                    </td>
					</tr>
			<?php 
						$rs_business_subtype->MoveNext();
					}
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="act" value="business_subtype1">		
							<input type="hidden" name="mode" value="delete">
							<input type="hidden" name="request_page" value="accomodation_managemen1t">
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
					<td colspan="14" class="errmsg"> No Business Property Type Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

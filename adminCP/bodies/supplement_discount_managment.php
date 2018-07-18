<?php

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$maxRows = 20;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."supplement_discount" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5
$vcar=$tblprefix."supplement_discount";
//$category=$tblprefix."content_category";
$qry_limit = "SELECT *
					FROM ".$vcar."
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Supplement Discount</td>
  	</tr>
  <tr><td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td></tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="3" align="right">Total Number of Supplement Discount Found: <?php echo $totalcountalpha ?></td>
		  </tr>
		  <tr class="tabheading">
		<td colspan="6" align="right"><a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false">
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /></a></td>
	</tr>
			<tr>
				<td colspan="7">
					<div id="controls" <?php if($_SESSION['record_add_edit']=='Yes'){ ?> style="display:block;" <?php } ?> class="add_subscriber">
                <form action="admin.php" enctype="multipart/form-data" method="post" name="testform" > 
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
							<tr>
								<td>Single Person Discount *</td>
								<td>
							<input type="radio" name="single_person_supplement"  id="single_person_supplement_on" value="1">Yes
							<input type="radio" name="single_person_supplement"  id="single_person_supplement_off" value="0">No 						
						</td>
						<!--<td><input type="text" name="single_person_supplement" class="fields" id="single_person_supplement" value="<?php //echo $rs_limit->fields['single_person_supplement']; ?>" />	</td> -->
		</tr>        
							
							<tr>
								<td>Figure In Percentage*</td>
								<td> <input type="radio" name="figure_in_percentage"  id="figure_in_percentage_on" value="1">Yes
							<input type="radio" name="figure_in_percentage"  id="figure_in_percentage_off" value="0">No  							
						</td>
						<!--<td><input type="text" name="figure_in_percentage" class="fields" id="figure_in_percentage" value="<?php //echo $rs_limit->fields['figure_in_percentage']; ?>" />						</td> -->
							</tr> 
							
							
							<tr>
								<td>Charge Rate Value* </td>
								<td><input  type="text" size="13px" name="charge_rate_value" id="charge_rate_value" value="<?php echo $rs_limit->fields['charge_rate_value']; ?>" />%</td>
							</tr> 
							 
							
					   
					<td>&nbsp;</td>
					<td>
					<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Add Discunt Rate" class="button" />			</td>
				</tr>
					
			
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="hidden" name="mode" value="add">
							<input type="hidden" name="act" value="supplement_discount_managment">
							<input type="hidden" name="act2" value="supplement_discount_managment">
							<input type="hidden" name="request_page" value="manage_supplement_discount" />
						</td>
					</tr>
				
				
				<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
				</tr>
				</table>
                 </form>   
          </div>
				</td>
			</tr>		

		    <tr height="5%">
			  <td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="10%">Sr#</td>
				<td width="25%">Single Person Discount</td>
				<td width="25%">Figure In Percentage</td>
				<td width="30%">Charge Rate Value</td>
				<td width="10%">Options</td>
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
					  <td> <?php 
								$q=stripslashes($rs_limit->fields['single_person_supplement']); 
								$q=(int)$q;
								if($q==1){
								echo "yes";
								}if($q==0){
								echo "No";
								}
								?></td>
								
								
								<td> <?php 
								$q=stripslashes($rs_limit->fields['figure_in_percentage']); 								$q=(int)$q;
								if($q==1){
								echo "yes";
								}if($q==0){
								echo "No";
								}
								?></td>
								
								
								<!--<td><input type="radio" name="single_person_supplement"  id="single_person_supplement_on" value="<?php //echo $rs_limit->fields['single_person_supplement']; ?>">Yes
							<input type="radio" name="single_person_supplement"  id="single_person_supplement_off" value="<?php //echo $rs_limit->fields['single_person_supplement']; ?>">No 						</td>
								
								<td> <input type="radio" name="figure_in_percentage"  id="figure_in_percentage_on" value="<?php //echo $rs_limit->fields['figure_in_percentage']; ?>">Yes
							<input type="radio" name="figure_in_percentage"  id="figure_in_percentage_off" value="<?php //echo $rs_limit->fields['single_person_supplement']; ?>">No 							</td>-->
					 <!--<td width="3%" valign="top"><?php// echo stripslashes($rs_limit->fields['single_person_supplement']); ?></td>-->
					 
					  <!--<td width="3%" valign="top"><?php //echo stripslashes($rs_limit->fields['figure_in_percentage']); ?></td>
					 -->
					 
					 
					 
					  <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['charge_rate_value'])."%"; ?> </td>
						
						<td >
						<a href="admin.php?act=edit_supplement_discount&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">							<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=supplement_discount_managment&amp;mode=del_discount&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manage_supplement_discount" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        		
		   </td>
					</tr>
					
			<?php $rs_limit->MoveNext();
			}?>
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
					<td colspan="13" class="errmsg"> No Supplement Discount Rate Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </tr>
</table><?php //echo $where;?>
</form>

<?php
// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid']))
{
?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php 
}
?>

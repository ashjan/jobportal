<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
 $roomid=$_GET['id']; 
 $propid= $_GET['propid'];
 $pm_id= $_GET['pm_id'];
	



$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

?>
<?php 
			$qry_faq = "SELECT 
							".$tblprefix."property_manager.first_name, 
							".$tblprefix."property_manager.last_name, 
							".$tblprefix."properties.property_name, 
							".$tblprefix."rooms.room_type, 
							".$tblprefix."standard_rates.id, 
							".$tblprefix."standard_rates.room_type_id, 
							".$tblprefix."standard_rates.pm_id,
							".$tblprefix."standard_rates.property_id,
							".$tblprefix."standard_rates.standard_start_date,
							".$tblprefix."standard_rates.standard_end_date,
							".$tblprefix."standard_rates.standard_rate_price,
							".$tblprefix."standard_rates.single_use_option,
							".$tblprefix."standard_rates.single_rate_price,
							".$tblprefix."standard_rates.rooms_for_sale,
							".$tblprefix."standard_rates.advance_use_option,
							".$tblprefix."standard_rates.advance_start_date,
							".$tblprefix."standard_rates.advance_end_date,
							".$tblprefix."standard_rates.advance_rate_price,
							".$tblprefix."standard_rates.single_adv_use_option,
							".$tblprefix."standard_rates.single_adv_rate_price
							FROM
 							".$tblprefix."standard_rates
  Inner Join ".$tblprefix."rooms ON ".$tblprefix."rooms.id = ".$tblprefix."standard_rates.room_type_id
  Inner Join ".$tblprefix."properties ON ".$tblprefix."properties.id = ".$tblprefix."standard_rates.property_id
  Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id = ".$tblprefix."standard_rates.pm_id 
  $module_pm_where "." AND ".$tblprefix."properties.id = ".$propid." AND ".$tblprefix."standard_rates.room_type_id = ".$roomid." AND  ".$tblprefix."standard_rates.pm_id = ".$pm_id." ORDER BY ".$tblprefix."standard_rates.id DESC"; 
						
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
				$qry_limit = "SELECT
							".$tblprefix."property_manager.first_name,
							".$tblprefix."property_manager.last_name, 
							".$tblprefix."properties.property_name,
							".$tblprefix."rooms.room_type,
							".$tblprefix."standard_rates.id,
							".$tblprefix."standard_rates.room_type_id,
							".$tblprefix."standard_rates.pm_id,
							".$tblprefix."standard_rates.property_id,
							".$tblprefix."standard_rates.standard_start_date,
							".$tblprefix."standard_rates.standard_end_date,
							".$tblprefix."standard_rates.standard_rate_price,
							".$tblprefix."standard_rates.single_use_option,
							".$tblprefix."standard_rates.single_rate_price,
							".$tblprefix."standard_rates.rooms_for_sale,
							".$tblprefix."standard_rates.adv_rooms_for_sale,
							".$tblprefix."standard_rates.advance_use_option,
							".$tblprefix."standard_rates.advance_start_date,
							".$tblprefix."standard_rates.advance_end_date,
							".$tblprefix."standard_rates.advance_rate_price,
							".$tblprefix."standard_rates.single_adv_use_option,
							".$tblprefix."standard_rates.single_adv_rate_price
							FROM
							".$tblprefix."standard_rates
							Inner Join ".$tblprefix."rooms ON ".$tblprefix."rooms.id = ".$tblprefix."standard_rates.room_type_id
							Inner Join ".$tblprefix."properties ON ".$tblprefix."properties.id = ".$tblprefix."standard_rates.property_id
							Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id = ".$tblprefix."standard_rates.pm_id  $module_pm_where"." AND ".$tblprefix."properties.id = ".$propid." AND ".$tblprefix."standard_rates.room_type_id = ".$roomid." AND ".$tblprefix."standard_rates.pm_id = ".$pm_id."   ORDER BY ".$tblprefix."standard_rates.id DESC LIMIT ".$startRow.",".$maxRows.""; 

				
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;

//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']."
				AND ".$tblprefix."properties.pm_type=0
				AND ".$tblprefix."properties.property_category=24";
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();
?>
<div id="get_rates"> 
	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
				<td width="15%">Room Type<br/>[Vrsta kreveta]</td>
                <td width="15%">PM Name</td>
                <td width="15%">Property Name</td>
				<td width="15%">Price Rate<br/>[Cijena]</td>
				<td width="15%">Single User Option<br/>[Mogućost rezervacije za jednu osobu]</td>
				<td width="15%">Single User Rate Price<br/>[Cijena za jednu osobu]</td>
				<td width="10%">Stating Date<br/>[Početni datum]/td>
				<td width="10%">Ending Date<br/>[Krajnji datum]</td>
				<td width="10%">Rooms For Sale<br/>[Raspolo&#382;ive sobe]</td>
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
	<td colspan="11">
       <strong>Standardna cijena</strong>
	</td>
	</tr>
	
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>

	<td valign="top"><?php echo $i; ?></td>
	<td valign="top"><?php  echo stripslashes($rs_limit->fields['room_type']); ?></td>
  
    <td valign="top"><?php  echo stripslashes($rs_limit->fields['first_name'].'  '.$rs_limit->fields['last_name']); ?></td>
    <td valign="top"><?php  echo stripslashes($rs_limit->fields['property_name']); ?></td>
    
	<td><?php echo stripslashes($rs_limit->fields['standard_rate_price']); ?></td>
	<td><?php  stripslashes($rs_limit->fields['single_use_option']);
	if($rs_limit->fields['single_use_option']==0){
	echo "NO";
	}else{
	echo "YES";
	} ?></td>
	<td><?php echo stripslashes($rs_limit->fields['single_rate_price']); ?></td>
	<td><?php echo stripslashes(date("m/d/Y",strtotime($rs_limit->fields['standard_start_date']))); ?></td>
	<td><?php echo stripslashes(date("m/d/Y",strtotime($rs_limit->fields['standard_end_date']))); ?></td>
	<td><?php echo stripslashes($rs_limit->fields['rooms_for_sale']); ?></td>
	<td>&nbsp;
	</td>
	</tr>
	
	
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
	<td colspan="10">
       <strong>Advance rates options<br/>[Opcije za napredne cijene]</strong>
       <?php if($rs_limit->fields['advance_use_option']==0){?><span style="color:red">No advance option&nbsp;[Nema opcija za napredne cijene]</span><?php }?>
	</td>
	<td>
	<a href="admin.php?act=edit_rates1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_rates1&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=rates_management1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
	</td>
	</tr>
	<?php if($rs_limit->fields['advance_use_option']!=0){?>
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
	<td valign="top">&nbsp </td>
	<td valign="top"><?php  echo $rs_limit->fields['room_type'];?> </td>
    <td valign="top"><?php  echo stripslashes($rs_limit->fields['first_name'].'  '.$rs_limit->fields['last_name']); ?></td>
    <td valign="top"><?php  echo stripslashes($rs_limit->fields['property_name']); ?></td>
	<td><?php echo stripslashes($rs_limit->fields['advance_rate_price']); ?></td>
	<td><?php  stripslashes($rs_limit->fields['single_adv_use_option']);
	if($rs_limit->fields['single_adv_use_option']==0){
	echo "NO";
	}else{
	echo "YES";
	} ?></td>
	<td><?php echo stripslashes($rs_limit->fields['single_adv_rate_price']); ?></td>
<!--	<td><?php 
    /*stripslashes($rs_limit->fields['advance_use_option']);
	if($rs_limit->fields['advance_use_option']==0){
	echo "NO";}else{echo "YES";} 
	*/
	?>
	</td>
	<td><?php 
	         if($rs_limit->fields['advance_start_date']!='1970-01-01' and $rs_limit->fields['advance_start_date']!='0000-00-00' 
	         and !empty($rs_limit->fields['advance_start_date']))
	         {
	         	$advance_start_date =stripslashes(date("m/d/Y",strtotime($rs_limit->fields['advance_start_date'])));
	         	
	         }else {
	         	$advance_start_date ='';
	         }
	         if($rs_limit->fields['advance_end_date']!='1970-01-01' and $rs_limit->fields['advance_end_date']!='0000-00-00'
	         and !empty($rs_limit->fields['advance_end_date']))
	         {
	         	$advance_end_date =stripslashes(date("m/d/Y",strtotime($rs_limit->fields['advance_end_date'])));
	          }else {
	         	$advance_end_date ='';
	         }

	?></td>-->
	
	<td><?php echo  $advance_start_date;?></td>
	<td><?php echo $advance_end_date; ?></td>
	
	<td><?php echo stripslashes($rs_limit->fields['adv_rooms_for_sale']); ?></td>
	<td>&nbsp;
	</td>
  </tr>
  <?php }?>
	<?php $i=$i+1; ?>
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
					<td colspan="13" class="errmsg"> No Standard Rate Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
</div>
<?php }  // End if ?>

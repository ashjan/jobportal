<?php
include('root.php');
include($root.'include/file_include.php');

?>


<div id="get_rates_images"> 
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
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE mv.pm_id = '.$_SESSION[SESSNAME]['pm_id']." AND pr.pm_type=1";
}else{
	$module_pm_where = ' WHERE pr.pm_type=1 ';
}

 $qry_faq = "SELECT mv.*,pm.id as pid,pm.first_name,pm.last_name,room_id,room_type,pr.id as prid,pr.property_name  FROM `".$tblprefix."mediaivideos` as mv INNER JOIN ".$tblprefix."properties as pr ON pr.id=mv.property_id LEFT JOIN tbl_rooms as ro ON ro.id=mv.room_id INNER JOIN ".$tblprefix."property_manager as pm ON pm.id=mv.pm_id  
 $module_pm_where 
"; 


/*


SELECT mv . * , pm.id AS pid, pm.first_name, pm.last_name, room_id, room_type, pr.id AS prid, pr.property_name
FROM `tbl_mediaivideos` AS mv
INNER JOIN tbl_properties AS pr ON pr.id = mv.property_id
LEFT JOIN tbl_rooms AS ro ON ro.id = mv.room_id
INNER JOIN tbl_property_manager AS pm ON pm.id = mv.pm_id
LIMIT 0 , 30


*/


$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 
$qry_limit = "SELECT mv.*,pm.id as pid,pm.first_name,pm.last_name,room_id,room_type,pr.id as prid,pr.property_name  FROM `".$tblprefix."mediaivideos` as mv INNER JOIN ".$tblprefix."properties as pr ON pr.id=mv.property_id LEFT JOIN ".$tblprefix."rooms as ro ON ro.id=mv.room_id INNER JOIN ".$tblprefix."property_manager as pm ON pm.id=mv.pm_id ".
 $module_pm_where." LIMIT ".$startRow.",".$maxRows."";

 $rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $qry_property_manag = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties
					WHERE  
					pm_id = ".$_SESSION[SESSNAME]['pm_id']." AND pm_type=1"; 
} else {
$qry_property_manag = "SELECT
                    ".$tblprefix."property_manager.id,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."property_manager"; 
}

$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$totalcountalpha =  $rs_limit->RecordCount();
?>




<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
            <tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="25">Property Manager</td>
				<td width="25">Property Name</td>
				<td width="65">Property Room</td>
                <td width="20%">Image</td>
                <td width="20%">Titles</td>
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
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td> 
					  <?php echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name']; ?>
					  </td>
						<td><?php 
						
						/*if($rs_limit->fields['property_id']==0){ 
						echo "Select Property Name";}else{*/
						
						
					  echo stripslashes($rs_limit->fields['property_name']);//}
					  ?></td>
						<td><?php if($rs_limit->fields['room_id']==0){
						 echo "All Rooms";
						 }else{
					  echo stripslashes($rs_limit->fields['room_type']);
					  }
					  ?></td>
						<td valign="middle"><a href="<?php echo $rs_limit->fields['image_full_path']; ?>">
						<img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['image_full_path']; ?>&w=50&h=40&zc=1" border="0"></a></td>
						<td valign="middle"><?php echo $rs_limit->fields['image_title']; ?></td>
						<td valign="middle">
							<a href="admin.php?act=editmediaimages&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;	
							<a href="admin.php?act=mediaimages&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=media_upload" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							<input type="hidden" name="act" value="manageletter">		
							<input type="hidden" name="mode" value="delete">						</td>
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
					<td colspan="14" class="errmsg"> No Media Image Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>

</div>


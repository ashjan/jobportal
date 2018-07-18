<?php
	include('root.php');
    include($root.'include/file_include.php');
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
 
 $propid= $_GET['propid'];
 $pm_id= $_GET['pm_id'];
 $room_id= $_GET['rooms_id1'];
		
		
 if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $module_pm_where = ' WHERE  '.$tblprefix.'properties.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND '.$tblprefix.'properties.pm_type=1'.'
 							AND '.$tblprefix.'properties.property_category=24 
							AND '.$tblprefix.'rooms.pm_id='.$pm_id.' 
							AND '.$tblprefix.'rooms.property_id = '.$propid.' 
							AND '.$tblprefix.'rooms.id = '.$room_id
							; 
							
							
 
}else{
 //$module_pm_where = ' WHERE '.$tblprefix.'rooms.discount_percentage<>0';
 $module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=1 
 							AND '.$tblprefix.'properties.property_category=24 
							AND '.$tblprefix.'properties.pm_id='.$pm_id.'  
							AND '.$tblprefix.'properties.id = '.$propid.'
							AND '.$tblprefix.'rooms.id='.$room_id 
							;
}


if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $module_pm_where1 = ' WHERE  '.$tblprefix.'rooms.pm_id = '.$_SESSION[SESSNAME]['pm_id'].'  				 			
							AND '.$tblprefix.'rooms.pm_id='.$pm_id.' 
							AND '.$tblprefix.'rooms.property_id = '.$propid.' 
							AND '.$tblprefix.'rooms.id = '.$room_id; 
}else{
 //$module_pm_where = ' WHERE '.$tblprefix.'rooms.discount_percentage<>0';
 $module_pm_where1 = ' WHERE '.$tblprefix.'rooms.pm_id='.$pm_id.' 									  
 							AND  '.$tblprefix.'rooms.property_id = '.$propid.' 
							AND '.$tblprefix.'rooms.id = '.$room_id
							;
}
		

		
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."rooms $module_pm_where1";




$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);


 $qry_limit = "SELECT ".$tblprefix."rooms.*,
                     ".$tblprefix."property_manager.first_name,
					 ".$tblprefix."property_manager.last_name,
					 ".$tblprefix."properties.property_name
 FROM ".$tblprefix."rooms  
 INNER JOIN ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id=".$tblprefix."rooms.pm_id 
 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.id=".$tblprefix."rooms.property_id $module_pm_where 
 LIMIT $startRow,$maxRows";
 
 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//Dropdown for parent

$qry_property_manag = "SELECT 
                    ".$tblprefix."property_manager.id,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name 
					FROM
					".$tblprefix."property_manager"; 
					
$rs_category = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_category->RecordCount();
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1  AND      
 property_category=24 ';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
<tr>
	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
</tr>

  <form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    
    <tr>
    <td>
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
     <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
    
    <tr height="5%">
    	<td colspan="13" ></td>
    </tr>
      
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr height="5%">
			<td colspan="13" ></td>
		    </tr>
			<tr>

			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="6%">PM Name</td>
				<td width="6%">Property Name</td> 
				<td width="6%">Room Name<br/>[Izaberite sobu]</td>
			    <td width="6%">Threshold<br/>[Uslov]</td>
				<td width="6%">Discount Percentage<br/>[Procenat popusta]</td> 
				<td width="6%">Refundable<br/>[Povratno]</td>
				
				<td width="6%">Lastminute Threshold<br/>[Last minute Uslov]</td>
				<td width="6%">Lastminute Disc %<br/>[Last Minute Disc %]</td> 
				<td width="6%">Lastminute Refundable<br/>[Last Minute Povratno]</td>
				
				<td width="6%">Long Stay Threshold<br/>[Dugi boravak Uslov]</td>
				<td width="6%">Long Stay Disc %<br/>[Dugi boravak Disc%]</td> 
				<td width="6%">Long Stay Refundable<br/>[Dugi boravak Povratno]</td>
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
			   
			    <td width="6%" valign="top"><?php echo $rs_limit->fields['first_name']." ".$rs_limit->fields['last_name']; ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['property_name']); ?> </td>
				<td width="6%" valign="top">
				
				<?php /*$qry_nroom = "SELECT room_type FROM ".$tblprefix."rooms WHERE id=".$rs_limit->fields['room_type']; 
  $rs_nroom = $db->Execute($qry_nroom);*/
  ?>



<?php //echo $rs_nroom->fields['room_type'].""?>
				
				<?php echo stripslashes($rs_limit->fields['room_type']); ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['threshold']); ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['discount_percentage'].'%.'); ?> </td>
				<td width="6%" valign="top"><?php if(stripslashes($rs_limit->fields['refundable'])==1){
			   echo "Yes";
			   }else
			   echo "No"; ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['lastminute_threshold']); ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['lastminute_discount_rate'].'%.'); ?> </td>
				<td width="6%" valign="top"><?php if(stripslashes($rs_limit->fields['lmin_refundable'])==1){
			   echo "Yes";
			   }else
			   echo "No";  ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['threshold_last_minute1']); ?> </td>
				<td width="6%" valign="top"><?php echo stripslashes($rs_limit->fields['lmin_discount_percentage1'].'%.'); ?> </td>
				<td width="6%" valign="top"><?php if(stripslashes($rs_limit->fields['lmin_refundable1'])==1){
			   echo "Yes";
			   }else
			   echo "No";  ?> </td>
			  <td width="5%" valign="top"><a href="admin.php?act=edit_discount&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				
				        <a href="admin.php?act=discount_management&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manage_discount_management" onClick="return confirm('Are you sure you want to Delete?')">
				        <img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" />
				        </a>
		   </td>
		   </tr>
			<?php $rs_limit->MoveNext();
			}?>
				<tr>
						<td colspan="13">
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
			<?php }else{ ?>
				<tr>
					<!--<td colspan="13" class="errmsg"> No Discount Found</td>-->
                    <td colspan="13" class="errmsg"> Ne Popust pronađeni</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
        
	</td>
  	</table>
  </td>
  </tr>
  </table>
</form>
 <!--code for when click on edit button toggle window will open , actually that is use for insertin category-->
<?php if(isset($_GET['cateid'])) {?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php } ?>

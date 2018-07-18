<?php
include('root.php');
include($root.'include/file_include.php');

 
	  $pm_id=$_GET['pm_id'];
      $propid=$_GET['propid'];
      $room = $_GET['id'];
	  	
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
	 
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		 $module_pm_where = ' WHERE '.$tblprefix.'rooms.pm_id = '.$pm_id.' AND '.$tblprefix.'properties.pm_type=1 AND '.$tblprefix.'rooms.id = '.$room.' AND '.$tblprefix.'rooms.property_id ='.$propid;
	}else{
		
		 //$module_pm_where = ' WHERE '.$tblprefix."properties.pm_type=1";
		 $module_pm_where = ' WHERE '.$tblprefix.'rooms.pm_id = '.$pm_id.' AND '.$tblprefix.'properties.pm_type=1 AND '.$tblprefix.'rooms.id = '.$room.' AND '.$tblprefix.'rooms.property_id ='.$propid;
	}

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

   $qry_faq = "SELECT  ".$tblprefix."rooms.*,
                    ".$tblprefix."properties.property_name,
			        ".$tblprefix."property_manager.first_name,
			        ".$tblprefix."property_manager.last_name 
               FROM ".$tblprefix."rooms 
	Inner Join ".$tblprefix."properties ON ".$tblprefix."rooms.property_id= ".$tblprefix."properties.id  
	Inner Join ".$tblprefix."property_manager ON ".$tblprefix."rooms.pm_id = ".$tblprefix."property_manager.id 
	$module_pm_where
	";

	
$rs_faq = $db->Execute($qry_faq);

$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT  ".$tblprefix."rooms.*,
                    ".$tblprefix."properties.property_name,
			        ".$tblprefix."property_manager.first_name,
			        ".$tblprefix."property_manager.last_name 
    FROM ".$tblprefix."rooms  
	Inner Join ".$tblprefix."properties ON ".$tblprefix."rooms.property_id= ".$tblprefix."properties.id  
	Inner Join ".$tblprefix."property_manager ON ".$tblprefix."rooms.pm_id = ".$tblprefix."property_manager.id 
	 $module_pm_where 
	LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
?>
<div id="get_rates_videos">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      
      
     <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			
			<tr>
				<td class="txt2" colspan="2">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="15%">Room Type<br/>[Vrsta sobe]</td>
				<td width="15%">Property<br/>[Naziv]</td>
				<td width="15%">Number Resources Available<br/>[Broj raspolo&#382;ivih soba]</td>
				<td width="15%">Max Persons Per Resources<br/>[Maksimalan broj gostiju po sobi]</td>
				<td width="15%">Meter Square<br/>[Dimenzije sobe]</td>
				<td width="5%">Options</td>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0){ $i=0;}else{
				     $i = ($pageNum*$maxRows);
				   }
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
			   <td width="20%" valign="top">
			            <?php  
						//Room Type  in Mon
						$language_qry = "SELECT ".$tblprefix."language_contents.id,
   				   	    	".$tblprefix."language_contents.language_id ,
				        	".$tblprefix."language_contents.page_id ,
							".$tblprefix."language_contents.field_name, 
							".$tblprefix."language_contents.translation_text,
				        	".$tblprefix."language_contents.translated_text,
							".$tblprefix."language_contents.fld_type
						 FROM ".$tblprefix."language_contents  
						 WHERE ".$tblprefix."language_contents.fld_type ='room_type' AND ".$tblprefix."language_contents.page_id=".$rs_limit->fields['id']." AND ".$tblprefix."language_contents.field_name='room_type_mon'"; 
						$rs_language     = $db->Execute($language_qry);
						$count_language  = $rs_language->RecordCount();
						$total_languages = $count_language;
						  if($count_language>0){
						  $rs_language->MoveFirst();
						  while(!$rs_language->EOF){
						     if($rs_language->fields['translated_text']!="" and $rs_language->fields['translated_text']!=NULL){
							 $rs_limit->fields['room_type'] = $rs_language->fields['translated_text'];
							 }
						     $rs_language->MoveNext();
						    }
						  }
						  echo stripslashes($rs_limit->fields['room_type']); 
						  ?></td>
			   			  <td  valign="top"><?php  echo stripslashes($rs_limit->fields['property_name']); ?></td>
			  
			   <td><?php echo stripslashes($rs_limit->fields['number_resources_available'])."&nbsp;&nbsp;"."Resources"; ?>
			   </td>
			   <td><?php echo stripslashes($rs_limit->fields['max_persons_per_resource'])."&nbsp;&nbsp;"."Persons Per Resource"; ?>
			   </td>
			   <td><?php echo stripslashes($rs_limit->fields['meter_square']); ?>
			   </td>

     		   <td>
						<a href="admin.php?act=edit_room_management&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>
						&amp;pm_id=<?php echo base64_encode($rs_limit->fields['pm_id']);?>&amp;property_id=<?php echo base64_encode($rs_limit->fields['property_id']);?>">	
						<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" />
						</a>&nbsp;&nbsp;				
				
				        <a href="admin.php?act=room_management&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manage_room_management" onClick="return confirm('Are you sure you want to Delete?')">
				        <img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" />
				        </a>
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
					<!--<td colspan="13" class="errmsg"> No Room Found</td>-->
                    <td colspan="13" class="errmsg"> Ne Soba pronađeni</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </table></td>
</div>


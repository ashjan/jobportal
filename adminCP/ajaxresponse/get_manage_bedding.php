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
		
	$propid		= $_GET['propid'];
	$pm_id		= $_GET['pm_id'];
	$room_id	= $_GET['rooms_id1'];	

$maxRows = 50;

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'bedding.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND '.$tblprefix.'properties.pm_type=1  
	                           AND '.$tblprefix.'bedding.room_id = '.$room_id.'
							   AND '.$tblprefix.'bedding.property_id = '.$propid;
}else{	
	  $module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=1 							    
							   AND '.$tblprefix.'bedding.room_id = '.$room_id.'
							   AND '.$tblprefix.'bedding.property_id = '.$propid.'
							   AND '.$tblprefix.'bedding.pm_id='.$pm_id ;
		
}


if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
	 $qry_faq = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.id,
					".$tblprefix."bedding.room_id,
					".$tblprefix."bedding.property_id,
					".$tblprefix."bedding.pm_id,
					".$tblprefix."bedding.id,
					".$tblprefix."bedding.bedding_type_name,
					".$tblprefix."bedding.number_beds,
					".$tblprefix."bedding.extra_beds,
					".$tblprefix."bedding.dimensions_width,
					".$tblprefix."bedding.dimensions_length,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."bedding
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."bedding.room_id = ".$tblprefix."rooms.id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."bedding.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."bedding.pm_id = ".$tblprefix."property_manager.id
					 $module_pm_where 
					";
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 $qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.id,
					".$tblprefix."bedding.room_id,
					".$tblprefix."bedding.property_id,
					".$tblprefix."bedding.pm_id,
					".$tblprefix."bedding.extra_beds,
					".$tblprefix."bedding.id,
					".$tblprefix."bedding.bedding_type_name,
					".$tblprefix."bedding.number_beds,
					".$tblprefix."bedding.dimensions_width,
					".$tblprefix."bedding.dimensions_length,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."bedding 
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."bedding.room_id = ".$tblprefix."rooms.id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."bedding.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."bedding.pm_id = ".$tblprefix."property_manager.id  $module_pm_where ORDER BY ".$tblprefix."bedding.id DESC
					LIMIT $startRow,$maxRows"; 
			
					
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//List down all Rooms
$qry_region = "SELECT * FROM ".$tblprefix."rooms" ;
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;


//List down all PMs
$qry_pm = "SELECT * FROM ".$tblprefix."property_manager" ;
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;



//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."properties where pm_type=1" ;
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;

$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();



?>
<script>
function ShowConversionResult(getid,resultid){
widthincm=$("#"+getid).val();
widthinIN=widthincm *0.4 ;
widthinIN = Math.round(widthinIN,2);
widthinIN = widthinIN + 'in';
$("#"+resultid).html(widthinIN);
}
</script>


    <div id="get_prop_bedding_types">
	 <form name="mngcontentform" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
	<td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
     <tr height="5%">
        <td colspan="8" ></td>
      </tr>
     <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="3%">Sr#</td>
                <td width="15%">Room Type<br/>[Vrsta sobe]</td>
				<td width="15%">PM</td>
				<td width="15%">Property<br/>[Vlasnik ]</td>
				<td width="15%">Bedding Type Name<br/>[Vrsta kreveta]</td>
				<td width="15%">Number Of Beds<br/>[Broj le&#382;ajeva]</td>
				<td width="15%">Extra Beds<br/>[Dodatni kreveti]</td>
				<td width="15%">Width<br/>[Širina kreveta]</td>
				<td width="15%">Length<br/>[Du&#382;ina kreveta]</td>
				<td width="10%">Options</td>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0){$i=0;}else{
				     $i = ($pageNum*$maxRows);
				   }
		 while(!$rs_limit->EOF){?>
		 <tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
		 <td valign="top"><?php echo ++$i; ?></td>
         <td  valign="top">
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
						 WHERE ".$tblprefix."language_contents.fld_type ='room_type' AND ".$tblprefix."language_contents.page_id=".$rs_limit->fields['room_id']." AND ".$tblprefix."language_contents.field_name='room_type_mon'"; 
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
         ?>
		 </td>
		 <td  valign="top"><?php  echo $rs_limit->fields['first_name'].'  '.$rs_limit->fields['last_name']; ?></td>
		 <td  valign="top"><?php  echo $rs_limit->fields['property_name']; ?></td>
		 <td  valign="top">
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
						 WHERE ".$tblprefix."language_contents.fld_type ='bedding_type_name' AND ".$tblprefix."language_contents.page_id=".$rs_limit->fields['id']." AND ".$tblprefix."language_contents.field_name='bedding_type_name_mon'";
						$rs_language     = $db->Execute($language_qry);
						$count_language  = $rs_language->RecordCount();
						$total_languages = $count_language;
						  if($count_language>0){
						  $rs_language->MoveFirst();
						  while(!$rs_language->EOF){
						     if($rs_language->fields['translated_text']!="" and $rs_language->fields['translated_text']!=NULL){
							 $rs_limit->fields['bedding_type_name'] = $rs_language->fields['translated_text'];
							 }
						     $rs_language->MoveNext();
						    }
						  }
		 ?> 
		 <?php  echo stripslashes($rs_limit->fields['bedding_type_name']); ?></td>
		 <td><?php echo "No of beds in room" . "&nbsp;&nbsp;" . $rs_limit->fields['number_beds']; ?></td>
		 <td  valign="top"><?php  echo $rs_limit->fields['extra_beds']; ?></td>
		 <td><table width="100%" class="txt"><tr><td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_width'])."&nbsp;&nbsp;"."cm"; ?></td>&nbsp;&nbsp;&nbsp;<td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_width'])*0.4."&nbsp;&nbsp;"."In"; ?></td></tr></table></td>
		 <td><table width="100%" class="txt"><tr><td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_length'])."&nbsp;&nbsp;"."cm"; ?></td>&nbsp;&nbsp;&nbsp; <td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_length'])*0.4."&nbsp;&nbsp;"."In"; ?></td></tr></table></td>
		<td>
						<a href="admin.php?act=edit_bedding&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;pm_id=<?php echo base64_encode($rs_limit->fields['pm_id']);?>&amp;property_id=<?php echo base64_encode($rs_limit->fields['property_id']);?>&amp;room_id=<?php echo base64_encode($rs_limit->fields['room_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;	
                        			
				<a href="admin.php?act=manage_bedding&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=bedding_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } 
							?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="13" class="errmsg"> No Room Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</table>
    </td></tr>
</form>
	</div>	
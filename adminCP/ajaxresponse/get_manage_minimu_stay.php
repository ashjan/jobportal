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

	$pm_id		=$_GET['pm_id'];
	$propid		=$_GET['propid'];
	$room_id	=$_GET['rooms_id1'];
	
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'property_minimum_stay.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
								AND '.$tblprefix.'properties.pm_type=1  
								AND '.$tblprefix.'properties.property_category=24 
								AND '.$tblprefix.'property_minimum_stay.room_id = '.$room_id.'
								AND '.$tblprefix.'property_minimum_stay.property_id = '.$propid;	
}else{
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=1
								AND '.$tblprefix.'properties.property_category=24  							    
								AND '.$tblprefix.'property_minimum_stay.room_id = '.$room_id.'
								AND '.$tblprefix.'property_minimum_stay.property_id = '.$propid.'
								AND '.$tblprefix.'property_minimum_stay.pm_id='.$pm_id ;
}	

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
$qry_faq = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."property_minimum_stay.rate_type,
					".$tblprefix."property_minimum_stay.night_stay,
					".$tblprefix."property_minimum_stay.id,
					".$tblprefix."property_minimum_stay.room_id,
					".$tblprefix."rooms.id,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."property_minimum_stay 
	Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_minimum_stay.room_id = ".$tblprefix."rooms.id 
	Inner Join ".$tblprefix."properties ON ".$tblprefix."property_minimum_stay.property_id= ".$tblprefix."properties.id  
	Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_minimum_stay.pm_id = ".$tblprefix."property_manager.id
	 $module_pm_where 
	";
												
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."property_minimum_stay.property_id,
					".$tblprefix."property_minimum_stay.pm_id,
					".$tblprefix."property_minimum_stay.rate_type,
					".$tblprefix."property_minimum_stay.night_stay,
					".$tblprefix."property_minimum_stay.id as mstayid,
					".$tblprefix."property_minimum_stay.room_id,
					".$tblprefix."rooms.id as rid,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."property_minimum_stay
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_minimum_stay.room_id = ".$tblprefix."rooms.id
					Inner Join ".$tblprefix."properties ON ".$tblprefix."property_minimum_stay.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_minimum_stay.pm_id = ".$tblprefix."property_manager.id $module_pm_where ORDER BY ".$tblprefix."property_minimum_stay.id DESC
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT
                    ".$tblprefix."rooms.id,
					".$tblprefix."rooms.room_type
					FROM
					".$tblprefix."rooms"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();

//List down all PMs
$qry_pm = "SELECT ".$tblprefix."property_manager.*,
   				   	   ".$tblprefix."properties.property_name ,
				       ".$tblprefix."properties.pm_type ,
				       ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;

//List down all Properties
$qry_properties =  "SELECT * FROM ".$tblprefix."properties 
					WHERE pm_type=1 
					AND ".$tblprefix."properties.property_category=24";
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;

$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]["pm_id"]." 
				AND pm_type=1 
				AND ".$tblprefix."properties.property_category=24";
$rs_prop = $db->Execute($property_qry);
$totalproperties =  $rs_prop->RecordCount();
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


    <div id="get_manage_minimu_stay">
	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	   <td width="5%">Sr#</td>
	    <td width="20%">Room type<br/>[Vrsta sobe]</td>
		<td width="15%">PM<br/>[vlasnika objekta]</td>
		<td width="20%">Property<br/>[Vlasnik ]</td>
		<td width="15%">Rate Type<br/>[Vrsta cijene]</td>
       	<td width="20%">Night Minimum Stay<br/>[Minimalan broj noćenja]</td>
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
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						
					  <td valign="top">
					  <?php 
					  if($rs_limit->fields['room_id']!=0){
					  echo $rs_limit->fields['room_type'];
					  }elseif($rs_limit->fields['room_id']==0){
					  echo 'All room types';
					  }
					  ?>
					  
					  </td>
					  
		 <td  valign="top" ><?php  echo stripslashes($rs_limit->fields['first_name']); ?>
		 <?php  echo stripslashes($rs_limit->fields['last_name']); ?></td>
					  <td  valign="top"><?php  echo stripslashes($rs_limit->fields['property_name']); ?></td>
					  
					  <td valign="top"><?php 
					  if(stripslashes($rs_limit->fields['rate_type'])==1){
					  	echo "Standard Rates";
					  }elseif(stripslashes($rs_limit->fields['rate_type'])==2){
					  	echo "Advance Rates";
					  }else{
					  	echo "All Rates";
					  }
					  ?></td>
					  <td valign="top" text align="center"><?php  echo stripslashes($rs_limit->fields['night_stay']); ?></td>
            	<td valign="top">
                <a href="admin.php?act=edit_minimum_stay&amp;id=<?php echo base64_encode($rs_limit->fields['mstayid']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_minimu_stay&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['mstayid']); ?>&amp;request_page=minimum_stay_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						
						?>
      <input type="hidden" name="act" value="manage_minimu_stay" />
      <input type="hidden" name="request_page" value="minimum_stay_management" />
      <input type="hidden" name="mode" value="add">
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
                            <!-- END: Pagination Code -->						
    </td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="hidden" name="act" value="manageletter">
      <input type="hidden" name="mode" value="delete">
    </td>
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
</form>
</div>	
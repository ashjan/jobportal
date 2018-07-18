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

	$propid	= $_GET['propid'];
	$pm_id	= $_GET['pm_id'];
	
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pmc.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
							AND
							pmc.pt_id ='.$propid.' 
							AND
							pmc.pm_id ='.$pm_id.'' ;
}else{
	 $module_pm_where = ' WHERE pmc.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
							AND
							pmc.pt_id ='.$propid.' 
							AND
							pmc.pm_id ='.$pm_id.'' ;
}


$maxRows = 100;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

 $qry_com = "SELECT pmc.*,pm.id as pm_idd,pm.first_name,pm.last_name FROM `".$tblprefix."property_manager_commission` as pmc 
INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id  $module_pm_where  ";

$rs_qry_com = $db->Execute($qry_com);
$count_add =  $rs_qry_com->RecordCount();

$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pm.last_name,pt.property_name FROM `".$tblprefix."property_manager_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id INNER JOIN tbl_properties as pt ON pt.id=pmc.pt_id $module_pm_where ";
 
$rs_limit = $db->Execute($qry_limit);

$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager "; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountalpha =  $rs_limit->RecordCount();



//Dropdown for parent
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>
<div id="get_prop_bedding_types">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt" >
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
    
      <tr class="tabheading"> 
            <td width="5%">Sr#</td>
            <td width="15%">Property Manager</td>
            <td width="15%">Property<br/>[Vlasnik] </td>
            <td width="15%">Starting Date<br/>[Početni datum]</td>
            <td width="15%">Ending Date<br/>[Krajnji datum]</td>
            <td width="20%">Commision<br/>[Provizija]</td>
            <td width="15%">Status</td>
            <td width="5%">Options	</td>
        </tr>
		<?php 
				if($totalcountalpha >0){
					if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					
					 while(!$rs_limit->EOF){ ?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['first_name']." ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['property_name']); ?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['from_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['to_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['commission']); ?></td>
					 	<td valign="top">
						<?php if($rs_limit->fields['status'] == '0'){?>
						<a href="admin.php?act=manage_pm_commission&amp;mode=updatestatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=pm_commision_management&amp;" >
							<img src="<?php MYSURL?>graphics/deactivate.gif" title="Click to Approve " border="0" /></a>&nbsp;&nbsp;
							<?php }else{?>
						<a href="admin.php?act=manage_pm_commission&mode=updatestatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=pm_commision_management" >
							<img src="<?php MYSURL?>graphics/activate.gif" title="Click to Deactivate " border="0" /></a>&nbsp;&nbsp;
							<?php }?>
					 </td>
						<td valign="top">
                <a href="admin.php?act=edit_pm_commision&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_pm_commission&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=pm_commision_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        </td>
            </tr>
					
        
      
      <input type="hidden" name="act" value="manage_pm_commission" />
      <input type="hidden" name="request_page" value="pm_commision_management" />
      <input type="hidden" name="mode" value="add">
		<?php 
        	$rs_limit->MoveNext();// while(!$rs_limit->EOF){ 
        } 
        ?>
              
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
</div>
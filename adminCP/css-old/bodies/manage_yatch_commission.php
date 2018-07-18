<?php

	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}


if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pmc.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}


$maxRows = 100;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_com = "SELECT pmc.*,pm.id as pm_idd,pm.first_name,pm.last_name FROM `".$tblprefix."yatch_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id  $module_pm_where";

$rs_qry_com = $db->Execute($qry_com);
$count_add =  $rs_qry_com->RecordCount();

$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pm.last_name,pt.agn_name FROM `".$tblprefix."yatch_commission` as pmc LEFT JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id LEFT JOIN tbl_yatchagency as pt ON pt.agn_id=pmc.pt_id $module_pm_where ";
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
$property_qry = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

$qry_yatchtypes = "SELECT * FROM ".$tblprefix."yatchtypes"; 
$rs_yatchtypes = $db->Execute($qry_yatchtypes);

$qry_ytcom = "SELECT * FROM ".$tblprefix."yatch_commission";  
$rs_ytcom = $db->Execute($qry_ytcom);

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Yatch Commision</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    	<td colspan="5" align="right">Total Number of Commision Found: <?php echo $totalcountalpha ?></td>
	</tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		   
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
		  <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name"  class="fields" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
					<option value="0">Select PM</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
<option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
				<?php
					$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr>
<?php  } ?>
			
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Agency</td>
              <td>
			  <div id="agency_name"> 
			    <select name="agency_id" id="agency_id" class="fields" />
					<option value="0">Select Agency</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['agn_id']; ?>"><?php echo $rs_property->fields['agn_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
<?php }else{ ?>
			<tr>
             <td>Agency</td>
              <td>
			  <div id="agency_name"> 
			    <select name="agency_id" id="agency_id" class="fields" />
					<option value="0">Select Agency</option>
				</select>
			  </div>
			  </td>
            </tr>
			
			
			
			 <!--<tr><td>Yatch</td>
              <td>
			    <select name="yatch_id" id="yatch_id"  class="fields" onchange="">
					<option value="0">Select Yatch Name</option>
				 	<?php
						//while(!$rs_yatchtypes->EOF){?>
<option value="<?php //echo $rs_yatchtypes->fields['id'];?>"><?php //echo $rs_yatchtypes->fields['yatch_name'];  ?></option>
				<?php
					//$rs_yatchtypes->MoveNext();
						//}?>		
				</select>
			  </td>
            </tr>-->
				
			
<?php  } ?>			
			  
		   <td> Starting Date </td>
			  <?php // $from_date=  date("y/m/d",strtotime($from_date)); ?>
			  <td width="200"><input  style="width:100px;" class="fields" type="text" name="from_date"  id="from_date" value="" />
			  
			  <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'from_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
				</script>
			  
			  </td>
            </tr>
			
			<tr>
              <td> Ending Date </td>
			  <?php // $to_date=  date("y/m/d",strtotime($to_date)); ?>
			  <td width="200"><input class="fields"  style="width:100px;" type="text" name="to_date"  id="to_date" value="" />
			  
			  <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'to_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
				</script>
			  
			  </td>
            </tr>
			
			<tr>
              <td> Commission </td>
			  <?php
			  if(isset($_SESSION["addpcommision"]["commission"]))
			  {
			  		 $comm = $_SESSION["addpcommision"]["commission"];
			  }
			  else
			  {
			  		 $comm = "";
			  }
			  ?>
              <td><input type="text" name="commission" class="fields1" id="commission" value="" /></td>
            </tr>
			
			 <tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Commision" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="<?=$_GET['act']?>" />
          <input type="hidden" name="request_page" value="yatch_commision_management" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div></td>
  </tr>
  <form name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
    <td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	   <td width="5%">Sr#</td>
	    <td width="15%">Property Manager</td>
		<td width="15%">Agency </td>
		<!--<td width="15%">Yacht </td>-->
		<td width="15%">Starting Date</td>
       	<td width="15%">Ending Date</td>
        <td width="20%">Commision</td>
        <td width="15%">Status</td>
		<td width="5%">Option</td>
		</tr>
<?php if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }?>
				   	<?php  while(!$rs_limit->EOF){ ?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['first_name']." ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php $qry_content = "SELECT * FROM  ".$tblprefix."yatchagency WHERE agn_id=".$rs_limit->fields['agency_id'];
		$rs_content = $db->Execute($qry_content);
		 echo $rs_content->fields['agn_name']; ?>
</td>
						<!--<td valign="top">
						<?php //$qry_yatch =  "SELECT * FROM ".$tblprefix."yatchtypes WHERE id=".$rs_limit->fields['yatch_id']; 
//$rs_yatch = $db->Execute($qry_yatch); echo $rs_yatch->fields['yatch_name']; ?>
						</td>-->
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['from_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['to_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['commission']); ?></td>
					 	<td valign="top">
						<?php if($rs_limit->fields['status'] == '0'){?>
						<a href="admin.php?act=manage_yatch_commission&amp;mode=updatestatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=yatch_commision_management" >
							<img src="<?php MYSURL?>graphics/deactivate.gif" title="Click to Approve " border="0" /></a>&nbsp;&nbsp;
							<?php }else{?>
						<a href="admin.php?act=manage_yatch_commission&mode=updatestatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=yatch_commision_management" >
							<img src="<?php MYSURL?>graphics/activate.gif" title="Click to Deactivate " border="0" /></a>&nbsp;&nbsp;
							<?php }?>
			</td>
			<td valign="top">
                <a href="admin.php?act=edit_yatch_commision&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_yatch_commission&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=yatch_commision_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
            </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						?>
      <input type="hidden" name="act" value="<?=$_GET['act']?>" />
      <input type="hidden" name="request_page" value="yatch_commision_management" />
      <input type="hidden" name="mode" value="add">
  </form>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="hidden" name="act" value="manageletter">
      <input type="hidden" name="mode" value="delete">
    </td>
  </tr>
  <tr>
  <td colspan="13"><!-- START: Pagination Code -->
    <div class="txt">
      <div id="txt" align="center"> Showing
        <?php 
							
							echo ($startRow + 1) ?>
        to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />
        Pages ::
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
        <a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a> &nbsp;
        <?php } 		
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
			  if ($pageNum < $totalPages - 1){
		?>
        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
       
      </div>
    </div>
    <!-- END: Pagination Code -->
  </td>
</tr>
<?php
	}else{
?>
<!--<tr>
  <td colspan="13" class="errmsg"> No Commission Found</td>
</tr>-->
<?php
				}// end if($totalcount > 0)
?>
  
</table>
</td>
</tr>
</table>
<?php //echo $where;?>

 <?php
					if($_SESSION[SESSNAME]['pm_moduleid']==2){
					?>
                    <script language="javascript">
	                    get_facilities('properties_facilities', <?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_facilities.php"?>');
					</script>
                    <?php
					}
					?>

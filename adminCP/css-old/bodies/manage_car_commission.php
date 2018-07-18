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

$qry_com = "SELECT pmc.*,pm.id as pm_idd,pm.first_name,pm.last_name FROM `".$tblprefix."car_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id  $module_pm_where  "; 

$rs_qry_com = $db->Execute($qry_com);
$count_add =  $rs_qry_com->RecordCount();

$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pm.last_name,pt.agn_name FROM `".$tblprefix."car_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id INNER JOIN tbl_agency as pt ON pt.agn_id=pmc.pt_id $module_pm_where ";

 
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
$property_qry = "SELECT agn_id,agn_name FROM ".$tblprefix."agency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Car Commision</td>
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
			    <select name="first_name" id="first_name"  class="fields" onchange="get_caragency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_caragencyy_name.php"?>')">
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
<?php  } ?>			
			
		 <td> Starting Date </td>
			  <?php // $from_date=  date("y/m/d",strtotime($from_date)); ?>
			  <td width="200"><input  style="width:100px;" class="fields" type="text" name="from_date"  id="from_date" value="<?php 
			  
			  $start_date=date("m/d/Y");
			  echo $start_date; ?>" />
			  
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
			  <td width="200"><input class="fields"  style="width:100px;" type="text" name="to_date"  id="to_date" value="<?php 
			  $today = date("m/d/Y");
			 
			  $tomorrow = strtotime(date("m/d/Y", strtotime($today)) . " +1 day");
			 // $to_date = date("m/d/Y",strtotime($tomorrow));
			  echo date("m/d/Y",$tomorrow);?>" />
			  
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
              <td><input type="text" name="commission" class="fields1" id="commission" value="<?php echo $comm;?>" /></td>
            </tr>
			
			 <tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Commision" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_car_commission" />
          <input type="hidden" name="request_page" value="car_commision_management" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div></td>
  </tr>
 
    <tr>
    
    <td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	   <td width="5%">Sr#</td>
	    <td width="15%">Car Manager</td>
		<td width="15%">Agency </td>
		<td width="15%">Starting Date</td>
       	<td width="15%">Ending Date</td>
        <td width="20%">Commision</td>
        <td width="15%">Status</td>
		<td width="5%">Option</td>
		</tr>
				<?php 	if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }?>
					<?php  while(!$rs_limit->EOF){ ?>
					
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['first_name']." ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['agn_name']); ?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['from_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['to_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['commission'])."%"; ?></td>
					 	<td valign="top">
						<?php if($rs_limit->fields['status'] == '0'){?>
						<a href="admin.php?act=manage_car_commission&amp;mode=updatestatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=car_commision_management" >
							<img src="<?php MYSURL?>graphics/deactivate.gif" title="Click to Approve " border="0" /></a>&nbsp;&nbsp;
							<?php }else{?>
						<a href="admin.php?act=manage_car_commission&mode=updatestatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;status=<?php echo $rs_limit->fields['status']; ?>&amp;request_page=car_commision_management" >
							<img src="<?php MYSURL?>graphics/activate.gif" title="Click to Deactivate " border="0" /></a>&nbsp;&nbsp;
							<?php }?>
					 </td>
						<td valign="top">
                <a href="admin.php?act=edit_car_commision&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_car_commission&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=car_commision_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
    </td>
  </tr>
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

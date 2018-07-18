<?php
$id=base64_decode($_GET['id']);
 $qry_limit =  "SELECT * FROM ".$tblprefix."yatch_commission where id=".$id;
$rs_limit = $db->Execute($qry_limit);

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' AND pm.id = '.$_SESSION[SESSNAME]['pm_id'];
	$pm_id = $_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}

$qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					FROM
					tbl_users"; 
$rs_property_manag = $db->Execute($qry_property_manag);



	    $qry_content = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pt.agn_name FROM `".$tblprefix."yatch_commission` as pmc INNER JOIN tbl_users as pm ON pm.id=pmc.pm_id INNER JOIN tbl_yatchagency as pt ON pt.agn_id=pmc.pt_id WHERE pmc.id=".$id.$module_pm_where;
		
		
	    
		
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		$pt_id = $rs_content->fields['pt_id'];
		
		$qry_prop ="SELECT * FROM ".$tblprefix."yatchagency";  
		$rs_prop = $db->Execute($qry_prop);

$qry_yatchtypes = "SELECT * FROM ".$tblprefix."yatchtypes"; 
$rs_yatchtypes = $db->Execute($qry_yatchtypes);

$qry_ytcom = "SELECT * FROM ".$tblprefix."yatch_commission WHERE id=".$id;  
$rs_ytcom = $db->Execute($qry_ytcom);



?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Yatch Commision Update Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
		
		</tr>
		
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
		<tr>
        <td>PM Name</td>
        <td>
		<select name="first_name" id="first_name" class=" fields" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agn_name.php"?>')">
					<option value="0">Select PM</option>
				 	<?php
						
				while(!$rs_property_manag->EOF){?>
		<option <?php if($rs_limit->fields['pm_id']==$rs_property_manag->fields['id']){  echo 'selected="selected"';
		               $pm_id=$rs_limit->fields['pm_id'];  
}?> value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'];  ?></option>
				<?php
				$rs_property_manag->MoveNext();
				}?>		
		</select>
				
				
			  </td>
            </tr>
		 
		 <?php } ?>   
			<tr>
             <td>Agency</td>
              <td>
			  <?php 
		if(!empty($pm_id)){ 
		$qry_content = "SELECT * FROM  ".$tblprefix."yatchagency WHERE pm_id=".$pm_id;
		}else {
		$qry_content = "SELECT * FROM  ".$tblprefix."yatchagency";
		}
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
			  
			  ?>
			  
			  <div id="agency_name"> 
			    <select name="agency_id" id="agency_id" style="width:146px;" />
					<option value="0">Select Agency</option>
					<?php 
				$rs_content->MoveFirst();
				while(!$rs_content->EOF){
				$is_cat_selected = '';
				if($_SESSION[SESSNAME]['pm_moduleid']==2){
					if($rs_content->fields['agn_id']==$rs_limit->fields['agency_id']){
						$is_cat_selected = 'selected="selected"';
					} else {
						$is_cat_selected = '';
					}
                }else{
				if($rs_content->fields['agn_id']==$rs_limit->fields['agency_id']){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
}
?>
<option value="<?php echo $rs_content->fields['agn_id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_content->fields['agn_name'];?></option>
	<?php $rs_content->MoveNext();
	}?>					
					
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
<option value="<?php //echo $rs_yatchtypes->fields['id'];?>" <?php //if($rs_yatchtypes->fields['id']==$rs_ytcom->fields['yatch_id']){echo 'selected="selected"';} ?>

><?php //echo $rs_yatchtypes->fields['yatch_name'];  ?></option>
				<?php
					//$rs_yatchtypes->MoveNext();
						//}?>		
				</select>
			  </td>
            </tr>-->
				
		
		   <td> Starting Date </td>
			  
			<?php
			  $from_date = $rs_limit->fields['from_date']; 
			  $from_date=  date("m/d/Y",strtotime($from_date)); ?>
			  <td ><input type="text" name="from_date"  id="from_date" value="<?php echo $from_date; ?>" />
			  
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managemenufrm',
                                        // input name
                                        'controlname': 'from_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			  
			  </td>
            </tr>
			
			<tr>
              <td> Ending Date </td>
			  <?php
			  $to_date = $rs_limit->fields['to_date']; 
			  $to_date =  date("m/d/Y",strtotime($to_date)); ?>
			  <td ><input type="text" name="to_date"  id="to_date" value="<?php echo $to_date; ?>" />					
			  
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managemenufrm',
                                        // input name
                                        'controlname': 'to_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			  
			  </td>
            </tr>
			
		<tr>
              <td> Commision </td>
			  <td><input type="text" name="commission" class="fields1" id="commission"  value="<?php echo $rs_limit->fields['commission']; ?>" /></td>
       		  </tr>
			  <tr><td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Commision" class="button"/>
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_yatch_commision" />
			<input type="hidden" name="act2" value="manage_yatch_commission" />
			<input type="hidden" name="request_page" value="yatch_commision_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
			</td>
	    </tr>
</table>
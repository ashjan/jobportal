<?php
$id=base64_decode($_GET['id']);

$qry_limit =  "SELECT * FROM ".$tblprefix."property_manager_commission where id='".$id."'";
$rs_limit = $db->Execute($qry_limit);

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' AND pm.id = '.$_SESSION[SESSNAME]['pm_id'];
	$pm_id = $_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}

$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);



	    $qry_content = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pm.last_name,pt.property_name FROM `".$tblprefix."property_manager_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id INNER JOIN tbl_properties as pt ON pt.id=pmc.pt_id WHERE pmc.id=".$id.$module_pm_where;
	    
		
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		$pt_id = $rs_content->fields['pt_id'];
		
		$qry_prop ="SELECT * FROM ".$tblprefix."properties WHERE id=".$pt_id.' AND pm_type=1' ;
		$rs_prop = $db->Execute($qry_prop);
		
       




?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Property Commision Management Section</td>
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
		<select name="first_name" id="first_name" class=" fields" onchange="get_prop_name3('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name3.php"?>')">
					<option value="0">Select PM</option>
				 	<?php
						
				while(!$rs_property_manag->EOF){?>
		<option <?php if($rs_limit->fields['pm_id']==$rs_property_manag->fields['id']){  echo 'selected="selected"';
		               $pm_id=$rs_limit->fields['pm_id'];  
}?> value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name']."&nbsp;".$rs_property_manag->fields['last_name'];  ?></option>
				<?php
				$rs_property_manag->MoveNext();
				}?>		
		</select>
				
				
			  </td>
            </tr>
		 
		 <?php } ?>   
			<tr>
             <td>Property Name</td>
              <td>
			  <?php 
		if(!empty($pm_id)){ 
		$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$pm_id.' 
						AND pm_type=1 
						AND  property_category=24 ';
		}else {
		$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_type=1 AND  property_category=24";
		}
		
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
			  
			  ?>
			  
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" style="width:146px;" />
					<option value="0">Izaberite objekat</option>
					<?php 
				
				
				
				$rs_content->MoveFirst();
				while(!$rs_content->EOF){
				$is_cat_selected = '';
				if($_SESSION[SESSNAME]['pm_moduleid']==2){
      
					if($rs_content->fields['properties_slug']==$rs_prop->fields['properties_slug'])
					{
						$is_cat_selected = 'selected="selected"';
					}
					else {
						$is_cat_selected = '';
					}
                }else{
	
         
				if($rs_content->fields['pt_id']==$rs_prop->fields['id']){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
}
?>
<option value="<?php echo $rs_content->fields['id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_content->fields['property_name'];?></option>
	<?php $rs_content->MoveNext();
	}?>					
					
				</select>
				</div>
			  </td>
            </tr>
				
				
				
				
				
				
				
		
		   <td> Starting Date </td>
			  
			<?php
			  $from_date = $rs_limit->fields['from_date']; 
			  $from_date=  date("m/d/Y",strtotime($from_date)); ?>
			  <td width="200"><input type="text" name="from_date"  id="from_date" value="<?php echo $from_date; ?>" />
			  
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
			  <td width="200"><input type="text" name="to_date"  id="to_date" value="<?php echo $to_date; ?>" />					
			  
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
			<input type="hidden" name="act" value="edit_pm_commision" />
			<input type="hidden" name="act2" value="manage_pm_commission" />
			<input type="hidden" name="request_page" value="pm_commision_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
			</td>
	    </tr>
</table>

<?php
$id=base64_decode($_GET['id']);
$qry_limit =  "SELECT pmc.*,pm.id as pm_idd,pm.first_name FROM `".$tblprefix."users_commission` as pmc INNER JOIN tbl_users as pm ON pm.id=pmc.pm_id";
$rs_limit = $db->Execute($qry_limit);


$qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					FROM
					tbl_users"; 
$rs_property_manag = $db->Execute($qry_property_manag);



?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Property Commision Management Section</td>
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
				<tr>
					<td class="txt1">Property Manager Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
				 	<option value="">Izaberite vlasnika objekta</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php //echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['first_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
           
		</tr>
		 
		 
		   <td> Starting Date </td>
             
			  <?php // $from_date=  date("y/m/d",strtotime($from_date)); ?>
			  <td width="200"><input type="text" name="from_date"  id="from_date" value="<?php echo $rs_limit->fields['from_date']; ?>" />
			  
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
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
			  <?php // $to_date=  date("y/m/d",strtotime($to_date)); ?>
			  <td width="200"><input type="text" name="to_date"  id="to_date" value="<?php echo $rs_limit->fields['to_date']; ?>" />
			  
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
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
			  <td><input type="text" name="commission" class="fields" id="commission"  value="<?php echo $rs_limit->fields['commission']; ?>" /></td>
       		  </tr>
			  <tr><td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Commision" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_yacht_commision" />
			<input type="hidden" name="act2" value="manage_yacht_commission" />
			<input type="hidden" name="request_page" value="yacht_commision_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
			</td>
	    </tr>
</table>


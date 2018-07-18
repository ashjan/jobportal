<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT 
                   id,
				   feature_title,
				   business_description,
                   checkin_times,
				   area_activities,
				   driving_directions,
				   airports,
				   other_transports,
				   policies_disclaimer
                   FROM ".$tblprefix."property_features WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);
 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Property Features Section</td>
 	</tr>
 
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				
				<td class="txt1">Feature title</td>
				<td>
				<input type="text" class="fields" name="feature_title" id="feature_title" value="<?php echo $rs_limit->fields['feature_title']?>" />
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Business Description</td>
				<td>
				<textarea rows="2" cols="20" name="business_description" class="smalltxtareas" id="business_description" /><?php echo $rs_limit->fields['business_description']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Checking Times</td>
				<td>
				<input type="text" name="checkin_times" id="checkin_times" clas="checkin_times" value="<?php echo date("m/d/Y",strtotime(checkin_times))?>" >
				<script language="JavaScript">
                                var o_cal = new tcal ({
                                    // input name
                                    'controlname': 'checkin_times'
                                });
                                // individual template parameters can be modified via the calendar variable
                                o_cal.a_tpl.yearscroll = false;
                                o_cal.a_tpl.weekstart = 1;
                                </script>
				</td>  
				</tr>
				
				<tr>
				<td class="txt1">Area Activities</td>
				<td>
				<textarea rows="2" cols="20" name="area_activities" class="smalltxtareas" id="area_activities"  /><?php echo $rs_limit->fields['area_activities']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Driving Directions</td>
				<td>
				<textarea rows="2" cols="20" name="driving_directions" class="smalltxtareas" id="driving_directions" /><?php echo $rs_limit->fields['driving_directions']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Airports</td>
				<td>
				<textarea rows="2" cols="20" name="airports" class="smalltxtareas" id="airports" /><?php echo $rs_limit->fields['airports']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Other Transports</td>
				<td>
				<textarea rows="2" cols="20" name="other_transports" class="smalltxtareas" id="other_transports" /><?php echo $rs_limit->fields['other_transports']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Policies Disclaimer</td>
				<td>
				<textarea rows="2" cols="20" name="policies_disclaimer" class="smalltxtareas" id="policies_disclaimer" /><?php echo $rs_limit->fields['policies_disclaimer']?></textarea>
				</td> 
				</tr>
<?php 
				if($totallanguages>0){ 
					while(!$rs_language->EOF){
					echo '<tr>
					<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
					<td>
					<input name="categoryname_'.$rs_language->fields['id'].'" id="categoryname_'.$rs_language->fields['id'].'" value="" type="text" size="55"  maxlength="100" />
					</td>
					</tr>';
					$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Features" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="property_features">
		<input type="hidden" name="act2" value="property_features">
		
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="features_management" />
					</td>
				</tr>
</form> 

		
		</td>
	</tr>
</table>


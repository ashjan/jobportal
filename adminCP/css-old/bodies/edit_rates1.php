<?php
$id=base64_decode($_REQUEST['id']);

 $qry_limit1 = "SELECT * FROM ".$tblprefix."standard_rates WHERE id=".$id;

$rs_limit1 = $db->Execute($qry_limit1);
 $pm_id=$rs_limit1->fields['pm_id'];


$qry_limit = "SELECT
				".$tblprefix."property_manager.first_name,
				".$tblprefix."property_manager.last_name,
				".$tblprefix."properties.property_name,
				".$tblprefix."rooms.room_type,
				".$tblprefix."standard_rates.id,
				".$tblprefix."standard_rates.room_type_id,
				".$tblprefix."standard_rates.pm_id,
				".$tblprefix."standard_rates.property_id,
				".$tblprefix."standard_rates.standard_start_date,
				".$tblprefix."standard_rates.standard_end_date,
				".$tblprefix."standard_rates.standard_rate_price,
				".$tblprefix."standard_rates.single_use_option,
				".$tblprefix."standard_rates.single_rate_price,
				".$tblprefix."standard_rates.rooms_for_sale,
				".$tblprefix."standard_rates.adv_rooms_for_sale,
				".$tblprefix."standard_rates.advance_use_option,
				".$tblprefix."standard_rates.advance_start_date,
				".$tblprefix."standard_rates.advance_end_date,
				".$tblprefix."standard_rates.advance_rate_price,
				".$tblprefix."standard_rates.single_adv_use_option,
				".$tblprefix."standard_rates.single_adv_rate_price
				FROM
				".$tblprefix."standard_rates
				Inner Join ".$tblprefix."rooms ON ".$tblprefix."rooms.id = ".$tblprefix."standard_rates.room_type_id
				Inner Join ".$tblprefix."properties ON ".$tblprefix."properties.id = ".$tblprefix."standard_rates.property_id
				Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id = ".$tblprefix."standard_rates.pm_id   	            WHERE ".$tblprefix."standard_rates.id=".$id." AND ".$tblprefix."properties.pm_type=0"; 
				
			
			
				
	/*$qry_limit = "SELECT 
           ".$tblprefix."property_manager.first_name, 
			".$tblprefix."property_manager.last_name, 
			".$tblprefix."properties.property_name, 
			".$tblprefix."rooms.room_type, 
			".$tblprefix."standard_rates1.advance_use_option,
			".$tblprefix."standard_rates1.single_use_option,
			".$tblprefix."standard_rates1.id, 
			".$tblprefix."standard_rates1.room_type_id, 
			".$tblprefix."standard_rates1.pm_id,
			".$tblprefix."standard_rates1.rooms_for_sale,
			".$tblprefix."standard_rates1.property_id,
			".$tblprefix."standard_rates1.single_adv_use_option,
			".$tblprefix."standard_date.standard_rate_price,
			".$tblprefix."single_date.single_rate_price,
			".$tblprefix."adv_single_date.single_adv_rate_price,
			".$tblprefix."adv_use_date.advance_rate_price 
			FROM ".$tblprefix."standard_rates1
			LEFT Join ".$tblprefix."standard_date ON ".$tblprefix."standard_date.standard_rate_id = ".$tblprefix."standard_rates1.id
			LEFT Join ".$tblprefix."single_date ON ".$tblprefix."single_date.standard_rate_id = ".$tblprefix."standard_rates1.id
			LEFT Join ".$tblprefix."adv_single_date ON ".$tblprefix."adv_single_date.standard_rate_id = ".$tblprefix."standard_rates1.id
			LEFT Join ".$tblprefix."adv_use_date ON ".$tblprefix."adv_use_date.standard_rate_id = ".$tblprefix."standard_rates1.id
			LEFT Join ".$tblprefix."rooms ON ".$tblprefix."rooms.id = ".$tblprefix."standard_rates1.room_type_id
  LEFT Join ".$tblprefix."properties ON ".$tblprefix."properties.id = ".$tblprefix."standard_rates1.property_id
  LEFT Join ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id = ".$tblprefix."standard_rates1.pm_id WHERE ".$tblprefix."standard_rates1.id=".$id." GROUP BY ".$tblprefix."standard_rates1.id";*/
	
               $rs_limit = $db->Execute($qry_limit);


//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
/*
$standard_start_date = "SELECT standard_date FROM ".$tblprefix."standard_date WHERE standard_rate_id=".$id." ORDER BY id ASC LIMIT 1";
$rs_standard_date = $db->Execute($standard_start_date);

$standard_end_date = "SELECT standard_date FROM ".$tblprefix."standard_date WHERE standard_rate_id=".$id." ORDER BY id DESC LIMIT 1";
$rs_standard_end_date = $db->Execute($standard_end_date);

$single_start_date ="SELECT single_date FROM ".$tblprefix."single_date WHERE standard_rate_id=".$id." ORDER BY id ASC LIMIT 1";
$rs_single_start = $db->Execute($single_start_date);

$single_end_date = "SELECT single_date FROM ".$tblprefix."single_date WHERE standard_rate_id=".$id." ORDER BY id DESC LIMIT 1";
$rs_single_end = $db->Execute($single_end_date);

$ad_s_date = "SELECT adv_use_date FROM ".$tblprefix."adv_use_date WHERE standard_rate_id=".$id." ORDER BY id ASC LIMIT 1";
$rs_adv_start = $db->Execute($ad_s_date);

$ad_e_date = "SELECT adv_use_date FROM ".$tblprefix."adv_use_date WHERE standard_rate_id=".$id." ORDER BY id DESC LIMIT 1";
$rs_adv_end = $db->Execute($ad_e_date);
//Room type dropdown
$ad_single_st_date = "SELECT adv_single_date FROM ".$tblprefix."adv_single_date WHERE standard_rate_id=".$id." ORDER BY id ASC LIMIT 1";
$rs_adv_single_start = $db->Execute($ad_single_st_date);

$ad_single_end_date = "SELECT adv_single_date FROM ".$tblprefix."adv_single_date WHERE standard_rate_id=".$id." ORDER BY id DESC LIMIT 1";
$rs_adv_single_end = $db->Execute($ad_single_st_date);
*/
if($_SESSION[SESSNAME]['pm_moduleid']==2){
$qry_prop = "SELECT * FROM ".$tblprefix."properties 
				WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
				AND ".$tblprefix."properties.pm_type=0 
				AND ".$tblprefix."properties.property_category=24";
} else {
$qry_prop = "SELECT * FROM ".$tblprefix."properties 
				WHERE ".$tblprefix."properties.pm_type=0 
				AND ".$tblprefix."properties.pm_id=".$pm_id." 
				AND ".$tblprefix."properties.property_category=24";
}

$rs_prop = $db->Execute($qry_prop);
$count_prop =  $rs_prop->RecordCount();
$totalprop = $count_prop;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Standard Rates Management &nbsp;[Podešavanje cijena]</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
  		<td>
		<?php
		 $errmsg=base64_decode($_GET['errmsg']);
	   	 echo  '<div class="errmsg"> '.$errmsg.'</div>';
		 ?>
		</td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	  <table cellpadding="1" cellspacing="1" border="0" class="txt" >

	  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
        <!--Property name against PM name-->
        <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_prop_name25('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name25.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
<?php
  while(!$rs_property_manag->EOF){
	if($rs_property_manag->fields['id']==$rs_limit->fields['pm_id'])
	{
	$sel= 'selected="selected"';
	}else{$sel='';}					
						?>
<option <?php echo $sel; ?> value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name']."&nbsp;".$rs_property_manag->fields['last_name'];  ?></option>
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
		<div id="property_name"> 
		<select name="property_name" id="property_name" class="fields" onchange="get_room_type2('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type2.php"?>')" >
		<option value="0">Izaberite objekat</option>
  <?php
  while(!$rs_prop->EOF){
	if($rs_prop->fields['id']==$rs_limit->fields['property_id']){
		$property_name_dd_selected_id = $rs_prop->fields['id'];
		$sel='selected="selected"';
	}else{
		$sel='';
	}
	?>
<option <?php echo $sel; ?> value="<?php echo $rs_prop->fields['id'];?>"><?php echo $rs_prop->fields['property_name'];  ?></option>
						<?php
						$rs_prop->MoveNext();
						}?>		
		</select>
				</div>
			  </td>
            </tr>
        
       
	   
	   
	       <tr>
          <td bgcolor="#3399FF"> Room/Property Type<br/>[Tip sobe/objekta] </td>
          <td>
	<?php 
	//Room type dropdown
    $qry_region = "SELECT * FROM ".$tblprefix."rooms WHERE property_id = " . $property_name_dd_selected_id;
	$rs_region = $db->Execute($qry_region);
	$count_region =  $rs_region->RecordCount();
	$totalRegions = $count_region;
	?>	<div id="room_type"> 
		  <select name="room_type" class="fields">
              <option value="<?php echo $rs_region->fields['id']; ?>"><?php echo $rs_region->fields['room_type']; ?></option>
			  <?php 
					while(!$rs_region->EOF){ 
						if($rs_region->fields['id']==$rs_limit->fields['room_type_id']){
							$sel = 'selected="selected"';
						}else{
							$sel='';
						}
						echo '<option '.$sel.' value="'.$rs_region->fields['id'].'">'.$rs_region->fields['room_type'].'</option>';
					$rs_region->MoveNext();
					}
				?>
            </select>         
		 </td>
        </tr>
	   
	   
	   
	   
	   
	    <!--Property name against PM name End HERE-->
        
        <tr>
          <td><h3>Standard Rate<br/>[Osnovna cijena]</h3></td>
        </tr>
        <tr  bgcolor="#CCCCCC">
          	<td><b>Start Range<br/>[Početni datum]</b> </td>
          	<td><b>End Range<br/>[Krajnji datum]</b> </td>
          	<td><b>Rate<br/>[Cijena]</b></td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.
          <br/>[Izaberite počentni i krajnji datum va&#382;enja cijene i unesite cijenu]
          <br/>
         <span style="color:#FF0000;"><strong>Warning:</strong> Replacing the date ranges will delete all the previous date ranges for this rate.</span>
         <br/>
         <span style="color:#FF0000;"><strong>Upozorenje:</strong>Mijenjanje perioda će izbrisati sve prethodno postavljene periode za ovu cijenu</span>
          
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
        <?php $standard_start_date = date("m/d/Y",strtotime($rs_limit1->fields['standard_start_date']))?>
          <td width="200"><input type="text" name="standard_start_date"  id="standard_start_date" value="<?php echo trim($standard_start_date);?>" />
              <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'standard_start_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>          </td>
          <td>
           <?php $standard_end_date = date("m/d/Y",strtotime($rs_limit1->fields['standard_end_date']))?>
          <input type="text" name="standard_end_date"  id="standard_end_date" value="<?php echo trim($standard_end_date); ?>" />
              <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'standard_end_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>          </td>
          <td><input type="text" name="standard_rate_price"  id="standard_rate_price" value="<?php echo $rs_limit1->fields['standard_rate_price']; ?>" /></td>
        </tr>
        
        <tr>
		<td bgcolor="#3399FF">Room For Sales <br/>[Raspolo&#382;ive sobe]</td>
		<td>
			 <select name="stndrd_rooms_for_sale" class="fields"   id="stndrd_rooms_for_sale">
			<?php for($i=1;$i<=25;$i++){ ?>
				<option <?php  if($i== $rs_limit1->fields['rooms_for_sale']){ echo 'selected="selected"';}?>> <?php  echo $i; ?></option>
			<?php }?>
				
			</select>
		</td>
		<td>&nbsp;</td>
		</tr>
        
        
        
        
        
        
        
        <tr>
					  <td colspan="3" ><h3>Single use rate<br/>[Cijena za jednu osobu]</h3></td>
					</tr>
        
        
        <tr>
			 <td bgcolor="#3399FF">Single User Option<br/>[Mogućost rezervacije za jednu osobu]</td>
			 <td>
             <input type="radio" name="single_use_option" id="single_use_option1" onClick="jQuery('#standard_single_use').show('slow');"  value="1" <?php  if(1== $rs_limit->fields['single_use_option']){ echo 'checked="checked"';}?>/>Da  &nbsp; &nbsp;
			 <input type="radio" onClick="jQuery('#standard_single_use').hide('slow');" name="single_use_option" id="single_use_option0"  value="0" <?php  if(0== $rs_limit->fields['single_use_option']){ echo 'checked="checked"';}?>/>Ne
			</td>
            <td>&nbsp;</td>
		</tr>
            
            
          
          
          
          <tr>
		<td colspan="2">	
			<div id="standard_single_use"  style="display:block;">
			   <table cellpadding="0" cellspacing="0" border="0" class="txt" >	 
					
					<tr  bgcolor="#CCCCCC">
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><b>Rate</b></td>
					</tr>
					<tr  bgcolor="#CCCCCC">
					  <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.
                      <br/>[Izaberite počentni i krajnji datum va&#382;enja cijene i unesite cijenu]
                        <br/>
					  <span style="color:#FF0000;"><strong>Warning:</strong>   Replacing the date ranges will delete all the previous date ranges for this rate.</span>
                      <br/>
                      <span style="color:#FF0000;"><strong>Upozorenje:</strong>Mijenjanje perioda će izbrisati sve prethodno postavljene periode za ovu cijenu</span>
                      </td>
					</tr>
					<tr>
					  <td width="200">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><input type="text" name="single_rate_price"  id="single_rate_price" value="<?php echo $rs_limit1->fields['single_rate_price']; ?>" /></td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					</tr>
			   </table>	
			</div>	
       </td>
	   </tr>
        
           
    </table>
	  	
		
		
	<table width="100%" border="0" cellspacing="1" cellpadding="2" class="txt">
 
       
	   <tr>
			 <td bgcolor="#3399FF">Room For Sales <br/>[Raspolo&#382;ive sobe]</td>
			 <td>
			 
			 <select name="stndrd_rooms_for_sale" class="fields"   id="stndrd_rooms_for_sale">
			<?php for($i=1;$i<=25;$i++){ ?>
				<option <?php  if($i== $rs_limit1->fields['rooms_for_sale']){ echo 'selected="selected"';}?>> <?php  echo $i; ?></option>
			<?php }?>
				
			</select></td>
			 
			 </tr>
		 <tr><td>&nbsp;</td></tr>
		<!--<tr>
			 <td bgcolor="#3399FF">Advance User Option<br/>[Napredne cijene]</td>
			 <td><select name="advance_use_option" class="fields"   id="advance_use_option">
				<option value="1" <?php  if(1== $rs_limit->fields['advance_use_option']){ echo 'selected="selected"';}?>>YES</option>
				<option value="0" <?php  if(0== $rs_limit->fields['advance_use_option']){ echo 'selected="selected"';}?>>NO</option>
			</select>
			</td>
			
			 </tr>
			 
			  <tr>
          <td ><h3>Advance use rate</h3></td>
        </tr>
        <tr  bgcolor="#CCCCCC">
          <td><b>Advance Range</b></td>
          <td><b>Advance Range</b></td>
          <td><b>Advance Rate</b></td>
        </tr>
        <tr  bgcolor="#CCCCCC">
          <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.</td>
        </tr>
			  
		<tr>
	
          <td width="200">
		  <input type="text" name="advance_start_date"  id="advance_start_date" 
		 
		  value=" <?php if(!empty($_SESSION['advance_start_date'])){?><?php echo $_SESSION['advance_start_date']; ?> 
		  <?php }else{ ?>
		  <?php echo $rs_limit1->fields['advance_start_date'];?>
		  <?php } ?>" />
              <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'advance_start_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>          
		  </td>
          <td><input type="text" name="advance_end_date"  id="advance_end_date" value="<?php if(!empty($_SESSION['advance_end_date'])){?><?php echo $_SESSION['advance_end_date']; ?> 
		  <?php }else{ ?>
		  <?php echo  $rs_limit1->fields['advance_end_date']; ?>
		  <?php } ?>" />
              <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'advance_end_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>          
			</td>
          <td><input type="text" name="advance_rate_price"  id="advance_rate_price" value="<?php echo $rs_limit1->fields['advance_rate_price']; ?>" />
		  </td>
        </tr>
 
 		  <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			
		<tr>
		 <td bgcolor="#3399FF">Room For Sales</td>
		 <td>
		 <select name="advnc_rooms_for_sale" class="fields"   id="advnc_rooms_for_sale">
			<?php for($i=1;$i<=25;$i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($rs_limit1->fields['adv_rooms_for_sale']==$i){?> selected="selected"<?php }?>> <?php  echo $i; ?></option>
			<?php }?>
		</select></td>
		 </tr>
			  
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
	
 
 
 
			 
			 
			  <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			 
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			 
			
			 <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>-->
		  </table>
			
			<!--
			 <table width="100%" border="0" cellspacing="1" cellpadding="2" class="txt">
             
             
             
             
             
 
             
             
             <tr>
			 <td bgcolor="#3399FF">Advance Single User Option</td>
			 <td><input type="radio" name="single_adv_use_option" id="single_adv_use_option1" onClick="jQuery('#advance_single_use').show('slow');"  value="1" <?php  if(1== $rs_limit->fields['single_adv_use_option']){ echo 'checked="checked"';}?>/>YES  &nbsp; &nbsp;
				<input type="radio" onClick="jQuery('#advance_single_use').hide('slow');" name="single_adv_use_option" id="single_adv_use_option0"  value="0" <?php  if(0== $rs_limit->fields['single_adv_use_option']){ echo 'checked="checked"';}?>/>NO
			</td>
		</tr>
        
        <tr>
		<td colspan="2">	
			<div id="advance_single_use"  style="display:block;">
			   <table cellpadding="0" cellspacing="0" border="0" class="txt" >	 
					<tr>
					  <td colspan="3" ><h3>Advance Single use rate</h3></td>
					</tr>
					<tr  bgcolor="#CCCCCC">
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><b>Rate</b></td>
					</tr>
					<tr  bgcolor="#CCCCCC">
					  <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.</td>
					</tr>
					<tr>
					  <td width="200">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><input type="text" name="single_adv_rate_price"  id="single_adv_rate_price" value="<?php echo $rs_limit1->fields['single_adv_rate_price']; ?>" /></td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
			   </table>	
			</div>	
       </td>
	   </tr>
             
              
             
   			 
			 <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
		<tr>
          <td>&nbsp;</td>
        </tr>
		
        
		
	<tr><td>&nbsp;</td><td><input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update rates" class="button" /></td></tr>
</table>
-->


<table cellpadding="2" cellspacing="2">
<tr><td>&nbsp;</td><td><input style="margin:5px; width:180px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update rates &nbsp; [A&#382;uriraj Cijena]" class="button" /></td></tr>
</table>


	  <input type="hidden" name="act" value="edit_rates1" />
			<input type="hidden" name="act2" value="edit_rates1" />
			<input type="hidden" name="request_page" value="rates_management1" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="mode" value="update">
			</form>
			</td>
	</tr>
</table>


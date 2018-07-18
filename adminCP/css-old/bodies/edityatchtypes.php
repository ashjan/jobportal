<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."yatchtypes WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);




$qry_manage = "SELECT * FROM ".$tblprefix."yatchagency";
$rs_property_manag = $db->Execute($qry_manage);



$qry_facility = "SELECT * FROM ".$tblprefix."property_facilities"; 
$rs_facility = $db->Execute($qry_facility);
$totalcountalfacility =  $rs_facility->RecordCount();

$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_property_manager = $db->Execute($qry_property_manag);

$qry_agency = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency WHERE pm_id=".$rs_limit->fields['pm_id'];
$rs_agency = $db->Execute($qry_agency);

$qry_yatch = "SELECT * FROM ".$tblprefix."yatch WHERE id=".$rs_limit->fields['yatch_name']; 
$rs_yatch = $db->Execute($qry_yatch);

$qry_splr = "SELECT * FROM ".$tblprefix."supplier WHERE id=".$rs_yatch->fields['supplier']; 
$rs_splr = $db->Execute($qry_splr);

$qry_yatchcat = "SELECT * FROM ".$tblprefix."yatch_category"; 
$rs_yatchcat = $db->Execute($qry_yatchcat);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Yatch Type Section</td>
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
		
		
		<tr>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">			</td></tr>
		
		
		
		<tr>
		<td class="txt1">Agency Name</td>
		<td>
			 <?php    $qry_content = "SELECT * FROM  ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
<select name="agency_id" class="fields" id="agency_id" onchange="">
<?php
if($count_add<=0){?>
<option value="0">No Agency Found</option>
<?php
}else{?>
<option value="0">Select Agency</option>	
	<?php while(!$rs_content->EOF)
	{
	?>
<option value="<?php echo $rs_content->fields['agn_id'];?>"><?php echo $rs_content->fields['agn_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    
?>
</select>
</td></tr>
		<?php
			}else{?>	
		
		<tr>
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
				 	<option value="0">Select Yatch Manager</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							if($rs_property_manag->fields['id']==$rs_limit->fields['pm_id']){
							   $is_manager_selected = 'selected="selected"';
							}else {
								$is_manager_selected = '';
							}
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php echo $is_manager_selected; ?>><?php echo $rs_property_manag->fields['first_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
							
				<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
						<select name="agency_id" class="fields" id="agency_id">
							<option value="0">First Select PM</option>
							<?php while(!$rs_agency->EOF){$is_manager_selected = '';
							if($rs_agency->fields['agn_id']==$rs_limit->fields['yatch_agency']){
							   $is_manager_selected = 'selected="selected"';
							}else {
								$is_manager_selected = '';
							}
                     ?>
		  			<option value="<?php echo $rs_agency->fields['agn_id'];?>" 
					<?php echo $is_manager_selected; ?>><?php echo $rs_agency->fields['agn_name'] ;?>
					</option>
	                <?php $rs_agency->MoveNext();
					} ?>			
						</select>
					</div>
					
					</td>
				</tr>
	<?php } ?>
    
    <tr>
	        <td>
  			Destination
		   	</td>
		
				<td>
				
				
				<input type="text" name="destination" class="fields" id="destination" value="<?php echo $rs_limit->fields['destination'];  ?>" />
					
				
				</td>
		</tr>
    	
		<tr>
	        <td>
  			Yatch Name
		   	</td>
		
				<td>
				
				
				<input type="text" name="yatch_name" class="fields" id="yatch_name" value="<?php echo $rs_limit->fields['yatch_name'];  ?>" />
					
				
				</td>
		</tr> 
        
        
        <!--This is the new fileds -->
        <tr>
		<td>
  			Number Yatch
		   	</td>
			<td>
			<input type="text" name="number_yachts" class="fields" id="number_yachts" value="<?php echo $rs_limit->fields['number_yachts'];  ?>" />
			</td>
        </tr>
        <!--Number yatch field is ended here-->
                         
              
			<tr>
		<td>
  			Yatch Category
		   	</td>
			<td>
			<select name="yatcat" id="yatcat" class="fields">
			<?php while(!$rs_yatchcat->EOF)
				{
                     ?>
		  			<option value="<?php echo $rs_yatchcat->fields['id'];?>"
					<?php
					if($rs_yatchcat->fields['id'] == $rs_limit->fields['yatch_cat'])
					{
						echo 'selected="selected"';
					}
					?>
					>
					<?php echo $rs_yatchcat->fields['yatch_category_name'] ;?>
					</option>
	                <?php $rs_yatchcat->MoveNext();
				} ?>	
			</select>
			</td>
        </tr>   	
				
   <tr>
				<td class="txt1">Built Year</td>
				<td>
				<input name="built_year" id="built_year" value="<?php echo $rs_limit->fields['built_year'];?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Length</td>
				<td>
				<input name="yatch_length" id="yatch_length" value="<?php echo $rs_limit->fields['yatch_length']?>" type="text" size="35"  maxlength="30" /> m(meter)
				</div>
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Beam</td>
				<td>
				<input name="yatch_beam" id="yatch_beam" value="<?php echo $rs_limit->fields['yatch_beam']?>" type="text" size="35"  maxlength="30" /> m(meter)
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch Draft</td>
				<td>
				<input name="yatch_draft" id="yatch_draft" value="<?php echo $rs_limit->fields['yatch_draft']?>" type="text" size="35"  maxlength="30" /> m(meter)
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Engine</td>
				<td>
				<input name="yatch_engine" id="yatch_engine" value="<?php echo $rs_limit->fields['yatch_engine']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Fuel Tank</td>
				<td>
				<input name="yatch_fuel_tank" id="yatch_fuel_tank" value="<?php echo $rs_limit->fields['yatch_fuel_tank']?>" type="text" size="35"  maxlength="30" /> L(Liter) 
				
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Cabins</td>
				<td>
				<input name="cabins" id="cabins" value="<?php echo $rs_limit->fields['cabins']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Yatch Water Tank</td>
				<td>
				<input name="water_tank" id="water_tank" value="<?php echo $rs_limit->fields['water_tank']?>" type="text" size="35"  maxlength="30" /> L(Liter) 
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Berthsk</td>
				<td>
				<input name="yathch_berths" id="yathch_berths" value="<?php echo $rs_limit->fields['yathch_berths']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Seats</td>
				<td>
				<input name="yatch_seats" id="yatch_seats" value="<?php echo $rs_limit->fields['yatch_seats']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch Additional Berth</td>
				<td>
				<input name="yatch_additional_berth" id="yatch_additional_berth" value="<?php echo $rs_limit->fields['yatch_additional_berth']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch wc</td>
				<td>
				<input name="yatch_wc" id="yatch_wc" value="<?php echo $rs_limit->fields['yatch_wc']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch Showers</td>
				<td>
				<input name="yatch_showers" id="yatch_showers" value="<?php echo $rs_limit->fields['yatch_showers']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>
        
        
        <tr>
				<td class="txt1">Yatch Picture</td>
				<td>
				<input name="yatch_picture" id="yatch_picture" value="" type="file" class="fields" />
				
				</td> 
		</tr>
        
        
        
		<tr><tr>
				<td class="txt1">Yatch Navigation Electronic</td>
				<td>
				<textarea name="yatch_navigation_electronic" id="yatch_navigation_electronic" style="width: 224px; height: 145px;"><?php echo $rs_limit->fields['yatch_navigation_electronic']?></textarea>
				
				</td> 
		</tr><tr>
				<td class="txt1">Sail And Deck</td>
				<td>
				<textarea name="sailanddeck" id="sailanddeck" style="width: 224px; height: 145px;" ><?php echo $rs_limit->fields['sailanddeck']?></textarea>
				
				</td> 
		</tr>
        <!--<tr>
				<td class="txt1">Yatch Week Day</td>
				<td>
				<input name="yatch_week_day" id="yatch_week_day" value="<?php //echo $rs_limit->fields['yatch_week_day']?>" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>-->
		<tr>
				<td class="txt1">Yatch Comfort</td>
				<td>
				<textarea name="yatch_comfort" style="width: 224px; height: 145px;" id="yatch_comfort"><?php echo $rs_limit->fields['yatch_comfort']?></textarea>
				
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Yatch Other</td>
				<td>
				<textarea name="yatch_other" style="width: 224px; height: 145px;" id="yatch_other"><?php echo $rs_limit->fields['yatch_other']?></textarea>
				
				</td> 
		</tr>
	        <td>&nbsp;
			</td>
					
        </tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Yatch" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="<?=$_GET['act']?>" />
			<input type="hidden" name="act2" value="yatchtypes" />
			<input type="hidden" name="request_page" value="yatchtypes_mangagemnet" />
			<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
			<input type="hidden" name="yatmodelid" id="yatmodelid" value="<?php echo $rs_limit->fields['yatch_name']?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


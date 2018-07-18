<?php
$id				=base64_decode($_GET['id']);
//$pm_id			=base64_decode($_GET['pm_id']);
//$property_id	=base64_decode($_GET['property_id']);

$qry_limit = "SELECT * FROM ".$tblprefix."bedding WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);


//List down all Rooms
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$qry_region = "SELECT * FROM ".$tblprefix."rooms WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'] ;
}else {
$qry_region = "SELECT * FROM ".$tblprefix."rooms" ;
}

$rs_region    = $db->Execute($qry_region);
$count_region = $rs_region->RecordCount();
$totalRegions = $count_region;


//List down all PMs
$qry_pm       = "SELECT ".$tblprefix."property_manager.*,
   				   	    ".$tblprefix."properties.property_name ,
				        ".$tblprefix."properties.pm_type ,
				        ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id 
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm    = $db->Execute($qry_pm);
$count_pm = $rs_pm->RecordCount();
$totalPm  = $count_pm;

//List down all Properties
 if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $qry_properties = "SELECT * FROM ".$tblprefix."properties 
						WHERE ".$tblprefix."properties.pm_id=".$_SESSION[SESSNAME]["pm_id"]."
				   		AND ".$tblprefix."properties.pm_type=1  
				   		AND ".$tblprefix."properties.property_category=24"; 	
 }else{
 $qry_properties = "SELECT * FROM ".$tblprefix."properties 
					WHERE ".$tblprefix."properties.pm_type=1 
					AND ".$tblprefix."properties.property_category=24"; 
			
 }
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;


?>
<script>
function ShowConversionResult(getid,resultid){
widthincm=$("#"+getid).val();
widthinIN=widthincm *0.4  ;
widthinIN = Math.round(widthinIN,2);
widthinIN = widthinIN + 'in';
$("#"+resultid).html(widthinIN);
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Bedding Management Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="50%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="3" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
           <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
    <tr>
	        <td>
  			Property Manager
		   	</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_edit_bed_prop_nam('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_edit_bed_prop_nam.php"?>')">
				<option value="0">Izaberite objekat</option>
				<?php 
   	while(!$rs_pm->EOF){?>
	<option value="<?php echo $rs_pm->fields['id'];?>" <?php if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){echo 'selected="selected"';} ?>><?php echo $rs_pm->fields['first_name'].'  '.$rs_pm->fields['last_name']; ?></option>
	<?php $rs_pm->MoveNext();
	}?>					
	</select>					

			</td>
        </tr>
        <?php }?>
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		   <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
				<div id="property_id"> 	
		<select name="property_id" class="fields"   id="property_id" onchange="get_room_type('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type6.php"?>')">
			<option value="0">Izaberite objekat</option>
		<?php while(!$rs_properties->EOF){?>
       <option value="<?php echo $rs_properties->fields['id']; ?>" 
       <?php if($rs_properties->fields['id']==$rs_limit->fields['property_id']){ echo 'selected="selected"';}?>>
	   <?php echo  $rs_properties->fields['property_name']; ?></option>
	   <?php $rs_properties->MoveNext();
	   }  ?>	
		</select> 
		</div>	
			</td>
        </tr>
<?php	}else{ ?>  
		  <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
				<div id="property_id"> 	
		<select name="property_id" class="fields"   id="property_id" onchange="get_room_type('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type.php"?>')">
			<option value="0">Izaberite objekat</option>
		<?php while(!$rs_properties->EOF){?>
       <option value="<?php echo $rs_properties->fields['id']; ?>" 
       <?php if($rs_properties->fields['id']==$rs_limit->fields['property_id']){ echo 'selected="selected"';}?>>
	   <?php echo  $rs_properties->fields['property_name']; ?></option>
	   <?php $rs_properties->MoveNext();
	   }  ?>	
		</select> 
		</div>	
		</td>
        </tr>
        <?php }?>
		   <tr>
		    <td>
  			Room Type<br/>[Vrsta sobe]
		   	</td>
			<td>
			<div id="room_id">
			<select name="room_id" class="fields"   id="room_id">
				<option value="0">Izaberite sobu Tip</option>
				<?php 
			     	while(!$rs_region->EOF){
					echo '<option value="'.$rs_region->fields['id'].'">'.$rs_region->fields['room_type'].'</option>';?>
					<option value="<?php echo $rs_region->fields['id']; ?>" <?php if($rs_region->fields['id']==$rs_limit->fields['room_id']){ echo 'selected="selected"';}?>>
					<?php echo $rs_region->fields['room_type']; ?></option>
					<?php
					$rs_region->MoveNext();
					}
				?>					
			</select>		
			</div>			
			</td>
        </tr>
        
		<tr>
		<td>&nbsp;</td><td>&nbsp;<br/><br/><br/></td>
		</tr>        
                         
<tr><td>Bedding Type Name<br/>[Vrsta kreveta]<br/><br/>
		   (Ruski)<br/><br/>
		   (Crnogorski)
	 </td>
		<td>
	<input type="text" name="bedding_type_name" class="fields" id="bedding_type_name" value="<?php echo $rs_limit->fields['bedding_type_name']; ?>"/>
	<br/><br/>
	<?php 
		                //For Russuan Language
						$language_qry = "SELECT ".$tblprefix."language_contents.id AS rus_lan_id,
				        	".$tblprefix."language_contents.translated_text 
						 FROM ".$tblprefix."language_contents  
						 WHERE ".$tblprefix."language_contents.fld_type ='bedding_type_name' AND ".$tblprefix."language_contents.page_id=".$id." AND ".$tblprefix."language_contents.field_name='bedding_type_name_rus'"; 
						$rs_language     = $db->Execute($language_qry);
						$count_language  = $rs_language->RecordCount();
						$total_languages = $count_language;
						  if($count_language>0){
						  $rs_language->MoveFirst();
						  while(!$rs_language->EOF){
						     if($rs_language->fields['translated_text']!="" and $rs_language->fields['translated_text']!=NULL){
							 $bedding_type_name_rus = $rs_language->fields['translated_text'];
							 $rus_lan_id    = $rs_language->fields['rus_lan_id'];
							 }
						     $rs_language->MoveNext();
						    }
						  }
		?>			  
   <input type="text"   name="bedding_type_name_rus" class="fields" id="bedding_type_name_rus" value="<?php echo $bedding_type_name_rus; ?>" />
   <br/><br/>
   <input type="hidden" name="rus_lan_id" id="rus_lan_id"     value="<?php echo $rus_lan_id; ?>"   />
		    <?php 
			            //For Montenegrin Language           
						$language_qry = "SELECT ".$tblprefix."language_contents.id AS mon_lan_id,
				        	".$tblprefix."language_contents.translated_text 
						 FROM ".$tblprefix."language_contents  
						 WHERE ".$tblprefix."language_contents.fld_type ='bedding_type_name' AND ".$tblprefix."language_contents.page_id=".$id." AND ".$tblprefix."language_contents.field_name='bedding_type_name_mon'"; 
						$rs_language     = $db->Execute($language_qry);
						$count_language  = $rs_language->RecordCount();
						$total_languages = $count_language;
						  if($count_language>0){
						  $rs_language->MoveFirst();
						  while(!$rs_language->EOF){
						     if($rs_language->fields['translated_text']!="" and $rs_language->fields['translated_text']!=NULL){
							 $bedding_type_name_mon = $rs_language->fields['translated_text'];
							 $mon_lan_id = $rs_language->fields['mon_lan_id'];
							 }
						     $rs_language->MoveNext();
						    }
						  }
			   ?>			
		   <input type="text"   name="bedding_type_name_mon" id="bedding_type_name_mon" value="<?php echo $bedding_type_name_mon; ?>" class="fields" /><br/><br/>
		   <input type="hidden" name="mon_lan_id"    id="mon_lan_id"    value="<?php echo $mon_lan_id; ?>" />
		   </td>
		   <td></td>
		   </tr>
        
		<tr>
		<td>&nbsp;</td><td>&nbsp;<br/><br/></td>
        </tr>		   
		
		   
		   <tr><td>Number of beds<br/>[Broj le&#382;ajeva]</td>
		   <td><input type="text" name="number_beds" class="fields" id="number_beds" value="<?php echo $rs_limit->fields['number_beds']; ?>" /></td>
		   <td></td>
		   </tr>
		   
		   <tr><td>Number of extra beds<br/>[Dodatni kreveti]</td>
		   <td><input type="text" name="extra_beds" class="fields" id="extra_beds" value="<?php echo $rs_limit->fields['extra_beds']; ?>" /></td>
		   <td></td>
		   </tr>
		   
		   
		   <tr><td>Dimensions Width<br/>[Širina kreveta]</td>
		   <td width="250px;"><input type="text" name="dimensions_width" class="smallfields" id="dimensions_width" value="<?php echo $rs_limit->fields['dimensions_width']; ?>" onblur="ShowConversionResult('dimensions_width','conversion_result_width');" />cm
		   </td>
		   <td>
		   <div id="conversion_result_width" style="width:30px; float:right; text-align:left; border:1px solid #000000;">
		   <?php echo $rs_limit->fields['dimensions_width']*0.4."&nbsp;in";  ?>
		   </div>
		   </td>
		   </tr>
		   
		   <tr><td>Dimensions Length<br/>[Du&#382;ina kreveta]</td>
		   <td width="250px;"><input type="text" name="dimensions_length" class="smallfields" id="dimensions_length" value="<?php echo $rs_limit->fields['dimensions_length']; ?>" onblur="ShowConversionResult('dimensions_length','conversion_result_length');"/>cm</td>
		   <td>
		   <div id="conversion_result_length" style="width:30px; float:right; text-align:left; border:1px solid #000000; ">
		   <?php echo $rs_limit->fields['dimensions_length']*0.4."&nbsp;in";  ?>
		   </div>
		   </td>
		   </tr>
		    
			  
			  
			<tr><td>	
			<input style="margin:5px; width:185px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Bedding &nbsp;[A&#382;uriraj krevet]" class="button"/>
		</td></tr>
		</table>
			<input type="hidden" name="act"             value="manage_bedding"     />
			<input type="hidden" name="act2"            value="manage_bedding"     />
			<input type="hidden" name="request_page"    value="bedding_management" />
			<input type="hidden" name="id"              value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode"            value="update"             />
		</form>
		</td>
	</tr>
</table>


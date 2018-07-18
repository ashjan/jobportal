<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."rooms WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);



//List down all PMs
$qry_pm = "SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
								GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;




if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE pm_id='.$_SESSION[SESSNAME]['pm_id'].' 
								 AND pm_type=0
							 	AND '.$tblprefix.'properties.property_category=24';
	}else{
		$module_pm_where = " WHERE pm_type=0
							AND ".$tblprefix."properties.property_category=24";
	}
$qry_properties = "SELECT * FROM ".$tblprefix."properties ".$module_pm_where ;
$rs_properties  = $db->Execute($qry_properties);
$count_prop     =  $rs_properties->RecordCount();
$totalprop      = $count_prop;

?>
<form action="admin.php" method="POST" enctype="multipart/form-data" id="managemenufrm" name="managemenufrm" >
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Room Management Section </td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
	<td>
	

	<div class="add_subscriber" style="display:block;">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
   <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
      <tr>
	        <td>
  			Select Property Manager::
		   	</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_prop_name('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_1.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
   	while(!$rs_pm->EOF){?>
	<option value="<?php echo $rs_pm->fields['id'];?>" <?php if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){echo 'selected="selected"';} ?>><?php echo $rs_pm->fields['first_name'].'  '.$rs_pm->fields['last_name']; ?></option>
	<?php $rs_pm->MoveNext();
	}?>					
	</select>							

			</td>
        </tr>
		 <?php }?> 
		 <tr>
	        <td>
  			Property Name<br/>[Naziv nekretnine]
		   	</td>
			<td>
		<div id="property_id"> 	
		<select name="property_id" class="fields"   id="property_id">
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
		  
		  
  
  
  
  
           <tr><td>&nbsp;&nbsp;</td>
		   <td><br/><br/></td>
		   </tr>
  
  
  
  
           <tr><td>Room Type<br/>[Vrsta sobe]</td>
		   <td>
		   <input type="text" name="room_type" class="fields" id="room_type" value="<?php echo $rs_limit->fields['room_type']; ?>"/><br/><br/>
		   
		   <?php 
		                //For Russuan Language
						$room_type_rus = "";
						$language_qry = "SELECT ".$tblprefix."language_contents.id AS rus_lan_id,
				        	".$tblprefix."language_contents.translated_text 
						 FROM ".$tblprefix."language_contents  
						 WHERE ".$tblprefix."language_contents.fld_type ='room_type' AND ".$tblprefix."language_contents.page_id=".$id." AND ".$tblprefix."language_contents.field_name='room_type_rus'"; 
						$rs_language     = $db->Execute($language_qry);
						$count_language  = $rs_language->RecordCount();
						$total_languages = $count_language;
						  if($count_language>0){
						  $rs_language->MoveFirst();
						  while(!$rs_language->EOF){
						     if($rs_language->fields['translated_text']!="" and $rs_language->fields['translated_text']!=NULL){
							 $room_type_rus = $rs_language->fields['translated_text'];
							 $rus_lan_id = $rs_language->fields['rus_lan_id'];
							 }
						     $rs_language->MoveNext();
						    }
						  }
			?>			  
		   <input type="text" name="room_type_rus" class="fields" id="room_type_rus" value="<?php echo $room_type_rus; ?>"/><br/><br/>
		   <input type="hidden" name="rus_lan_id" id="rus_lan_id"     value="<?php echo $rus_lan_id; ?>"   />
		    <?php 
			            //For Montenegrin Language           
						$room_type_mon = "";
						$language_qry = "SELECT ".$tblprefix."language_contents.id AS mon_lan_id,
				        	".$tblprefix."language_contents.translated_text 
						 FROM ".$tblprefix."language_contents  
						 WHERE ".$tblprefix."language_contents.fld_type ='room_type' AND ".$tblprefix."language_contents.page_id=".$id." AND ".$tblprefix."language_contents.field_name='room_type_mon'"; 
						$rs_language     = $db->Execute($language_qry);
						$count_language  = $rs_language->RecordCount();
						$total_languages = $count_language;
						  if($count_language>0){
						  $rs_language->MoveFirst();
						  while(!$rs_language->EOF){
						     if($rs_language->fields['translated_text']!="" and $rs_language->fields['translated_text']!=NULL){
							 $room_type_mon = $rs_language->fields['translated_text'];
							 $mon_lan_id = $rs_language->fields['mon_lan_id'];
							 }
						     $rs_language->MoveNext();
						    }
						  }
			   ?>			
		   <input type="text"   name="room_type_mon" id="room_type_mon" value="<?php echo $room_type_mon; ?>" class="fields" /><br/><br/>
		   <input type="hidden" name="mon_lan_id"    id="mon_lan_id"    value="<?php echo $mon_lan_id; ?>" />
		   
		   
		   </td>
		   </tr>
		   
		   <tr><td>&nbsp;&nbsp;</td>
		   <td><br/><br/></td>
		   </tr>
		   
		   <tr> <td>Number Resources Available<br/>[Broj raspolo&#382;ivih soba]</td>
				<td> 
				<input type="text" name="number_resources_available" value="<?php echo $rs_limit->fields['number_resources_available'];?>">
				</td>
				</tr>
			 <tr><td>
			 <?php $opt=$rs_limit->fields['max_persons_per_resource']; ?>
			  Max Persons Per Resources<br/>[Maksimalan broj gostiju po sobi]</td>
			  <td>
			    <select class="fields" name="max_persons_per_resource" id="<?php echo $rs_limit->fields['id']; ?>">
				<?php for($i=1; $i<=10; $i++){
				echo'<option value="'.$i.'"';
				if($opt==$i){
				echo 'selected="selected"';
				}
				 echo '>'. $i. ' Persons Per Resource </option>'."\n";
				}
				?>
				</select></td></tr>
		   
				
		
				
				<tr><td colspan="2">
			 	
			 </td>
			 </tr>
			 <tr><td>Meter Square<br/>[Dimenzije sobe]</td>
			  <td><input type="text" name="meter_square" class="smallfields" id="meter_square" value="<?php echo $rs_limit->fields['meter_square']; ?>" /></td></tr>
	           </table>
				</div>
			 </td>
			 </tr>
		     
			 
			 
			 <tr>
             <td>
             <a href="javascript:" style="margin:5px; width:112px; float:none; text-align:center;" name="submit" id="submit" class="button" onclick="edit_room_manag()">Update Room</a>	
			<!--<input style="margin:5px; width:112px; float:none; text-align:center;" type="button" name="submit" id="submit" value="Update Room" class="button" onclick="edit_room1_manag()" />-->
			</td>
            </tr>
		
		
		
		
		
		
		</table>
		        </div> 
			<input type="hidden" name="act" value="edit_room_management1" />
			<input type="hidden" name="act2" value="edit_room_management1" />
			<input type="hidden" name="request_page" value="manage_room_management1" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		
		</td>
	</tr>
</table>
   </div>
  
  </td>
  </tr>
  </table>
</form>
<script type="text/javascript">

function edit_room_manag(){ 
    var validation_flag= true;
	with (document.managemenufrm){ 		
		
		if(pm_id.value=="0"){
			alert("Please Enter Property Manager");
			pm_id.focus();
			validation_flag= false;
		}
		
		if(property_id.value=="0"){
			alert("Please Enter Property Name");
			property_id.focus();
			validation_flag= false;
		}	
		
		if(room_type.value==""){
			alert("Please Enter Room Type");
			room_type.focus();
			validation_flag= false;
			
		}
		
		if(number_resources_available.value==""){
			alert("Please Enter Number Resources");
			number_resources_available.focus();
			validation_flag= false;
			
		}		
		
		if(meter_square.value==""){
			alert("Please Enter Square Meter value");
			meter_square.focus();
			validation_flag= false;
		}		
	}
		if(validation_flag==true){
			   document.getElementById('managemenufrm').submit();
			}
		return validation_flag;
}// END
</script>
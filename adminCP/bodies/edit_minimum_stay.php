<?php
$id				=base64_decode($_GET['id']);

$qry_limit = "SELECT * FROM ".$tblprefix."property_minimum_stay WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);
$property_id=$rs_limit->fields['property_id'];
$pm_id=$rs_limit->fields['pm_id'];

//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT
						".$tblprefix."rooms.id,
						".$tblprefix."rooms.room_type
						FROM 
						".$tblprefix."rooms WHERE ".$tblprefix."rooms.property_id=".$property_id;

$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();


//List down all PMs
$qry_pm = "SELECT ".$tblprefix."users.*,
   				   	   ".$tblprefix."properties.property_name ,
				       ".$tblprefix."properties.pm_type ,
				       ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;

//List down all Properties
 if($_SESSION[SESSNAME]['pm_moduleid']==2){
$qry_properties = "SELECT * FROM ".$tblprefix."properties WHERE ".$tblprefix."properties.pm_id=".$_SESSION[SESSNAME]["pm_id"]."
				   AND ".$tblprefix."properties.pm_type=1  
				   AND ".$tblprefix."properties.property_category=24"; 	
 }else {
//$qry_properties = "SELECT * FROM ".$tblprefix."properties WHERE ".$tblprefix."properties.id=".$property_id;
$qry_properties =  "SELECT * FROM ".$tblprefix."properties 
					WHERE ".$tblprefix."properties.pm_type=1 
					AND ".$tblprefix."properties.property_category=24 AND ".$tblprefix."properties.pm_id=".$pm_id;
 }

$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt" >
 	<tr>
  		<td id="heading">Edit Minimum Stay Section</td>
 	</tr>
    <tr>
        <td colspan="3" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
        </td>
    </tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		 <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?> 
		<tr>
	        <td>
  			Property Manager
		   	</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_prop_nam_edit('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_nam_edit.php"?>')">
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
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
        <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
		<div id="property_id"> 	
		<select  class="fields"   name="property_id" onchange="get_room_type2('room_ids', this.value, '<?php echo MYSURL."ajaxresponse/get_Room_type7.php"?>')">
			<option value="0">Izaberte objekat</option>
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
        <?php } else {?>
		 <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
		<div id="property_id"> 	
		
		
		<select name="property_id" class="fields">
			<option value="0">Izaberte objekat</option>
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
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		  <tr>
             <td>Room Type<br/>[Tip sobe]</td>
              <td>
			  
			  <div id="room_ids" >
			    <select name="room_id" id="room_id" class="fields">
					<option value="0">All room types </option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
							<option value="<?php echo $rs_property_manag->fields['id'];?>"
							<?php
							if($rs_property_manag->fields['id'] == $rs_limit->fields['room_id']){
								echo 'selected="selected"';
							}
							?>><?php echo $rs_property_manag->fields['room_type'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			</div>	
			  </td>
            </tr>
		  <?php }else {?>
		  <tr>
             <td>Room Type<br/>[Tip sobe]</td>
              <td>
			  
			  <div id="room_id" >
			    <select name="room_id" id="room_id" class="fields">
					<option value="0">Select Room Type</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
							<option value="<?php echo $rs_property_manag->fields['id'];?>"
							<?php
							if($rs_property_manag->fields['id'] == $rs_limit->fields['room_id']){
								echo 'selected="selected"';
							}
							?>><?php echo $rs_property_manag->fields['room_type'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			</div>	
			  </td>
            </tr>
            <?php }?>
			
            <tr>
			  <td> Rate Type<br/>[Vrsta cijene] </td>
              <td>
			    <select name="rate_type" id="rate_type" class="fields">
					<option 
					<?php
					if($rs_limit->fields['rate_type'] == '1'){
						echo 'selected="selected"';
					}
					?>
					value="1">Osnovna cijena</option>
				 	<!--<option value="2"
					<?php
					//if($rs_limit->fields['rate_type'] == '2'){
						//echo 'selected="selected"';
					//}
					?>
					>Advance Rates</option>
                    <option value="3"
					<?php
					//if($rs_limit->fields['rate_type'] == '3'){
						//echo 'selected="selected"';
					//}
					?>
					>All Rates</option>-->
				</select>
			  </td>
            </tr>
		
		
			
			<tr>
              <td> Nights Minimum Stay<br/>[Minimalan broj noćenja]  </td>
              <td><select name="night_stay" id="night_stay" class="fields">
					<option value="">Izaberite minimalan broj noćenja</option>
					<?php
						for($i=1; $i<=40; $i++){
							?>
							<option 
							<?php
							if($i==$rs_limit->fields['night_stay']){
								echo 'selected="selected"';
							}?> value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php
						}
					?>
				</select>   
			  </td>
            </tr>
			
            <tr>
              <td>&nbsp;</td>
              <td><input style="margin:2px; width:142px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update minimum stay" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_minimu_stay" />
          <input type="hidden" name="request_page" value="minimum_stay_management" />
          <input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
		  <input type="hidden" name="mode" value="update">
        </form>
			</td>
	    </tr>
</table>


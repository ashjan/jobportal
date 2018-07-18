<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."rooms WHERE id=".$id; 
$rs_limit = $db->Execute($qry_limit);



$qry_property_manag = "SELECT
                    ".$tblprefix."users.id,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name 
					FROM
					".$tblprefix."users"; 
$rs_category = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_category->RecordCount();
$qrypname = "SELECT
                    ".$tblprefix."properties.property_name,
					".$tblprefix."properties.id 
					FROM
					".$tblprefix."properties where ".$tblprefix."properties.id='".$rs_limit->fields['property_id']."'"; 
$rs_pname = $db->Execute($qrypname);

$qry_room = "SELECT * FROM ".$tblprefix."rooms" ;
$rs_room = $db->Execute($qry_room);
$count_add =  $rs_room->RecordCount();
$totalRows = $count_add;
if($_SESSION[SESSNAME]['pm_moduleid']==2){
$qry_prop = "SELECT * FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
} else {
$qry_prop = "SELECT * FROM ".$tblprefix."properties" ;	
}

$rs_prop = $db->Execute($qry_prop);
$count_prop =  $rs_prop->RecordCount();
$totalprop = $count_prop;

?>
<script type="text/javascript">

function edit_discount_manag(){ 

   var validation_flag= true;

	with (document.managecontentfrm){ 		
		
		if(wise_price_yes.checked==true){
			if(discount_percentage.value==""){
				alert("Please Enter Early booking Discount Percentage");
				discount_percentage.focus();
				validation_flag= false;			
			}
		}
	
		
		if(lmin_lastminuteoffer_yes.checked==true){
			if(lastminute_discount_rate.value==""){
				alert("Please Enter Last Minute Offer Discount Percentage");
				lastminute_discount_rate.focus();
				validation_flag= false;			
			}	
		}	
		
		if(long_stay_yes.checked==true){				
			if(threshold_last_minute1.value==""){
				alert("Please Enter Long Stay Threshold");
				threshold_last_minute1.focus();
				validation_flag= false;			
			}			
		
			if(lmin_discount_percentage1.value==""){
				alert("Please Enter Long Stay Discount Percentage");
				lmin_discount_percentage1.focus();
				validation_flag= false;			
			}			
		}		
			
	}
		if(validation_flag==true){
			document.getElementById('managecontentfrm').submit();
			}
		return validation_flag;
}// END
</script>
<form action="admin.php" method="post" enctype="multipart/form-data" name="managecontentfrm" id="managecontentfrm">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Discount Management Section</td>
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
				
				
				
				<tr>
						<td>Property Manager </td>
						<td>
						<!-- <?php
						//if(!empty($_SESSION['pm_id'])){ ?> 
						<input readonly="value" type="text" name="pm_id" id="pm_id" value="
						<?php //$qry_pm = "SELECT first_name,last_name FROM ".$tblprefix."users WHERE id=".$_SESSION['pm_id'];
 							  //$rs_pm = $db->Execute($qry_pm);
 						?>
						 <?php //echo $_SESSION['id']; ?><?php //echo $rs_pm->fields['first_name'];  echo $rs_pm->fields['last_name'];?>
						
						<?php //echo $_SESSION['pm_id']; ?>" />
						<?php //}else{ ?> -->
						
						<input readonly="value" type="text" name="pm_id1" id="pm_id1" 
						<?php $qry_pm = "SELECT first_name,last_name FROM ".$tblprefix."users WHERE id=".$rs_limit->fields['pm_id']; 
 							  $rs_pm = $db->Execute($qry_pm);
 						?>
						
						value="<?php echo $rs_pm->fields['first_name'];?><?php echo '&nbsp;'; ?> <?php echo $rs_pm->fields['last_name']; ?>"/>
						
						<?php //} ?>
						<input type="hidden" type="text" name="pm_id" id="pm_id" value="<?php echo $rs_limit->fields['pm_id']; ?>" />
						
					</td>
					</tr> 
					
				<tr>
						<td>Property Name</td>
						<td>
		<input readonly="value" type="text" name="property_name1" id="property_name1"<?php  $qry_property = "SELECT property_name FROM ".$tblprefix."properties WHERE id=".$rs_limit->fields['property_id']; $rs_property = $db->Execute($qry_property);?> value="<?php echo $rs_property->fields['property_name']; ?>" />
			<input type="hidden" type="text" name="property_name" id="property_name" value="<?php echo $rs_limit->fields['property_id']; ?>" />
						
					</td>
					</tr> 
					
				<tr>
						<td>Izaberite sobu</td>
						<td>
						<input readonly="value" type="text" name="room_type1" room_type="room_type1" 
						<?php $qry_nroom = "SELECT room_type FROM ".$tblprefix."rooms WHERE id=".$rs_limit->fields['id']; 
 							  $rs_nroom = $db->Execute($qry_nroom);
 						?> value="<?php echo $rs_nroom->fields['room_type'];?>" />
						
						<input type="hidden" type="text" name="room_type" id="room_type" value="<?php echo $rs_limit->fields['id']; ?>" />
					</td>
					</tr> 
				
				
				<!--<?php //if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php //echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php //} else {?>
<tr>
				<td class="txt2">Select Property Manager:</td>
					<td>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name3('property_name', this.value, '<?php //echo MYSURL."ajaxresponse/get_prop_name3.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					//$rs_category->MoveFirst();
					//while(!$rs_category->EOF){
					?>  <option value="<?php //echo $rs_category->fields['id'];?>"
						<?php
						//if($rs_category->fields['id'] == $rs_limit->fields['pm_id']){echo 'selected="selected"';}
						?>>
						<?php //echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?>
						</option>
						<?php
						//$rs_category->MoveNext();
					//}
					?>			
					</select>					
					</td>
				</tr>
				<?php //}?>
			<?php //if($_SESSION[SESSNAME]['pm_moduleid']==2){?>	
				<tr>
             <td>Property Name</td>
              <td>
		<div id="property_name">
		<select name="property_name" id="property_name" class="fields" onchange="get_room_type2('room_type', this.value, '<?php //echo MYSURL."ajaxresponse/get_room_type2.php"?>')" >
		<option value="0">Select Property</option>
  <?php
  /*$rs_prop->MoveFirst();
  while(!$rs_prop->EOF){
	if($rs_prop->fields['id']==$rs_limit->fields['property_id']){
		$property_name_dd_selected_id = $rs_prop->fields['id'];
		$sel='selected="selected"';
		
	}else{
		$sel='';
	}
	*/
	?>
<option <?php //echo $sel; ?> value="<?php //echo $rs_prop->fields['id'];?>"><?php //echo $rs_prop->fields['property_name'];  ?></option>
						<?php
						//$rs_prop->MoveNext();
						//}?>		
		</select>
				</div>
			  </td>
            </tr>
            <?php //} else {?>
		<tr>
             <td class="txt2">Property Name</td>
              <td>
  <div id="property_name"> 
	<select name="property_name" id="property_name"  class="dropfields" onchange="get_room_type('room_type', this.value, '<?php //echo MYSURL."ajaxresponse/get_room_type10.php"?>')" />
   	    <option value="<?php //echo $rs_room->fields['id'];?>"><?php //echo $rs_pname->fields['property_name'];?></option>	
		<option value="<?php //echo $rs_room->fields['id'];?>"><?php //echo $rs_room->fields['property_name'];?></option>
	</select>
  </div>
			  </td>
       </tr>
	   <?php //}?>
	  <?php //if($_SESSION[SESSNAME]['pm_moduleid']==2){?>	
	   <tr>
          <td > Room/Property Type </td>
          <td >
		 
	<?php 
	
	//Room type dropdown
  // $qry_region = "SELECT * FROM ".$tblprefix."rooms WHERE property_id = " . $property_name_dd_selected_id;

	/*$rs_region = $db->Execute($qry_region);
	$count_region =  $rs_region->RecordCount();
	$totalRegions = $count_region;*/
	?>	<div id="room_type"> 
		  <select name="room_type" class="fields">
              <option value="<?php //echo $rs_region->fields['id']; ?>"><?php //echo $rs_region->fields['room_type']; ?></option>
			  <?php 
					/*while(!$rs_region->EOF){ 
						if($rs_region->fields['id']==$rs_limit->fields['room_type_id']){
							$sel = 'selected="selected"';
						}else{
							$sel='';
						}
						echo '<option '.$sel.' value="'.$rs_region->fields['id'].'">'.$rs_region->fields['room_type'].'</option>';
					$rs_region->MoveNext();
					}*/
				?>
            </select>         
		 </td>
        </tr> 
	
	<?php //}else {?>
	<tr>
             <td class="txt2"> Room Name</td>
              <td>
  <div id="room_type">
    <select name="room_type" id="room_type" class="fields" />
	 <option value="<?php //echo $rs_limit->fields['room_type'];?>"><?php //echo $rs_limit->fields['room_type'].""?></option>
	 <option value="<?php //echo $rs_rooms->fields['id'];?>"><?php //echo $rs_pname->fields['rs_room'];?></option>
	</select>
  </div>
			  </td>
            </tr>  
	  <?php //}?> -->		
				

	         <tr>
				<td><h3>Early booking<br/>[Rana rezervacija]</h3></td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="early_booking" id="wise_price_yes" 
				<?php 
				if($rs_limit->fields['early_booking']=='1')
				{
					echo 'checked="checked"';
				}
				?>
				value="1" onClick="jQuery('#wise_price_parameters').show('slow');" ><span> Da</span>
				<input type="radio" name="early_booking"  id="wise_price_no" value="0" 
				<?php 
				if($rs_limit->fields['early_booking']=='0')
				{
					echo 'checked="checked"';
				}
				?>
				onClick="jQuery('#wise_price_parameters').hide('slow');" ><span> Ne</span>
				</div>
				</td>
			 </tr>
		
		<tr>
				<td colspan="2">
				<div id="wise_price_parameters">
				<table cellpadding="1" cellspacing="1" border="0" >	
				<tr>
				<td class="txt1">Threshold<br/>[Uslov]</td>
			<?php 
			if($rs_limit->fields['long_stay']==0){
			?>
			<script language="javascript">
			jQuery('#lastmindiv2').hide('slow');
			</script>
			<?php }else{ ?>
			<script language="javascript">
			jQuery('#lastmindiv2').show('slow');
			</script>
			<?php  } ?>
				<td><?php
			if($rs_limit->fields['lmin_lastminuteoffer']==0){
			?>
			<script language="javascript">
			jQuery('#lastmindiv').hide('slow');
			</script>
			<?php }else{ ?>
			<script language="javascript">
			jQuery('#lastmindiv').show('slow');
			</script>
			<?php  } ?>
			<?php
			if($rs_limit->fields['early_booking']==0){
			?>
			<script language="javascript">
			jQuery('#wise_price_parameters').hide('slow');
			</script>
			<?php }else{ ?>
			<script language="javascript">
			jQuery('#wise_price_parameters').show('slow');
			</script>
			<?php  }
			if(!empty($_SESSION['threshold'])){
			?> 
			<input type="text" name="threshold" class="fields" id="threshold" value="<?php echo $_SESSION['threshold'] ; ?>" />
			<select style="width:120px;" name="threshold" id="threshold" >
				              <option value="45" >45 Day</option>
							  <?php for($days=46;$days<=90; $days++){  ?>
							  <option value="<?php echo $days; if($_SESSION['threshold']==$days){ 
							  echo 'selected="selected"';
							 } ?>"><?php echo $days;?>Dana</option>
							  <?php } ?>
				              </select>
			
			<?php }else{  ?>
			   <select style="width:120px;" name="threshold" id="threshold" >
				              <option value="45" >45 Dana</option>
							  <?php for($days=46;$days<=90; $days++){ ?>
							  <option value="<?php echo $days;?>" 
							  <?php if($rs_limit->fields['threshold']==$days){ 
							        echo 'selected="selected"';
							        } ?>><?php echo $days.'&nbsp;';?>Dana</option>
							  <?php } ?>
				              </select>
			<?php } ?>
				</td> 
		</tr>
		<tr>
				<td  class="txt">
				           
				</td>
				<td  class="txt">Od 45 do 90 dana </td>
				</tr>
		
			
		
		
		<tr>
				<td class="txt1">Discount Percentage<br/>[Procenat popusta]</td>
				<td class="txt1">
			<?php
			if(!empty($_SESSION['discount_percentage'])){?> 
			<input type="text" name="discount_percentage" class="fields" id="discount_percentage" value="<?php echo $_SESSION['discount_percentage'] ; ?>" />  
			<?php }else{ ?>
			<input type="text" name="discount_percentage" class="fields" id="discount_percentage" value="<?php echo $rs_limit->fields['discount_percentage']; ?>"/> 
			<?php } ?></td> <td><?php echo "%"; ?> </td> 
		</tr>
		
				
				<tr>
				<td class="txt1">Refundable<br/>[Povratno]</td>
				<td>
				
				<div class="fields_checked">
					<input type="radio" name="refundable" id="refundable_yes" 
					<?php 
					if($rs_limit->fields['refundable']=='1')
					{
						echo 'checked="checked"';
					}
					?>
					value="1" ><span>Da</span>
					<input type="radio" name="refundable" 
					<?php 
					if($rs_limit->fields['refundable']=='0')
					{
						echo 'checked="checked"';
					}
					?>
					 id="refundable_no" value="0" ><span> Ne</span>
				</div>
				</td></tr>
				</table></div></td></tr>
				  <!--<tr>
					 <td class="txt">
  			Last Minute Offer
		   	</td>
			<td>
<?php //if(!empty($_SESSION['elastminute_deal'])){ ?>
			<input type="text" name="elastminute_deal" class="fields" id="elastminute_deal" value="<?php //echo $_SESSION['elastminute_deal'] ; ?>" />
			<?php //}else{ ?> 
			<input type="text" name="elastminute_deal" class="fields" id="elastminute_deal" value="<?php //echo $rs_limit->fields['elastminute_deal'] ; ?>" />
			<?php //} ?>
			
        </tr>--> 
		   
				<!--<tr>
	        <td class="txt">
  			Last Minute Offer
		   	</td>
			<td>
			<?php //if(!empty($_SESSION['elastminute_deal'])){ ?>
			<input type="text" name="elastminute_deal" class="fields" id="elastminute_deal" value="<?php //echo $_SESSION['elastminute_deal'] ; ?>" />
			<?php //}else{ ?> 
			<input type="text" name="elastminute_deal" class="fields" id="elastminute_deal" value="<?php //echo $rs_limit->fields['elastminute_deal'] ; ?>" />
			<?php //} ?>
			</td>
        </tr>-->
	<tr><td><td>	
	<tr><td colspan="2">
			 	<hr/>
			 </td>
			 </tr>

			 
	<tr><td><h3> Last Minute Offer<br/>[Last minute ponuda]</h3></td>
	<td>
	<div class="fields_checked">
				<input type="radio" name="lmin_lastminuteoffer" id="lmin_lastminuteoffer_yes"
				<?php 
					if($rs_limit->fields['lmin_lastminuteoffer']=='1')
					{echo 'checked="checked"';}
				?>
				 value="1" onClick="jQuery('#lastmindiv').show('slow');" ><span> Da</span>
				<input type="radio" name="lmin_lastminuteoffer"  id="lmin_lastminuteoffer_no"
				<?php 
					if($rs_limit->fields['lmin_lastminuteoffer']=='0')
					{echo 'checked="checked"';}
				?>
				 value="0" onClick="jQuery('#lastmindiv').hide('slow');" ><span> Ne</span>
	</div>
	</td>
	</tr>	
		<tr><td colspan="2">
		<div id="lastmindiv">
				<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
	        <td class="txt1">
  			Threshold<br/>[Uslov]
		   	</td>
			<td>
			
			<?php
			if(!empty($_SESSION['lastminute_threshold'])){?> 
			<!--<input type="text" name="lastminute_threshold" class="fields" id="lastminute_threshold" value="<?php //echo $_SESSION['lastminute_threshold'] ; ?>"/>-->
			 <select style="width:120px;" name="lastminute_threshold" id="lastminute_threshold" >
				            <option value="1" selected="selected">1 Day</option>
							<?php for($days=2;$days<=30; $days++){ ?>
							<option value="<?php echo $days; ?>" 
						   <?php 
                           if($days==$_SESSION['lastminute_threshold']){echo 'selected="selected"';}
						   ?>><?php echo $days; ?> Dana</option>
							  <?php } ?>
			 </select>
			<?php }else{ ?>
			<!--<input type="text" name="lastminute_threshold" class="fields" id="lastminute_threshold" value="<?php //echo $rs_limit->fields['lastminute_threshold']; ?>"/>--> 
			
			<select style="width:120px;" name="lastminute_threshold" id="lastminute_threshold" >
				            <option value="1" selected="selected">1 Dana</option>
							<?php for($days=2;$days<=30; $days++){ ?>
							<option value="<?php echo $days; ?>" 
						   <?php 
                           if($days==$rs_limit->fields['lastminute_threshold']){echo 'selected="selected"';}
						   ?>><?php echo $days; ?> Dana</option>
							  <?php } ?>
			 </select>
			<?php } ?>
			</td>
        </tr>
		<tr>
	        <td class="txt1">
  			Discount Percentage<br/>[Procenat popusta]
		   	</td>
			<td>
			<?php if(!empty($_SESSION['lastminute_discount_rate'])){ ?>
			<input type="text" name="lastminute_discount_rate" class="fields" id="lastminute_discount_rate" value="<?php echo $_SESSION['lastminute_discount_rate'] ; ?>" />
			<?php }else{ ?> 
			<input type="text" name="lastminute_discount_rate" class="fields" id="lastminute_discount_rate" value="<?php echo $rs_limit->fields['lastminute_discount_rate'] ; ?>" />
			<?php } ?>
			</td> <td class="txt"><?php echo "%"; ?> </td>
        </tr>
		
		<tr>
	        <td class="txt1">
  			Refundable<br/>[Povratno]
		   	</td>
			<td>
			
			
			
			
			<div class="fields_checked">
			<input type="radio" name="lmin_refundable"
			<?php 
				if($rs_limit->fields['lmin_refundable']=='1')
				{
					echo 'checked="checked"';
				}
			?>
			 id="refundable_yes" value="1" ><span>Da</span>
			<input type="radio" name="lmin_refundable" 
			<?php 
				if($rs_limit->fields['lmin_refundable']=='0')
				{
					echo 'checked="checked"';
				}
			?>
			 id="refundable_no" value="0" ><span> Ne</span>
			</div>
			
			<!--<div class="fields_checked">
			<input type="radio" name="lmin_refundable" id="refundable_yes" checked="checked" value="1" ><span>Yes</span>
			<input type="radio" name="lmin_refundable"  id="refundable_no" value="0" ><span> No</span>
			</div>-->

			</td>
        </tr>
		
		</table></div></td></tr>
		<!--<tr>
	        <td class="txt">
  			Last Minute Offer
		   	</td>
			<td>
			<?php //if(!empty($_SESSION['lmin_lastminuteoffer'])){ ?>
			<input type="text" name="lmin_lastminuteoffer" class="fields" id="lmin_lastminuteoffer" value="<?php //echo $_SESSION['lmin_lastminuteoffer'] ; ?>" />
			<?php //}else{ ?> 
			<input type="text" name="lmin_lastminuteoffer" class="fields" id="lmin_lastminuteoffer" value="<?php //echo $rs_limit->fields['lmin_lastminuteoffer'] ; ?>" />
			<?php //} ?>
			
			-->
		
		<tr><td colspan="2">
			 	<hr/>
			 </td>
			 </tr>
			 
		<tr><td><h3> Long Stay<br/>[Dugi boravak]</h3></td>
		<td>
	   <div class="fields_checked">
				<input type="radio" name="long_stay" id="long_stay_yes"
				<?php 
				if($rs_limit->fields['long_stay']=='1')
				{
					echo 'checked="checked"';
				}
				?>
				 value="1" onClick="jQuery('#lastmindiv2').show('slow');" ><span> Da</span>
				<input type="radio" name="long_stay"  id="long_stay_no" 
				<?php 
				if($rs_limit->fields['long_stay']=='0')
				{
					echo 'checked="checked"';
				}
				?>
				value="0" onClick="jQuery('#lastmindiv2').hide('slow');" ><span> Ne</span>
		</div></td>
		</tr>	
		<tr><td colspan="2">
		<div id="lastmindiv2">
				<table cellpadding="1" cellspacing="1" border="0" >
		
		<tr>
	        <td class="txt1">
  				Threshold<br/>[Uslov]
		   	</td>
			<td>
			<?php if(!empty($_SESSION['threshold_last_minute1'])){ ?>
			<input type="text" name="threshold_last_minute1" class="fields" id="threshold_last_minute1" value="<?php echo $_SESSION['threshold_last_minute1'] ; ?>" />
			<?php }else{ ?> 
			<input type="text" name="threshold_last_minute1" class="fields" id="threshold_last_minute1" value="<?php echo $rs_limit->fields['threshold_last_minute1'] ; ?>" />
			<?php } ?>
			</td>
        </tr>
		
		
		<tr>
	        <td class="txt1">
  			Discount Percentage<br/>[Procenat popusta]
		   	</td>
			<td><?php if(!empty($_SESSION['lmin_discount_percentage1'])){ ?>
			<input type="text" name="lmin_discount_percentage1" class="fields" id="lmin_discount_percentage1" value="<?php echo $_SESSION['lmin_discount_percentage1'] ; ?>" />
			<?php }else{ ?> 
			<input type="text" name="lmin_discount_percentage1" class="fields" id="lmin_discount_percentage1" value="<?php echo $rs_limit->fields['lmin_discount_percentage1'] ; ?>" />
			<?php } ?>
			
			</td> <td class="txt"><?php echo "%"; ?> </td>
        </tr>
		
		<tr>
	        <td class="txt1">
  			Refundable<br/>[Povratno]
		   	</td>
			<td><div class="fields_checked">
			<input type="radio" name="lmin_refundable1" id="lmin_refundable1"
			<?php 
				if($rs_limit->fields['lmin_refundable1']=='1')
				{
					echo 'checked="checked"';
				}
				?>
			 value="1" ><span>Da</span>
			<input type="radio" name="lmin_refundable1" 
			<?php 
				if($rs_limit->fields['lmin_refundable1']=='0')
				{
					echo 'checked="checked"';
				}
				?>
			 id="lmin_refundable1" value="0" ><span> Ne</span>
			</div>
			</td>
        </tr>
		</table></div></td></tr>
		<!--<tr>
	        <td class="txt">
  			Last Minute Offer
		   	</td>
			<td><?php //if(!empty($_SESSION['long_stay'])){ ?>
			<input type="text" name="long_stay" class="fields" id="long_stay" value="<?php //echo $_SESSION['long_stay'] ; ?>" />
			<?php //}else{ ?> 
			<input type="text" name="long_stay" class="fields" id="long_stay" value="<?php //echo $rs_limit->fields['long_stay'] ; ?>" />
			<?php //} ?>
			
			</td>
        </tr>-->

			 <tr><td colspan="2">	
			<!--<input style="margin:5px; width:112px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update" class="button"/>-->
            <a href="javascript:" style="margin:5px; width:112px; float:none; text-align:center;" name="submit" id="submit" class="button" onclick="edit_discount_manag()">Update Discount&nbsp;[A&#382;uriraj popust]</a>
		</td></tr>
		</table>
		        </div> 
			<input type="hidden" name="act" value="edit_discount" />
			<input type="hidden" name="act2" value="discount_management" />
			<input type="hidden" name="request_page" value="manage_discount_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		
<?php 
$_SESSION[early_booking]=$post[''];
$_SESSION[threshold]=$post[''];
$_SESSION[discount_percentage]=$post[''];
$_SESSION[refundable]=$post[''];
$_SESSION[long_stay] =$post[''];
$_SESSION[long_stay]=$post[''];
$_SESSION[lastminute_deal]=$post[''];
$_SESSION[lastminute_threshold]=$post[''];
$_SESSION[lastminute_discount_rate]=$post[''];
$_SESSION[threshold_last_minute]=$post[''];
$_SESSION[lmin_discount_percentage]=$post[''];
$_SESSION[lmin_refundable]=$post[''];
$_SESSION[lmin_lastminuteoffer]=$post[''];
$_SESSION[threshold_last_minute1]=$post[''];
$_SESSION[lmin_discount_percentage1]=$post[''];
$_SESSION[lmin_refundable1]=$post[''];
$_SESSION[long_stay]=$post[''];
?>
		
		
		</td>
	</tr>
</table>
   </div>
   </form>
  </td>
  </tr>
  </table></form>



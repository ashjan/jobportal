<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."vat_tax_charges WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);
//Query for the Property Manager that will be dynamically populated in the add and edit form
/*$qry_property_manag ="SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
								GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();*/

$qry_property_managsel ="SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
								GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_managsel = $db->Execute($qry_property_managsel);

 $qry_property_sel ="SELECT * FROM  tbl_properties
					WHERE id = ".$rs_limit->fields['property_id'].' AND '.$tblprefix.'properties.pm_type=1 ';
					
$rs_property_sel = $db->Execute($qry_property_sel);
$qry_prop = "SELECT * FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
			AND ".$tblprefix."properties.pm_type=1
			AND ".$tblprefix."properties.property_category=24";

$rs_prop = $db->Execute($qry_prop);
$count_prop =  $rs_prop->RecordCount();
$totalprop = $count_prop;

?>
<!--<form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">-->
 <form action="admin.php" method="post" enctype="multipart/form-data" id="managemenufrm" name="managemenufrm">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt" bgcolor="#E7DAE7">
 	<tr>
  		<td id="heading">Edit Vat Charges Management Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	
	<tr>
					<td colspan="3" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
					</td>
				</tr>
	
	
	<tr>
		<td>
	
			<table width="70%" border="0" align="left" cellpadding="5" cellspacing="0" class="txt">
				<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td>
            </tr>
            <?php } else {?>
				<tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" onchange="get_edit_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_edit_prop_name.php"?>')"  class="fields">
					<option value="<?php echo $rs_property_managsel->fields['id']; ?>"><?php echo $rs_property_managsel->fields['first_name']."  ".$rs_property_managsel->fields['last_name']; ?></option>
				 	<?php
						while(!$rs_property_managsel->EOF){?>
                        
							<option value="<?php echo $rs_property_managsel->fields['id'];?>"
							<?php if($rs_property_managsel->fields['id']==$rs_limit->fields['pm_id'])
							{
								echo 'selected="selected"';
							} ?>>
					<?php echo $rs_property_managsel->fields['first_name']."  ".$rs_property_managsel->fields['last_name'];  ?></option>
                    
						<?php
						$rs_property_managsel->MoveNext();
						}?>		
					
					
					
				</select>
			  </td>
            </tr>
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){ ?>
			<tr>
             <td>Property Name</td>
              <td>
		<div id="property_name"> 
		<select name="property_name" id="property_name" class="fields" onchange="get_prp_vat_edit_on('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_prp_vat_edit_on.php"?>')" >
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
			<?php } else {?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_name" id="property_name" class="fields" />
				<!--selected values start from here-->
				<option value="0">Izaberite objekat</option>
				<?php
					while(!$rs_property_sel->EOF){
				?>
					<option value="<?php echo $rs_property_sel->fields['id']; ?>"
					<?php if($rs_property_sel->fields['id']==$rs_limit->fields['property_id']){echo "selected=\"selected\"";}?>
					>
					<?php echo $rs_property_sel->fields['property_name']; ?></option>
				 	
					<?php
						$rs_property_sel->MoveNext();
						}?>
					<!--selected values ends here-->
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
		<tr>
              <td> Vat Type Percent <br/>[Procenat PDV-a]</td>
             
			 <td> <?php $opt=$rs_limit->fields['vat_type_percent']; ?> 
			   <select name="vat_type_percent" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>Ne</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Da</option>
				</select>
				</td>
        </tr>
		
		<tr>
              <td> Vat Status <br/>[Status PDV-a]</td>
              <td> <?php $opt=$rs_limit->fields['vat_status']; ?> 
			   <select name="vat_status" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>Nije uključeno</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Uključeno</option>
				</select>
		</td>
        </tr>
		<tr>
              <td> Vat Amount <br/>[Iznos PDV-a]</td>
			  <td><input type="text" name="vat_amount" class="fields" id="vat_amount" value="<?php echo $rs_limit->fields['vat_amount']; ?>" class="fields" /></td>
              <td>%</td>
        </tr>
		<tr> <td> City Tax Type <br/>[Boravišna taksa] </td>
			 <td> <?php $opt=$rs_limit->fields['city_tax_type']; ?> 
				<select name="city_tax_type" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
				 	<option value="0" selected="selected">Cijena po osobi po noćenju</option>
				</select>
				</td>
             </tr>
		<tr>
              <td> City Tax Status  <br/>[Status boravišne takse]</td>
             
			 <td> <?php $opt=$rs_limit->fields['city_tax_status']; ?> 
			    <select name="city_tax_status" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
				<option value="0" <?php if($opt == 0){ ?> selected="selected" <?php } ?>>Nije uključeno</option>
				<option value="1" <?php if($opt == 1){ ?> selected="selected" <?php } ?>>Uključeno</option>
				</select>
				</td>
        </tr>
		
		<tr>
              <td> City Tax Amount<br/>[Iznos boravišne takse]</td>
			 <td> <?php $opt=$rs_limit->fields['city_tax_amount']; ?> 
			   <input type="text" class="fields" name="city_tax_amount" value="<?php echo $opt; ?>" id="<?php echo $rs_limit->fields['id']; ?>" />
				</td><td>&euro;</td>
        </tr>
        
		<tr>
              <td> Service Charges Type <br/>[Vrsta usluge]</td>
			  <td> 
			  <input type="text" class="fields" name="service_charges_type" id="service_charges_type" value="<?php echo $rs_limit->fields['service_charges_type']?>">
			  <!-- <input  type="text" name="service_charges_type" id="service_charges_type" style="width:146px;" />-->
				</td>
			  </tr>	
		
		<tr>
              <td> Service Charge Amount<br/>[Cijena usluge]</td>
              <td><input type="text" name="service_charge_amount" class="fields" id="service_charge_amount" value="<?php echo $rs_limit->fields['service_charge_amount']; ?>" /></td><td>&euro;</td>
        </tr>
		
		<tr> <td> Service Status <br/>[Status usluge]</td>
				<td> <?php $opt=$rs_limit->fields['service_status']; ?> 
			   <select class="fields" name="service_status" id="<?php echo $rs_limit->fields['id']; ?>">
			    
				<option value="0" <?php if($rs_limit->fields['service_status']==0){echo 'selected="selected"';} ?> > Nije uključeno</option>
				<option value="1"<?php if($rs_limit->fields['service_status']==1){echo 'selected="selected"';} ?> > Uključeno</option>
 				

				</select>
				</td>
				</tr>	
		
		<tr>
        <td colspan="2" align="center"><!--<input style="margin:5px; width:146px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Vat and Charges" class="button"  />-->
        	<a href="javascript:" style="margin:5px; width:112px; float:none; text-align:center;" name="submit" id="submit" class="button" onclick="edit_vat_tax()">Update Vat and Tax &nbsp;[A&#382;uriraj Podešavanja za PDV i takse]</a>
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="vat_and_tax_charges_management" />
			<input type="hidden" name="request_page" value="manage_vat_and_tax_charges" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		
			</td>
	    </tr>
        </td>
		</tr>
</table>
</form>
<script type="text/javascript">

function edit_vat_tax(){ 
    var validation_flag= true;
	with (document.managemenufrm){ 		
		
		if(first_name.value=="0"){
			alert("Please Enter PM Name");
			first_name.focus();
			validation_flag= false;
		}
		
		if(property_name.value=="0"){
			alert("Please Enter Property Name");
			property_name.focus();
			validation_flag= false;
		}		
		
	}
		if(validation_flag==true){
			   document.getElementById('managemenufrm').submit();
			}
		return validation_flag;
}// END
</script>
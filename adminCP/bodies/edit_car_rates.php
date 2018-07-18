
<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."car_rates WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

//Query for the Cars that will be dynamically populated in the add and edit form
    $qry_car = "SELECT
                    ".$tblprefix."car.id,
					".$tblprefix."car.car_type
					FROM
					".$tblprefix."car"; 
$rs_car = $db->Execute($qry_car);
$totalcountpropertymanag =  $rs_car->RecordCount();


$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);

$qry_carsupplier = "SELECT * FROM ".$tblprefix."carsupplier" ;
$rs_carsupplier = $db->Execute($qry_carsupplier);

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users";  
$rs_pm = $db->Execute($qry_pm);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt" >
 	<tr>
  		<td id="heading">Car Rates Management Section</td>
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
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php
			}else{
			?>
				
		 <tr>
		 	<td class="txt1">Property Manager</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_car_agency('get_agency', this.value, '<?php echo MYSURL."ajaxresponse/get_car_agency.php"?>')">
				<option value="0">Izaberite objekat</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){
				echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>	
			</td><td> </td><td> </td>
			</tr> 
		 
		 <?php
		}?>
		 
		  <tr>
					<td>Car Agency*</td>
								<td>
			<div id="get_agency">
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
				<?php $rs_agency->Movefirst(); ?>
				<?php while(!$rs_agency->EOF){ ?>
				<option value="<?php echo $rs_agency->fields['agn_id']; ?>"
  				<?php if($rs_agency->fields['agn_id']==$rs_limit->fields['agency']){
				echo 'selected="selected"';
				} ?>>
				<?php echo $rs_agency->fields['agn_name'];?></option>				
				<?php
				$rs_agency->MoveNext();
				}
				?>
			</select>
			
			</div>	
								</td><td> </td><td> </td>
							</tr> 
					
					  
	<tr>
      <td>Car Supplier*</td>
	 <td><div id="get_supplier"> 	
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type2.php"?>')">
				<?php $rs_carsupplier->Movefirst(); ?>
				<?php while(!$rs_carsupplier->EOF){ ?>
				<option value="<?php echo $rs_carsupplier->fields['id']; ?>"
  				<?php if($rs_carsupplier->fields['id']==$rs_limit->fields['supplier']){
				echo 'selected="selected"';
				} ?>>
				<?php echo $rs_carsupplier->fields['supplier_name'];?></option>				
				<?php
				$rs_carsupplier->MoveNext();
				}
				?>
		</select>
		</div>	
	
	
	
	  </td>
    </tr> 
		
		
		
		<tr>
	        <td>
  			Car type
		   	</td>
			<td>
							
			<div id="get_car">
				<select name="car_id" class="fields"   id="car_id">
				<?php $rs_car->Movefirst(); ?>
				<?php while(!$rs_car->EOF){ ?>
				<option value="<?php echo $rs_car->fields['id']; ?>"
  				<?php if($rs_car->fields['id']==$rs_limit->fields['car_id']){
				echo 'selected="selected"';
				} ?>>
				<?php echo $rs_car->fields['car_type'];?></option>				
				<?php
				$rs_car->MoveNext();
				}
				?>
			</select>		
			</div>
			
			
			</td>
        </tr>

        
        <tr>
	        <td>
  			Number Cars
		   	</td>
			<td>
		
			 <input id="number_cars" class="fields" type="text" value="<?php echo $rs_limit->fields['number_cars']; ?>" name="number_cars">
		
	    	</td>
        </tr>
        
		 
		  
		<tr>
             <td>Starting Days</td>
			  <td><input type="text" name="starting_days" id="starting_days" class="fields" value="<?php echo $rs_limit->fields['starting_days']; ?>">
			   <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'date_ranges',
                                        // input name
                                        'controlname': 'starting_days',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
             </td>
			  </tr>
			 
			 
			  </td>
            </tr>	
			
			
			 <tr>
			  <td> Ending Days </td>
			 
			 
			  <td><input type="text" name="ending_days" id="ending_days" class="fields" value="<?php echo $rs_limit->fields['ending_days']; ?>">
			   <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'date_ranges',
                                        // input name
                                        'controlname': 'ending_days',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			</td>
			</tr>
			
			
		  
		  <tr>
             <td>Days Extra</td>
              <td>
			  
			  
			    <input id="days_extra" class="fields" type="text" value="<?php echo $rs_limit->fields['days_extra']; ?>" name="days_extra">
			
			  </td>
            </tr>
            
			
            <tr>
			  <td> Per Month </td>
              <td>
			    <input id="per_month" class="fields" type="text" value="<?php echo $rs_limit->fields['per_month']; ?>" name="per_month">
			  </td>
            </tr>
            
			
            <tr>
			  <td> Car Rates </td>
              <td>
			    <input id="car_rate" class="fields" type="text" value="<?php echo $rs_limit->fields['car_rate']; ?>" name="car_rate">&euro;
			  </td>
            </tr>
		
		
			
			
			
            <tr>
              <td>&nbsp;</td>
              <td><input style="margin:2px; width:142px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update minimum stay" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="edit_car_rates" />
		  <input type="hidden" name="act2" value="manage_car_rates" />
          <input type="hidden" name="request_page" value="car_rates_management" />
          <input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
		  <input type="hidden" name="mode" value="update">
        </form>
			</td>
	    </tr>
</table>


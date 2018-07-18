<?php
$id=base64_decode($_GET['id']);
$vcar=$tblprefix."car";
  $qry_limit = "SELECT cr.*, tbl_sup.supplier_name
					FROM ".$vcar." as cr  
		      INNER JOIN tbl_carsupplier as tbl_sup ON tbl_sup.id=cr.supplier_id  WHERE cr.id=".$id;  
$rs_limit = $db->Execute($qry_limit);

$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);

$qry_cat = "SELECT * FROM ".$tblprefix."car_categories" ;
$rs_cat = $db->Execute($qry_cat);

$qry_carsupplier = "SELECT * FROM ".$tblprefix."carsupplier" ;
$rs_carsupplier = $db->Execute($qry_carsupplier);

/*echo '<pre>';
print_r($_SESSION['car_price']);
die;*/

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."property_manager";  
$rs_pm = $db->Execute($qry_pm);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Car Management Section</td>
 	</tr>
	
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?> </td>
					</tr>
					
					<tr>
					
					
					<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
           
		   <tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
			
			<option value="0">Select Car Agency</option>	
	<?php while(!$rs_agency->EOF){
				
				$is_cat_selected = '';
				if($rs_agency->fields['agn_id']==$rs_limit->fields['agency']){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_agency->fields['agn_id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_agency->fields['agn_name'] ;?></option>
	<?php $rs_agency->MoveNext();
	}
	
?>
</select>
			
		</td>
			</tr> 	
		   
		   
		    <?php
			}else{ ?> 
					
					
		 	<td class="txt1">Property Manager<br/>[Vlasnik objekta]</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_car_agency('get_agency', this.value, '<?php echo MYSURL."ajaxresponse/get_car_agency.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
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
			<tr>
		 	<td class="txt1">Car Agency*</td>
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
			
			</td>
			</tr> 
		<?php }?>
		<tr>
	        <td class="txt1">
  			
			Supplier Name
		   	</td>
			<td>
		<div id="get_supplier"> 	
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type.php"?>')">
		
		<?php $rs_carsupplier->Movefirst(); ?>
				<?php while(!$rs_carsupplier->EOF){ ?>
				<option value="<?php echo $rs_carsupplier->fields['id']; ?>"
  				<?php if($rs_carsupplier->fields['id']==$rs_limit->fields['supplier_id']){
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
						<td>Car Type </td>
						<td>
				<input type="text" name="car_type" class="fields" id="car_type" value="<?php echo $rs_limit->fields['car_type']?>"  />
				</td>
					</tr> 
					
					
					<tr>
								<td>Car Category*</td>
								<td>
								
								
								
				<select name="category" class="fields"   id="category">
				<option value="0">Select Car Category</option>
				<?php 
			    while(!$rs_cat->EOF){
				?>
				<option value="<?php echo $rs_cat->fields['id'];?>"
				<?php
				if($rs_cat->fields['id']==$rs_limit->fields['category']){
				echo 'selected="selected"';
				}
				?>><?php echo $rs_cat->fields['car_category_name'];?></option>
				<?php
				$rs_cat->MoveNext();
				}
				?>					
			</select>	
				
					</td><td> </td><td> </td>
				</tr> 
			   				<tr>
							  <td>Produced*</td>
							   <td width="150">
			
			
				<!--<input type="text" name="produced" class="fields" id="produced" value="<?php //echo $rs_limit->fields['produced']?>"  />
				
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managemenufrm',
                                        // input name
                                        'controlname': 'produced',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
             </script>-->
			 
			 <select name="produced" class="fields"   id="produced">
          <option value="0">Select Car Produced Year</option>
          <?php 
			    for($j=1950;$j<=2050;$j++){
				
				 ?>
          <option value="<?php  
		  
		  echo $j;?>"
				<?php
				if($rs_limit->fields['produced']==$j){
				echo 'selected="selected"';
				}
				?>><?php echo $j;?></option>
          <?php
				
				}
			?>
        </select>
			 
			 
			 
			 
			 
			 
			 
			</td><td> </td>
					  </tr>
					  
					  
					  
					  <tr>
							  <td>Doors*</td>
							  <td><!--<input type="text" name="doors" class="fields" id="doors" value="<?php //echo $rs_limit->fields['doors']; ?>" />-->
							  
							 
			
				
				<input type="text" name="doors" class="fields" id="doors" value="<?php echo $rs_limit->fields['doors']?>"  />
				 </td><td> </td><td> </td>
					  </tr>
					  
					  
					  
					  <tr>
							  <td>Passengers*</td>
							  <td>
				<input type="text" name="passengers" class="fields" id="passengers" value="<?php echo $rs_limit->fields['passengers']?>"  />
							</td><td> </td><td> </td>
					  </tr>
					  
					  
					  <tr>
							  <td>Number of Cars*</td>
							  <td>
				<input type="text" name="num_of_car" class="fields" id="num_of_car" value="<?php echo $rs_limit->fields['num_of_car']?>"  />
				</td><td> </td><td> </td>
					  </tr>
					  
					  
					  <tr>
							  <td>Minimum days for rent*</td>
							  <td>
							  
				<input type="text" name="min_day_for_rent" class="fields" id="num_of_min_day_for_rentcar" value="<?php echo $rs_limit->fields['min_day_for_rent']?>"  />
				</td><td> </td><td> </td>
					  </tr>
			  
			  
			  
					<tr>
						<td>Car Picture </td>
						<td><input type="file" name="car_picture" class="fields" id="car_picture" value="<?php echo $rs_limit->fields['car_picture']; ?>" />
						 </td><td> </td>
						 
					<tr><td></td>
						<td> 
			<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."graphics/car_upload/".$rs_limit->fields['car_picture'];?>&w=50&h=40&zc=1" border="0" />
					 </td><td></td><td> </td><td> </td>
					</tr> 
					     
	   				
               
	        <td>&nbsp;			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update Car" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_car" />
			<input type="hidden" name="act2" value="car" />
			<input type="hidden" name="request_page" value="manage_car" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['car_picture']; ?>" />
			<input type="hidden" name="mode" value="update">
			
		</form>
		</td>
	</tr>
</table>


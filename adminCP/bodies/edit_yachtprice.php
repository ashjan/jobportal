<?php
$id=base64_decode($_GET['id']);
 $qry_limit= "SELECT * FROM ".$tblprefix."yatmng_price WHERE id=".$id; 
 $rs_limit = $db->Execute($qry_limit);


$qry_property_manag = "SELECT
                    ".$tblprefix."users.id,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name 
					FROM
					".$tblprefix."users"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].'';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

$qry_model = "SELECT id,model FROM  ".$tblprefix."yachtmodel";
$rs_model = $db->Execute($qry_model);
$count_add =  $rs_model->RecordCount();

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Yacht Rates Management</td>
 	</tr>
	
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right"></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
    </td>
  </tr>
  <tr>
    <td colspan="6"> 
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
          <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_yacht_agency('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_yacht_agency.php"?>')">
					<option value="0">Select PM</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
					    <option value="<?php echo $rs_property_manag->fields['id'];?>"
					    <?php if($rs_limit->fields['pm_id']==$rs_property_manag->fields['id']){ echo 'selected="selected"';}?>>
					    <?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr> 
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Agency Name</td>
              <td>
			  <div id="agency_name"> 
			    <select name="agency" id="agency" class="fields" onchange="get_yacht_agency('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_yacht_agency.php"?>')">
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['agn_id']; ?>" <?php if($rs_limit->fields['agn_id']==$rs_property->fields['agn_id']){echo 'selected="selected"';}?>><?php echo $rs_property->fields['agn_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
<?php }else{ ?>
			<tr>
             <td>Agency Name</td>
              <td>
              <?php $qry_agency = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency WHERE pm_id=".$rs_limit->fields['pm_id'];
                $rs_agency = $db->Execute($qry_agency);
                $total_agency = $rs_agency->RecordCount();
              ?>
			  <div id="agency_name"> 
			    <select name="agency" id="agency" class="fields" onchange="get_agency_model('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_agency_model.php"?>','<?php echo $rs_limit->fields['pm_id']?>')" />
					
					<?php if($total_agency>0){
						 $rs_agency->MoveFirst();
						 while (!$rs_agency->EOF) {?>
						 <option value="<?php echo $rs_agency->fields['agn_id'];?>" 
						 <?php if($rs_limit->fields['agn_id']==$rs_agency->limits->fields['agn_id']){
						 	echo 'selected="selected"';
						 }?>> <?php echo $rs_agency->fields['agn_name']?></option>
						 	
						<?php 
						  $rs_agency->MoveNext();
						 }
						?>
					
					<?php }?>
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
			
			<tr>
	        <td bgcolor="#3399FF">
  			Model Name
		   	</td>
			<td>
			<?php 
			$qry_model = "SELECT id,yatch_name FROM ".$tblprefix."yatchtypes WHERE pm_id=".$rs_limit->fields['pm_id']." 
			             AND yatch_agency=".$rs_limit->fields['agn_id'];
			$rs_model = $db->Execute($qry_model);
			$total_model = $rs_model->RecordCount();
			?>
	<div id="room_type">
			<select name="model" class="dropfields" >
			  <option value="0">Select Model</option>
			  <?php if($total_model>0){
			  	   $rs_model->MoveFirst();
			  	   while (!$rs_model->EOF) {?>
			  	   	<option value="<?php echo $rs_model->fields['id']?>"<?php if($rs_limit->fields['yat_model']==$rs_model->fields['id']){echo 'selected="selected"';}?>>
			  	   	<?php echo $rs_model->fields['yatch_name'];?>
			  	   	</option>
			  	  <?php 
			  	        $rs_model->MoveNext() 	;
			  	   }
			  }
			  	?>

			</select>
    </div>
			</td>
        </tr>

        <!--Property name against PM name-->
        
		    
			
        
        <!--Property name against PM name End HERE-->
			 <tr>
			 <td >
			 <b> Rate</b>
			 </td></tr>
			 <tr  bgcolor="#CCCCCC">
          <td><b>Start Range</b> </td>
          <td><b>End Range</b> </td>
          <td><b>Rate</b></td>
        </tr>
       
	    <tr bgcolor="#CCCCCC">
         <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.</td>
        </tr>
		
			<tr>
			<td width="200">
			  <input type="text" name="standard_start_date"  id="standard_start_date" value="<?php echo date("m/d/Y",strtotime($rs_limit->fields['start_date']))?>" />
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'standard_start_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
             </script>
			</td>
			
			 <td>
			 <input type="text" name="standard_end_date"  id="standard_end_date" value="<?php echo date("m/d/Y",strtotime($rs_limit->fields['end_date']))?>" />
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'standard_end_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			 </td>
			
			  <td>
			  <input type="text" name="standard_rate_price"  id="standard_rate_price" value="<?php echo $rs_limit->fields['price'];?>" />
			  </td>
			 </tr>
			 
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			 
			 <!--<tr>
			 <td bgcolor="#3399FF">Berths</td>
			 <td>
			 <select name="berths_for_sale" class="fields"   id="berths_for_sale">
			<?php //for($i=1;$i<=25;$i++){ ?>
				<option value="<?php //echo $i; ?>" <?php //if($rs_limit->fields['berths_for_sale']==$i){echo 'selected="selected"';}?>> <?php  //echo $i; ?></option>
			<?php //}?>
			</select>
			</td>
			<td>&nbsp;</td>
			 </tr>-->
			 <tr>
			 <td>Price</td>
			 <td>
			 <select name="price_style" id="price_style" onchange="price_availability('price_style','show_select')" class="fields">
			 <option value="0" <?php if($rs_limit->fields['day_weekflag']==0){echo 'selected="selected"';}?>>Per day</option>
			 <option value="1" <?php if($rs_limit->fields['day_weekflag']==1){echo 'selected="selected"';}?>>Per week</option>
			 </select>
			
			 </td>
			 </tr>
			 <?php 
			   $display = 'none';
			  if($rs_limit->fields['day_weekflag']==0){
			       $display = 'none';
			  }else {
			  	$display = 'block';
			  }
			  
			  ?>
			 
			 			   <tr>
			   
		<td colspan="2" class="txt">
				<table border="0" cellpadding="2" cellspacing="1" width="84%" id="show_select" style="display:<?php echo $display?>">
			       <tr>
				   <td width="30%" class="txt">Renting starts by</td>
                   <td width="32%" >
                 <select name="days_in_week" class="fields">
				<?php  for($i=1; $i<=7; $i++){?>
					<option value="<?php echo $i; ?>"  <?php 
					if($rs_limit->fields['rent_start_day']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					 ?> ><?php echo $i; ?></option>
					<?php } ?>
                 </select>				
                 </tr>
                 </table>
        </td>
        
		</tr>
					     
	   				
               
	        <td>&nbsp;			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update agency" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_yachtprice" />
			<input type="hidden" name="request_page" value="mng_yatprice" />
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>


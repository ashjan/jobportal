<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$maxRows = 50;

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE '.$tblprefix.'standard_rates.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
							AND '.$tblprefix.'properties.pm_type=1
							AND '.$tblprefix.'properties.property_category=24'; 
}else{
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=1
							AND '.$tblprefix.'properties.property_category=24'; 
}
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
			 $qry_faq = "SELECT 
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
  Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id = ".$tblprefix."standard_rates.pm_id 
  $module_pm_where ORDER BY ".$tblprefix."standard_rates.id DESC";
						
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
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
							Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_manager.id = ".$tblprefix."standard_rates.pm_id  							$module_pm_where"." ORDER BY ".$tblprefix."standard_rates.id DESC LIMIT ".$startRow.",".$maxRows.""; 

				
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;

//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
						".$tblprefix."properties.property_name ,
						".$tblprefix."properties.pm_type ,
						".$tblprefix."properties.property_category 
						FROM ".$tblprefix."property_manager 
						inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties 
						WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
						AND '.$tblprefix.'properties.pm_type=1 
						AND '.$tblprefix.'properties.property_category=24';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();


?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading" colspan="3">Standard Rates Management &nbsp;[Podešavanje cijena]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?>>
	<?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?>
	</td>
  </tr>
  <tr class="tabheading">
    <td colspan="8" align="right">Total Standard Rates Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="8" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="8"> 
	    <div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){ ?>
		  <tr>
			<td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td>
		 </tr>
<?php	}else{ ?>
          <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_prop_name5('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name5.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
					    <option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr> 
		  <?php }?>
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		  <tr>
          <td>Property Name</td>
          <td>
		   <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields" onchange="get_room_type2('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type8.php"?>')">
					<option value="0">Izaberite objekat</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
<?php }else{ ?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields"  />
					<option value="0">Izaberite objekat</option>
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
			
			<tr>
	        <td bgcolor="#3399FF">
  			Room/Property Type<br/>[Tip sobe/objekta]
		   	</td>
			<td>
			
	<div id="room_type">
			<select name="room_type" class="dropfields" >
			  <option value="0">Izaberite sobu</option>
			</select>
    </div>
			</td>
        </tr>

        <!--Property name against PM name-->
        
		    
			
        
        <!--Property name against PM name End HERE-->
			 <tr>
			 <td colspan="2">
			 <b>Standard Rate<br/>[Osnovna cijena]</b>
			 </td>
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
         
			
			<tr>
			<td width="200">
			 <input type="text" name="standard_start_date"  id="standard_start_date" />
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
			 <input type="text" name="standard_end_date"  id="standard_end_date" />
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
			  <input type="text" name="standard_rate_price"  id="standard_rate_price" />
			  </td>
			 </tr>
			 
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			 
			 <tr>
			 <td bgcolor="#3399FF">Room For Sales<br/>[Raspolo&#382;ive sobe]</td>
			 <td>
			 <select name="stndrd_rooms_for_sale" class="fields"   id="stndrd_rooms_for_sale">
			<?php for($i=1;$i<=25;$i++){ ?>
				<option value="<?php echo $i; ?>"> <?php  echo $i; ?></option>
			<?php }?>
			</select>
			</td>
			<td>&nbsp;</td>
			 </tr>
			 
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
		
	 <tr>
	   <td colspan="3" >	    
       <table cellpadding="0" cellspacing="0" border="0" class="txt" >	 
					<tr>
					  <td><h3>Single use rate<br/>[Cijena za jednu osobu]</h3></td>
					</tr>   
       </table>
	   </td>
	 </tr>
		
			 
        <tr>
			 <td bgcolor="#3399FF">Single User Option<br/>[Mogućost rezervacije za jednu osobu]</td>
			 <td>
             <input type="radio" name="single_use_option" id="single_use_option1" onClick="jQuery('#standard_single_use').show('slow');"  checked="checked"  value="1"/><!--YES  &nbsp; &nbsp;--> Da
			 <input type="radio" onClick="jQuery('#standard_single_use').hide('slow');" name="single_use_option" id="single_use_option0"  value="0"/><!--NO  &nbsp; &nbsp;--> Ne
			</td>
            <td>&nbsp;</td>
		</tr>
            
            
          
          
          
      <tr>
		<td colspan="3" >	
			<div id="standard_single_use"  style="display:block;" class="txt">
			   <table cellpadding="0" cellspacing="0" border="0" class="txt" >	 
					<tr  bgcolor="#CCCCCC">
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><b>Rate<br/>[cijena]</b></td>
					</tr>
					<tr  bgcolor="#CCCCCC">
					  <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.
                      <br/>[Izaberite počentni i krajnji datum va&#382;enja cijene i unesite cijenu ]
                       <br/>
					  <span style="color:#FF0000;"><strong>Warning:</strong>   Replacing the date ranges will delete all the previous date ranges for this rate.</span>
                      <br/>
                      <span style="color:#FF0000;"><strong>Upozorenje:</strong>Mijenjanje perioda će izbrisati sve prethodno postavljene periode za ovu cijenu</span>
                      </td>
					</tr>
					<tr>
					  <td width="200">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><input type="text" name="single_rate_price"  id="single_rate_price" value="0" /></td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
			   </table>	
			</div>	
       </td>
	   </tr>
			
			 <tr><td colspan="3">&nbsp;</td></tr> 
			 <tr>
			 <td bgcolor="#3399FF">Advance User Option<br/>[Napredne cijene]</td>
			 <td>
			 <select name="advance_use_option" class="fields"  id="advance_use_option" 
			 onchange="jQuery('#advance_rate_option').toggle('slow');">
				<option value="1"  name="single_use_option">Da</option>
				<option value="0"  name="single_use_option">Ne</option>
			</select>
			</td>
			 <td>&nbsp;</td>
			 </tr>
	
	
	 <tr>
     <td colspan="3" >
	  <div id="advance_rate_option">
    	<table width="100%" border="0" cellspacing="1" cellpadding="2" class="txt" >
	 <tr>
       <td colspan="2">
		  
		  
	<table cellpadding="0" cellspacing="0" border="0" class="txt">
      <tr>
	  <td colspan="2">	 
			 
			<h3>Advance use rate<br/>[Period za naprednu cijenu]</h3></td>
        </tr>
        <tr  bgcolor="#CCCCCC">
          <td><b>Advance Range<br/>[Period za naprednu cijenu]</b></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr  bgcolor="#CCCCCC">
          <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.<br/>[Izaberite počentni i krajnji datum va&#382;enja cijene i unesite cijenu ]</td>
        </tr>
			  <tr>
			  
			  <td width="200"><input type="text" name="advance_start_date"  id="advance_start_date" />
			                     <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'advance_start_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
				</td>
			  <td><input type="text" name="advance_end_date"  id="advance_end_date" />
			                      <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'advance_end_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			  </td>
			  <td><input type="text" name="advance_rate_price"  id="advance_rate_price" value="0" /></td>
			 </tr>
			 
			 
			  <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			
			<tr>
			 <td bgcolor="#3399FF">Room For Sales<br/>[Raspolo&#382;ive sobe]</td>
			 <td>
			<select name="advnc_rooms_for_sale" class="fields"   id="advnc_rooms_for_sale">
			<?php for($i=1;$i<=25;$i++){ ?>
				<option value="<?php echo $i; ?>"> <?php  echo $i; ?></option>
			<?php }?>
			</select>
			</td>
			 </tr>
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			 
			
			 <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
		  </table>
			
	</td>		
	</tr>
	<tr>
	   <td colspan="2" >	    
       <table cellpadding="0" cellspacing="0" border="0" class="txt" >	 
					<tr>
					  <td><h3>Advance Single use rate <br/>[Mogućnost rezervacije za jednu osobu]</h3></td>
					</tr>   
       </table>
	   </td>
	  </tr>  
	
	
	<tr>
	   <td colspan="2">
		<tr>
			 <td bgcolor="#3399FF" style="width:198px;">Advance Single User Option<br/>[Mogućnost rezervacije za jednu osobu]</td>
			 <td><input type="radio" name="single_adv_use_option" id="single_adv_use_option1" onClick="jQuery('#advance_single_use').show('slow');" checked="checked"  value="1"/><!--YES  &nbsp; &nbsp;--> Da
				<input type="radio" onClick="jQuery('#advance_single_use').hide('slow');" name="single_adv_use_option" id="single_adv_use_option0"  value="0"/><!--NO &nbsp; &nbsp;--> Ne
			</td>
		</tr>
		<tr>
		<td colspan="2">	
			<div id="advance_single_use"  style="display:block;">
			   <table cellpadding="0" cellspacing="0" border="0" class="txt" >	 
					<tr  bgcolor="#CCCCCC">
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><b>Rate <br/>[cijena]</b></td>
					</tr>
					<tr  bgcolor="#CCCCCC">
					  <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.<br/>[Izaberite počentni i krajnji datum va&#382;enja cijene i unesite cijenu ]</td>
					</tr>
					<tr>
					  <td width="200">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td><input type="text" name="single_adv_rate_price"  id="single_adv_rate_price" value="0" /></td>
					</tr>
					<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
			   </table>	
			</div>	
       </td>
	   </tr> 
     </td>
	 </tr>
    </tr>
	</table>
      </div>		 
     </td>
    </tr>
    <tr>
    <td colspan="3">
     <table width="100%" border="0" cellspacing="1" cellpadding="2" class="txt" >
		<tr>
          <td>&nbsp;</td>
        </tr>
	      <input type="hidden" name="act" value="manage_rates" />
		  <input type="hidden" name="request_page" value="rates_management" />
          <input type="hidden" name="mode" value="add">
      
    </tr>
      <tr> <td>&nbsp;</td>
  <td><input style="margin:5px; width:180px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert rates &nbsp;[Dodajte cijene]" class="button" /></td> 
  </tr> 
  
    </table>
	</form>
	</td>
	</tr>
	
</table>
</div>
<table cellpadding="1" cellspacing="2" border="0">
	
	
    <tr>
    <td colspan="3">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
	 <!-- hs changes starts here -->	
					<?php
                    //Dropdown for parent
					
                    $category_qry ="SELECT ".$tblprefix."property_manager.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
									 FROM ".$tblprefix."property_manager 
									 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
									 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
									 GROUP BY ".$tblprefix."properties.pm_id"; 
                    $rs_category = $db->Execute($category_qry); 
                    ?>
	<tr>
	<td>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>				
					<form action="admin.php" name="uniqueness" method="post" enctype="multipart/form-data">
                    <?php if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>
                    <tr>
				    	<td class="txt2">Select PM :</td>
					<td>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name22('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name22.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta :</option>
					<?php
					if(isset($_GET['pm_id'])){
						$pm_id = base64_decode($_GET['pm_id']);
						}else{
						$pm_id = 0;
						}
					$rs_category->MoveFirst();
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>"
					<?php
						if($pm_id==$rs_category->fields['id']){echo 'selected="selected"';}
					?>
					><?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?></option>
					<?php
					$rs_category->MoveNext();
					}
					?>			
					</select>
                    </td>
                    </tr>
                    <tr>
				    	<td class="txt2">Select Property Name :<br/>[Izaberite objekat]</td>
					<td>
					<div id="property_id1">
					<?php
						//condition for selected dropdown start
					if(isset($_GET['pr_id'])){
						$pr_id = base64_decode($_GET['pr_id']);
						}else{
						$pr_id = 0;
						}
						//Dropdown for parent
						if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
                    	 $property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=1';
						$rs_prop = $db->Execute($property_qry);
						$totalprope =  $rs_prop->RecordCount();
						}
					//condition for selected dropdown ends
					?>
					<select name="property_id"class="fields" >
				 	<option value="0">Izaberite objekat</option>
					<?php
					if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
					$rs_prop->MoveFirst();
					while(!$rs_prop->EOF){ 
					?>
					<option value="<?php echo $rs_prop->fields['id']; ?>"
					 <?php 
 						if($pr_id==$rs_prop->fields['id']){echo 'selected="selected"';}
 					 ?>
					><?php echo $rs_prop->fields['property_name']; ?></option>
					<?php
					$rs_prop->MoveNext();
					}}
					?>
					</select>
					</div>
					</td>
                    </tr>
                    <tr>
				    	<td class="txt2">Select Room :<br/>[Izaberite sobu]</td>
					<td>
					<div id="rooms_id1">
					<?php
						//condition for selected dropdown start
					if(isset($_GET['pr_id'])){
						$pr_id = base64_decode($_GET['pr_id']);
						}else{
						$pr_id = 0;
						}
						//Dropdown for parent
						if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
                    	 $property_qry = "SELECT id,room_type FROM ".$tblprefix."rooms WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=1'; 
						$rs_prop = $db->Execute($property_qry);
						$totalprope =  $rs_prop->RecordCount();
						}
					//condition for selected dropdown ends
					?>
					<select name="room_id" class="fields" >
				 	<option value="0">Izaberite sobu</option>
					<?php
					if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
					$rs_prop->MoveFirst();
					while(!$rs_prop->EOF){ 
					?>
					<option value="<?php echo $rs_prop->fields['id']; ?>"
					 <?php 
 						if($pr_id==$rs_prop->fields['id']){echo 'selected="selected"';}
 					 ?>
					><?php echo $rs_prop->fields['room_type']; ?></option>
					<?php
					$rs_prop->MoveNext();
					}}
					?>
					</select>
					</div>
                    </td>
                    </tr>
					<?php
					}else{
					?>
                    <tr>
                    	<td class="txt2"> Select Property Name<br/>[Izaberite objekat]</td>
                    <td>
                    <div id="property_id">
					<select name="property_id"class="fields" onchange="get_rooms('rooms_id1', this.value,<?php echo $_SESSION[SESSNAME]['pm_id']; ?> , '<?php echo MYSURL."ajaxresponse/get_rooms.php"?>')">
				 	<option value="0">Izaberite objekat</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>" ><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
					</select>
					</div>
                    </td>
                    </tr>
					
					
                    <tr>
                    	<td class="txt2"> Select Room<br/>[Izaberite sobu]</td>
                    <td>
					<div id="rooms_id1">
					<select name="room_id" class="fields" 
					 onchange="get_rates('get_rates', this.value, '<?php echo MYSURL."ajaxresponse/get_rates.php"?>')" >
				 	<option value="0">Izaberite sobu</option>
					<?php  
                    /*						
					$rs_region->MoveFirst();
					while(!$rs_region->EOF){ ?>
 <option value="<?php echo $rs_region->fields['id']; ?>" ><?php echo $rs_region->fields['room_type']; ?></option>
					<?php 
					$rs_region->MoveNext();
					} 
                    */					
					?>
					</select>
					</div>
					</td>
                    </tr>					
                    </form>				
					<?php } ?>
					
	</table>
	</td>
	</tr>
  	</table>
  </td>
  </tr>
</table>


	<!-- hs changes ends here -->
	<div id="get_rates"> 
	</div>


<?php

// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid']))
{
?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php 
}
?>



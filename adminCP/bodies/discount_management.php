<?php
	
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $module_pm_where = ' WHERE  '.$tblprefix.'properties.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
 							AND '.$tblprefix.'properties.pm_type=1
							AND '.$tblprefix.'properties.property_category=24'; 
}else{
 
 $module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=1
 							AND '.$tblprefix.'properties.property_category=24'; 
}

if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $module_pm_where1 = ' WHERE  '.$tblprefix.'rooms.pm_id = '.$_SESSION[SESSNAME]['pm_id']; 
}else{
 
 $module_pm_where1 = '';
}
		
		
	$maxRows = 50;
	if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
	if ($pageNum == '') $pageNum=0;
	$startRow = $pageNum * $maxRows;
	
	$qry_faq = "SELECT * FROM ".$tblprefix."rooms $module_pm_where1";
	$rs_faq = $db->Execute($qry_faq);
	$count_add =  $rs_faq->RecordCount();
	$totalRows = $count_add;
	$totalPages = ceil($totalRows/$maxRows);


	$qry_limit = "SELECT ".$tblprefix."rooms.*,
					 ".$tblprefix."users.first_name,
					 ".$tblprefix."users.last_name,
					 ".$tblprefix."properties.property_name
	FROM ".$tblprefix."rooms  
	INNER JOIN ".$tblprefix."users ON ".$tblprefix."users.id=".$tblprefix."rooms.pm_id 
	INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.id=".$tblprefix."rooms.property_id $module_pm_where 
	LIMIT $startRow,$maxRows";
 
 
 
	$rs_limit = $db->Execute($qry_limit);
	$totalcountalpha =  $rs_limit->RecordCount();

	//Dropdown for parent

	$qry_property_manag ="SELECT ".$tblprefix."users.*,
						  ".$tblprefix."properties.property_name ,
						  ".$tblprefix."properties.pm_type ,
						  ".$tblprefix."properties.property_category 
							 FROM ".$tblprefix."users 
							 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
							 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
							 GROUP BY ".$tblprefix."properties.pm_id";  
					
	$rs_category = $db->Execute($qry_property_manag);
	$totalcountpropertymanag =  $rs_category->RecordCount();
	$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
					AND pm_type=1 
					AND '.$tblprefix.'properties.property_category=24';
					
	$rs_property = $db->Execute($property_qry);
	$totalproperties =  $rs_property->RecordCount();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">

    <tr>
        <td id="heading" colspan="2">Discount Property &nbsp; &nbsp;[Upravljanje popustima]</td>
        
    </tr>
   <tr>
        <td>&nbsp;</td>
        <td colspan="6" align="right">
      <a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"> 
	  <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> 
	  </td>
    </tr>
    
 
    
  <tr>
  <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
 
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
    <form action="admin.php" method="post" enctype="multipart/form-data" name="managecontentfrm" id="managecontentfrm">
    <table cellpadding="1" cellspacing="1" border="0" class="txt" >
  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
  
  
   <tr>
				<td class="txt">Select Property Manager:<br/>[Izaberite objekat]:</td>
					<td>
	<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_dis_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_dis_name.php"?>')">
	<option value="0">Izaberite vlasnika objekta</option>
	<?php
	//$rs_category->MoveFirst();
	while(!$rs_category->EOF){
	?><option value="<?php echo $rs_category->fields['id'];?>"
		<?php
		/*if($rs_category->fields['id'] == $_SESSION["sessdiscount"]["pm_id"]){
			echo 'selected="selected"';
		}*/
	?>>
		<?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?>
	</option>
	<?php
		$rs_category->MoveNext();
	}
	?>			
	</select>					
					</td>
				</tr>
			<?php }?>
		 <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		 <tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_name" id="property_name" class="fields" onchange="get_room_type2('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type2.php"?>')">
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
		 <?php } else { ?>		
		<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_name" id="property_name" class="fields" />
					<option value="0">Izaberite objekat</option>
				</select>
				</div>
			  </td>
        </tr>
           <?php }?>
    <tr>
    <td>Izaberite sobu</td>
	<td>
            <div id="room_type"> 
                <select name="room_type" id="room_type" class="fields" />
                    <option value="0">Izaberite sobu</option>
                </select>
            </div>
    </td>
	</tr>

	<tr>
    <td colspan="2">
			 	<hr/>
	</td>
	</tr>

			
		<tr>
				<td><h3>Early booking<br/>[Rana rezervacija]</h3></td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="early_booking" id="wise_price_yes" checked="checked" value="1" onClick="jQuery('#wise_price_parameters').show('slow');" ><span> Da</span>
				<input type="radio" name="early_booking"  id="wise_price_no"  value="0" onClick="jQuery('#wise_price_parameters').hide('slow');" ><span> Ne</span>
				</div>
				
				</td> 
		</tr>
		<?php //if(){ echo'&nbsp;'; } ?>
		
		<tr>
				<td colspan="2">
				<div id="wise_price_parameters">
				<table cellpadding="1" cellspacing="1" border="0" >	
							
				<tr>
	        <td class="txt1">
  			Uslov
		   	</td>
			<td class="txt1">
				<table cellpadding="1" cellspacing="1" border="0"  width="100%" >	
				<tr>
				<td  class="txt">
				              <select style="width:120px;" name="threshold" id="threshold" >
				              <option value="45" selected="selected">45 Day</option>
							  <?php for($days=46;$days<=90; $days++){ ?>
							  <option value="<?php echo $days; ?>"><?php echo $days; ?> Dana</option>
							  <?php } ?>
				              </select>
				</td>
				<td  class="txt">Od 45 do 90 dana </td>
				</tr>
				</table>
			</td>
        </tr>
			
				<tr>
				<td class="txt1">Discount Percentage<br/>[postotak popusta]</td>
				<td class="txt1" style="width:350px;">
				<input class="fields" type="text" value="" name="discount_percentage" id="discount_percentage" />% 
				</td> 
				</tr>
				
				
					
					<tr>
					<td class="txt1">Refundable<br/>[povratni]</td>
					<td>
					<div class="fields_checked">
					<input type="radio" name="refundable" id="refundable_yes" checked="checked" value="1" ><span>Da</span>
					<input type="radio" name="refundable"  id="refundable_no" value="0" ><span> Ne</span>
					</div>
					
					</td> 
					</tr>
			</table>
			</div>
				
				
				
				</td>
				</tr>
		
		<tr><td colspan="2">
			 	<hr/>
			 </td>
			 </tr>
		
	<tr><td><h3> Last Minute Offer<br/>[Last minute ponuda]</h3></td>
	<td>
	<div class="fields_checked">
				<input type="radio" name="lmin_lastminuteoffer" id="lmin_lastminuteoffer_yes" checked="checked" value="1" onClick="jQuery('#lastmindiv').show('slow');" ><span> Da</span>
				<input type="radio" name="lmin_lastminuteoffer"  id="lmin_lastminuteoffer_no" value="0" onClick="jQuery('#lastmindiv').hide('slow');" ><span> Ne</span>
	</div></td>
	</tr>	
		<tr>
		<td colspan="2">
		<div id="lastmindiv">
		<table cellpadding="1" cellspacing="1" border="0" >	
		<tr>
	        <td class="txt1">
  			Threshold<br/>[Uslov]
		   	</td>
			<td class="txt1">
				<table cellpadding="1" cellspacing="1" border="0"  width="100%" >	
				<tr>
				<td  class="txt">
				              <select style="width:120px;" name="lastminute_threshold" id="lastminute_threshold" >
				              <option value="1" selected="selected">1 Day</option>
							  <?php for($days=2;$days<=30; $days++){ ?>
							  <option value="<?php echo $days; ?>"><?php echo $days; ?> Dana</option>
							  <?php } ?>
				              </select>
				</td>
				<td  class="txt"> Od 1 do 30 dana samo</td>
				</tr>
				</table>
			</td>
        </tr>
		
		
		<tr>
	        <td class="txt1">
  			Discount Percentage<br/>[Procenat popusta]
		   	</td>
			<td  class="txt1"  style="width:350px;">
			<input type="text" name="lastminute_discount_rate" class="fields" id="lastminute_discount_rate" value="" />% 
			</td>
        </tr>
		
		<tr>
	        <td class="txt1">
  			Refundable<br/>[povratni]
		   	</td>
			<td>
			<div class="fields_checked">
			<input type="radio" name="lmin_refundable" id="refundable_yes" checked="checked" value="1" ><span>Da</span>
			<input type="radio" name="lmin_refundable"  id="refundable_no" value="0" ><span> Ne</span>
			</div>
			</td>
        </tr>
		</table>
		</div>
		</td></tr>
		
		<tr><td colspan="2">
			 	<hr/>
			 </td>
			 </tr>
		<tr><td><h3> Long Stay<br/>[Dugi boravak]</h3></td>
		<td>
	   <div class="fields_checked">
				<input type="radio" name="long_stay" id="long_stay_yes" checked="checked" value="1" onClick="jQuery('#lastmindiv2').show('slow');" ><span> Da</span>
				<input type="radio" name="long_stay"  id="long_stay_no" value="0" onClick="jQuery('#lastmindiv2').hide('slow');" ><span> Ne</span>
		</div></td>
		</tr>	
		
		<tr>
		<td colspan="2">
		<div id="lastmindiv2">
		<table cellpadding="1" cellspacing="1" border="0" >	
		
		<tr>
	        <td class="txt1">
  			Threshold<br/>[Uslov]
		   	</td>
			<td>
			<input type="text" name="threshold_last_minute1" class="fields" id="threshold_last_minute1" value="" />
			</td>
        </tr>
		
		
		<tr>
	        <td class="txt1">
  			Discount Percentage<br/>[Procenat popusta]
		   	</td>
			<td class="txt1"  style="width:350px;">
			<input type="text" name="lmin_discount_percentage1" class="fields" id="lmin_discount_percentage1" value="" /> % 
			</td>
        </tr>
		
		<tr>
	        <td class="txt1">
  			Refundable<br/>[povratni]
		   	</td>
			<td>
			<div class="fields_checked">
			<input type="radio" name="lmin_refundable1" id="lmin_refundable1" checked="checked" value="1" ><span>Da</span>
			<input type="radio" name="lmin_refundable1"  id="lmin_refundable1" value="0" ><span> Ne</span>
			</div>
			</td>
        </tr>
		</table></div></td></tr>
		
 		 <tr>           
              <td colspan="2"><!--<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Discount" class="button" />-->
              <a href="javascript:" style="margin:5px; width:112px; float:none; text-align:center;" name="submit" id="submit" class="button" onclick="add_discount_manag()">Add Discount &nbsp;[Dodaj popust]</a>
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="discount_management" />
          <input type="hidden" name="request_page" value="manage_discount_management" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div></td>
  </tr>
	<form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    <td colspan="2">
    	<?php  if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>       
        <tr>                
        <?php                                 
        //Dropdown List    
         $offline_qry = "SELECT ".$tblprefix."users.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";            
         $rs_offline = $db->Execute($offline_qry);           
        ?>
        
            <td width="30%" class="tabheading">Select PMs:</td>
            <td width="70%" align="center">
            <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_discount('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_discount.php"?>')">
            
                <option value="0">Izaberite vlasnika objekta</option>
                <?php
                    while(!$rs_offline->EOF){?>
                    <option value="<?php echo $rs_offline->fields['id'];?>"><?php echo $rs_offline->fields['first_name'].' '.$rs_offline->fields['last_name'];  ?></option>
                    
                    <?php
                    $rs_offline->MoveNext();
                    }?>	
                    	
            </select><br />
            </td>
         </tr>
         
        <?php  }else{	        
			$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
									AND  property_category=24 
									AND  pm_type=1";
			$rs_content = $db->Execute($qry_content);
			$count_add =  $rs_content->RecordCount();
		?>
        <tr>
            <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
            <td width="70%" align="center">
            <div id="property_id1">		
            <select name="property_id" class="fields" id="property_id" onChange="get_prop_room_discount('rooms_id1',this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_prop_room_discount.php"?>')">
            <?php
            if($count_add<=0){?>
            <option value="0">Izaberite objekat</option>
            <?php
            }else{?>
            <option value="0">Izaberite objekat</option>	
                <?php while(!$rs_content->EOF){
            ?>
            <option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
                <?php $rs_content->MoveNext();
                }
                }
            ?>
            </select>	
    		</div>
            </td>
        </tr> 
       <?php } ?>  
       
       <?php if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>
       <tr>
            <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
            <td width="70%" align="center">
            <div id="property_id1">           
                <select name="property_id" id="property_id" class="fields"  />
                    <option value="0">Izaberite objekat</option>
                </select>            
            </div>
            </td>
        </tr>
       <?php } ?>
        <tr>
				<td width="20%" class="tabheading">Select Room Name<br/>[Izaberite sobu]</td>
				<td width="60%" align="center">
                <div id="rooms_id1">
			    <select name="room_id" id="room_id" class="fields"  />
					<option value="0">Izaberite sobu</option>
				</select>
				</div>
                </td>
		    </tr>     
	</form>
    </td>
 </table>

<div id="get_prop_room_discount"></div>
<?php
// code for when click on edit button toggle window will open , actually that is use for inserting category 
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

<script type="text/javascript">

function add_discount_manag(){ 

    var validation_flag= true;

	with (document.managecontentfrm){ 		
		
		
				
		if(pm_id.value=="0"){
			alert("Please Enter Property Manager");
			pm_id.focus();
			validation_flag= false;
		}
		
		if(property_name.value=="0"){
			alert("Please Enter Property Name");
			property_name.focus();
			validation_flag= false;
		}	
		
		if(room_type.value=="0"){
			alert("Please Enter Room Type");
			room_type.focus();
			validation_flag= false;			
		}	
		
		
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
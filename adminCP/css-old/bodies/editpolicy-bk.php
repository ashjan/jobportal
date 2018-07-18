<script language="javascript">
 var imagePath='<?php MYSURL ?>graphics/';
  var ie=document.all;
  var dom=document.getElementById;
  var ns4=document.layers;
  var bShow=false;
  var textCtl;
  function setTimePicker(t) {
    textCtl.value=t;
    closeTimePicker();
  }

  function refreshTimePicker(mode) {
    
    if (mode==0)
      { 
        suffix="AM"; 
      }
    else
      { 
        suffix="PM"; 
      }

    sHTML = "<table><tr><td><table cellpadding=3 cellspacing=0 bgcolor='#f0f0f0'>";
    for (i=0;i<12;i++) {

      sHTML+="<tr align=right style='font-family:verdana;font-size:11px;color:#000000;'>";

      if (i==0) {
        hr = 12;
      }
      else {
        hr=i;
      }  

      for (j=0;j<4;j++) {
        sHTML+="<td width=57 style='cursor:hand;font-family:verdana;font-size:11px;' onmouseover='this.style.backgroundColor=\"#66CCFF\"' onmouseout='this.style.backgroundColor=\"\"' onclick='setTimePicker(\""+
        hr + ":" + padZero(j*15) + "&nbsp;" + suffix 
        + "\")'><a style='text-decoration:none;color:#000000' href='javascript:setTimePicker(\""+ hr + ":" + padZero(j*15) + "&nbsp;" + suffix + 
        "\")'>" + hr + ":"+padZero(j*15) +"&nbsp;"+ "<font color=\"#808080\">" + suffix + "&nbsp;</font></a></td>";
      }
      sHTML+="</tr>";
    }
    sHTML += "</table></td></tr></table>";
    document.getElementById("timePickerContent").innerHTML = sHTML;
  }

  if (dom){
    document.write ("<div id='timepicker' style='z-index:9;position:absolute;visibility:hidden;'><table style='border-width:3px;border-style:solid;border-color:#0033AA' bgcolor='#ffffff' cellpadding=0><tr bgcolor='#0033AA'><td><table cellpadding=0 cellspacing=0 width='100%' background='" + imagePath + "titleback.gif'><tr valign=bottom height=21><td style='font-family:verdana;font-size:11px;color:#ffffff;padding:3px' valign=center><B>&nbsp;Select&nbsp;Time </B></td><td><img id='iconAM' src='" + imagePath + "am1.gif' onclick='document.getElementById(\"iconAM\").src=\"" + imagePath + "am1.gif\";document.getElementById(\"iconPM\").src=\"" + imagePath + "pm2.gif\";refreshTimePicker(0)' style='cursor:hand'></td><td><img id='iconPM' src='" + imagePath + "pm2.gif' onclick='document.getElementById(\"iconAM\").src=\"" + imagePath + "am2.gif\";document.getElementById(\"iconPM\").src=\"" + imagePath + "pm1.gif\";refreshTimePicker(1)' style='cursor:hand'></td><td align=right valign=center>&nbsp;<img onclick='closeTimePicker()' src='" + imagePath + "close.gif'  STYLE='cursor:hand'>&nbsp;</td></tr></table></td></tr><tr><td colspan=2><span id='timePickerContent'></span></td></tr></table></div>");
    refreshTimePicker(0);
  }

  var crossobj=(dom)?document.getElementById("timepicker").style : ie? document.all.timepicker : document.timepicker;
  var currentCtl

  function selectTime(ctl,ctl2) {
    var leftpos=0
    var toppos=0

    textCtl=ctl2;
    currentCtl = ctl
    currentCtl.src=imagePath + "timepicker2.gif";

    aTag = ctl
    do {
      aTag = aTag.offsetParent;
      leftpos  += aTag.offsetLeft;
      toppos += aTag.offsetTop;
    } while(aTag.tagName!="BODY");
    crossobj.left =  ctl.offsetLeft  + leftpos 
    crossobj.top = ctl.offsetTop +  toppos + ctl.offsetHeight +  2 
    crossobj.visibility=(dom||ie)? "visible" : "show"
    hideElement( 'SELECT', document.getElementById("timepicker") );
    hideElement( 'APPLET', document.getElementById("timepicker") );      
    bShow = true;
  }

  // hides <select> and <applet> objects (for IE only)
  function hideElement( elmID, overDiv ){
    if( ie ){
      for( i = 0; i < document.all.tags( elmID ).length; i++ ){
        obj = document.all.tags( elmID )[i];
        if( !obj || !obj.offsetParent ){
            continue;
        }
          // Find the element's offsetTop and offsetLeft relative to the BODY tag.
          objLeft   = obj.offsetLeft;
          objTop    = obj.offsetTop;
          objParent = obj.offsetParent;
          while( objParent.tagName.toUpperCase() != "BODY" )
          {
          objLeft  += objParent.offsetLeft;
          objTop   += objParent.offsetTop;
          objParent = objParent.offsetParent;
          }
          objHeight = obj.offsetHeight;
          objWidth = obj.offsetWidth;
          if(( overDiv.offsetLeft + overDiv.offsetWidth ) <= objLeft );
          else if(( overDiv.offsetTop + overDiv.offsetHeight ) <= objTop );
          else if( overDiv.offsetTop >= ( objTop + objHeight + obj.height ));
          else if( overDiv.offsetLeft >= ( objLeft + objWidth ));
          else
          {
          obj.style.visibility = "hidden";
          }
      }
    }
  }
     
  //unhides <select> and <applet> objects (for IE only)
  function showElement( elmID ){
    if( ie ){
      for( i = 0; i < document.all.tags( elmID ).length; i++ ){
        obj = document.all.tags( elmID )[i];
        if( !obj || !obj.offsetParent ){
            continue;
        }
        obj.style.visibility = "";
      }
    }
  }

  
  
  
  function closeTimePicker() {
    crossobj.visibility="hidden"
    showElement( 'SELECT' );
    showElement( 'APPLET' );
    currentCtl.src=imagePath + "timepicker.gif"
  }
  
  
  
  

  document.onkeypress = function check_in_from() { 
    if (event.keyCode==27){
      if (!bShow){
        closeTimePicker();
      }
    }
  }



   document.onkeypress = function check_in_until() { 
    if (event.keyCode==27){
      if (!bShow){
        closeTimePicker();
      }
    }
  }
  
  
  
  
  document.onkeypress = function check_out_from() { 
    if (event.keyCode==27){
      if (!bShow){
        closeTimePicker();
      }
    }
  }
 
 
  
 document.onkeypress = function check_out_until() { 
    if (event.keyCode==27){
      if (!bShow){
        closeTimePicker();
      }
    }
  }
  
  
  
  
  
  function isDigit(c) {
    
    return ((c=='0')||(c=='1')||(c=='2')||(c=='3')||(c=='4')||(c=='5')||(c=='6')||(c=='7')||(c=='8')||(c=='9'))
  }

  function isNumeric(n) {
    
    num = parseInt(n,10);

    return !isNaN(num);
  }

  function padZero(n) {
    v="";
    if (n<10){ 
      return ('0'+n);
    }
    else
    {
      return n;
    }
  }

  function validateDatePicker(ctl) {

    t=ctl.value.toLowerCase();
    t=t.replace(" ","");
    t=t.replace(".",":");
    t=t.replace("-","");

    if ((isNumeric(t))&&(t.length==4))
    {
      t=t.charAt(0)+t.charAt(1)+":"+t.charAt(2)+t.charAt(3);
    }

    var t=new String(t);
    tl=t.length;

    if (tl==1 ) {
      if (isDigit(t)) {
        ctl.value=t+":00 am";
      }
      else {
        return false;
      }
    }
    else if (tl==2) {
      if (isNumeric(t)) {
        if (parseInt(t,10)<13){
          if (t.charAt(1)!=":") {
            ctl.value= t + ':00 am';
          } 
          else {
            ctl.value= t + '00 am';
          }
        }
        else if (parseInt(t,10)==24) {
          ctl.value= "0:00 am";
        }
        else if (parseInt(t,10)<24) {
          if (t.charAt(1)!=":") {
            ctl.value= (t-12) + ':00 pm';
          } 
          else {
            ctl.value= (t-12) + '00 pm';
          }
        }
        else if (parseInt(t,10)<=60) {
          ctl.value= '0:'+padZero(t)+' am';
        }
        else {
          ctl.value= '1:'+padZero(t%60)+' am';
        }
      }
      else
           {
        if ((t.charAt(0)==":")&&(isDigit(t.charAt(1)))) {
          ctl.value = "0:" + padZero(parseInt(t.charAt(1),10)) + " am";
        }
        else {
          return false;
        }
      }
    }
    else if (tl>=3) {

      var arr = t.split(":");
      if (t.indexOf(":") > 0)
      {
        hr=parseInt(arr[0],10);
        mn=parseInt(arr[1],10);

        if (t.indexOf("pm")>0) {
          mode="pm";
        }
        else {
          mode="am";
        }

        if (isNaN(hr)) {
          hr=0;
        } else {
          if (hr>24) {
            return false;
          }
          else if (hr==24) {
            mode="am";
            hr=0;
          }
          else if (hr>12) {
            mode="pm";
            hr-=12;
          }
        }
      
        if (isNaN(mn)) {
          mn=0;
        }
        else {
          if (mn>60) {
            mn=mn%60;
            hr+=1;
          }
        }
      } else {

        hr=parseInt(arr[0],10);

        if (isNaN(hr)) {
          hr=0;
        } else {
          if (hr>24) {
            return false;
          }
          else if (hr==24) {
            mode="am";
            hr=0;
          }
          else if (hr>12) {
            mode="pm";
            hr-=12;
          }
        }

        mn = 0;
      }
      
      if (hr==24) {
        hr=0;
        mode="am";
      }
      ctl.value=hr+":"+padZero(mn)+" "+mode;
    }
  }
</script>
<?php
$id = base64_decode($_GET['id']);



$qry_limit = "SELECT * FROM ".$tblprefix."property_policy WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

//   List down all Projecties
 
$qry_property_name = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_type=1 AND property_category=24";
  
$rs_property_name = $db->Execute($qry_property_name);
$count_property_name =  $rs_property_name->RecordCount();
$totalPM = $count_property_name;


//   List down all Project Manager


$qry_pm = "SELECT id,first_name FROM ".$tblprefix."property_manager" ;

$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;


$qry_pm2 = "SELECT id,first_name FROM ".$tblprefix."property_manager where id = ".$rs_limit->fields['pm_id'] ;

$rs_pm2 = $db->Execute($qry_pm2);
$count_pm2 =  $rs_pm2->RecordCount();
$totalPM2 = $count_pm2;

$qry_prop = "SELECT id,property_name,property_category FROM ".$tblprefix."properties where id = ".$rs_limit->fields['property_id']." 
				AND pm_type=1
			 	AND property_category=24";

$rs_prop = $db->Execute($qry_prop);
$count_prop =  $rs_prop->RecordCount();
$totalPM2 = $count_prop;

//Dropdown for parent 
$category_qry ="SELECT ".$tblprefix."property_manager.*,
   				   	   ".$tblprefix."properties.property_name ,
				       ".$tblprefix."properties.pm_type ,
				       ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_category = $db->Execute($category_qry);

if($rs_limit->fields['maximum_baby_cots'] == 0){
$display_cots = 'display:none';
}else {
$display_cots = 'display:block';
}

if($rs_limit->fields['maximum_extra_beds'] == 0){
$display_beds = 'display:none';
}else {
$display_beds = 'display:block';
}
$qry_services = "SELECT * FROM ".$tblprefix."property_free_services";
$rs_services = $db->Execute($qry_services);
 ?>


<!--form validation through javascript START--->
<script type="text/javascript">
$(document).ready(function() {
			$("#deposit_amount_percent").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
</script>
<!--form validation through javascript ENDS--->
   <table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Property Policy</td>
 	</tr>
 <?php if( isset($_REQUEST['okmsg']) || isset($_REQUEST['errmsg'])) {?>
<tr>
    <td colspan="8" align="center" <?php if(isset ($_REQUEST['okmsg'])) {?> class="okmsg" <?php } else { ?> class="errmsg" <?php }?> > <?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?>
	</td>
    </tr>
	<?php } ?>
	<tr>
		<td>
	
	<form name="managecontentfrm" action="admin.php?act=manage_property" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">				
<div class="border_div_categories" style="background-color: #E7DAE7; float:left; width:100%;"  align="center">				
<table cellpadding="1" cellspacing="1" border="0" >
				
					<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Property 
		   	</td>
        </tr>
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
		<tr>
				<td class="txt2">Select Property Manager:</td>
					<td>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_edit_policy_pro_nam('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_edit_policy_pro_nam.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>"
					<?php
					if($rs_category->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?></option>
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
					<td class="txt">Property Name</td>
					<td>               
			            <div id="property_name"> 
						 <select name="property_name" class="fields"   id="property_name">
						<?php 
						$qry_property = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
										 AND pm_type=1
										 AND property_category=24";
						
                        $rs_property = $db->Execute($qry_property);
						$count_property =  $rs_property->RecordCount();
						$totalproperty = $count_property;
						$rs_property->MoveFirst();
						while(!$rs_property->EOF){
						?>
						<option value="<?php echo $rs_property->fields['id'];?>" <?php if($rs_property->fields['id']==$rs_prop->fields['id']){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_property->fields['property_name']; ?></option>
						<?php
						$rs_property->MoveNext();
						} 
						 ?>
							
						 </select>
						</div> 				
				    </td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt">Property Name</td>
					<td>               
			            <div id="property_name"> 
						 <select name="property_name" class="fields"   id="property_id">
			<option value="<?php echo $rs_prop->fields['id']; ?>"><?php echo $rs_prop->fields['property_name']; ?></option>
						 </select>
						</div> 				
				    </td>
				</tr>
				<?php }?>
				
		<tr>
         
		 <tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Time Ranges
		   	</td>
        </tr>
		<tr>
	        <td class="txt">
  			Check In From *<br/>[Prijavljivanje od]
		   	</td>
			<td class="txt">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td style="width:100px;">
			<input type="text" name="check_in_from" class="smallestfields" id="check_in_from" value="<?php echo $rs_limit->fields['check_in_from']?>" />
			</td>
			<td style="width:100px;">
			<IMG SRC="<?php MYSURL?>graphics/timepicker.gif" BORDER="0" ALT="Pick a Time!" ONCLICK="selectTime(this,check_in_from)" STYLE="cursor:hand"/>
			</td>
			<td class="txt" style="width:140px;">
			Check In Untill<br/>[Prijavljivanje do]
			</td>
			<td style="width:100px;">
			<input type="text" name="check_in_until" class="smallestfields" id="check_in_until" value="<?php echo $rs_limit->fields['check_in_until']?>" />
			</td>
			<td style="width:100px;">
			<IMG SRC="<?php MYSURL?>graphics/timepicker.gif" BORDER="0" ALT="Pick a Time!" ONCLICK="selectTime(this,check_in_until)" STYLE="cursor:hand"/>
			</td>
			</tr>
			</table>
			</td>
        </tr>  
		<tr>
			<td class="txt" style="width:100px;">
  			Check Out From<br/>[Odjavljivanje od]
		   	</td>
		<td class="txt">	
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="txt" style="width:100px;">
			<input type="text" name="check_out_from" class="smallestfields" id="check_out_from" value="<?php echo $rs_limit->fields['check_out_from']?>" />
			</td>
			<td style="width:100px;" >
			<IMG SRC="<?php MYSURL?>graphics/timepicker.gif" BORDER="0" ALT="Pick a Time!" ONCLICK="selectTime(this,check_out_from)" STYLE="cursor:hand"/>
			</td>
		<td class="txt" style="width:140px;">	Check Out Untill </td>
		<td style="width:100px;">
			<input type="text" name="check_out_until" class="smallestfields" id="check_out_until" value="<?php echo $rs_limit->fields['check_out_until']?>" />
			</td>
			<td style="width:100px;">
			<IMG SRC="<?php MYSURL?>graphics/timepicker.gif" BORDER="0" ALT="Pick a Time!" ONCLICK="selectTime(this,check_out_until)" STYLE="cursor:hand"/>
			</td>
		</tr>
		</table>	
			</td>
        </tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
	   </tr>
		<tr>
	        <td class="txt">
		   	</td>
			<td>
			</td>
        </tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Child Policies
		   	</td>
        </tr>
		<tr>
			<td class="txt">Maximum Baby Cots</td>
			<td>
			<script language="javascript">
			<?php if($rs_limit->fields['maximum_baby_cots']>0){ ?>
			changeValue('maximum_baby_cots', 'baby_costs');
			<?php } ?>
			</script>
	<select name="maximum_baby_cots" class="fields" id="maximum_baby_cots" onchange="changeValue('maximum_baby_cots', 'baby_costs')">	
				 <?php for($i = 0;$i <=12; $i++){?>			   
				   <option value="<?php echo $i;?>" <?php if($i == $rs_limit->fields['maximum_baby_cots'])
				   {?> selected="selected" <?php }?>><?php echo ($i==0)?'No capacity for Baby Cots':$i;?></option>
					<?php } ?>
				 </select>				
		    </td>
		</tr>
		
		<tr>
			<td class="txt">Maximum Extra Beds</td>
		<td>
			     <select name="maximum_extra_beds" class="fields"   id="maximum_extra_beds" onchange="changeValue('maximum_extra_beds', 'extra_bed_charges_table')">
					 <?php for($i = 0;$i <=12; $i++){?>		
					 <option value="<?php echo $i;?>" <?php if($i == $rs_limit->fields['maximum_extra_beds']){?> selected="selected" <?php }?>><?php echo ($i==0)?'No extra beds ':$i;?></option>
					<?php } ?>
				 </select>				
		    </td>
		</tr>
		<tr>
	        <td colspan="2" class="txt">

 <table border="0" cellpadding="2" cellspacing="1" id="extra_beds" style=" <?php echo $display_beds; ?>">
	  <tr>
		
			       <td class="txt">Children Age For Free of Charge When Using Existing Beds </td>
                   <td width="51%" >
                 <select name="children_age_beds" class="fields">
				<?php for($i = 1;$i <=12; $i++){?>		
						   <?php if($i == $rs_limit->fields['children_age_beds']){ ?>
					<option value="<?php echo $i;?>" selected="selected" ><?php echo $i;?></option>	   
					<?php } else {?>
					 <option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }} ?>
                 </select>				
        </td>
        <td  width="15%" class="txt">(Years)</td>
		</tr>
	  <tr>	
	  <td  colspan="3" class="txt">
			
			<?php
			echo "<pre>"; 
			echo  "Extra Bed Charges".$rs_limit->fields['extra_bed_charges'];
			echo "</pre>";
			?>
			
			<table border="0" cellpadding="2" cellspacing="1" width="84%" id="extra_bed_charges_table" style="display:none;">
			<td class="txt">Extra Bed Charges
		   	</td>
			<td width="55%">
 <input type="text" name="extra_bed_charges" class="fields" id="extra_bed_charges" value="<?php echo $rs_limit->fields['extra_bed_charges']?>" />
			</td>
			<td class="txt" width="1%">EUR</td>
			</table>
			</td>
	 </tr>		
 </table>
 
 
 
		</td>
        </tr>
 <div id="children_age_beds">
		<tr>
			<td colspan="2" class="txt">
			<table border="0" cellpadding="2" cellspacing="1" id="baby_costs" >
                    <tr>
					<td class="txt">Children Age For free of charge when using Extra beds </td>
                    <td class="txt" width="66%">
                 <select name="children_age_beds" class="fields" >
                           <?php for($i = 0;$i <=12; $i++){?>		
						   <?php if($i == $rs_limit->fields['children_age_beds']){ ?>
					<option value="<?php echo $i;?>" selected="selected" ><?php echo $i;?></option>	   
					<?php } else {?>
					 <option value="<?php echo $i;?>" ><?php echo $i;?></option>
					<?php }} ?>
                 </select>				
				 (Years)
                    </td>
                 </tr>
                </table>
		    </td>
			
		</tr>
		</div>
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">Cancellation Policy</td>
		</tr>
		<tr><td class="txt">Cacellation Days</td>
			<td>
			<select name="cacellation_days" class="fields" id="cacellation_days">
			<?php for($i=1;$i<=12;$i++){?>
			<option value="<?php echo $i;?>"
			<?php if($i==$rs_limit->fields['cacellation_days']){?>selected="selected" <?php }?>>
			(<?php echo $i;?>) Days</option>
			<?php }?>
			
			</select>
			</td></tr>
		<tr><td class="txt">Cancellation Charges Percent</td>
			<td class="txt">
		<select name="cancellation_charges_percent" id="cancellation_charges_percent" class="fields">
		<option value="0">First night will be charged</option>
		<?php for($i = 10; $i <= 100; $i=$i+10){?>
		<option value="<?php echo $i; ?>" <?php if($i == $rs_limit->fields['cancellation_charges_percent']){?> selected="selected" <?php }?>><?php echo $i; ?></option>
		<?php }?>
		</select>
		%
			</td></tr>
			
			
			
			
			<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
			No Show Policy
			</td>
			</tr>
			
			
			<tr><td class="txt">No Show Policy</td>
			<td>
			<select name="no_show_policy" class="fields"   id="no_show_policy">
					<option value="1">First Night will be Charged</option>
					<option value="0">Total Price of the Reservation will be cCharged</option>
				 </select>
			</td></tr>
		
		
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Meal Plans 
		   	</td>
        </tr>
		<tr>
			<td class="txt">Break Fast</td>
			<td>
			     <select name="break_fast" class="fields" id="break_fast" onchange="changeValue('break_fast', 'mealplan_div')">
					<option 
					<?php
					if($rs_limit->fields['break_fast'] == '1')
					{
						echo 'selected="selected"';
					}
					?> 
					value="1">Yes</option>
					<option 
					<?php
					if($rs_limit->fields['break_fast'] == '0')
					{
						echo 'selected="selected"';
					}
					?> 
					value="0">No</option>
				 </select>		
		    </td>
		</tr>
		
		 <!-- Meal Plan-->
        <tr>
		<td colspan="2">
        <table  id="mealplan_div" name="mealplan_div" width="100%" cellpadding="0" cellspacing="2" border="0"   
		<?php if((isset($_SESSION['add_sees']['meal_plan']) and $_SESSION['add_sees']['meal_plan']!=0) or ($rs_limit->fields['break_fast'] == '1')){?> style="display:block" <?php }else{?> style="display:none;" <?php }?>>  
         
		<tr>
			<td style="width:259px;" class="txt">Meal Plan</td>
			<td >
			<select name="meal_plan" class="fields"   id="meal_plan">
				 	<option value="">Select Meal Plan</option>
					<option
					<?php
					if($rs_limit->fields['meal_plan'] == '0')
					{
						echo 'selected="selected"';
					}
					?> value="0">Any</option>
					<option value="1"
					<?php
					if($rs_limit->fields['meal_plan'] == '1')
					{
						echo 'selected="selected"';
					}
					?> 
					>English breakfast</option>
					<option value="2"
					<?php
					if($rs_limit->fields['meal_plan'] == '2')
					{
						echo 'selected="selected"';
					}
					?> 
					>buffet</option>
					<option value="3"
					<?php
					if($rs_limit->fields['meal_plan'] == '4')
					{
						echo 'selected="selected"';
					}
					?> 
					>continental</option>
			</select>
			     			
		    </td>
		</tr>
        </table>
        </td>
        </tr>
        
		<tr>
		    <td  style="text-align:left; font-weight:bold;" class="txt">
  			Free services
		   	</td>
		   	<td  class="txt">
		   	<?php
            $services = explode(',',$rs_limit->fields['free_service']);
            
		   	while(!$rs_services->EOF){
		   		
		   		?>
		<br /><input type="checkbox" name="free_services[]" id="free_services[]" value="<?php echo $rs_services->fields['id']?>"
		<?php if(in_array($rs_services->fields['id'],$services)){?> checked="checked"<?php } ?>
		>
		<?php echo $rs_services->fields['service_name']?>
		<?php $rs_services->MoveNext();}?>
		   	</td>
		</tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Credit Cards Policies
		   	</td>
        </tr>
		<tr>
			<td class="txt">Credit Card Accepted</td>
			<?php $explode_values=explode(',',$rs_limit->fields['credit_card_accepted']);

			?>
			<td class="txt">
	<input type="checkbox" name="credit_card_accepted[]" value="0" id="credit_card_accepted" onclick="return is_checked();" <?php //if($_SESSION['add_sees']['dont_accept_credit_card']==0){ echo 'checked="checked"';} 
	
	if(in_array(0,$explode_values)){
	?> checked="checked"<?php }?>/>Don't Accept Credit Card<br/>
	<div id="credit_card" style="display:block;">
	<input type="checkbox" name="credit_card_accepted[]" value="1" id="credit_card_accepted" <?php 
	if(in_array(1,$explode_values)){
	?> checked="checked"<?php }?>/>American Express<br/> 
	<input type="checkbox" name="credit_card_accepted[]" value="2" id="credit_card_accepted" <?php 
	if(in_array(2,$explode_values)){
	?> checked="checked"<?php }?> />Visa<br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="3" id="credit_card_accepted" <?php 
	if(in_array(3,$explode_values)){
	?> checked="checked"<?php }?>
	 >Euro And Master Card<br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="4" id="credit_card_accepted" <?php if(in_array(4,$explode_values)){
	?> checked="checked"<?php }?> />Diners Club<br/>
	<input type="checkbox" name="credit_card_accepted[]" value="5" id="credit_card_accepted" <?php if(in_array(5,$explode_values)){
	?> checked="checked"<?php }?>/>Maestro<br/> 		
	</div>
		    </td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Deposit Policies
		   	</td>
        </tr>
		<tr>
			<td class="txt">Pay Deposit</td>
			<td>
			     <select name="pay_deposit" class="fields"   id="pay_deposit">
					<option
					<?php if($rs_limit->fields['pay_deposit'] == '1'){echo 'selected="selected"';}?> 
					value="1">Yes</option>
					<option 
		<?php if($rs_limit->fields['pay_deposit'] == '0'){echo 'selected="selected"';}?> 
					value="0">No</option>
				 </select>				
		    </td>
		</tr>
		
		
		<tr>
	        <td class="txt">
  			Deposit Amount Percent
		   	</td>
			<td>
			<input type="text" name="deposit_amount_percent" class="fields" id="deposit_amount_percent" maxlength="2" value="<?php echo $rs_limit->fields['deposit_amount_percent']?>" /><span class="txt">(This is the percent amount of the total price)</span>
			</td>
			
        </tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Food & Beverage
		   	</td>
        </tr>
		
		<tr>
	        <td class="txt">
  			Food & Beverage
		   	</td>
			<td>
			<TEXTAREA name="food_beverage"  id="food_beverage" rows="4" cols="28"><?php echo $rs_limit->fields['food_beverage']?></TEXTAREA>
			</td>
        </tr>
		
		<tr>
	        <td class="txt">
  			Food & Beverage (Rus)
		   	</td>
			<td>
<?php  
$query ="SELECT * FROM `tbl_language_contents` WHERE `page_id` ='$id' AND language_id ='5' AND `fld_type` = 'policy_foods' AND `field_name`= 'food_beverage_rus'";
$result =mysql_fetch_object( mysql_query($query));	
			?>
			<TEXTAREA name="food_beverage_rus"  id="food_beverage_rus" rows="4" cols="28"><?php echo $result->translated_text;?></TEXTAREA>
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Hrana i pice
		   	</td>
			<td>
            <?php  
$query_mon ="SELECT * FROM `tbl_language_contents` WHERE `page_id` ='$id' AND language_id ='7' AND `fld_type` = 'policy_foods' AND `field_name`= 'food_beverage_mon'";
										$result_mon=mysql_fetch_object( mysql_query($query_mon));	
			?>
			<TEXTAREA name="food_beverage_mon"  id="food_beverage_mon" rows="4" cols="28"><?php echo $result_mon->translated_text;?></TEXTAREA>
			</td>
        </tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Inetrnet
		   	</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Available
		   	</td>
			<td>
			<select  class="fields" name="internet_available" id="internet_available">
				<option
				<?php
					if($rs_limit->fields['internet_available'] == '1')
					{
						echo 'selected="selected"';
					}
					?> 
				 value="1">Yes</option>
				<option
				<?php
					if($rs_limit->fields['internet_available'] == '0')
					{
						echo 'selected="selected"';
					}
					?>  value="0">No</option>
			</select>
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Type
		   	</td>
			<td>
			<input type="text" name="internet_type" class="fields" id="internet_type" value="<?php echo $rs_limit->fields['internet_type']?>" />
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Cost
		   	</td>
			<td>
			<input type="text" name="internet_cost" class="fields" id="internet_cost" value="<?php echo $rs_limit->fields['internet_cost']?>"  />
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Location
		   	</td>
			<td>
			<input type="text" name="internet_location" class="fields" id="internet_location" value="<?php echo $rs_limit->fields['internet_location']?>" />
			</td>
        </tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Parking
		   	</td>
        </tr>
		<tr>
			<td class="txt">Parking Available</td>
			<td>
			     <select name="parking_available" class="fields" id="parking_available">
					<option 
					<?php
					if($rs_limit->fields['parking_available'] == '1')
					{
						echo 'selected="selected"';
					}
					?> 	
					 value="1">Yes</option>
					<option
					<?php
					if($rs_limit->fields['parking_available'] == '0')
					{
						echo 'selected="selected"';
					}
					?> 
					 value="0">No</option>
				 </select>				
		    </td>
		</tr>
		
		<tr>
	        <td class="txt">
  			Parking Place 
		   	</td>
			<td>
			<input type="text" name="parking_place" class="fields" id="parking_place" value="<?php echo $rs_limit->fields['parking_place']?>" />
			</td>
        </tr>
		
		<tr>
	        <td class="txt">
  			Parking Costs 
		   	</td>
			<td>
			<input type="text" name="parking_costs" class="fields" id="parking_costs" value="<?php echo $rs_limit->fields['parking_costs']?>" />
			</td>
        </tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Pets
		   	</td>
        </tr>
		<tr>
			<td class="txt">Pets Allowed</td>
			<td>
			     <select name="pets_allowed" class="fields" id="pets_allowed">
					<option
					<?php
					if($rs_limit->fields['pets_allowed'] == '1')
					{
						echo 'selected="selected"';
					}
					?> 
					 value="1">Yes</option>
					<option
					<?php
					if($rs_limit->fields['pets_allowed'] == '0')
					{
						echo 'selected="selected"';
					}
					?> 
					 value="0">No</option>
				 </select>				
		    </td>
		</tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Important Notice
		   	</td>
        </tr>
		<tr>
	        <td class="txt">
  			Important Notice 
		   	</td>
			<td>
<TEXTAREA name="important_notice" id="important_notice" rows="4" cols="28"><?php echo $rs_limit->fields['important_notice']?></TEXTAREA>
			</td>
        </tr>

</table>
</div>

<div class="border_div_categories" style=" background-color: #E7DAE7; float:left; width:100%;"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td>
<input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update Policy" class="button"/>
		</td>
		</tr>
		</table>
</div>
        <tr>
		<td>&nbsp;</td>
		<td>
		<input type="hidden" name="mode" value="update"/>
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>"/>
		<input type="hidden" name="act" value="manage_property_policy"/>
		<input type="hidden" name="act2" value="manage_property_policy"/>
		<input type="hidden" name="request_page" value="policy_management"/>
		</td>
		</tr>
<script language="javascript">
			<?php if($rs_limit->fields['maximum_extra_beds']>0){
			?>
			changeValue('maximum_extra_beds', 'extra_bed_charges_table');
			<?php 
			} ?>
</script>

</form>
  
		</td>
	</tr>
</table>

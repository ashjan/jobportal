<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
		
	
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE pp.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND pr.pm_type=0';
	}else{
		$module_pm_where = 'WHERE pr.pm_type=0';
	}	
	
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
$qry_policy = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.id as prid,pr.property_name
			   FROM `".$tblprefix."property_policy` as pp LEFT JOIN ".$tblprefix."properties as pr ON pr.id=pp.property_id LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id $module_pm_where ";
			   
$rs_policy = $db->Execute($qry_policy);
$count_add =  $rs_policy->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name, pr.id as prid,pr.property_name
				   FROM `".$tblprefix."property_policy` as pp 
				   LEFT JOIN ".$tblprefix."properties as pr ON pr.id=pp.property_id
				   LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id
				    $module_pm_where 
					ORDER BY property_name ASC  
				   LIMIT $startRow,$maxRows";
		
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//   List down all Projecties

$qry_property_name = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_type=0" ;

$rs_property_name = $db->Execute($qry_property_name);
$count_property_name =  $rs_property_name->RecordCount();
$totalPM = $count_property_name;

$qry_services = "SELECT * FROM ".$tblprefix."property_free_services";
$rs_services = $db->Execute($qry_services);

//   List down all Project Manager


$qry_pm = "SELECT id,first_name,last_name FROM ".$tblprefix."property_manager" ;
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;


?>
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

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Property Policy</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Property Policy Found: <?php echo $totalcountalpha; ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
	<?php
	if(isset($_SESSION['add_sees'])){
	?>
	<div style="background-color:#E7DAE7;">
	<?php 
	}else{ 
	?>
	<div id="controls" class="add_subscriber" >
	<?php
	}
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
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">				
<div class="border_div_categories"  align="center">				
<table cellpadding="1" cellspacing="1" border="0" >
				<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Property 
		   	</td>
        </tr>
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
		<tr>
		<td class="txt" width="35%">Property Manager</td>
		<td width="65%">
		<select name="first_name" class="fields" id="first_name"  onchange="get_prop_name3('property_name', this.value, '<?php echo MYSURL.							  		"ajaxresponse/get_prop_name3_3.php"?>')">
		<option value="0">Select Project Manager First</option>
		<?php 
    	while(!$rs_pm->EOF){?>
		<option value="<?php echo $rs_pm->fields['id']; ?>" <?php if(!empty($_SESSION['add_sees']['first_name'])){
		if($_SESSION['add_sees']['first_name']==$rs_pm->fields['id']){
		echo "selected='selected'";
		}
		}?>><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
		<?php 
		$rs_pm->MoveNext();
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
				<select name="property_name" class="fields"   id="property_name">
						<option value="0">Izaberite objekat</option>
						<?php 
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=0';
						$rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($_SESSION['add_sees']['property_name']==					 						$rs_prop->fields[id]){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->fields['property_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						 ?>
						</select>
				</td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt">Property Name</td>
					<td>               
			            <div id="property_name"> 
						<select name="property_name" class="fields"   id="property_id">
						<option value="0">Izaberite objekat</option>
						<?php if (!empty($_SESSION['add_sees']['property_name'])){
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION['add_sees']['first_name'].'';
                        $rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($_SESSION['add_sees']['property_name']==$rs_prop->fields[id]){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->fields['property_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						} ?>
						</select>
						</div> 				
				    </td>
				</tr>
				<?php } ?>
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
			<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Time Ranges
		   	</td>
        </tr>
		<tr>
	        <td class="txt">
  			Check In From *
		   	</td>
			<td class="txt">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td style="width:100px;">
			<input type="text" name="check_in_from" class="smallestfields" id="check_in_from" 
			value="<?php if (!empty($_SESSION['add_sees']['check_in_from'])){ echo $_SESSION['add_sees']['check_in_from']; }?>"/>
			</td>
			<td style="width:100px;">
			<IMG SRC="<?php MYSURL?>graphics/timepicker.gif" BORDER="0" ALT="Pick a Time!" ONCLICK="selectTime(this,check_in_from)" STYLE="cursor:hand"/>
			</td>
			<td class="txt" style="width:140px;">
			Check In Untill
			</td>
			<td style="width:100px;">
			<input type="text" name="check_in_until" class="smallestfields" id="check_in_until" 
			value="<?php if (!empty($_SESSION['add_sees']['check_in_until'])){ echo $_SESSION['add_sees']['check_in_until']; }?>" />
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
  			Check Out From
		   	</td>
		<td class="txt">	
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td class="txt" style="width:100px;">
			<input type="text" name="check_out_from" class="smallestfields" id="check_out_from" 
			value="<?php if (!empty($_SESSION['add_sees']['check_out_from'])){ echo $_SESSION['add_sees']['check_out_from']; }?>" />
			</td>
			<td style="width:100px;" >
			<IMG SRC="<?php MYSURL?>graphics/timepicker.gif" BORDER="0" ALT="Pick a Time!" ONCLICK="selectTime(this,check_out_from)" STYLE="cursor:hand"/>
			</td>
		<td class="txt" style="width:140px;">	Check Out Untill </td>
		<td style="width:100px;">
			<input type="text" name="check_out_until" class="smallestfields" id="check_out_until" 
			value="<?php if (!empty($_SESSION['add_sees']['check_out_until'])){ echo $_SESSION['add_sees']['check_out_until']; }?>" />
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
		
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Child Policies
		   	</td>
        </tr>
	
		<tr>
			<td class="txt">Maximum Baby Cots</td>
			<td>
			     <select name="maximum_baby_cots" class="fields"   id="maximum_baby_cots" onchange="changeValue('maximum_baby_cots', 'baby_costs')">
					<option value="0">No capacity for Baby Cots</option>
					<?php  for($i=1; $i<=12; $i++){
					?>
					<option <?php if(!empty($_SESSION['add_sees']['maximum_baby_cots'])){
					if($_SESSION['add_sees']['maximum_baby_cots']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				  <?php	} ?>
				 </select>				
		    </td>
		</tr>
		
		<tr>
			<td class="txt">Maximum Extra Beds</td>
			<td>
			     <select name="maximum_extra_beds" class="fields"   id="maximum_extra_beds" onchange="changeValue('maximum_extra_beds', 'extra_beds');">
					<option value="0">No Extra Beds</option>
					<?php  for($i=1; $i<=12; $i++){
					?>
					<option value="<?php echo $i; ?>"  <?php if(!empty($_SESSION['add_sees']['maximum_extra_beds'])){
					if($_SESSION['add_sees']['maximum_extra_beds']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>  ><?php echo $i; ?></option>
					<?php  } ?>
				 </select>				
		    </td>
		</tr>
		
		<tr>
			<td colspan="2" class="txt">
				<table border="0" cellpadding="2" cellspacing="1" id="baby_costs" <?php if(isset($_SESSION['add_sees']['children_age']) and $_SESSION['add_sees']['maximum_baby_cots']!=0){?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }?> width="84%">
                    <td width="30%"  class="txt">Children Age For Free of Charge When Using Baby Cots </td>
                    <td width="32%" >
                    <select name="children_age" class="fields"   id="children_age">
					<?php  for($i=1; $i<=12; $i++){?>
					<option value="<?php echo $i; ?>"  <?php if(!empty($_SESSION['add_sees']['children_age'])){
					if($_SESSION['add_sees']['children_age']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>  ><?php echo $i; ?></option>
					<?php  } ?>
                    </select>				
                    </td>
                    <td  width="10%"  class="txt">(Years)</td>
                </table>
            </td>
        </tr>		
	
	
	
	    <tr>
		<td colspan="2" class="txt">
				<table border="0" cellpadding="2" cellspacing="1" width="84%" >
			       
				   <td width="30%" class="txt">Children Age For Free of Charge When Using Existing Beds </td>
                   <td width="32%" >
                 <select name="children_age_beds" class="fields">
				<?php  for($i=1; $i<=12; $i++){?>
					<option value="<?php echo $i; ?>"  <?php if(!empty($_SESSION['add_sees']['children_age_beds'])){
					if($_SESSION['add_sees']['children_age_beds']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?> ><?php echo $i; ?></option>
					<?php } ?>
                 </select>				
        </td>
        <td  width="10%" class="txt">(Years)</td>
		</tr>
		
		
		<tr>
	        <td  colspan="3" class="txt">
			<table border="0" cellpadding="2" cellspacing="1" width="84%" id="extra_beds" <?php if(isset($_SESSION['add_sees']['extra_bed_charges'])and $_SESSION['add_sees']['maximum_extra_beds']!=0){?> style="display:block;"<?php }else{?> style="display:none;" <?php }?>>
  			<td width="36%" class="txt">Extra Bed Charges
		   	</td>
			<td width="32%">
<input type="text" name="extra_bed_charges" class="fields" id="extra_bed_charges" 
 value="<?php if(!empty($_SESSION['add_sees']['extra_bed_charges'])){ echo $_SESSION['add_sees']['extra_bed_charges'];} ?>" />
			</td>
			<td  width="1%">
			EUR
			</td>
			</tr>
			</table>
			</td>
        </tr> 
					 		   
			    </table>
            </td>
        </tr>
		
	   
	   
	   
<!--		<tr><td class="txt">First Night Charge </td>
			<td><select name="first_night_charge" class="fields"   id="first_night_charge">
					<option value="1">Yes</option>
					<option value="0">No</option>
				 </select>
			</td>
		</tr>
-->		
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		
		<!--<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">Cancellation Policy</td>
		</tr>
		<tr><td class="txt">Cacellation Days</td>
			<td>
			<select name="cacellation_days" class="fields" id="cacellation_days">
			<?php for($i = 1; $i <=12; $i++){?>
		<option value="<?php echo $i; ?>"
		<?php if(!empty($_SESSION['add_sees']['cacellation_days'])){
					if($_SESSION['add_sees']['cacellation_days']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>
		><?php echo '('.$i.')'.Days; ?></option>
		<?php }?>

			</select>
			</td></tr>
		<tr><td class="txt">Cancellation Charges Percent</td>
		<td>
		<select name="cancellation_charges_percent" id="cancellation_charges_percent" class="fields">
		
		<option value="0">First night will be charged</option>
		<?php for($i = 10; $i <= 100; $i=$i+10){?>
		<option 
		<?php if(!empty($_SESSION['add_sees']['cancellation_charges_percent'])){
					if($_SESSION['add_sees']['cancellation_charges_percent']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>
		
		value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php }?>
		</select>
		%
		</td></tr>
			
			<tr>
			<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
			No Show Policy
			</td>
			</tr>
			<tr><td class="txt">
			No Show Policy
			</td>
			<td>
			<select name="no_show_policy" class="fields"   id="no_show_policy">
			<option 
			<?php if(!empty($_SESSION['add_sees']['no_show_policy'])){ 
				if($_SESSION['add_sees']['no_show_policy']==1){ echo 'selected="selected"';}
				} ?>
			
			value="1">First night will be charged</option>
			<option 
			<?php if(!empty($_SESSION['add_sees']['no_show_policy'])){ 
				if($_SESSION['add_sees']['no_show_policy']==0){ echo 'selected="selected"';}
				} ?>
			value="0">Total price of the reservation will be charged</option>
			</select>
			</td></tr>
		-->
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Meal Plans 
		   	</td>
        </tr>
		<tr>
			<td class="txt">Break Fast</td>
			<td>
			     <select name="break_fast" class="fields" id="break_fast">
					<option 
					<?php 
				/*if(!empty($_SESSION['add_sees']['break_fast'])){ */
				if($_SESSION['add_sees']['break_fast']==1){ echo 'selected="selected"';}
				/*}*/ ?> value="1">Yes</option>
					<option 
					<?php /*if(!empty($_SESSION['add_sees']['break_fast'])){ */
				if($_SESSION['add_sees']['break_fast']==0){ echo 'selected="selected"';}
				/*}*/ ?> 
					value="0">No</option>
				 </select>				
		    </td>
		</tr>
		<tr>
			<td class="txt">Meal Plan</td>
			<td>
			     <select name="meal_plan" class="fields"   id="meal_plan">
				 	<option value="">Select Meal Plan</option>
					<option 
					
					<?php 
				if($_SESSION['add_sees']['meal_plan']==0){ echo 'selected="selected"';}
				?> value="0">Any</option>
					<option value="1" <?php 
				if($_SESSION['add_sees']['meal_plan']==1){ echo 'selected="selected"';}
				 ?>>English breakfast</option><option value="2"
				<?php  
				if($_SESSION['add_sees']['meal_plan']==2){ echo 'selected="selected"';}
				 ?>>buffet</option>
					<option value="3" <?php  
				if($_SESSION['add_sees']['meal_plan']==3){ echo 'selected="selected"';}
				 ?>>continental</option>
				 </select>				
		    </td>
		</tr>
		
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<!--<tr>
		<td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;font-weight:bold;">
		Property Free Services
		</td>
		<td class="txt">
		<?php 
		
		/*if($rs_limit->fields['free_service']==NULL or $rs_limit->fields['free_service']=''){
		}else{
		
		$free_service=explode(',',$rs_limit->fields['free_service']);
		}
		foreach($free_service as $i){
		echo $i;
		}
		while(!$rs_services->EOF){*/?>
		<br /><input type="checkbox" name="free_services[]" id="free_services[]" value="<?php /*echo $rs_services->fields['id'];*/?>">
		<?php /* echo $rs_services->fields['service_name'];*/?>
		<?php  /*$rs_services->MoveNext();}*/?>
		</td>
		</tr>-->
		
			<tr>
		<td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;font-weight:bold;">
		Property Free Services
		</td>
		<td class="txt">
		
		<?php while(!$rs_services->EOF){?>
		<br /><input type="checkbox" name="free_services[]" id="free_services[]" value="<?php echo $rs_services->fields['id']?>" <?php 
		if(isset($_SESSION['add_sees']['free_services'])){
		if(in_array($rs_services->fields['id'],$_SESSION['add_sees']['free_services'])){echo 'checked="checked"';} }?>>
		<?php echo $rs_services->fields['service_name']?>
		<?php $rs_services->MoveNext();
		}
		
		?>
		</td>
		</tr>
		
		
		
		
		<tr><td>&nbsp;&nbsp;</td></tr>
		<tr>
	        <td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;">
  			Credit Cards Policies
		   	</td>
			<td class="txt">
			<?php
		if(isset($_SESSION['add_sees']['credit_card_accepted']) and in_array(0,$_SESSION['add_sees']['credit_card_accepted']))
		
		{
			$display = "none";
		}else{
			$display = "block";
		}
	?>
	
	<input type="checkbox" name="credit_card_accepted[]" value="0" id="credit_card_accepted" onclick="return is_checked();" <?php 
		
	 //if($_SESSION['add_sees']['dont_accept_credit_card']==0){ echo 'checked="Yes"';} ?> <?php if(isset($_SESSION['add_sees']['credit_card_accepted'])){ 
	if(in_array(0,$_SESSION['add_sees']['credit_card_accepted'])){echo 'checked="checked"';}
	}?>/>Don't Accept Credit Card<br/>
	<div id="credit_card" style="display:<?php echo $display;?>;">
	<input type="checkbox" name="credit_card_accepted[]" value="1" id="credit_card_accepted" <?php if(isset($_SESSION['add_sees']['credit_card_accepted'])){ 
if (in_array(1, $_SESSION['add_sees']['credit_card_accepted'])) { echo 'checked="checked"';}
	}
	
	//if($_SESSION['add_sees']['american_express']==1){ echo 'checked="Yes"';} ?>/>American Express<br/> 
	<input type="checkbox" name="credit_card_accepted[]" value="2" id="credit_card_accepted" <?php  if(isset($_SESSION['add_sees']['credit_card_accepted'])){ 
	if (in_array(2, $_SESSION['add_sees']['credit_card_accepted']))  { echo 'checked="checked"';}}
	//if($_SESSION['add_sees']['visa']==2){ echo 'checked="Yes"';} ?> />Visa<br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="3" id="credit_card_accepted" <?php  if(isset($_SESSION['add_sees']['credit_card_accepted'])){
	if (in_array(3, $_SESSION['add_sees']['credit_card_accepted']))  { echo 'checked="checked"';} }
	//if($_SESSION['add_sees']['euro_master_card']==3){ echo 'checked="Yes"';} ?>/>Euro And Master Card<br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="4" id="credit_card_accepted" <?php 
	
	 if(isset($_SESSION['add_sees']['credit_card_accepted'])){
	if (in_array(4, $_SESSION['add_sees']['credit_card_accepted']))  { echo 'checked="checked"';} }
	//if($_SESSION['add_sees']['diners_club']==4){ echo 'checked="Yes"';} ?> />Diners Club<br/>
	<input type="checkbox" name="credit_card_accepted[]" value="5" id="credit_card_accepted" <?php  if(isset($_SESSION['add_sees']['credit_card_accepted'])){
	if (in_array(5, $_SESSION['add_sees']['credit_card_accepted'])) { echo 'checked="checked"';}}

	
	
	//if($_SESSION['add_sees']['maestro']==5){ echo 'checked="Yes"';} ?>/>Maestro<br/> 		
	</div>
		    </td>
		</tr>
		
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
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
					<?php if(!empty($_SESSION['add_sees']['pay_deposit'])){ 
				if($_SESSION['add_sees']['pay_deposit']==1){ echo 'selected="selected"';}
				} ?>
					value="1">Yes</option>
					<option 
					<?php if(!empty($_SESSION['add_sees']['pay_deposit'])){ 
				if($_SESSION['add_sees']['pay_deposit']==0){ echo 'selected="selected"';}
				} ?>
					 value="0">No</option>
				 </select>				
		    </td>
		</tr>
		<tr>
	        <td class="txt">
  			Deposit Amount Percent
		   	</td>
			<td>
			<input type="text" name="deposit_amount_percent" class="fields" id="deposit_amount_percent" 
			value="<?php if(!empty($_SESSION['add_sees']['deposit_amount_percent'])){ echo $_SESSION['add_sees']['deposit_amount_percent'];} ?>" maxlength="2"/>
			
			<span class="txt">(This is the percent amount of the total price)</span></td>
        </tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Food & Beverage
		   	</td>
        </tr>
		<tr>
	        <td class="txt">
  			Food Beverage
		   	</td>
			<td>
			<TEXTAREA name="food_beverage"  id="food_beverage"   rows="4" cols="28"><?php if(!empty($_SESSION['add_sees']['food_beverage'])){ echo $_SESSION['add_sees']['food_beverage'];} ?></TEXTAREA>
			</td>
        </tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Internet
		   	</td>
        </tr>
		<tr>
		<tr>
	        <td class="txt">
  			Internet Available
		   	</td>
			<td>
			<select name="internet_available" id="internet_available">
				

				<option
				<?php /*if(!empty($_SESSION['add_sees']['internet_available'])){ */
				if($_SESSION['add_sees']['internet_available']==1){ echo 'selected="selected"';}
				/*}*/ ?> value="1">Yes</option>
				<option 
				<?php /*if(!empty($_SESSION['add_sees']['internet_available'])){ */
				if($_SESSION['add_sees']['internet_available']==0){ echo 'selected="selected"';}
				/*}*/ ?> value="0">No</option>
			</select>
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Type
		   	</td>
			<td>
			<input type="text" name="internet_type" class="fields" id="internet_type" 
			value="<?php if(!empty($_SESSION['add_sees']['internet_type'])){ echo $_SESSION['add_sees']['internet_type'];} ?>" 
			/>
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Cost
		   	</td>
			<td>
			<input type="text" name="internet_cost" class="fields" id="internet_cost" 
			value="<?php if(!empty($_SESSION['add_sees']['internet_cost'])){ echo $_SESSION['add_sees']['internet_cost'];} ?>" />
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			Internet Location
		   	</td>
			<td>
			<input type="text" name="internet_location" class="fields" id="internet_location" 
			value="<?php if(!empty($_SESSION['add_sees']['internet_location'])){ echo $_SESSION['add_sees']['internet_location'];} ?>" />
			</td>
        </tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Parking
		   	</td>
        </tr>
		<tr>
			<td class="txt">Parking Available</td>
			<td>
			     <select name="parking_available" class="fields"   id="parking_available">
					<option 
					<?php /*if(!empty($_SESSION['add_sees']['parking_available'])){ */
				if($_SESSION['add_sees']['parking_available']==1){ echo 'selected="selected"';}
				/*}*/ ?>
					
					value="1">Yes</option>
					<option 
					<?php /*if(!empty($_SESSION['add_sees']['parking_available'])){ */
				if($_SESSION['add_sees']['parking_available']==0){ echo 'selected="selected"';}
				/*}*/ ?>
					value="0">No</option>
				 </select>				
		    </td>
		</tr>
		
		<tr>
	        <td class="txt">
  			Parking Place 
		   	</td>
			<td>
			<input type="text" name="parking_place"  id="parking_place" 
			value="<?php if(!empty($_SESSION['add_sees']['parking_place'])){ 
				echo $_SESSION['add_sees']['parking_place'];
				} ?>" />
			</td>
        </tr>
		
		<tr>
	        <td class="txt">
  			Parking Costs 
		   	</td>
			<td>
			<input type="text" name="parking_costs" class="fields" id="parking_costs" value="<?php if(!empty($_SESSION['add_sees']['parking_place'])){ 
				echo $_SESSION['add_sees']['parking_costs'];
				} ?>" />
			</td>
        </tr>
		
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Pets
		   	</td>
        </tr>
		<tr>
			<td class="txt">Pets Allowed</td>
			<td>
			     <select name="pets_allowed" class="fields"   id="pets_allowed">
					<option 
					<?php /*if(!empty($_SESSION['add_sees']['pets_allowed'])){ */
				if($_SESSION['add_sees']['pets_allowed']==1){ echo 'selected="selected"';}
				/*}*/ ?>
					
					 value="1">Yes</option>
					<option 
					
					<?php /*if(!empty($_SESSION['add_sees']['pets_allowed'])){ */
				if($_SESSION['add_sees']['pets_allowed']==0){ echo 'selected="selected"';}
				/*} */?>
					value="0">No</option>
				 </select>				
		    </td>
		</tr>
		
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Important Notices
		   	</td>
        </tr>
		
		
		
		
		
		<tr>
	        <td class="txt">
  			Important Notice 
		   	</td>
			<td>
			<TEXTAREA name="important_notice" id="important_notice" value="" rows="4" cols="28"><?php if(!empty($_SESSION['add_sees']['important_notice'])){ echo $_SESSION['add_sees']['important_notice'];} ?></TEXTAREA>
			</td>
        </tr>
		
		
		
		
		
		
		
		   
</table>
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Dodaj politiku objekta" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="<?=$_GET['act']?>">
		<input type="hidden" name="act2" value="<?=$_GET['act']?>">
		<input type="hidden" name="request_page" value="policy_management_1" />
					</td>
				</tr>
</form> 

  </div>  
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
                <td width="4%">Property Name</td>
				<td width="4%">PM Name</td>
				<td width="4%">Check In From</td>
				<td width="4%">Check In Untill</td>
				<td width="4%">Check Out From</td>
				<td width="4%">Check Out Untill</td>
				<td width="4%">Maximum Baby Cots</td>
				<td width="4%">Options</td>
				
				</tr>
				
				
		
		<?php if($totalcountalpha >0){
		
		      if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
			   while(!$rs_limit->EOF){
		?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>> 
						<td valign="top"><?php  echo ++$i; ?></td>
                        
						<td valign="top"><?php echo $rs_limit->fields['property_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_in_from']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_in_until']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_out_from']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_out_until']; ?></td>
						<td valign="top"><?php $rs_limit->fields['maximum_baby_cots'];
						if($rs_limit->fields['maximum_baby_cots']==0){
						echo "No capacity for Baby Cots";
						}else{
						echo $rs_limit->fields['maximum_baby_cots'];
						}
						
						 ?></td>
						
						<td valign="top">
		<a href="admin.php?act=editpolicy1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
		<a href="admin.php?act=manage_property_policy1&amp;mode=del_policy&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=policy_management_1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
							
		<a   href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />
		</a>		
        </td>
		</tr>
					<style>
					#controls_<?php echo $rs_limit->fields['id'] ?>{
					display:none;
					}
					</style>
					<tr>
					<td colspan="9">
				<div id="controls_<?php echo $rs_limit->fields['id']; ?>" >		
				<table cellpadding="2" cellpadding="2" border="0" bordercolor="#666666" bgcolor="#E7DAE7"  >
				<tr class="txt tabheading" >
				<?php if(!trim(empty($rs_limit->fields['maximum_extra_beds']))){?>
				<td width="4%"> Maximum Extra Beds</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['children_capacity']))){?>
				<td width="4%">Children Capacity</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['children_age']))){?>
				<td width="4%">Children Age</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['extra_children_charges']))){?>
				<td width="4%">Extra Children Charges</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['break_fast']))){?>
				<td width="4%">Break Fast</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['meal_plan']))){?>
				<td width="4%">Meal Plan</td>
				<?php }?>
				<?php  if(!trim(empty($rs_limit->fields['credit_card_accepted']))){?>
				<td width="4%">Credit Card Accepted</td>
				<?php }?>
				<?php  if(!trim(empty($rs_limit->fields['pay_deposit']))){?>
				<td width="4%">Pay Deposit</td>
				<?php }?>                                 
				<?php if(!trim(empty($rs_limit->fields['deposit_amount_percent']))){?>
				<td width="4%">Deposit Amount Percent</td>
				<?php }?>
				
				</tr>
				
				<tr class="txt">
				<?php if(!trim(empty($rs_limit->fields['maximum_extra_beds']))){?>
				    <td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['maximum_extra_beds']; ?></td>
				    <?php }?>
				    <?php if(!trim(empty($rs_limit->fields['children_capacity']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['children_capacity']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['children_age']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['children_age']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['extra_children_charges']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['extra_children_charges']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['break_fast']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['break_fast']==0)
						{
							echo "Yes";
						}else {
						echo "No";
						}
						
						?></td>
						<?php }?>
						<?php 
						$meal_plan = '';
						$plan = $rs_limit->fields['meal_plan'];
						if(0==$plan){
						$meal_plan= "Any";	
						}elseif(1==$plan){
							$meal_plan = "English Breakfast";
						}elseif (2==$plan){
						$meal_plan = "Buffet";
						}else {
						$meal_plan= "Continental";
						}
						$credit_card_value = array();
						$credit_card = explode(',',$rs_limit->fields['credit_card_accepted']);
						if(in_array(0,$credit_card)){
						$credit_card_value[]="Dont Accept Credit Card";
						}
						if(in_array(1,$credit_card)){
						$credit_card_value[]="American Express";
						}
						if(in_array(2,$credit_card)){
						$credit_card_value[]="Visa";
						}
						if(in_array(3,$credit_card)){
						$credit_card_value[]="Euro and Master Card";
						}
						if(in_array(4,$credit_card)){
						$credit_card_value[]="Maestro";
						}
							?>
						<?php if(!trim(empty($rs_limit->fields['meal_plan']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $meal_plan; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['credit_card_accepted']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo implode(',',$credit_card_value); ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['pay_deposit']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['pay_deposit']==0)
						{echo "No";}else {echo "Yes";} ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['deposit_amount_percent']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['deposit_amount_percent']; ?></td>
						<?php }?>
						

					
				</tr>
				<tr class="txt tabheading">
				<?php if(!trim(empty($rs_limit->fields['minimum_days_stay']))){?>
				<td width="4%">Minimum Days Stay</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['less_days_price']))){?>
				<td width="4%">Less Days Price</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['food_beverage']))){?>
				<td width="4%">Food Beverage</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['internet_type']))){?>
				<td width="4%">Internet Type</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['internet_location']))){?>
				<td width="4%">Internet Location</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['parking_available']))){?>
				<td width="4%">Parking Available</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['parking_place']))){?>
				<td width="4%">Parking Place</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['parking_costs']))){?>
				<td width="4%">Parking Costs</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['pets_allowed']))){?>
				<td width="4%">Pets Allowed</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['important_notice']))){?>
				<td width="4%">Important Notice</td>
				<?php }?>				
				</tr>
				<tr class="txt" >
				   		
						<?php if(!trim(empty($rs_limit->fields['minimum_days_stay']))){?>
				   		<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['minimum_days_stay']; ?> <?php echo "&nbsp;"; ?></td>
				   		<?php }?>
				   		<?php if(!trim(empty($rs_limit->fields['less_days_price']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['less_days_price']; ?> <?php echo "&nbsp;"; ?></td><?php }?>
						<?php if(!trim(empty($rs_limit->fields['food_beverage']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['food_beverage']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['internet_type']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['internet_type']; ?></td>
						<?php } ?>
						<?php if(!trim(empty($rs_limit->fields['internet_location']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['internet_location']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['parking_available']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['parking_available']==0)
						{echo "No";}else {echo "Yes";}  ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['parking_place']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['parking_place']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['parking_costs']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['parking_costs']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['pets_allowed']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['pets_allowed']==0)
						{echo "No";}else {echo "Yes";} ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['important_notice']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['important_notice']; ?></td>
						<?php }?>
						
				</tr>
				</table>
				</div>
				</td>
				</tr>
			<?php $rs_limit->MoveNext();
			}?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}
							else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPages){
							if($pageNum==0)
							$count= $count+10;
							else { $count= $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							

							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Data Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>

<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
		
	
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' AND pp.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
	}else{
		$module_pm_where = ' ';
	}	
		

$maxRows = 50;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

 $qry_policy = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.agn_id as prid,pr.agn_name,yat.yatch_name
			   FROM `".$tblprefix."yatagncy_policy` as pp LEFT JOIN ".$tblprefix."yatchagency as pr ON pr.agn_id=pp.agncy_id LEFT JOIN ".$tblprefix."yatch as yat ON yat.id=pp.yatmodel LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id $module_pm_where ";
			   
$rs_policy = $db->Execute($qry_policy);
$count_add =  $rs_policy->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 $qry_limit = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.agn_id as prid,pr.agn_name,yat.yatch_name
			   FROM `".$tblprefix."yatagncy_policy` as pp LEFT JOIN ".$tblprefix."yatchagency as pr ON pr.agn_id=pp.agncy_id LEFT JOIN ".$tblprefix."yatch as yat ON yat.id=pp.yatmodel LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id $module_pm_where 
				  ORDER BY pp.pol_id DESC LIMIT $startRow,$maxRows";
		
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//   List down all Projecties

$qry_property_name ="SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency" ;

$rs_property_name = $db->Execute($qry_property_name);
$count_property_name =  $rs_property_name->RecordCount();
$totalPM = $count_property_name;


//   List down all Project Manager


$qry_pm = "SELECT id,first_name,last_name FROM ".$tblprefix."property_manager" ;
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;

$qry_yat = "SELECT * FROM ".$tblprefix."yatch" ;
$rs_yat = $db->Execute($qry_yat);
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
<table width="100%" border="0" cellspacing="2" cellpadding="2"  class="txt">
	<tr>
    	<td id="heading">Manage Yacht Agency Policy</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Policies Found: <?php echo $totalcountalpha; ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('slow'); return false;"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
	<?php
	/*if(isset($_SESSION['add_sees'])){
	?>
	<div class="add_subscriber">
	<?php 
	}else{ 
	?>
	<div id="controls" class="add_subscriber">
	<?php
	}*/
	?>
	<div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">				
<div class="border_div_categories"  align="center">				
<table cellpadding="1" cellspacing="1" border="0" >
				<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Agency 
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
		<select name="first_name" class="fields" id="first_name"  onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
		<option value="0">Select Project Manager First</option>
		<?php 
    	while(!$rs_pm->EOF){?>
		<option value="<?php echo $rs_pm->fields['id']; ?>" <?php if(!empty($_SESSION['add_sees']['first_name'])){
		if($_SESSION['add_sees']['first_name']==$rs_pm->fields['id']){
		echo "selected='selected'";
		}
		}?>
		 ><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
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
				<td class="txt">Agency</td>
						<td>
						<select name="agency_id" class="fields"   id="agency_id">
						<option value="0">Select Agency</option>
						<?php 
						$qry_prop = "SELECT * FROM ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']; 
						$rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['agn_id'];?>" <?php if($_SESSION['add_sees']['agency_id'] == $rs_prop->fields['agn_id']){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->fields['agn_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						 ?>
						</select>
				</td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt">Agency</td>
					<td>               
			            <div id="agency_name"> 
						<select name="agency_id" class="fields"   id="agency_id">
						<option value="0">Select Agency</option>
						<?php if (!empty($_SESSION['add_sees']['property_name'])){
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION['add_sees']['first_name'];
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
				<td class="txt">Policy Applicable On</td>
				<td class="txt">
				<div id="supplierdiv"><!--div start-->
				<select name="ymodel" id="ymodel" class="fields">
				<option value="0">All Models</option>	
				<?php while(!$rs_yat->EOF)
				{
				?>
					<option value="<?php echo $rs_yat->fields['id'];?>"><?php echo $rs_yat->fields['yatch_name'] ;?></option>
					<?php $rs_yat->MoveNext();
				}
				?>
				</select>
				</div><!--div ends-->
				</td> 
		</tr>
		
	    <tr>
		<td colspan="2" class="txt">
				<table border="0" cellpadding="2" cellspacing="1" width="84%" id="extra_beds" style="display:none;">
			       
				   <td width="30%" class="txt">Children Age For Free of Charge When Using Beds </td>
                   <td width="32%" >
                 <select name="children_age_beds" class="fields">
				<?php  for($i=1; $i<=10; $i++){?>
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
			
			<table border="0" cellpadding="2" cellspacing="1" width="84%">
  			<td width="36%" class="txt">Extra Bed Charges
		   	</td>
			<td width="32%">
<input type="text" name="extra_bed_charges" class="fields" id="extra_bed_charges" 
 value="<?php if(!empty($_SESSION['add_sees']['extra_bed_charges'])){ echo $_SESSION['add_sees']['extra_bed_charges'];} ?>" />
			</td>
			<td  width="1%">
			</td>
			</tr>
			</table>
			</td>
        </tr> 
					 		   
			    </table>
            </td>
        </tr>
		
		
	
		   
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">Cancellation Policy</td>
		</tr>
		<tr><td class="txt">Cacellation Days</td>
			<td>
			 <input type="text" name="cancldays" class="fields" id="cancldays" 
			value="<?php if(!empty($_SESSION['add_sees']['cancldays'])){ echo $_SESSION['add_sees']['cancldays'];} ?>"/>
			</td></tr>
		<tr><td class="txt">Cancellation Charges Percent</td>
		<td>
		<select name="cancellation_charges_percent" id="cancellation_charges_percent" class="fields">
		
		<option value="0">0</option>
		<?php for($i = 10; $i <= 90; $i+=10){?>
		<option 
		<?php if(!empty($_SESSION['add_sees']['cancellation_charges_percent'])){
					if($_SESSION['add_sees']['cancellation_charges_percent']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>
		
		value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php }?>
		<option value="100">Total price of reservation will be charged</option>
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
			<option value="0">0</option>
		<?php for($i = 10; $i <= 90; $i+=10){?>
		<option 
		<?php if(!empty($_SESSION['add_sees']['no_show_policy'])){
					if($_SESSION['add_sees']['no_show_policy']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>
		
		value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php }?>
		<option value="100">Total price of reservation will be charged</option>
		
			</select>%
			</td></tr>
		
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr><td>&nbsp;&nbsp;</td></tr>
		<tr>
	        <td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;">
  			Credit Cards Policies
		   	</td>
			<td class="txt">
			
	<?php if(isset($_SESSION['add_sees']['credit_card_accepted'])){ 
	if(in_array(0,$_SESSION['add_sees']['credit_card_accepted'])){echo 'Selected="Selected"';}
	}?>
	<input type="checkbox" name="credit_card_accepted[]" value="0" id="credit_card_accepted" onclick="return is_checked();" <?php 
		
	 //if($_SESSION['add_sees']['dont_accept_credit_card']==0){ echo 'checked="Yes"';} ?>/>Don't Accept Credit Card<br/>
	<div id="credit_card" style="display:block;">
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
  			Payment Method
		   	</td>
        </tr>
		
		<tr>
			<td class="txt">Prepayment</td>
			<td class="txt">
			     <input type="text" name="prepayment" class="fields" id="prepayment" 
			value="<?php if(!empty($_SESSION['add_sees']['prepayment'])){ echo $_SESSION['add_sees']['prepayment'];} ?>"/>%
		    </td>
		</tr>
		<tr>
	        <td class="txt">
  			Remaining
		   	</td>
			<td class="txt">
			<input type="text" name="remainingpay" class="fields" id="remainingpay" 
			value="<?php if(!empty($_SESSION['add_sees']['remainingpay'])){ echo $_SESSION['add_sees']['remainingpay'];} ?>"/>% of rental price at least   
			 <select name="weeksprior" id="weeksprior">
			<?php for($i = 1; $i <= 15; $i++){?>
		<option value="<?php echo $i; ?>"
		<?php if(!empty($_SESSION['add_sees']['weeksprior'])){
					if($_SESSION['add_sees']['weeksprior']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?>
		><?php echo $i; ?></option>
		<?php }?>

			</select> weeks prior to the rental date</td>
        </tr>
		<tr>
			<td class="txt">Security Deposit</td>
			<td class="txt">
			     <input type="text" name="secdeposit" class="fields" id="secdeposit" 
			value="<?php if(!empty($_SESSION['add_sees']['secdeposit'])){ echo $_SESSION['add_sees']['secdeposit'];} ?>"/> Payable upon checking in (usually a credit card slip or cash). Refundable following check out.

		    </td>
		</tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Discounts
		   	</td>
        </tr>
		<tr>
				<td class="txt">Early booking</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="early_booking" id="wise_price_yes" value="1" onClick="jQuery('#wise_price_parameters').show('slow');" ><span> Yes</span>
				<input type="radio" name="early_booking"  id="wise_price_no" checked="checked" value="0" onClick="jQuery('#wise_price_parameters').hide('slow');" ><span> No</span>
				</div>
				
				</td> 
		</tr>
		
		
		
		<tr>
				<td colspan="2">
				<div id="wise_price_parameters">
				<table cellpadding="1" cellspacing="1" border="0" width="100%" class="txt">	
				
				
				<tr>
				<td class="txt" width="35%">Threshold</td>
				<td width="65%">
<input type="text" name="threshold" class="fields" id="threshold" value="<?php echo $_SESSION['add_sees']['threshold']?>"/>
				</td> 
				</tr>
				
				<tr>
				<td class="txt">Discount Percentage</td>
				<td class="txt" style="width:350px;">
<input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['discount_percentage']?>" name="discount_percentage" id="discount_percentage" /> % 
				</td> 
				</tr>
			</table>
			</div>
				</td>
				</tr>
				
				<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Discount for more Weeks
		   	</td>
        </tr>
		<tr>
				<td class="txt">&nbsp;</td>
				<td class="txt">				
				Week 0
				&nbsp; <input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['discweek0'];?>" name="discweek0" id="discweek0" /> %<br />
				Week 1
				&nbsp; <input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['discweek1'];?>" name="discweek1" id="discweek1" /> %<br />
				Week 2
				&nbsp; <input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['discweek2'];?>" name="discweek2" id="discweek2" /> %<br />
				Week 3
				&nbsp; <input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['discweek3'];?>" name="discweek3" id="discweek3" /> %<br />
				Week 4
				&nbsp; <input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['discweek4'];?>" name="discweek4" id="discweek4" /> %<br />
				</td> 
		</tr>
				<tr>
				<td class="txt">Maximal Discount</td>
				<td class="txt">
				<input class="fields" type="text" value="<?php echo $_SESSION['add_sees']['max_discount'];?>" name="max_discount" id="max_discount" /> %
				</td> 
		</tr>
		<tr>
		<td colspan="2" style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Free for sunnymontenegro.com customers 
		   	</td>
        </tr>
		<tr>
		<tr>
	        <td class="txt">&nbsp;
  		   	</td>
			<td class="txt">
			<?php
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."yatch_free_srvices" ;
				$rs_free = $db->Execute($qry_free);
				while(!$rs_free->EOF)
				{
				?>
				<input type="checkbox" name="freeser[]" value="<?php echo $rs_free->fields['ser_id']; ?>" id="freeser" /><?php echo $rs_free->fields['free_service'];?><br/>
				<?php
					$rs_free->MoveNext();
				}
			?>
			</td>
        </tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Important Note
		   	</td>
        </tr>
		<tr>
	        <td class="txt">
  			*Only with skipper
		   	</td>
			<td>
			<select name="onlywidskpr" id="onlywidskpr">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
			</td>
        </tr>
		<tr>
	        <td class="txt">
  			**Only with crow
		   	</td>
			<td>
			<select name="onlywidcrow" id="onlywidcrow">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>				
			</td>
        </tr>		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
	        <td  style="text-align:left; font-weight:bold;" class="txt">
  			Offers Included in Price
		   	</td>
			<td class="txt">
				<textarea name="inc_inprice" id="inc_inprice" style="width: 228px; height: 104px;"></textarea>
			</td>
        </tr>
		<tr>
		<td colspan="2"  style="text-align:center;" class="txt">(Please enter Comma seperated offers)</td>
		</tr>
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
	        <td  style="text-align:left; font-weight:bold;" class="txt">
  			Offers Not Included in Price
		   	</td>
			<td class="txt">
				<textarea name="notinc_inprice" id="notinc_inprice" style="width: 228px; height: 104px;"></textarea>				
			</td>
        </tr>
		<tr>
		<td colspan="2"  style="text-align:center;" class="txt">(Please enter Comma seperated offers)</td>
		</tr>
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Optional Extras<br />
		   	</td>
		</tr>
		<tr>
	        <td class="txt">
  			Select and Specify charges
		   	</td>
			<td class="txt">
			<?php
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."yatch_optional" ;
				$rs_free = $db->Execute($qry_free);
				while(!$rs_free->EOF)
				{
				?>
				<input type="checkbox" name="optxtra[]" value="<?php echo $rs_free->fields['ser_id']; ?>" id="optxtra" />
				<?php echo $rs_free->fields['free_service'];?>		
				<input type="text" name="<?php echo $rs_free->fields['ser_id']; ?>" id="<?php echo $rs_free->fields['ser_id']; ?>" value="0" class="fields" style="width:50px;" />€<br/>
				<?php
					$rs_free->MoveNext();
				}
			?>
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
		<input type="hidden" name="act" value="mng_yatagncy_policy">
		<input type="hidden" name="act2" value="mng_yatagncy_policy">
		<input type="hidden" name="request_page" value="mng_yatagncy_policy" />
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
                <td width="4%">PM Name</td>
				<td width="4%">Agency Name</td>
				<td width="4%">Yacht Model</td>
				<td width="4%">Cancellation Days</td>
				<td width="4%">Cancellation Charges</td>
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
					<tr<?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>> 
						<td valign="top"><?php echo ++$i; ?></td>
                        
						<td valign="top"><?php echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['agn_name']; ?></td>
						<td valign="top"><?php
						if($rs_limit->fields['yatch_name'] == "")
						{
							echo "Applicable to All";
						}
						else
						{
							echo $rs_limit->fields['yatch_name']; 
						}
						?></td>
						<td valign="top"><?php echo $rs_limit->fields['cancl_days']; ?></td>
						<td valign="top"><?php 
						if($rs_limit->fields['cancl_charges']=='100')
						{
							echo "Total price of reservation will be charged";
						}
						else
						{
							echo $rs_limit->fields['cancl_charges']; 
						}					
						?></td>
						
						
						<td valign="top">
		<a href="admin.php?act=edityatagnpolicy&amp;id=<?php echo base64_encode($rs_limit->fields['pol_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
		<a href="admin.php?act=mng_yatagncy_policy&amp;mode=del_policy&amp;id=<?php echo base64_encode($rs_limit->fields['pol_id']); ?>&amp;request_page=mng_yatagncy_policy" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
							
		<a   href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['pol_id']; ?>').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />
		</a>		
        </td>
		</tr>
					<style>
					#controls_<?php echo $rs_limit->fields['pol_id'] ?>{
					display:none;
					}
					</style>
					<tr>
					<td colspan="9">
				<div id="controls_<?php echo $rs_limit->fields['pol_id']; ?>" >		
				<table cellpadding="2" cellpadding="2" border="1" bordercolor="#666666" bgcolor="#E7DAE7"  >
				
				
				
				<tr class="txt tabheading">
				
				<td width="10%">Free Services</td>
				<td width="15%">Offers Included in Price</td>
				<td width="20%">Offers Not Included in Price</td>
				<td width="10%">Optional Extras</td>
				<td width="15%">Credit Card Accepted</td>
				<td width="20%">Cancelation charges</td>
				<td width="10%">Important Notice</td>
				
								
				</tr>
				
				<tr class="txt" >
	<?php
			  $qry_freeserv = "SELECT pp.*, pr.offer_id 
			   FROM `".$tblprefix."yatch_free_srvices` as pp ,".$tblprefix."freeoffer_cagnpol as pr WHERE pr.car_agnpolicy_id='".$rs_limit->fields['pol_id']."' and pr.offer_id=pp.ser_id and pr.flag='0'";
			   
			   $rs_freeserv = $db->Execute($qry_freeserv);
			   
			   
			   $qry_xtra = "SELECT pp.* 
			   FROM `".$tblprefix."yatch_optional` as pp ,".$tblprefix."xtra_cagnpol as pr WHERE pr.car_agnpolicy_id='".$rs_limit->fields['pol_id']."' and pr.xtra_id=pp.ser_id and pr.flag='0'";
			   
			   $rs_xtra = $db->Execute($qry_xtra);
			   
			    ?>
						
				   		<td valign="top">
						<?php
						$totalcountalpha1 =  $rs_freeserv->RecordCount();
						if($totalcountalpha1 > 0)
						{ 
							echo '<ul>';
							while(!$rs_freeserv->EOF)
							{
								echo "<li>".$rs_freeserv->fields['free_service']."</li>"; 
								$rs_freeserv->MoveNext();
							}
							echo '</ul>';
						}
						else
						{
							echo "No Free Services";
						}
						?>
						</td>
						<td valign="top">
						<?php 
						if($rs_limit->fields['ofr_included_inprice']!='')
						{
							echo $rs_limit->fields['ofr_included_inprice'];
						}
						else
						{
							echo '&nbsp;';
						}
						?>
						</td>
						<td valign="top">
						<?php 
						if($rs_limit->fields['ofr_notincluded_inprice']!='')
						{
							echo $rs_limit->fields['ofr_notincluded_inprice'];
						}
						else
						{
							echo '&nbsp;';
						}
						?>
						</td>
						<td valign="top">
						<?php 
						$totalcountalpha4 =  $rs_xtra->RecordCount();
						if($totalcountalpha4 > 0)
						{
						echo '<ul>';
							while(!$rs_xtra->EOF)
							{
								echo "<li>".$rs_xtra->fields['free_service']."</li>"; 
								$rs_xtra->MoveNext();
							}
						echo '</ul>';
						}
						else
						{
							echo "No Optional Extras";
						}
						?>
						</td>
						<td valign="top">
						<?php 
						if($rs_limit->fields['creditcard']!="")
						{
						echo '<ul>';
							$explcards = explode(",",$rs_limit->fields['creditcard']);
							if(in_array('1',$explcards))
							{
								echo "<li>American Express</li>";
							}
							if(in_array('2',$explcards))
							{
								echo "<li>Visa</li>";
							}
							if(in_array('3',$explcards))
							{
								echo "<li>Euro and Master Card</li>";
							}
							if(in_array('4',$explcards))
							{
								echo "<li>Diners Club</li>";
							}
							if(in_array('5',$explcards))
							{
								echo "<li>Maestro</li>";
							}
						echo '</ul>';
						}
						else
						{
							echo "&nbsp;";
						}
						 ?>
						</td>
						<td valign="top"><?php 
						if($rs_limit->fields['cancl_charges']=='100')
						{
							echo "Total price of reservation will be charged";
						}
						else
						{
							echo $rs_limit->fields['cancl_charges']; 
						}					
						?></td>
						<td valign="top"><?php echo "&nbsp;";?></td>
						
				</tr>
				
				<tr class="txt tabheading">
				
				<td width="10%">No Show Policy</td>
				<td width="15%">Prepayment</td>
				<td width="15%">Remaining</td>
				<td width="10%">Security Deposit</td>
				<td width="15%">Threshold</td>
				<td width="10%">Deposit Charges</td>
				<td width="15%">Maximal Discount</td>
				
								
				</tr>
				
				<tr class="txt" >
				   		<td valign="top">
						<?php
						if($rs_limit->fields['noshow_pol'] == '100')
						{ 
							echo "Total price of the reservation will be charged";
						}
						else
						{
							echo $rs_limit->fields['noshow_pol']."%";
						}
						?>
						</td>
						<td valign="top">
						<?php 
						if($rs_limit->fields['prepayment'] == "")
						{ 
							echo "0";
						}
						else
						{
							echo $rs_limit->fields['prepayment'];
						}
						?>
						</td>
						<td valign="top">
						<?php 
						if($rs_limit->fields['remaining'] == "")
						{ 
							echo "0";
						}
						else
						{
							echo $rs_limit->fields['remaining'];
						}
						?>
						</td>
						<td valign="top">
						<?php 
						if($rs_limit->fields['security_deposit'] == "")
						{ 
							echo "0";
						}
						else
						{
							echo $rs_limit->fields['security_deposit'];
						}
						?>
						</td>
						<td valign="top"><?php echo $rs_limit->fields['threshold']; ?></td>
						
						<td valign="top"><?php echo $rs_limit->fields['depositcharge']; ?></td>
						<td valign="top"><?php 
						if($rs_limit->fields['maximal_discount'] == "")
						{ 
							echo "0";
						}
						else
						{
							echo $rs_limit->fields['maximal_discount'];
						}
						?></td>
						
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

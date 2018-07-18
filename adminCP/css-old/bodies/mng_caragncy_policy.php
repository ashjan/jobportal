<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
		
	
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE pp.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
	}else{
		$module_pm_where = ' ';
	}	
		

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_policy = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.agn_id as prid,pr.agn_name
			   FROM `".$tblprefix."caragncy_policy` as pp LEFT JOIN ".$tblprefix."agency as pr ON pr.agn_id=pp.agncy_id LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id $module_pm_where ";			
$rs_policy = $db->Execute($qry_policy);
$count_add =  $rs_policy->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.agn_id as prid,pr.agn_name
			   FROM `".$tblprefix."caragncy_policy` as pp LEFT JOIN ".$tblprefix."agency as pr ON pr.agn_id=pp.agncy_id LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id $module_pm_where 
				   LIMIT $startRow,$maxRows";

$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//   List down all Projecties

$qry_property_name = "SELECT agn_id,agn_name FROM ".$tblprefix."agency" ;

$rs_property_name = $db->Execute($qry_property_name);
$count_property_name =  $rs_property_name->RecordCount();
$totalPM = $count_property_name;


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
    	<td id="heading">Manage Car Agency Policy</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Policies Found: <?php echo $totalcountalpha; ?></td>
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
	<div>
	<?php 
	}else{ 
	?>
	<div id="controls" class="add_subscriber">
	<?php
	}
	?>
	
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
		<td class="txt" width="35%">Car Manager</td>
		<td width="65%">
		<select name="first_name" class="fields" id="first_name"  onchange="get_caragency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_caragencyy_name.php"?>')">
		<option value="0">Select Car Manager First</option>
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
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
						$rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($_SESSION['add_sees']['property_name']==					 						$rs_prop->fields[id]){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->	  		 						fields['property_name']; ?></option>
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
						<?php 
						while(!$rs_property_name->EOF){
						?>
						<option value="<?php echo $rs_property_name->fields['agn_id'];?>"><?php echo $rs_property_name->fields['agn_name']; ?></option>
						<?php
						$rs_property_name->MoveNext();
						} 
						} ?>
						</select>
						</div> 				
				    </td>
				</tr>
				<?php //} ?>
	
			
	    <tr>
		<td colspan="2" class="txt">
				<table border="0" cellpadding="2" cellspacing="1" width="84%" id="extra_beds" style="display:none;">
			       
				   <td width="30%" class="txt">Children Age For Free of Charge When Using Beds </td>
                   <td width="32%" >
                 <select name="" class="fields">
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
<input type="text" name="" class="fields" id="" 
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
		<?php for($i = 10; $i <= 100; $i+=10){?>
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
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
			No Show Policy
			</td>
			</tr>
			<tr><td class="txt">
			No Show Policy
			</td>
			
			<td>
		<select name="no_show_policy" id="no_show_policy" class="fields">
		
		<option value="0">0</option>
		<?php for($i = 10; $i <= 100; $i+=10){?>
		<option 
		value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php }?>
		</select>
		%
		</td>
		</tr>
			<tr>
	        <td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;">
  			Credit Cards Policies
		   	</td>
			
			
			<td class="txt">
			
	<?php $credit_card_accepted= explode(',',$rs_limit->fields['credit_card_accepted']);  
	?>			
	<input type="checkbox" name="credit_card_accepted[]" value="0" id="credit_card_accepted" onclick="return is_checked();"/>Don't Accept Credit Card <br/>
	<div id="credit_card" style="display:block;">
	<input type="checkbox" name="credit_card_accepted[]" value="1" id="credit_card_accepted"/>American Express <br/> 
	<input type="checkbox" name="credit_card_accepted[]" value="2" id="credit_card_accepted"/>Visa <br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="3" id="credit_card_accepted"/>Euro And Master Card <br/>
	<input type="checkbox" name="credit_card_accepted[]" value="4" id="credit_card_accepted"/>Diners Club<br/>
	<input type="checkbox" name="credit_card_accepted[]" value="5" id="credit_card_accepted"/>Maestro <br/> 		
	</div>
		    </td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Deposit Policy
		   	</td>
        </tr>
		<tr>
				<td class="txt">Charge Deposit</td>
				<td>
				<div class="fields_checked">
				<input type="radio" name="charge_flag" id="charge_yes" checked="checked" value="1" onClick="jQuery('#wise_deposit').show('slow');" ><span> Yes</span>
				<input type="radio" name="charge_flag"  id="charge_no" value="0" onClick="jQuery('#wise_deposit').hide('slow');" ><span> No</span>
				</div>
				
				</td> 
		</tr>
		<tr>
				<td colspan="2">
				<div id="wise_deposit">
				<table cellpadding="1" cellspacing="1" border="0" width="100%" class="txt">	
				<tr>
				<td class="txt" width="35%">Charges</td>
				<td width="65%">
<input type="text" name="dcharges" class="fields" id="dcharges" value="<?php if(!empty($_SESSION['add_sees']['dcharges'])){ echo $_SESSION['add_sees']['dcharges'];} ?>"/>%
				</td> 
				</tr>
			</table>
			</div>
				</td>
				</tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">Driver Age</td>
		</tr>
		<tr><td class="txt">Minimum</td>
			<td class="txt">
			 <input type="text" name="driverage" class="fields" id="driverage" 
			value="<?php if(!empty($_SESSION['add_sees']['driverage'])){ echo $_SESSION['add_sees']['driverage'];} ?>"/> years
			</td></tr>
			
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Free for sunnymontenegro.com customers 
		   	</td>
        </tr>
		
		<tr>
	        <td class="txt">&nbsp;
  			
		   	</td>
			
			<td class="txt">
			<?php
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."car_free_srvices" ;
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
  			Included in Price
		   	</td>
        </tr>
		
		<tr>
	        <td class="txt">&nbsp;
  			
		   	</td>
			
			<td class="txt">
			<?php
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."offers_included_in_price" ;
				$rs_free = $db->Execute($qry_free);
				while(!$rs_free->EOF)
				{
				?>
				<input type="checkbox" name="inc_inprice[]" value="<?php echo $rs_free->fields['ser_id']; ?>" id="inc_inprice" /><?php echo $rs_free->fields['free_service'];?><br/>
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
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
		
		<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Optional Extras
		   	</td>
        </tr>
		
		<tr>
	        <td class="txt">&nbsp;
  			
		   	</td>
			
			<td class="txt">
			<?php
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."car_optional" ;
				$rs_free = $db->Execute($qry_free);
				while(!$rs_free->EOF)
				{
				?>
				<input type="checkbox" name="optxtra[]" value="<?php echo $rs_free->fields['ser_id']; ?>" id="optxtra" /><?php echo $rs_free->fields['free_service'];?><br/>
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
	        <td class="txt">&nbsp;
  			
		   	</td>
			<td>
			<input type="text" size="55" name="impnotice" id="impnotice" value="<?php echo $_SESSION['add_sees']['impnotice'];?>" />
				
			</td>
        </tr>
		
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
		</tr>
	
		   
</table>
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
		<td>&nbsp;</td>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Dodaj politiku objekta" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="mng_caragncy_policy">
		<input type="hidden" name="act2" value="mng_caragncy_policy">
		<input type="hidden" name="request_page" value="mng_caragncy_policy" />
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
				<td width="8%">PM Name</td>
                <td width="8%">Agency Name</td>
				<td width="4%">Driver Age</td>
				<td width="4%">Cancellation Days</td>
				<td width="4%">Cancellation Charges</td>
				<td width="4%">Options</td>
				
				</tr>
				
				
		
		<?php if($totalcountalpha >0){
				$i = 0;
		 
			   while(!$rs_limit->EOF){
		?>
					<tr<?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>> 
						<td valign="top"><?php echo ++$i; ?></td>
                        <td valign="top"><?php echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['agn_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['driver_age']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['cancl_days']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['cancl_charges']; ?></td>
						
						
						
						<td valign="top">
		<a href="admin.php?act=editcaragnpolicy&amp;id=<?php echo base64_encode($rs_limit->fields['pol_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
		<a href="admin.php?act=mng_caragncy_policy&amp;mode=del_policy&amp;id=<?php echo base64_encode($rs_limit->fields['pol_id']); ?>&amp;request_page=mng_caragncy_policy" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
							
		<a   href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['pol_id']; ?>').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />
		</a>		
        </td>
		</tr>
					<style>
					#controls_<?php echo $rs_limit->fields['pol_id'] ?>
					{
						display:none;
					}
					</style>
					<tr>
					<td colspan="9">
				<div id="controls_<?php echo $rs_limit->fields['pol_id']; ?>">		
				<table cellpadding="2" cellpadding="2" border="1" bordercolor="#666666" bgcolor="#E7DAE7">
				
				<tr class="txt tabheading">
				
				<td width="10%">Free Services</td>
				<td width="15%">Offers Included in Price</td>
				<td width="15%">Offers Not Included in Price</td>
				<td width="10%">Optional Extras</td>
				<td width="10%">Deposit Charges</td>
				<td width="15%">Credit Card Accepted</td>
				<td width="15%">Terms and Condition</td>
				<td width="10%">Important Notice</td>
				
								
				</tr>
				<tr class="txt" >
	<?php
			  $qry_freeserv = "SELECT pp.*, pr.offer_id 
			   FROM `".$tblprefix."car_free_srvices` as pp ,".$tblprefix."freeoffer_cagnpol as pr WHERE pr.car_agnpolicy_id='".$rs_limit->fields['pol_id']."' and pr.offer_id=pp.ser_id and pr.flag='1'";
			   
			   $rs_freeserv = $db->Execute($qry_freeserv);
			   
			   
			   $qry_xtra = "SELECT pp.* 
			   FROM `".$tblprefix."car_optional` as pp ,".$tblprefix."xtra_cagnpol as pr WHERE pr.car_agnpolicy_id='".$rs_limit->fields['pol_id']."' and pr.xtra_id=pp.ser_id and pr.flag='1'";
			   
			   $rs_xtra = $db->Execute($qry_xtra);
			   
			    $qry_inc = "SELECT pp.* 
			   FROM `".$tblprefix."offers_included_in_price` as pp ,".$tblprefix."included_cagnpol as pr WHERE pr.car_agnpolicy_id='".$rs_limit->fields['pol_id']."' and pr.included_id=pp.ser_id and pr.flag='1'";
			   
			   $rs_inc = $db->Execute($qry_inc);
			   
			   $qry_ninc = "SELECT pp.* 
			   FROM `".$tblprefix."offers_not_included_in_price` as pp ,".$tblprefix."nincluded_cagnpol as pr WHERE pr.car_agnpolicy_id='".$rs_limit->fields['pol_id']."' and pr.nincluded_id=pp.ser_id and pr.flag='1'";
			   
			   $rs_ninc = $db->Execute($qry_ninc);
			 
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
						$totalcountalpha2 =  $rs_inc->RecordCount();
						if($totalcountalpha2 > 0)
						{
						echo '<ul>';
							while(!$rs_inc->EOF)
							{
								echo "<li>".$rs_inc->fields['free_service']."</li>"; 
								$rs_inc->MoveNext();
							}
						echo '</ul>';
						}
						else
						{
							echo "No Offers Included in Price";
						}
						?>
						</td>
						<td valign="top">
						<?php 
						$totalcountalpha3 =  $rs_ninc->RecordCount();
						if($totalcountalpha3 > 0)
						{
						echo '<ul>';
							while(!$rs_ninc->EOF)
							{
								echo "<li>".$rs_ninc->fields['free_service']."</li>"; 
								$rs_ninc->MoveNext();
							}
						echo '</ul>';
						}
						else
						{
							echo "No Offers Not Included in Price";
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
						<td valign="top"><?php echo $rs_limit->fields['depositcharge']; ?></td>
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
						<td valign="top"><?php echo $rs_limit->fields['trmsncond']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['imp_notice']; ?></td>
						
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

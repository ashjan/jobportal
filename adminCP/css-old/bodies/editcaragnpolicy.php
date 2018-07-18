<?php
	$id=base64_decode($_GET['id']); 
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
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_policy = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.agn_id as prid,pr.agn_name
			   FROM `".$tblprefix."caragncy_policy` as pp,".$tblprefix."agency as pr, ".$tblprefix."property_manager as pm WHERE 	 	    		   pp.pol_id='".$id."' and pr.agn_id=pp.agncy_id and pm.id=pp.pm_id $module_pm_where ";
	   
			   
			   
$rs_policy = $db->Execute($qry_policy);
$count_add =  $rs_policy->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);


$qry_limit = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.agn_id as prid,pr.agn_name
			   FROM `".$tblprefix."caragncy_policy` as pp,".$tblprefix."agency as pr, ".$tblprefix."property_manager as pm WHERE pp.pol_id='".$id."' and pr.agn_id=pp.agncy_id and pm.id=pp.pm_id $module_pm_where ";  	

//echo $qry_limit;
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
	<tr>
	<td colspan="8">
	<div id="controls" class="add_subscriber" style="display:block;">
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
		<option value="<?php echo $rs_pm->fields['id']; ?>" 
		<?php 
		if($rs_limit->fields['pm_id']==$rs_pm->fields['id'])
		{
			echo "selected='selected'";
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
						$rs_property_name->MoveFirst();
						while(!$rs_property_name->EOF){
						?>
						<option value="<?php echo $rs_property_name->fields['agn_id'];?>" <?php if($rs_property_name->fields[agn_id] == $rs_limit->fields['agncy_id']){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_property_name->fields['agn_name']; ?></option>
						<?php
						$rs_property_name->MoveNext();
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
						<option value="<?php echo $rs_property_name->fields['agn_id'];?>"
						<?php
						if($rs_property_name->fields['agn_id'] ==  $rs_limit->fields['agncy_id'])
						{
							echo 'selected="selected"';
						}
						?>
						><?php echo $rs_property_name->fields['agn_name']; ?></option>
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
			value="<?php echo $rs_limit->fields['cancl_days']; ?>"/>
			</td></tr>
		<tr><td class="txt">Cancellation Charges Percent</td>
		<td>
		<select name="cancellation_charges_percent" id="cancellation_charges_percent" class="fields">
		
		<option value="0">0</option>
		<?php for($i = 10; $i <= 100; $i+=10){?>
		<option value="<?php echo $i; ?>"
		<?php
		if($rs_limit->fields['cancl_charges'] == $i)
		{
			echo 'selected="selected"';
		}
		?>
		><?php echo $i; ?></option>
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
			<!--<td>
			<select name="no_show_policy" class="fields"   id="no_show_policy">
			<option value="1"
			<?php 
			/*if($rs_limit->fields['noshow_pol']==1)
			{
				echo 'selected="selected"';
			}*/
			?>
			>First night will be charged</option>
			<option 
			<?php 
			/*if($rs_limit->fields['noshow_pol']==0){
				echo 'selected="selected"';
			}*/
			?> 
			value="0">Total price of the reservation will be charged</option>
			</select>
			</td>-->
			
			<td>
		<select name="no_show_policy" id="no_show_policy" class="fields">
		
		<option value="0">0</option>
		<?php for($i = 10; $i <= 100; $i+=10){?>
		<option 
		value="<?php echo $i; ?>" <?php 
			if($rs_limit->fields['noshow_pol']==$i)
			{
				echo 'selected="selected"';
			}
			?>><?php echo $i; ?></option>
		<?php }?>
		</select>
		%
		</td>
		</tr>
			
			</tr>
		
		
		<tr>
	        <td class="txt" style="border-left:opx solid #999999; border-bottom:0px solid #999999;">
  			Credit Cards Policies
		   	</td>
			
			
			<td class="txt">
			
	<?php $credit_card_accepted= explode(',',$rs_limit->fields['credit_card_accepted']);  
	?>			
	<input type="checkbox" name="credit_card_accepted[]" value="0" id="credit_card_accepted" onclick="return is_checked();" <?php if($credit_card_accepted==0){ echo 'checked="checked"';} ?>/>Don't Accept Credit Card <br/>
	<div id="credit_card" style="display:block;">
	<input type="checkbox" name="credit_card_accepted[]" value="1" id="credit_card_accepted" 
	<?php if(in_array('1',$credit_card_accepted)){ echo 'checked="checked"';} ?>/>American Express <br/> 
	<input type="checkbox" name="credit_card_accepted[]" value="2" id="credit_card_accepted" 
	<?php if(in_array('2',$credit_card_accepted)){ echo 'checked="checked"';} ?> />Visa <br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="3" id="credit_card_accepted" 
	<?php if(in_array('3',$credit_card_accepted)){ echo 'checked="checked"';} ?>/>Euro And Master Card <br/> 				 
	<input type="checkbox" name="credit_card_accepted[]" value="4" id="credit_card_accepted" 
	<?php if(in_array('4',$credit_card_accepted)){ echo 'checked="checked"';} ?> />Diners Club 
	<br/>
	<input type="checkbox" name="credit_card_accepted[]" value="5" id="credit_card_accepted" 
	<?php if(in_array('5',$credit_card_accepted)){ echo 'checked="checked"';} ?>/>Maestro <br/> 		
	</div>
		    </td>
		</tr>
			
		<tr>
		<td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">&nbsp;</td>
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
				<input type="radio" name="charge_flag" id="charge_yes"
				<?php
				if($rs_limit->fields['depositcharge']!=0)
				{
					echo 'checked="checked"';
				}
				?>
				  value="1" onClick="jQuery('#wise_deposit').show('slow');" ><span> Yes</span>
				<input type="radio" name="charge_flag" 
				<?php
				if($rs_limit->fields['depositcharge']==0)
				{
					echo 'checked="checked"';
				}
				?>
				 id="charge_no" value="0" onClick="jQuery('#wise_deposit').hide('slow');" ><span> No</span>
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
<input type="text" name="dcharges" class="fields" id="dcharges" value="<?php echo $rs_limit->fields['depositcharge'];?>"/>%
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
			value="<?php echo $rs_limit->fields['driver_age'];?>"/> years
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
				$qry_xxtra = "SELECT free_services FROM  ".$tblprefix."caragncy_policy WHERE pol_id =".$id;
				$rs_xxtra = $db->Execute($qry_xxtra);
				$freeserarray = array();    
				$freeserarray= explode(",",$rs_xxtra->fields['free_services']);
				
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."car_free_srvices" ;
				$rs_free = $db->Execute($qry_free);
				while(!$rs_free->EOF)
				{
				?>
				<input type="checkbox" name="freeser[]" value="<?php echo $rs_free->fields['ser_id']; ?>"  id="freeser" 
				<?php
				if(in_array($rs_free->fields['ser_id'],$freeserarray))
				{
					echo 'checked="checked"';
				}
				?>
				/><?php echo $rs_free->fields['free_service'];?><br/>
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
				$qry_free = "SELECT ser_id,free_service FROM ".$tblprefix."offers_included_in_price";
				$rs_free = $db->Execute($qry_free);
				$qry_xxtra = "SELECT inc_price FROM  ".$tblprefix."caragncy_policy WHERE pol_id =".$id;
				$rs_xxtra = $db->Execute($qry_xxtra);
				$incarray = array();    
				$incarray= explode(",",$rs_xxtra->fields['inc_price']);
				while(!$rs_free->EOF)
				{
				?>
				<input type="checkbox" name="inc_inprice[]"
				<?php
				if(in_array($rs_free->fields['ser_id'],$incarray))
				{
					echo 'checked="checked"';
				}
				?>
				 value="<?php echo $rs_free->fields['ser_id']; ?>" id="inc_inprice" /><?php echo $rs_free->fields['free_service'];?><br/>  
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

				$qry_xxtra = "SELECT lst_extras FROM  ".$tblprefix."caragncy_policy WHERE pol_id =".$id; 
				$rs_xxtra = $db->Execute($qry_xxtra);
				$xxtraarray = array();    
				$xxtraarray= explode(",",$rs_xxtra->fields['lst_extras']);
				while(!$rs_free->EOF)
				{
				?>
				
				<input type="checkbox" name="optxtra[]"
				<?php
				if(in_array($rs_free->fields['ser_id'],$xxtraarray))
				{
					echo 'checked="checked"';
				}
				?>
				 value="<?php echo $rs_free->fields['ser_id']; ?>" id="optxtra" /><?php echo $rs_free->fields['free_service'];?><br/>  
				<?php
					$rs_free->MoveNext();
				}
			?>
			
			</td>
			
<!--

	<td class="txt">
			
	<?php //$optxtra= explode(',',$rs_limit->fields['lst_extras']);  
	?>		
	
	<input type="checkbox" name="optxtra[]" value="1" id="optxtra" 
	<?php //if(in_array('1',$optxtra)){ echo 'checked="checked"';} ?>/>Snow Chains<br/> 
	<input type="checkbox" name="optxtra[]" value="2" id="lst_extras" 
	<?php //if(in_array('2',$optxtra)){ echo 'checked="checked"';} ?> />Winter tires <br/> 				 
	<input type="checkbox" name="optxtra[]" value="3" id="optxtra" 
	<?php //if(in_array('3',$optxtra)){ echo 'checked="checked"';} ?>/>Ski rack<br/> 				 
	<input type="checkbox" name="optxtra[]" value="4" id="optxtra" 
	<?php //if(in_array('4',$optxtra)){ echo 'checked="checked"';} ?> />GPS<br/>
	<input type="checkbox" name="optxtra[]" value="5" id="optxtra" 
	<?php //if(in_array('5',$optxtra)){ echo 'checked="checked"';} ?>/>Baby seat<br/> 		
	<input type="checkbox" name="optxtra[]" value="6" id="optxtra" 
	<?php //if(in_array('6',$optxtra)){ echo 'checked="checked"';} ?>/>Child seat<br/> 
	<input type="checkbox" name="optxtra[]" value="7" id="optxtra" 
	<?php //if(in_array('7',$optxtra)){ echo 'checked="checked"';} ?>/>Driver<br/> 
	<input type="checkbox" name="optxtra[]" value="8" id="optxtra" 
	<?php //if(in_array('8',$optxtra)){ echo 'checked="checked"';} ?>/>Delivery or taking vehicle on Other location (on request) <br/> 
	 
		    </td>-->
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
			<input type="text" size="55" name="impnotice" id="impnotice" value="<?php echo $rs_limit->fields['imp_notice']; ?>" />
				
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
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Edit Policy" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>">
		<input type="hidden" name="act" value="editcaragnpolicy">
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
  
</table>
<?php //echo $where;?>

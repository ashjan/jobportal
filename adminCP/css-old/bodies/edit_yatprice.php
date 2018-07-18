<?php
	 $id=base64_decode($_GET['id']);
		 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$qry_limit = "SELECT * FROM ".$tblprefix."yatmng_price where id='".$id."'"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_yat = "SELECT * FROM ".$tblprefix."yatch" ;
$rs_yat = $db->Execute($qry_yat);

$qry_agncy = "SELECT * FROM ".$tblprefix."yatchagency" ;
$rs_agncy = $db->Execute($qry_agncy);
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yacht Prices</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
    </tr>
 	
	
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber" style="display:block;">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="manageprice" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0"  width="100%" >				
				<tr>
				<td class="txt2" width="25%" align="right">Is the Price? &nbsp;</td>
				<td>
				<select name="prw_prday" id="prw_prday" onchange="get_weekdays(this.value)">
				<option
				<?php
				if($rs_limit->fields['day_weekflag']==0)
				{
					echo 'selected="selected"';
				}
				?>
				 value="0">Per Day</option>
				<option value="1"
				<?php
				if($rs_limit->fields['day_weekflag']==1)
				{
					echo 'selected="selected"';
				}
				?>
				>Per Week</option>
				</select>
 				</td> 
				</tr>
				
				<tr>
					<td class="txt2" align="right">&nbsp;</td>
					<td>
					<div id="weekdays" style="display:none;">
						<select name="daysofweek" class="fields" id="daysofweek">
							<option value="0">Renting starts by:</option>
							<option value="1">Sunday</option>
							<option value="2">Monday</option>
							<option value="3">Tuesday</option>
							<option value="4">Wednesday</option>
							<option value="5">Thursday</option>
							<option value="6">Friday</option>
							<option value="7">Saturday</option>
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
				<td class="txt2" align="right">Agency: &nbsp;</td>
				<td>
				
				<select name="agency_id" id="agency_id">
				<option value="0">Select Agency</option>	
				<?php while(!$rs_agncy->EOF)
				{
				?>
					<option value="<?php echo $rs_agncy->fields['agn_id'];?>"
					<?php
					if($rs_limit->fields['agn_id']== $rs_agncy->fields['agn_id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_agncy->fields['agn_name'] ;?></option>
					<?php $rs_agncy->MoveNext();
				}
				?>
				</select>
				
 				</td> 
				</tr>
				
				<tr>
				<td class="txt2" align="right">Yacht Model: &nbsp;</td>
				<td>
				
				<select name="ymodel" id="ymodel">
				<option value="0">Select Yacht Model</option>	
				<?php while(!$rs_yat->EOF)
				{
				?>
					<option value="<?php echo $rs_yat->fields['id'];?>"
					<?php
					if($rs_limit->fields['yat_model']== $rs_yat->fields['id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_yat->fields['yatch_name'] ;?></option>
					<?php $rs_yat->MoveNext();
				}
				?>
				</select>
				
 				</td> 
				</tr>
				
				<tr>
					<td class="txt2" align="right">Start Range: &nbsp;</td>
					<td>
			 <input type="text" name="start_range"  id="start_range" value="<?php echo $rs_limit->fields['start_date'];?>" readonly="readonly"/>
			  <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'manageprice',
                                        // input name
                                        'controlname': 'start_range'
                                    });
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
			</script>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt2" align="right">End Range: &nbsp;</td>
					<td>
			 <input type="text" name="end_range"  id="end_range" value="<?php echo $rs_limit->fields['end_date'];?>" readonly="readonly" />
			  <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'manageprice',
                                        // input name
                                        'controlname': 'end_range'
                                    });
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
			</script>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt2" align="right">Price: &nbsp;</td>
					<td>
					<input type="text" name="yatprice" id="yatprice" value="<?php echo $rs_limit->fields['price'];?>" /> €
					
					</td>
				</tr>
				
                <tr>
                <td>&nbsp;
                
                </td>
                <td>
                <input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Set Price" class="button" />
                </td>
                </tr>
</table>				
</div>

<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']);?>" />
		<input type="hidden" name="act" value="change_yatprices">
		<input type="hidden" name="act2" value="change_yatprices">
		<input type="hidden" name="request_page" value="mng_yatprice" />
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
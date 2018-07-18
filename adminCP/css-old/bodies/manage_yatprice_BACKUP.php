<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."yatfacility_management" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);



$qry_limit = "SELECT * FROM ".$tblprefix."yatfacility_management "; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_yat = "SELECT * FROM ".$tblprefix."yatch" ;
$rs_yat = $db->Execute($qry_yat);

$qry_agncy = "SELECT * FROM ".$tblprefix."yatchagency" ;
$rs_agncy = $db->Execute($qry_agncy);
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yacht Prices
			</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number of Records Found: <?php echo $totalcountalpha ?></td>
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
 <div id="controls" class="add_subscriber">
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
				<option value="0">Per Day</option>
				<option value="1">Per Week</option>
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
					<option value="<?php echo $rs_agncy->fields['agn_id'];?>"><?php echo $rs_agncy->fields['agn_name'] ;?></option>
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
				<?php while(!$rs_yat->EOF){
				?>
					<option value="<?php echo $rs_yat->fields['id'];?>"><?php echo $rs_yat->fields['yatch_name'] ;?></option>
					<?php $rs_yat->MoveNext();
				}
				?>
				</select>
				
 				</td> 
				</tr>
				
				<tr>
					<td class="txt2" align="right">Start Range: &nbsp;</td>
					<td>
					
			 <input type="text" name="start_range"  id="start_range" value="" readonly="readonly"/>
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
			 <input type="text" name="end_range"  id="end_range" value="" readonly="readonly" />
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
					<input type="text" name="yatprice" id="yatprice" /> €
					
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
		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="manage_yatprice">
		<input type="hidden" name="act2" value="manage_yatprice">
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
  <tr>
    <td> <form action="admin.php" name="uniqueness" method="post" enctype="multipart/form-data">
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" >
			 
			  
			  </td>
		    </tr>
			
		
				<tr>
					<td class="txt2" align="right">Start Range: &nbsp;</td>
					<td>
			<?php	
				$date = date("m/d/Y");
				$newdate = strtotime ( '-1 week' , strtotime ( $date ) ) ;
				$newdate = date ( 'm/d/Y' , $newdate );
			?>
			 <input type="text" name="start_range"  id="start_range" value="<?php echo $newdate;?>" readonly="readonly"/>
			 <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'uniqueness',
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
			 <input type="text" name="end_range"  id="end_range" value="<?php echo date("m/d/Y");?>" readonly="readonly" />
			  <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'uniqueness',
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
				<td class="txt2" align="right">Yacht Model: &nbsp;</td>
				<td>
				<?php
				$qry_yat = "SELECT * FROM ".$tblprefix."yatch" ;
				$rs_yat = $db->Execute($qry_yat);
				?>
				<select name="ymodel" id="ymodel" onchange="document.uniqueness.submit()">
				<option value="0">Select Yacht Model</option>	
				<?php 
				while(!$rs_yat->EOF)
				{
				?>
					<option value="<?php echo $rs_yat->fields['id'];?>"><?php echo $rs_yat->fields['yatch_name'] ;?></option>
					<?php $rs_yat->MoveNext();
				}
				?>
				</select>
				
 				</td> 
				</tr>
				
				<tr>
					<td class="txt2" align="right">Show Overview of Prices: &nbsp;</td>
					<td>
			
			 <select name="prwdayflag" id="prwdayflag">
			 <option value="0">Per Day</option>
			 <option value="1">Per Week</option>
			 </select>
					
					</td>
				</tr>
				
				
		</table>
		
		<input type="hidden" name="viewprices" id="viewprices" value="1"  />
		<input type="hidden" name="act" value="manage_yatprice">
		</form>	</td>
  </tr>
  
  <tr><td>
  <div id="properties_facilities">
  <?php
  if(isset($_POST['viewprices']) and $_POST['viewprices']=="1" and $_POST['prwdayflag']=="0")
  {
  	$ecplstartdate = explode("/",$_POST['start_range']);
	$ecplenddate = explode("/",$_POST['end_range']);
			
	$qry_overview = "SELECT yatpr.*,yat.yatch_name FROM `".$tblprefix."yatmng_price` as yatpr,`".$tblprefix."yatch` as yat WHERE yatpr.yat_model=yat.id and yatpr.start_date>='".$_POST['start_range']."' and yatpr.end_date<='".$_POST['end_range']."'";
	$rs_overview = $db->Execute($qry_overview);
	$totaloverview =  $rs_overview->RecordCount();
	
	?>
	
	
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
       
	  				<tr>
				<td colspan="13">
				<?php 
				if($totaloverview >0){
				    $rs_overview->MoveFirst();
				?>	
		<table cellpadding="1" cellspacing="0"  width="100%" style="background-color:#0066FF; color:#FFFFFF; font-weight:bold;">
					<tr>
					<td>
					Yacht Price Overview
					</td>
					</tr>
		</table>
			<?php 
			while(!$rs_overview->EOF){
			?>
			<table cellpadding="1" cellspacing="0"  width="100%">
			<tr style="background-color:#999999; color:#FFFFFF; font-weight:bold;" >
			        <td>
                    <?php echo $rs_overview->fields['yatch_name']; 
					echo "&nbsp;";
					?> 					
					</td> 
					<td><?php 
					$date=$rs_overview->fields['start_date'];
					$today=date($date);
				$month = date ("M",strtotime($today));
switch($month){
case 'Jan':
       echo 'January';
       break;

case 'Feb':
       echo "February";
       break;

case 'Mar':
        echo "March";
       break;

case 'apr':
        echo "April";
       break;


case 'May':
        echo "May";
       break;


case 'Jun':
        echo "June";
       break;


case 'Jul':
        echo "July";
       break;


case 'Aug':
        echo "August";
       break;


case 'Sep':
         echo "September";
       break;


case 'Oct':
        echo "October";
       break;


case 'Nov':
        echo "November";
       break;

case 'Dec':
        echo "December";
       break;

}

?></td>
					</tr>
					</table>
				<?php
				$rs_overview->MoveNext();
				}// while(!$rs_overview->EOF)
			    ?>
				</td>
				</tr>
<?php
}else{
 ?>				
				<tr>
				<td colspan="13" class="errmsg">No Rates  Found</td>
				</tr>
                </table>
	
	
	<?php

  }
  }
  ?>
	</div>
  </td></tr>
</table>
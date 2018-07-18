<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_room = "SELECT car_type from ".$tblprefix."car"; 
$rs_car = $db->Execute($qry_room);

$qry_faq = "SELECT * FROM ".$tblprefix."car_facility";
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);



$qry_limit = "SELECT cf.*,c.id as cid FROM `tbl_car_facility` as cf  INNER JOIN tbl_car as c ON c.id=cf.car_id";


/*$qry_limit = "SELECT * FROM ".$tblprefix."car_facility LIMIT $startRow,$maxRows"; */
$rs_limit = $db->Execute($qry_limit);

$qry_limit1 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=1"; 
$rs_limit1 = $db->Execute($qry_limit1);

$qry_limit2 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=2 "; 
$rs_limit2 = $db->Execute($qry_limit2);

$qry_limit3 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=3 "; 
$rs_limit3 = $db->Execute($qry_limit3);


$qry_limit4 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=4 "; 
$rs_limit4 = $db->Execute($qry_limit4);

$qry_limit5 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=5 "; 
$rs_limit5 = $db->Execute($qry_limit5);

$qry_limit6 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=6 "; 
$rs_limit6 = $db->Execute($qry_limit6);

$qry_limit7 = "SELECT * FROM ".$tblprefix."car_facility WHERE ".$tblprefix."car_facility.car_facility_type=7 "; 
$rs_limit7 = $db->Execute($qry_limit7);



$totalcountalpha =  $rs_limit->RecordCount();
$totalcountalpha1 =  $rs_limit1->RecordCount();
$totalcountalpha2 =  $rs_limit2->RecordCount();
$totalcountalpha3 =  $rs_limit3->RecordCount();
$totalcountalpha4 =  $rs_limit4->RecordCount();
$totalcountalpha5 =  $rs_limit5->RecordCount();
$totalcountalpha6 =  $rs_limit6->RecordCount();
$totalcountalpha7 =  $rs_limit7->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Car Type</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total Cars Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td  colspan="6">
	<div id="controls" class="add_subscriber">
        <form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	
		<tr>
	        <td>
  			Facility Name
		   	</td>
			<td><input type="text" name="car_facility_status" class="fields" id="car_facility_status" /></td>
        </tr>                    
   <tr>
		<tr><td>Kategorija sadr&#382;aja</<br /></td>
			   <td><select name="property_fac_category" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="">Select Category</option>
				<option value="1">car Ameneties</option>
				<option value="2">Media and Technology</option>
				<option value="3">Kitchen</option> 
				<option value="4">Bathcar</option>
				</select>
				</td></tr>
				<tr><td>car Type</td>
				<td>
					<select name="car_type" class="fields" id="<?php echo $rs_car->fields['car_type'] ?>">
				 	<option value="0">Select Car Type</option>
					<?php
					$rs_car->MoveFirst();
					while(!$rs_car->EOF){
										?>
		  			<option value="<?php echo $rs_car->fields['id'];?>" <?php echo $is_cat_selected; ?>  ><?php echo $rs_car->fields['car_type'];  ?></option>
					<?php
					$rs_car->MoveNext();
					}
					?>			
					</select>					
					</td>				
				</tr>
				<tr>
				<tr><td>Facility Status</<br />
			   <td><select name="car_facility_status" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="0">No</option>
				<option value="1">Yes</option>
				</select>
				</td></td>
				
             <tr></tr>  
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Add Car Facility" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="manage_car_facility" />
			<input type="hidden" name="request_page" value="car_facility_management" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="add">
		</form>
      </div></td>
  </tr>
 
   
    <tr>
    <td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
     <tr>
     <td colspan="8" >
	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			<tr><td>Car Type</td><!--<td><select name="car_type" id="<?php //echo $rs_limit->fields['room_type']; ?>">
			
				<option value="0">Select Room Type</option>
				<option value="1">Stodio</option>
				<option value="2">Apartment</option>
				<option value="3">Large Room</option>
				</select>-->
				
				<td>
					<select name="car_type" class="fields" id="<?php echo $rs_car->fields['car_type'] ?>" onchange="get_room_facilities('propertyroom', this.value, '<?php echo MYSURL."ajaxresponse/get_room_facilities.php"?>')">
				 	<option value="0">Select Car Type</option>
					<?php
					$rs_car->MoveFirst();
					while(!$rs_car->EOF){
										?>
		  			<option value="<?php echo $rs_car->fields['id'];?>" <?php echo $is_cat_selected; ?>  ><?php echo $rs_car->fields['car_type'];  ?></option>
					<?php
					$rs_car->MoveNext();
					}
					?>			
					</select>					
					</td>
				<!--</td>--><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<tr><td></td></tr>
				</table>
		   </td>
		  </tr>
		  <tr><td> <div id="propertyroom"></div></td></tr>
		</table>
	</td>
	</tr>
   </table>
	

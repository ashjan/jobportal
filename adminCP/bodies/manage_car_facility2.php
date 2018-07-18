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

$qry_faq = "SELECT * FROM ".$tblprefix."car_facility" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."car_facility LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//Dropdown for parent
$category_qry = "select * from ".$tblprefix."car";
$rs_category = $db->Execute($category_qry);

//Dropdown for parent
$category_qry1 = "select * from ".$tblprefix."car";
$rs_category1 = $db->Execute($category_qry1);

//Dropdown for parent
$property_qry = "select agn_id,agn_name FROM ".$tblprefix."agency";
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Car Facility</td>
  </tr>
  <tr>
    <td colspan="8" align="center" 
	<?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> >
	<?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?>
	</td>
  </tr>
  
    <tr class="tabheading">
    <td colspan="6" align="right">
	
	<a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > 
	  <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> 
	</a> 
	  </td>
  </tr>
  <tr>
    <td colspan="6">
	  <div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="POST"  enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
           
		   
		   <tr>
				<td class="txt2">Select Car:</td>
					<td>
					<select name="car_name" class="fields" id="car_name" onChange="get_car_facility('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_car_facility.php"?>')">
				 	<option value="0">Select Car</option>
					<?php
					$rs_category1->MoveFirst();
					while(!$rs_category1->EOF){
					?>
		  			<option value="<?php echo $rs_category1->fields['id'];?>"><?php echo $rs_category1->fields['car_name'];  ?></option>
					<?php
					$rs_category1->MoveNext();
					}
					?>			
					</select>					
					</td>
			</tr>
			
			
		   
			<tr>
				<td class="txt2">Select Car Agency:</td>
					<td>
					<div id="property_id">
					<select name="property_id" class="fields" id="property_id">
				 	<option value="0">Select Agency Name</option>
					</select></div>					
					</td>
			</tr>
		   
		   
		   
		   
		   <tr>
			<td>Kategorija sadr&#382;aja </td>
			   <td><select name="fac_cat_id" id="fac_cat_id" class="fields1"
			   onchange="get_car_fac_name('facility_name', this.value, '<?php echo MYSURL."ajaxresponse/get_car_fac_name.php"?>')"
			    >
				<option value="">Select Category</option>
				<option 
				
				value="1">General</option>
				<option value="2">Activities</option>
				<option value="3">Services</option>
				</select>
				</td>
		</tr>
		   
		   
		   
		    <tr>
              <td> Facilities </td>
			  <?php
	
				?>
              <td>
			  <div id="facility_name">
			  <select  name="fac_id" id="fac_id"  multiple="multiple" size="5" class="fields1">
			      <option value="0">Izaberite sadr&#382;aj</option>
			  </select>
			 </div> 
			  </td>
            </tr>
					
        
            
			<tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Facilities" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_facility" />
          <input type="hidden" name="request_page" value="facility_management" />
          <input type="hidden" name="mode" value="add"/>
        </form>
      </div></td>
  </tr>

    <tr>
	<td>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
				<td class="txt2">Select Car Name:</td>
					<td>
					<form action="admin.php" method="post" enctype="multipart/form-data">
					<select name="pm_id" class="fields" id="pm_id" onChange="get_agency_name('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_agency_name.php"?>')">
				 	<option value="0">Select Car Name</option>
					<?php
					$rs_category->MoveFirst();
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>" ><?php echo $rs_category->fields['car_name'];  ?></option>
					<?php
					$rs_category->MoveNext();
					}
					?>			
					</select>	
					
					<div id="property_id1">
					<select name="property_id"class="fields" id="property_id" onChange="get_facilities('get_car_facility', this.value, '<?php echo MYSURL."ajaxresponse/get_car_facility.php"?>')">
				 	<option value="0">Select Agency Name</option>
					</select>
					</div>
					</form>				
					</td>
				</tr>
	</table>
	</td>
	</tr>

	<tr>
    <td> 
    <div id="properties_facilities">
	</div>
</td>
</tr>
</table>

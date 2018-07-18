<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE rf.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
			$qry_prop = "SELECT  id,property_name,property_category FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
						AND pm_type=1 
						AND '.$tblprefix.'properties.property_category=24';
			$rs_prop = $db->Execute($qry_prop);
			$count_add =  $rs_prop->RecordCount();
	}else{
		$module_pm_where = ' ';
	}	
	
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_room = "SELECT room_type from tbl_rooms "; 
$rs_room = $db->Execute($qry_room);

$qry_faq = "SELECT * FROM ".$tblprefix."room_facility " ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT rf.*,rm.id as rid,rm.room_type  FROM `tbl_room_facility` as rf  INNER JOIN tbl_rooms as rm ON rm.id=rf.rm_id 
$module_pm_where ";
/*$qry_limit = "SELECT * FROM ".$tblprefix."room_facility LIMIT $startRow,$maxRows"; */
$rs_limit = $db->Execute($qry_limit);

$qry_limit1 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=1"; 
$rs_limit1 = $db->Execute($qry_limit1);

$qry_limit2 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=2 "; 
$rs_limit2 = $db->Execute($qry_limit2);

$qry_limit3 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=3 "; 
$rs_limit3 = $db->Execute($qry_limit3);

$qry_limit4 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=4 "; 
$rs_limit4 = $db->Execute($qry_limit4);

$totalcountalpha =  $rs_limit->RecordCount();
$totalcountalpha1 =  $rs_limit1->RecordCount();
$totalcountalpha2 =  $rs_limit2->RecordCount();
$totalcountalpha3 =  $rs_limit3->RecordCount();
$totalcountalpha4 =  $rs_limit4->RecordCount();
$qry_property_manag = "SELECT ".$tblprefix."users.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_prop_manag = $db->Execute($qry_property_manag);
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Room Facility Management&nbsp;[Upravljanje sadr&#382;ajima u sobi]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php 
	
	
		if(isset($_GET['okmsg']) or isset($_GET['errmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total Rooms facilities Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6">
	<div id="controls" class="add_subscriber">
        <form name="managemenufrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	
		
	 	    <?php
			if($_SESSION[SESSNAME]['pm_moduleid']==2){
			?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
			<?php
			}else{
			?>
	    <tr>
             <td>PM Name</td>
              <td>
			   
				<select name="first_name" id="pm_name_id" class="fields" onchange="get_prop_name5('pm_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name18.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_prop_manag->EOF){?>
							<option value="<?php echo $rs_prop_manag->fields['id'];?>"><?php echo $rs_prop_manag->fields['first_name'].' '.$rs_prop_manag->fields['last_name'];  ?></option>
						<?php
						$rs_prop_manag->MoveNext();
						}?>		
				</select>
			 
			  </td>
            </tr> 
			<?php } ?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="pm_name">  
			    <select name="pr_id" id="pr_id" class="fields" onchange="get_room_type2('room_type', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type3.php"?>')" />
					<option value="0">Izaberite objekat</option>
	<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){
	
$rs_prop->MoveFirst();
while(!$rs_prop->EOF){
?>
<option value="<?php echo $rs_prop->fields['id'];?>"><?php echo $rs_prop->fields['property_name'] ;?></option>
	<?php $rs_prop->MoveNext();
	}
	?>
	
	<?php  }	?>
				</select>
				</div>
			  </td>
            </tr>
			
			<tr><td>Room Type<br/>[Vrsta sobe]</td><td>
			<div id="room_type">
			<select name="room_type" class="dropfields" >
			  <option value="0">Izaberite sobu</option>
			</select>
      </div>
			</td></tr>
			
			                
   <tr>
		<tr><td>Facility Category<br />[Izaberite kategoriju sadr&#382;aja]</td>
			   <td><select class="fields" name="property_fac_category"  onchange="get_fac_name('facility_name', this.value, '<?php echo MYSURL."ajaxresponse/get_room_fac_name.php"?>')">
				<option value="">Izaberite kategoriju sadr&#382;aja</option>
				<option value="1">Room Ameneties</option>
				<option value="2">Media and Technology</option>
				<option value="3">Kitchen</option> 
				<option value="4">Bathroom</option>
				</select>
				</td></tr>
				<tr>
				<td>Facilities<br/>[Izaberite sadr&#382;aj]</td>
				 <td><div id="facility_name">
			  <select  name="fac_id" id="fac_id"  multiple="multiple" size="5" class="fields1">
			      <option value="0">Izaberite sadr&#382;aj</option>
			  </select>
			 </div> 
			 </td>
				</tr>
				<tr>
				<!--<tr><td>Facility Status</<br />
			   <td><select name="room_facility_status" id="<?php echo $rs_limit->fields['id']; ?>">
				<option value="0">No</option>
				<option value="1">Yes</option>
				</select>
				</td>
				
				
             <tr></tr>  -->
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:222px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Add Room Facility &nbsp;[Dodaj sadr&#382;aj sobe]" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="room_facility_management" />
			<input type="hidden" name="request_page" value="manage_room_facility" />
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
		    
			<?php
			if($_SESSION[SESSNAME]['pm_moduleid']==2){
			?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php
			}else{
			?>
			<tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_prop_name16('property_name1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name16.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
						<option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr> 
			<?php 
			}
			?>
			<tr>
             <td>Property Name</td>
              <td>
                    <div id="property_name1"> 
                    <select name="pr_id" id="pr_id" class="fields" onchange="get_room_type2('room_type1', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type11.php"?>')" />
                    <option value="0">Izaberite objekat</option>
                    <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){
                    $rs_prop->MoveFirst();
                    while(!$rs_prop->EOF){
                    ?>
                    <option value="<?php echo $rs_prop->fields['id'];?>"><?php echo $rs_prop->fields['property_name'] ;?></option>
                    <?php $rs_prop->MoveNext();
                    }
                     }	?>
                    </select>
                   </div>
			</td>
            </tr>
			<tr>
	        <td>
  			Room/Property Type<br/>[Tip sobe/objekta]
		   	</td>
			<td>
	<div id="room_type1">
			<select name="room_type1" class="dropfields" >
			  <option value="0">Izaberite sobu</option>
			</select>
   </div>
			</td>
        </tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<tr><td></td></tr>
					</tr>
					</table>
		   </td>
		  </tr>
		  <tr><td> <div id="propertyroom"></div></td></tr>
		</table>
	</td>
	</td>
	</tr>
   </table>
	
	
	



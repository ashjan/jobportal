<?php
include('root.php');
include($root.'include/file_include.php');
$propertyroomid=$_GET['id'];
$prid=$_GET['roomid']; 

 $tbl_properties = $tblprefix."properties";
 $qry_pm = "SELECT pm_id FROM ".$tbl_properties." WHERE id='".$prid."' "; 
$qry_execute = $db->Execute($qry_pm);
$tbl_room_facility = $tblprefix."room_facility";
$tbl_room_facility_management = $tblprefix."room_facility_management";
$qry_room = "SELECT room_type from tbl_rooms";
$rs_room = $db->Execute($qry_room);

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."room_facility" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 $qry_limit = "SELECT rf.*,rm.id as rid,rm.room_type  FROM `tbl_room_facility` as rf  
              INNER JOIN tbl_rooms as rm ON rm.id=rf.rm_id 
			  WHERE  rf.pm_id=".$propertyroomid ." AND rf.property_id=".$prid; 

//$qry_limit = "SELECT * FROM ".$tblprefix."room_facility"; 		  

/*$qry_limit = "SELECT * FROM ".$tblprefix."room_facility LIMIT $startRow,$maxRows"; */
$rs_limit = $db->Execute($qry_limit);

   $qry_limitrf = "SELECT * FROM ".$tblprefix."room_facility WHERE rm_id=".$prid; 
	 $rs_limitrf= $db->Execute($qry_limitrf);

	 
	  /* $qry_limit1 = "SELECT * 
               FROM ".$tblprefix."room_facility 
			   WHERE ".$tblprefix."room_facility.facility_type=1 
			   AND 
			   ".$tblprefix."room_facility.pm_id=".$propertyroomid ." 
			   AND 
			   ".$tblprefix."room_facility.property_id=".$prid; */

		//$qry_limit1 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=1 "; 	  
  $qry_limit1 = "SELECT ".$tbl_room_facility_management.".facility_name AS facility,".$tbl_room_facility_management.".id AS fid,
                 ".$tbl_room_facility.".*
                 FROM ".$tbl_room_facility_management."
                 INNER JOIN ".$tbl_room_facility." ON 
                 ".$tbl_room_facility_management.".id=".$tbl_room_facility.".fac_cat_id
                 WHERE ".$tbl_room_facility.".rm_id=".$propertyroomid." AND ".$tbl_room_facility.".property_id=".$prid." AND ".$tbl_room_facility_management.".room_fac_category=1 ";

  
 /*$qry_limit1 = "SELECT * 
               FROM ".$tblprefix."room_facility_management 
			   WHERE ".$tblprefix."room_facility_management.room_fac_category=1";*/
 
$rs_limit1 = $db->Execute($qry_limit1);

/* $qry_limit2 = "SELECT * 
               FROM ".$tblprefix."room_facility 
			   WHERE ".$tblprefix."room_facility.facility_type=2 
			   AND 
			    ".$tblprefix."room_facility.pm_id=".$propertyroomid ." AND ".$tblprefix."room_facility.property_id=".$prid; */ 

 //$qry_limit2 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=2 "; 			    

 /*$qry_limit2 = "SELECT * 
               FROM ".$tblprefix."room_facility_management 
			   WHERE ".$tblprefix."room_facility_management.room_fac_category=2"; */
 $qry_limit2 = "SELECT ".$tbl_room_facility_management.".facility_name AS facility,".$tbl_room_facility_management.".id AS fid,
                 ".$tbl_room_facility.".*
                 FROM ".$tbl_room_facility_management."
                 INNER JOIN ".$tbl_room_facility." ON 
                 ".$tbl_room_facility_management.".id=".$tbl_room_facility.".fac_cat_id
                 WHERE ".$tbl_room_facility.".rm_id=".$propertyroomid." AND ".$tbl_room_facility.".property_id=".$prid." AND ".$tbl_room_facility_management.".room_fac_category=2";

$rs_limit2 = $db->Execute($qry_limit2);

/* $qry_limit3 = "SELECT * 
               FROM ".$tblprefix."room_facility 
			   WHERE ".$tblprefix."room_facility.facility_type=3 
			    AND  
			   ".$tblprefix."room_facility.pm_id=".$propertyroomid ." AND ".$tblprefix."room_facility.property_id=".$prid; */


 //$qry_limit3 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=3 "; 			     


 /*$qry_limit3 = "SELECT * 
               FROM ".$tblprefix."room_facility_management 
			   WHERE ".$tblprefix."room_facility_management.room_fac_category=3"; */
 $qry_limit3 = "SELECT ".$tbl_room_facility_management.".facility_name AS facility,".$tbl_room_facility_management.".id AS fid,
                 ".$tbl_room_facility.".*
                 FROM ".$tbl_room_facility_management."
                 INNER JOIN ".$tbl_room_facility." ON 
                 ".$tbl_room_facility_management.".id=".$tbl_room_facility.".fac_cat_id
                 WHERE ".$tbl_room_facility.".rm_id=".$propertyroomid." AND ".$tbl_room_facility.".property_id=".$prid." AND ".$tbl_room_facility_management.".room_fac_category=3 ";

$rs_limit3 = $db->Execute($qry_limit3);


/* $qry_limit4 = "SELECT * FROM ".$tblprefix."room_facility WHERE ".$tblprefix."room_facility.facility_type=4  
			    AND  
			   ".$tblprefix."room_facility.pm_id=".$propertyroomid."  
			    AND ".$tblprefix."room_facility.property_id=".$prid;*/
				
				/*$qry_limit4 = "SELECT * 
               FROM ".$tblprefix."room_facility_management 
			   WHERE ".$tblprefix."room_facility_management.room_fac_category=4";  */
				$qry_limit4 = "SELECT ".$tbl_room_facility_management.".facility_name AS facility,".$tbl_room_facility_management.".id AS fid,
                 ".$tbl_room_facility.".*
                 FROM ".$tbl_room_facility_management."
                 INNER JOIN ".$tbl_room_facility." ON 
                 ".$tbl_room_facility_management.".id=".$tbl_room_facility.".fac_cat_id
                 WHERE ".$tbl_room_facility.".rm_id=".$propertyroomid." AND ".$tbl_room_facility.".property_id=".$prid." AND ".$tbl_room_facility_management.".room_fac_category=4";

				$rs_limit4 = $db->Execute($qry_limit4);
					$totalcountalphar =  $rs_room->RecordCount(); 
					$totalcountalpha  =  $rs_limit->RecordCount(); 
					$totalcountalpha1 =  $rs_limit1->RecordCount(); 
					$totalcountalpha2 =  $rs_limit2->RecordCount(); 
					$totalcountalpha3 =  $rs_limit3->RecordCount(); 
					$totalcountalpha4 =  $rs_limit4->RecordCount(); 
?>


	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
			<tr height="5%">
			<td colspan="4" ></td>
		    </tr>
			<tr class="tabheading">
				<!--
				<td width="5%">Room Ameneties</td>
				<td width="8%">Media and Technology</td>
				<td width="5%">Kitchen</td>
				<td width="5%">Bathroom</td>
				-->
                <td width="5%">Pogdnosti u sobi</td>
				<td width="8%">Mediji i tehnologija</td>
				<td width="5%">Kuhinja</td>
				<td width="5%">Kupatilo</td>
				
		    </tr>
					
			<tr><td colspan="4">		
					<table cellpadding="2" cellspacing="2" border="0" width="100%" class="txt">
					
					<!--<tr>
					<td class="txt" width="35%"> Remove</td>
					<td class="txt" width="25%">Remove</td>
					<td class="txt" width="25%">Remove</td>
					<td class="txt" width="25%">Remove</td>
					</tr>-->
                    
                    <tr>
					<td class="txt" width="35%">Remove</td>
					<td class="txt" width="25%">Remove</td>
					<td class="txt" width="25%">Remove</td>
					<td class="txt" width="25%">Remove</td>
					</tr>
					 <div id = $propertyroom> 
				<tr>
				<td valign="top" width="25%" height="300">
				<form action="admin.php" method="post" name="genrl" enctype="multipart/form-data">
					<table cellpadding="0" cellspacing="0" border="0" height="300" class="txt">
					 
					 <?php 
					if($totalcountalpha1 >0){
					$rs_limit1->MoveFirst();
					
					while(!$rs_limit1->EOF){
			  $qry_mon= "SELECT  
               lan.translated_text  
			   FROM ".$tblprefix."language_contents AS lan 
			   WHERE 
			   lan.page_id = '".$rs_limit1->fields['fid']."'   
			    AND 
			   lan.fld_type = 'room_facility' 
			    AND 
			   lan.field_name = 'room_facility_mon' 
			    AND 
			   lan.language_id = '7' ";
		 $rs_mon   = $db->Execute($qry_mon);
		 $totalmon = $rs_mon->RecordCount();
		 $translated_mon ="";
		 if($totalmon >0){while(!$rs_mon->EOF){ $translated_mon = $rs_mon->fields['translated_text'];$rs_mon->MoveNext();}} 
		 if($translated_mon=="" or $translated_mon ==' ' or $translated_mon == NULL){$translated_mon = $rs_limit1->fields['facility_name'];}
		?>
		<input type="checkbox" value = "<?php echo $rs_limit1->fields['id']; ?>"  name="room_aminities[]"/>
        <?php echo $translated_mon; ?><br/>
					 <?php $rs_limit1->MoveNext();
			        } 
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
					<!--<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete Room Ameneties" class="button"  />-->
                    <input style="margin:5px; width:142px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Izbriši pogodnosti u sobi" class="button"  />
                    </td></tr>
					<input type="hidden" name="act" value="room_facility_management1"  />
			        <input type="hidden" name="request_page" value="manage_room_facility1" />
					<input type="hidden" name="mode" value="delete_room_ameneties1">
					<input type="hidden" name="first_name" value="<?php echo $qry_execute->fields['pm_id']?>" />
					<input type="hidden" name="property_id" value="<?php echo $prid?>" />
					<input type="hidden" name="room_id" value="<?php echo $propertyroomid?>"/>
					
					</table></form>
				</td>
				
				<!--Code for the second column of radio button-->
				<td valign="top" width="25%"  height="300">
				<form action="admin.php" method="post" enctype="multipart/form-data">
					    <table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					
					<?php 
					if($totalcountalpha2 >0){
					$rs_limit2->MoveFirst();
					
					while(!$rs_limit2->EOF){
				$qry_mon= "SELECT  
               lan.translated_text  
			   FROM ".$tblprefix."language_contents AS lan 
			   WHERE 
			   lan.page_id = '".$rs_limit2->fields['fid']."'   
			    AND 
			   lan.fld_type = 'room_facility' 
			    AND 
			   lan.field_name = 'room_facility_mon' 
			    AND 
			   lan.language_id = '7' ";
		 $rs_mon   = $db->Execute($qry_mon);
		 $totalmon = $rs_mon->RecordCount();
		 $translated_mon ="";
		 if($totalmon >0){while(!$rs_mon->EOF){ $translated_mon = $rs_mon->fields['translated_text'];$rs_mon->MoveNext();}} 
		 if($translated_mon=="" or $translated_mon ==' ' or $translated_mon == NULL){$translated_mon = $rs_limit2->fields['facility_name'];}
					?>
					<input type="checkbox" value = "<?php echo $rs_limit2->fields['id']; ?>"  name="mdeia_n_tech[]"/>
             <?php echo $translated_mon; ?><br/>
					 <?php $rs_limit2->MoveNext();
										
			        } 
					}
					?>
					<tr valign="bottom" ><td valign="bottom">
					<!--<input style="margin:5px; width:145px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete Media n Technology" class="button"  />-->
                    
                    <input style="margin:5px; width:222px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Izbrišite sadr&#382;aj za medije i tehnologiju" class="button"  />
					</td></tr>
					<input type="hidden" name="act" value="room_facility_management1"  />
			        <input type="hidden" name="request_page" value="manage_room_facility1" />
					<input type="hidden" name="mode" value="delete_media_n_tech1">
					<input type="hidden" name="first_name" value="<?php echo $qry_execute->fields['pm_id']?>" />
					<input type="hidden" name="property_id" value="<?php echo $prid?>" />
					<input type="hidden" name="room_id" value="<?php echo $propertyroomid?>"/>
					
					
					</table>
					</form>
				</td>
				
				
<!--Code for the third column of radio button-->
					 <td valign="top" width="25%" height="300"><form action="admin.php" method="post" enctype="multipart/form-data">
					 <table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					<?php 
					if($totalcountalpha3 >0){
					$rs_limit3->MoveFirst();
				while(!$rs_limit3->EOF){
				$qry_mon= "SELECT  
               lan.translated_text  
			   FROM ".$tblprefix."language_contents AS lan 
			   WHERE 
			   lan.page_id = '".$rs_limit3->fields['fid']."'   
			    AND 
			   lan.fld_type = 'room_facility' 
			    AND 
			   lan.field_name = 'room_facility_mon' 
			    AND 
			   lan.language_id = '7' ";
		 $rs_mon   = $db->Execute($qry_mon);
		 $totalmon = $rs_mon->RecordCount();
		 $translated_mon ="";
		 if($totalmon >0){while(!$rs_mon->EOF){ $translated_mon = $rs_mon->fields['translated_text'];$rs_mon->MoveNext();}} 
		 if($translated_mon=="" or $translated_mon ==' ' or $translated_mon == NULL){$translated_mon = $rs_limit3->fields['facility_name'];}
				
				?>
					<input type="checkbox" value = "<?php echo $rs_limit3->fields['id']; ?>"  name="food_n_drinks[]"/>
             <?php echo $translated_mon; ?><br/>
					 <?php $rs_limit3->MoveNext();
			}
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
					<!--<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete Kitchen" class="button"  />-->
                    
                    <input style="margin:5px; width:145px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Izbrišite opremu kuhinje" class="button"  />
                    </td></tr>
					<input type="hidden" name="act" value="room_facility_management1"  />
			        <input type="hidden" name="request_page" value="manage_room_facility1" />
					<input type="hidden" name="mode" value="delete_food_n_drinks1">
					<input type="hidden" name="first_name" value="<?php echo $qry_execute->fields['pm_id']?>" />
					<input type="hidden" name="property_id" value="<?php echo $prid?>" />
					<input type="hidden" name="room_id" value="<?php echo $propertyroomid?>"/>
					
					
					</table></form>
					</td>
					
				<td valign="top" width="25%" height="300"><form action="admin.php" method="post" enctype="multipart/form-data">
					<table cellpadding="0" cellspacing="0" border="0" height="300">
					 
					<?php 
					if($totalcountalpha4 >0){
					$rs_limit4->MoveFirst();
					while(!$rs_limit4->EOF){
					
					
					$qry_mon= "SELECT  
               lan.translated_text  
			   FROM ".$tblprefix."language_contents AS lan 
			   WHERE 
			   lan.page_id = '".$rs_limit4->fields['fid']."'   
			    AND 
			   lan.fld_type = 'room_facility' 
			    AND 
			   lan.field_name = 'room_facility_mon' 
			    AND 
			   lan.language_id = '7' ";
		 $rs_mon   = $db->Execute($qry_mon);
		 $totalmon = $rs_mon->RecordCount();
		 $translated_mon ="";
		 if($totalmon >0){while(!$rs_mon->EOF){ $translated_mon = $rs_mon->fields['translated_text'];$rs_mon->MoveNext();}} 
		 if($translated_mon=="" or $translated_mon ==' ' or $translated_mon == NULL){$translated_mon = $rs_limit4->fields['facility_name'];}
					?>
					<input type="checkbox" value = "<?php echo $rs_limit4->fields['id']; ?>"  name="bathroom[]"/>
             <?php echo $translated_mon; ?><br/>
					 <?php $rs_limit4->MoveNext();
					}
					}
					?>
					<tr valign="bottom" >
					<td valign="bottom">
					<!--<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete BathRoom" class="button"/>-->
        			<input style="margin:5px; width:145px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Izbrišite opremu kupatila" class="button"/>
				</td></tr>
					<input type="hidden" name="act" value="room_facility_management1"  />
			        <input type="hidden" name="request_page" value="manage_room_facility1" />
					<input type="hidden" name="mode" value="delete_bathroom1">
					<input type="hidden" name="first_name" value="<?php echo $qry_execute->fields['pm_id']?>" />
					<input type="hidden" name="property_id" value="<?php echo $prid?>" />
					<input type="hidden" name="room_id" value="<?php echo $propertyroomid?>"/>
					</table>
					</td></form>
					</tr>
				
				
					</div>
</table>
</td></tr>
</table>


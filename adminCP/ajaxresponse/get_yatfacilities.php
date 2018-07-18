<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];


$tbl_prop_fac= $tblprefix."yacht_facility";
$tbl_prop_fac_mng= $tblprefix."yatfacility_management";

 $qry_limit = "SELECT ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".facility_type,
					  ".$tbl_prop_fac.".yatch_id,
					  ".$tbl_prop_fac.".yacht_facility_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".yat_fac_category
               FROM ".$tbl_prop_fac."    
			   INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
			   WHERE ".$tbl_prop_fac.".yatch_id=".$propertymanagerid;
	   
			    
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



$qry_limit1 = "SELECT 
                      ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".facility_type,
					  ".$tbl_prop_fac.".yatch_id,
					  ".$tbl_prop_fac.".yacht_facility_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".yat_fac_category
			  FROM ".$tbl_prop_fac."   
			  INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
              WHERE ".$tbl_prop_fac.".facility_type=1 
			  AND ".$tbl_prop_fac.".yatch_id=".$propertymanagerid; 
			  
			  
$rs_limit1 = $db->Execute($qry_limit1);
$totalcountalpha1 =  $rs_limit1->RecordCount();

$qry_limit2 = "SELECT ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".facility_type,
					  ".$tbl_prop_fac.".yatch_id,
					  ".$tbl_prop_fac.".yacht_facility_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".yat_fac_category
               FROM ".$tbl_prop_fac."    
			   INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
			   WHERE ".$tbl_prop_fac.".facility_type=2 
			   AND ".$tbl_prop_fac.".yatch_id=".$propertymanagerid;
			   
			    
$rs_limit2 = $db->Execute($qry_limit2);
$totalcountalpha2 =  $rs_limit2->RecordCount();

 $qry_limit3 = "SELECT ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".facility_type,
					  ".$tbl_prop_fac.".yatch_id,
					  ".$tbl_prop_fac.".yacht_facility_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".yat_fac_category
			   FROM ".$tbl_prop_fac."
			   INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
			   WHERE ".$tbl_prop_fac.".facility_type=3 
			   AND ".$tbl_prop_fac.".yatch_id=".$propertymanagerid;
			   

$rs_limit3 = $db->Execute($qry_limit3);
$totalcountalpha3 =  $rs_limit3->RecordCount();





//Dropdown for parent
$category_qry = "select * from ".$tblprefix."property_manager ";
$rs_category = $db->Execute($category_qry);

?>


 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading">
        <!--<td width="3%">Sr#</td>-->
        <td width="33%">General</td>
        <td width="33%">Activities</td>
        <td width="33%">Services</td>
      </tr>
	  <tr>
					<td class="txt" width="35%"> Select</td>
					<td class="txt" width="25%">  Select</td>
					<td class="txt" width="25%">  Select</td>
	</tr>
      <tr>
        
		<td valign="top"><form action="<?php echo MYSURL;?>admin.php" method="post" name="getfac" enctype="multipart/form-data">
		<table class="txt">
		
            <?php 
				    if($totalcountalpha1 >0){
					while(!$rs_limit1->EOF) {
			              ?>
            <tr valign="top">
              <td valign="top">
		<input type="checkbox" value = "<?php echo $rs_limit1->fields['f_id']; ?>"  name="activities[]"/>
             <?php echo $rs_limit1->fields['facility_name']; ?>
				
				
				
				</td>
				<td>
			
			
			
				</td>
            </tr>
            <?php 
						$rs_limit1->MoveNext();
						} 
						}
						?>
				<tr valign="bottom" >
					<td valign="bottom">
					<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete General" class="button" />	
					<input type="hidden" name="act" value="manageyacht_facility"  />
			        <input type="hidden" name="request_page" value="yatfacility_management" />
					<input type="hidden" name="mode" value="del">
					</td>
				</tr>
				  
          </table>
		  </form>
		  </td> 
		
        <td valign="top">
		<form action="admin.php" method="post" enctype="multipart/form-data">
		<table class="txt">
		
            <?php 
				    if($totalcountalpha2 >0){
					while(!$rs_limit2->EOF) {
			              ?>
            <tr valign="top"><td valign="top"> 
	
<input type="checkbox" value = "<?php echo $rs_limit2->fields['f_id']; ?>"   name="activities[]"/>
		
              <?php echo $rs_limit2->fields['facility_name']; ?> </td>
			  <td>
			  
			  </td>
            </tr>
            <?php    $rs_limit2->MoveNext();
						}
						}
						 ?>
						 <tr valign="bottom" ><td valign="bottom">
					<input style="margin:5px; width:145px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete Activities" class="button"  />
					</td></tr>
					<input type="hidden" name="act" value="manageyacht_facility"  />
			        <input type="hidden" name="request_page" value="yatfacility_management" />
					<input type="hidden" name="mode" value="del">
					</form>
          </table>
		  </form>
		  </td>
        <td valign="top"><form action="admin.php" method="post" enctype="multipart/form-data">
		<table class="txt">
		
            <?php 
				    	if($totalcountalpha3 >0){
						while(!$rs_limit3->EOF) {
			              ?>
            <tr valign="top"> <td valign="top"> 
					 
 <input type="checkbox" value = "<?php echo $rs_limit3->fields['f_id']; ?>"  name="activities[]"/>
             <?php echo $rs_limit3->fields['facility_name']; ?>
			 
			 
			 </td>
			  <td>&nbsp;
   			  
			  </td>
            </tr>
			
            <?php 
						$rs_limit3->MoveNext();
						} 
						}
						?>
						<tr valign="bottom" >
					<td valign="bottom">
		<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Delete Services" class="button"  /></td></tr>
					<input type="hidden" name="act" value="manageyacht_facility"  />
			        <input type="hidden" name="request_page" value="yatfacility_management" />
					<input type="hidden" name="mode" value="del">
					
          </table></form></td>
      </tr>
        
  <tr>
    <td>&nbsp;</td>
  </tr>

</table>
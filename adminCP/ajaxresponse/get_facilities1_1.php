<?php
include('root.php');
include($root.'include/file_include.php');
$propertymanagerid=$_GET['id'];


$tbl_prop_fac= $tblprefix."property_facilities";
$tbl_prop_fac_mng= $tblprefix."facility_management";

 $qry_limit = "SELECT ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".fac_cat_id,
					  ".$tbl_prop_fac.".property_id,
					  ".$tbl_prop_fac.".property_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".property_fac_category
               FROM ".$tbl_prop_fac."    
			   INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
			   WHERE ".$tbl_prop_fac.".property_id=".$propertymanagerid;
	   
			    
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



$qry_limit1 = "SELECT 
                      ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".fac_cat_id,
					  ".$tbl_prop_fac.".property_id,
					  ".$tbl_prop_fac.".property_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".property_fac_category
			  FROM ".$tbl_prop_fac."   
			  INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
              WHERE ".$tbl_prop_fac.".fac_cat_id=1 
			  AND ".$tbl_prop_fac.".property_id=".$propertymanagerid; 
			  
			  
$rs_limit1 = $db->Execute($qry_limit1);
$totalcountalpha1 =  $rs_limit1->RecordCount();

$qry_limit2 = "SELECT ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".fac_cat_id,
					  ".$tbl_prop_fac.".property_id,
					  ".$tbl_prop_fac.".property_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".property_fac_category
               FROM ".$tbl_prop_fac."    
			   INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
			   WHERE ".$tbl_prop_fac.".fac_cat_id=2 
			   AND ".$tbl_prop_fac.".property_id=".$propertymanagerid;
			   
			    
$rs_limit2 = $db->Execute($qry_limit2);
$totalcountalpha2 =  $rs_limit2->RecordCount();

 $qry_limit3 = "SELECT ".$tbl_prop_fac.".id as f_id,
                      ".$tbl_prop_fac.".fac_id,
					  ".$tbl_prop_fac.".fac_cat_id,
					  ".$tbl_prop_fac.".property_id,
					  ".$tbl_prop_fac.".property_status,
					  ".$tbl_prop_fac.".pm_id,
					  ".$tbl_prop_fac_mng.".id as f_mng_id,
					  ".$tbl_prop_fac_mng.".facility_name,
					  ".$tbl_prop_fac_mng.".property_fac_category
			   FROM ".$tbl_prop_fac."
			   INNER JOIN ".$tbl_prop_fac_mng." ON ".$tbl_prop_fac_mng.".id=".$tbl_prop_fac.".fac_id 
			   WHERE ".$tbl_prop_fac.".fac_cat_id=3 
			   AND ".$tbl_prop_fac.".property_id=".$propertymanagerid;
			   

$rs_limit3 = $db->Execute($qry_limit3);
$totalcountalpha3 =  $rs_limit3->RecordCount();





//Dropdown for parent
$category_qry = "select * from ".$tblprefix."property_manager ";
$rs_category = $db->Execute($category_qry);

//Dropdown for parent
$pro_qry = "select * from ".$tblprefix."properties ";
$rs_pro = $db->Execute($pro_qry);

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
					<input type="hidden" name="act" value="manage_facility1"  />
			        <input type="hidden" name="request_page" value="manage_prop_facility1" />
					<input type="hidden" name="mode" value="del">
					<input type="hidden" name="pr_id" value="<?php echo base64_encode($rs_pro->fields['id']);?>">
					<input type="hidden" name="pm_id" value="<?php echo base64_encode($rs_category->fields['id']);?>">
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
					<input type="hidden" name="act" value="manage_facility1"  />
			        <input type="hidden" name="request_page" value="manage_prop_facility1" />
					<input type="hidden" name="mode" value="del">
					<input type="hidden" name="pr_id" value="<?php echo base64_encode($rs_pro->fields['id']);?>">
					<input type="hidden" name="pm_id" value="<?php echo base64_encode($rs_category->fields['id']);?>">
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
		<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Remove Services" class="button"  /></td></tr>
					<input type="hidden" name="act" value="manage_facility1"  />
			        <input type="hidden" name="request_page" value="manage_prop_facility1" />
					<input type="hidden" name="mode" value="del">
					<input type="hidden" name="pr_id" value="<?php echo base64_encode($rs_pro->fields['id']);?>">
					<input type="hidden" name="pm_id" value="<?php echo base64_encode($rs_category->fields['id']);?>">
					
          </table></form></td>
      </tr>
        
  <tr>
    <td>&nbsp;</td>
  </tr>
<!--  <tr>
    <td colspan="2">
	  <input type="hidden" name="act" value="manageletter">
      <input type="hidden" name="mode" value="delete">
    </td>
  </tr>-->
</table>
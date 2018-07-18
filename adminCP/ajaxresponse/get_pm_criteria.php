<?php
include('root.php');
include($root.'include/file_include.php');
$pm_id=$_GET['pm_id'];
$prop_id=$_GET['prop_id'];


$tbl_pm_prop_criteria= $tblprefix."pm_property_criteria";
$tbl_reviews = $tblprefix."reviews";

 $qry_limit = "SELECT ".$tbl_pm_prop_criteria.".id,
                      ".$tbl_pm_prop_criteria.".criteria_id
			   FROM ".$tbl_pm_prop_criteria."    
			   WHERE ".$tbl_pm_prop_criteria.".property_id=".$prop_id." AND ".$tbl_pm_prop_criteria.".pm_id=".$pm_id;
	   
		    
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



$qry_limit1 = "SELECT 
                      ".$tbl_reviews.".id,
                      ".$tbl_reviews.".reviews_name
			   FROM ".$tbl_reviews."";   
			  
			  
			  
$rs_limit1 = $db->Execute($qry_limit1);
$totalcountalpha1 =  $rs_limit1->RecordCount();


?>


 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading">
        <!--<td width="3%">Sr#</td>-->
        <td width="33%">Criteria</td>
         </tr>
	  <tr>
					<td class="txt" width="35%"> Select</td>
		
	</tr>
      <tr>
        
		<td valign="top"><form action="<?php echo MYSURL;?>admin.php" method="post" name="getfac" enctype="multipart/form-data">
		<table class="txt">
		
            <?php 
                    if($totalcountalpha>0){
				    if($totalcountalpha1 >0){
					while(!$rs_limit1->EOF) {
						$id = $rs_limit1->fields['id'];
						$explode_values = explode(',',$rs_limit->fields['criteria_id']);
			              ?>
            <tr valign="top">
              <td valign="top">
		<input type="checkbox" value = "<?php echo $rs_limit1->fields['id']; ?>"  
			              <?php if(in_array($id,$explode_values)){?> checked="checked"<?php }?>
			              name="criteria[]"/>
             <?php echo $rs_limit1->fields['reviews_name']; ?>
				
				
				
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
					<input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update General" class="button" />
					<input type="hidden" name="id"	 value="<?php echo base64_encode($rs_limit->fields['id']);?>">
					<input type="hidden" name="pm_id" value="<?php echo $pm_id?>">
					<input type="hidden" name="property_id" value="<?php echo $prop_id?>">
					<input type="hidden" name="act" value="manage_pm_criteria"  />
			        <input type="hidden" name="request_page" value="pm_criteria_management" />
					<input type="hidden" name="mode" value="update">
					</td>
				</tr>
			<?php }else {?>	  
			<tr valign="top">
			<td valign="top">No criteria selected</td>
			</tr>
			<?php }?>
          </table>
		  </form>
		  </td> 
		
        
<!--  <tr>
    <td colspan="2">
	  <input type="hidden" name="act" value="manageletter">
      <input type="hidden" name="mode" value="delete">
    </td>
  </tr>-->
</table>
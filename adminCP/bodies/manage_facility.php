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


if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}


$qry_faq = "SELECT * FROM ".$tblprefix."property_facilities $module_pm_where " ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."property_facilities $module_pm_where LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//Dropdown for parent
$category_qry =" SELECT ".$tblprefix."users.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_category = $db->Execute($category_qry);

//Dropdown for parent
$category_qry1 = "SELECT * FROM ".$tblprefix."users";
$rs_category1 = $db->Execute($category_qry1);

//Dropdown for parent
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']. ' AND pm_type=1';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

$qry_pm =  " SELECT ".$tblprefix."users.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";


$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;


?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Property Facility &nbsp;[Podešavanje politke objekta]</td>
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
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
		
			<tr>
				<td class="txt2">Select Property Name:<br/>[Izaberite objekat]</td>
					<td>
			
			<div id="property_id">
					<select name="property_id"class="fields" >
				 	<option value="0">Izaberite objekat</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
					</select>
					</div>
			
			</td>
			</tr>
			
            <?php
			}else{?>
			<tr>
	        <td style="border-left:1px solid #999999;">
  			Project Manager
		   	</td>
			<td style="border-right:1px solid #999999;">
			<select name="first_name" class="fields"   id="first_name" onchange="get_prop_nam_fac_add('property_ids', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_nam_fac_add.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if(isset($_SESSION["addproperty"]["first_name"]) and $_SESSION["addproperty"]["first_name"]==$rs_pm->fields['id']){ echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>					
			</td>
        </tr>
		<tr>
				<td class="txt2">Select Property Type:<br/>[Izaberite objekat]</td>
					<td>
					<div id="property_ids">
					<select name="property_id" class="fields" >
				 	<option value="0">Izaberite objekat</option>
					</select></div>					
					</td>
		 </tr>	
		<?php } ?>
	    
				
		  
		   <tr>
			<td>Facility Category <br/>[Izaberite kategoriju sadr&#382;aja]</td>
			   <td>
   <select name="fac_cat_id" id="fac_cat_id" class="fields1" 
	 onchange="get_fac_name('facility_name', this.value, '<?php echo MYSURL."ajaxresponse/get_fac_name.php"?>')">
				<option value="">Izaberite kategoriju sadr&#382;aja</option>
				<option 
				value="1">Opšte</option>
				<option value="2"
				
				>Aktivnosti</option>
				<option value="3"
				>Usluge</option>
				</select>
				</td>
		</tr>
		    <tr>
              <td> Facilities <br/>[Sadr&#382;aji]</td>
			  <?php
	
				?>
              <td>
			  <div id="facility_name">
			  <select  name="fac_id" id="fac_id"  multiple="multiple" size="5" class="fields1">
			      <option value="0">Izaberite Naziv sadr&#382;aja</option>
			  </select>
			 </div> 
			  </td>
            </tr>
					
        
            
			<tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:180px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Facilities&nbsp;[Dodaj sadr&#382;aj]" class="button" />
              </td>
            </tr>
			</table> 
          <input type="hidden" name="act" value="manage_facility" />
          <input type="hidden" name="request_page" value="facility_management" />
          <input type="hidden" name="mode" value="add"/>
        </form>
      </div> </td>
  </tr>

    <tr>
	<td>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
				<td class="txt2">Select Property :<br/>[Izaberte objekat]</td>
					<td>
					<form action="admin.php" name="uniqueness" method="post" enctype="multipart/form-data">
					
                    <?php
					if($_SESSION[SESSNAME]['pm_moduleid']!=2){
					?>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name11('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name11.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					if(isset($_GET['pm_id'])){
						$pm_id = base64_decode($_GET['pm_id']);
						}else{
						$pm_id = 0;
						}
					$rs_category->MoveFirst();
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>"
					<?php
						if($pm_id==$rs_category->fields['id']){echo 'selected="selected"';}
					?>
					><?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?></option>
					<?php
					$rs_category->MoveNext();
					}
					?>			
					</select>
					<div id="property_id">
					<?php
						//condition for selected dropdown start
					if(isset($_GET['pr_id'])){
						$pr_id = base64_decode($_GET['pr_id']);
						}else{
						$pr_id = 0;
						}
						//Dropdown for parent
						if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
                    	 $property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=1';
						$rs_prop = $db->Execute($property_qry);
						$totalprope =  $rs_prop->RecordCount();
						}
					//condition for selected dropdown ends
					?>
					<select name="property_id"class="fields" >
				 	<option value="0">Izaberite objekat</option>
					<?php
					if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
					$rs_prop->MoveFirst();
					while(!$rs_prop->EOF){ 
					?>
					<option value="<?php echo $rs_prop->fields['id']; ?>"
					 <?php 
 						if($pr_id==$rs_prop->fields['id']){echo 'selected="selected"';}
 					 ?>
					><?php echo $rs_prop->fields['property_name']; ?></option>
					<?php
					$rs_prop->MoveNext();
					}}
					?>
					</select>
					</div>
					<?php
					}else{
					?>
					<div id="property_id">
					
					<select name="property_id"class="fields" onchange="get_facilities('properties_facilities', this.value, '<?php echo MYSURL."ajaxresponse/get_facilities.php"?>')" >
				 	<option value="0">Izaberite objekat</option>
					<?php  
						
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>" ><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
					</select>
					</div>
					</form>				
					<?php } ?>
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
           <?php
           /* if($_SESSION[SESSNAME]['pm_moduleid']==2){
			?>
            <script language="javascript">
	        get_facilities('properties_facilities', <?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_facilities.php"?>');
			</script>
            <?php }*/ ?>
			<?php
			 if(isset($_GET['pr_id']) && $_GET['pr_id']!='' && isset($_GET['pm_id']) && $_GET['pm_id']!=''){
			 $propertymanagerid=base64_decode($_GET['pr_id']);


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
$category_qry = "select * from ".$tblprefix."users ";
$rs_category = $db->Execute($category_qry);

?>


 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading">
        <!--<td width="3%">Sr#</td>-->
        <td width="33%">General<br/>[Opšte]</td>
        <td width="33%">Activities<br/>[Aktivnosti]</td>
        <td width="33%">Services<br/>[Usluge]</td>
      </tr>
	  <tr>
					<td class="txt" width="35%"> Select<br/>[Izaberite]</td>
					<td class="txt" width="25%">  Select<br/>[Izaberite]</td>
					<td class="txt" width="25%">  Select<br/>[Izaberite]</td>
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
					<input type="hidden" name="act" value="manage_facility"  />
			        <input type="hidden" name="request_page" value="manage_prop_facility" />
					<input type="hidden" name="mode" value="del">
					<input type="hidden" name="pr_id" value="<?php echo $_GET['pr_id'];?>">
					<input type="hidden" name="pm_id" value="<?php echo $_GET['pm_id'];?>">
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
					if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
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
					<input type="hidden" name="act" value="manage_facility"  />
			        <input type="hidden" name="request_page" value="manage_prop_facility" />
					<input type="hidden" name="mode" value="del">
					<input type="hidden" name="pr_id" value="<?php echo $_GET['pr_id'];?>">
					<input type="hidden" name="pm_id" value="<?php echo $_GET['pm_id'];?>">
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
					<input type="hidden" name="act" value="manage_facility"  />
			        <input type="hidden" name="request_page" value="manage_prop_facility" />
					<input type="hidden" name="mode" value="del">
					<input type="hidden" name="pr_id" value="<?php echo $_GET['pr_id'];?>">
					<input type="hidden" name="pm_id" value="<?php echo $_GET['pm_id'];?>">
					
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
			 
			 <?php 
			 }
			?>
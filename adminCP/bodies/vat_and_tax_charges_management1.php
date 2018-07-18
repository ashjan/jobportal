<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
	
	
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'vat_tax_charges.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
							AND '.$tblprefix.'properties.pm_type=0
							AND '.$tblprefix.'properties.property_category=24'; 
}else{
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=0
							AND '.$tblprefix.'properties.property_category=24'; 
}	
	

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
												
$qry_faq = "SELECT
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					".$tblprefix."vat_tax_charges.id,
					".$tblprefix."vat_tax_charges.vat_type_percent,
					".$tblprefix."vat_tax_charges.vat_status,
					".$tblprefix."vat_tax_charges.vat_amount,
					".$tblprefix."vat_tax_charges.city_tax_type,
					".$tblprefix."vat_tax_charges.city_tax_status,
					".$tblprefix."vat_tax_charges.city_tax_amount,
					".$tblprefix."vat_tax_charges.service_charges_type,
					".$tblprefix."vat_tax_charges.service_charge_amount,
					".$tblprefix."vat_tax_charges.service_status
					FROM
					".$tblprefix."properties
					Inner Join ".$tblprefix."vat_tax_charges ON ".$tblprefix."vat_tax_charges.property_id = ".$tblprefix."properties.id
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."vat_tax_charges.pm_id = ".$tblprefix."property_manager.id
					$module_pm_where
					" ;
												
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT ".$tblprefix."properties.property_name,
					 ".$tblprefix."property_manager.first_name,
					 ".$tblprefix."property_manager.last_name,
					 ".$tblprefix."vat_tax_charges.id,
					 ".$tblprefix."vat_tax_charges.vat_type_percent,
					 ".$tblprefix."vat_tax_charges.vat_status,
					 ".$tblprefix."vat_tax_charges.vat_amount,
					 ".$tblprefix."vat_tax_charges.city_tax_type,
					 ".$tblprefix."vat_tax_charges.city_tax_status,
					 ".$tblprefix."vat_tax_charges.city_tax_amount,
					 ".$tblprefix."vat_tax_charges.service_charges_type,
					 ".$tblprefix."vat_tax_charges.service_charge_amount,
					 ".$tblprefix."vat_tax_charges.service_status 
					 FROM
					".$tblprefix."properties
					Inner Join ".$tblprefix."vat_tax_charges ON ".$tblprefix."vat_tax_charges.property_id = ".$tblprefix."properties.id
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."vat_tax_charges.pm_id = ".$tblprefix."property_manager.id  $module_pm_where ORDER BY ".$tblprefix."vat_tax_charges.id DESC
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
								GROUP BY ".$tblprefix."properties.pm_id"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();

$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
				AND pm_type=0
				AND '.$tblprefix.'properties.property_category=24';
				
			
				
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Vat & Tax Charges&nbsp;&nbsp;[Podešavanje za PDV i takse]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total number Vat & Tax Charges Found:<?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
     <form action="admin.php" method="post" enctype="multipart/form-data" id="managemenufrm" name="managemenufrm">
   <!--  <form name="managecontentfrm" action="admin.php" method="post" enctype="multipart/form-data">-->
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php
			}else{
			?>
		  <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
							<option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name']."  ".$rs_property_manag->fields['last_name']; ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr>
		    <?php }?>
		    <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr>
				<td>Property Name::</td>
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
			}else{
			?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_name" class="fields" />
					<option value="0">Izaberite objekat</option>
					
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
            <tr>
           
			  <td> Vat Type Percent <br/>[Procenat PDV-a] </td>
              <td>
			    <select name="vat_type_percent" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
				    <option value="">PDV u procentima</option>
					<option value="0">Ne</option>
				 	<option value="1" selected="selected">Da</option>
				</select>
			  </td>
            </tr>
			
			<tr>
              <td> Vat Status <br/>[Status PDV-a]</td>
              <td><select name="vat_status" id="<?php echo $rs_limit->fields['id']; ?>" class="fields"><option value="0">Nije uključeno</option>
			   <option value="1">Uključeno</option>
			   </select>   
			  </td>
            </tr>
			
			<tr>
              <td> Vat Amount <br/>[Iznos PDV-a] </td>
              <td>
			  <input type="text" name="vat_amount" class="fields" id="vat_amount" value="0" />
			  </td>
              <td>%</td>
            </tr>
			
			
			<tr>
              <td> City Tax Type<br/>[Boravišna taksa]</td>
              <td>
			   <select name="city_tax_type" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
					<option selected="selected" value="0">Cijena po osobi po noćenju</option>
				</select>
			  <!--<input type="text" name="city_tax_type" id="<?php //echo $rs_limit->fields['id']; ?>" value="Per Person Per Night">-->
			  </td>
            </tr>
			<tr>
              <td> City Tax Status <br/>[Status boravišne takse]</td>
              <td>
			  <select name="city_tax_status" id="<?php echo $rs_limit->fields['id']; ?>" class="fields">
					<option value="0">Nije uključeno</option>
				 	<option value="1">Uključeno</option>
				</select>
			  </td>
            </tr>
			<tr>
              <td> City Tax Amount <br/>[Iznos boravišne takse]</td>
              <td>
			  <input type="text" name="city_tax_amount" id="<?php echo $rs_limit->fields['id']; ?>" class="fields" />
			  </td><td>&euro;</td>
            </tr>
			<tr>
              <td> Service Charges Type<br/>[Vrsta usluge] </td>
             <td>
		   <input type="text" id="service_charges_type" class="fields" name="service_charges_type" value="" />
		   </td> 		  
		   </tr>
			<tr>
              <td> Service Charge Amount <br/>[Cijena usluge]</td>
              <td>
			  <input type="text" name="service_charge_amount" class="fields" id="service_charge_amount" value="0" />
               </td><td>&euro;</td>
            </tr>
			
			<tr>
              <td> Service Status <br/>[Status usluge]</td>
              <td>
			   <select name="service_status" id="<?php echo $rs_limit->fields['id']; ?>" class="fields" >
					<option value="0"> Nije uključeno</option>
				 	<option value="1">Uključeno</option>
				</select>
			  </tr>
			
            <tr>
              <td>&nbsp;</td>
              <td><!--<input style="margin:2px; width:142px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Vat and Tax charges" class="button" />-->
              <a href="javascript:" style="margin:5px; width:112px; float:none; text-align:center;" name="submit" id="submit" class="button" onclick="add_vat_tax()">Insert Vat and Tax &nbsp;[Unesite Podešavanja za PDV i takse] </a>
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="vat_and_tax_charges_management1" />
          <input type="hidden" name="request_page" value="manage_vat_and_tax_charges1" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div></td>
  </tr>
    <tr>
    
					<?php
                    //Dropdown for parent
                    $category_qry ="SELECT ".$tblprefix."property_manager.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
								 FROM ".$tblprefix."property_manager 
								 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								 WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
								 GROUP BY ".$tblprefix."properties.pm_id";
                    $rs_category = $db->Execute($category_qry); 
                    ?>
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      
<tr>
				
					<td align="center">
					<form action="admin.php" name="uniqueness" method="post" enctype="multipart/form-data" >
                    <?php
					if($_SESSION[SESSNAME]['pm_moduleid']!=2){
					?>
                     <tr>
                        <td width="30%" class="tabheading">Select PM</td>
                        <td width="70%" align="center">
					<select name="pm_id" class="fields" id="pm_id" onchange="get_vat_and_tax1('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_vat_and_tax1.php"?>')">
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
                    </td>
                    </tr>
                     <tr>
                        <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
                        <td width="70%" align="center">
					<div id="property_id1">
                   
					<?php
						//condition for selected dropdown start
					if(isset($_GET['pr_id'])){
						$pr_id = base64_decode($_GET['pr_id']);
						}else{
						$pr_id = 0;
						}
						//Dropdown for parent
						if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
                    	 $property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=0';
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
                    </td>	
					<div id="rooms_id1">
					<?php
						//condition for selected dropdown start
					if(isset($_GET['pr_id'])){
						$pr_id = base64_decode($_GET['pr_id']);
						}else{
						$pr_id = 0;
						}
						//Dropdown for parent
						if(isset($_GET['pr_id']) and isset($_GET['pm_id']) and !empty($_GET['pr_id']) and !empty($_GET['pm_id'])){
                    	 $property_qry = "SELECT id,room_type FROM ".$tblprefix."rooms WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=0'; 
						$rs_prop = $db->Execute($property_qry);
						$totalprope =  $rs_prop->RecordCount();
						}
					//condition for selected dropdown ends
					?>
					
					</div>
					
					
					<?php
					}else{
					?>
                    <tr>
                        <td width="30%" class="tabheading">Select Property<br/>[vlasnika objekta]</td>
                        <td width="70%" align="center">
					<div id="property_id">
					
					<select name="property_id"class="fields" 
					onchange= "get_rates_vat_tax1('get_vat_and_tax1', this.value,<?php echo $_SESSION[SESSNAME]['pm_id']; ?>, '<?php echo MYSURL."ajaxresponse/get_vat_and_tax1.php" ;?>')">
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
					</td>
                    </tr>
					</form>				
					<?php } ?>
					</td>
				</tr>
  
</table>
</td>
</tr>
</table>
<div id="get_vat_and_tax1"> </div>
<?php //echo $where;?>
<script type="text/javascript">

function add_vat_tax(){ 
    var validation_flag= true;
	with (document.managemenufrm){ 		
		
		if(first_name.value=="0"){
			alert("Please Enter PM Name");
			first_name.focus();
			validation_flag= false;
		}
		
		if(property_id.value=="0"){
			alert("Please Enter Property Name");
			property_id.focus();
			validation_flag= false;
		}		
			
	}
		if(validation_flag==true){
			   document.getElementById('managemenufrm').submit();
			}
		return validation_flag;
}// END
</script>
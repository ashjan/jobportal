<?php
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE '.$tblprefix.'rooms.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
							AND '.$tblprefix.'properties.pm_type=0';
	}else{
		$module_pm_where = ' WHERE '.$tblprefix."properties.pm_type=0";
	}

	$maxRows = 20;
	if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
	if ($pageNum == '') $pageNum=0;
	$startRow = $pageNum * $maxRows;
	
	$qry_faq = "SELECT * FROM ".$tblprefix."properties" ; 
	$rs_faq = $db->Execute($qry_faq);
	
	$totalcountalpha = $rs_faq ->RecordCount();
	
	$count_add =  $rs_faq->RecordCount();
	$totalRows = $count_add;
	$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5


	//List down all Properties
	$qry_properties = "SELECT * FROM ".$tblprefix."users WHERE id=".$rs_faq->fields['pm_id'];
	$rs_properties = $db->Execute($qry_properties);
	$count_prop =  $rs_properties->RecordCount();
	$totalprop = $count_prop;


	//List down all PMs
	$qry_pm = "SELECT * FROM ".$tblprefix."users WHERE id=".$rs_faq->fields['pm_id'];
	$rs_pm = $db->Execute($qry_pm);
	$count_pm =  $rs_pm->RecordCount();
	$totalPm = $count_pm;

	//Dropdown for parent
	$online_qry = "SELECT * FROM ".$tblprefix."users WHERE id=".$rs_faq->fields['pm_id'];
	$rs_online = $db->Execute($online_qry);

	$qry_offline_properties = "SELECT
					".$tblprefix."vat_tax_charges.pm_id,
					".$tblprefix."vat_tax_charges.property_id,
					".$tblprefix."vat_tax_charges.id,
					".$tblprefix."vat_tax_charges.vat_amount,
					".$tblprefix."vat_tax_charges.vat_type_percent,
					".$tblprefix."vat_tax_charges.service_charges_type,
					".$tblprefix."vat_tax_charges.city_tax_amount,
					".$tblprefix."vat_tax_charges.service_charge_amount,
					".$tblprefix."standard_rates.standard_start_date,
					".$tblprefix."standard_rates.standard_end_date,
					
					".$tblprefix."properties.property_code,
					".$tblprefix."properties.property_name,
					".$tblprefix."properties.property_category,
					".$tblprefix."properties.region,
					".$tblprefix."properties.street,
					".$tblprefix."properties.town,
					".$tblprefix."properties.postcode,
					".$tblprefix."properties.telephone,
					".$tblprefix."properties.fax,
					".$tblprefix."properties.email,
					".$tblprefix."properties.property_url,
					".$tblprefix."properties.numbers_of_stars,
					".$tblprefix."properties.total_number_rooms,
					".$tblprefix."properties.local_bank_account,
					".$tblprefix."properties.properties_slug,
					".$tblprefix."properties.id,
					".$tblprefix."properties.no_property_rooms,
					".$tblprefix."properties.contact_language,
					".$tblprefix."properties.short_description,
					".$tblprefix."properties.pm_type,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name,
					
					".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_category.property_category_slug
					
					FROM
					".$tblprefix."vat_tax_charges
					Inner Join ".$tblprefix."standard_rates ON ".$tblprefix."vat_tax_charges.property_id = ".$tblprefix."standard_rates.property_id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."vat_tax_charges.property_id = ".$tblprefix."properties.id
					Inner Join ".$tblprefix."users ON ".$tblprefix."vat_tax_charges.pm_id = ".$tblprefix."users.id
					Inner Join ".$tblprefix."property_category ON ".$tblprefix."properties.property_category = ".$tblprefix."property_category.id
					WHERE
					".$tblprefix."properties.pm_type =  '0'
					GROUP BY
					".$tblprefix."properties.property_name";
		//  WHERE prop.pm_type=1"; 
		$rs_offline_properties = $db->Execute($qry_offline_properties);
		$totalofflineinvoices =  $rs_offline_properties->RecordCount();  
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Offline Invoice Report
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">

	
  <tr>
  <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
 
  
	<form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    <td>
    	<?php  if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>       
        <tr>      
        <?php                                 
        //Dropdown List    
         $online_qry = "SELECT ".$tblprefix."users.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category  
						FROM ".$tblprefix."users 
						inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						WHERE ".$tblprefix."properties.pm_type =0   
						GROUP BY ".$tblprefix."properties.pm_id";            
         $rs_online = $db->Execute($online_qry);           
        ?>
        
            <td width="30%" class="tabheading">Select PMs</td>
            <td width="70%" align="center">
            <select name="pm_id" class="fields" id="pm_id" onchange="get_property_offline_invoice('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_property_offline_invoice.php"?>')">
            
                <option value="0">Izaberite vlasnika objekta</option>
                <?php
                    while(!$rs_online->EOF){?>
                    <option value="<?php echo $rs_online->fields['id'];?>"><?php echo $rs_online->fields['first_name'].' '.$rs_online->fields['last_name'];  ?></option>
                    
                    <?php
                    $rs_online->MoveNext();
                    }?>	
                    	
            </select><br />
            </td>
         </tr>
         
        <?php  }else{	        
			$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
							AND pm_type=0 ";
			$rs_content = $db->Execute($qry_content);
			$count_add =  $rs_content->RecordCount();
		?>
         <tr>
            <td width="30%" class="tabheading">Select Property</td>
            <td width="70%" align="center">
            <div id="property_id1">		
        		<select name="property_id" class="fields" id="property_id" onChange="get_offline_invoice('get_offline_invoice',this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>,'<?php echo MYSURL."ajaxresponse/get_offline_invoice.php"?>')">
        <?php
        if($count_add<=0){?>
        <option value="0">Izaberite objekat</option>
        <?php
        }else{?>
        <option value="0">Izaberite objekat</option>	
            <?php while(!$rs_content->EOF){
        ?>
        <option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
            <?php $rs_content->MoveNext();
            }
            }
        ?>
        </select>	
    		</div>	
            </td>
        </tr> 
        <?php } ?>  
       
       <?php if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>
        <tr>
            <td width="30%" class="tabheading">Select Property</td>
            <td width="70%" align="center">
            <div id="property_id1">           
                <select name="property_id" id="property_id" class="fields"  />
                    <option value="0">Izaberite objekat</option>
                </select>            
            </div>
            </td>
        </tr>
        <?php } ?>                        
	</td>
	</form>
 </table>

<div id="get_offline_invoice"></div>
</div></div>
<?php
// code for when click on edit button toggle window will open , actually that is use for inserting category 
if(isset($_GET['cateid'])){
?><script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php 
}
?>


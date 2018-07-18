<?php	
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
$qry_definvice = "SELECT 
                   id,
				   invoice_defcharg 
                   FROM ".$tblprefix."invoicedef_charge WHERE id='1'"; 
$rs_definvice = $db->Execute($qry_definvice);

/*if(isset($_GET['mailsentt']))
{
}else{*/
 	
//$qry_avgrating1 = "SELECT AVG(rating) as proprating,property_id,pm_id FROM ".$tblprefix."property_reviews GROUP BY property_id ORDER BY proprating DESC LIMIT 0,5";


					$qry_avgrating1 ="SELECT
									".$tblprefix."properties.property_code,
									".$tblprefix."properties.pm_id,
									".$tblprefix."properties.property_name,
									".$tblprefix."properties.region,
									".$tblprefix."properties.street,
									".$tblprefix."properties.town,
									".$tblprefix."properties.postcode,
									".$tblprefix."properties.telephone,
									".$tblprefix."properties.property_url,
									".$tblprefix."properties.numbers_of_stars,
									".$tblprefix."properties.property_thumbnail,
									".$tblprefix."properties.local_bank_account,
									".$tblprefix."properties.properties_slug,
									".$tblprefix."properties.business_type,
									".$tblprefix."properties.latitude,
									".$tblprefix."properties.no_property_rooms,
									".$tblprefix."properties.contact_language,
									".$tblprefix."properties.short_description,
									".$tblprefix."properties.permission_status,
									Avg(".$tblprefix."admn_proprating.rating) AS rating_sum,
									".$tblprefix."properties.id,
									Avg(".$tblprefix."property_reviews.rating) as proprating
									FROM
									".$tblprefix."properties
									Left Join ".$tblprefix."admn_proprating ON ".$tblprefix."admn_proprating.proprty_id = ".$tblprefix."properties.id
									left Join ".$tblprefix."property_reviews ON ".$tblprefix."property_reviews.property_id = ".$tblprefix."properties.id
									WHERE ".$tblprefix."properties.permission_status=1 and ".$tblprefix."properties.topoffr_flag=1 or ".$tblprefix."properties.goldoffr_flag=1
									group by  ".$tblprefix."properties.id order by proprating DESC, rating_sum DESC LIMIT 0,5";

 //echo $qry_avgrating1."<br><br>"; 
 
$rs_avgrating1 = $db->Execute($qry_avgrating1);
$totalprops =  $rs_avgrating1->RecordCount();

//echo $qry_avgrating1."<br>";


if($totalprops >0)
{
//$countr = 1;
   while(!$rs_avgrating1->EOF)
   {
		$qry_pickpm = "SELECT email_address FROM ".$tblprefix."users where id='".$rs_avgrating1->fields['pm_id']."'"; 
		$rs_pickpm = $db->Execute($qry_pickpm);
		 $qryinsrttpoffr = "INSERT INTO ".$tblprefix."top_offer_program SET
													 pm_id='".$rs_avgrating1->fields['pm_id']."',
													 proprty_id = '".$rs_avgrating1->fields['id']."',
													 pm_email = '".$rs_pickpm->fields['email_address']."',
													 rating = '".$rs_avgrating1->fields['proprating']."',
													 emailsnt_flag='0',
													 ofr_accptdflag = '0',
													 invoic_charg_amnt = '',
													 invoic_chargdflag = '0',
													 offer_status = '0',
													 timeinserted = '".date("Y-m-d H:i:s")."'
											"; 
		//echo $qryinsrttpoffr."<br>";							
		$rs_insrttpoffr = $db->Execute($qryinsrttpoffr);
		//$countr++;
   		$rs_avgrating1->MoveNext();
   }
}

/*}*/


$qry_topoffr = "SELECT top_offer.*,
AVG( rev.rating ),
pm.first_name,
pm.last_name,
prop.property_name,
tbl_admn_proprating.rating,
prop.pm_type,
((IFNULL(Avg(tbl_admn_proprating.rating), 0 ) + IFNULL((AVG(rev.rating)/2), 0 ))/2) as avg_rate
FROM tbl_top_offer_program AS top_offer
LEFT JOIN tbl_property_reviews AS rev ON rev.property_id = top_offer.proprty_id
LEFT JOIN tbl_users AS pm ON pm.id = top_offer.pm_id
LEFT JOIN tbl_properties AS prop ON prop.id = top_offer.proprty_id
LEFT JOIN tbl_admn_proprating ON tbl_admn_proprating.proprty_id = prop.id
WHERE prop.permission_status=1 and (prop.topoffr_flag=1 or prop.goldoffr_flag=1)
GROUP BY top_offer.proprty_id
ORDER BY avg_rate DESC
LIMIT 0 , 18";

//echo $qry_topoffr; die;
								  
//echo $qry_topoffr;
$rs_topoffr = $db->Execute($qry_topoffr);
$totoffers =  $rs_topoffr->RecordCount();

//echo $qry_topoffr."<br>";

$maxRows = 18;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$totalRows = $totoffers;
$totalPages = ceil($totalRows/$maxRows);
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Top Offer Program</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Offers Found: <?php echo $totoffers ?></td>
	</tr>
	<tr>
    
    <?php
//Dropdown for parent
$category_qry = "SELECT * FROM ".$tblprefix."users ";
$rs_category = $db->Execute($category_qry); 
?>
    
					<table cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
				<!--<td class="txt2">Select Room:</td>-->
					<td align="center">
					<form action="admin.php" name="uniqueness" method="post" enctype="multipart/form-data" >
                    <?php
					if($_SESSION[SESSNAME]['pm_moduleid']!=2){
					?>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_topoffer('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_topoffer.php"?>')">
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
                    	 $property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=1';
						$rs_prop = $db->Execute($property_qry);
						$totalprope =  $rs_prop->RecordCount();
						}
					//condition for selected dropdown ends
					?>
					<select name="property_id"class="fields" >
				 	<option value="0">Select Property Name</option>
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
                    	 $property_qry = "SELECT id,room_type FROM ".$tblprefix."rooms WHERE pm_id=".base64_decode($_GET['pm_id']). ' AND pm_type=1'; 
						$rs_prop = $db->Execute($property_qry);
						$totalprope =  $rs_prop->RecordCount();
						}
					//condition for selected dropdown ends
					?>
					
					</div>
					
					
					<?php
					}else{
					?>
					<div id="property_id">
					
					<select name="property_id"class="fields" onchange="get_rates('get_rates', this.value, '<?php echo MYSURL."ajaxresponse/get_rates.php"?>')" >
				 	<option value="0">Select Property Name</option>
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
				</tr>
	
  <tr>
    <!--table cut form here-->
  </tr>
</table>

<div id="get_rates"></div>
<?php //echo $where;?>
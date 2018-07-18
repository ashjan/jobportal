
<?php
	include('root.php');
	include($root.'include/file_include.php'); 
	
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		
	$propid		= $_GET['propid'];
	$pm_id		= $_GET['pm_id'];
	$room_id	= $_GET['rooms_id1'];	

$maxRows = 50;
//						   AND '.$tblprefix.'bedding.room_id = '.$room_id.'   AND '.$tblprefix.'bedding.room_id = '.$room_id.'
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  pp.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND pr.pm_type=1 							    
							   AND pp.property_id = '.$propid;
}else{	
	  $module_pm_where = ' WHERE pr.pm_type=1 							    
							   AND pp.property_id = '.$propid.'
							   AND pp.pm_id='.$pm_id ;
		
}


if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

  $qry_policy = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name,pr.id as prid,pr.property_name
			   FROM `".$tblprefix."property_policy` as pp 
			   LEFT JOIN ".$tblprefix."properties as pr ON pr.id=pp.property_id 
			   LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id 
			   $module_pm_where AND pr.property_category=24 "; 
			  
			   
		   

$rs_policy = $db->Execute($qry_policy);
$count_add =  $rs_policy->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pp.*,pm.id as pid,pm.first_name,pm.last_name, pr.id as prid,pr.property_name
				   FROM `".$tblprefix."property_policy` as pp 
				   LEFT JOIN ".$tblprefix."properties as pr ON pr.id=pp.property_id
				   LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=pp.pm_id
				    $module_pm_where  AND pr.property_category=24 
					ORDER BY property_name ASC  
				    LIMIT $startRow,$maxRows";
		
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//   List down all Projecties

$qry_property_name = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_type=1 AND property_category=24" ;

$rs_property_name = $db->Execute($qry_property_name);
$count_property_name =  $rs_property_name->RecordCount();
$totalPM = $count_property_name;

$qry_services = "SELECT * FROM ".$tblprefix."property_free_services";
$rs_services = $db->Execute($qry_services);

//   List down all Project Manager


$qry_pm ="SELECT ".$tblprefix."property_manager.*,".$tblprefix."properties.property_name 
						 FROM ".$tblprefix."property_manager 
						 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;


?>


 <div id="get_prop_property_policy">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
	
	
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
            <tr class="tabheading">
				<td width="2%">Sr#</td>
                <td width="4%">Property Name</td>
				<td width="4%">PM Name<br/>[Ime vlasnika objekta]</td>
				<td width="4%">Check In From<br/>[Prijavljivanje od]</td>
				<td width="4%">Check In Untill<br/>[Prijavljivanje do]</td>
				<td width="4%">Check Out From<br/>[Odjavljivanje od]</td>
				<td width="4%">Check Out Untill<br/>[Odjavljivanje do]</td>
				<td width="4%">Maximum Baby Cots<br/>[Maksimalno krevetaca]</td>
				<td width="4%">Options</td>
			</tr>			
		
		<?php if($totalcountalpha >0){
		
		      if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
			   while(!$rs_limit->EOF){
		?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>> 
						<td valign="top"><?php  echo ++$i; ?></td>
                        
						<td valign="top"><?php echo $rs_limit->fields['property_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_in_from']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_in_until']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_out_from']; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['check_out_until']; ?></td>
						<td valign="top"><?php $rs_limit->fields['maximum_baby_cots'];
						if($rs_limit->fields['maximum_baby_cots']==0){
						echo "No capacity for Baby Cots";
						}else{
						echo $rs_limit->fields['maximum_baby_cots'];
						}
						
						 ?></td>
						
						<td valign="top">
		<a href="admin.php?act=editpolicy&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
		<a href="admin.php?act=manage_property_policy&amp;mode=del_policy&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=policy_management" onClick="return confirm('Jeste li sigurni da &#382;elite izbrisati?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
							
		<a   href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />
		</a>		
        </td>
		</tr>
					<style>
					#controls_<?php echo $rs_limit->fields['id'] ?>{
					display:none;
					}
					</style>
					<tr>
					<td colspan="9">
				<div id="controls_<?php echo $rs_limit->fields['id']; ?>" >		
				<table cellpadding="2" cellpadding="2" border="0" bordercolor="#666666" bgcolor="#E7DAE7"  >
				<tr class="txt tabheading" >
				<?php if(!trim(empty($rs_limit->fields['maximum_extra_beds']))){?>
				<td width="4%"> Maximum Extra Beds</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['children_capacity']))){?>
				<td width="4%">Children Capacity</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['children_age']))){?>
				<td width="4%">Children Age</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['extra_children_charges']))){?>
				<td width="4%">Extra Children Charges</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['break_fast']))){?>
				<td width="4%">Break Fast</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['meal_plan']))){?>
				<td width="4%">Meal Plan</td>
				<?php }?>
				<?php  if(!trim(empty($rs_limit->fields['credit_card_accepted']))){?>
				<td width="4%">Credit Card Accepted</td>
				<?php }?>
				<?php  if(!trim(empty($rs_limit->fields['pay_deposit']))){?>
				<td width="4%">Pay Deposit</td>
				<?php }?>                                 
				<?php if(!trim(empty($rs_limit->fields['deposit_amount_percent']))){?>
				<td width="4%">Deposit Amount Percent</td>
				<?php }?>
				
				</tr>
				
				<tr class="txt">
				<?php if(!trim(empty($rs_limit->fields['maximum_extra_beds']))){?>
				    <td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['maximum_extra_beds']; ?></td>
				    <?php }?>
				    <?php if(!trim(empty($rs_limit->fields['children_capacity']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['children_capacity']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['children_age']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['children_age']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['extra_children_charges']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['extra_children_charges']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['break_fast']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['break_fast']==0){
						echo "Yes";}else {echo "No";}
						?></td>
						<?php }?>
						<?php 
						$meal_plan = '';
						$plan = $rs_limit->fields['meal_plan'];
						if(0==$plan){
						$meal_plan= "Any";	
						}elseif(1==$plan){
							$meal_plan = "English Breakfast";
						}elseif (2==$plan){
						$meal_plan = "Buffet";
						}else {
						$meal_plan= "Continental";
						}
						$credit_card_value = array();
						$credit_card = explode(',',$rs_limit->fields['credit_card_accepted']);
						if(in_array(0,$credit_card)){
						$credit_card_value[]="Dont Accept Credit Card";
						}
						if(in_array(1,$credit_card)){
						$credit_card_value[]="American Express";
						}
						if(in_array(2,$credit_card)){
						$credit_card_value[]="Visa";
						}
						if(in_array(3,$credit_card)){
						$credit_card_value[]="Euro and Master Card";
						}
						if(in_array(4,$credit_card)){
						$credit_card_value[]="Maestro";
						}
							?>
						<?php if(!trim(empty($rs_limit->fields['meal_plan']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $meal_plan; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['credit_card_accepted']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo implode(',',$credit_card_value); ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['pay_deposit']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['pay_deposit']==0)
						{echo "No";}else {echo "Yes";} ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['deposit_amount_percent']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['deposit_amount_percent']; ?></td>
						<?php }?>
						

					
				</tr>
				<tr class="txt tabheading">
				<?php if(!trim(empty($rs_limit->fields['minimum_days_stay']))){?>
				<td width="4%">Minimum Days Stay</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['less_days_price']))){?>
				<td width="4%">Less Days Price</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['food_beverage']))){?>
				<td width="4%">Food Beverage</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['internet_type']))){?>
				<td width="4%">Internet Type</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['internet_location']))){?>
				<td width="4%">Internet Location</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['parking_available']))){?>
				<td width="4%">Parking Available</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['parking_place']))){?>
				<td width="4%">Parking Place</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['parking_costs']))){?>
				<td width="4%">Parking Costs</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['pets_allowed']))){?>
				<td width="4%">Pets Allowed</td>
				<?php }?>
				<?php if(!trim(empty($rs_limit->fields['important_notice']))){?>
				<td width="4%">Important Notice</td>
				<?php }?>				
				</tr>
				<tr class="txt" >
				   		
						<?php if(!trim(empty($rs_limit->fields['minimum_days_stay']))){?>
				   		<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['minimum_days_stay']; ?> <?php echo "&nbsp;"; ?></td>
				   		<?php }?>
				   		<?php if(!trim(empty($rs_limit->fields['less_days_price']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['less_days_price']; ?> <?php echo "&nbsp;"; ?></td><?php }?>
						<?php if(!trim(empty($rs_limit->fields['food_beverage']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['food_beverage']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['internet_type']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['internet_type']; ?></td>
						<?php } ?>
						<?php if(!trim(empty($rs_limit->fields['internet_location']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['internet_location']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['parking_available']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['parking_available']==0)
						{echo "No";}else {echo "Yes";}  ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['parking_place']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['parking_place']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['parking_costs']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['parking_costs']; ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['pets_allowed']))){?>
						<td valign="top"><?php echo "&nbsp;"; if($rs_limit->fields['pets_allowed']==0)
						{echo "No";}else {echo "Yes";} ?></td>
						<?php }?>
						<?php if(!trim(empty($rs_limit->fields['important_notice']))){?>
						<td valign="top"><?php echo "&nbsp;"; echo $rs_limit->fields['important_notice']; ?></td>
						<?php }?>
						
				</tr>
				</table>
				</div>
				</td>
				</tr>
			<?php $rs_limit->MoveNext();
			}?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}
							else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPages){
							if($pageNum==0)
							$count= $count+10;
							else { $count= $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							

							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Data Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	
    </td>
  </tr>
</table>
</div>

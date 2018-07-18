<?php
	include('root.php');
	include($root.'include/file_include.php');

	$pm_id	=$_GET['pm_id'];
	$propid	=$_GET['propid'];
  

	if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'vat_tax_charges.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
							AND '.$tblprefix.'properties.pm_type=1 							
							AND '.$tblprefix.'vat_tax_charges.property_id = '.$propid; 
							
}else{
	$module_pm_where = ' WHERE  
							'.$tblprefix.'properties.pm_type=1 							
							AND '.$tblprefix.'vat_tax_charges.pm_id='.$pm_id.' 
							AND '.$tblprefix.'vat_tax_charges.property_id = '.$propid; 
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
$qry_property_manag = "SELECT
                    ".$tblprefix."property_manager.id,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name 
					FROM
					".$tblprefix."property_manager"; 
					
					
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>
<div id="get_vat_and_tax"> 
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
    <tr class="tabheading"> 
	    <td width="5%">Sr#</td>
	    <td width="8%">Property Id</td>
		<td width="8%">Pm Id<br/>[Ime vlasnika objekta]</td>
       	<td width="8%">Vat Type Percent<br/>[Procenat PDV-a]</td>
        <td width="8%">Vat Status<br/>[Status PDV-a]</td>
        <td width="8%">Vat Amount<br/>[Iznos PDV-a]</td>
		<td width="8%">City Tax Type<br/>[Boravišna taksa]</td>
		<td width="8%">City Tax Status<br/>[Status boravišne takse]</td>
		<td width="8%">City Tax Amount<br/>[Iznos boravišne takse]</td>
		<td width="8%">Service Charges Type<br/>[Vrsta usluge]</td>
		<td width="8%">Service Charge Amount<br/>[Cijena usluge]</td>
		<td width="8%">Service Status<br/>[Status usluge]</td>
		<td width="5%">Option</td>
		</tr>
      <?php 
			 if($totalcountalpha >0){	
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						
					  <td valign="top">
					  <?php 
					  echo stripslashes($rs_limit->fields['property_name']);
					  ?></td>
					  <td valign="top"><?php 
					  echo $rs_limit->fields['first_name']."  ".$rs_limit->fields['last_name'];
					  ?></td>
					  <td valign="top"><?php 
					  $rfstatus=stripslashes($rs_limit->fields['vat_type_percent']);if ($rfstatus==0){
					  echo "No";}
					  else{
					  echo "Yes";
					  } ?></td>
					   <td valign="top"><?php 
					  $rfstatus=stripslashes($rs_limit->fields['vat_status']);if ($rfstatus==0){
					  echo "Not Included";
					  }else{
					  echo "Included";
					  } ?></td>
					  <td valign="top"><?php  echo stripslashes($rs_limit->fields['vat_amount']); ?>%</td>
				
						 <td valign="top"><?php 
					  $rfstatus=stripslashes($rs_limit->fields['city_tax_type']);
					  if ($rfstatus==0){
					  echo "Per person per night";
					  }else{
					  echo "Per person per night";
					  } ?>
                      </td>
				
				<td  valign="top"><?php 
					  $rfstatus=stripslashes($rs_limit->fields['city_tax_status']);if ($rfstatus==0){
					  echo "Not Included";}
					  else{
					  echo "Included";
					  } ?></td>
					  
				<td  valign="top"><?php echo $rs_limit->fields['city_tax_amount']; ?>&euro;</td>
				
				<td valign="top"><?php 
					  $rfstatus=stripslashes($rs_limit->fields['service_charges_type']);
					  echo $rfstatus;
					   ?></td>				
				
				<td><?php echo stripslashes($rs_limit->fields['service_charge_amount']); ?>&euro;
			   </td>
               
			    <td valign="top"><?php 
					  $rfstatus=stripslashes($rs_limit->fields['service_status']);if ($rfstatus==0){
					  echo "Not Included";}
					  else{
					  echo "Included";
					  } ?></td>
			   			   
            	<td valign="top">
                <a href="admin.php?act=edit_vat_and_tax_charges&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=vat_and_tax_charges_management&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manage_vat_and_tax_charges" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        </td>
            </tr>
            <?php 
			$rs_limit->MoveNext();
			} 
			
			?>
    <?php 
  }
  else
  {
?>
<tr class="tabheading"> 
	   <!--<td colspan="13" width="5%" class="errmsg">No Record Found</td>-->
	     <td colspan="13" width="5%" class="errmsg">Ne Snimanje pronađena</td>
		</tr>
<?php 
  }
	?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
     
    </td>
  </tr>
  <tr>
  <td colspan="13"><!-- START: Pagination Code -->
    <div class="txt">
      <div id="txt" align="center"> Showing
        <?php 
							
							echo ($startRow + 1) ?>
        to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />
        Pages ::
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
        <a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a> &nbsp;
        <?php } 		
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
        <?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?>
        <a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>
        <?php }
			  if ($pageNum < $totalPages - 1){
		?>
        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
        <?php } ?>
      </div>
    </div>
    <!-- END: Pagination Code -->
  </td>
</tr>
</table>
</div>
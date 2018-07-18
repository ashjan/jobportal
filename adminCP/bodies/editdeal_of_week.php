<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT top_offer.*,pm.id as pm_id,pm.first_name,pm.last_name,prop.id as prop_id,prop.property_name 
FROM tbl_offer_of_week AS top_offer
INNER JOIN tbl_users AS pm ON pm.id=top_offer.pm_id 
INNER JOIN tbl_properties AS prop ON prop.id=top_offer.property_id  
WHERE top_offer.id=".$id;
$rs_topoffr = $db->Execute($qry_limit);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Deal of Week &nbsp;[Izmjeni]</td>
 	</tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php?act=manage_property" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" class="txt">		
<tr><td colspan="2">&nbsp;</td></tr>		
				<tr>
				<td class="txt2">Property Manager:<br/>[vlasnika objekta] </td>
				<td>
				<?php echo $rs_topoffr->fields['first_name']."&nbsp;".$rs_topoffr->fields['last_name']; ?>
				</td>
				</tr>
				
				<tr>
				<td class="txt2">Property:<br/>[vlasnika]  </td>
				<td>
				<?php echo $rs_topoffr->fields['property_name']; ?>			
				</td>
				</tr>
				
				<tr>
				<td class="txt2">Date:<br/>[Datum]   </td>
				<td>
				<?php 
				$deal_end_date=date("m/d/Y", strtotime($rs_topoffr->fields['deal_end_date']));
				?>
				<input type="text" name="deal_end_date" id="deal_end_date" value="<?php echo $deal_end_date; ?>" />
				<script language="JavaScript">
			   var o_cal = new tcal ({
			   	// form name
			   	'formname': 'managecontentfrm',
			   	// input name
			   	'controlname': 'deal_end_date',
			   });

			   // individual template parameters can be modified via the calendar variable
			   o_cal.a_tpl.yearscroll = false;
             </script>
				</td>
				</tr>
				<tr>
				<td class="txt2">Discount Price<br/>[Cijena sa popustom]</td>
				<td>
				<input type="text" name="dprice" class="fields"  id="dprice" value="<?php echo $rs_topoffr->fields['discount_price']?>" /> EUR
 				</td> 
				</tr>
</table>				
<table class="txt" cellpadding="1" cellspacing="1" border="0" >		
</table>
<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="A&#382;uriraj" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="pm_id" value="<?php echo $rs_topoffr->fields['pm_id'];?>" />
		<input type="hidden" name="property_id" value="<?php echo $rs_topoffr->fields['prop_id'];?>" />
		<input type="hidden" name="deals_status" value="<?php echo $rs_topoffr->fields['deals_status'];?>" />
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="editdeal_of_week">
		<input type="hidden" name="act2" value="deal_of_week">
		<input type="hidden" name="request_page" value="dealofweek" />
		<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" />
		<input type="hidden" name="pprice" value="0" />
					</td>
				</tr>
	<?php			
 ?>
 </form>
		</td>
	</tr>
</table>
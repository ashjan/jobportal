<?php
$id=base64_decode($_GET['id']);


 $qry_limit = "SELECT * FROM  ".$tblprefix."property_free_services WHERE id=".$id;
 $rs_limit = $db->Execute($qry_limit);


                    //  G  E T       A L L    T H E    L A N G U A G E        F I E L D S  
					$language_query = "SELECT * FROM  ".$tblprefix."language   
												WHERE ".$tblprefix."language.id<>4";
					$rs_language    = $db->Execute($language_query);
					$totallanguage  = $rs_language->RecordCount();						   
					
					
?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Property Free Services for sunnymontenegro.com Customer[A&#382;uriraj "Free for SunnyMontenegro" program]</td>
 	</tr>
 	<tr>

<?php if ($_REQUEST['errmsg']) {?>
<td colspan="3" class="errmsg" align="center"><?php echo base64_decode($_REQUEST['errmsg']);?></td>
	
<?php }?>
</td>
</tr>	
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<table cellpadding="1" cellspacing="1" border="0" >		
	
				<tr>
				<td class="txt2">Service<br/>[Usluge]: </td>
				<td>
				<?php 
			if(!empty($_SESSION['event_category_name']))
			{ ?> 
				<input name="event_category_name" id="event_category_name" value="<?php echo $_SESSION['event_category_name']; ?>" type="text" size="55"  maxlength="55" />*
			<?php	
			}else{ ?>
				<input name="event_category_name" id="event_category_name" value="<?php echo $rs_limit->fields['service_name']?>" type="text" size="55"  maxlength="55" />*
			<?php } ?>
				</td>
				</tr>
				
	
	<?php while(!$rs_language->EOF){ 
	
	//  G E T       A L L    T H E     T R A N S L A T E D      F I E L D S       LANGUAGE CONTENTS
	
                     $language_content_query = "SELECT 
                           ".$tblprefix."language_contents.id,
						   ".$tblprefix."language_contents.language_id,
                           ".$tblprefix."language_contents.page_id,
                           ".$tblprefix."language_contents.field_name,
                           ".$tblprefix."language_contents.translation_text,
                           ".$tblprefix."language_contents.translated_text,
                           ".$tblprefix."language_contents.fld_type
                           FROM  ".$tblprefix."language_contents   
						   WHERE ".$tblprefix."language_contents.fld_type='free_services' 
						   AND   ".$tblprefix."language_contents.field_name='service_name_".$rs_language->fields['id']."' 
						   AND   ".$tblprefix."language_contents.page_id=".$id."  
						   AND   ".$tblprefix."language_contents.language_id=".$rs_language->fields['id'];
                     $rs_language_content = $db->Execute($language_content_query);
                     $totallanguagecontent =  $rs_language_content->RecordCount();
	
	 ?>
	<tr>
	<td class="txt2">Service <?php echo $rs_language->fields['Lan_name']; ?>: </td>
	<td>
	<input name="service_name_<?php echo $rs_language->fields['id']; ?>" id="service_name_<?php echo $rs_language->fields['id']; ?>" value="<?php echo $rs_language_content->fields['translated_text']?>" type="text" size="55" maxlength="55" />
	</td>
	</tr>
	<?php 
	$rs_language->MoveNext();
	} 
	?>	
</table>				
<table class="txt" cellpadding="1" cellspacing="1" border="0" >
				
				
</table>


<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td>
        <input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
		<input type="hidden" name="mode"  value="update">
		<input type="hidden" name="act"   value="update_ppt_freeservice">
		<input type="hidden" name="act2"  value="property_free_service">
		<input type="hidden" name="request_page" value="freeppt_management" />
		<input type="hidden" name="id"    value="<?php echo base64_encode($id);?>" />
					</td>
				</tr>
	<?php			
    	$_SESSION['event_category_name']='';
    ?> 				
</form>
		
		</td>
	</tr>
</table>



<?php
  $lan_id=4;  
   $qry_limit = "SELECT 
                   id,
				   page_title, page_description, language_id
                   FROM ".$tblprefix."welcome_page WHERE language_id='".$lan_id."'";   
$rs_limit = $db->Execute($qry_limit);

   $qry_language = "SELECT *
                   FROM ".$tblprefix."language";   
$rs_language = $db->Execute($qry_language);
 ?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Welcome Page
</div></div>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	
 <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
    <table cellpadding="1" cellspacing="1" border="0" class="table" >				
				<tr>
				<td class="txt1">Page Title</td>
				<td>
<textarea rows="1" cols="80"  name="page_title" id="page_title" class="fields" style="width:250px; height:20px;" ><?php echo $rs_limit->fields['page_title']?></textarea>
		
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Page Description</td>
				<td>
<textarea rows="8" cols="60"  name="page_description" class="fields" style="width:250px; height:200px;" id="page_description"><?php echo $rs_limit->fields['page_description'];?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Language</td>
				<td>
				
				<input type="hidden" name="language" id="language" value="<?php echo $rs_limit->fields['language_id'] ; ?>" />
			<!--	<select name="language" class="fields" id="language" onchange="">
				 	<option value="0">Select Language</option>
					<?php
					//$rs_language->MoveFirst();
				//	while(!$rs_language->EOF){
					
								?>
		  			<option value="<?php //echo $rs_language->fields['id'];?>" <?php //if($rs_language->fields['id']== $rs_limit->fields['language_id']){
					//echo 'selected="selected"';
				//	} ?>><?php //echo $rs_language->fields['Lan_name'];  ?></option>
					<?php
					//$rs_language->MoveNext();
				//	}
					?>			
					</select>-->
				</td> 
				</tr>
				
				
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:105px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="welcome_page">
		<input type="hidden" name="act2" value="welcome_page">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="welcome_page_management" />
					</td>
				</tr>
				
</form> 
		</td>
	</tr>
	
	<tr>
		<td>
		
		<?php
   $lan_id=5;  
   $qry_limit = "SELECT 
                   id,
				   page_title, page_description, language_id
                   FROM ".$tblprefix."welcome_page WHERE language_id='".$lan_id."'";   
   $rs_limit = $db->Execute($qry_limit);
		?>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				<tr>
				<td class="txt1">Page Title</td>
				<td>
		<textarea rows="1" cols="100"  name="page_title" id="page_title" class="fields" style="width:250px; height:20px;" ><?php echo $rs_limit->fields['page_title']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Page Description</td>
				<td>
<textarea rows="8" cols="60"  name="page_description" class="fields" style="width:250px; height:200px;" id="page_description"><?php echo $rs_limit->fields['page_description'];?></textarea>
				</td> 
				</tr>
				
				<tr>
<!--				<td class="txt1">Language<<br/>[Jezik]/td>-->
				<td>
				<input type="hidden" name="language" id="language" value="<?php echo $rs_limit->fields['language_id'] ; ?>" />
				<!--<select name="language" class="fields" id="language" onchange="">
				 	<option value="0">Select Language</option>
					<?php
					$rs_language->MoveFirst();
					while(!$rs_language->EOF){
							//echo $rs_language->fields['id'];			
								?>
		  			<option value="<?php echo $rs_language->fields['id'];?>" <?php if($rs_language->fields['id']== $rs_limit->fields['language_id']){
					echo 'selected="selected"';
					} ?>><?php echo $rs_language->fields['Lan_name'];  ?></option>
					<?php
					$rs_language->MoveNext();
					}
					?>			
					</select>-->
				</td> 
				</tr>
				
				
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:105px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="welcome_page">
		<input type="hidden" name="act2" value="welcome_page">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="welcome_page_management" />
					</td>
				</tr>
				
</form> 
		</td>
	</tr>
	
	
	<tr>
		<td>
	<?php
	$lan_id=7;  
   $qry_limit = "SELECT 
                   id,
				   page_title, page_description, language_id
                   FROM ".$tblprefix."welcome_page WHERE language_id='".$lan_id."'";   
   $rs_limit = $db->Execute($qry_limit);
		?>	
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
    <table cellpadding="1" cellspacing="1" border="0" class="table" >				
				<tr>
				<td class="txt1">Page Title</td>
				<td>
		<textarea rows="1" cols="100"  name="page_title" id="page_title" class="fields" style="width:250px; height:20px;" ><?php echo $rs_limit->fields['page_title']?></textarea>
				</td> 
				</tr>
				
				<tr>
				<td class="txt1">Page Description</td>
				<td>
<textarea rows="8" cols="60"  name="page_description" class="fields" style="width:250px; height:200px;" id="page_description"><?php echo $rs_limit->fields['page_description'];?></textarea>
				</td> 
				</tr>
				
				<tr>
<!--				<td class="txt1">Language</td>-->
				<td>
			<input type="hidden" name="language" id="language" value="<?php echo $rs_limit->fields['language_id'] ; ?>" />	
				<!--<select name="language" class="fields" id="language" onchange="">
				 	<option value="0">Select Language</option>
					<?php
					//$rs_language->MoveFirst();
					//while(!$rs_language->EOF){
						
								?>
		  			<option value="<?php //echo $rs_language->fields['id'];?>" <?php //if($rs_language->fields['id']== $rs_limit->fields['language_id']){
					//echo 'selected="selected"';
				//	} ?>><?php //echo $rs_language->fields['Lan_name'];  ?></option>
					<?php
					//$rs_language->MoveNext();
					//}
					?>			
					</select>-->
				</td> 
				</tr>
				
				
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:105px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
					<td>&nbsp;</td>
					<td>
	
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="welcome_page">
		<input type="hidden" name="act2" value="welcome_page">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">
		<input type="hidden" name="request_page" value="welcome_page_management" />
					</td>
				</tr>
				
</form> 
		</td>
	</tr>
	
</table>
</div></div>


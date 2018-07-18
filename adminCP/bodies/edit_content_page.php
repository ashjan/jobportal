<?php 

	$page = base64_decode($_GET['pageid']);
	$qry_content = "SELECT * FROM  ".$tblprefix."pm_pagecontent WHERE id = '".$page."'";  
	$rs_content = $db->Execute($qry_content);
	$isrs_contents =  $rs_content->RecordCount(); 
	
if($_GET['menuname']!=""){
	$menuname = stripslashes($_GET['menuname']);
}else{
	$menuname = 'Unknown menu name';
}
$mode = "update";

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users";  
$rs_pm = $db->Execute($qry_pm);

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

if(!$_GET['okmsg'] && !$_GET['errmsg'])
{
	unset($_SESSION['add_content_page']);
}


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Home Page Contents</td>
 	</tr>
        <th>&nbsp;</th>

	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
				</tr>
				<tr>
				<td colspan="2" class="txt2">
			      Page Title:</td>
				</tr>
				<tr>
				<td colspan="2">
				<table width="422" height="26" cellpadding="0" cellspacing="2" style="border:#666666 1px dotted; width:445px;">
				<tr >
					<td width="59" class="txt1">   </td>
					<td width="430">
<input style="width:356px;" name="page_title" id="page_title" class="fields" type="text" value="<?php 
if(isset($_SESSION['add_content_page']['page_title'])){
	echo $_SESSION['add_content_page']['page_title'];
}else {
	echo stripslashes($rs_content->fields['page_title']);
}

?>" />					</td>
				</tr>
<?php 
				
?>
				</table>				</td>
				</tr>
	
<th>&nbsp;</th>
	<tr>
            
            
	<td>Description :</td>
        <td>&nbsp;</td>
	</tr>
			
				<tr>
                                    
					<td><textarea id="sitegdt" name="sitegdt" rows="25" cols="90">
					<?php if(isset($_SESSION['add_content_page']['sitegdt'])){echo $_SESSION['add_content_page']['sitegdt'];}
					else {
						echo stripslashes(trim($rs_content->fields['description']));
					}
					?>
					</textarea></td>
				</tr>
				<tr>
				
			    
				
				
				
                                    <th>&nbsp;</th>
				<tr>
				<td><input type="submit" class="button" name="contentSbt" id="contentSbt" value="<?php if($page=='send'){echo 'Update Contents';}else {echo 'Update Contents'; }?> " />						
				</td>
				<td>
			    <input type="hidden" name="act" value="add_content_pages">
				<input type="hidden" name="request_page" value="content_pm_management" />	
				<input type="hidden" name="page_id" value="<?php echo $pageid; ?>">	
				<input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo base64_encode($page); ?>">
                <input type="hidden" name="content_slug" value="<?php echo $rs_content->fields['content_slug']?>"/>
                </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
	</form>
		</td>
	</tr>
</table>

<?php

	$page = base64_decode($_GET['pageid']);
	$qry_content = "SELECT * FROM  ".$tblprefix."resume_views WHERE id = '".$page."'";  
	$rs_content = $db->Execute($qry_content);
	$isrs_contents =  $rs_content->RecordCount(); 
	$mode = "update";

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users WHERE user_type = 3"; 
$rs_pm = $db->Execute($qry_pm);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Resume Views Management</td>
 	</tr>
	<tr>
	</tr>
	<tr>
	<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
				</tr>

			<tr>
			<td class="txt1">Candidate Name</td>
			<td>
			<?php 
			
			?>
			<select name="pm_id" class="fields"   id="pm_id" >
				<option value="0">Select Candidate</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				
				if($rs_content->fields['candidate_id']==$rs_pm->fields['id'])
				{
					echo 'selected="selected"';
				}
				
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>
			</td>
			</tr> 
			
			<tr>
			<td class="txt1">Resume Views</td>
			<td>
                            <input type="text" name="no_of_views" value="<?php $rs_content->fields['no_of_views'];?>"
			</td>
			</tr> 
                        
                        <tr>
			<td class="txt1">Limit Flag</td>
			<td>
                            <input type="text" name="limit_flag" value="<?php $rs_content->fields['limit_flag'];?>"
			</td>
			</tr> 
                        
                        <tr>
			<td class="txt1">View Limit</td>
			<td>
                            <input type="text" name="view_limit" value="<?php $rs_content->fields['view_limit'];?>"
			</td>
			</tr> 
				<tr>
				<td>&nbsp;</td>
				<td>
                                <input type="submit" class="button" name="contentSbt" id="contentSbt" value="Update">						
				<input type="hidden" name="act" value="add_content_pages">
				<input type="hidden" name="request_page" value="resume_views_management" />	
				<input type="hidden" name="page_id" value="<?php echo $rs_content->fields['id']; ?>">	
				<input type="hidden" name="mode" value="<?php echo $mode; ?>">
                                <input type="hidden" name="id" value="<?php echo base64_encode($page); ?>">
   <!--               <input type="hidden" name="content_slug" value="<?php //echo $rs_content->fields['content_slug']?>"/>-->
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

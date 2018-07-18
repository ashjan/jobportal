<?php
$id=base64_decode($_GET['id']); 

$qry_limit ="SELECT id,first_name,last_name,profile_pic FROM tbl_users WHERE id=".$id; ; 
$rs_limit = $db->Execute($qry_limit);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading" colspan="2">Edit Image media Section</td>
 	</tr>
 	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
		
    <tr><td>Employer Name</td><td width="3%" valign="top"><?php echo $rs_limit->fields['first_name'].'&nbsp;'.$rs_limit->fields['last_name'] ; ?></td></tr>		
				
		
		 <th>&nbsp;</th>
		<tr>
        	<td class="txt1">New Image</td>
			<td>
			<input type="file" name="image" class="fields" />
                        </td>
                
                        <td>
            	<!--imge will come here-->
                <?php 
					 
						if(!empty($rs_limit->fields['profile_pic'])){
						$image_name =$rs_limit->fields['profile_pic'];
						}else{
						$image_name ="noimg.jpg";
						}
						?>
                <img width="78px" height="78px"  src="<?php echo BASE_URL."uploads/profile_images/".$image_name.""; ?>"/>
            	<!--imge upto here-->
			</td>
           
        </tr>
        <th>&nbsp;</th>
		<tr>
                    
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:180px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Image" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="mediaimages">
		<input type="hidden" name="act2" value="editmediaimages">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['profile_pic']; ?>" />
		<input type="hidden" name="request_page" value="media_upload" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>


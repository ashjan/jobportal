<?php
$id=base64_decode($_GET['id']); 

 $qry_limit = "SELECT * FROM ".$tblprefix."slider_images WHERE id=".$id;

$rs_limit = $db->Execute($qry_limit);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Slider Images Section</td>
 	</tr>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
           <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
			<tr>
				<td class="txt1">Title</td>
		<td><input type="text" name="image_title" class="fields" value="<?php echo $rs_limit->fields['image_title']; ?>" /></td>
		</tr>
		
		
		<tr>
        	<td class="txt1">Image</td>
			<td>
			<input type="file" name="image" class="fields" />
            	<!--imge will come here-->
                <?php 
					  if($rs_limit->fields['image_full_path']!=NULL){
					   ?>
					   
					   <img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['image_full_path']; ?>&w=50&h=40&zc=1" border="0">	

					   <?php 
					  }
					  
					  ?>
            	<!--imge upto here-->
			</td>
           
        </tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Image" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="editsliderimages">
		<input type="hidden" name="act2" value="editsliderimages">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['image']; ?>" />
		<input type="hidden" name="request_page" value="slider_manager" />
					</td>
				</tr>
				<tr>
		<td colspan="2" class="txt1">Note: Preffered image size is 898 x 175</td>
		</tr>
</form> 


		
		</td>
	</tr>
</table>


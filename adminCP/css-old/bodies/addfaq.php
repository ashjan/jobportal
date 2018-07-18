<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}
if(isset($_GET['faqid'])){
$faqid = base64_decode($_GET['faqid']);

$query_faq = "SELECT * FROM ".$tblprefix."faq WHERE id = '".$faqid ."' "; 
$rs_faq = $db->Execute($query_faq);
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
  <tr><td id="heading">Add FAQ'S</td></tr>
  <tr>
	<td>
	<form name="addfaqfrm" action="admin.php" method="post" onsubmit="return validate_faq()">
		<table width="758" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 <tr>
				<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>				</td>
			 </tr>
			 <tr>
			   	<td>&nbsp;</td>
			   	<td colspan="2" class="required_txt">* Required Fields</td>
	      	 </tr>
		    
			 <tr>
			  	<td valign="top">Question: </td>
			  	<td>
					<textarea name="faq_question" id="faq_question" class="smalltxtareas" cols="120" rows="8"><?php echo(stripslashes($rs_faq->fields['question']));?></textarea>
				</td>
		     </tr>
             
             
             
		     <tr>
		    	<td>Answer: </td>
		    	<td></td>
			 </tr>
			 <tr>
				<td>&nbsp;</td>
				<td>
					<textarea id="description" name="description" rows="25" cols="83"> <?php echo stripslashes($rs_faq->fields['answer'])?>					</textarea>
				</td>
			 </tr>
             
             
             
			 <tr>
			  	<td>Status:</td>
			  	<td>
			  		<select name="status" id="status" class="smalldropfields">
                                            <option value="1" <?php if(!empty($rs_faq->fields)){if($rs_faq->fields['status'] == 1){?> selected="selected" <?php }}?>>Active</option>
                                                <option value="0" <?php if(!empty($rs_faq->fields)){if($rs_faq->fields['status'] == 0){?> selected="selected" <?php }}?>>De-Active</option>
			    	</select>
			  	</td>
		  	 </tr>
			 <tr>
				<td>&nbsp;</td>
				<td>
				<?php if(isset($faqid)){?>
					<input type="submit" name="updatefaqSbt" id="updatefaqSbt" value="Update FAQ  " />
					<input type="hidden" name="faqid" value="<?php echo $rs_faq->fields['id'];?>" />
					<input type="hidden" name="act" value="addfaq">
					<input type="hidden" name="act2" value="viewfaq">
					<input type="hidden" name="mode" value="update">
                    <input type="hidden" name="request_page" value="faq_get" />							
				<?php }else{?>
					<input type="submit" name="addfaqSbt" id="addfaqSbt" value="Add FAQ  " />
					<input type="hidden" name="act" value="addfaq">
					<input type="hidden" name="act2" value="viewfaq">
					<input type="hidden" name="mode" value="send">
                    <input type="hidden" name="request_page" value="faq_get" />					
					<?php }?>
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


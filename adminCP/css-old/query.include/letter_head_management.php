<?php
	
	//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='edit_latter_head' && $_POST['request_page']=='letter_head_management'){
	
			$letter_head_details = addslashes(trim($_POST['letter_head_details']));
			$letter_head_telephone = addslashes(trim($_POST['letter_head_telephone']));
			$letter_head_email = addslashes(trim($_POST['letter_head_email']));
			$letter_head_website = addslashes(trim($_POST['letter_head_website']));
			$letter_head_other_details = addslashes(trim($_POST['letter_head_other_details']));
			
			
	 $id=base64_decode($_POST['id']);
	 	
			if($letter_head_details == ''){
				$errmsg = base64_encode('Please Enter Latter Head Details');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
			if($letter_head_telephone == ''){
				$errmsg = base64_encode('Please Enter Telephone Number');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
			
			if($letter_head_email == ''){
				$errmsg = base64_encode('Please Enter Email');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
			
			if($letter_head_website == ''){
				$errmsg = base64_encode('Please Enter WebSite URL');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
			
			if($letter_head_other_details == ''){
				$errmsg = base64_encode('Please Enter Other Details About Letter Head');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}
		
			
			
			  $sql_letter_head= "UPDATE ".$tblprefix."montenegro_letter_head 
														SET
														letter_head_details = '".$letter_head_details."',
														letter_head_telephone ='".$letter_head_telephone."',
														letter_head_email ='".$letter_head_email."',
														letter_head_website ='".$letter_head_website."',
														letter_head_other_details ='".$letter_head_other_details."'
														WHERE
														id=".$id;
												
														
														
				$rs_letter_head = $db->Execute($sql_letter_head);
					if($rs_letter_head){
						$okmsg = base64_encode("The Montenegro Latter Head Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=manage_letter_head");
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("The Montenegro Latter Head Is Not Updated!");
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($_POST['id']));
						exit; 
					}
			} 
	
?>
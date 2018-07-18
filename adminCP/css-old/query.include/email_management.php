<?php

######################
#
# 	POST SECTION
#
######################

//-----------ADD Email-----------
	
	if($_POST['mode'] == 'send' && $_POST['act'] == 'manageemail' && isset($_POST['letterSbt'])){
	
	 $_SESSION["addemail"]=$_POST;
		
		$newsletter_name = addslashes(trim($_POST['newsletter_name']));
		$description = addslashes(trim($_POST['description']));
		echo "2nd eneternece";
		if($newsletter_name == ''){
		echo "3rd eneternece";
			$errmsg = base64_encode('Please Enter Email Subject');
			header("Location: admin.php?act=addemail&errmsg=$errmsg");
			exit;
		}
		if($description == ''){
		echo "4th eneternece";
			$errmsg = base64_encode('Please Enter Message Body');
			header("Location: admin.php?act=addemail&errmsg=$errmsg");
			exit;
		}
		
		
		$sql_query = "INSERT INTO ".$tblprefix."email_conf SET
													 subject = '".$newsletter_name."', 
													 email_body = '".$description."'";
		$rs_newsletter = $db->Execute($sql_query); 
		
		if($rs_newsletter){
		unset($_SESSION["addemail"]);
		 $okmsg = base64_encode("Template Added successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		 exit;	  
	       }/* END:  if($rs_newsletter) */
	
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['letterSbt'])) */


//---------Update Email---------
	   
	 if($_POST['mode'] == 'send' && $_POST['act'] == 'manageemail' && isset($_POST['updateletterSbt'])){
	 	
		$newsletter_name = addslashes(trim($_POST['newsletter_name']));
		$description = addslashes(trim($_POST['description']));
		if($newsletter_name == ''){
			$errmsg = base64_encode('Please Enter Email Subject');
			header("Location: admin.php?act=editemail&newsid=".base64_encode($_POST['newsid'])."&errmsg=$errmsg");
			exit;
		}
		if($description == ''){
			$errmsg = base64_encode('Please Enter Message Body');
			header("Location: admin.php?act=editemail&newsid=".base64_encode($_POST['newsid'])."&errmsg=$errmsg");
			exit;
		}
		
		$sql_update = "UPDATE ".$tblprefix."email_conf SET 
												 subject = '".$newsletter_name."', 
												 email_body = '".$description."'
		         								 WHERE id=".$_POST['newsid'];
		$rs = $db->Execute($sql_update);
	
		if($rs){
		 $okmsg = base64_encode("Email Template Updated successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;	  
	       }/* END: if($rs){ */
	
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['updateletterSbt'])) */

	   
######################
#
# 	GET SECTION
#
######################

//---------Single Email Delete---------
	
		if($_GET['mode']=='delletter'){
			 
				$del_qry = " DELETE FROM ".$tblprefix."email_conf WHERE id = '".base64_decode($_GET['newsid'])."'" ;
				$rs__newsletter = $db->Execute($del_qry);
				
				$okmsg = base64_encode("Email Template Deleted successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;
				
	    } /* if($_GET['mode']=='delletter') */

?>
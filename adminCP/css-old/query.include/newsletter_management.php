<?php

######################
#
# 	POST SECTION
#
######################

//-----------ADD News Letter-----------
	
	if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['letterSbt'])){
		$buyer_type = addslashes(trim($_POST['buyer_type']));
		$newsletter_name = addslashes(trim($_POST['newsletter_name']));
		$description = addslashes(trim($_POST['description']));
		
		$sql_query = "INSERT INTO ".$tblprefix."newsletter SET
													 letter_name = '".$newsletter_name."', 
													 letter_description = '".$description."' , 
													 cdate='".date('Y-m-d')."'";
		$rs_newsletter = $db->Execute($sql_query); 
		
		if($rs_newsletter){
		 $okmsg = base64_encode("Newsletter Added successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		 exit;	  
	       }/* END:  if($rs_newsletter) */
	
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['letterSbt'])) */


//---------Update News Letter---------
	   
	 if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['updateletterSbt'])){
	 	$buyer_type = addslashes(trim($_POST['buyer_type']));
		$newsletter_name = addslashes(trim($_POST['newsletter_name']));
		$description = addslashes(trim($_POST['description']));
		
		$sql_update = "UPDATE ".$tblprefix."newsletter SET 
												 letter_name = '".$newsletter_name."', 
												 letter_description = '".$description."'
		         								 WHERE id=".$_POST['newsid'];
		$rs = $db->Execute($sql_update);
	
		if($rs){
		 $okmsg = base64_encode("Newsletter Updated successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;	  
	       }/* END: if($rs){ */
	
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['updateletterSbt'])) */

	   
######################
#
# 	GET SECTION
#
######################

//---------Single NewsLetter Delete---------
	
		if($_GET['mode']=='delletter'){
			 
				$del_qry = " DELETE FROM ".$tblprefix."newsletter WHERE id = '".base64_decode($_GET['newsid'])."'" ;
				$rs__newsletter = $db->Execute($del_qry);
				
				$okmsg = base64_encode("Newsletter Deleted successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;
				
	    } /* if($_GET['mode']=='delletter') */

?>
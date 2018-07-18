<?php

######################
#
# 	POST SECTION
#
######################

//-----------ADD News Letter-----------
	
	if($_POST['mode'] == 'send' && $_POST['act'] == 'news_letter_group_by_name' && isset($_POST['letterSbt'])){
		$subscriber_list = implode(',',$_POST['subscriber_list']);
		$group_name = addslashes(trim($_POST['group_name']));
		//$newsletter_name = addslashes(trim($_POST['newsletter_name']));
		$group_name_des = addslashes(trim($_POST['group_name_des']));

		$sql_query = "INSERT INTO ".$tblprefix."newsletter_groups SET
													 group_name = '".$group_name."', 
													 group_name_des = '".$group_name_des."',
													 subscriber_list = '".$subscriber_list."'
													 ";
		$rs_newsletter = $db->Execute($sql_query); 
		
		if($rs_newsletter){
		 $okmsg = base64_encode("Newsletter Added successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		 exit;	  
	       }/* END:  if($rs_newsletter) */
	
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'manageletter' && isset($_POST['letterSbt'])) */


//---------Update News Letter---------
	   
	 if($_POST['mode'] == 'send' && $_POST['act'] == 'news_letter_group_by_name' && isset($_POST['updategroupSbt'])){
	 	
		$subscriber_list = implode(',',$_POST['subscriber_list']);
		
		
		$buyer_type = addslashes(trim($_POST['buyer_type']));
		//$newsletter_name = addslashes(trim($_POST['newsletter_name']));
		$description = addslashes(trim($_POST['group_name_des']));
		
		$sql_update = "UPDATE ".$tblprefix."newsletter_groups SET 
													group_name_des = '".$description."',
												  	 subscriber_list = '".$subscriber_list."'
												     WHERE id=".$_POST['newsid'];
		$rs = $db->Execute($sql_update);
	
		if($rs){
		 $okmsg = base64_encode("Group Name Updated successfully. !");
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
			 
				$del_qry = " DELETE FROM ".$tblprefix."newsletter_groups WHERE id = '".base64_decode($_GET['newsid'])."'" ;
				$rs__newsletter = $db->Execute($del_qry);
				
				$okmsg = base64_encode("Group Name Deleted successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;
				
	    } /* if($_GET['mode']=='delletter') */

?>
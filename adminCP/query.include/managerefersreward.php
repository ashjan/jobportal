<?php

######################
#
# 	POST SECTION
#
######################

//---------Update Refers Reward---------
	   
	 if($_POST['mode'] == 'send' && $_POST['act'] == 'managerefersreward' && isset($_POST['updaterefersrewardSbt'])){
	 	$refferer_reward_percentage  = $_POST['refferer_reward_percentage'];
		$set="";
		
 	    $set=" refferer_reward_percentage=".$refferer_reward_percentage;
		
		$sql_update = "UPDATE ".$tblprefix."refers_reward SET ".$set."
 	    WHERE id=".base64_decode($_POST['refid']);

		
		$rs = $db->Execute($sql_update);
	
		if($rs){
		 $okmsg = base64_encode("Refers reward amount updated successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		  exit;	  
	       }else{
		  echo "<br/> Refers Reward Amount not updated <br/>";
		   }
		   /* END: if($rs){ */
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'refers reward ' && isset($_POST['referers reward '])) */
?>
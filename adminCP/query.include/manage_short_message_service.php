<?php
//---------Update Short Message Service---------
	 if($_POST['mode'] == 'send' && $_POST['act'] == 'short_message_service' && isset($_POST['updatemessageSbt'])){
		$user_id 			= addslashes(trim($_POST['user_id']));
		$password 			= addslashes(trim($_POST['password']));
		$api_id 			= trim($_POST['api_id']);
		$api_url 			= trim($_POST['api_url']);
		$default_message	= addslashes(trim($_POST['default_message']));
		$success_message 	= addslashes(trim($_POST['success_message']));
		$failure_message 	= addslashes(trim($_POST['failure_message']));
		
		if($user_id == ''){
			//$errmsg = base64_encode('Please Enter User id');
			$errmsg = base64_encode('Unesite korisnički ID');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		if($password == ''){
			//$errmsg = base64_encode('Please Enter password');
			$errmsg = base64_encode('Molimo unesite lozinku');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		
		if($api_id == ''){
			//$errmsg = base64_encode('Please Enter Api id');
			$errmsg = base64_encode('Unesite Api id');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		
		if($api_url == ''){
			//$errmsg = base64_encode('Please Enter Api url');
			$errmsg = base64_encode('Unesite Api url');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		
		if($default_message == ''){
			//$errmsg = base64_encode('Please Enter Default Message');
			$errmsg = base64_encode('Unesite Default poruku');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		
		if($success_message == ''){
			//$errmsg = base64_encode('Please Enter Sucess Message');
			$errmsg = base64_encode('Molimo unesite uspjeh poruku');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		
		if($failure_message == ''){
			//$errmsg = base64_encode('Please Enter Failure Message');
			$errmsg = base64_encode('Unesite neuspjeh poruku');
			header("Location: admin.php?act=edit_short_message_service&messageid=".base64_encode($_POST['messageid'])."&errmsg=$errmsg");
			exit;
		}
		

		 $update_message = "UPDATE ".$tblprefix."short_message_service SET 
												 user_id 			= '".$user_id."', 
												 password 			= '".$password."', 
												 api_id 			= '".$api_id."', 
												 api_url			= '".$api_url."', 
												 default_message	= '".$default_message."',
												 success_message	= '".$success_message."',
												 failure_message	= '".$failure_message."'
		         								 WHERE id=".$_POST['messageid'];
	   											 
												 
		$rs_short_message = $db->Execute($update_message);
	
		if($rs_short_message)
		{
			//$okmsg = base64_encode("Short Messaging Service Configuration Done Successfully!");
			$okmsg = base64_encode("Short Messaging Service konfiguracije učinjeno uspješno!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;	  
	    }/* END: if($rs_short_message){ */	
}

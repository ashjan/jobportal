<?php
session_start();
set_time_limit(0);

include("include/file_include.php");
	
if($_REQUEST['emailid']==""){
	echo 'Internal Server Error, Try again';
	exit;
}else{
	//check either email format is valid
	$act_code = base64_encode(rand().date("mdY").date("Ghi"));
	
	$qry_newsletter = "SELECT * FROM ".$tblprefix."newsletter WHERE id='".$_SESSION['field']['newsletter']."'";
	$rs_newsletter = $db->Execute($qry_newsletter);
	
	$newsletter_body = trim($rs_newsletter->fields['letter_description']);
	
	$_SESSION['recipients'][$_REQUEST['emailid']] = trim($_SESSION['recipients'][$_REQUEST['emailid']]);
	if(!is_array($_SESSION['justsentemails'])){
		if(isvalidemailformat($_SESSION['recipients'][$_REQUEST['emailid']])){
			//check either Subscriber is valid or not
			$emailid =  RandomNumberGen("15");
			$statusofrecp = isvalidemail($_SESSION['recipients'][$_REQUEST['emailid']], $_SESSION['savednewsletterid'], $emailid);
			if($statusofrecp == "old"){
			
				sendnewsletter($_SESSION['recipients'][$_REQUEST['emailid']], $_SESSION['field']['subject'], $newsletter_body, $_SESSION['field']['sendername'], $_SESSION['field']['senderemail']);
				$_SESSION['sentemails']++;
			}
		}else{
			$_SESSION['invalidemails']++;
		}
		$_SESSION['justsentemails'][] = $_SESSION['recipients'][$_REQUEST['emailid']];	
	}else{
		
			if(isvalidemailformat($_SESSION['recipients'][$_REQUEST['emailid']])){
				//check either Subscriber is valid or not
				$emailid =  RandomNumberGen("15");
				$statusofrecp = isvalidemail($_SESSION['recipients'][$_REQUEST['emailid']], $_SESSION['savednewsletterid'], $emailid);
				if($statusofrecp == "old"){
					sendnewsletter($_SESSION['recipients'][$_REQUEST['emailid']], $_SESSION['field']['subject'], $newsletter_body, $_SESSION['field']['sendername'], $_SESSION['field']['senderemail']);
					$_SESSION['sentemails']++;
				}
			}else{
				$_SESSION['invalidemails']++;
			}
			$_SESSION['justsentemails'][] = $_SESSION['recipients'][$_REQUEST['emailid']];
		
	}
	echo '<br>'.$_SESSION['recipients'][$_REQUEST['emailid']].' <span style="color:#ff0000;">sent</span>';
}

//Functions//
//is Valid email format or not
function isvalidemailformat($email){
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
		return true;
	}else{
		return false;
	}
}
//Randon Key Gen
function RandomNumberGen($no){
	$totalChar = $no;  //length of random number
	$salt = "abcdefghijklmnpqrstuvwxyz123456789";  // salt to select chars
	srand((double)microtime()*1000000); // start the random generator
	$password=""; // set the inital variable
	for ($i=0;$i<$totalChar;$i++)  // loop and create number
	$randnumber= $randnumber. substr ($salt, rand() % strlen($salt), 1);
	return $randnumber;
}
//Server Path for Activation
function getrootpath(){
$fullpath = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$isolated = explode("/", $fullpath);
$lesscounter = count($isolated)-2;
$adminpath = "";
  for($getme=0; $getme<=$lesscounter; $getme++){
  	if($adminpath==""){
		$adminpath = $isolated[$getme];
	}else{
		$adminpath = $adminpath."/".$isolated[$getme];
	}
  }
$adminpath = $adminpath."/";
return $adminpath;
}
//Subscriber verification
function isvalidemail($email, $newsletterid, $emailid){
 return "old";
}
//Saving Newsletter

//Sending Newsletter

function sendnewsletter($toemail, $newslettersubject, $newsletter, $sendername, $senderemail){

	/*Setting Email Body and Sending*/
	
	$rs_qry_noreply = mysql_query("SELECT noreplyemail,notifyemail FROM tbl_admin") or die(mysql_error());
	$row_qry_noreply = mysql_fetch_array($rs_qry_noreply);
		
	$noreply_email = $row_qry_noreply['noreplyemail'];
	$notifyemail = $row_qry_noreply['notifyemail'];
	
	$rs_qry = mysql_query("SELECT act_code,id FROM tbl_newletter_subscriber WHERE sub_email = '".$toemail."'") or die(mysql_error());
	$row_qry = mysql_fetch_array($rs_qry);
		
	$toemailid = $row_qry['id'];
	$encode_str = "message.php?act_str_unsub=".$act_code."&unsubid=";
	$encode_id = base64_encode($toemailid);
	
	$unscribe_link = 'Click <a href="'.MYSURL.$encode_str.$encode_id.'">Unsubscribe Now</a> if you do not wish to get any more newsletters from Unique Hijabs';
	
	$search = array('{UNSUBSCRIBE_LINK}');
	$replace = array($unscribe_link);
	
	$newsletter_body = str_replace($search,$replace,stripslashes($newsletter));
	
	
				$mContact = new Mail;
				$mContact->ReplyTo($noreply_email);
				$mContact->To($toemail);
				$mContact->Subject($newslettersubject);
				//$mContact->Envelope('-f'.$notifyemail);
				$mContact->Body($newsletter_body);
				$mContact->Priority(2) ; 
				$mContact->Send();

	
}

?>
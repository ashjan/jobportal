<?php

######################
#
# 	POST SECTION
#
######################

//-----------ADD Subscriber-----------

	if($_POST['mode'] == 'send' && $_POST['act'] == 'managesubscriber' && isset($_POST['addsubscribeSbt'])){
	
		$buyer_type = addslashes(trim($_POST['buyer_type']));
		$sub_email = addslashes(trim($_POST['sub_email']));
		$act_code = base64_encode(rand().date("mdY").date("Ghi"));
		
		$chk_qry = "SELECT * FROM ".$tblprefix."newletter_subscriber WHERE sub_email = '".$sub_email."'";
		$rs_cate = $db->Execute($chk_qry);
		$count_rec = $rs_cate->RecordCount();

		if($count_rec != 0){
			$errmsg = base64_encode('Subscriber Email you have entered already exist.');
			header("Location: admin.php?act=managesubscriber&errmsg=$errmsg");
			exit;
		}
		
		
		if($sub_email == ''){
			$errmsg = base64_encode('Please Enter Subscriber Email.');
		}else{
		
		$ins_news = "INSERT INTO ".$tblprefix."newletter_subscriber SET
															sub_email = '".$sub_email."',
															act_code = '".$act_code."',
															status = '0'";
		$rs_ins_news = $db->Execute($ins_news);
		
				if($rs_ins_news){
		 			$okmsg = base64_encode("Newsletter Subscriber Added successfully. !");
		 			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		 			exit;	  
	       		}/* END:  if($rs_grade) */
			}/* END: if($sub_email == '') */
	   }/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'managesubscriber' && isset($_POST['addsubscribeSbt'])) */
	   
	   if($_POST['act']=='managesubscriber' && $_POST['active'] == 'Activate All' ){
			
			
							
			$delfaqid= array();
			$delfaqid = $_POST['checkbox'];
													
			if(count($delfaqid) > 0){
			
				foreach($delfaqid as $key => $del_catid){
					
					//$recent_qry = "SELECT * FROM ".$tblprefix."category WHERE id = '".$del_catid."'";
				//	$rs_recent = $db->Execute($recent_qry);
				
				$del_parent = "UPDATE ".$tblprefix."newletter_subscriber SET status = '1' WHERE id = '".$del_catid."'" ;
				
					$rs_parent = $db->Execute($del_parent);

				}//end foreach
				
			}//end if count
			
			$okmsg = base64_encode("Selected Newsletter Subscriber Activate successfully.");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
							 
		}
		if($_POST['act']=='managesubscriber' && $_POST['deactive'] == 'Deactivate All' ){
			
			
							
			$delfaqid= array();
			$delfaqid = $_POST['checkbox'];
													
			if(count($delfaqid) > 0){
			
				foreach($delfaqid as $key => $del_catid){
					
					//$recent_qry = "SELECT * FROM ".$tblprefix."category WHERE id = '".$del_catid."'";
				//	$rs_recent = $db->Execute($recent_qry);
				
				$del_parent = "UPDATE ".$tblprefix."newletter_subscriber SET status = '0' WHERE id = '".$del_catid."'" ;
				
					$rs_parent = $db->Execute($del_parent);

				}//end foreach
				
			}//end if count
			
			$okmsg = base64_encode("Selected Newsletter Subscriber Deactivate successfully.");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
							 
		}
	   
######################
#
# 	GET SECTION
#
######################

//---------Single NewsLetter Delete---------
	
	if($_GET['mode']=='delsubscriber'){
			 
		$del_qry = " DELETE FROM ".$tblprefix."newletter_subscriber WHERE id = '".base64_decode($_GET['subid'])."'" ;
		$rs__newsletter = $db->Execute($del_qry);
				
		$okmsg = base64_encode("Subscriber Deleted successfully. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
				
	    } /* if($_GET['mode']=='delsubscriber') */
		
//---------NewsLetter Email Status---------		
		 
	if($_GET['mode']=='updatenewsletterstatus' && isset($_GET['status'])){

		$oldstatus = $_GET['status'];
		$subid=base64_decode($_GET['subid']);
		$act=$_GET['act'];
				
		if($oldstatus == '0'){
			$newstatus = 1;
		}else{
			$newstatus = 0;
				}
			$update_qry = "UPDATE ".$tblprefix."newletter_subscriber SET 
														   status = '".$newstatus."' WHERE id = '".$subid."'";
				$update_rs = $db->Execute($update_qry);
				
				if($update_rs){
				   
					$_SESSION['updatenewsletterstatus']='yes'; 
					$okmsg = base64_encode('Subscribe Status updated successfully.');
					header("Location: admin.php?act=$act&okmsg=$okmsg");
					exit;
				
				}//end if($update_rs)
				exit;
		
		}/*END: if($_GET['mode']=='updatenewsletterstatus' && isset($_GET['status'])) */

?>
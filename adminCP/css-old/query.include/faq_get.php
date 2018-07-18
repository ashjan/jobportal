<?php
	//---------Single FAQ's Delete---------
	if($_POST['mode']=='send' && $_POST['request_page']=='faq_get' && $_POST['act']=='addfaq'){
				$update_qry = "INSERT ".$tblprefix."faq SET 
														 question = '".$_POST['faq_question']."',
														 answer = '".$_POST['description']."',
														 status = '".$_POST['status']."'";
				$update_rs = $db->Execute($update_qry);
	
				if($update_rs){
					$okmsg = base64_encode('FAQ Inserted successfully.');
					header("Location: admin.php?act=".$_POST['act2']."&okmsg=$okmsg");
					exit;
				
				}//end if($update_rs)
				exit;
		
		}
	if($_POST['mode']=='update' && $_POST['request_page']=='faq_get' && $_POST['act']=='addfaq'){
				$id=$_POST['faqid'];
				$update_qry = "UPDATE ".$tblprefix."faq SET 
														 question = '".$_POST['faq_question']."',
														 answer = '".$_POST['description']."',
														 status = '".$_POST['status']."'
														 WHERE 
														 id=".$id;

				$update_rs = $db->Execute($update_qry);

				if($update_rs){
					$okmsg = base64_encode('FAQ Update successfully.');
					header("Location: admin.php?act=".$_POST['act2']."&okmsg=$okmsg");
					exit;
				
				}//end if($update_rs)
				exit;
		
		}		


	if($_GET['mode']=='delfaq'){
			 
			$del_qry = " DELETE FROM ".$tblprefix."faq WHERE id = '".base64_decode($_GET['faqid'])."' " ;
			$rs_faq = $db->Execute($del_qry);
				
			$okmsg = base64_encode("FAQ Deleted successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;
				
	    } /* END: if($_GET['mode']=='delfaq') */
		
	//---------Change FAQ's Status---------
	if($_GET['mode']=='updatefaqstatus' && isset($_GET['status'])){

			$oldstatus = $_GET['status'];
			$faqid=base64_decode($_GET['faqid']);
			$act=$_GET['act'];
				
				if($oldstatus == '0'){
					
					$newstatus = 1;
				}else{
		
					$newstatus = 0;
				}
				
				$update_qry = "UPDATE ".$tblprefix."faq SET 
														 status = '".$newstatus."' 
														 WHERE id = '".$faqid."'";
				$update_rs = $db->Execute($update_qry);
				
				if($update_rs){

					$okmsg = base64_encode('FAQ Status updated successfully.');
					header("Location: admin.php?act=$act&okmsg=$okmsg");
					exit;
				
				}//end if($update_rs)
				exit;
		
		}

?>
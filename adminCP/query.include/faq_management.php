<?php
	if($_POST['mode'] == 'send' && $_POST['act'] == 'viewfaq' && isset($_POST['addfaqSbt'])){
		$question = addslashes(trim($_POST['faq_question']));
		$answer = addslashes(trim($_POST['description']));
		$status = addslashes(trim($_POST['status']));
		
		$sql_query = "INSERT INTO ".$tblprefix."faq SET 
													 question = '".$question."', 
													 answer = '".$answer."' , 
													 cdate='".date('Y-m-d')."', 	
													 status='".$status."'";
		$rs_faq = $db->Execute($sql_query); 
		
		if($rs_faq){
		 $okmsg = base64_encode("FAQ Added successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		 exit;	  
	       }/* END:  if($rs_faq) */
	
	   }
	/* END: if($_POST['mode'] == 'send' && $_POST['act'] == 'addfaq' && isset($_POST['addfaqSbt'])) */
    if($_POST['mode'] == 'send' && $_POST['act'] == 'viewfaq' && isset($_POST['updatefaqSbt'])){
		$question = addslashes(trim($_POST['faq_question']));
		$answer = addslashes(trim($_POST['description']));
		$status = addslashes(trim($_POST['status']));
		
		$sql_update = "UPDATE ".$tblprefix."faq SET 
												 question = '".$question."',
												 answer='".$answer."',
												 status='".$status."'
		         								 WHERE id=".$_POST['faqid'];
		$rs = $db->Execute($sql_update);
	
		if($rs){
			 $okmsg = base64_encode("FAQ Updated successfully. !");
		 	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;	  
		}
	
	   }
	//---------Multiple FAQ's Delete---------	   
    if($_POST['act']=='viewfaq' && $_POST['delete'] == 'Delete All' ){ 
							
			$delfaqid= array();
			$delfaqid = $_POST['checkbox'];
													
			if(count($delfaqid) > 0){
			
				foreach($delfaqid as $key => $value){
																										
				$del_qry = " DELETE FROM ".$tblprefix."faq WHERE id = '".$value."' " ;
				$rs = $db->Execute($del_qry);
					
				}//end foreach
			}//end if count
			
			$okmsg = base64_encode("FAQ's Deleted successfully.. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
			exit;
							 
		} 
	/* END:  if($_POST['act']=='viewfaq' && $_POST['delete'] == 'Delete All' )  */

?>
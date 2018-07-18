<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//---------UPDATE STAUS PROPERTY MANAGER ---------
//echo "<pre>"; print_r($_GET); exit;
if($_GET['mode']=='change_pmstatus' && $_GET['act']=='testimonials_listing' && $_GET['request_page']=='testimonials_manager'){
		$id=base64_decode($_GET['id']);
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		$update_qry = " UPDATE ".$tblprefix."testimonials SET
		                                                  status = '".$newstatus."'
														  WHERE id  = '".$id."' ";
		$rs_pmqry = $db->Execute($update_qry);			
		
		 
			
		$okmsg = base64_encode("Manager Record successfully UPDATED And Properties Against Him Also. !");
					header("Location: admin.php?okmsg=$okmsg&act=testimonials_listing");
					exit;	  
} 
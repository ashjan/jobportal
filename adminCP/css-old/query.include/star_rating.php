<?php
if($_POST['mode']=='add' && $_POST['act']=='star_rating' && $_POST['request_page']=='star_rating'){

$post=$_POST;
/*echo '<pre>';
print_r($post);
exit;*/
$error='';


$start_rating = addslashes($post['start_rating']);

				if($post['start_rating']==''){
					$error="Star Rating is compulsory<br>";
				}
				
						
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{

	
					echo  $start_rat  =  "INSERT INTO ".$tblprefix."star_rating SET 
																start_rating = '".$post['start_rating']."'																							                                                                "; 
	 					
							$start_rat_res= $db->Execute($start_rat);
							
							
			if($run_query)
			{
										

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();

								
								
								
								
								$okmsg = base64_encode("Star Rating inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
							else
							{
								$okmsg = base64_encode("Star Rating Added Successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
							
					

}

}




	


/****************************************************************************
*																			*
*                            Update Events 									*
*																			*
****************************************************************************/




if($_POST['mode']=='update' && $_POST['act']=='star_rating' && $_POST['request_page']=='star_rating')
{

$post=$_POST;
$error='';
$id=$_POST[page_id];

$gdt_page_title = addslashes($post['start_rating']);


//regular exprission
$gdt_page_title_slug=preg_replace('/[^a-z0-9]/i', '', $start_rating_page_title_slug);




				if($post['start_rating']==''){
					$error="Star Rating is compulsory<br>";
				}
				
	
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{

		
				 	$update_gdt_query  =  "UPDATE ".$tblprefix."star_rating SET 
																start_rating = '".$post['start_rating']."'
																where id=".$id; 
	 						
							$start_rat_res= $db->Execute($update_gdt_query);
						
							if($run_query){
							
							
							
							
										
										

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;

							
							
							
								$okmsg = base64_encode("Star Rating updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Star Rating updated in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}


}
}
	
	

/***************************************************************************
*
*                         Delete Events 
*
***************************************************************************/

if($_GET['mode']=='delete' && $_GET['act']=='star_rating' && $_GET['request_page']=='star_rating')
{


 	$id=base64_decode($_GET['id']); 
	
	
		
		$del_qry = " DELETE FROM ".$tblprefix."star_rating WHERE id =".$id;  
		$rs_delete = $db->Execute($del_qry);
		
			
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='gdtdescription_type' ";  
		$rs_delete = $db->Execute($del_qry);
		
		
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='gdt_type' ";  
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){	
			$okmsg = base64_encode("Star Rating Deleted successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}else{
		$okmsg = base64_encode("Star Rating to Delete.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		
 	} 
} 






?>
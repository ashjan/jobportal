<?php 
if($_POST['mode']=='add' && $_POST['act']=='lang_cont_managment' && $_POST['request_page']=='language_content'){ 
$post=$_POST;
$error='';
if($post['language_id']==''){
	//$error="Select a Language <br>";
	$error="Izaberite jezik <br>";
}
if($post['page_id']==''){
	//$error.="Select a page<br>";
	$error.="Izaberite stranu<br>";
}
if($post['field_name']==''){
	//$error.="field name is required<br>";
	$error.="Potrebno je unijeti naziv polja<br>";
}

$arry=explode(' ', $post['field_name']);
if(isset($arry[1])){
	//$error.="White space in field name<br>"; 
	$error.="Prazno polje u nazivu <br>";
}
if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬]/', $post['field_name']))
{
   //$error.="special character in filed name<br>"; 
   $error.="special character in filed name<br>";
}
if($post['page_type']==''){
	//$error.="Page Type is required<br>";
	$error.="Page Type is required<br>";
}
$arry=explode(' ', $post['page_type']);
if(isset($arry[1])){
 	//$error.="White space in page type<br>";
	$error.="Bijelo polje u vrsti strane<br>";
}
if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬]/', $post['page_type']))
{
   //$error.="special character in page type<br>"; 
   $error.="Posebni karakteri u vrsti polja<br>"; 
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act2']);
			exit;
}
else{
						$select_query = "SELECT * From
												".$tblprefix."language_contents
												WHERE
												language_id = ".$post['language_id']." 
												AND
												page_id = ".strtoupper($post['page_id'])."
												AND
												field_name= '".$post['field_name']."'
												AND
												fld_type ='".$post['page_type']."'
												";
				$sel_run_query = $db->Execute($select_query);
				if($sel_run_query->fields){
					$id= base64_encode($sel_run_query->fields['id']);
					$type= base64_encode($sel_run_query->fields['fld_type']);
						//$errmsg = base64_encode("This filed has been already Translated.!");
						$errmsg = base64_encode("Ovo polje je vec prevedeno.!");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act2']."&id=".$id."&type=".$type);
						exit;
				}else{
				$update_img_query = "INSERT ".$tblprefix."language_contents SET
														language_id = '".$post['language_id']."',
														page_id = '".strtoupper($post['page_id'])."',
														field_name= '".$post['field_name']."',
														translated_text= '".$post['translated_text']."',
														fld_type ='".$post['page_type']."'
														"; 
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								//$okmsg = base64_encode("Language Content inserted successfully.!");
								$okmsg = base64_encode("Jezicki sadržaj uspješno unijet.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$errmsg = base64_encode("Unable to add Language Content in database.!");
								$errmsg = base64_encode("Nije moguce dodati jezicki sadržaj.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
							}
					}
	}
}




if($_POST['mode']=='update' && $_POST['act']=='edit_lang_cont_managment' && $_POST['request_page']=='language_content'){
$post=$_POST;
$error='';
if($post['language_id']==''){
	//$error="Select a Language <br>";
	$error="Izaberite jezik <br>";
}
if($post['page_id']==''){
	//$error.="Select a page<br>";
	$error.="Izaberite stranu<br>";
}
if($post['field_name']==''){
	//$error.="field name is required<br>";
	$error.="Potrebno je unijeti naziv polja<br>";
}

$arry=explode(' ', $post['field_name']);
if(isset($arry[1])){
	//$error.="White space in field name<br>"; 
	$error.="Prazno polje u nazivu <br>";
}
if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬]/', $post['field_name']))
{
   $error.="special character in filed name<br>"; 
}
if($post['page_type']==''){
	$error.="Page Type is required<br>";
}
$arry=explode(' ', $post['page_type']);
if(isset($arry[1])){
	//$error.="White space in page type<br>";
	$error.="Bijelo polje u vrsti strane<br>";
}
if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬]/', $post['page_type']))
{
   //$error.="special character in page type<br>"; 
   $error.="Posebni karakteri u vrsti polja<br>"; 
}
if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit;
}
else{
			$select_query = "SELECT * From
												".$tblprefix."language_contents
												WHERE
												language_id = ".$post['language_id']." 
												AND
												page_id = ".strtoupper($post['page_id'])."
												AND
												field_name= '".$post['field_name']."'
												AND
												fld_type ='".$post['page_type']."'
												AND
												id<>".$post['id']."
												";
				$sel_run_query = $db->Execute($select_query);
				if($sel_run_query->fields){
					$id= base64_encode($sel_run_query->fields['id']);
					$type= base64_encode($sel_run_query->fields['fld_type']);
						//$errmsg = base64_encode("This filed has been already Translated.!");
						$errmsg = base64_encode("Ovo polje je vec prevedeno.!");
						header("Location: admin.php?errmsg=$errmsg&act=".$post['act2']."&id=".$id."&type=".$type);
						exit;
				}else{
						$update_img_query = "UPDATE ".$tblprefix."language_contents SET
														language_id = '".$post['language_id']."',
														page_id = '".strtoupper($post['page_id'])."',
														field_name= '".$post['field_name']."',
														translated_text= '".$post['translated_text']."',
														fld_type ='".$post['page_type']."'
														WHERE 
														id = ".$post['id']."
														"; 
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								//$okmsg = base64_encode("Language Content inserted successfully.!");
								$okmsg = base64_encode("Jezicki sadržaj uspješno dodat!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
								exit;
							}else{
								//$errmsg = base64_encode("Unable to add Language Content in database.!");
								$errmsg = base64_encode("Nije moguce dodati jezicki sadržaj.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act2']);
								exit;
							}
						}														
	}
}
if($_GET['mode']=='delete' && $_GET['act']=='lang_cont_managment' && $_GET['request_page']=='language_content'){
$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE id = ".$id;
		$rs_newsletter = $db->Execute($del_qry);				
		//$okmsg = base64_encode("Deleted Item successfully. !");
		$okmsg = base64_encode("Stavka uspješno izbrisana. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	

}
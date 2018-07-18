<?php 
/**************************************************************************
								ADD PDF
**************************************************************************/ 

if($_POST['mode']=='add' && $_POST['act']=='pdf_files' && $_POST['request_page']=='pdf_upload'){
	
	$post=$_POST;
	
	$error='';
	$property_id	= addslashes(trim($_POST['property_name']));
	$property_name 	= addslashes(trim($_POST['property_name']));	
	$userfile		=  $_FILES['userfile'];
    
	
	if($property_name== 0){
		//$error.="Please Select Property Name <br>";
		$error.="Molimo izaberite vlasnika objekta<br>";
	}

	if($userfile == ''){
		//$error.="Please Upload pdf file<br>";
		$error.="Molimo dodajte PDF<br>";
	}

	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
		exit;
	}else{
		$images=$_FILES['userfile'];
		$count=count($images['name']);
		$errmsg='';
		$okmsg='';
		
			$type = explode("/", $images['type']);
			$size = $images['size'][$i];
			
			if($type[1]!="pdf"){
				//$errmsg .= base64_encode("PDF format was wrong!<br>");
				$errmsg .= base64_encode("Format PDF fajla nije ispravan!<br>");
			}else{
				
				//$image_name_rand = generateRandomString(10);
			$tmp_name=$_FILES['userfile']['name'];
			
			$tmp_name=str_replace(" ","_",$tmp_name);
			$tmp_name=str_replace("@","_",$tmp_name);
			$tmp_name=str_replace("!","_",$tmp_name);
			$tmp_name=str_replace("#","_",$tmp_name);
			$tmp_name=str_replace("$","_",$tmp_name);
			$tmp_name=str_replace("%","_",$tmp_name);
			
			$tmp_name=str_replace("^","_",$tmp_name);
			$tmp_name=str_replace("&","_",$tmp_name);
			$tmp_name=str_replace("*","_",$tmp_name);
			$tmp_name=str_replace("(","_",$tmp_name);
			$tmp_name=str_replace(")","_",$tmp_name);
			$tmp_name=str_replace("+","_",$tmp_name);
			$tmp_name=str_replace("=","_",$tmp_name);
			
			$tmp_name=str_replace("\\","_",$tmp_name);
			$tmp_name=str_replace("/","_",$tmp_name);
			$tmp_name=str_replace("'","_",$tmp_name);
			$tmp_name=str_replace("[","_",$tmp_name);
			$tmp_name=str_replace("]","_",$tmp_name);
			$tmp_name=str_replace("{","_",$tmp_name);
			$tmp_name=str_replace("}","_",$tmp_name);
			
			$tmp_name=str_replace("<","_",$tmp_name);
			$tmp_name=str_replace(">","_",$tmp_name);
			$tmp_name=str_replace("?","_",$tmp_name);
			$tmp_name=str_replace("|","_",$tmp_name);
			$tmp_name=str_replace(";","_",$tmp_name);
			$tmp_name=str_replace(".","_",$tmp_name);
			$tmp_name=str_replace(",","_",$tmp_name);
				
				$file_name = $tmp_name.".".$type[1];
				$sel_qry = "SELECT * FROM ".$tblprefix."pdf_files WHERE file_name ='".$file_name."'";
				$rs_select = $db->Execute($sel_qry);

				if($rs_select->fields){
					$image_name_rand = generateRandomString(10);
					$file_name = $file_name."_".$image_name_rand.".".$type[1];

				}

				$full_path = "../pdf_file/".$file_name;
				$target_path = "../pdf_file/";
				$info = getimagesize($_FILES['userfile']['tmp_name']);
               
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path.$file_name)){

					$insert_pdf_query = "INSERT ".$tblprefix."pdf_files SET
												file_name 	= '".$file_name."',
												full_path	= '".$full_path."',												
										 	  property_id 	= '".$property_id."'";
				          
               
					$run_query = $db->Execute($insert_pdf_query);
					if($run_query){
						//$msg.= base64_encode("Pdf Uploaded successfully!\n");
						$msg.= base64_encode("PDF je uspješno dodat!\n");
					}else{
						//$errmsg.= base64_encode("Pdf not Uploaded to DB!");
						$errmsg.= base64_encode("PDF nije dodat!");
					}
				}else{
					//$errmsg.= base64_encode("Unable to upload Pdf!<br>");
					$errmsg.= base64_encode("PDF fajl nije dodat!<br>");
				}

			}		
		header("Location: admin.php?msg=$msg&errmsg=$errmsg&act=".$_POST['act']);
		exit;
	}
}

/********************************************************************************
								EDIT PDF
********************************************************************************/ 

   
	
if($_POST['mode']=='update' && $_POST['act']=='pdf_files'){
	$post=$_POST;
	$error='';
	
	
	$property_id 	= addslashes(trim($_POST['property_name']));	
	$userfile		= $_FILES['userfile'];
	$id	=base64_decode($_POST['id']);
	
	if($property_id == 0){
		//$error.="Please Select Property name <br>";
		$error.="Molimo izaberite vlasnika objekta<br/>";
	}

	
	if($userfile == ''){
		//$error.="Please upload pdf file.!<br>";
		$error.="Molimo dodajte PDF.!<br/>";
	}
	
	
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=edit_pdf_files&id=".$_POST['id']);
		exit;
	}
	

	if(!empty($_FILES['userfile']['name'])){
		$image_name_rand = generateRandomString(10);
		$type = explode(".", $_FILES['userfile']['name']);
		if($type[1]!="pdf"){
			//$okmsg = base64_encode("pdf must be pdf format.!");
			$okmsg = base64_encode("pdf must be pdf format.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit();
		}else{
			//$file_name = $image_name_rand.".".$type[1];
			$tmp_name=$_FILES['userfile']['name'];
			
			$tmp_name=str_replace(" ","_",$tmp_name);
			$tmp_name=str_replace("@","_",$tmp_name);
			$tmp_name=str_replace("!","_",$tmp_name);
			$tmp_name=str_replace("#","_",$tmp_name);
			$tmp_name=str_replace("$","_",$tmp_name);
			$tmp_name=str_replace("%","_",$tmp_name);
			
			$tmp_name=str_replace("^","_",$tmp_name);
			$tmp_name=str_replace("&","_",$tmp_name);
			$tmp_name=str_replace("*","_",$tmp_name);
			$tmp_name=str_replace("(","_",$tmp_name);
			$tmp_name=str_replace(")","_",$tmp_name);
			$tmp_name=str_replace("+","_",$tmp_name);
			$tmp_name=str_replace("=","_",$tmp_name);
			
			$tmp_name=str_replace("\\","_",$tmp_name);
			$tmp_name=str_replace("/","_",$tmp_name);
			$tmp_name=str_replace("'","_",$tmp_name);
			$tmp_name=str_replace("[","_",$tmp_name);
			$tmp_name=str_replace("]","_",$tmp_name);
			$tmp_name=str_replace("{","_",$tmp_name);
			$tmp_name=str_replace("}","_",$tmp_name);
			
			$tmp_name=str_replace("<","_",$tmp_name);
			$tmp_name=str_replace(">","_",$tmp_name);
			$tmp_name=str_replace("?","_",$tmp_name);
			$tmp_name=str_replace("|","_",$tmp_name);
			$tmp_name=str_replace(";","_",$tmp_name);
			$tmp_name=str_replace(".","_",$tmp_name);
			$tmp_name=str_replace(",","_",$tmp_name);
			
			$file_name = $tmp_name.".".$type[1];
			$full_path = "../pdf_file/".$file_name;
			$target_path = "../pdf_file/";
			$info = getimagesize($_FILES['userfile']['tmp_name']);
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path.$file_name)){
				if($_POST['old_pdf']!=""){
					if(file_exists($target_path.$_POST['old_pdf'])){
						@unlink($target_path.$_POST['old_pdf']);
					}
				}
				$update_pdf_query = "UPDATE ".$tblprefix."pdf_files SET
												file_name 	= '".$file_name."',
												full_path	= '".$full_path."',	
												property_id = '".$property_id."'	
									 WHERE id=".$id;
											 
				$run_query = $db->Execute($update_pdf_query);
				if($run_query){
					//$msg.= base64_encode("Pdf uploaded Successfully!\n");
					$msg.= base64_encode("PDF je uspješno dodat!\n");
				}else{
					//$errmsg.= base64_encode("Pdf not uploaded to DB!");
					$errmsg.= base64_encode("PDF nije dodat!");
				}
			}else{
				//$okmsg = base64_encode("Unable to upload  Pdf.!");
				$okmsg = base64_encode("PDF fajl nije dodat.!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
				exit;
			}
		}
	} else {
		$file_name = $_POST['old_pdf'];
		$id = base64_decode($_POST['id']);
		$full_path = "../pdf_file/".$file_name;
		$update_pdf_query = "UPDATE ".$tblprefix."pdf_files SET
												file_name 	= '".$file_name."',
												full_path	= '".$full_path."',	
												property_id = '".$property_id."'											
										 	 WHERE id=".$id;
		$run_query = $db->Execute($update_pdf_query);	
	}
}



/******************************************************************************
								DELETE PDF
******************************************************************************/ 

if($_GET['mode']=='delete' && $_GET['act']=='pdf_files' && $_GET['request_page']=='pdf_upload'){
	
	$id=base64_decode($_GET['id']);
	$sel_qry = "SELECT file_name FROM ".$tblprefix."pdf_files WHERE id =".$id;
	$rs_select = $db->Execute($sel_qry);

	$file_name	= $rs_select->fields['file_name'];
	$del_qry	= " DELETE FROM ".$tblprefix."pdf_files WHERE id =".$id;
	$rs_delete	= $db->Execute($del_qry);
	
	if($rs_delete){
		$target_path =  "../pdf_file/";
		if(file_exists($target_path.$file_name)){
			@unlink($target_path.$file_name);
		}
		//$okmsg = base64_encode("PDF Deleted Successfully. !");
		$okmsg = base64_encode("PDF fajl uspješno izbrisan. !");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}
	else{
		//$okmsg = base64_encode("Unable to Delete .!");
		$okmsg = base64_encode("PDF fajl nije izbrisan.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;

	}
}
?>
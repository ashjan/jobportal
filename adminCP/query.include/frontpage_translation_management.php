<?php	
//Update Section
if($_POST['mode']=='update' && $_POST['act']=='frontpage_translation' && $_POST['request_page']=='frontpage_translation_management'){
$post=$_POST;
//$myFile = "../app_montenegro/views/include/testFile.php";
//$myFile = "http://dev.evsoft.pk/montenegro/app_montenegro/views/include/ENG_language.php";
$myFile = "../../task3//ENG_language.php";
//$myFile = "../app_montenegro/views/include/demo.php";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = '<?php $Lan=array(';
$counter=0;
foreach($post as $key=>$values){
$stringData .= "'$key'=>'$values'";
if($counter<(count($post)-1))$stringData .= ",";
$counter++;
}
$stringData .= '); ?>';
fwrite($fh, $stringData);
fclose($fh);
$error='';
	}
?>
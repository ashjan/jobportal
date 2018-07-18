<?php	
//Update Section

if($_POST['mode']=='update' && $_POST['act']=='frontpage_translation' && $_POST['request_page']=='frntpg_mon_trans_management'){
$post=$_POST;


//$myFile = "../app_montenegro/views/include/MON_language.php";
$myFile = "../../task3//MON_language.php";

$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = '<?php $Lan=array(';
$counter=0;
foreach($post as $key=>$values){
$stringData .= "'$key'=>'$values'";
if($counter<(count($post)-1))$stringData .= ",";
?>

<?php
$counter++;
}
$stringData .= '); ?>';
fwrite($fh, $stringData);
fclose($fh);
$error='';
	}
	?>
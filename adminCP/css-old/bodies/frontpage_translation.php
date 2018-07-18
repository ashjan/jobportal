<?php 
//$file_0="../app_montenegro/views/include/ENG_language.php";
$file_0="../../task3/ENG_language.php";
//$file_1="../app_montenegro/views/include/RUS_language.php";
//$file_2="../app_montenegro/views/include/MON_language.php";
?>
<style>
#controls{ display:none;}
#controls2{ display:none;}
#controls3{ display:none;}
</style>
<?php 
unset($vars[0]);
include ($file_0);
echo '<form action="admin.php" enctype="multipart/form-data" method="post" name="testform" >';
echo '<br/><b>
<a class="font_size_18" title="Click to open this panel" onclick="jQuery(\'#controls\').slideToggle(\'fast\'); 
jQuery(\'#controls2\').hide(\'fast\'); 
jQuery(\'#controls3\').hide(\'fast\');
return false" href="javascript:;"> English </a>
<b/><br /> <br />';

//$all_defined_vars=get_defined_vars();
$all_defined_vars['GLOBALS']['Lan']=$Lan;
$count=0;
?>
<div id="controls">
<?php
foreach($all_defined_vars['GLOBALS']['Lan'] as $k=>$v){

if($count%2==0){
$cls_style="style=\"background-color:#999999; color:#FFFFFF; font-size:9px;\"";
}else{
$cls_style="style=\"background-color:#CCCCCC; color:#000000; font-size:9px;\"";
}

echo "<table ".$cls_style." cellpadding=\"2\" cellspacing=\"2\"><tr><td>".$k."</td></tr><tr><td><input type=\"text\" class=\"txt4\"  size=\"100\" value=\"".$v."\" Name=\"".$k."\"/></td></tr></table>";
$count++;
}
echo '<input type="Submit" value="Submit" />';
echo '<input type="hidden" name="mode" value="update">';
echo '<input type="hidden" name="act" value="frontpage_translation">';
echo '<input type="hidden" name="request_page" value="frontpage_translation_management" />';
echo '</form>';
?>
</div>
<?php
$count=0;
echo '<form action="admin.php" enctype="multipart/form-data" method="post" name="testform1" >';
echo '<br /> <br /><b>
<a class="font_size_18" title="Click to open this panel" onclick="jQuery(\'#controls2\').slideToggle(\'fast\');
jQuery(\'#controls\').hide(\'fast\'); 
jQuery(\'#controls3\').hide(\'fast\');
 return false" href="javascript:;"> 
 Montenegro </a><b/> <br /> <br />';
?>
<div id="controls2">
<?php
$Lan=array();
//$file_3="../app_montenegro/views/include/MON_language.php";
$file_3="../../task3/MON_language.php";
include ($file_3);
//$all_defined_vars=get_defined_vars();
$all_defined_vars['GLOBALS']['Lan']=$Lan;
foreach($all_defined_vars['GLOBALS']['Lan'] as $k=>$v){
if($count%2==0){
$cls_style="style=\"background-color:#999999; color:#FFFFFF; font-size:9px;\"";
}else{
$cls_style="style=\"background-color:#CCCCCC; color:#000000; font-size:9px;\"";
}
echo "<table ".$cls_style." cellpadding=\"2\" cellspacing=\"2\"><tr><td>".$k."</td></tr><tr><td><input type=\"text\" class=\"txt4\"  size=\"100\" value=\"".$v."\" Name=\"".$k."\"/></td></tr></table>";
$count++;
}
echo '<input type="Submit" value="Submit" align="centre" />';
echo '<input type="hidden" name="mode" value="update">';
echo '<input type="hidden" name="act" value="frontpage_translation">';
echo '<input type="hidden" name="request_page" value="frntpg_mon_trans_management" />';
echo '</form>';
?>
</div>
<?php
$count=0;
echo '<br /> <br /><b>
<a  class="font_size_18" title="Click to open this panel" onclick="jQuery(\'#controls3\').slideToggle(\'fast\'); jQuery(\'#controls\').hide(\'fast\');
jQuery(\'#controls2\').hide(\'fast\');  return false" href="javascript:;"> 
 Russian </a><b/> <br /> <br />';
?>
<div id="controls3">
<?php 
$Lan=array();
echo '<form action="admin.php" enctype="multipart/form-data" method="post" name="testform2" >';
//$file_4="../app_montenegro/views/include/RUS_language.php";
$file_4="../../task3/RUS_language.php";
include ($file_4);
//$all_defined_vars=get_defined_vars();
$all_defined_vars['GLOBALS']['Lan']=$Lan;
foreach($all_defined_vars['GLOBALS']['Lan'] as $k=>$v){
if($count%2==0){
$cls_style="style=\"background-color:#999999; color:#FFFFFF; font-size:9px;\"";
}else{
$cls_style="style=\"background-color:#CCCCCC; color:#000000; font-size:9px;\"";
}
echo "<table ".$cls_style." cellpadding=\"2\" cellspacing=\"2\"><tr><td>".$k."</td></tr><tr><td><input type=\"text\" class=\"txt4\"  size=\"100\" value=\"".$v."\" Name=\"".$k."\"/></td></tr></table>";
$count++;
}
echo '<input type="Submit" value="Submit" />';
echo '<input type="hidden" name="mode" value="update">';
echo '<input type="hidden" name="act" value="frontpage_translation">';
echo '<input type="hidden" name="request_page" value="frntpg_rus_trans_management" />';
echo '</form>';
?>
</div>
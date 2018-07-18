<?php  
ob_start();
session_start();
/*
define('DBHOST', 'localhost'); 
define('DBUSER', 'evsof3_evs');
define('DBPASS', 'evs@2o11');
define('DBNAME', 'evs_montenegro2');
*/
define('DBHOST', 'localhost'); 
define('DBUSER', 'root');
//define('DBPASS', '');
define('DBPASS', '');
define('DBNAME', 'jobportal');
//define('SURL', 'http://'.$_SERVER['HTTP_HOST'].'/montenegro/');
//define('MYSURL', 'http://'.$_SERVER['HTTP_HOST'].'/montenegro/adminCP/');
define('SURL', 'http://'.$_SERVER['HTTP_HOST'].'/jobportal/adminCP/');
define('MYSURL', 'http://'.$_SERVER['HTTP_HOST'].'/jobportal/adminCP/');
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/jobportal/');
//Defining Application Session Name
define('SESSNAME',"sunnymontenegro-adminauth");
//define('TITLE', ':: Ima Nobody ::');
define('ADMIN_TITLE',":: Admin Control Panel ::");
$tblprefix= 'tbl_';
define('SECURITY_CHECK',"1");
include('../classes/adodb/adodb.inc.php');
$db = ADONewConnection('mysql');
// $db->debug = true;
$db->Connect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Database not found! please install your application properly");
?><!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />--><?php mysql_set_charset('utf8');
 mysql_query("SET NAMES 'utf8'");
?>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
include('include/siteconfig.inc.php');
include('include/sitefunction.php');
error_reporting(E_ALL);
//Checking if Admin is already logged in
if(isset($_SESSION[SESSNAME])){
	if($_SESSION[SESSNAME]['islogin']=='yes'){
                header('Location: admin.php');
		exit;
	}
}

if(isset($_POST['mode'])){
	/* if($_SESSION['security_code'] == $_POST['verifycode']){ */
		$sql = "SELECT 
					".$tblprefix."admin.name,
					".$tblprefix."admin.username,
					".$tblprefix."admin.email,
					".$tblprefix."admin.noreplyemail,
					".$tblprefix."admin.notifyemail
					FROM ".$tblprefix."admin 
					WHERE 
					username='".mysql_escape_string($_POST['username'])."' 
					and 
					password = '".mysql_escape_string($_POST['password'])."'";
		$rs = $db->Execute($sql);
		$isrs = $rs->RecordCount();
		if($isrs >0){
				echo $sql_pm_modules = "SELECT 
							".$tblprefix."modules.id, 
							".$tblprefix."modules.module_name, 
							".$tblprefix."modules.module_type, 
							".$tblprefix."modules.module_act,
							".$tblprefix."modules.module_group
							FROM ".$tblprefix."modules
                                                        WHERE
                                                         ".$tblprefix."modules.status=1
							ORDER BY ".$tblprefix."modules.module_order ASC  
							";
				$rs_pm_modules = $db->Execute($sql_pm_modules);
				$isrs_pm_modules = $rs_pm_modules->RecordCount();
				if($isrs_pm_modules > 0){
	
					$modules_groups = array();
					
					while(!$rs_pm_modules->EOF) {
						$modules_groups[$rs_pm_modules->fields['module_group']][] = $rs_pm_modules->fields;
						$rs_pm_modules->MoveNext();
					}
					
				$_SESSION[SESSNAME]['islogin']='yes';
				$_SESSION[SESSNAME]['islogin']=true;
				$_SESSION[SESSNAME]['name']=$rs->fields['name'];
				$_SESSION[SESSNAME]['email']=$rs->fields['email'];
				$_SESSION[SESSNAME]['noreplyemail']=$rs->fields['noreplyemail'];
				$_SESSION[SESSNAME]['notifyemail']=$rs->fields['notifyemail'];
				
				$_SESSION[SESSNAME]['business_email']='';
				$_SESSION[SESSNAME]['town']='';
				$_SESSION[SESSNAME]['phone_number']='';
				$_SESSION[SESSNAME]['pm_status']='';
				$_SESSION[SESSNAME]['pm_id']=0;
				$_SESSION[SESSNAME]['pm_moduleid']=1;
				$_SESSION[SESSNAME]['pm_modules_list']=$modules_groups;
				//var_dump($modules_groups); exit;
				header("Location: admin.php");
				exit;
			}else{
				$msg=base64_encode("Critical MySQL error while loading modules for your account. Please contact administrator.");
				
				header("Location: index.php?msg=$msg");
				exit;
			}
		}else{
			$sql_pm = "SELECT 
						".$tblprefix."property_manager.id, 
						".$tblprefix."property_manager.first_name, 
						".$tblprefix."property_manager.last_name,
						".$tblprefix."property_manager.email_address as email,
						".$tblprefix."property_manager.business_email,
						".$tblprefix."property_manager.town,
						".$tblprefix."property_manager.phone_number,
						".$tblprefix."property_manager.pm_status 
						
						FROM ".$tblprefix."property_manager 
						WHERE 
						
						email_address='".mysql_escape_string($_POST['username'])."' 
						and 
						password = '".password(mysql_escape_string($_POST['password']))."' 
						";
			$rs_pm = $db->Execute($sql_pm);
			$isrs_pm = $rs_pm->RecordCount();
			if($isrs_pm > 0){
				$sql_pm_modules = "SELECT 
							".$tblprefix."modules.id, 
							".$tblprefix."modules.module_name, 
							".$tblprefix."modules.module_type, 
							".$tblprefix."modules.module_act,
							".$tblprefix."modules.module_group
							FROM ".$tblprefix."modules 
							WHERE 
							 ".$tblprefix."modules.module_type=2
                                                         AND
                                                         ".$tblprefix."module.status=1
							 ORDER BY ".$tblprefix."modules.module_order ASC
							";
				$rs_pm_modules = $db->Execute($sql_pm_modules);
				$isrs_pm_modules = $rs_pm_modules->RecordCount();
				if($isrs_pm_modules > 0){

					$modules_groups = array();
					
					while(!$rs_pm_modules->EOF) {
						$modules_groups[$rs_pm_modules->fields['module_group']][] = $rs_pm_modules->fields;
						$rs_pm_modules->MoveNext();
					}
					
					$_SESSION[SESSNAME]['islogin']='yes';
					$_SESSION[SESSNAME]['islogin']=true;
					$_SESSION[SESSNAME]['name']=$rs_pm->fields['first_name'] . ' ' . $rs_pm->fields['last_name'];
					$_SESSION[SESSNAME]['email']=$rs_pm->fields['email'];
					$_SESSION[SESSNAME]['noreplyemail']='';
					$_SESSION[SESSNAME]['notifyemail']='';
					
					$_SESSION[SESSNAME]['business_email']=$rs_pm->fields['business_email'];
					$_SESSION[SESSNAME]['town']=$rs_pm->fields['town'];
					$_SESSION[SESSNAME]['phone_number']=$rs_pm->fields['phone_number'];
					$_SESSION[SESSNAME]['pm_status']=$rs_pm->fields['pm_status'];
					$_SESSION[SESSNAME]['pm_id']=$rs_pm->fields['id'];
					$_SESSION[SESSNAME]['pm_moduleid']=2;
					$_SESSION[SESSNAME]['pm_modules_list']=$modules_groups;
					header("Location: admin.php");
					exit;
				}else{
					$msg=base64_encode("Critical MySQL error while loading modules for your account. Please contact administrator.");
					
					header("Location: index.php?msg=$msg");
					exit;
				}

			}else{
				$msg=base64_encode("Invalid username or password");				
				
				header("Location: index.php?msg=$msg");
				exit;
			}
		}
/*	}else{
		$msg=base64_encode("Security code did not match");	
		header("Location: index.php?msg=$msg");
		exit;
	} */
}

?>

<?php include("include/header_logo.php");?>
<body>
    


<div class="row"><!-- content -->
<div class="col-md-12">

    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h1>Login</h1>
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel-heading">
                    <div class="text-muted bootstrap-admin-box-title"></div>
                </div>
                <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                    <form name="form1" class="form-horizontal" method="post" action="" onSubmit="return validate_login();">
                    <fieldset>
                            <legend>Please Log In</legend>
                            <div id="success-msg">
                                <?php
	if(isset($_GET['msg'])){
		echo base64_decode($_GET['msg']);
	}else{
	?>
	  Welcome to  <?php echo ADMIN_TITLE;?>
	<?php
	}
	?>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="focusedInput">User Name:</label>
                                <div class="col-lg-9">
                                    <input name="username" type="text" class="fields" id="username" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="focusedInput">Password</label>
                                <div class="col-lg-9">
                                    <input name="password" type="password" class="fields" id="password" tabindex="2" value="">
                                </div>
                            </div>
                         <!--   <div class="form-group">
                                <label class="col-lg-3 control-label" for="focusedInput">Security Code:</label>
                                <div class="col-lg-9">
                                    <img src="<?php echo MYSURL?>classes/captchacode/CaptchaSecurityImages.php?width=150&height=30&character=8" style="border: 1px dotted #808080" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="focusedInput">Verify Code:</label>
                                <div class="col-lg-9">
                                    <input name="verifycode" type="text" class="smallfields" id="verifycode" tabindex="2" value="">
                                    
                                </div>
                            </div>-->
							<input name="mode" type="hidden" id="mode" value="login">
                            <button type="submit" class="btn btn-primary">Login</button>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
                </div>
    
    
</div>
</div>
<!-- footer -->
<div class="navbar navbar-footer">
    <div class="container">
        <div class="row col-lg-12">
            <footer role="contentinfo">
                <p class="left">Job Mug</p>
                <p class="right">© 2014 <a href="http://www.meritoo.pl" target="_blank">Job Mug</a></p>
            </footer>
        </div>
    </div>
</div>
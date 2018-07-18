<!DOCTYPE html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Job Mug</title>

<script>
	window.GD = window.GD || {};
	GD.pageInfo = window.GD || {};
</script>
<script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2-ui.min.js";?>"></script>

<script type="text/javascript" src="<?php echo base_url() . 'resources/js/jquery.autocomplete.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resources/js/pretty.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resources/js/pop_upjs.js'; ?>"></script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="generator" content="Jadii.com - 1.0.013" />
<?php $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
if($segments[4] == 'job_details'){?>
<link href="<?php echo base_url() . "resources/css/detail.css"?>" rel="stylesheet" type="text/css"/>
<?php }else{ ?>
<link href="<?php echo base_url() . "resources/css/search.css"?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() . "resources/css/popup_style1.css"?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() . "resources/css/popup_style.css"?>" rel="stylesheet" type="text/css"/>
<?php } ?>
</head>
<body>
    
    
    
<div class="main_jadii">
    
    <div class="nav_menu" id="PageTop">
        <a href="<?php echo base_url();?>" title="Home">Home</a>
                <a href="<?php echo $url.'jobs/job_listing';?>" title="Jobs"> Jobs </a>
                <a href="<?php echo $url.'welcome/candidates_listing';?>" title="Candidate"> Candidates </a>
                <a href="<?php echo $url.'welcome/consultants_listing';?>" title="Consultants"> Consultants </a>
                <a href="#" title="Employers" id="employer_nav"> Employers </a>
                <ul class="emp_drp">
                    <li><a target='_top' rel='nofollow' class='join hideTab' title="signup">GET FREE EMPLOYER ACCOUNT</a></li>
                    <li><a target='_top' rel='nofollow' class='signin' title="login">SIGN IN TO EMPLOYER SECTION</a></li>
                    <li>
                        <?php if(!isset($this->session->userdata['user_data']['usr_id'])){?>
                        <a href="<?php echo base_url();?>welcome/blog">
                        <?php }elseif (isset($this->session->userdata['user_data']['usr_id']) && $this->session->userdata['user_data']['usr_id'] == 4) {?>
                            <a href="<?php echo base_url();?>jobs/index">
                        <?php }?>
                            POST A JOB</a></li>
                </ul>
		<?php if(!isset($this->session->userdata['user_data']['u_type'])){?>
		<a target='_top' rel='nofollow' class='join hideTab margn' title="signup"> Sign Up </a>or
                <a target='_top' rel='nofollow' class='signin last_nav' title="login"> Login </a>
                <?php } else{?>
                <a class="last_nav" href="<?php echo $url;?>welcome/logout" title="logout"> Logout </a>
                <?php }?>
    </div>
    
     <script type='text/x-deferred-js' data-desc='home.jsp'>
	/* <![CDATA[ */
	GD.home.initNonMember(GD.fb.requestedPerms);
	/* ]]> */
        
        $("#employer_nav").click(function(){
            $(".emp_drp").toggle();
        });
	</script>
    
<div id="Shape1">
</div>
<div id="Rectangle4copy9">
<img src="<?php echo base_url();?>resources/images/images2/Rectangle4copy9.png" width="1368" height="50" /></div>
    <a href="<?php echo base_url();?>">
<div id="MUG">
    <img src="<?php echo base_url();?>resources/images/logo.png" height="47" /></div></a>

<div id="Rectangle16">
<img src="<?php echo base_url();?>resources/images/images2/Rectangle16.png" width="1368" height="101" /></div>


<?php //echo form_open('welcome/job_search');?>
<div class="top_search_box">
    <?php echo form_open('welcome/job_search');?>
                        <div id="top_search_box">
                            <input type="text" placeholder="Job Title, Keywords" name="search_box" class="inner_searchbox" id="autocomplete">
                            </div>
                        <div id=""> <input type="text" placeholder="Any Location" name="location" id="location" class="search_drop2"/></div>
			
                        <button type="submit" id="RoundedRectangle6cop_0" name="search"> </button>                        
                        <?php echo form_close();?>
    
                              </div>
<div id="header_drp_down4">
    <?php if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 4){ ?>
    <a href="<?php echo $url.'jobs';?>"><img src="<?php echo base_url();?>resources/images/images2/post_newjob.png"/></a>
    <?php } ?>
</div>

<?php //echo form_close();?>
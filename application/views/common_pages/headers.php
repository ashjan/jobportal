<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Jobmug</title>
                <script>
	window.GD = window.GD || {};
	GD.pageInfo = window.GD || {};
</script>

	<script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2-ui.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/js/jquery.autocomplete.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/js/pop_upjs.js'; ?>"></script>
                
	<link href="<?php echo base_url() . "resources/css/styles.css"?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() . "resources/css/popup_style1.css"?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() . "resources/css/popup_style.css"?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resources/css/slick.css';?>"/>
    
    </head>
    <body>
        
        <div class="top_head_cntnr">
            <div class="top_inner">
                <a href="<?php echo base_url();?>"> <div id="MUG"><img src="<?php echo base_url();?>resources/images/logo.png"></div></a>
    
                        <div class="nav_menu" id="PageTop">
        <a href="<?php echo base_url();?>" title="Home">Home</a>
                <a href="<?php echo $url.'jobs/job_listing';?>" title="Jobs"> Jobs </a>
                <a href="<?php echo $url.'welcome/candidates_listing';?>" title="Candidate"> Candidates </a>
                <a href="<?php echo $url.'welcome/candidates_listing';?>" title="Consultants"> Consultants </a>
                <a href="<?php echo $url.'welcome/packages';?>" title="Show Packages"> Packages </a>
                
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
                <a href="#" title="Employers"> Employers </a>
                <a class="last_nav" href="<?php echo $url;?>welcome/logout" title="logout"> Logout </a>
                <?php }?>
    </div>
            </div>
                        </div>
        <script type='text/x-deferred-js' data-desc='home.jsp'>
	GD.home.initNonMember(GD.fb.requestedPerms);
        $("#employer_nav").click(function(e){
            $(".emp_drp").toggle();
        });
        
	</script>
        
        
        
        
        <div id="background">
            <div id="slider_outer"><img width="1212px" src="<?php echo base_url();?>resources/images/job_mug_bg.png">
                        
        </div>
    
    
    
    
            <div class="srch_up_text"> Your Career Partner. </div>
    <div class="search_container">
                        <?php echo form_open('welcome/job_search/homepage');?>
                        <div id="RoundedRectangle6">
                            <input type="text" placeholder="Job Title, Keywords" name="search_box" class="inner_searchbox" id="autocomplete">
                            </div>
                        <div id="RoundedRectangle6cop"> <input type="text" placeholder="Any Location" name="location" id="location" class="search_drop2"/></div>
			
                        <button type="submit" id="RoundedRectangle6cop_0" name="search"> </button>
                        <?php echo form_close();?>

    </div>
            <div class="srch_low_text"> Search jobs from over 20,000 Companies. </div>
            
            <?php include("fb_login_script.php");?>
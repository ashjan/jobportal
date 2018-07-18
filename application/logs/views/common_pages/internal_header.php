<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Job Mug</title>

<script>
	window.GD = window.GD || {};
	GD.pageInfo = window.GD || {};
</script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="generator" content="Jadii.com - 1.0.013" />

<link href="styles.css" rel="stylesheet" type="text/css">
<!-- <script type="text/javascript" src='<?php echo base_url() . "resources/js/jquery-1.10.0.min.js" ?>'></script>-->
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2-ui.min.js";?>"></script>
    
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/zebra_datepicker.js" ?>"></script>
    
    <script type="text/javascript" src="<?php echo base_url() . 'resources/tinymce/tinymce.min.js'; ?>"></script>
    
<!--    <script type="text/javascript" src="<?php echo base_url() . 'resources/scheduler/jquery-1.9.1.min.js'; ?>"></script>-->
    <script type="text/javascript" src="<?php echo base_url() . 'resources/scheduler/daypilot-all.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/rating/jquery.rating.js'; ?>"></script>
<!--   <script type="text/javascript" src="<?php echo base_url() . 'resources/js/jquery.autocomplete.min.js'; ?>"></script>-->
    
     <script type="text/javascript" src="<?php echo base_url() . 'resources/js/jquery.autocomplete.js'; ?>"></script>
     <script type="text/javascript" src="<?php echo base_url() . 'resources/js/pretty.js'; ?>"></script>
     <script type="text/javascript" src="<?php echo base_url() . 'resources/js/pop_upjs.js'; ?>"></script>
     
     
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    browser_spellcheck : true,
    auto_focus: "elm1",
    width: 600
 });
</script>


    
    
    <link rel="stylesheet" href="<?php echo base_url() . 'resources/css/internal.css';?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/css/default.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'resources/scheduler/media/layout.css';?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_g.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_green.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_traditional.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_transparent.css'; ?>">
        
       
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_white.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/rating/rating.css'; ?>">
        <link href="<?php echo base_url() . "resources/css/popup_style1.css"?>" rel="stylesheet" type="text/css"/>
                <link href="<?php echo base_url() . "resources/css/popup_style.css"?>" rel="stylesheet" type="text/css"/>
                
    <?php   date_default_timezone_set('America/New_York'); ?>
    
    
</head>
<body>
    <div class="header_top">
        <div class="top_inner">
           <a href="<?php echo base_url();?>">  <div class="top_logo"> <img src="<?php echo base_url();?>resources/images/logo.png" height="49" /> </div> </a>
            
            <div class="nav_menu" id="PageTop">
        <a href="<?php echo base_url();?>" title="Home">Home</a>
                <a href="<?php echo $url.'/jobs/job_listing';?>" title="Jobs"> Jobs </a>
                <a href="<?php echo $url.'/welcome/candidates_listing';?>" title="Candidate"> Candidates </a>
                <a href="<?php echo $url.'/welcome/consultants_listing';?>" title="Consultants"> Consultants </a>
                <a href="#" title="Employers" id="employer_nav"> Employers </a>
                <ul class="emp_drp">
                    <?php if(!isset($this->session->userdata['user_data']['usr_id'])){?>
                    <li><a target='_top' rel='nofollow' class='join hideTab' title="signup">GET FREE EMPLOYER ACCOUNT</a></li>
                    <li><a target='_top' rel='nofollow' class='signin' title="login">SIGN IN TO EMPLOYER SECTION</a></li>
                    <?php } ?>
                    <li>
                        <?php if(!isset($this->session->userdata['user_data']['usr_id'])){?>
                        <a href="<?php echo base_url();?>index.php/welcome/blog">
                        <?php }elseif (isset($this->session->userdata['user_data']['usr_id']) && $this->session->userdata['user_data']['u_type'] == 4) {?>
                            <a href="<?php echo base_url();?>index.php/jobs/index">
                        <?php }?>
                            POST A JOB</a></li>
                </ul>
		<?php if(!isset($this->session->userdata['user_data']['u_type'])){?>
		<a target='_top' rel='nofollow' class='join hideTab margn' title="signup"> Sign Up </a>or
                <a target='_top' rel='nofollow' class='signin last_nav' title="login"> Login </a>
                <?php } else{?>
                <a class="last_nav" href="<?php echo $url;?>/welcome/logout" title="logout"> Logout </a>
                <?php }?>
            </div>
        </div>
        </div>
    
    <script type='text/x-deferred-js' data-desc='home.jsp'>
	/* <![CDATA[ */
	GD.home.initNonMember(GD.fb.requestedPerms);
	/* ]]> */
        
        
        
        $("#employer_nav").click(function(e){
            $(".emp_drp").toggle();
        });
        
	</script>
    
<div class="main_jadii">
    <!-- facebook login script to start from here -->
    
    
    
    
    <!-- facebook login script -->
    
    <div class="header">
        
        
        
        <div class="header_lower">
            
<!--            <div class="top_search_box">
    <form><input type="text" placeholder="Search Jobs" name="search_box" class="inner_searchbox" id="autocomplete"></form>
                              </div>

                            <div class="notifications_box">
                                 <img src="<?php echo base_url();?>resources/images/images/notification_1.png"/>
                                <img src="<?php echo base_url();?>resources/images/images/notification_2.png"/>
                                <img src="<?php echo base_url();?>resources/images/images/notification_3.png"/>
                            </div>-->
<div class="search_container">
                        <?php echo form_open('welcome/job_search');?>
                        <div id="top_search_box">
                            <input type="text" placeholder="Job Title, Keywords" name="search_box" class="inner_searchbox" id="autocomplete">
                            </div>
                        <div id=""> <input type="text" placeholder="Any Location" name="location" id="location" class="search_drop2"/></div>
			
                        <button type="submit" id="RoundedRectangle6cop_0" name="search"> </button>
<!--                            <div id="RoundedRectangle6cop_0"><img src="<?php echo base_url();?>resources/images/images/RoundedRectangle6cop_0.png"></div>
                        <div id="Layer22"><img src="<?php echo base_url();?>resources/images/images/Layer22.png"></div>
                        <div id="Search"><img src="<?php echo base_url();?>resources/images/images/Search.png"></div></button>-->
                        
                        <?php echo form_close();?>

    </div>

    <div id="header_drp_down4">
        <?php if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 4){ ?>
        <a href="<?php echo $url.'/jobs';?>"><img src="<?php echo base_url();?>resources/images/images/post_job.png"/></a>
        <?php }?>
    </div>
            
        </div>
        
        
    </div>
    

<!--<div id="Rectangle4copy9">
<img src="<?php echo base_url();?>resources/images/images2/Rectangle4copy9.png" width="1368" height="129" /></div>
<a href="<?php echo base_url();?>">
<div id="MUG">
    </div></a>

<div id="Rectangle16">
<img src="<?php echo base_url();?>resources/images/images2/Rectangle16.png" width="1368" height="101" /></div>-->


<?php //echo form_open('welcome/job_search');?>
<!--<div id="header_top_drop1">
 <select required="" name="category" id="category" class="search_drop">
                                <option value="">All Jobs</option>
                                <?php //foreach($categories as $cat){ ?>
                                <option value="<?php //echo $cat['id'];?>"><?php //echo $cat['property_category_name'];?></option>
                                <?php //} ?>
                            </select>
</div>
<div id="header_top_drop2">
    <input type="text" placeholder="Any Location" required="" name="location" id="location" class="search_drop2"/>
</div>


    <button type="submit" id="header_top_drop3" name="search"></button>-->
  

<?php //echo form_close();?>

    
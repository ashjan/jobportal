<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Jobmug</title>
                <script>
	window.GD = window.GD || {};
	GD.pageInfo = window.GD || {};
</script>
<!--                <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.0.min.js";?>"></script>-->
<!--                <script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js'></script>-->

<script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2-ui.min.js";?>"></script>
<!--                <script type="text/javascript" src="<?php echo base_url() . "resources/js/jssor.core.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jssor.utils.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jssor.slider.js";?>"></script>-->
                <script type="text/javascript" src="<?php echo base_url() . 'resources/js/jquery.autocomplete.js'; ?>"></script>
                <script type="text/javascript" src="<?php echo base_url() . 'resources/js/pop_upjs.js'; ?>"></script>
                
		<link href="<?php echo base_url() . "resources/css/styles.css"?>" rel="stylesheet" type="text/css"/>
                
                <link href="<?php echo base_url() . "resources/css/popup_style1.css"?>" rel="stylesheet" type="text/css"/>
                <link href="<?php echo base_url() . "resources/css/popup_style.css"?>" rel="stylesheet" type="text/css"/>
               
                
                <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resources/css/slick.css';?>"/>
                
                
                
<!--                <script>
        jQuery(document).ready(function ($) {
            //Reference http://www.jssor.com/development/slider-with-slideshow-jquery.html
            //Reference http://www.jssor.com/development/tool-slideshow-transition-viewer.html

            var _SlideshowTransitions = [
            //Fade
            { $Duration: 1200, $Opacity: 2 }
            ];

            var options = {
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

        });
    </script>-->
                
               
	</head>
    <body>
        
        <div class="top_head_cntnr">
            <div class="top_inner">
                <a href="<?php echo base_url();?>"> <div id="MUG"><img src="<?php echo base_url();?>resources/images/logo.png"></div></a>
    
                        <div class="nav_menu" id="PageTop">
        <a href="<?php echo base_url();?>" title="Home">Home</a>
                <a href="<?php echo $url.'/jobs/job_listing';?>" title="Jobs"> Jobs </a>
                <a href="<?php echo $url.'/welcome/candidates_listing';?>" title="Candidate"> Candidates </a>
                <a href="<?php echo $url.'/welcome/candidates_listing';?>" title="Consultants"> Consultants </a>
                <a href="#" title="Employers" id="employer_nav"> Employers </a>
                <ul class="emp_drp">
                    <li><a target='_top' rel='nofollow' class='join hideTab' title="signup">GET FREE EMPLOYER ACCOUNT</a></li>
                    <li><a target='_top' rel='nofollow' class='signin' title="login">SIGN IN TO EMPLOYER SECTION</a></li>
                    <li>
                        <?php if(!isset($this->session->userdata['user_data']['usr_id'])){?>
                        <a href="<?php echo base_url();?>index.php/welcome/blog">
                        <?php }elseif (isset($this->session->userdata['user_data']['usr_id']) && $this->session->userdata['user_data']['usr_id'] == 4) {?>
                            <a href="<?php echo base_url();?>index.php/jobs/index">
                        <?php }?>
                            POST A JOB</a></li>
                </ul>
		<?php if(!isset($this->session->userdata['user_data']['u_type'])){?>
		<a target='_top' rel='nofollow' class='join hideTab margn' title="signup"> Sign Up </a>or
                <a target='_top' rel='nofollow' class='signin last_nav' title="login"> Login </a>
                <?php } else{?>
                <a href="#" title="Employers"> Employers </a>
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
        
        
        
        
        <div id="background">
<!--    <div id="Shape1"><img src="<?php echo base_url();?>resources/images/images/Shape1.png"></div>-->
			
                        
            <div id="slider_outer"><img width="1212px" src="<?php echo base_url();?>resources/images/job_mug_bg.png">
                        
                            <!-- slider starts here -->
                            
<!--                            <div id="slider1_container" style="position: relative; width: 1368px;
        height: 397px;">

         Loading Screen 
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

         Slides Container 
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1368px; height: 397px;
            overflow: hidden;">
            <div>
                <img u=image src="<?php echo base_url();?>resources/images/images/landscape/Background.png" />
            </div>
            <div>
                <img u=image src="<?php echo base_url();?>resources/images/images/landscape/02.jpg" />
            </div>
            <div>
                <img u=image src="<?php echo base_url();?>resources/images/images/landscape/03.jpg" />
            </div>
            <div>
                <img u=image src="<?php echo base_url();?>resources/images/images/landscape/04.jpg" />
            </div>
        </div>
        <a style="display: none" href="http://www.jssor.com">javascript</a>
    </div>-->
                            
                            <!-- slider starts here -->
                            
                            
                        </div>
    
    
    
    
            <div class="srch_up_text"> Your Career Partner. </div>
    <div class="search_container">
                        <?php echo form_open('welcome/job_search');?>
                        <div id="RoundedRectangle6">
                            <input type="text" placeholder="Job Title, Keywords" name="search_box" class="inner_searchbox" id="autocomplete">
                            </div>
                        <div id="RoundedRectangle6cop"> <input type="text" placeholder="Any Location" name="location" id="location" class="search_drop2"/></div>
			
                        <button type="submit" id="RoundedRectangle6cop_0" name="search"> </button>
<!--                            <div id="RoundedRectangle6cop_0"><img src="<?php echo base_url();?>resources/images/images/RoundedRectangle6cop_0.png"></div>
                        <div id="Layer22"><img src="<?php echo base_url();?>resources/images/images/Layer22.png"></div>
                        <div id="Search"><img src="<?php echo base_url();?>resources/images/images/Search.png"></div></button>-->
                        
                        <?php echo form_close();?>

    </div>
            <div class="srch_low_text"> Search jobs from over 20,000 Companies. </div>
            
            <?php include("fb_login_script.php");?>

<!DOCTYPE html>

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
<link href="<?php echo base_url() . 'resources/css/package.css';?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2.min.js";?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery-1.10.2-ui.min.js";?>"></script>
    
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/zebra_datepicker.js" ?>"></script>
    
    <script type="text/javascript" src="<?php echo base_url() . 'resources/tinymce/tinymce.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/scheduler/daypilot-all.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/rating/jquery.rating.js'; ?>"></script>
     <script type="text/javascript" src="<?php echo base_url() . 'resources/js/jquery.autocomplete.js'; ?>"></script>
     <script type="text/javascript" src="<?php echo base_url() . 'resources/js/pretty.js'; ?>"></script>
     <script type="text/javascript" src="<?php echo base_url() . 'resources/js/pop_upjs.js'; ?>"></script>
     <script type="text/javascript" src="<?php echo base_url() . 'resources/fancybox/lib/jquery.mousewheel-3.0.6.pack.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/fancybox/source/jquery.fancybox.js?v=2.1.5';?>"></script>
    <link href="<?php echo base_url() . 'resources/fancybox/source/jquery.fancybox.css?v=2.1.5';?>" rel="stylesheet" type="text/css" />
<?php if($this->uri->segment(2)!='candidates_listing' && $this->uri->segment(2)!='emp_application_details' && $this->uri->segment(2)!='job_listing' && $this->uri->segment(2)!='job_search'){ ?>     
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    browser_spellcheck : true,
    auto_focus: "elm1",
    width: 600,
 });
</script>
<?php } ?>

    
    
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
            <?php if(!isset($this->session->userdata['user_data']['u_type']) || $this->session->userdata['user_data']['u_type'] == 3){?>
                <a href="<?php echo $url.'jobs/job_listing';?>" title="Jobs"> Jobs </a>
            <?php } else{ ?> 
                <a href="<?php echo $url.'jobs/emp_job_listing';?>" title="Jobs"> My Jobs </a>
                <?php }?>
                <a href="<?php echo $url.'welcome/candidates_listing';?>" title="Candidate"> Candidates </a>
                <a href="<?php echo $url.'welcome/consultants_listing';?>" title="Consultants"> Consultants </a>
                <a href="<?php echo $url.'welcome/packages';?>" title="Show Packages"> Packages </a>
                <a href="#" title="Employers" id="employer_nav"> Employers </a>
                
				
				<?php ######## GET LATEST NOTIFICATION ###########
				if(isset($this->session->userdata['user_data']['usr_id']) and $this->session->userdata['user_data']['usr_id'] != ''){
				$uid = $this->session->userdata['user_data']['usr_id'];
				$latest_notification		=	$this->m_common->getlatestnotification($uid);
				 ?>
                <a href="<?php echo base_url(''); ?>jobs/shownotification" title="Employers" id="employer_nav"> Notification <?php if($latest_notification->total > 0) {?><span class="nav-counter"><?php echo $latest_notification->total ;  ?></span> <?php } ?> </a>
                <?php }  ?>
                <ul class="emp_drp">
                    <?php if(!isset($this->session->userdata['user_data']['usr_id'])){?>
                    <li><a target='_top' rel='nofollow' class='join hideTab' title="signup">GET FREE EMPLOYER ACCOUNT</a></li>
                    <li><a target='_top' rel='nofollow' class='signin' title="login">SIGN IN TO EMPLOYER SECTION</a></li>
                    <?php } ?>
                    <li>
                        <?php if(!isset($this->session->userdata['user_data']['usr_id'])){?>
                        <a href="<?php echo base_url();?>welcome/blog">
                        <?php }elseif (isset($this->session->userdata['user_data']['usr_id']) && $this->session->userdata['user_data']['u_type'] == 4) {?>
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
    <div class="header">
        
        
        
        <div class="header_lower">
<div class="search_container">
                        <?php echo form_open('welcome/job_search');?>
                        <div id="top_search_box">
                            <input type="text" placeholder="Job Title, Keywords" name="search_box" class="inner_searchbox" id="autocomplete" value="<?php if(isset($this->session->userdata['search_dt']['ttl'])){ echo $this->session->userdata['search_dt']['ttl'];} else echo ""; ?>" >
                            </div>
                        <div id=""> <input type="text" placeholder="Any Location" name="location" id="location" class="search_drop2" value="<?php if(isset($this->session->userdata['search_dt']['srch'])){ echo $this->session->userdata['search_dt']['srch'];} else echo ""; ?>"/></div>
			
                        <button type="submit" id="RoundedRectangle6cop_0" name="search"> </button>
                        <?php echo form_close();?>

    </div>

    <div id="header_drp_down4">
        <?php if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 4){ ?>
        <a href="<?php echo $url.'jobs';?>"><img src="<?php echo base_url();?>resources/images/images/post_job.png"/></a>
        <?php }?>
    </div>
            
        </div>
        
        
    </div>
    

<script>
$(document).ready(function(){
    $('.fancybox').fancybox({
                                'width' : 650,
				'autoScale': false,
				'transitionIn': 'elastic',
				'transitionOut': 'elastic'
                            });
});
    </script>
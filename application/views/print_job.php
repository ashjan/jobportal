
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
<?php if($this->uri->segment(2)!='candidates_listing' && $this->uri->segment(2)!='emp_application_details'){ ?>     
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
    <script type='text/x-deferred-js' data-desc='home.jsp'>
	/* <![CDATA[ */
	GD.home.initNonMember(GD.fb.requestedPerms);
	/* ]]> */
        
        
        
        $("#employer_nav").click(function(e){
            $(".emp_drp").toggle();
        });
        
	</script> 

<?php //echo form_close();?>
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

<div class="right_panel_descrip">
            <div id="comp_logo_sml"> <?php if($job_dt[0]['logo'] != ""){
                            echo '<img src="'.base_url().'uploads/profile_images/'.$job_dt[0]['logo'].'"/>';
                        }elseif($job_dt[0]['profile_pic'] != ""){?>
                        <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job_dt[0]['profile_pic'];?>"/>
                        <?php }else{?>
                        <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                        <?php }?> 
                        </div>
                        <div class="ttl_compjob more_wid">
                        <div class="main_title"><?php echo $job_dt[0]['job_title'];?></div>
			<div class="company"> <?php if($job_dt[0]['company_name'] == ""){ 
            echo $job_dt[0]['first_name'].' '.$job_dt[0]['last_name'];
            }else{
                echo $job_dt[0]['company_name'];
            }
            ?> </div>
                        </div>
                        
                        
			
                        
			<div id="Shape5"><img src="<?php echo base_url();?>resources/images/images3/Shape5.png"></div>
			<div id="Layer41"><img src="<?php echo base_url();?>resources/images/images3/Layer41.png"></div>
			<div class="favourites">Add to Favourites</div>
                        <div id="Layer40"> <a href="<?php echo base_url('');?>welcome/load_map/<?php echo $job_dt[0]['job_id']; ?>" title="Show Map" ><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"> </a></div>
			<div class="locationn"><?php echo $job_dt[0]['city_name']?></div>
			
                        
			<div id="Shape5copy"><img src="<?php echo base_url();?>resources/images/images3/Shape5copy.png"></div>
			<div class="job_description">
			<h2>Description</h2>
			<?php echo content($job_dt[0]['job_description']); ?>
			</div>
                        
                        <div class="clearfix"></div>
                        
                        
                        
                </div>
                    
			
<?php

	function content($text, $allowed_tags = '<p><b><i><sup><sub><em><strong><ul><br><li><div><span>')
    {
        mb_regex_encoding('UTF-8');
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
              $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    } 
	
 ?>
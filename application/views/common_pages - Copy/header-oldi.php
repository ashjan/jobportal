<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/libraries/REST_Controller.php';
//var_dump($this->session->all_userdata());
?>
<head>
    
    <script type="text/javascript" src='<?php echo base_url() . "resources/js/jquery-1.10.0.min.js" ?>'></script>
    
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/zebra_datepicker.js" ?>"></script>
    
    <script type="text/javascript" src="<?php echo base_url() . 'resources/tinymce/tinymce.min.js'; ?>"></script>
    
<!--    <script type="text/javascript" src="<?php echo base_url() . 'resources/scheduler/jquery-1.9.1.min.js'; ?>"></script>-->
    <script type="text/javascript" src="<?php echo base_url() . 'resources/scheduler/daypilot-all.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resources/rating/jquery.rating.js'; ?>"></script>
    
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    browser_spellcheck : true,
    auto_focus: "elm1",
    width: 600
    

 });
</script>


    
    
    <link rel="stylesheet" href="<?php echo base_url() . 'resources/css/style.css';?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/css/default.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'resources/scheduler/media/layout.css';?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_g.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_green.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_traditional.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_transparent.css'; ?>">
       
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/scheduler/media/calendar_white.css'; ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'resources/rating/rating.css'; ?>">
    <?php   date_default_timezone_set('America/New_York'); ?>
    
    
</head>
<body>
   
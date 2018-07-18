<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/divbraries/REST_Controller.php';
//var_dump($this->session->all_userdata());
include("common_pages/header.php");
?>

<div id="login_container">
	<a href="<?php echo base_url();?>"><h1>Welcome to Ovex Tech Job Portal!</h1></a>

	<div id="login_body">
            <h2>Job Search</h2>
            <?php echo form_open('jobs/job_search');?>
                
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
                
            <div >What would you want to search.?</br><input type="text" class="inpt_fld" name="search" id="search" required=""/>&nbsp;&nbsp;&nbsp;<select style="width: 160px;" name="category"><option value="">--Select Category--</option><?php foreach ($categories as $cnt) { ?><option value="<?php echo $cnt['id'];?>"><?php echo $cnt['property_category_name'];?></option><?php } ?></select></div>
                <div class="clearfix"></div>
                
                
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Search Job"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
	</div>

	<p class="footer">  <strong> Ovex Tech Job POrtal</strong> </p>
</div>

<?php include("common_pages/footer.php"); ?>  

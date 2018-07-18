
<?php
//$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
//echo "<pre>"; print_r($segments); exit;
include("common_pages/internal_header.php");?>

<!--<div id="container">
	<a href="<?php echo base_url();?>"><h1>Welcome to Ovex Tech Job Portal!</h1></a>
        <?php if(isset($this->session->userdata['user_data']['is_user_logged_in'])){ ?>
        <div class="upper_menu">
            <a href="<?php echo base_url().'index.php/profile/index'?>">Update Profile</a> |
        <a href="<?php echo base_url().'index.php/profile/change_password'?>">Change Password</a> |
        <a href="<?php echo base_url().'index.php/welcome/logout'?>">Logout</a>
        </div>-->
        
        <?php 
        }
//        if(isset($this->session->userdata['user_data']['u_type']))
//        {
//            if($this->session->userdata['user_data']['u_type'] == 3)
//            {
//                include("common_pages/left_pannel_usr.php");
//            }
//            else 
//            {
//                include("common_pages/left_pannel.php");
//            }
//        }
        ?>
        
<!--	<div id="body" style="display: inline-block;">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            <?php if(!empty($job_dt)){
            
?>
           <div class="jobstl">
               <h2 class=""><a href="#"><?php echo $job_dt[0]['job_title']; ?></a></h2>
               <div class="clearfix"></div>
               
               <span class="info"><strong>Posted By: </strong><?php echo $job_dt[0]['first_name']." ".$job_dt[0]['last_name']; ?></span>
               <div class="clearfix"></div>
               
               <span class="info"><strong>Job Posted: </strong><?php $date1=date_create($job_dt[0]['start_date']); echo date_format($date1,'g:ia \o\n l jS F Y'); ?></span>
               <div class="clearfix"></div>
               <span class="col-lg-4">Cisco</span>
               <span class="info"><strong>Due Date: </strong><?php $date=date_create($job_dt[0]['end_date']); echo date_format($date,'g:ia \o\n l jS F Y'); ?></span><div class="clearfix"></div>
               <span class="info"><strong>Job Location: </strong><?php  echo $job_dt[0]['city_name']; ?>,<?php echo $job_dt[0]['Region']; ?>,<?php echo $job_dt[0]['cnt_name']; ?></span>
               <div class="clearfix"></div><strong>Description: </strong><p><?php echo $job_dt[0]['job_description']?></p>
               <?php if(isset($utyp)){ 
               if($utyp == 3){
                   if(!isset($first_chk)){
               if($check > 0){
                   echo '<div class="err_msg"> You ave already applied for this job. </div>';
               }
               else{ ?>
               <a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'];?>" class="aply"><input type="button" value="Apply" /></a>
               <?php } 
                   }
               }
               else
               {
                   echo '<a href="'.base_url().'index.php/jobs/edit_job/'.$job_dt[0]['job_id'].'" class="updt"/><input type="button" name="Edit" value="Update Job Details"/></a></br></br>';
                   echo '<a href="'.base_url().'index.php/jobs/delete_job/'.$job_dt[0]['job_id'].'" class="updt"/><input type="button" name="delete" value="Delete Job"/></a>';
               }
               }?>
                       </div>
            
            <?php }?>
            
	</div>

	<p class="footer"></p>
</div>-->


<?php //include("common_pages/footer.php");?>

		<div id="background">
			
                    <div class="left_pannel">
                        <div class="big_title">Job Summary</div>
			<div id="Shape5copy6"><img src="<?php echo base_url();?>resources/images/images3/Shape5copy6.png"></div>
			<div class="sub_lable">Company</div>
			<div class="employer_name"><?php echo $job_dt[0]['first_name']." ".$job_dt[0]['last_name']; ?></div>
			<div class="sub_lable">Location</div>
			<div class="sub_label_name_atr"><?php echo $job_dt[0]['city_name']?></div>
			<div class="sub_lable"> Industry </div>
			<div class="sub_label_name_atr"><?php echo $job_dt[0]['property_category_name'];?></div>
			
                        <div class="sub_lable"> Job Type </div>
			<div class="sub_label_name_atr"><?php if($job_dt[0]['job_type'] == 2){echo 'Part time';} else{echo 'Full Time';}  ?></div>
			
                        
                        <div class="sub_lable"> Experience </div>
                        <div class="sub_label_name_atr"><?php 
                        if($job_dt[0]['experience'] == -2){echo 'Student';}
                        elseif($job_dt[0]['experience'] == -1){echo 'fresh Graduate';}
                        elseif($job_dt[0]['experience'] == 0) {echo 'Less Than 1 year';}
                        elseif($job_dt[0]['experience'] > 0 && $job_dt[0]['experience'] < 26){
                            echo $job_dt[0]['experience'].' Year'; if($job_dt[0]['experience']>1 && $job_dt[0]['experience']<26){echo 's';}
                        }
                        elseif($job_dt[0]['experience'] == 26){echo 'More Than 25 years';}?></div>
			
                                                
                        <div class="sub_lable"> Shift Timing </div>
                        <div class="sub_label_name_atr"> <?php if($job_dt[0]['shift_titming'] == 2){echo 'Evening Shift';}
                            elseif($job_dt[0]['shift_titming'] == 3) {echo 'Night Shift';}
                            elseif($job_dt[0]['shift_titming'] == 4){echo 'On Rotation';}
                            else {echo 'Morning Shift';}?> </div>
                        
			<div class="sub_lable"> Salary Range </div>
			<div class="sub_label_name_atr">$500000 -$600000</div>
                        
			<div class="sub_lable"> Career Level </div>
			<div class="sub_label_name_atr"> <?php
                        if($job_dt[0]['career'] == 1){echo 'Student (High School/College)';}
                        elseif($job_dt[0]['career'] == 2){echo 'Student (Undergraduate/Graduate)';}
                        elseif($job_dt[0]['career'] == 3){echo 'Entry Level';}
                        elseif($job_dt[0]['career'] == 5){echo 'Manager (Manager/Supervisor)';}
                        elseif($job_dt[0]['career'] == 6){echo 'Executive';}
                        elseif($job_dt[0]['career'] == 7){echo 'Senior Executive';}
                        else{echo 'Experienced (Non-Managerial)';} ?>
                        </div>
			
                        
                        <?php if(isset($utyp)){ 
                                            if($utyp == 3){
                        if(!isset($first_chk)){
               if($check > 0){
                   echo '<div id="RoundedRectangle7cop_0"> <button class="apply_btn" value="Already Applied">Already Applied</button> </div>';
                   //echo '<div id="APPLYNOW_0">Already Applied</div>';
               }
               else{ ?>
                        
                        <div id="RoundedRectangle7cop_0"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>
<!--                                <div id="APPLYNOW_0"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'];?>" class="aply"><img src="<?php echo base_url();?>resources/images/images3/APPLYNOW_0.png"></a></div>-->
                        <?php }}}}else{?>
                        <div id="RoundedRectangle7cop_0"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>
<!--                                <div id="APPLYNOW_0"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'];?>" class="aply"> <button class="apply_btn" value="Apply Now"></button> </a></div>-->
                                <?php } ?>
                        
                        <div id="left_sqr_ad"><img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq1.png';?>"/></div>
<!--                        <div id="ADcopy"><img src="<?php echo base_url();?>resources/images/images3/ADcopy.png"></div>-->
			<div id="left_sqr_ad"><img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq2.png';?>"/></div>
<!--			<div id="ADcopy2"><img src="<?php echo base_url();?>resources/images/images3/ADcopy2.png"></div>-->
                    </div>
			
		
                    <div class="right_panel_descrip">
                    
			
			<div id="comp_logo_sml"><img src="<?php echo base_url().'resources/classes/phpthumb/phpThumb.php?src=/jobportal/uploads/profile_images/'.$job_dt[0]['profile_pic'];?>&w=78&h=73&q=100"></div>
                        <div class="ttl_compjob more_wid">
                        <div class="main_title"><?php echo $job_dt[0]['job_title'];?></div>
			<div class="company"><?php echo $job_dt[0]['first_name']." ".$job_dt[0]['last_name']; ?></div>
                        </div>
                        
                        <div class="dat_aply_contnr">
                            <div class="post_date"><?php $date1=date_create($job_dt[0]['start_date']); echo date_format($date1,'jS F Y'); ?>  <script>// var intrvl = ''; intrvl = prettyDate('<?php echo str_replace(" ", 'T', $job_dt[0]['start_date']);?>'); document.write(intrvl); </script> </div>
			
                               <?php   if(isset($utyp)){ 
                                            if($utyp == 3){
                                if(!isset($first_chk)){
               if($check > 0){
                   echo '<div id="RoundedRectangle7cop"> <button class="apply_btn sml" value="Apply Now">Already Applied</button> </div>';
                   
               }
               else{ ?>
                                <div id="RoundedRectangle7cop"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn sml" value="Apply Now">Apply Now</button> </a></div>
			 <?php }}}} else{?>
                        <div id="RoundedRectangle7cop"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn sml" value="Apply Now">Apply Now</button> </a></div>
			<?php } ?>
                        </div>
			
                        
			<div id="Shape5"><img src="<?php echo base_url();?>resources/images/images3/Shape5.png"></div>
			<div id="Layer41"><img src="<?php echo base_url();?>resources/images/images3/Layer41.png"></div>
			<div class="favourites">Add to Favourites</div>
                        <div id="Layer40"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
			<div class="locationn"><?php echo $job_dt[0]['city_name']?></div>
			
                        <div id="RoundedRectangle7"><img src="<?php echo base_url();?>resources/images/images2/part_time2.png"></div>
			<div id="Shape5copy"><img src="<?php echo base_url();?>resources/images/images3/Shape5copy.png"></div>
			<div class="job_description">
			<h2>Description</h2>
			<?php echo $job_dt[0]['job_description'];
                        ?>
			</div>
                        
                        <div class="btns_contnr">
                        
                            <div id="back_cntnr"> <button class="back_btn" value="Back" onclick="javascript:history.go(-1);">Back</button> </div>
			
                        <?php if(isset($utyp)){ 
                                            if($utyp == 3){
                                if(!isset($first_chk)){
               if($check > 0){
                   echo '<div id="RoundedRectangle7cop_1"> <button class="apply_btn" value="Apply Now">Already Applied</button> </div>';
                   
               }
               else{ ?>
                                
                                <div id="RoundedRectangle7cop_1"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>
                                
                                <?php }}}
               else
               {
                   echo '<div id="RoundedRectangle7cop_1"><a href="'.base_url().'index.php/jobs/edit_job/'.$job_dt[0]['job_id'].'" class="updt"/><input class="btn_blue" type="button" name="Edit" value="Update Job Details"/></a></div>';
                   echo '<div class="del_cntnr"><a href="'.base_url().'index.php/jobs/delete_job/'.$job_dt[0]['job_id'].'" class="updt"/><input class="btn_red" type="button" name="delete" value="Delete Job"/></a></div>';
               }
               } else{?>
                        <div id="RoundedRectangle7cop_1"><a href="<?php echo $url;?>/jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>
                                
                                <?php } ?>
                        
                    </div>
                        
                </div>
                    <div class="right_long_ad">
                        <div id="Rectangle15copy"><img width="193px" height="932px" src="<?php echo base_url();?>resources/images/ad_vr1.png"></div>
                    </div>
			
			
		
		</div>
 

<?php include 'common_pages/internal_footer.php';?>
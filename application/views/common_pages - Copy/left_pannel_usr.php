

<div class="left_pannel">
    
    <div class="left_profile_pic">
        <?php if(isset($this->session->userdata['user_data']['dp']) && $this->session->userdata['user_data']['dp'] != "" && $this->session->userdata['user_data']['dp'] != 'no file'){?>
        <img width="200px" height="200px" src="<?php echo base_url();?>uploads/profile_images/<?php echo $this->session->userdata['user_data']['dp'];?>"/>
        <?php }else{?>
        <img width="200px" height="200px" src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
        <?php } ?>
    </div> 
                            
    <div class="left_username"><?php echo ucfirst($this->session->userdata['user_data']['f_name']).' '.  ucfirst($this->session->userdata['user_data']['l_name']);?></div>
    
    <ul class="swapper">
        <li> <a href="<?php echo base_url();?>resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> My Career Plan</a></li>
        <li> <a href="<?php echo base_url();?>profile/"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> Edit profile</a></li>
        <?php if(isset($resume)){?>
        <li>  <a href="<?php echo base_url();?>resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> Preview Resume</a></li>
        <li>  <a href="<?php echo base_url();?>resume/edit_resume/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> Edit Resume</a></li>
        <?php }else{?>
        <li>  <a href="<?php echo base_url().'resume';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> Resume Management </a></li>
        <?php } ?>
        <li>  <a href="<?php echo base_url().'jobs/job_listing';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> Jobs </a></li>
        <li>  <a href="<?php echo base_url().'jobs/most_viewed';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> Most Viewed Jobs </a></li>
        <li>  <a href="<?php echo base_url().'jobs/cand_applications';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> Applications</a></li>
        <li>  <a href="<?php echo base_url().'campaign';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_favourites_icon.PNG"/> Subscribe Campaign</a></li>
        <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> My Favorite Jobs</a> </li>
        <li>  <a href="<?php echo base_url().'testimonials/add_testimonial';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> Add Testimonial</a> </li>
    </ul>
</div>
<!--<input class="inner_searchbox" placeholder="Search"  type="text" name="search_box" onkeyup="javascript:auto_comp(this)" id="autocomplete"/>-->
<!--<div class="search_box">
    
    <form><input type="text" placeholder="Search Jobs" name="search_box" class="inner_searchbox" id="autocomplete"></form>
      

                        </div> -->

<!--                        <div class="notifications_box">
                             <img src="<?php echo base_url();?>resources/images/images/notification_1.png"/>
                            <img src="<?php echo base_url();?>resources/images/images/notification_2.png"/>
                            <img src="<?php echo base_url();?>resources/images/images/notification_3.png"/>
                        </div>
<div class="pad"></div>-->
                        
                        
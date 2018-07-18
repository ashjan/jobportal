

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
        <li><img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> <a href="<?php echo base_url();?>index.php/resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>">My Career Plan</a></li>
        <li><img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> <a href="<?php echo base_url();?>/index.php/profile/">Edit profile</a></li>
        <?php if(isset($resume)){?>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> <a href="<?php echo base_url();?>index.php/resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>">Preview Resume</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> <a href="<?php echo base_url();?>index.php/resume/edit_resume/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>">Edit Resume</a></li>
        <?php }else{?>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> <a href="<?php echo base_url().'index.php/resume';?>"> Resume Management </a></li>
        <?php } ?>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/job_listing';?>"> Jobs </a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/most_viewed';?>"> Most Viewed Jobs </a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/cand_applications';?>">Applications</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_favourites_icon.PNG"/> <a href="<?php echo base_url().'campaign';?>">Subscribe Campaign</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/my_favourite_jobs';?>">My Favourite Jobs</a> </li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <a href="<?php echo base_url().'index.php/testimonials/add_testimonial';?>">Add Testimonial</a> </li>
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
                        
                        
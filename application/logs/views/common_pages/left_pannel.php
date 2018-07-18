

<div class="left_pannel">
    
    <div class="left_profile_pic">
        <?php if(isset($this->session->userdata['user_data']['dp']) && $this->session->userdata['user_data']['dp'] != "" && $this->session->userdata['user_data']['dp'] != 'no file'){?>
        <img width="200px" height="200px" src="<?php echo base_url();?>uploads/profile_images/<?php echo $this->session->userdata['user_data']['dp'];?>"/>
        <?php }else{?>
        <img width="200px" height="200px" src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
        <?php } ?>
    </div> 
                            
    <div class="left_username"><?php echo ucfirst($this->session->userdata['user_data']['f_name']).' '.ucfirst($this->session->userdata['user_data']['l_name']);?></div>
    
    <ul class="swapper">
        <li><img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> <a href="<?php echo base_url();?>/index.php/profile/">Edit profile</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <a href="<?php echo base_url().'index.php/profile/comp_profile_editor';?>">Company Profile</a> </li>
        <?php if(!empty($owner)){?>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <a href="<?php echo base_url().'index.php/profile/manage_team';?>">Manage Team</a> </li>
        <?php } ?>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/index';?>">Post New Job</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/emp_job_listing';?>">Jobs Listing</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> <a href="<?php echo base_url().'/index.php/jobs/emp_applications';?>">Applications</a></li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <a href="<?php echo base_url().'index.php/resume/fav_cand_listing/';?>">Favorite Candidates</a> </li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> <a href="<?php echo base_url().'index.php/jobs/my_favourite_jobs';?>">My Favorite Jobs</a> </li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/calender.png"/> <a href="<?php echo base_url().'index.php/jobs/my_favourite_jobs';?>">Calender</a> </li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <a href="<?php echo base_url().'index.php/jobs/my_favourite_jobs';?>">Preferences</a> </li>
        <li> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/package_detail.png"/> <a href="<?php echo base_url().'index.php/jobs/my_favourite_jobs';?>">My package Details</a> </li>
        <form id="login-form" method="post" action="">
            <input type="hidden" value="home" name="page" id="page"/>
            <input type="hidden" value="aftab" name="login" id="lgn"/>
            
            <input type="hidden" value="aftab" name="password" id="pas"/>
            <input type="hidden" value="<?php print_r($this->session->userdata['logindetails']);?>" name="sesson" id="sesson"/>
            <li><button type="submit" name="process" id="proc" class="submit" value="Continue"><a href="<?php echo base_url().'campaign/admin';?>">Campaign Management</a></button></li>
        </form>
    </ul>
	</div>

<!--<div class="search_box">
    <input class="inner_searchbox" placeholder="Search"  type="text" name="search_box" onkeyup="javascript:auto_comp(this)" id="autocomplete"/>
    <form><input type="text" placeholder="Search Jobs" name="search_box" class="inner_searchbox" id="autocomplete"></form>
      

                        </div> 
                        <div class="notifications_box">
                             <img src="<?php echo base_url();?>resources/images/images/notification_1.png"/>
                            <img src="<?php echo base_url();?>resources/images/images/notification_2.png"/>
                            <img src="<?php echo base_url();?>resources/images/images/notification_3.png"/>
                        </div>
                        
                        <div class="pad"></div>-->

	
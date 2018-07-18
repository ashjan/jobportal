

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
        <li>  <a href="<?php echo base_url();?>profile/"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> Edit profile</a></li>
        <li>  <a href="<?php echo base_url().'profile/comp_profile_editor';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> Company Profile</a> </li>
        <?php if(!empty($owner)){?>
        <li>  <a href="<?php echo base_url().'profile/manage_team';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> Manage Team</a> </li>
        <?php } ?>
        <li>  <a href="<?php echo base_url().'jobs/index';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> Post New Job</a></li>
        <li>  <a href="<?php echo base_url().'jobs/emp_job_listing';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> Jobs Listing</a></li>
        <li>  <a href="<?php echo base_url().'jobs/emp_applications';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> Applications</a></li>
        <li>  <a href="<?php echo base_url().'resume/fav_cand_listing/';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> Favorite Candidates</a> </li>
        <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> My Favorite Jobs</a> </li>
<!--  <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/calender.png"/> Calender</a> </li>-->
        <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> Preferences</a> </li>
        <li>  <a href="<?php echo base_url().'jobs/subscribedpackage';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/package_detail.png"/> My package Details</a> </li>
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

	
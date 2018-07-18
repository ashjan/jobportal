
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
        <li> <a href="<?php echo base_url();?>profile/"> 
        <span class="left_pannel_img"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/profile_icon.PNG"/> </span><span class="left_pannel_txt"> Edit profile </span></a></li>
        
        <li>  <a href="<?php echo base_url().'profile/comp_profile_editor';?>"> <span class="left_pannel_img"><img class="left_icon"  src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> </span><span class="left_pannel_txt" style="margin-left: 6%;"> Company Profile </span></a> </li>
        <?php if(!empty($owner)){?>
        
        <li>  <a href="<?php echo base_url().'profile/manage_team';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <span class="left_pannel_txt" style="margin-left: 7%;"> Manage Team </span></a> </li>
        <?php } ?>
        <li>  <a href="<?php echo base_url().'jobs/index';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/resume_icon.PNG"/> <span class="left_pannel_txt" style="margin-left: 11%;">Post New Job </span></a></li>
        <li>  <a href="<?php echo base_url().'jobs/emp_job_listing';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/applied_job_icon.PNG"/> <span class="left_pannel_txt" style="margin-left: 13%;">Jobs Listing </span></a></li>
        <li>  <a href="<?php echo base_url().'jobs/emp_applications';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> <span class="left_pannel_txt" style="margin-left: 12%;"> Applications </span> </a></li>
        <li>  <a href="<?php echo base_url().'resume/fav_cand_listing/';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <span class="left_pannel_txt" style="margin-left: 8%;"> Favorite Candidates</span> </a> </li>
        <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/accepted_jobs_icon.PNG"/> <span class="left_pannel_txt" style="margin-left: 12%;"> My Favorite Jobs </span></a> </li>
<!--  <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/calender.png"/> Calender</a> </li>-->
        <li>  <a href="<?php echo base_url().'jobs/my_favourite_jobs';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/my_preferences.png"/> <span class="left_pannel_txt" style="margin-left: 7%;"> Preferences </span></a> </li>
        <li>  <a href="<?php echo base_url().'jobs/subscribedpackage';?>"> <img class="left_icon" src="<?php echo base_url();?>resources/images/images/package_detail.png"/><span class="left_pannel_txt" style="margin-left: 7%;"> My package Details </span></a> </li>
        <form id="login-form" method="post" action="">
            <input type="hidden" value="home" name="page" id="page"/>
            <input type="hidden" value="aftab" name="login" id="lgn"/>
            
            <input type="hidden" value="aftab" name="password" id="pas"/>
            <input type="hidden" value="<?php print_r($this->session->userdata['logindetails']);?>" name="sesson" id="sesson"/>
            <li><button type="submit" name="process" id="proc" class="submit" value="Continue"><a href="<?php echo base_url().'campaign/admin';?>">Campaign Management</a></button></li>
        </form>
    </ul>
	</div>


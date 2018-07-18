
<?php

include("common_pages/internal_header.php");?>




<?php //include("common_pages/footer.php");?>

		<div id="background">
			
                    <div class="left_pannel">
                        <div class="big_title">Job Summary</div>
			<div id="Shape5copy6"><img src="<?php echo base_url();?>resources/images/images3/Shape5copy6.png"></div>
			<div class="sub_lable">Company</div>
			<div class="employer_name">
                        <?php if($job_dt[0]['company_name'] == ""){ 
                                echo $job_dt[0]['first_name'].' '.$job_dt[0]['last_name'];
                                }else{
                                    echo $job_dt[0]['company_name'];
                                }
                                ?>
                        </div>
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
                        <div class="sub_label_name_atr"><?php if($job_dt[0]['salary']){echo $job_dt[0]['salary'].'-'; }
						if($job_dt[0]['salary_to'] > 0){ echo $job_dt[0]['salary_to'];} else { echo "Max:";}
						?></div>
                        
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
                        
                        <div id="RoundedRectangle7cop_0"><a href="<?php echo $url;?>jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>

                        <?php }}}}else{?>
                        <div id="RoundedRectangle7cop_0"><a href="<?php echo $url;?>jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>

                                <?php } ?>
                        
                        <div id="left_sqr_ad"><img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq1.png';?>"/></div>

			<div id="left_sqr_ad"><img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq2.png';?>"/></div>

                    </div>
			
		
                    <div class="right_panel_descrip">
                    
                        
                        <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
                        
			<div class="map">
                                <iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $job_dt[0]['city_name']; ?>&output=embed"></iframe>
                            </div>
			
                        
                        
                        
			
                        
			

                        
                        
                </div>
                    <div class="right_long_ad">
                        <div id="Rectangle15copy"><img width="193px" height="932px" src="<?php echo base_url();?>resources/images/ad_vr1.png"></div>
                    </div>
			
			
		
		</div>
 

<?php include 'common_pages/internal_footer.php';?>
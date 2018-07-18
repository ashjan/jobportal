<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
	
    
<!--        <a class="skp_bt" href="<?php echo base_url();?>"><h1><input type="button" name="back" value="Back to MAin"/></h1></a>-->
           
    <?php 
        if(isset($this->session->userdata['user_data']['u_type']))
        {
            if($this->session->userdata['user_data']['u_type'] == 3)
            {
                
                ?>
                    
                    <ul class="tabs_cnt">
                        
                        <?php if(isset($resume)){ ?>
                        <li>
                            <a href="<?php echo base_url();?>resume/edit_resume/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Edit Resume
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
                                <img src="<?php echo base_url().'resources/images/resume_preview.png';?>"/>
                            <br/>
                            Preview Resume
                            </a>
                        </li>
                        
                        <li>
                            <a href=""> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Download Resume
                            </a>
                        </li>
                        
                        <?php }else{ ?>
                        
                        <li>
                            <a href="<?php echo base_url().'resume';?>"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Resume Management
                            </a>
                        </li>
                        
                        <?php } ?>
                        
                        <li>
                            <a href=""> 
                                <img src="<?php echo base_url().'resources/images/interviews-jobseeker.png';?>"/>
                            <br/>
                            My Interviews
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'jobs/cand_applications';?>"> 
                                <img src="<?php echo base_url().'resources/images/job-applications.gif';?>"/>
                            <br/>
                            My Applications
                            </a>
                        </li>
                    </ul>
                    
                    <div class="clearfix"></div>
                    
                    <?php
                
                include("common_pages/left_pannel_usr.php");
            }
            else 
            {
                ?> 
            <ul class="tabs_cnt">
                        
                       
                        <li>
                            <a href="<?php echo base_url();?>jobs/"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Post Job
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>jobs/emp_job_listing/"> 
                                <img src="<?php echo base_url().'resources/images/resume_preview.png';?>"/>
                            <br/>
                            Job Listing
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>jobs/emp_applications/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Applications
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>resume/fav_cand_listing/"> 
                                <img src="<?php echo base_url().'resources/images/interviews-jobseeker.png';?>"/>
                            <br/>
                            Favorite Candidates
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url().'jobs/emp_applications';?>"> 
                                <img src="<?php echo base_url().'resources/images/job-applications.gif';?>"/>
                            <br/>
                            Applications
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <?php
                include("common_pages/left_pannel.php");
            }
        }
        else
        {
            echo '<div class="left_pannel">';
            echo '<img width="266" height="936" src="'.base_url().'resources/images/ad_vr2.jpg"></div>';
        }
        ?>
           <?php //echo "<pre>"; print_r($reseme_details); exit; ?>
            <div class="right_panel">
            <?php if(isset($app_id)){?>
            <a href="<?php echo $url.'jobs/schedule_interview/'.$app_id.'/0/'.$job_id;?>"><input type="button" name="schedule" value="Schedule Interview"/></a>
            <?php } ?>
           
            <span class="cv_img">
               <?php if(!empty($reseme_details[0]['images'])){?>
                <img width="100px" height="100px" class="resume_pic" src="<?php echo base_url().'resources/classes/phpthumb/phpThumb.php?src=/jobportal/uploads/resume_images/'.$reseme_details[0]['images'][0]['image_name'];?>&w=100&h=100&q=100&bg=ffffff"/>
               <?php } else{?>
                <img width="100px" height="100px" class="resume_pic" src="<?php echo base_url().'resources/images/profilepic.png';?>"/>
               <?php }?>
            </span>
            
            <h2><?php echo $reseme_details[0]['first_name'].' '.$reseme_details[0]['last_name']; if ($reseme_details[0]['father_name']!=""){ if($reseme_details[0]['gender']=='Male'){echo ' S/o ';}else{echo ' D/o ';} echo $reseme_details[0]['father_name']; }?></h2>
            <p><?php echo $reseme_details[0]['address_1']; ?></p><br hidefocus="true" style="outline: medium none;">
            <div class= "resume_div"><strong class="gen_inf">Phone #: </strong></div>
            <div class= "resume_div"> <?php echo $reseme_details[0]['phone']; ?></div>
            <div class="clear"></div>
            
            
            <?php if($reseme_details[0]['cnic']){?>
            <div class= "resume_div"><strong>CNIC #: </strong></div> <div class= "resume_div"><?php echo $reseme_details[0]['cnic']; ?>  </div>
            <div class="clear"></div>
            <?php } ?>
            
            <?php if($reseme_details[0]['salary']){?>
            <div class= "resume_div"><strong>Current Salary: </strong></div> <div class= "resume_div"><?php echo $reseme_details[0]['salary']; ?> </div> 
            <div class="clear"></div>
            <?php } ?>
            
            <?php if($reseme_details[0]['expected_salary']){?>
            <div class= "resume_div"><strong>Expected Salary: </strong> </div><div class= "resume_div"><?php echo $reseme_details[0]['expected_salary']; ?>  </div> 
            <div class="clear"></div>
            
            <?php } if($reseme_details[0]['marital_status'] != ""){ ?> 
                
            <div class= "resume_div"><strong>Marital Status: </strong></div> <div class= "resume_div"><?php echo $reseme_details[0]['marital_status']; ?> </div>  
            <div class="clear"></div>
            
            <?php }?>
                
                <?php if($reseme_details[0]['email'] != ""){?>
            
            <div class= "resume_div"><strong>Email: </strong></div> <div class= "resume_div"><?php echo $reseme_details[0]['email']; ?>  </div> 
            <div class="clear"></div>
            
            <?php } if($reseme_details[0]['date_of_birth'] != ""){?>
            <div class= "resume_div"><strong>Date Of Birth: </strong></div> <div class= "resume_div"><?php echo date("l jS F Y",strtotime($reseme_details[0]['date_of_birth'])); ?> </div>  
            <div class="clear"></div>
            
            <?php } if($reseme_details[0]['available_date'] != ""){?>
            <div class= "resume_div"><strong>Available From: </strong></div> <div class= "resume_div"><?php echo date("l jS F Y",strtotime($reseme_details[0]['available_date'])); ?> </div>  
            <div class="clear"></div>
            <?php }  ?>
            
            
            
            <?php if(!empty($reseme_details[0]['objectives'])){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/portfolio_icon.png"/>Objectives</h3>
            <div class="dtls">
                <?php 
                    echo stripslashes($reseme_details[0]['objectives']);
                
?>
            </div>
            <?php }  
            
                  
            if(!empty($resume_cover_letter[0]['letter_description'])){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/portfolio_icon.png"/>Covering Letter</h3>
            <div class="dtls">
            <?php 
                    echo stripslashes($resume_cover_letter[0]['letter_description']);
            ?>
            </div>
            <?php 
            } 
            if($reseme_details[0]['education_details'][0]['title'] != ''){
			//if(!empty($reseme_details[0]['education_details'])){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/education_icon.png"/>Educational Details</h3>
            <div class="dtls">
                <?php foreach($reseme_details[0]['education_details'] as $res){
                echo '<h4>'.$res['title'];
                if($res['grade'] != "")
                {
                    echo '('.$res['grade'].')';
                }
                    echo '<div class="period">'; if($res['start_date'] != ""){ echo date("jS F Y",strtotime($res['start_date']));} if($res['start_date'] != "" && $res['end_date'] != ""){echo ' to ';} if($res['end_date'] != ""){ echo date("jS F Y",strtotime($res['end_date'])); } echo '</div></h4>';
                    echo 'at '.$res['institute'];
                }
?>
            </div>
                <?php } ?>
            
            <?php 
			if($reseme_details[0]['work_details'][0]['designation'] != ''){
			//if(!empty($reseme_details[0]['work_details'])){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/experiance_icon.png"/>Work Experience</h3>
            <div class="dtls">
                <?php foreach($reseme_details[0]['work_details'] as $res){
                    echo '<h4>'.$res['designation'].'<div class="period">'; if($res['start_date'] != ""){ echo date("jS F Y",strtotime($res['start_date']));} if($res['end_date'] != "" && $res['start_date'] != ""){ echo ' to '; } if($res['end_date'] != ""){ echo date("jS F Y",strtotime($res['end_date']));} echo '</div></h4>';
                    echo stripslashes($res['job_responsibilities']);
                }
?>
            </div>
            <?php } ?>
            
            <?php 
			if($reseme_details[0]['trainings'][0]['course_name'] != ''){
			//if(!empty($reseme_details[0]['trainings'])){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/portfolio_icon.png"/>Trainings & Courses</h3>
            <div class="dtls">
                <?php foreach($reseme_details[0]['trainings'] as $tran){
                    echo '<h4>'.$tran['course_name'].'<div class="period">';if($tran['date'] != ""){ echo date("jS F Y",strtotime($tran['date']));} echo '</div></h4>';
                    if($tran['conducted_by'] != ""){ echo '<strong>Conducted By: </strong>'.$tran['conducted_by'];} if($tran['location'] != ""){ echo '<strong> In: </strong>'.$tran['location']; }
                }
?>
            </div>
            <?php } ?>
            
            <?php 
			if($reseme_details[0]['achievements'][0]['description'] != ''){
			//if(!empty($reseme_details[0]['achievements'])){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/awards_icon.png"/>Key Achievements</h3>
            <div class="dtls">
                <?php foreach($reseme_details[0]['achievements'] as $ach){
                    echo '<h4>'.$ach['description'].'<div class="period">'; if($ach['ach_date'] != ""){ echo date("jS F Y",strtotime($ach['ach_date']));} echo '</div></h4>';
                if($ach['location'] != ""){ echo '<strong>at: </strong>'.$ach['location'];}
                }
?>
            </div>
            <?php } ?>
            
             <?php if($reseme_details[0]['business_skills'] != ""){?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/skills_icon.png"/>Business Skills</h3>
            <?php echo stripslashes($reseme_details[0]['business_skills']); ?>
            <?php } if($reseme_details[0]['language_skills'] != ""){ ?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/skills_icon.png"/>Language Skills</h3>
            <?php echo stripslashes($reseme_details[0]['language_skills']); ?>
            <?php } if($reseme_details[0]['computer_skills'] != ""){ ?>
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/skills_icon.png"/>Computer Skills</h3>
            <?php echo stripslashes($reseme_details[0]['computer_skills']); ?>
            <?php } if($reseme_details[0]['refrences'] != ""){?>
            
            <h3 class="res_heading_sb"><img src="<?php echo base_url();?>resources/images/portfolio_icon.png"/>References</h3>
            <div class="dtls">
                <?php echo stripslashes($reseme_details[0]['refrences']); ?>
            </div>
            <?php } ?>
            
            </div>
        
        
       <?php if(isset($usr_typ) && $usr_typ !=3){?>
        <div class="cv_rating">
            <h3 class="heading_sb">Ratings & Reviews</h3>
            <div class="dtls">
                <?php if(!empty($review_criteria)){ 
                    $rv = 1;
                    foreach($review_criteria as $rev){?>
                <div class="text"><?php echo $rev['criteria'];?></div> <div class="field"><div class="rating"  id="rate<?php echo $rv;?>"></div></div>
                <script>
                var rv_id = "<?php echo $rv;?>";
                var str_rt = "<?php echo $url.'review/star_rating/'.$rev['id'].'/'.$reseme_details[0]['id'].'/'.$reseme_details[0]['candidate_id'].'/'.$rev['check_aded'];?>";
                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                </script>
                
                <?php $rv++;} } ?>
                <?php echo form_open('review/add_resume_review/'.$reseme_details[0]['id'].'/'.$reseme_details[0]['candidate_id'].'/'.$app_id.'/'.$job_id);?>
                <div class="text">Review:</div> <div class="field"><textarea name="review" id="review"></textarea></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div><div class="field"><input type="submit" name="post_review" value="Post Review"/></div>
                <?php echo form_close();?>
            </div>
        </div>
       <?php } ?> 
        
	
</div>


<?php include("common_pages/internal_footer.php");?>`
<script>
    function uploadd()
    {
        $('#cv_upl').css('display','block');
        $('#create_cv').css('display','none');
    }
    
    function createe()
    {
        $('#create_cv').css('display','block');
        $('#cv_upl').css('display','none');
    }
    
    $(document).ready(function() {

    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $('#available').Zebra_DatePicker();
    $('#dob').Zebra_DatePicker();
 });
    </script>
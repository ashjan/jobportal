
<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if($this->session->userdata['user_data']['u_type'] == 3)
        {
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
                            <a href="<?php echo base_url();?>profile/manage_team/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Manage Team
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
        ?>
        
	<div class="right_panel">
            
            <?php
            echo form_open('jobs/index');?>
            <h2>Post New Job</h2>
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
                
                <div class="text">Job Title:</div>
                <div class="field"><input type="text" class="inpt_fld" name="title" id="title" value="<?php if(isset($ttl)){echo $ttl;}else echo '';?>" required/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Description:</div>
                <div class="field"><textarea name="description" cols="50" rows="10"> <?php if(isset($des)){echo $des;}else echo '';?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Country:</div>
                <div class="field"><select id="Country" name="Country" class="inpt_fld" onChange="effect_of_country(this);">
                            <option value="">--Select Country--</option>
                            <?php foreach ($countries as $cnt) { ?>
                                <option value="<?php echo $cnt['countryid']; ?>" <?php if(isset($cntry) and $cntry == $cnt['countryid']){echo " selected='selected'";} ?>><?php echo $cnt['country']; ?></option>
                            <?php } ?>
                        </select></div>
                <div class="clearfix"></div>
            
                <div class="text">State:</div>
                <div class="field"><select id="State" name="State" class="inpt_fld" onChange="effect_of_state(this);">
                            <option value="">--Select State--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">City:</div>
                <div class="field"><select id="City" name="City" class="inpt_fld">
                            <option value="">--Select City--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Type:</div>
                <div class="field"><select class="inpt_fld" name="type" id="type">
                                <option value="">-- Select Job Type --</option>
                                <?php if(isset($type) and $type == 2){
										
									?>
                                <option value="1">Full Time</option>
                                <option value="2" selected="selected" >Part Time</option>
                                <?php } else { ?>
                                <option value="1" selected >Full Time</option>
                                <option value="2">Part Time</option>
                                <?php } ?>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Salary From:</div>
                <div class="field"><input type="text" class="inpt_fld" name="salary" id="salary" value="<?php if(isset($sal)){echo $sal;}else echo '';?>"  required/>&nbsp;PKR</div>
                <div class="clearfix"></div>
                
                <div class="text">Salary To:</div>
                <div class="field"><input type="text" class="inpt_fld" name="salary_to" id="salary_to" value="<?php if(isset($sal_to)){echo $sal_to;}else echo '';?>" required/>&nbsp;PKR</div>
                <div class="clearfix"></div>
                
                
                <div class="text">Job Category:</div>
                <div class="field"><select id="category" name="category" class="inpt_fld">
                            <option value="">--Select Category--</option>
                            <?php foreach ($categories as $cnt) { ?>
                                <option value="<?php echo $cnt['id']; ?>" <?php if(isset($cat) and $cat == $cnt['id']){echo " selected='selected'";} ?>><?php echo $cnt['property_category_name']; ?></option>
                            <?php } ?>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Career Level:</div>
                <div class="field"><select id="career_lvl" name="career_lvl" class="inpt_fld">
                <?php if(isset($career) and $career != ''){
					if($career == 1){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1" selected >Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5">Manager (Manager/Supervisor)</option>
                            <option value="6">Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                        <?php } elseif($career == 2){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2" selected >Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5">Manager (Manager/Supervisor)</option>
                            <option value="6">Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                        <?php } elseif($career == 3){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3" selected>Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5">Manager (Manager/Supervisor)</option>
                            <option value="6">Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                        <?php } elseif($career == 4){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4" selected>Experienced (Non-Managerial)</option>
                            <option value="5">Manager (Manager/Supervisor)</option>
                            <option value="6">Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                        <?php } elseif($career == 5){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5" selected>Manager (Manager/Supervisor)</option>
                            <option value="6">Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                       <?php } elseif($career == 6){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5" >Manager (Manager/Supervisor)</option>
                            <option value="6" selected>Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                        <?php } elseif($career == 6){
						?>
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5" >Manager (Manager/Supervisor)</option>
                            <option value="6" >Executive (SVP, VP, Department Head)</option>
                            <option value="7" selected>Senior Executive (CEO, President, etc.)</option>
                        <?php } } else { ?>
                        <option value="" selected>>--Select Level--</option>
                            <option value="1"> Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5" >Manager (Manager/Supervisor)</option>
                            <option value="6" >Executive (SVP, VP, Department Head)</option>
                            <option value="7" >Senior Executive (CEO, President, etc.)</option>
                        <?php } ?>
                        
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Experience Level:</div>
                <div class="field"><select id="experience" name="experience" class="inpt_fld">
                            
                            <?php if(isset($experience) and $experience != ''){
									if($experience == -2){
								 ?>
                            <option value="">--Select Level--</option>
                            <option value="-2" selected>Student</option>
                            <option value="-1">fresh Graduate</option>
                            <option value="0">Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>"><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26"> More Than 25 years</option>
                                <?php }elseif($experience == -1){
								 ?>
                            <option value="">--Select Level--</option>
                            <option value="-2">Student</option>
                            <option value="-1" selected>fresh Graduate</option>
                            <option value="0">Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>"><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26"> More Than 25 years</option>
                                 <?php }elseif($experience == 0 ){
								 ?>
                            <option value="">--Select Level--</option>
                            <option value="-2">Student</option>
                            <option value="-1">fresh Graduate</option>
                            <option value="0" selected>Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>"><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26"> More Than 25 years</option>
                                <?php }elseif($experience == 26){
								 ?>
                            <option value="">--Select Level--</option>
                            <option value="-2">Student</option>
                            <option value="-1">fresh Graduate</option>
                            <option value="0">Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>"><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26" selected> More Than 25 years</option>
                                <?php }elseif($experience < 26 and $experience > 0){
								 ?>
                            <option value="">--Select Level--</option>
                            <option value="-2">Student</option>
                            <option value="-1">fresh Graduate</option>
                            <option value="0">Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>" <?php if($experience == $exp){echo " selected='selected'";} ?>><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26"> More Than 25 years</option>
                                <?php } }else { ?>
                                 <option value="" selected>--Select Level--</option>
                            <option value="-2">Student</option>
                            <option value="-1">fresh Graduate</option>
                            <option value="0">Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>"><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26" > More Than 25 years</option>
                                <?php } ?>
                                
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Shift Timings:</div>
                <div class="field"><select id="shift" name="shift" class="inpt_fld">
                            <?php if(isset($shift) and $shift != ''){
								if($shift == 1){
								 ?>
                            
                            <option value="">--Select Timings--</option>
                                <option value="1" selected> Morning Shift </option>
                                <option value="2"> Evening Shift </option>
                                <option value="3"> Night Shift </option>
                                <option value="4"> On Rotation</option>
                                <?php } else if($shift == 2){
								 ?>
                            
                            <option value="">--Select Timings--</option>
                                <option value="1"> Morning Shift </option>
                                <option value="2" selected> Evening Shift </option>
                                <option value="3"> Night Shift </option>
                                <option value="4"> On Rotation</option>
                                <?php } else if($shift == 3){
								 ?>
                            
                            <option value="">--Select Timings--</option>
                                <option value="1"> Morning Shift </option>
                                <option value="2"> Evening Shift </option>
                                <option value="3" selected> Night Shift </option>
                                <option value="4"> On Rotation</option>
                                <?php } else if($shift == 4){
								 ?>
                            
                            <option value="">--Select Timings--</option>
                                <option value="1"> Morning Shift </option>
                                <option value="2"> Evening Shift </option>
                                <option value="3"> Night Shift </option>
                                <option value="4" selected> On Rotation</option>
                                <?php } } else { ?>
                                <option value="" selected>--Select Timings--</option>
                                <option value="1"> Morning Shift </option>
                                <option value="2"> Evening Shift </option>
                                <option value="3"> Night Shift </option>
                                <option value="4" > On Rotation</option>
                                <?php } ?>
                                
                                
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">No of Vacancies:</div>
                <div class="field"><input type="text" name="vacancies" value="<?php if(isset($vacancies)){echo $vacancies;}else{echo "";} ?>" id="vacancies" class="inpt_fld"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Job Posted:</div>
                <div class="field"><input class="inpt_fld" type="text" name="start_date" id="start_date" value="<?php if(isset($start)){echo $start;}else{echo "";} ?>" required/> </div>
                <div class="clearfix"></div>
                
                <div class="text">Due Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date" id="end_date" value="<?php if(isset($end)){echo $end;}else{echo "";} ?>" required readonly/></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Post Job"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();
           // }else{ echo "Please Complete your Registration process to get full access to all the features."; }?>
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
     function effect_of_country(ele)
    {
        var cod = ele.value;
        $.ajax({url: stt + cod, success: function(result) {

                $('#State').html(result);

            }});
    }

    function effect_of_state(ele)
    {
        var cod = ele.value;
        $.ajax({url: cty + cod, success: function(result) {

                $('#City').html(result);

            }});
    }
    
    $(document).ready(function() {

    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $('#start_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
 });
</script>
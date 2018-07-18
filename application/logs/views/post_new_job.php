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
                            <a href="<?php echo base_url();?>index.php/jobs/"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Post Job
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>index.php/jobs/emp_job_listing/"> 
                                <img src="<?php echo base_url().'resources/images/resume_preview.png';?>"/>
                            <br/>
                            Job Listing
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>index.php/profile/manage_team/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Manage Team
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>index.php/resume/fav_cand_listing/"> 
                                <img src="<?php echo base_url().'resources/images/interviews-jobseeker.png';?>"/>
                            <br/>
                            Favorite Candidates
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url().'index.php/jobs/emp_applications';?>"> 
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
            if($this->session->userdata['user_data']['is_comp_admin'] == 1){
            echo form_open('jobs/index');?>
            <h2>Post New Job</h2>
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
                
                <div class="text">Job Title:</div>
                <div class="field"><input type="text" class="inpt_fld" name="title" id="title" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Description:</div>
                <div class="field"><textarea name="description" cols="50" rows="10"></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Country:</div>
                <div class="field"><select id="Country" name="Country" class="inpt_fld" onchange="effect_of_country(this);">
                            <option value="">--Select Country--</option>
                            <?php foreach ($countries as $cnt) { ?>
                                <option value="<?php echo $cnt['countryid']; ?>"><?php echo $cnt['country']; ?></option>
                            <?php } ?>
                        </select></div>
                <div class="clearfix"></div>
            
                <div class="text">State:</div>
                <div class="field"><select id="State" name="State" class="inpt_fld" onchange="effect_of_state(this);">
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
                                <option value="1">Full Time</option>
                                <option value="2">Part Time</option>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Salary:</div>
                <div class="field"><input type="text" class="inpt_fld" name="salary" id="salary" required=""/>&nbsp;PKR</div>
                <div class="clearfix"></div>
                
                <div class="text">Job Category:</div>
                <div class="field"><select id="category" name="category" class="inpt_fld">
                            <option value="">--Select Category--</option>
                            <?php foreach ($categories as $cnt) { ?>
                                <option value="<?php echo $cnt['id']; ?>"><?php echo $cnt['property_category_name']; ?></option>
                            <?php } ?>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Career Level:</div>
                <div class="field"><select id="career_lvl" name="career_lvl" class="inpt_fld">
                            <option value="">--Select Level--</option>
                            <option value="1">Student (High School/College)</option>
                            <option value="2">Student (Undergraduate/Graduate)</option>
                            <option value="3">Entry Level</option>
                            <option value="4">Experienced (Non-Managerial)</option>
                            <option value="5">Manager (Manager/Supervisor)</option>
                            <option value="6">Executive (SVP, VP, Department Head)</option>
                            <option value="7">Senior Executive (CEO, President, etc.)</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Experience Level:</div>
                <div class="field"><select id="experience" name="experience" class="inpt_fld">
                            <option value="">--Select Level--</option>
                            <option value="-2">Student</option>
                            <option value="-1">fresh Graduate</option>
                            <option value="0">Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>"><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26"> More Than 25 years</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Shift Timings:</div>
                <div class="field"><select id="shift" name="shift" class="inpt_fld">
                            <option value="">--Select Timings--</option>
                                <option value="1"> Morning Shift </option>
                                <option value="2"> Evening Shift </option>
                                <option value="3"> Night Shift </option>
                                <option value="4"> On Rotation</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">No of Vacancies:</div>
                <div class="field"><input type="text" name="vacancies" id="vacancies" class="inpt_fld"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Job Posted:</div>
                <div class="field"><input class="inpt_fld" type="text" name="start_date" id="start_date" required=""/> </div>
                <div class="clearfix"></div>
                
                <div class="text">Due Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date" id="end_date" required="" readonly="readonly"/></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Post Job"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();
            }else{ echo "Please Complete your Registration process to get full access to all the features."; }?>
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'index.php/jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'index.php/jobs/list_cities/'; ?>';
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
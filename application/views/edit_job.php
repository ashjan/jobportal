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
            include("common_pages/left_pannel.php");
        }
        ?>
        
	<div class="right_panel">
            
            <?php echo form_open('jobs/edit_job');?>
            <h2>Edit Job</h2>
            
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
                
                <div class="text">Job Title:</div>
                <div class="field"><input type="hidden" name="job_id" value="<?php echo $job_dtl[0]['job_id'];?>"/><input type="text" class="inpt_fld" style="width: 550px;" name="title" id="title" value="<?php if($this->input->post('title') != ""){echo $this->input->post('title');}else{echo $job_dtl[0]['job_title'];}?>" required/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Description:</div>
                <div class="field"><textarea name="description" cols="50" rows="10"><?php if($this->input->post('description') != ""){echo $this->input->post('description');}else{ echo $job_dtl[0]['job_description'];}?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Country:</div>
                <div class="field"><select class="inpt_fld" id="Country" name="Country">
                            <option value="">--Select Country--</option>
                            <?php foreach ($countries as $cnt) { 
                                if($cnt['countryid'] == $job_dtl[0]['country']){?>
                            <option value="<?php echo $cnt['countryid']; ?>" selected="selected"><?php echo $cnt['country']; ?></option>
                                <?php }else{?>
                                <option value="<?php echo $cnt['countryid']; ?>"><?php echo $cnt['country']; ?></option>
                                <?php }} ?>
                        </select></div>
                <div class="clearfix"></div>
            
                <div class="text">State:</div>
                <div class="field"><select class="inpt_fld" id="State" name="State">
                            <option value="">--Select State--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">City:</div>
                <div class="field"><select class="inpt_fld" id="City" name="City">
                            <option value="">--Select City--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Type:</div>
                        <div class="field"><select class="inpt_fld" name="type" id="type">
                                <option value="">-- Select Job Type --</option>
                                <option value="1" <?php if($job_dtl[0]['job_type'] == 1){ echo "selected='selected'";} ?>>Full Time</option>
                                <option value="2" <?php if($job_dtl[0]['job_type'] == 2){ echo "selected='selected'";} ?>>Part Time</option>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Salary From:</div>
                <div class="field"><input class="inpt_fld" type="text"  name="salary" value="<?php if($this->input->post('salary') != ""){echo $this->input->post('salary');}else{ echo $job_dtl[0]['salary'];}?>" id="salary" required=""/>&nbsp;PKR</div>
                <div class="clearfix"></div>
                
                <div class="text">Salary To:</div>
                <div class="field"><input type="text" class="inpt_fld" name="salary_to" id="salary_to" value="<?php echo $job_dtl[0]['salary_to'];?>" required/>&nbsp;PKR</div>
                <div class="clearfix"></div>
                
                
                <div class="text">Job Category:</div>
                <div class="field"><select class="inpt_fld" id="category" name="category">
                            <option value="">--Select Category--</option>
                            <?php foreach ($categories as $cnt) {
                                if($cnt['id'] == $job_dtl[0]['category']){?>
                            <option value="<?php echo $cnt['id']; ?>" selected="selected"><?php echo $cnt['property_category_name']; ?></option>
                                <?php }else{?>
                            
                                <option value="<?php echo $cnt['id']; ?>"><?php echo $cnt['property_category_name']; ?></option>
                                <?php }} ?>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Career Level:</div>
                <div class="field"><select id="career_lvl" name="career_lvl" class="inpt_fld">
                            <option value="">--Select Level--</option>
                            <option value="1" <?php if($job_dtl[0]['career'] == 1){ echo "selected='selected'";} ?>>Student (High School/College)</option>
                            <option value="2" <?php if($job_dtl[0]['career'] == 2){ echo "selected='selected'";} ?>>Student (Undergraduate/Graduate)</option>
                            <option value="3" <?php if($job_dtl[0]['career'] == 3){ echo "selected='selected'";} ?>>Entry Level</option>
                            <option value="4" <?php if($job_dtl[0]['career'] == 4){ echo "selected='selected'";} ?>>Experienced (Non-Managerial)</option>
                            <option value="5" <?php if($job_dtl[0]['career'] == 5){ echo "selected='selected'";} ?>>Manager (Manager/Supervisor)</option>
                            <option value="6" <?php if($job_dtl[0]['career'] == 6){ echo "selected='selected'";} ?>>Executive (SVP, VP, Department Head)</option>
                            <option value="7" <?php if($job_dtl[0]['career'] == 7){ echo "selected='selected'";} ?>>Senior Executive (CEO, President, etc.)</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Experience Level:</div>
                <div class="field"><select id="experience" name="experience" class="inpt_fld">
                            <option value="">--Select Level--</option>
                            <option value="-2" <?php if($job_dtl[0]['experience'] == -2){ echo "selected='selected'";} ?>>Student</option>
                            <option value="-1" <?php if($job_dtl[0]['experience'] == -1){ echo "selected='selected'";} ?>>fresh Graduate</option>
                            <option value="0" <?php if($job_dtl[0]['experience'] == 0){ echo "selected='selected'";} ?>>Less Than 1 year</option>
                            <?php for($exp=1;$exp<=25;$exp++) { ?>
                                <option value="<?php echo $exp; ?>" <?php if($job_dtl[0]['experience'] == $exp){ echo "selected='selected'";} ?>><?php echo $exp.' Year'; if($exp > 1){echo 's';} ?></option>
                            <?php } ?>
                                <option value="26" <?php if($job_dtl[0]['experience'] == 26){ echo "selected='selected'";} ?>> More Than 25 years</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Shift Timings:</div>
                <div class="field"><select id="shift" name="shift" class="inpt_fld">
                            <option value="">--Select Timings--</option>
                                <option value="1" <?php if($job_dtl[0]['shift_titming'] == 1){ echo "selected='selected'";} ?>> Morning Shift </option>
                                <option value="2" <?php if($job_dtl[0]['shift_titming'] == 2){ echo "selected='selected'";} ?>> Evening Shift </option>
                                <option value="3" <?php if($job_dtl[0]['shift_titming'] == 3){ echo "selected='selected'";} ?>> Night Shift </option>
                                <option value="4" <?php if($job_dtl[0]['shift_titming'] == 4){ echo "selected='selected'";} ?>> On Rotation</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">No of Vacancies:</div>
                <div class="field"><input type="text" name="vacancies" id="vacancies" class="inpt_fld" value="<?php if($this->input->post('vacancies') != ""){echo $this->input->post('vacancies');}else{ echo $job_dtl[0]['vacancies'];}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Post Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="start_date" value="<?php if($this->input->post('start_date') != ""){echo $this->input->post('start_date');}else{ echo $job_dtl[0]['start_date'];}?>" id="start_date" required/></div>
                <div class="clearfix"></div>
                
                <div class="text">Due Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date" value="<?php if($this->input->post('end_date') != ""){echo $this->input->post('end_date');}else{ echo $job_dtl[0]['end_date'];}?>" id="end_date" required readonly/></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Update Job"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    
    function validateForm() {
    var x = $('#title').val();
    if (x == null || x == "") {
        alert("First name must be filled out");
        return false;
    }
}
    
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
    state_id = '<?php echo $job_dtl[0]['state'];?>';
    city_id = '<?php echo $job_dtl[0]['city'];?>';
     $("#Country").change(function () {
	var cod = "";
	$("#Country option:selected").each(function () {
	cod += $(this).val();
	});
        
        $.ajax({url: stt + cod+'/'+state_id , success: function(result) {

                $('#State').html(result);

            }});
    }).trigger('change');

    $("#State").change(function () {
	var cod = "";
	$("#State option:selected").each(function () {
	cod += $(this).val();
	});
        if(cod == "")
        {
           cod = state_id; 
        }
        $.ajax({url: cty +cod+'/'+city_id, success: function(result) {

                $('#City').html(result);

            }});
    }).trigger('change');
    
    $(document).ready(function() {

    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $('#start_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
 });
</script>
<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if($this->session->userdata['user_data']['u_type'] == 3)
        {
            
            ?>
                    
                    <ul class="tabs_cnt">
                        
                        <?php if(isset($resume)){ ?>
                        <li>
                            <a href="<?php echo base_url();?>index.php/resume/edit_resume/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Edit Resume
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>index.php/resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
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
                            <a href="<?php echo base_url().'index.php/resume';?>"> 
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
                            <a href="<?php echo base_url().'index.php/jobs/cand_applications';?>"> 
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
                            <a href="<?php echo base_url();?>index.php/jobs/emp_applications/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Applications
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
<!--            <div class="frm_icons">
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Personal Info</label>
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume3/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Academics</label>
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume4/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Experiences</label>
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume5/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Trainings</label>
                
            </div>
            <div class="clearfix"></div>-->
<!--            <div id="cv_upl" style="display: none;">
                <?php echo form_open_multipart('resume/resume_upload');?>
                <h2>Upload Your Resume</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
                
                <div class="text">Upload Resume:</div>
                <div class="field"><input type="file" name="userfile1" /></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" id="upl_sub" name="submit" value="Save"/></div>
                <div class="clearfix"></div>
                
                <?php echo form_close();?>
                
            </div>-->
            
            <?php //echo "<pre>"; print_r($resume_details); exit;?>
                <h2>Edit My Resume</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
                <h3 class="res_edt_col_hd" id="prsnl">
                    <img src="<?php echo base_url();?>resources/images/portfolio_icon.png"/>Personal Details</h3>
                <div class="clearfix"></div>
            
                <div id="personal_details">
            <?php echo form_open('resume/edit_resume/'.$id.'/');?>
                <div class="text">First Name:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input onkeyup="validateForm()" type="text" class="inpt_fld" name="fname" id="fname" required="" value="<?php if($resume_details[0]['first_name']){ echo $resume_details[0]['first_name']; }elseif($this->input->post('fname') != ""){ echo $this->input->post('fname'); }?>"/>
                    <div class="msg" id="fnami"></div></div>
                
                
                <div class="text">Last Name:</div>
                <div class="field"><input onkeyup="validateForm()" type="text" class="inpt_fld" name="lname" id="lname" required="" value="<?php if($resume_details[0]['last_name']){ echo $resume_details[0]['last_name']; }elseif($this->input->post('lname') != ""){ echo $this->input->post('lname'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Father Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="father_name" id="father_name" value="<?php if($resume_details[0]['father_name']){ echo $resume_details[0]['father_name']; }elseif($this->input->post('father_name') != ""){ echo $this->input->post('father_name'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Gender:</div>
                <div class="field"><select class="inpt_fld" name="gender" id="gender">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?php if($resume_details[0]['gender'] == "Male"){ ?> selected="selected" <?php } ?> >Male</option>
                <option value="Female" <?php if($resume_details[0]['gender'] == "Female"){ ?> selected="selected" <?php } ?>>Female</option>
                    </select></div>
                
                
                <div class="text">Marital Status:</div>
               <div class="field"><select class="inpt_fld" name="m_status" id="m_status">
                        <option value="">-- Please Select --</option>
                        <option value="Single" <?php if($resume_details[0]['marital_status'] == "Single"){ ?> selected="selected" <?php } ?> >Single</option>
                        <option value="Married" <?php if($resume_details[0]['marital_status'] == "Married"){ ?> selected="selected" <?php } ?>>Married</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">CNIC #:</div>
                <div class="field"><input type="text" class="inpt_fld" name="cnic" id="cnic" value="<?php if($resume_details[0]['cnic']){ echo $resume_details[0]['cnic']; }elseif($this->input->post('cnic') != ""){ echo $this->input->post('cnic'); }?>"/></div>
                
                
                <div class="text">Profession Category:</div>
                <div class="field"><select class="inpt_fld" name="pro_cat" id="pro_cat">
                        <option value="">--Select Category--</option>
                        <?php foreach($categories as $cat){
                            if($resume_details[0]['category'] == $cat['id']){?>
                        <option value="<?php echo $cat['id'];?>" selected="selected"><?php echo $cat['property_category_name'];?></option>
                            <?php }else {?>
                        <option value="<?php echo $cat['id'];?>"><?php echo $cat['property_category_name'];?></option>
                        <?php }} ?>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Email:</div>
                <div class="field"><input type="email" class="inpt_fld" name="email" id="email" required="" value="<?php if($resume_details[0]['email']){ echo $resume_details[0]['email']; }elseif($this->input->post('email') != ""){ echo $this->input->post('email'); }?>"/></div>
                
                
                <div class="text">Phone#:</div>
                <div class="field"><input type="tel" class="inpt_fld" name="phone" id="phone" required="" value="<?php if($resume_details[0]['phone']){ echo $resume_details[0]['phone']; }elseif($this->input->post('phone') != ""){ echo $this->input->post('phone'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Address:</div>
                <div class="field"><input type="text" class="inpt_fld" name="adres" id="adres" value="<?php if($resume_details[0]['address_1']){ echo $resume_details[0]['address_1']; }elseif($this->input->post('adres') != ""){ echo $this->input->post('adres'); }?>"/></div>
                <div class="clearfix"></div>
                
<!--                <div class="text">Address 2:</div>
                <div class="field"><input type="text" class="inpt_fld" name="adres2" id="adres2" value="<?php //if($resume_details[0]['address_2']){ echo $resume_details[0]['address_2']; }elseif($this->input->post('adres') != ""){ echo $this->input->post('adres'); }?>"/></div>
                <div class="clearfix"></div>-->
                
                <div class="text">Objectives:</div>
                <div class="field"><textarea name="objectives" id="objectives"><?php if($resume_details[0]['objectives']){ echo $resume_details[0]['objectives']; }elseif($this->input->post('objectives') != ""){ echo $this->input->post('objectives'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Date of Birth:</div>
                <div class="field"><input class="inpt_fld" type="text" name="dob" id="dob" value="<?php if($resume_details[0]['date_of_birth']){ echo $resume_details[0]['date_of_birth']; }elseif($this->input->post('dob') != ""){ echo $this->input->post('dob'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Current Salary:</div>
                <div class="field"><input class="inpt_fld" type="text" name="salary" id="salary" value="<?php if($resume_details[0]['salary']){ echo $resume_details[0]['salary']; }elseif($this->input->post('salary') != ""){ echo $this->input->post('salary'); }?>"/> </div>
                
                
                <div class="text">Expected Salary:</div>
                <div class="field"><input class="inpt_fld" type="text" name="exp_sal" id="exp_sal" value="<?php if($resume_details[0]['expected_salary']){ echo $resume_details[0]['expected_salary']; }elseif($this->input->post('exp_sal') != ""){ echo $this->input->post('exp_sal'); }?>"/> </div>
                <div class="clearfix"></div>
                
                <h3 class="res_heading_sb">Availability</h3>
                <div class="clearfix"></div>
                <div class="text">Available From:</div>
                <div class="field"><input class="inpt_fld" type="text" name="available" id="available" value="<?php if($resume_details[0]['available_date']){ echo $resume_details[0]['available_date']; }elseif($this->input->post('available') != ""){ echo $this->input->post('available'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <h3 class="res_heading_sb">Business Skills</h3>
                <div class="clearfix"></div>
            
                <div class="text">Title:</div>
                <div class="field"><input type="hidden" value="<?php echo $id;?>" name="id"/><input type="text" class="inpt_fld" name="bus_title" id="bus_title" value="<?php if($resume_details[0]['business_title']){ echo $resume_details[0]['business_title']; }elseif($this->input->post('bus_title') != ""){ echo $this->input->post('bus_title'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Business Skills:</div>
                <div class="field"><textarea name="buss_skill" id="buss_skill"><?php if($resume_details[0]['business_skills']){ echo stripslashes($resume_details[0]['business_skills']); }elseif($this->input->post('buss_skill') != ""){ echo $this->input->post('buss_skill'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <h3 class="res_heading_sb">Other Skills</h3>
                <div class="clearfix"></div>
            
                <div class="text">Computer Languages:</div>
                <div class="field"><textarea name="lang_skill" id="lang_skill"><?php if($resume_details[0]['language_skills']){ echo stripslashes($resume_details[0]['language_skills']); }elseif($this->input->post('lang_skill') != ""){ echo $this->input->post('lang_skill'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Computer Skills:</div>
                <div class="field"><textarea name="comp_skill" id="comp_skill"><?php if($resume_details[0]['computer_skills']){ echo stripslashes($resume_details[0]['computer_skills']); }elseif($this->input->post('comp_skill') != ""){ echo $this->input->post('comp_skill'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">References:</div>
                <div class="field"><textarea name="refrence" id="refrence"><?php if($resume_details[0]['refrences']){ echo stripslashes($resume_details[0]['refrences']); }elseif($this->input->post('refrence') != ""){ echo $this->input->post('refrence'); }?></textarea></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Update"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
            </div>
                
                <h3 class="res_edt_col_hd" id="acad">
                    <input type="hidden" value="0" id="acad_ck"/>
                    <img src="<?php echo base_url();?>resources/images/education_icon.png"/>Educational Details
                </h3>
                
                <div id="academics">
                    
                    <?php if(!empty($resume_details) && !empty($resume_details[0]['education_details'])){
                        $incr=0;
                        echo form_open('resume/edit_edu/'.$resume_details[0]['id']);
                        foreach($resume_details[0]['education_details'] as $res){?>
                    
                            <div class="text">Degree Title:</div>
                <div class="field"><input type="text" class="inpt_fld" name="deg_ttl[]" id="deg_ttl" required="" value="<?php if($res['title'] != ""){ echo $res['title'];}elseif($this->input->post('deg_ttl') != ""){ echo $this->input->post('deg_ttl'); }?>"/></div>
                
                
                <div class="text">University/Board:</div>
                <div class="field"><input type="hidden" name="res_id[]" value="<?php echo $resume_details[0]['id'];?>"/><input type="text" class="inpt_fld" name="ins_name[]" id="ins_name" value="<?php if($res['institute'] != ""){ echo $res['institute'];}elseif($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">CGPA/Grade:</div>
                <div class="field"><input type="hidden" name="id[]" value="<?php echo $res['id'];?>"/><input type="text" class="inpt_fld" name="grade[]" id="grade" value="<?php if($res['grade'] != ""){ echo $res['grade'];}elseif($this->input->post('grade') != ""){ echo $this->input->post('grade'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Start Date:</div>
                        <div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date<?php echo $incr;?>" value="<?php if($res['start_date'] != ""){ echo $res['start_date'];}elseif($this->input->post('strt_date') != ""){ echo $this->input->post('strt_date'); }?>"/></div>
                
            
                <div class="text">Completion Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date<?php echo $incr;?>" value="<?php if($res['end_date'] != ""){ echo $res['end_date'];}elseif($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div id="tar">
                <div class="text">Major Subjects:</div>
                <div class="field"><textarea name="maj_sub[]" id="maj_sub"><?php if($res['maj_subjects'] != ""){ echo $res['maj_subjects'];}elseif($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?></textarea></div>
                <div class="clearfix"></div>
                </div>
                
                <div class="del_adeed"><a href="<?php echo base_url().'index.php/resume/delete_edu/'.$resume_details[0]['id'].'/'.$res['id'];?>"> <img src="<?php echo base_url().'resources/images/delete_edit_icon.png'?>"/> </a></div>
                
                <script>
                    var inc = <?php echo $incr;?>;
                $('#strt_date'+inc).Zebra_DatePicker();
    $('#end_date'+inc).Zebra_DatePicker();
</script>
                
                        <?php $incr++; }
                    echo '<div class="text"></div>';
                    echo '<div class="field"><input type="submit" name="submit" value="Update"/></div>';
                    echo '<div class="clearfix"></div>';
                            echo form_close();
                        } ?>
                    <div class="add_new_icn" id="edu_ad_icn">
                        <img src="<?php echo base_url().'resources/images/plus_sign.png'?>"/> Add New Education Detail
                    </div>
                    
                    <div id="add_edu_frm">
                        <?php echo form_open('resume/edit_resume3/'.$resume_details[0]['id']);?>
                        <div id="create_edu">
                <div class="text">Degree Title:</div>
                <div class="field"><input type="hidden" value="0" id="indexi_edu"/><input type="text" class="inpt_fld" name="deg_ttl[]" id="deg_ttl" required="" value="<?php if($this->input->post('deg_ttl') != ""){ echo $this->input->post('deg_ttl'); }?>"/></div>
                
                
                <div class="text">University/Board:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $resume_details[0]['id'];?>"/><input type="text" class="inpt_fld" name="ins_name[]" id="ins_name" required="" value="<?php if($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">CGPA/Grade:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input type="text" class="inpt_fld" name="grade[]" id="grade" value="<?php if($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Start Date:</div>
                        <div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date_edu0" required="" value="<?php if($this->input->post('strt_date') != ""){ echo $this->input->post('strt_date'); }?>"/></div>
                
            
                <div class="text">Completion Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date_edu0" required="" value="<?php if($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div id="tar">
                <div class="text">Major Subjects:</div>
                <div class="field"><textarea name="maj_sub[]" id="maj_sub"></textarea></div>
                <div class="clearfix"></div>
                </div>
                
                
                
                <div id="add_moreedu"></div>
                
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more_edu()"/>
                
                <img id="rem_bt_edu" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_form()"/>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"> <input type="submit" name="submit" value="Add"/> </div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                        
                    </div>

                </div>
            
                <h3 class="res_edt_col_hd" id="wrk">
                    <input type="hidden" value="0" id="wrk_ck"/>
                    <img src="<?php echo base_url();?>resources/images/experiance_icon.png"/>Work Experience
                </h3>
                <div id="experiances">
                    
                    <?php if(!empty($resume_details) && !empty($resume_details[0]['education_details'])){
                        echo form_open('resume/edit_work/'.$resume_details[0]['id']);
                        $incr=0;
                        foreach($resume_details[0]['work_details'] as $wrk){
                        ?>
                    
                     <div class="text">Designation:</div>
                <div class="field"><input type="text" class="inpt_fld" name="desig[]" id="desig" required="" value="<?php if($wrk['designation'] != ""){ echo $wrk['designation'];}elseif($this->input->post('desig') != ""){ echo $this->input->post('desig'); }?>"/></div>
                
                
                <div class="text">Company:</div>
                <div class="field"><input type="hidden" name="id[]" value="<?php echo $wrk['id'];?>"/><input type="text" class="inpt_fld" name="cmpny[]" id="cmpny" required="" value="<?php if($wrk['company_name'] != ""){ echo $wrk['company_name'];}elseif($this->input->post('cmpny') != ""){ echo $this->input->post('cmpny'); }?>"/></div>
                <div class="clearfix"></div>
                
                <h3>Duration</h3>
                
                
                <div class="text">Start Date:</div>
                <div class="field"><input type="hidden" name="res_id[]" value="<?php echo $resume_details[0]['id'];?>"/><input class="inpt_fld" type="text" name="strt_date[]" id="wrk_strt_date<?php echo $incr;?>" required="" value="<?php if($wrk['start_date'] != ""){ echo $wrk['start_date'];}elseif($this->input->post('start_date') != ""){ echo $this->input->post('start_date'); }?>"/></div>
                
                
                <div class="text">End Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="wrk_end_date<?php echo $incr;?>" value="<?php if($wrk['end_date'] != ""){ echo $wrk['end_date'];}elseif($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Responsibilities:</div>
                <div class="field"><textarea name="responsiblty[]" id="responsiblty"><?php if($wrk['job_responsibilities'] != ""){ echo stripslashes($wrk['job_responsibilities']);}elseif($this->input->post('responsiblty') != ""){ echo $this->input->post('responsiblty'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="del_adeed"><a href="<?php echo base_url().'index.php/resume/delete_work/'.$resume_details[0]['id'].'/'.$wrk['id'];?>"> <img src="<?php echo base_url().'resources/images/delete_edit_icon.png'?>"/> </a></div>
                
                    <script>
                     var inc = <?php echo $incr;?>;
                $('#wrk_end_date'+inc).Zebra_DatePicker();
                $('#wrk_strt_date'+inc).Zebra_DatePicker();
                    </script>
                    
                    <?php $incr++; }
                echo '<div class="text"></div>';
                echo '<div class="field"><input type="submit" name="submit" value="Update"/></div>';
                echo '<div class="clearfix"></div>';
                    echo form_close();
                }?>
                    <div class="add_new_icn" id="add_exp_icn">
                        <img src="<?php echo base_url().'resources/images/plus_sign.png'?>"/> Add New Work Experience
                    </div>
                    
                    <div id="add_exp_frm">
                     
                        <?php echo form_open('resume/edit_resume4/'.$resume_details[0]['id']); ?>
                        <div id="create_exp">
            
                <div class="clearfix"></div>
            
                <div class="text">Designation:</div>
                <div class="field"><input type="hidden" id="indexi_exp" value="0"/><input type="text" class="inpt_fld" name="desig[]" id="desig" required="" value="<?php if($this->input->post('desig') != ""){ echo $this->input->post('desig'); }?>"/></div>
                
                
                <div class="text">Company:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $resume_details[0]['id'];?>"/><input type="text" class="inpt_fld" name="cmpny[]" id="cmpny" required="" value="<?php if($this->input->post('cmpny') != ""){ echo $this->input->post('cmpny'); }?>"/></div>
                <div class="clearfix"></div>
                
                <h3>Duration</h3>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Start Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date_exp0" required="" value="<?php if($this->input->post('start_date') != ""){ echo $this->input->post('start_date'); }?>"/></div>
                
                
                <div class="text">End Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date_exp0" required="" value="<?php if($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Responsibilities:</div>
                <div class="field"><textarea name="responsiblty[]" id="responsiblty"></textarea></div>
                <div class="clearfix"></div>
                
                <div id="add_moreexp"></div>
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more_exp()"/>
                <img id="rem_bt_exp" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_form_exp()"/>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Add"/>  </div>
                <div class="clearfix"></div>
                        <?php echo form_close(); ?>
                    </div>
                    
                </div>
            
                
                <h3 class="res_edt_col_hd" id="tran">
                    <input type="hidden" value="0" id="tran_ck"/>
                    <img src="<?php echo base_url();?>resources/images/skills_icon.png"/>Trainings & Courses
                </h3>
                <div id="trainings">
                    
                    <?php if(!empty($resume_details[0]['trainings'])){
                            $incr=0;
                          echo form_open('resume/edit_train/'.$resume_details[0]['id']);
                        foreach($resume_details[0]['trainings'] as $tran){
                        ?>
                    
                    <div class="text">Course Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="course_nam[]" id="course_nam" value="<?php if($tran['course_name'] != ""){ echo $tran['course_name'];}elseif($this->input->post('course_nam') != ""){ echo $this->input->post('course_nam'); }?>"/></div>
                
                
                <div class="text">Conducted By:</div>
                <div class="field"><input type="hidden" value="<?php echo $tran['id'];?>" name="id[]"/><input type="text" class="inpt_fld" name="con_by[]" id="con_by" value="<?php if($tran['conducted_by'] != ""){ echo $tran['conducted_by'];}elseif($this->input->post('con_by') != ""){ echo $this->input->post('con_by'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Location:</div>
                <div class="field"><input type="hidden" value="<?php echo $resume_details[0]['id'];?>" name="res_id[]"/><input type="text" class="inpt_fld" name="location[]" id="location" value="<?php if($tran['location'] != ""){ echo $tran['location'];}elseif($this->input->post('location') != ""){ echo $this->input->post('location'); }?>"/></div>
                
                
                <div class="text">Date:</div>
                <div class="field"><input type="text" class="inpt_fld" name="con_date[]" id="con_date<?php echo $incr;?>" value="<?php if($tran['date'] != ""){ echo $tran['date'];}elseif($this->input->post('con_date') != ""){ echo $this->input->post('con_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="del_adeed"><a href="<?php echo base_url().'index.php/resume/delete_train/'.$resume_details[0]['id'].'/'.$tran['id'];?>"> <img src="<?php echo base_url().'resources/images/delete_edit_icon.png'?>"/> </a></div>
                    <script>
                     var inc = <?php echo $incr;?>;
                $('#con_date'+inc).Zebra_DatePicker();
                    </script>
                    <?php $incr++; }
                    echo '<div class="text"></div>';
                    echo '<div class="field"><input type="submit" name="submit" value="Update"/></div>';
                    echo '<div class="clearfix"></div>';
                            echo form_close();
                } ?>
                    <div class="add_new_icn" id="add_train_icn">
                        <img src="<?php echo base_url().'resources/images/plus_sign.png'?>"/> Add New Training
                    </div>
                    
                   
                    <div id="add_tran_frm">
                        
                        <?php echo form_open('resume/edit_resume5/'.$resume_details[0]['id']);?>
                        
                        <div id="check_train">
                <div class="text">Course Name:</div>
                <div class="field"><input type="hidden" value="0" id="indexi_train"/><input type="text" class="inpt_fld" name="course_nam[]" id="course_nam" value="<?php if($this->input->post('course_nam') != ""){ echo $this->input->post('course_nam'); }?>"/></div>
                
                
                <div class="text">Conducted By:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $resume_details[0]['id'];?>"/><input type="text" class="inpt_fld" name="con_by[]" id="con_by" value="<?php if($this->input->post('con_by') != ""){ echo $this->input->post('con_by'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location[]" id="location" value="<?php if($this->input->post('location') != ""){ echo $this->input->post('location'); }?>"/></div>
                
                </div>
                
                <div class="text">Date:</div>
                <div class="field"><input type="text" class="inpt_fld" name="con_date[]" id="con_date_train0" value="<?php if($this->input->post('con_date') != ""){ echo $this->input->post('con_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div id="add_moretrain"></div>
                
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more_train()"/>
                <img id="rem_bt_train" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_form_train()"/>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" value="add"/> </div>
                <div class="clearfix"></div>
                
                <?php echo form_close();?>
                
                    </div>
                </div>
                
                <h3 class="res_edt_col_hd" id="awrd">
                    <input type="hidden" value="0" id="awrd_ck"/>
                    <img src="<?php echo base_url();?>resources/images/awards_icon.png"/>Awards & Achievements
                </h3>
                <div id="awards">
                    
                    <?php if(!empty($resume_details[0]['achievements'])){
                        $incr=0;
                        echo form_open('resume/edit_achiev/'.$resume_details[0]['id']);
                        foreach ($resume_details[0]['achievements'] as $ach){?>
                    
                    <div class="text">Description:</div>
                <div class="field"><input type="hidden" value="<?php echo $ach['id'];?>" name="id[]"/><input type="text" class="inpt_fld" name="desc[]" id="desc" value="<?php if($ach['description'] != ""){ echo $ach['description'];}elseif($this->input->post('desc') != ""){ echo $this->input->post('desc');}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Location:</div>
                <div class="field"><input type="hidden" value="<?php echo $res_id;?>" name="res_id[]"/><input type="text" class="inpt_fld" name="location[]" id="location" value="<?php if($ach['location'] != ""){ echo $ach['location'];}elseif($this->input->post('location') != ""){ echo $this->input->post('location');}?>"/></div>
                
                
                
                <div class="text">Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="ach_date[]" id="ach_date<?php echo $incr;?>" value="<?php if($ach['ach_date'] != ""){ echo $ach['ach_date'];}elseif($this->input->post('ach_date') != ""){ echo $this->input->post('ach_date');}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="del_adeed"><a href="<?php echo base_url().'index.php/resume/delete_achiev/'.$resume_details[0]['id'].'/'.$ach['id'];?>"> <img src="<?php echo base_url().'resources/images/delete_edit_icon.png'?>"/> </a></div>
                
                <script>
                     var inc = <?php echo $incr;?>;
                $('#ach_date'+inc).Zebra_DatePicker();
                    </script>
                    
                    <?php $incr++; }
                    echo '<div class="text"></div>';
                    echo '<div class="field"><input type="submit" name="submit" value="Update"/></div>';
                    echo '<div class="clearfix"></div>';
                            echo form_close();
                }?>
                    <div class="add_new_icn" id="add_award_icn">
                        <img src="<?php echo base_url().'resources/images/plus_sign.png'?>"/> Add New Award
                    </div>
                   
                    <div id="add_award_frm">
                        
                        <?php echo form_open('resume/edit_resume6/'.$resume_details[0]['id']);?>
               <div id="check_awards">    
                <div class="text">Description:</div>
                <div class="field"><input type="hidden" value="0" id="indexi_award"/><input type="text" class="inpt_fld" name="desc[]" id="desc"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Location:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $resume_details[0]['id'];?>"/><input type="text" class="inpt_fld" name="location[]" id="location"/></div>
                
                </div>
                
                <div class="text">Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="ach_date[]" id="ach_date_award0"/></div>
                <div class="clearfix"></div>
                
                <div id="add_moreaward"></div>
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more_achiev()"/>
                <img id="rem_bt_award" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_achiev()"/>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Add"/>  </div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                        
                    </div>
                </div>
        
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>
    <div id="zeb_scr"></div>
<script>
    
    function validateForm() {
    var x = $('#fname').val();
    if (x == null || x == "") {
       var fnam =  "First name must be filled out";
        $('#fnami').html(fnam);
        return false;
    }
    else{
        fnam = "";
         $('#fnami').html(fnam);   
        
    }
}
    
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
    


    
    $("#acad").click(function(){
        var acd_ck = $('#acad_ck').val();
        if(acd_ck == 0)
        {
            $("#academics").css('display','block');
            $('#acad_ck').val(1);
        }
        else
        {
            $("#academics").css('display','none');
            $('#acad_ck').val(0);
        }
    });
    
    $("#wrk").click(function(){
       var wr_ck =  $('#wrk_ck').val();
       if(wr_ck == 0)
        {
            $("#experiances").css('display','block');
            $('#wrk_ck').val(1);
        }
        else
        {
            $("#experiances").css('display','none');
            $('#wrk_ck').val(0);
        }
        
      });
    
    $("#tran").click(function(){
        var ck = $('#tran_ck').val();
        if(ck == 0)
        {
            $("#trainings").css('display','block');
            $('#tran_ck').val(1);
        }
        else
        {
            $("#trainings").css('display','none');
            $('#tran_ck').val(0);
        }
      });
      
    $("#awrd").click(function(){
        var ck = $('#awrd_ck').val();
        if(ck == 0)
        {
            $("#awards").css('display','block');
            $('#awrd_ck').val(1);
        }
        else
        {
            $("#awards").css('display','none');
            $('#awrd_ck').val(0);
        }
      });
      
      
      $("#edu_ad_icn").click(function(){
          $("#edu_ad_icn").css('display','none');
          $("#add_edu_frm").css('display','block');
      });
       
      function add_more_edu()
    {
        var indx = $('#indexi_edu').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi_edu').val(indexo);
        var sep = '<div class="clearfix"></div>';
        var frm = $('#create_edu').html();
        var tar = ''; //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Start Date:</div><div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date_edu'+ indexo +'" required=""/></div>';
         strt += '<div class="text">Completion Date:</div><div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date_edu'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#strt_date_edu'+ indexo +'").Zebra_DatePicker();';
        scr += '$("#end_date_edu'+ indexo +'").Zebra_DatePicker();';
        
        var tex = "";
        tex += '<script>tinymce.init({selector: "textarea",  browser_spellcheck : true,auto_focus: "elm1",width: 600});<';
        tex += '/script>';
        
        tar += '<div class="text">Major Subjects:</div><div class="field"><textarea name="maj_sub[]" id="maj_sub_edu'+ indexo +'"></textarea></div><div class="clearfix"></div>';
        
        var dv = '<div class="frm_edu'+ indexo +'">';
        var dvv = '</div>';
        
        $('#add_moreedu').append(dv + frm + strt + tex + tar + dvv+ sep );
        $('#zeb_scr').append(scr);
        $('#rem_bt_edu').css('display','block');
    }
    
    function remove_form()
    {
        var indx = $('#indexi_edu').val();
        var indexo = "";
        if(indx != 0){
        indexo = parseInt(indx) - 1;
        $('#indexi_edu').val(indexo);
            if(indexo == 0){
                $('#rem_bt_edu').css('display','none');
            }
    }
     $('.frm_edu'+ indx).remove();
    }
    
    
    
    
    $("#add_exp_icn").click(function(){
          $("#add_exp_icn").css('display','none');
          $("#add_exp_frm").css('display','block');
      });
      
      function add_more_exp()
    {
        var indx = $('#indexi_exp').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi_exp').val(indexo);
        var sep = '<div class="clearfix"></div>';
        var frm = $('#create_exp').html();
        var tar = ''; //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Start Date:</div><div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date_exp'+ indexo +'" required=""/></div>';
         strt += '<div class="text">End Date:</div><div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date_exp'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#strt_date_exp'+ indexo +'").Zebra_DatePicker();';
        scr += '$("#end_date_exp'+ indexo +'").Zebra_DatePicker();';
        
        var tex = "";
        tex += '<script>tinymce.init({selector: "textarea",  browser_spellcheck : true,auto_focus: "elm1",width: 600});<';
        tex += '/script>';
        
        tar += '<div class="text">Job Responsibilities:</div><div class="field"><textarea name="responsiblty[]" id="responsiblty_exp'+ indexo +'"></textarea></div><div class="clearfix"></div>';
        //var flsi = 
        var dv = '<div class="frm_exp'+ indexo +'">';
        var dvv = '</div>';
        
        $('#add_moreexp').append(dv  + frm + strt + tex +tar + dvv + sep);
        $('#zeb_scr').append(scr);
        $('#rem_bt_exp').css('display','block');
    }
    
    function remove_form_exp()
    {
        var indx = $('#indexi_exp').val();
        var indexo = parseInt(indx) - 1;
        $('#indexi_exp').val(indexo);
        if(indexo == 0){
                $('#rem_bt_exp').css('display','none');
            }
        $('.frm_exp'+ indx).remove();
    }
    
    
      
      $("#add_award_icn").click(function(){
          $("#add_award_icn").css('display','none');
          $("#add_award_frm").css('display','block');
      });
      
      function add_more_achiev()
    {
        var indx = $('#indexi_award').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi_award').val(indexo);
        var sep = '<div class="clearfix"></div>';
        var frm = $('#check_awards').html();
         //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Date:</div><div class="field"><input class="inpt_fld" type="text" name="ach_date[]" id="ach_date_award'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#ach_date_award'+ indexo +'").Zebra_DatePicker();';
        var dv = '<div class="frmachv_'+ indexo +'">';
        var dvv = '</div>';
        
        $('#add_moreaward').append(dv + sep + frm + strt + dvv);
        $('#zeb_scr').append(scr);
        $('#rem_bt_award').css('display','block');
    }
    
    function remove_achiev()
    {
        var indx = $('#indexi_award').val();
        var indexo = parseInt(indx) - 1;
        $('#indexi_award').val(indexo);
        if(indexo == 0){
                $('#rem_bt_award').css('display','none');
            }
        $('.frmachv_'+ indx).remove();
    }
    
     
      
      $("#add_train_icn").click(function(){
          $("#add_train_icn").css('display','none');
          $("#add_tran_frm").css('display','block');
      });
      
      function add_more_train()
    {
        var indx = $('#indexi_train').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi_train').val(indexo);
        var sep = '<div class="clearfix"></div>';
        var frm = $('#check_train').html();
        var tar = ''; //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Date:</div><div class="field"><input class="inpt_fld" type="text" name="con_date[]" id="con_date_train'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#con_date_train'+ indexo +'").Zebra_DatePicker();';
        
        var dv = '<div class="frm_'+ indexo +'">';
        var dvv = '</div>';
        
        $('#add_moretrain').append(dv  + frm + strt + dvv + sep);
        $('#zeb_scr').append(scr);
        $('#rem_bt_train').css('display','block');
    }
    
    function remove_form_train()
    {
        var indx = $('#indexi_train').val();
        var indexo = parseInt(indx) - 1;
        $('#indexi_train').val(indexo);
        if(indexo == 0){
                $('#rem_bt_train').css('display','none');
            }
        $('.frm_'+ indx).remove();
    }
      
    $(document).ready(function() {

    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $('#available').Zebra_DatePicker();
    $('#dob').Zebra_DatePicker();
    $("#strt_date_edu0").Zebra_DatePicker();
    $("#end_date_edu0").Zebra_DatePicker();
    
    $("#strt_date_exp0").Zebra_DatePicker();
    $("#end_date_exp0").Zebra_DatePicker();
    $("#ach_date_award0").Zebra_DatePicker();
    $("#con_date_train0").Zebra_DatePicker();
 });
    </script>
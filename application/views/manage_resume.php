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
            <div class="frm_icons">
                <label class="ic_one"> <img width="100px" height="100px" onClick="uploadd()" src="<?php echo base_url();?>resources/images/upload_cv.png"/></br>Upload Resume</label>
                <label class="ic_two"> <img width="100px" height="100px" onClick="createe()" src="<?php echo base_url();?>resources/images/create_cv.png"/></br>Create Resume</label>
            </div>
            <div class="clearfix"></div>
            <div id="cv_upl" style="display: none;">
                <?php echo form_open_multipart('resume/resume_upload');?>
                <h2>Upload Your Resume</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
                
                <div class="text">Upload Resume:</div>
                <div class="field"><input type="file" class="inpt_fld" name="userfile1" required /></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" id="upl_sub" name="submit" value="Save"/></div>
                <div class="clearfix"></div>
                
                <?php echo form_close();?>
                
            </div>
            
            <div id="create_cv">
            <?php echo form_open('resume/index');?>
            <h2>Create Resume Step 1 of 5</h2>
            
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
            
            <h3>Personal details</h3>
                <div class="clearfix"></div>
            
                <div class="text">First Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="fname" id="fname" required value="<?php if($this->input->post('fname') != ""){ echo $this->input->post('fname'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Last Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="lname" id="lname" value="<?php if($this->input->post('lname') != ""){ echo $this->input->post('lname'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Father Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="father_name" id="father_name" value="<?php if($this->input->post('father_name') != ""){ echo $this->input->post('father_name'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Gender:</div>
                <div class="field"><select  class="inpt_fld" name="gender" id="gender">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?php if($this->input->post('gender')=='Male'){ echo 'selected';}?>>Male</option>
                <option value="Female" <?php if($this->input->post('gender')=='Female'){ echo 'selected';}?>>Female</option>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Marital Status:</div>
                 <div class="field"><select class="inpt_fld" name="m_status" id="m_status">
                        <option value="">-- Please Select --</option>
                        <option value="Single" <?php if($this->input->post('m_status')=='Single'){ echo 'selected';}?>>Single</option>
                        <option value="Married" <?php if($this->input->post('m_status')=='Married'){ echo 'selected';}?>>Married</option>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">CNIC #:</div>
                <div class="field"><input type="text" class="inpt_fld" name="cnic" id="cnic" value="<?php if($this->input->post('cnic') != ""){ echo $this->input->post('cnic'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Profession Category:</div>
                <div class="field"><select class="inpt_fld" name="pro_cat" id="pro_cat">
                        <option value="">--Select Category--</option>
                        <?php foreach($categories as $cat){?>
                        <option value="<?php echo $cat['id'];?>" <?php if($this->input->post('pro_cat')==$cat['id']){ echo 'selected';}?> > <?php echo $cat['property_category_name'];?> </option>
                        <?php } ?>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Email:</div>
                <div class="field"><input type="email" class="inpt_fld" name="email" id="email" required value="<?php if($this->input->post('email') != ""){ echo $this->input->post('email'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Phone#:</div>
                <div class="field"><input type="tel" class="inpt_fld" name="phone" id="phone" required value="<?php if($this->input->post('phone') != ""){ echo $this->input->post('phone'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Address:</div>
                <div class="field"><input type="text" class="inpt_fld" name="adres" id="adres" value="<?php if($this->input->post('adres') != ""){ echo $this->input->post('adres'); }?>"/></div>
                <div class="clearfix"></div>

                <div class="text">Objectives:</div>
                <div class="field"><textarea name="objectives" id="objectives"><?php if($this->input->post('objectives') != ""){ echo $this->input->post('objectives'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Date of Birth:</div>
                <div class="field"><input class="inpt_fld" type="text" name="dob" id="dob" value="<?php if($this->input->post('dob') != ""){ echo $this->input->post('dob'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Current Salary:</div>
                <div class="field"><input class="inpt_fld" type="text" name="salary" id="salary" value="<?php if($this->input->post('salary') != ""){ echo $this->input->post('salary'); }?>"/> PKR</div>
                <div class="clearfix"></div>
                
                <div class="text">Expected Salary:</div>
                <div class="field"><input class="inpt_fld" type="text" name="exp_sal" id="exp_sal" value="<?php if($this->input->post('exp_sal') != ""){ echo $this->input->post('exp_sal'); }?>"/> PKR</div>
                <div class="clearfix"></div>
                
                <h3>Availability</h3>
                <div class="clearfix"></div>
                <div class="text">Available From:</div>
                <div class="field"><input class="inpt_fld" type="text" name="available" id="available" value="<?php if($this->input->post('available') != ""){ echo $this->input->post('available'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Proceed to Next Step"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                
        </div>
	</div>

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
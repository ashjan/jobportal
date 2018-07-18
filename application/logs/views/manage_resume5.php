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
            
            <div id="create">
            <?php echo form_open('resume/step_five');?>
            <h2>Create Resume Step 5 of 5</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
            
             <h3>Courses/Trainings/Workshops</h3>
                <div class="clearfix"></div>
                <div id="trainings">
                <div class="text">Course Name:</div>
                <div class="field"><input type="hidden" value="0" id="indexi"/><input type="text" class="inpt_fld" name="course_nam[]" id="course_nam" value="<?php if($this->input->post('course_nam') != ""){ echo $this->input->post('course_nam'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Conducted By:</div>
                <div class="field"><input type="text" class="inpt_fld" name="con_by[]" id="con_by" value="<?php if($this->input->post('con_by') != ""){ echo $this->input->post('con_by'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location[]" id="location" value="<?php if($this->input->post('location') != ""){ echo $this->input->post('location'); }?>"/></div>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Date:</div>
                <div class="field"><input type="text" class="inpt_fld" name="con_date[]" id="con_date" value="<?php if($this->input->post('con_date') != ""){ echo $this->input->post('con_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div id="more"></div>
                
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more()"/>
                <img id="rem_bt" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_form()"/>
                <div class="clearfix"></div>
                
            <h3>Business Skills</h3>
                <div class="clearfix"></div>
            
                <div class="text">Title:</div>
                <div class="field"><input type="hidden" value="<?php echo $id;?>" name="id"/><input type="text" class="inpt_fld" name="bus_title" id="bus_title" required="" value="<?php if($this->input->post('bus_title') != ""){ echo $this->input->post('bus_title'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Business Skills:</div>
                <div class="field"><textarea name="buss_skill" id="buss_skill"><?php if($this->input->post('buss_skill') != ""){ echo $this->input->post('buss_skill'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <h3>Other Skills</h3>
                <div class="clearfix"></div>
            
                <div class="text">Language Skills:</div>
                <div class="field"><textarea name="lang_skill" id="lang_skill"><?php if($this->input->post('lang_skill') != ""){ echo $this->input->post('lang_skill'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">Computer Skills:</div>
                <div class="field"><textarea name="comp_skill" id="comp_skill"><?php if($this->input->post('comp_skill') != ""){ echo $this->input->post('comp_skill'); }?></textarea></div>
                <div class="clearfix"></div>
                
                <div class="text">References:</div>
                <div class="field"><textarea name="refrence" id="refrence"><?php if($this->input->post('refrence') != ""){ echo $this->input->post('refrence'); }?></textarea></div>
                <div class="clearfix"></div>
                
                
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Save"/> <a class="skp_bt" href="<?php echo base_url();?>index.php/resume/resume_details/<?php echo $id;?>"><input class="skp_btn" type="button" name="skip" value="Skip This Step"/></a></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                
        </div>
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>`
<script>
     function add_more()
    {
        var indx = $('#indexi').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi').val(indexo);
        var sep = '<div class="separator"></div>';
        var frm = $('#trainings').html();
        var tar = ''; //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Date:</div><div class="field"><input class="inpt_fld" type="text" name="con_date[]" id="con_date_'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#con_date_'+ indexo +'").Zebra_DatePicker();';
        
        var dv = '<div class="frm_'+ indexo +'">';
        var dvv = '</div>';
        
        $('#more').append(dv + sep + frm + strt + dvv);
        $('#zeb_scr').append(scr);
        $('#rem_bt').css('display','block');
    }
    
    function remove_form()
    {
        var indx = $('#indexi').val();
        var indexo = parseInt(indx) - 1;
        $('#indexi').val(indexo);
        if(indexo == 0){
                $('#rem_bt').css('display','none');
            }
        $('.frm_'+ indx).remove();
    }
    
    $('#con_date').Zebra_DatePicker();
</script>
<div id="zeb_scr"></div>
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
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Personal Info</label>
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume3/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Academics</label>
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume4/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Experiences</label>
                <label class="ic_one"> <a href="<?php echo $url.'/resume/edit_resume5/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Trainings</label>
                
            </div>
            <div class="clearfix"></div>
            
            <?php if(!empty($resume_details) && !empty($resume_details[0]['education_details'])){?>
            <h3 class="heading_sb">Educational Details</h3>
            <div class="dtls">
                <?php foreach($resume_details[0]['education_details'] as $res){
                    echo '<h4>'.$res['title'];
                if($res['grade'] != "")
                {
                    echo '('.$res['grade'].')';
                }
                    echo '<div class="period">'; if($res['start_date'] != ""){ echo date("jS F Y",strtotime($res['start_date']));} if($res['start_date'] != "" && $res['end_date'] != ""){echo ' to ';} if($res['end_date'] != ""){ echo date("jS F Y",strtotime($res['end_date'])); } echo '</div></h4>';
                    echo 'at '.$res['institute'];
                    echo '<br hidefocus="true" style="outline: medium none;">';
                    echo '<a href="'.$url.'/resume/edit_edu/'.$res['id'].'">Edit</a> | <a href="'.$url.'/resume/delete_edu/'.$res['id'].'">Delete</a>';
                }
?>
            </div>
                <?php } ?>
            
            <div class="separator"></div>
            
                <h2>Edit Academic Record</h2>
            <?php echo form_open('resume/edit_edu/'.$res_id.'/'.$id);?>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
            <h3>Education History</h3>
                <div class="clearfix"></div>
                <div id="create">
                <div class="text">Degree Title:</div>
                <div class="field"><input type="hidden" value="0" id="indexi"/><input type="text" class="inpt_fld" name="deg_ttl" id="deg_ttl" required="" value="<?php if(!empty($education)){ echo $education[0]['title'];}elseif($this->input->post('deg_ttl') != ""){ echo $this->input->post('deg_ttl'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">University/Board:</div>
                <div class="field"><input type="hidden" name="res_id" value="<?php echo $res_id;?>"/><input type="text" class="inpt_fld" name="ins_name" id="ins_name" value="<?php if(!empty($education)){ echo $education[0]['institute'];}elseif($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">CGPA/Grade:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input type="text" class="inpt_fld" name="grade" id="grade" value="<?php if(!empty($education)){ echo $education[0]['grade'];}elseif($this->input->post('grade') != ""){ echo $this->input->post('grade'); }?>"/></div>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Start Date:</div>
                        <div class="field"><input class="inpt_fld" type="text" name="strt_date" id="strt_date" value="<?php if(!empty($education)){ echo $education[0]['start_date'];}elseif($this->input->post('strt_date') != ""){ echo $this->input->post('strt_date'); }?>"/></div>
                <div class="clearfix"></div>
            
                <div class="text">Completion Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date" id="end_date" value="<?php if(!empty($education)){ echo $education[0]['end_date'];}elseif($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div id="tar">
                <div class="text">Major Subjects:</div>
                <div class="field"><textarea name="maj_sub" id="maj_sub"><?php if(!empty($education)){ echo $education[0]['maj_subjects'];}elseif($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?></textarea></div>
                <div class="clearfix"></div>
                </div>
                
                
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Update"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                
        
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>`

<script>
    
    $('#start_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
    
    </script>

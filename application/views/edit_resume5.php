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
                <label class="ic_one"> <a href="<?php echo $url.'resume/edit_resume/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Personal Info</label>
                <label class="ic_one"> <a href="<?php echo $url.'resume/edit_resume3/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Academics</label>
                <label class="ic_one"> <a href="<?php echo $url.'resume/edit_resume4/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Experiences</label>
                <label class="ic_one"> <a href="<?php echo $url.'resume/edit_resume5/'.$res_id;?>"><img width="100px" height="100px" src="<?php echo base_url();?>resources/images/create_cv.png"/></a></br>Trainings</label>
                
            </div>
            <div class="clearfix"></div>
            
            
            <?php if(!empty($resume_details[0]['trainings'])){?>
            <h3 class="heading_sb">Trainings & Courses</h3>
            <div class="dtls">
                <?php foreach($resume_details[0]['trainings'] as $tran){
                    echo '<h4>'.$tran['course_name'].'<div class="period">';if($tran['date'] != ""){ echo date("jS F Y",strtotime($tran['date']));} echo '</div></h4>';
                    if($tran['conducted_by'] != ""){ echo '<strong>Conducted By: </strong>'.$tran['conducted_by'];} if($tran['location'] != ""){ echo '<strong> In: </strong>'.$tran['location']; }
                     echo '<br hidefocus="true" style="outline: medium none;">';
                    echo '<a href="'.$url.'resume/edit_train/'.$id.'/'.$tran['id'].'">Edit</a> | <a href="'.$url.'resume/delete_train/'.$id.'/'.$tran['id'].'">Delete</a>';
                }
?>
            </div>
            <?php } ?>
            
            <div class="separator"></div>
            
            <div id="create">
            <?php echo form_open('resume/edit_resume5/'.$id);?>
            <h2>Add Trainings & Courses</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
            
             <h3>Courses/Trainings/Workshops</h3>
                <div class="clearfix"></div>
                <div id="trainings">
                <div class="text">Course Name:</div>
                <div class="field"><input type="hidden" value="0" id="indexi"/><input type="text" class="inpt_fld" name="course_nam" id="course_nam" value="<?php if($this->input->post('course_nam') != ""){ echo $this->input->post('course_nam'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Conducted By:</div>
                <div class="field"><input type="hidden" value="<?php echo $id;?>" name="id"/><input type="text" class="inpt_fld" name="con_by" id="con_by" value="<?php if($this->input->post('con_by') != ""){ echo $this->input->post('con_by'); }?>"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location" id="location" value="<?php if($this->input->post('location') != ""){ echo $this->input->post('location'); }?>"/></div>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Date:</div>
                <div class="field"><input type="text" class="inpt_fld" name="con_date" id="con_date" value="<?php if($this->input->post('con_date') != ""){ echo $this->input->post('con_date'); }?>"/></div>
                <div class="clearfix"></div>
                
            
                
                
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Save"/></div>
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
        strt += '<div class="text">Date:</div><div class="field"><input style="width: 250px;" type="text" name="con_date[]" id="con_date_'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#con_date_'+ indexo +'").Zebra_DatePicker();';
        
        
        $('#more').append(sep + frm + strt);
        $('#zeb_scr').append(scr);
    }
    
    $('#con_date').Zebra_DatePicker();
</script>
<div id="zeb_scr"></div>
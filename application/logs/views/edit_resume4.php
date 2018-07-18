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
            <h3 class="heading_sb">Work History</h3>
            <div class="dtls">
                <?php foreach($resume_details[0]['work_details'] as $res){
                   echo '<h4>'.$res['designation'].'<div class="period">'; if($res['start_date'] != ""){ echo date("jS F Y",strtotime($res['start_date']));} if($res['end_date'] != "" && $res['start_date'] != ""){ echo ' to '; } if($res['end_date'] != ""){ echo date("jS F Y",strtotime($res['end_date']));} echo '</div></h4>';
                    echo stripslashes($res['job_responsibilities']);
                    echo '<br hidefocus="true" style="outline: medium none;">';
                    echo '<a href="'.$url.'/resume/edit_work/'.$res_id.'/'.$res['id'].'">Edit</a> | <a href="'.$url.'/resume/delete_work/'.$res_id.'/'.$res['id'].'">Delete</a>';
                }
?>
            </div>
                <?php } 
                  if(!empty($resume_details[0]['achievements'])){?>
            <h3 class="heading_sb">Key Achievements</h3>
            <div class="dtls">
                <?php foreach($resume_details[0]['achievements'] as $ach){
                    echo '<h4>'.$ach['description'].'<div class="period">'; if($ach['ach_date'] != ""){ echo date("jS F Y",strtotime($ach['ach_date']));} echo '</div></h4>';
                if($ach['location'] != ""){ echo '<strong>at: </strong>'.$ach['location'];}
                     echo '<br hidefocus="true" style="outline: medium none;">';
                    echo '<a href="'.$url.'/resume/edit_achiev/'.$res_id.'/'.$ach['id'].'">Edit</a> | <a href="'.$url.'/resume/delete_achiev/'.$res_id.'/'.$ach['id'].'">Delete</a>';
                }
?>
            </div>
            <?php } ?>
            
            <div class="separator"></div>
            
                <h2>Add Work Details</h2>
            <?php echo form_open('resume/edit_resume4/'.$res_id);?>
            
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
                <div id="create">
            <h3>Work History</h3>
                <div class="clearfix"></div>
            
                <div class="text">Designation:</div>
                <div class="field"><input type="hidden" id="indexi" value="0"/><input type="text" class="inpt_fld" name="desig" id="desig" value="<?php if($this->input->post('desig') != ""){ echo $this->input->post('desig'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Company:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input type="text" class="inpt_fld" name="cmpny" id="cmpny" value="<?php if($this->input->post('cmpny') != ""){ echo $this->input->post('cmpny'); }?>"/></div>
                <div class="clearfix"></div>
                
                <h3>Duration</h3>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Start Date:</div>
                <div class="field"><input type="hidden" name="res_id" value="<?php echo $res_id;?>"/><input class="inpt_fld" type="text" name="strt_date" id="strt_date" value="<?php if(!empty($work)){ echo $work[0]['start_date'];}elseif($this->input->post('start_date') != ""){ echo $this->input->post('start_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">End Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date" id="end_date" value="<?php if($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Responsibilities:</div>
                <div class="field"><textarea name="responsiblty" id="responsiblty"><?php if($this->input->post('responsiblty') != ""){ echo $this->input->post('responsiblty'); }?></textarea></div>
                <div class="clearfix"></div>
                
                
                
                <div class="separator"></div>
                
                <div id="achievments">
            <h3>Key Achievements</h3>
                <div class="clearfix"></div>
                
                <div class="text">Description:</div>
                <div class="field"><input type="text" class="inpt_fld" name="desc" id="desc" value="<?php if($this->input->post('desc') != ""){ echo $this->input->post('desc'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location" id="location" value="<?php if($this->input->post('location') != ""){ echo $this->input->post('location'); }?>"/></div>
                <div class="clearfix"></div>
                
                </div>
                
                <div class="text">Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="ach_date" id="ach_date" value="<?php if($this->input->post('ach_date') != ""){ echo $this->input->post('ach_date'); }?>"/></div>
                <div class="clearfix"></div>
                
<!--                <div id="add_achiev"></div>
                
                <img src="<?php echo base_url();?>resources/images/add.png" onclick="add_more_achiev()"/>-->
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Save"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                
        
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
        var frm = $('#create').html();
        var tar = ''; //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Start Date:</div><div class="field"><input style="width: 250px;" type="text" name="strt_date[]" id="strt_date_'+ indexo +'"/></div><div class="clearfix"></div>';
         strt += '<div class="text">End Date:</div><div class="field"><input style="width: 250px;" type="text" name="end_date[]" id="end_date_'+ indexo +'"/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#strt_date_'+ indexo +'").Zebra_DatePicker();';
        scr += '$("#end_date_'+ indexo +'").Zebra_DatePicker();';
        
        var tex = "";
        tex += '<script>tinymce.init({selector: "textarea",  browser_spellcheck : true,auto_focus: "elm1",width: 600});<';
        tex += '/script>';
        
        tar += '<div class="text">Job Responsibilities:</div><div class="field"><textarea name="responsiblty[]" id="responsiblty_'+ indexo +'"></textarea></div><div class="clearfix"></div>';
        //var flsi = 
        $('#more').append(sep + frm + strt + tex +tar);
        $('#zeb_scr').append(scr);
    }
    
    function add_more_achiev()
    {
        var indx = $('#indexi').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi').val(indexo);
        var sep = '<div class="separator"></div>';
        var frm = $('#achievments').html();
         //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Date:</div><div class="field"><input style="width: 250px;" type="text" name="ach_date[]" id="ach_date'+ indexo +'"/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#ach_date'+ indexo +'").Zebra_DatePicker();';
        
        
        $('#add_achiev').append(sep + frm + strt);
        $('#zeb_scr').append(scr);
    }
    
    $('#ach_date').Zebra_DatePicker();
    
    $('#strt_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
</script>
<div id="zeb_scr"></div>
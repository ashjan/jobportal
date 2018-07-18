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
                    echo '<a href="'.$url.'/resume/edit_edu/'.$id.'/'.$res['id'].'">Edit</a> | <a href="'.$url.'/resume/delete_edu/'.$id.'/'.$res['id'].'">Delete</a>';
                }
?>
            </div>
                <?php } ?>
            
            <div class="separator"></div>
            
                <h2>Add a New Academic Record</h2>
            <?php echo form_open('resume/edit_resume3/'.$id);?>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
            <h3>Education History</h3>
                <div class="clearfix"></div>
                <div id="create">
                <div class="text">Degree Title:</div>
                <div class="field"><input type="hidden" value="0" id="indexi"/><input type="text" class="inpt_fld" name="deg_ttl[]" id="deg_ttl" required="" value="<?php if($this->input->post('deg_ttl') != ""){ echo $this->input->post('deg_ttl'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">University/Board:</div>
                <div class="field"><input type="text" class="inpt_fld" name="ins_name[]" id="ins_name" required="" value="<?php if($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">CGPA/Grade:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input type="text" class="inpt_fld" name="grade[]" id="grade" value="<?php if($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Start Date:</div>
                        <div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date" required="" value="<?php if($this->input->post('strt_date') != ""){ echo $this->input->post('strt_date'); }?>"/></div>
                <div class="clearfix"></div>
            
                <div class="text">Completion Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date" required="" value="<?php if($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div id="tar">
                <div class="text">Major Subjects:</div>
                <div class="field"><textarea name="maj_sub[]" id="maj_sub"></textarea></div>
                <div class="clearfix"></div>
                </div>
                
                
                
                <div id="more"></div>
                
                
                <img src="<?php echo base_url();?>resources/images/add.png" onclick="add_more()"/>
                
                
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
        strt += '<div class="text">Start Date:</div><div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date_'+ indexo +'" required=""/></div><div class="clearfix"></div>';
         strt += '<div class="text">Completion Date:</div><div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date_'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#strt_date_'+ indexo +'").Zebra_DatePicker();';
        scr += '$("#end_date_'+ indexo +'").Zebra_DatePicker();';
        
        var tex = "";
        tex += '<script>tinymce.init({selector: "textarea",  browser_spellcheck : true,auto_focus: "elm1",width: 600});<';
        tex += '/script>';
        
        tar += '<div class="text">Major Subjects:</div><div class="field"><textarea name="maj_sub[]" id="maj_sub_'+ indexo +'"></textarea></div><div class="clearfix"></div>';
        //var flsi = 
        $('#more').append(sep + frm + strt + tex +tar);
        $('#zeb_scr').append(scr);
    }
    
    $('#strt_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
</script>
<div id="zeb_scr"></div>
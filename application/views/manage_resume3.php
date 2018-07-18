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
            
            
                <h2>Create Resume Step 3 of 5</h2>
            <?php echo form_open('resume/step_three');?>
            
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
            
            <h3>Education History</h3>
                <div class="clearfix"></div>
                <div id="create">
                <div class="text">Degree Title:</div>
                <div class="field"><input type="hidden" value="0" id="indexi"/><input type="text" class="inpt_fld" name="deg_ttl[]" id="deg_ttl" required="" value="<?php if($this->input->post('deg_ttl') != ""){ echo $this->input->post('deg_ttl'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">University/Board:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input type="text" class="inpt_fld" name="ins_name[]" id="ins_name" required="" value="<?php if($this->input->post('ins_name') != ""){ echo $this->input->post('ins_name'); }?>"/></div>
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
                
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more()"/>
                
                <img id="rem_bt" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_form()"/>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Save"/> <a class="skp_bt" href="<?php echo base_url();?>resume/step_four/<?php echo $id;?>"><input class="skp_btn" type="button" name="skip" value="Skip This Step"/></a></div>
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
        
        var dv = '<div class="frm_'+ indexo +'">';
        var dvv = '</div>';
        
        $('#more').append(dv + sep + frm + strt + tex + tar + dvv);
        $('#zeb_scr').append(scr);
        $('#rem_bt').css('display','block');
    }
    
    function remove_form()
    {
        var indx = $('#indexi').val();
        var indexo = "";
        if(indx != 0){
        indexo = parseInt(indx) - 1;
        $('#indexi').val(indexo);
            if(indexo == 0){
                $('#rem_bt').css('display','none');
            }
    }
    
        
    
        $('.frm_'+ indx).remove();
    }
    
    
    $('#strt_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
</script>
<div id="zeb_scr"></div>
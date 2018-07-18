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
            
            
                <h2>Create Resume Step 4 of 5</h2>
            <?php echo form_open('resume/step_four');?>
            
            
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
            
                <div id="create">
            <h3>Work History</h3>
                <div class="clearfix"></div>
            
                <div class="text">Designation:</div>
                <div class="field"><input type="hidden" id="indexi" value="0"/><input type="text" class="inpt_fld" name="desig[]" id="desig" required="" value="<?php if($this->input->post('desig') != ""){ echo $this->input->post('desig'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Company:</div>
                <div class="field"><input type="hidden" name="id" value="<?php echo $id;?>"/><input type="text" class="inpt_fld" name="cmpny[]" id="cmpny" required="" value="<?php if($this->input->post('cmpny') != ""){ echo $this->input->post('cmpny'); }?>"/></div>
                <div class="clearfix"></div>
                
                <h3>Duration</h3>
                <div class="clearfix"></div>
                </div>
                
                <div class="text">Start Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="strt_date[]" id="strt_date" required="" value="<?php if($this->input->post('start_date') != ""){ echo $this->input->post('start_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">End Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date" required="" value="<?php if($this->input->post('end_date') != ""){ echo $this->input->post('end_date'); }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Job Responsibilities:</div>
                <div class="field"><textarea name="responsiblty[]" id="responsiblty"></textarea></div>
                <div class="clearfix"></div>
                
                <div id="more"></div>
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more()"/>
                <img id="rem_bt" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_form()"/>
                <div class="clearfix"></div>
                <div class="separator"></div>
                
                <div id="achievments">
            <h3>Key Achievements</h3>
                <div class="clearfix"></div>
                
                <div class="text">Description:</div>
                <div class="field"><input type="text" class="inpt_fld" name="desc[]" id="desc"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location[]" id="location"/></div>
                <div class="clearfix"></div>
                
                </div>
                
                <div class="text">Date:</div>
                <div class="field"><input class="inpt_fld" type="text" name="ach_date[]" id="ach_date"/></div>
                <div class="clearfix"></div>
                
                <div id="add_achiev"></div>
                
                <img class="add_icn" src="<?php echo base_url();?>resources/images/add.png" onclick="add_more_achiev()"/>
                <img id="rem_btt" style="display: none;" src="<?php echo base_url();?>resources/images/Delete-icon.png" width="20px" height="20px" onclick="remove_achiev()"/>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Save"/> <a class="skp_bt" href="<?php echo base_url();?>resume/step_five/<?php echo $id;?>"><input class="skp_btn" type="button" name="skip" value="Skip This Step"/></a></div>
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
         strt += '<div class="text">End Date:</div><div class="field"><input class="inpt_fld" type="text" name="end_date[]" id="end_date_'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#strt_date_'+ indexo +'").Zebra_DatePicker();';
        scr += '$("#end_date_'+ indexo +'").Zebra_DatePicker();';
        
        var tex = "";
        tex += '<script>tinymce.init({selector: "textarea",  browser_spellcheck : true,auto_focus: "elm1",width: 600});<';
        tex += '/script>';
        
        tar += '<div class="text">Job Responsibilities:</div><div class="field"><textarea name="responsiblty[]" id="responsiblty_'+ indexo +'"></textarea></div><div class="clearfix"></div>';
        //var flsi = 
        var dv = '<div class="frm_'+ indexo +'">';
        var dvv = '</div>';
        
        $('#more').append(dv + sep + frm + strt + tex +tar + dvv);
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
    
    function add_more_achiev()
    {
        var indx = $('#indexi').val();
        var indexo = parseInt(indx) + 1;
        $('#indexi').val(indexo);
        var sep = '<div class="separator"></div>';
        var frm = $('#achievments').html();
         //$('#tar').html();
        
        var strt = "";
        strt += '<div class="text">Date:</div><div class="field"><input class="inpt_fld" type="text" name="ach_date[]" id="ach_date'+ indexo +'" required=""/></div><div class="clearfix"></div>';
        
        var scr = "";
        scr += '<script>$("#ach_date'+ indexo +'").Zebra_DatePicker();';
        var dv = '<div class="frmachv_'+ indexo +'">';
        var dvv = '</div>';
        
        $('#add_achiev').append(dv + sep + frm + strt + dvv);
        $('#zeb_scr').append(scr);
        $('#rem_btt').css('display','block');
    }
    
    function remove_achiev()
    {
        var indx = $('#indexi').val();
        var indexo = parseInt(indx) - 1;
        $('#indexi').val(indexo);
        if(indexo == 0){
                $('#rem_btt').css('display','none');
            }
        $('.frmachv_'+ indx).remove();
    }
    
    $('#ach_date').Zebra_DatePicker();
    
    $('#strt_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
</script>
<div id="zeb_scr"></div>
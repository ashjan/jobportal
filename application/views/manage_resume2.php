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
            <?php echo form_open_multipart('resume/step_two_process');?>
            <h2>Create Resume Step 2 of 5</h2>
            
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
            
            <h3>Photos</h3>
                <div class="clearfix"></div>
            
                <div class="text">Upload Photos:</div>
                <div class="field"><input class="inpt_fld" type="file" name="photos[]" multiple=""/><input type="hidden" name="id" value="<?php echo $id;?>"/></div>
                <div class="clearfix"></div>
                
                
                <h3>Video</h3>
                <div class="clearfix"></div>
                <div class="text">Upload Video:</div>
                <div class="field"><input class="inpt_fld" type="file" name="userfile1" id="userfile1"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Save"/>  <a class="skp_bt" href="<?php echo base_url();?>resume/step_three/<?php echo $id;?>"><input type="button" class="skp_btn" name="skip" value="Skip This Step"/></a></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
                
        </div>
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>`
<script>
    function myFunction() {
        var pass1 = document.getElementById("e_password").value;
        var pass2 = document.getElementById("e_password_confirm").value;
        var pwdlen = document.getElementById("e_password").length;
        if (pwdlen < 8) {
            alert("Passwords must be atleast 8 charachters long");
        }
        if (pass1 != pass2 || pwdlen < 8) {
            if (pwdlen < 8) {
                alert("Passwords must be at sleast 8 characters long");
            }

            //alert("Passwords Do not match");
            document.getElementById("e_password").style.borderColor = "#E34234";
            document.getElementById("e_password_confirm").style.borderColor = "#E34234";
            alert("Passwords do not Match!!!");
            return false;
        }
        if (pass1 == pass2) {

            document.getElementById("employer_reg").submit();
            return true;
        }
    }

    function canFunction() {
        var pass1 = document.getElementById("password").value;
        var pass2 = document.getElementById("password_confirm").value;
        var pwdlen = document.getElementById("password").length;

        if (pwdlen < 8) {
            alert("Passwords must be at least 8 characters long");
        }

        if (pass1 != pass2) {
            //alert("Passwords Do not match");
            document.getElementById("password").style.borderColor = "#E34234";
            document.getElementById("password_confirm").style.borderColor = "#E34234";
            alert("Passwords do not Match.");
            return false;
        }


        if (pass1 == pass2) {

            document.getElementById("can_reg").submit();
            return true;
        }
    }


    emailcheck = '<?php echo base_url() . 'ajax/check_email_availablity'; ?>';
    namecheck = '<?php echo base_url() . 'ajax/check_name_availablity'; ?>';


</script>


<script>
    $('#employer').hide();
    $('#option1').change(function() {
        
        
        $('#candidate').css('display','block');
        $('#employer').css('display','none');
       
        $('#inactive_can').css('display','none');
        $('#active_can').css('display','block');
        
        $('#inactive_emp').css('display','block');
        $('#active_emp').css('display','none');
    });
    $('#option2').change(function() {
           // alert('emp');
            $('#candidate').css('display','none');
        $('#employer').css('display','block');
        
        $('#inactive_can').css('display','block');
        $('#active_can').css('display','none');
        
        $('#inactive_emp').css('display','none');
        $('#active_emp').css('display','block');
    });

        profilelink = '<?php echo base_url() . 'company' ?>';

        $.ajax({url: profilelink, type: 'get', success: function(result) {
                //   $("#div1").html(result);
                console.log(result);
                if (result.reply == 1) {
                    var response = '<option value="0">Please Select</option>'
                    obj = result.data;
                    for (i in obj) {
                        response += '<option value="'+obj[i]['company_id']+'">'+obj[i]['company_name']+'</option>';
                    }
                    $('#company').html(response);

                }
                else {
                     $('#company').html('<option value="">'+obj.message+'</option>');
                }
            }});
    $('#chatbox').hide();
</script>
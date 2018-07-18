<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/divbraries/REST_Controller.php';
//var_dump($this->session->all_userdata());
include("common_pages/internal_header.php");
?>

<body>
		<div id="background">
	
                    <div class="left_pannel">
                        <img width="256px" height="500px" src="<?php echo base_url();?>resources/images/ad_vr2.jpg"/>
                    </div>

	<div class="right_panel_login">
            <?php echo form_open_multipart('registration/index');?>
            <h2>Register</h2>
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
                
                <div class="text">First Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="fname" id="fname" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Last Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="lname" id="lname" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Email:</div>
                <div class="field"><input type="text" class="inpt_fld" name="email" id="email" required="" value="<?php if($this->input->post('email') != ""){ echo $this->input->post('email');}?>"/></div>
                <div class="clearfix"></div>
            
<!--                <div class="text">Business Email:</div>
                <div class="field"><input type="text" class="inpt_fld" name="bus_email" id="bus_email" required=""/></div>
                <div class="clearfix"></div>-->
                
                <div class="text">Password:</div>
                <div class="field"><input  class="inpt_fld" type="password" name="pass" id="pass" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Confirm Password:</div>
                <div class="field"><input  class="inpt_fld" type="password" name="confpass" id="confpass" required=""/></div>
                <div class="clearfix"></div>
                
            <div class="text">Town:</div>
                <div class="field"><input type="text" class="inpt_fld" name="town" id="town" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Phone#:</div>
                <div class="field"><input type="text" class="inpt_fld" name="phone" id="phone" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Profile Picture:</div>
                <div class="field"><input type="file" class="inpt_fld" name="userfile" id="userfile"/></div>
                <div class="clearfix"></div>
                
                
                <div class="text">User Type:</div>
                        <div class="field"><select class="inpt_fld" name="utype" id="utype">
                                <option value="">--Select Type--</option>                                
                                <option value="1">Admin</option>
                                <option value="2">HR MAnager</option>
                                <option value="3">Applicant</option>
                                <option value="4">Employer</option>
                    </select></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Register"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
	</div>
                    
                    
                        
                        <div class="right_adds">
                            <img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq1.png';?>"/>
                            <div class="clearfix"></div>
                            <img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq2.png';?>"/>
                        </div>
                    
                    <div class="resultswrap"  id="resultss">
        </div>
        </div>
                    
                    
	
</div>


<?php include("common_pages/internal_footer.php");?>
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


    emailcheck = '<?php echo base_url() . 'index.php/ajax/check_email_availablity'; ?>';
    namecheck = '<?php echo base_url() . 'index.php/ajax/check_name_availablity'; ?>';


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

        profilelink = '<?php echo base_url() . 'index.php/company' ?>';

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
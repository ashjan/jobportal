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
            
            <div class="profile_img_container">
            <div class="sml_img_top">
             <img class="sml_img" src="<?php echo base_url().'resources/images/profile_pic_icon.png';?>"/>
            </div>
            <div class="up_pr_img">
                <?php if($profile[0]['profile_pic'] != ""){?>
                <img src="<?php echo base_url().'uploads/profile_images/'.$profile[0]['profile_pic'];?>"/>
                <?php }else{?>
                <img src="<?php echo base_url().'uploads/profile_images/profilepic.png';?>"/>
                <?php } ?>
            </div>
             <div class="sml_img_low">
                 <form name="form1" enctype="multipart-formdata">
                 <span> <img src="<?php echo base_url().'resources/images/upload_pic_icon.png';?>"/> </span>
                 
                 <input type="file" name="uploadBox" class="upload_profile_pic"/>
                 </form>
             </div>
            </div>
            
            
            <h2>Update Profile</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
            
            <div class="form_container">
                <?php echo form_open_multipart('profile/index');?>
                <div class="text">First Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="fname" id="fname" required="" value="<?php if(isset($profile[0]['first_name'])){ echo $profile[0]['first_name']; }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Last Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="lname" id="lname" required="" value="<?php if(isset($profile[0]['last_name'])){ echo $profile[0]['last_name']; }?>"/></div>
                <div class="clearfix"></div>
                
            
<!--                <div class="text">Profile picture:</div>
                <div class="field"><input type="file" class="inpt_fld" name="userfile" id="userfile" /></div>
                <div class="clearfix"></div>-->
                
                <div class="text">Town:</div>
                <div class="field"><input type="text" class="inpt_fld" name="town" id="town" required="" value="<?php if(isset($profile[0]['town'])){ echo $profile[0]['town']; }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Phone#:</div>
                <div class="field"><input type="text" class="inpt_fld" name="phone" id="phone" required="" value="<?php if(isset($profile[0]['phone_number'])){ echo $profile[0]['phone_number']; }?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Update"/></div>
                <div class="clearfix"></div>
                <?php echo form_close();?>
                
                <div class="clearfix"></div>
                
                
                
                <?php echo form_open('profile/change_password');?>
                
                <div class="text">Old Password:</div>
                <div class="field"><input type="password" class="inpt_fld" name="pass" id="pass" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">New Password:</div>
                <div class="field"><input type="password" class="inpt_fld" name="new_pass" id="new_pass" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Confirm Password:</div>
                <div class="field"><input type="password" class="inpt_fld" name="conf_pass" id="conf_pass" required=""/></div>
                <div class="clearfix"></div>
            
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Change Password"/></div>
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


    emailcheck = '<?php echo base_url() . 'index.php/ajax/check_email_availablity'; ?>';
    namecheck = '<?php echo base_url() . 'index.php/ajax/check_name_availablity'; ?>';
    upload_url = '<?php echo base_url() . 'index.php/profile/dyn_pic_upload'; ?>';
    link_redirect = '<?php echo base_url() . 'index.php/profile/'; ?>';
// Add events
$('input[type=file]').on('change', prepareUpload);
 
// Grab the files and set them to our variable
function prepareUpload(event)
{
    var files = event.target.files;
    
    //var  file = document.form1.uploadBox.value;
    	//files.files[0]
            
            	var pic_data = new FormData();
                $.each(files, function(key, value)
                {
                    pic_data.append(key, value);
                });
            
            $.ajax({
            url: upload_url,
            type: 'POST',
            data: pic_data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data)
            {
                console.log(data);
//                alert(data);
                window.location.replace(link_redirect);
            }});
}

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
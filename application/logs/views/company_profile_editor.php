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
            <?php //echo "<pre>"; print_r($usr_ck); exit; ?>
            <?php if(!empty($owner) || $usr_ck['privilage_status'] == 1){ ?>
            <div class="profile_img_container">
            <div class="sml_img_top">
             <img class="sml_img" src="<?php echo base_url().'resources/images/profile_pic_icon.png';?>"/>
            </div>
            <div class="up_pr_img">
                <?php if(isset($profile[0]['logo'])){if($profile[0]['logo'] != ""){?>
                <img src="<?php echo base_url().'uploads/profile_images/'.$profile[0]['logo'];?>"/>
                <?php }else{
                   ?>
                <img src="<?php echo base_url().'uploads/profile_images/profilepic.png';?>"/>
                    <?php
                }}else{?>
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
            <?php } ?>
            
            <h2>Company Profile Editor</h2>
            
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
            
            
            <div class="form_container">
                
                <?php if(empty($profile)){?>
                <div class="comp_selector">
                <?php echo form_open_multipart('profile/select_company'); ?>
                
                <div class="text">Existing Company:</div>
                <div class="field"><select id="company" name="company" class="inpt_fld" onchange="javascript:select_comp(this)">
                            <option value="">--Select Company--</option>
                            <?php foreach ($companies as $cmp) { ?>
                            
                                <option value="<?php echo $cmp['company_id']; ?>"><?php echo $cmp['company_name']; ?></option>
                            <?php } ?>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="big_txt"> Or </div>
                
               
                
                <div class="text"></div>
                <div class="field"><input id="selector_submit" type="submit" name="submit" value="Update"/></div>
                <div class="clearfix"></div>
                
                <?php echo form_close();?>
            </div>
                <?php } elseif(!empty($owner) || $usr_ck['company_id'] == 0 || $usr_ck['privilage_status'] == 1 ){?>
                
                <div class="comp_editor">
                <?php echo form_open_multipart('profile/comp_profile_editor');?>
                
                
                
                <div class="text">Company Name:</div>
                <div class="field"> <input type="hidden" value="<?php if(isset($profile[0]['company_id'])){echo $profile[0]['company_id'];}?>" name="id" id="comp_id"/> <input type="text" class="inpt_fld" name="comp_name" id="comp_name" required="" value="<?php if(isset($profile[0]['company_name'])){ echo $profile[0]['company_name']; }elseif($this->input->post('comp_name') != ""){echo $this->input->post('comp_name');}?>"/></div>
                <div class="clearfix"></div>
                    
                <div class="text">Tag line:</div>
                <div class="field"><input type="text" class="inpt_fld" name="tag_line" id="tag_line" required="" value="<?php if(isset($profile[0]['tag_line'])){ echo $profile[0]['tag_line']; }elseif($this->input->post('tag_line') != ""){echo $this->input->post('tag_line');}?>"/></div>
                <div class="clearfix"></div>
                
 
                <div class="text">Foundation Year:</div>
                <div class="field"><input type="text" class="inpt_fld" name="found_year" id="found_year" required="" value="<?php if(isset($profile[0]['found_year'])){ echo $profile[0]['found_year']; }elseif($this->input->post('found_year') != ""){echo $this->input->post('found_year');}?>"/></div>
                <div class="clearfix"></div>
                
                                
                                
                <div class="text">Team Size:</div>
                <div class="field"><input type="text" class="inpt_fld" name="team_size" id="team_size" required="" value="<?php if(isset($profile[0]['team_size'])){ echo $profile[0]['team_size']; }elseif($this->input->post('team_size') != ""){echo $this->input->post('team_size');}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">category:</div>
                <div class="field"><select id="category" name="category" class="inpt_fld">
                            <option value="">--Select Category--</option>
                            <?php foreach ($categories as $cnt) { 
                                if($cnt['id'] == $profile[0]['category']){?>
                            <option value="<?php echo $cnt['id']; ?>" selected="selected"><?php echo $cnt['property_category_name']; ?></option>
                                <?php }else{?>
                                <option value="<?php echo $cnt['id']; ?>"><?php echo $cnt['property_category_name']; ?></option>
                            <?php }} ?>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location" id="location" required="" value="<?php if(isset($profile[0]['location'])){ echo $profile[0]['location']; }elseif($this->input->post('location') != ""){echo $this->input->post('location');}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Country:</div>
                <div class="field"><select id="Country" name="Country" class="inpt_fld" onchange="effect_of_country(this);">
                            <option value="">--Select Country--</option>
                            <?php foreach ($countries as $cnt) { 
                                if($cnt['countryid'] == $profile[0]['country']){?>
                            <option value="<?php echo $cnt['countryid']; ?>" selected="selected"><?php echo $cnt['country']; ?></option>
                                <?php }else{?>
                                <option value="<?php echo $cnt['countryid']; ?>"><?php echo $cnt['country']; ?></option>
                            <?php }} ?>
                        </select></div>
                <div class="clearfix"></div>
            
                <div class="text">State:</div>
                <div class="field"><select id="State" name="State" class="inpt_fld" onchange="effect_of_state(this);">
                            <option value="">--Select State--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">City:</div> 
                <div class="field"><select id="City" name="City" class="inpt_fld">
                            <option value="">--Select City--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                
                
                <div class="text"> Address:</div>
                <div class="field"><input id="searchTextField" type="text" name="adress" size="50" class="inpt_fld" style="text-align: left;width:357px;direction: ltr;"></div>
<div class="clearfix"></div>

           <div class="text">latitude:</div>
           <div class="field"><input name="latitude" class="MapLat inpt_fld" value="" type="text" placeholder="Latitude" style="width: 161px;" readonly=""/></div>
            <div class="clearfix"></div>
            
            <div class="text">longitude:</div>
            <div class="field"><input name="longitude" class="MapLon inpt_fld" value="" type="text" placeholder="Longitude" style="width: 161px;" readonly=""/></div>
            <div class="clearfix"></div>
            
    <div id="map_canvas" style="height: 350px;width: 500px;margin: 0.6em;"></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Update"/></div>
                <div class="clearfix"></div>
                <?php echo form_close();?>
                </div>
                
                <?php }else{
                    echo "Wait for the authorization from the Company`s Admin.";
                }?>
                <div class="clearfix"></div>
                
                <?php if($usr_ck['company_id'] == 0){?>
                
                <div class="comp_editor">
                <?php echo form_open_multipart('profile/comp_profile_editor');?>
                
                
                
                <div class="text">New Company:</div>
                <div class="field"> <input type="hidden" value="<?php if(isset($profile[0]['company_id'])){echo $profile[0]['company_id'];}?>" name="id" id="comp_id"/> <input type="text" class="inpt_fld" name="comp_name" id="comp_name" required="" value="<?php if(isset($profile[0]['company_name'])){ echo $profile[0]['company_name']; }elseif($this->input->post('comp_name') != ""){echo $this->input->post('comp_name');}?>"/></div>
                <div class="clearfix"></div>
                    
                <div class="text">Tag line:</div>
                <div class="field"><input type="text" class="inpt_fld" name="tag_line" id="tag_line" required="" value="<?php if(isset($profile[0]['tag_line'])){ echo $profile[0]['tag_line']; }elseif($this->input->post('tag_line') != ""){echo $this->input->post('tag_line');}?>"/></div>
                <div class="clearfix"></div>
                
 
                <div class="text">Foundation Year:</div>
                <div class="field"><input type="text" class="inpt_fld" name="found_year" id="found_year" required="" value="<?php if(isset($profile[0]['found_year'])){ echo $profile[0]['found_year']; }elseif($this->input->post('found_year') != ""){echo $this->input->post('found_year');}?>"/></div>
                <div class="clearfix"></div>
                
                                
                                
                <div class="text">Team Size:</div>
                <div class="field"><input type="text" class="inpt_fld" name="team_size" id="team_size" required="" value="<?php if(isset($profile[0]['team_size'])){ echo $profile[0]['team_size']; }elseif($this->input->post('team_size') != ""){echo $this->input->post('team_size');}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">category:</div>
                <div class="field"><select id="category" name="category" class="inpt_fld">
                            <option value="">--Select Category--</option>
                            <?php foreach ($categories as $cnt) { 
                                if($cnt['id'] == $profile[0]['category']){?>
                            <option value="<?php echo $cnt['id']; ?>" selected="selected"><?php echo $cnt['property_category_name']; ?></option>
                                <?php }else{?>
                                <option value="<?php echo $cnt['id']; ?>"><?php echo $cnt['property_category_name']; ?></option>
                            <?php }} ?>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">Location:</div>
                <div class="field"><input type="text" class="inpt_fld" name="location" id="location" required="" value="<?php if(isset($profile[0]['location'])){ echo $profile[0]['location']; }elseif($this->input->post('location') != ""){echo $this->input->post('location');}?>"/></div>
                <div class="clearfix"></div>
                
                <div class="text">Country:</div>
                <div class="field"><select id="Country" name="Country" class="inpt_fld" onchange="effect_of_country(this);">
                            <option value="">--Select Country--</option>
                            <?php foreach ($countries as $cnt) { 
                                if($cnt['countryid'] == $profile[0]['country']){?>
                            <option value="<?php echo $cnt['countryid']; ?>" selected="selected"><?php echo $cnt['country']; ?></option>
                                <?php }else{?>
                                <option value="<?php echo $cnt['countryid']; ?>"><?php echo $cnt['country']; ?></option>
                            <?php }} ?>
                        </select></div>
                <div class="clearfix"></div>
            
                <div class="text">State:</div>
                <div class="field"><select id="State" name="State" class="inpt_fld" onchange="effect_of_state(this);">
                            <option value="">--Select State--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                <div class="text">City:</div>
                <div class="field"><select id="City" name="City" class="inpt_fld">
                            <option value="">--Select City--</option>
                        </select></div>
                <div class="clearfix"></div>
                
                
                
               <div class="text"> Address:</div>
               <div class="field"><input id="searchTextField" name="adress" type="text" size="50" style="text-align: left;width:357px;direction: ltr;"></div>

           <div class="text">latitude:</div>
           <div class="field"><input name="latitude" class="MapLat" value="" type="text" placeholder="Latitude" style="width: 161px;" readonly=""/></div>
           
            <div class="text">longitude:</div>
            <div class="field"><input name="longitude" class="MapLon" value="" type="text" placeholder="Longitude" style="width: 161px;" readonly=""/></div>

    <div id="map_canvas" style="height: 350px;width: 500px;margin: 0.6em;"></div>
                
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Update"/></div>
                <div class="clearfix"></div>
                <?php echo form_close();?>
                </div>
                
                <?php } ?>
                
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
    upload_url = '<?php echo base_url() . 'index.php/profile/dyn_logo_upload'; ?>';
    link_redirect = '<?php echo base_url() . 'index.php/profile/comp_profile_editor'; ?>';
// Add events
$('input[type=file]').on('change', prepareUpload);
 
// Grab the files and set them to our variable
function prepareUpload(event)
{
    var files = event.target.files;
    var comp_id  = $('#comp_id').val();
    //var  file = document.form1.uploadBox.value;
    	//files.files[0]
            
            	var pic_data = new FormData();
                $.each(files, function(key, value)
                {
                    pic_data.append(key, value);
                });
            
            $.ajax({
            url: upload_url+'/'+comp_id,
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


    stt = '<?php echo base_url() . 'index.php/jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'index.php/jobs/list_cities/'; ?>';
     function effect_of_country(ele)
    {
        var cod = ele.value;
        $.ajax({url: stt + cod, success: function(result) {

                $('#State').html(result);

            }});
    }

    function effect_of_state(ele)
    {
        var cod = ele.value;
        $.ajax({url: cty + cod, success: function(result) {

                $('#City').html(result);

            }});
    }
    
    function select_comp(ele)
    {
        var val = ele.value;
        
        if(val == "")
        {
            $('.comp_editor').css('display','block');
            $('#selector_submit').css('display','none');
        }
        else
        {
             $('.comp_editor').css('display','none');
             $('#selector_submit').css('display','block');
        }
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


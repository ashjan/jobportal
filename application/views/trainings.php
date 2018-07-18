
<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if($this->session->userdata['user_data']['u_type'] == 3)
        {
            //include("common_pages/left_pannel_usr.php");
        }
        else 
        {
            ?> 
            <ul class="tabs_cnt">
                        <li>
                            <a href="<?php echo base_url();?>jobs/"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Post Job
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>jobs/emp_job_listing/"> 
                                <img src="<?php echo base_url().'resources/images/resume_preview.png';?>"/>
                            <br/>
                            Job Listing
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>profile/manage_team/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Manage Team
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>resume/fav_cand_listing/"> 
                                <img src="<?php echo base_url().'resources/images/interviews-jobseeker.png';?>"/>
                            <br/>
                            Favorite Candidates
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url().'jobs/emp_applications';?>"> 
                                <img src="<?php echo base_url().'resources/images/job-applications.gif';?>"/>
                            <br/>
                            Applications
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <?php
            //include("common_pages/left_pannel.php");
        }
        ?>
        
	<div class="right_panel">
            
           
            <div class="training_cntnr"> 
            
                <div class="logo_time">
                    <div class="srch_logo"> <img src="<?php echo $url.'resources/images/training_logo.png';?>"/> </div>
                    <div class="srch_time">2 days ago</div>
                </div>
                
                <div class="traing_dtls">
                    <div class="train_ttl_comp">
                        <div class="result_ttl"> <a href="#"> Human Resource Management </a> </div>
                        <div class="compny">OVEX TECH</div>    
                    </div>
                    
                    <div class="training_price"> $25 / Person</div>
                    
                    <div class="clear"></div>
                    <div class="separator_light"></div>
                    <div class="clear"></div>
                    
                    <div class="rating_reviews"> <img src="<?php echo $url.'resources/images/training_stars.png';?>"/> </div>
                    <div class="train_reviews">12 Reviews </div>
                    
                    <div class="train_loc_icon"> <img height="25px" src="<?php echo $url.'resources/images/images/Layer40copy4.png';?>"/> </div>
                    <div class="training_loc"> Islamabad </div>
                    
                    <div class="duration_ttl">Duration: </div>
                    <div class="train_duration">3 hours</div>
                    
                    <div class="clear"></div>
                    <div class="separator_light"></div>
                    <div class="clear"></div>
                    
                    <div class="training_descrip">
                         It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).   
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    <div class="train_registered"> <span class="train_reg_num"> 125 </span> People Registered </div>
                    
                    <div class="join_train"> <button class="apply_btn" name="join"> JOIN NOW </button> </div>
                    
                </div>
                    
                </div>
            
            
            <div class="clearfix"></div>
            
            <div class="training_cntnr"> 
            
                <div class="logo_time">
                    <div class="srch_logo"> <img src="<?php echo $url.'resources/images/training_logo.png';?>"/> </div>
                    <div class="srch_time">2 days ago</div>
                </div>
                
                <div class="traing_dtls">
                    <div class="train_ttl_comp">
                        <div class="result_ttl"> <a href="#"> Human Resource Management </a> </div>
                        <div class="compny">OVEX TECH</div>    
                    </div>
                    
                    <div class="training_price"> $25 / Person</div>
                    
                    <div class="clear"></div>
                    <div class="separator_light"></div>
                    <div class="clear"></div>
                    
                    <div class="rating_reviews"> <img src="<?php echo $url.'resources/images/training_stars.png';?>"/> </div>
                    <div class="train_reviews">12 Reviews </div>
                    
                    <div class="train_loc_icon"> <img height="25px" src="<?php echo $url.'resources/images/images/Layer40copy4.png';?>"/> </div>
                    <div class="training_loc"> Islamabad </div>
                    
                    <div class="duration_ttl">Duration: </div>
                    <div class="train_duration">3 hours</div>
                    
                    <div class="clear"></div>
                    <div class="separator_light"></div>
                    <div class="clear"></div>
                    
                    <div class="training_descrip">
                         It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).   
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    <div class="train_registered"> <span class="train_reg_num"> 125 </span> People Registered </div>
                    
                    <div class="join_train"> <button class="apply_btn" name="join"> JOIN NOW </button> </div>
                    
                </div>
                    
                </div>
            
                
            </div>
            
                    <div id="right_ad_vertical">
<img width="198" height="936" src="<?php echo $url;?>resources/images/ad_vr1.png">
                    </div>
           
	</div>
                    
                    

</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
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
    
    $(document).ready(function() {

    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $('#start_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
 });
</script>
<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if(isset($this->session->userdata['user_data']['u_type']))
        {
            if($this->session->userdata['user_data']['u_type'] == 3)
            {
                ?>
                    
                    <ul class="tabs_cnt">
                        
                        <?php if(isset($resume)){ ?>
                        <li>
                            <a href="<?php echo base_url();?>index.php/resume/edit_resume/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Edit Resume
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>index.php/resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
                                <img src="<?php echo base_url().'resources/images/resume_preview.png';?>"/>
                            <br/>
                            Preview Resume
                            </a>
                        </li>
                        
                        <li>
                            <a href=""> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Download Resume
                            </a>
                        </li>
                        
                        <?php }else{ ?>
                        
                        <li>
                            <a href="<?php echo base_url().'index.php/resume';?>"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Resume Management
                            </a>
                        </li>
                        
                        <?php } ?>
                        
                        <li>
                            <a href=""> 
                                <img src="<?php echo base_url().'resources/images/interviews-jobseeker.png';?>"/>
                            <br/>
                            My Interviews
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'index.php/jobs/cand_applications';?>"> 
                                <img src="<?php echo base_url().'resources/images/job-applications.gif';?>"/>
                            <br/>
                            My Applications
                            </a>
                        </li>
                    </ul>
                    
                    <div class="clearfix"></div>
                    
                    <?php
                include("common_pages/left_pannel_usr.php");
            }
            else 
            {
                include("common_pages/left_pannel.php");
            }
        }else{
        ?>
        <div class="left_pannel">
                        <img width="266" height="936" src="<?php echo base_url();?>resources/images/ad_vr2.jpg">
                    </div>
        <?php } ?>
                    
    <div class="right_panel">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            <?php if(!isset($pg_ck)){
            echo '<h2>Jobs List</h2>';
            }
            else{
                echo '<h2>Most Viewed Jobs</h2>';
            } //if(isset($categories)){?>
<!--            <select calss="cat_sel" name="categ" id="categ" onchange="jobs_filter(this)">
                <option value=""> --- Select Category --- </option>
                <?php foreach($categories as $cat){?>
                <option value="<?php echo $cat['id'];?>"><?php echo $cat['property_category_name'];?></option>
                <?php } ?>
            </select>-->
            <?php //} ?>
            
            <?php 
            if(!empty($jobs)){                //echo "<pre>"; print_r($jobs); exit;
                $rv = 1;
                foreach($jobs as $job){
                    
?>
            <div class="result_container">
            <div class="srch_logo">
                <?php if($job['profile_pic'] != ""){?>
                <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job['profile_pic'];?>"/>
                <?php }else{?>
                <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                <?php }?>
            </div>
            
            <div class="ttl_compjob">
                <div class="result_ttl"><a href="<?php echo $url;?>/jobs/job_details/<?php echo $job['job_id'];?>"><?php echo $job['job_title']; ?></a></div>
            <div class="compny"><?php echo $job['first_name'].' '.$job['last_name'];?></div>
            </div>
            
                <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location loc_wid"><?php echo $job['city_name']; ?></div>
            
                    
            <div class="srch_type">
                <?php if($job['job_type'] == 2){?>
                             <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/part_time2.png"/>
                <?php }else{?>
                             <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/full_time2.png">
                <?php }?>
                 </div>
            
            <div class="srch_descrip"><div class="rating"  id="rate<?php echo $rv;?>"></div> </div>
                <script>
                var rv_id = "<?php echo $rv;?>";
                //var str_rt = "<?php //echo $url.'/review/star_rating/'.$rev['id'].'/'.$job['res_id'].'/'.$job['candidate_id'].'/'.$rev['check_aded'];?>";
                var str_rt = "";
                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                </script>
            
            <div class="lowr_cntnr">
            <div class="srch_time"><?php echo date("jS F Y",strtotime($job['start_date'])); ?></div>
            
            <div class="attrs">
                <a href="<?php echo base_url().'index.php/jobs/job_details/'.$job['job_id'];?>" class="attr">Overview</a>
                <a href="#" class="attr">Review</a>
                <a href="#" class="attr last">Salaries</a>
            </div>
            
            <?php if(isset($this->session->userdata['user_data']['u_type'])){?>
            <div class="addfav_icn fav_pad">
                
                <a href="<?php echo base_url().'index.php/jobs/add_fav_job/'.$job['job_id'].'/'.$page.'/'.$job['fav_id'];?>">
                    <?php if($job['fav_id'] == ""){?>
                    <img src="<?php echo base_url(); ?>resources/images/images2/Layer41copy3.png"/>
                <?php }else{?>
                    <img width="24px" height="23px" src="<?php echo base_url(); ?>resources/images/star_full.png"/>
                <?php } ?>
                </a>
                
            </div>
            <div class="add_fav">Add To Favourites</div>
            <?php } ?>
            <div class="fav_apply apl_mrg">
                
                <?php if($job['apl_id'] == 0){?>
                <button class="apply_btn sml" value="Apply Now">Already Applied</button>
                <?php }else{ ?>
                <a href="<?php echo base_url().'index.php/jobs/apply/'.$job['job_id'].'/'.$job['company'];?>"><img src="<?php echo base_url().'resources/images/apply_btn.png';?>"/></a>
                <?php } ?>
                
            </div>
            
            </div>
        </div>
            
            <div class="clearfix"></div>
            <div class="separator"></div>

            
            <?php $rv++; }}
            else{
                echo '<div>No Jobs Found.</div>';
            }
            //echo '</table></div>';
            if(!isset($pg_ck)){?>
        
            <div class="pagination"><?php echo $pagin; ?></div>
            <?php } ?>
	
        </div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'index.php/jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'index.php/jobs/list_cities/'; ?>';
    
    job = '<?php echo base_url() . 'index.php/jobs/filter_jobs/'; ?>';
    urll = '<?php echo $url;?>';
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
    
    function jobs_filter(ele)
    {
        var cat = ele.value;
         $.ajax({url: job + cat, success: function(result) {
                 
                 obj = [];
                    obj = JSON.parse(result);
                 var jobs = "";
                 if(obj != ""){
                     jobs +='<thead>'
                     jobs +='<th>Job Title</th>';
                     jobs +='<th>Category</th>';
                     jobs +='<th>Location</th>';
                     jobs +='<th>Posted</th>';
                
                '</thead>'
                     for(i in obj){
                          
                     
               
                         jobs += '<tr><td class="ttll"><a href="'+ urll +'/jobs/job_details/'+ obj[i]['job_id'] +'">'+ obj[i]['job_title'] +'</a></td>';
                         jobs += '<td>'+ obj[i]['category_name'] +'</td>';
                         jobs += '<td>'+ obj[i]['city_name'] +'</td>';
                         jobs += '<td>'+ obj[i]['start_datee'] +'</td></tr>';
                         
                     }
                 }
                 else{
                        jobs += '<tr><td>No Job found in this category</td></tr>';
                 }
                $('#resultss').html(jobs);

            }});
    }
    
    $(document).ready(function() {

    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $('#start_date').Zebra_DatePicker();
    $('#end_date').Zebra_DatePicker();
 });
</script>
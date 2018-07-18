<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
            
 <?php 
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
            
            ?> 
            <ul class="tabs_cnt">
                        <li>
                            <a href="<?php echo base_url();?>index.php/jobs/"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Post Job
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>index.php/jobs/emp_job_listing/"> 
                                <img src="<?php echo base_url().'resources/images/resume_preview.png';?>"/>
                            <br/>
                            Job Listing
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>index.php/jobs/emp_applications/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Applications
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>index.php/resume/fav_cand_listing/"> 
                                <img src="<?php echo base_url().'resources/images/interviews-jobseeker.png';?>"/>
                            <br/>
                            Favorite Candidates
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url().'index.php/jobs/emp_applications';?>"> 
                                <img src="<?php echo base_url().'resources/images/job-applications.gif';?>"/>
                            <br/>
                            Applications
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <?php
            
            include("common_pages/left_pannel.php");
        }
        ?>
        
	<div class="right_panel">
            <h2>Job Applications List</h2>
            
            <div class="resultswrap">
            <table class="results">
                <thead>
                <th>Job Title</th>
                
                <th>Location</th>
                <th>Apply Date</th>
                <th>Delete</th>
                </thead>
            
            <?php if(!empty($app_list)){
                $inc=0;
                foreach($app_list as $job){
            $inc++;
?>
                
                <tr class="res_tr" id="rem_dv<?php echo $inc;?>">
                    <td class="ttll"><a href="#"><?php echo $job['job_title']; ?></a></td>
                    
                    <td><?php echo $job['city_name']; ?></td>
                    <td><?php $date1=date("l jS F Y",strtotime($job['apply_date'])); 
               echo $date1; 
               ?></td>
                    <td> <img src="<?php echo base_url().'resources/images/delete_app.png'; ?>" onclick="javascript:show_hd_tr(<?php echo $inc;?>)"/> </td>
                    </tr>
                    <tr id="rem_div<?php echo $inc;?>"> <td colspan="4" class="separator"></td> </tr>
                
<!--           <div class="joblist">
               <h3 class="job_heading"><a href="#"><?php echo $job['job_title']; ?></a></h3>
               
               <small class="job_info"><b>Start Date: </b><?php echo $job['start_date']; ?></small>
               </br>
               <small class="col-lg-4">Cisco</small>
               <small class="job_info"><b>End Date: </b><?php echo $job['end_date']; ?></small>
               <small class="job_info"><b>Location: </b><?php echo $job['city_name']; ?>,<?php echo $job['Region']; ?>,<?php echo $job['cnt_name']; ?></small>
           </div>
            <div class="clearfix"></div>-->
            <?php }}?>
            </table>
            </div>
            <div class="pagination"><?php echo $pagin; ?></div>
	</div>
          

	
</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'index.php/jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'index.php/jobs/list_cities/'; ?>';
    
    function show_hd_tr(dv_id)
    {
        $('#rem_dv'+dv_id).css('display','none');
        $('#rem_div'+dv_id).css('display','none');
    }
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
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
            include("common_pages/left_pannel.php");
        }
        ?>
        
	<div class="right_panel">
            <h2>Applications List</h2>
            
            <div class="resultswrap">
            <table class="results">
                <thead>
                <th>Job Title</th>
                <th>Category</th>
                <th>Location</th>
                <th>Posted</th>
                <th>End Date</th>
                <th>Delete</th>
                </thead>
            
            <?php if(!empty($jobs)){
                $inc=0;
                foreach($jobs as $job){
                    $inc++;
            
?>
            
            <tr class="res_tr" id="rem_dv<?php echo $inc;?>">
                <td class="ttll"><a href="<?php echo $url.'jobs/emp_application_details/'.$page.'/'.$job['job_id'];?>"><?php echo $job['job_title']; ?></a></td>
                    <td><?php echo $job['category_name']; ?></td>
                    <td><?php echo $job['city_name']; ?></td>
                    <td><?php $date1=date("l jS F Y",strtotime($job['start_date'])); 
               echo $date1; 
               ?></td>
                    <td><?php echo date("l jS F Y",strtotime($job['end_date']));?></td>
                    <td> <img src="<?php echo base_url().'resources/images/delete_app.png'; ?>" onClick="javascript:show_hd_tr(<?php echo $inc;?>)"/> </td>
                    </tr>
                    
            <?php }}?>
            </table>
            </div>
            <div class="pagination"><?php echo $pagin; ?></div>
	</div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
    
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
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
                            <a href="<?php echo base_url();?>index.php/profile/manage_team/"> 
                                <img src="<?php echo base_url().'resources/images/resume-save.png';?>"/>
                                <br/>
                            Manage Team
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
            <h2>Team List</h2>
            
            <div class="resultswrap">
            <table class="results">
                <thead>
                <th>First Name</th>
                
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone#</th>
                <th>Privilege</th>
                </thead>
            
            <?php if(!empty($team)){
                $inc=0;
                foreach($team as $tm){
            $inc++;
?>
                
                <tr class="res_tr" id="rem_dv<?php echo $inc;?>">
                    <td class="ttll"><a href="#"><?php echo $tm['first_name']; ?></a></td>
                    
                    <td><?php echo $tm['last_name']; ?></td>
                    <td><?php  echo $tm['email_address']; ?></td>
                    <td><?php  echo $tm['phone_number']; ?></td>
                    <td> 
                       <?php if($tm['privilage_status'] == 1){ ?>
                        <a href="<?php echo $url.'/profile/set_privilage/0/'.$tm['id'].'/'.$page;?>"><img src="<?php echo base_url().'resources/images/activate.gif'; ?>"/></a>
                       <?php }else{ ?>
                        <a href="<?php echo $url.'/profile/set_privilage/1/'.$tm['id'].'/'.$page;?>"><img src="<?php echo base_url().'resources/images/deactivate.gif'; ?>"/></a>
                       <?php } ?>
                    </td>
                    </tr>
<!--                    <tr id="rem_div<?php echo $inc;?>"> <td colspan="4" class="separator"></td> </tr>-->
                
<!--           <div class="joblist">
               <h3 class="job_heading"><a href="#"><?php echo $tm['job_title']; ?></a></h3>
               
               <small class="job_info"><b>Start Date: </b><?php echo $tm['start_date']; ?></small>
               </br>
               <small class="col-lg-4">Cisco</small>
               <small class="job_info"><b>End Date: </b><?php echo $tm['end_date']; ?></small>
               <small class="job_info"><b>Location: </b><?php echo $tm['city_name']; ?>,<?php echo $tm['Region']; ?>,<?php echo $tm['cnt_name']; ?></small>
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
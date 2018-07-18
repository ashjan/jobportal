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
            <h2>Jobs Listing</h2>
            
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
            
            <div class="resultswrap">
                <?php if(!empty($jobs)){ ?>
                
                
            <table class="results">
                <thead>
                <th style="background: #2980b9; color: #fff;">Job Title</th>
                <th style="background: #2980b9; color: #fff;">Location</th>
                <th style="background: #2980b9; color: #fff;">Posted</th>
                <th style="background: #2980b9; color: #fff;">Expires</th>
                <th style="background: #2980b9; color: #fff;">Status</th>
                <th style="background: #2980b9; color: #fff;">Favorite</th>
                <th style="background: #2980b9; color: #fff;">filled</th>
                <th style="background: #2980b9; color: #fff;">No Of Apps</th>
                </thead>
            
            <?php 
                $inc=0;
                foreach($jobs as $job){
                    $inc++;
?>
            
            <tr class="res_tr" id="rem_dv<?php echo $inc;?>">
                <td class="ttll"><a href="<?php echo $url.'jobs/job_details/'.$job['job_id'];?>"><?php echo $job['job_title']; ?></a></td>
                    <td><?php echo $job['city_name']; ?></td>
                    <td><?php $date1=date("jS M Y",strtotime($job['start_date'])); 
               echo $date1; 
               ?></td>
                    <td><?php echo date("jS M Y",strtotime($job['end_date']));?></td>
                    
                    <td>
                        <?php $dat = date("Y/m/d");
                        if(strtotime($job['end_date']) >= strtotime($dat)){
                        echo '<span class="sucs_msg">Active</span>'; 
                        }
                        else{
                            echo '<span class="message">Expired</span>';
                        } ?>

                    </td>
                    
                    <td>
                        <a href="<?php echo base_url().'jobs/add_fav_job/'.$job['job_id'].'/'.$page.'/'.$job['fav_id'];?>">
                    <?php if($job['fav_id'] == ""){?>
                    <img src="<?php echo base_url(); ?>resources/images/images2/Layer41copy3.png"/>
                <?php }else{?>
                    <img width="24px" height="23px" src="<?php echo base_url(); ?>resources/images/star_full.png"/>
                <?php } ?>
                </a>
                    </td>
                    
 
                    <td> 
                        
                        <input type="checkbox" name="filled" id="filled" onChange="javascript:make_filled(<?php echo $job['job_id']; ?>)" <?php if($job['filled'] == 1){ echo 'checked="checked"';  }?> />
                        
                    </td>
                        
                    <td>
                        <?php if($job['no_of_app'] != 0){?>
                        <a href="<?php echo $url.'jobs/emp_application_details/'.$page.'/'.$job['job_id'];?>"> <?php echo $job['no_of_app'].' applicants'; ?> </a>
                        <?php } ?>
                    </td>
                    </tr>

            <?php } ?>
            </table>
                <?php }else{
                    echo "No Jobs Found.";
                    echo '<div class="clearfix"></div>';
                    echo '<a href="'.base_url().'jobs/"> <img src="'.base_url().'resources/images/images/post_job.png"/> </a>';
                } ?>
                
            </div>
            <div class="pagination"> <?php echo $pagin; ?> </div>
	</div>
	
</div>

   <script language="javascript" type="text/javascript">
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
    fill_url = '<?php echo base_url() . 'jobs/make_fill_job/'; ?>';
    
     function make_filled(id)
    {
    var fl = $("#filled:checked").val();
    
    
    
        $.ajax({url: fill_url + fl+'/'+id, success: function(result) {


            }});
        alert(fl+'<- id');
    }
    
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
        $.ajax({url: cty + cod, success: function(result){

                $('#City').html(result);

            }});
    }
    
    var fltr_url = "<?php echo base_url().'jobs/filter_jobs/'?>";
    function filter_emp_jobs(ele)
    {
        var fili = ele.value;alert(fili);
        var form_dta = {'filter':fili}
        $.ajax({url:fltr_url,type:"POST",data:form_dta,success: function(result){
                alert(result);
        }});
    }
    
    
</script> 
    
<?php include("common_pages/internal_footer.php");?>
    
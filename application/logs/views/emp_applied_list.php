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
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            <h2>Applications List</h2>
            
            
            
            <?php if(!empty($app_list)){
                $dv_id = 0;
                foreach($app_list as $app){
                ?>
            
            
            <div class="result_container">
            <div class="srch_logo">
                <?php if($app['profile_pic'] != ""){?>
                <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $app['profile_pic'];?>"/>
                <?php } else{?>
                <img src="<?php echo base_url().'resources/images/profilepic.png';?>"/>
                <?php } ?>
                            </div>
            
            <div class="ttl_compjob">
                <div class="result_ttl"><a href="<?php echo $url.'/resume/resume_details/'.$app['res_id'].'/'.$app['cand_id'].'/'.$app['application_id'].'/'.$app['job_id'];?>"> <?php echo $app['first_name'].' '.$app['last_name']; ?> </a></div>
            <div class="compny"><?php echo $app['category_name'];?></div>
            </div>
            
                <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location loc_wid">Akutan</div>
            
                    
            <div class="reject_app">
                <a href="<?php echo $url.'/jobs/reject_application/'.$app['application_id'].'/'.$page.'/'.$app['job_id'];?>"><input class="red_btn" type="button" name="reject" value="Reject Application"/></a>
                                             
                                 </div>
            
            <div class="srch_descrip"><?php echo substr($app['objectives'], 200) ;?> </div>
            
            <div class="lowr_cntnr">
            <div class="srch_time"><?php echo date("jS F Y",strtotime($app['apply_date']));?></div>
            
            <div class="attrs">
                <a class="attr" href="<?php echo $url.'/resume/resume_details/'.$app['res_id'].'/'.$app['cand_id'].'/'.$app['application_id'].'/'.$app['job_id'];?>">Overview</a>
                <a class="attr" href="#">Review</a>
                <a class="attr last" href="#">Salaries</a>
            </div>
            
            <div class="addfav_icn fav_pad">
                <?php if($app['fav_id'] == ""){?>
                        <a href="<?php echo $url.'/jobs/mark_favourite/'.$app['candidate_id'].'/'.$page.'/'.$app['job_id'].'/'; ?>"> <img width="24px" height="24px" src="<?php echo base_url();?>resources/images/star_empty.png"/></a>
                        <?php } else{?>
                        <a href="<?php echo $url.'/jobs/mark_favourite/'.$app['candidate_id'].'/'.$page.'/'.$app['job_id'].'/'.$app['fav_id']; ?>"> <img width="24px" height="24px" src="<?php echo base_url();?>resources/images/star_full.png"/></a>
                        <?php } ?>
                </div>
            <div class="add_fav">Add To Favourites</div>
            
            <div class="schedule_intrv">
                <a href="<?php echo $url.'/jobs/schedule_interview/'.$app['application_id'].'/'.$page.'/'.$app['job_id'];?>"> <input class="green_btn" type="button" name="schedule" id="schedule" value="Schedule Interview"/> </a>
            </div>
            
            </div>
        </div>
            <div class="clearfix"></div>
            <div class="separator"></div>
            
            
            <!--New Design -->
            
            
            
            <?php if($dv_id == 0){ ?>
            <script>
                var rate_url = '<?php echo $url.'/jobs/add_rating/';?>';
                $(document).ready(function() {
            <?php } ?>
                    var id_dv = "<?php echo '#rate'.$dv_id;?>";
    // assuming the controls you want to attach the plugin to 
    // have the "datepicker" class set
    $(id_dv).rating(rate_url, {maxvalue:5, increment:.5});
 <?php if($dv_id == 0){ ?>
    });
</script>
                <?php }?>
            
           <?php
            $dv_id++; ?>
            
                <?php  }}?>
            
            <div style="float:left; width: 160px;">
            <div id="nav"></div>
            </div>
             <div id="dp"></div>
            
            <div class="pagination"><?php echo $pagin; ?></div>
	</div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'index.php/jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'index.php/jobs/list_cities/'; ?>';
    create_eve = '<?php echo base_url() . 'index.php/jobs/add_appointment/'; ?>';
    added_eve = '<?php echo base_url() . 'index.php/jobs/get_appointments/'; ?>';
    update_eve = '<?php echo base_url() . 'index.php/jobs/update_appointment/'; ?>';
    
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
    
</script>
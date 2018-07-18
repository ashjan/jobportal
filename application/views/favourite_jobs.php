<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if(isset($this->session->userdata['user_data']['u_type']))
        {
            if($this->session->userdata['user_data']['u_type'] == 3)
            {
                include("common_pages/left_pannel_usr.php");
            }
            else 
            {
                include("common_pages/left_pannel.php");
            }
        }
        ?>
        
    <div class="right_panel">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            
            <h2>My Favourite Jobs</h2>

            <?php if(!empty($jobs)){
                $rv = 1;
                        foreach($jobs as $job){
            ?>
            <div class="favourite_container">
            <div class="srch_logo">
                <?php if($job['profile_pic'] != ""){?>
                <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job['profile_pic'];?>"/>
                <?php }else{?>
                <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                <?php } ?>
            </div>
            
            <div class="ttl_comp">
                <div class="result_ttl"><a href="<?php echo base_url();?>jobs/job_details/3"><?php echo $job['job_title']; ?></a></div>
            <div class="compny"><?php echo $job['first_name'].' '.$job['last_name'];?></div>
            </div>
            
            
            
            <div class="srch_descrip"><div class="rating"  id="rate<?php echo $rv;?>"></div> </div>
                <script>
                var rv_id = "<?php echo $rv;?>";
                
                var str_rt = "";
                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                </script>
            
            <div class="lowr_cntnr">
            <div class="srch_time"> <?php echo date("jS F Y",strtotime($job['start_date'])); ?> </div>
            
            <div class="attrs mrgn">
                <a href="<?php echo base_url();?>/jobs/job_details/<?php echo $job['job_id'];?>" class="attr">Overview</a>
                <a href="#" class="attr">Review</a>
                <a href="#" class="attr last">Salaries</a>
            </div>
            
            <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location"><?php echo $job['city_name'];?></div>
            
            <div class="srch_type">
                <?php if($job['job_type'] == 2){?>
                             <img width="101px" height="28px" src="<?php echo base_url();?>resources/images/images2/part_time2.png"/>
                <?php }else{?>
                             <img width="101px" height="28px" src="<?php echo base_url();?>resources/images/images2/full_time2.png">
                <?php }?>
                 </div>
            
            <div class="fav_apply remv_mrg">
                <?php if($this->session->userdata['user_data']['u_type'] == 3){
                if($job['apl_id'] == 0){ ?>
                <a href="<?php echo base_url().'jobs/apply/'.$job['job_id'];?>"><img src="<?php echo base_url().'resources/images/apply_btn.png';?>"/></a>
                <?php }else{ ?>
                <button class="apply_btn sml" value="Already Applied">Already Applied</button>
                <?php }} ?>
            </div>
            
            </div>
        </div>
            
            <div class="clearfix"></div>
            
            <?php $rv++;}} ?>
            

	
        </div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
    
    job = '<?php echo base_url() . 'jobs/filter_jobs/'; ?>';
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
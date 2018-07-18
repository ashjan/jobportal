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
        else
        {
        ?>
                    <div class="left_pannel">
                        <img width="266" height="936" src="<?php echo base_url();?>resources/images/ad_vr2.jpg">
                    </div>
        <?php } ?>
                    
    <div class="right_panel">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            <?php if(!isset($pg_ck)){
            echo '<h2>Candidates List</h2>';
            }
            else{
                echo '<h2>Consultants List</h2>';
            }  ?>
            
            <div class="search_results">
        
                <div id="data_dv">
                    
            <?php 
            if(!empty($cands)){                //echo "<pre>"; print_r($jobs); exit;
                $rv=1;
                foreach($cands as $job){
                    
?>
             <div class="result_container">
            <div class="srch_logo">
                <?php if($job['profile_pic'] != ""){?>
                <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job['profile_pic'];?>"/>
                <?php }else{?>
                <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                <?php }?>
                </div>
            
            <div class="ttl_comp aut_wid">
                <div class="result_ttl"><a href="<?php echo base_url();?>index.php/welcome/resume_details/<?php echo $job['res_id'].'/'.$job['candidate_id'];?>"> <?php echo $job['first_name'].' '.$job['last_name'];?> </a></div>
            <div class="compny"> <?php echo $job['category_name'];?> </div>
            </div>
            
            <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location"><?php echo $job['city_name'];?></div>
            
            <div class="srch_type">
                             <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/part_time2.png">
                 </div>
            
            <div class="srch_descrip"> <div class="rating"  id="rate<?php echo $rv;?>"></div> </div>
                <script>
                var rv_id = "<?php echo $rv;?>";
                //var str_rt = "<?php //echo $url.'/review/star_rating/'.$rev['id'].'/'.$job['res_id'].'/'.$job['candidate_id'].'/'.$rev['check_aded'];?>";
                var str_rt = "";
                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                </script> 
            
            <div class="lowr_cntnr">
            <div class="srch_time">2 Days Ago</div>
            
            <div class="attrs">
                <a href="<?php echo base_url();?>index.php/welcome/resume_details/<?php echo $job['res_id'].'/'.$job['candidate_id'];?>" class="attr">Overview</a>
                <a href="#" class="attr">Review</a>
                <a href="#" class="attr last">Salaries</a>
            </div>
                        </div>
        </div>
        
        <div class="clearfix"></div>
        <div class="separator"></div>

            
            <?php $rv++; }}
            else{
                echo '<div>No Candidates Found.</div>';
            }
            //echo '</table></div>';
            if(!isset($pg_ck)){?>
        
            <div class="pagination"><?php echo $pagin; ?></div>
            <?php } ?>
                    
    
                </div>
            

        <div class="vr_intrnl_ad">
            <?php if(!empty($projects)){?>
          <h2>Recent Projects</h2>
          <?php foreach($projects as $pro){?>
          <div class="project_container">
              <img width="198" src="<?php echo base_url().'adminCP/media/images/'.$pro['image'];?>">
            <h3><?php echo $pro['category_name'];?></h3>
            <div class="project_des"> <?php echo $pro['description'];?> </div>
          </div>
          
          <div class="clearfix"></div>
          <div class="separator"></div>
          <div class="clearfix"></div>
            <?php }}?>
          
          
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
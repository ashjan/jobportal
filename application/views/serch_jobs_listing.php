<?php include("common_pages/header.php");?>

<div id="container">
	<a href="<?php echo base_url();?>"><h1>Welcome to Ovex Tech Job Portal!</h1></a>
        
        
	<div id="body" style="display: inline-block;">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            <?php if(!isset($pg_ck)){
            echo '<h2>Jobs List</h2>';
            }
            else{
                echo '<h2>Most Viewed Jobs</h2>';
            }
            if(!empty($jobs)){
                foreach($jobs as $job){
            
?>
           <div class="joblist">
               <h3 class="job_heading"><a href="<?php echo $url;?>jobs/job_details/<?php echo $job['job_id'];?>"><?php echo $job['job_title']; ?></a></h3>
               
               <small class="job_info"><b>Start Date: </b><?php $date1=date_create($job['start_date']); echo date_format($date1,'g:ia \o\n l jS F Y'); ?></small>
               </br>
<!--               <small class="col-lg-4">Cisco</small>-->
               <small class="job_info"><b>End Date: </b><?php $date=date_create($job['end_date']); echo date_format($date,'g:ia \o\n l jS F Y'); ?></small>
               <small class="job_info"><b>Location: </b><?php echo $job['city_name']; ?>,<?php echo $job['Region']; ?>,<?php echo $job['cnt_name']; ?></small>
           </div>
            <div class="clearfix"></div>
            <?php }}
            else{
                echo '<div>No Jobs Found.</div>';
            }
            if(!isset($pg_ck)){?>
            <div class="pagination"><?php echo $pagin; ?></div>
            <?php } ?>
	</div>
        </div>
	<p class="footer">  <strong> Ovex Tech Job POrtal</strong> </p>
</div>


<?php include("common_pages/footer.php");?>
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
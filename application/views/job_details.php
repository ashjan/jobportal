
<?php
//$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
//echo "<pre>"; print_r($segments); exit;
include("common_pages/internal_header.php");?>



		<div id="background">
			
                    <div class="left_pannel">
                        <div class="big_title">Job Summary</div>
			<div id="Shape5copy6"><img src="<?php echo base_url();?>resources/images/images3/Shape5copy6.png"></div>
			<div class="sub_lable">Company</div>
			<div class="employer_name">
                        <?php if($job_dt[0]['company_name'] == ""){ 
                                echo $job_dt[0]['first_name'].' '.$job_dt[0]['last_name'];
                                }else{
                                    echo $job_dt[0]['company_name'];
                                }
                                ?>
                        </div>
			<div class="sub_lable">Location</div>
			<div class="sub_label_name_atr"><?php echo $job_dt[0]['city_name']?></div>
			<div class="sub_lable"> Industry </div>
			<div class="sub_label_name_atr"><?php echo $job_dt[0]['property_category_name'];?></div>
			
                        <div class="sub_lable"> Job Type </div>
			<div class="sub_label_name_atr"><?php if($job_dt[0]['job_type'] == 2){echo 'Part time';} else{echo 'Full Time';}  ?></div>
			
                        
                        <div class="sub_lable"> Experience </div>
                        <div class="sub_label_name_atr"><?php 
                        if($job_dt[0]['experience'] == -2){echo 'Student';}
                        elseif($job_dt[0]['experience'] == -1){echo 'fresh Graduate';}
                        elseif($job_dt[0]['experience'] == 0) {echo 'Less Than 1 year';}
                        elseif($job_dt[0]['experience'] > 0 && $job_dt[0]['experience'] < 26){
                            echo $job_dt[0]['experience'].' Year'; if($job_dt[0]['experience']>1 && $job_dt[0]['experience']<26){echo 's';}
                        }
                        elseif($job_dt[0]['experience'] == 26){echo 'More Than 25 years';}?></div>
			
                                                
                        <div class="sub_lable"> Shift Timing </div>
                        <div class="sub_label_name_atr"> <?php if($job_dt[0]['shift_titming'] == 2){echo 'Evening Shift';}
                            elseif($job_dt[0]['shift_titming'] == 3) {echo 'Night Shift';}
                            elseif($job_dt[0]['shift_titming'] == 4){echo 'On Rotation';}
                            else {echo 'Morning Shift';}?> </div>
                        
			<div class="sub_lable"> Salary Range </div>
                        <div class="sub_label_name_atr"><?php if($job_dt[0]['salary']){echo $job_dt[0]['salary'].'-'; }
						if($job_dt[0]['salary_to'] > 0){ echo $job_dt[0]['salary_to'];} else { echo "Max:";}
						?></div>
                        
			<div class="sub_lable"> Career Level </div>
			<div class="sub_label_name_atr"> <?php
                        if($job_dt[0]['career'] == 1){echo 'Student (High School/College)';}
                        elseif($job_dt[0]['career'] == 2){echo 'Student (Undergraduate/Graduate)';}
                        elseif($job_dt[0]['career'] == 3){echo 'Entry Level';}
                        elseif($job_dt[0]['career'] == 5){echo 'Manager (Manager/Supervisor)';}
                        elseif($job_dt[0]['career'] == 6){echo 'Executive';}
                        elseif($job_dt[0]['career'] == 7){echo 'Senior Executive';}
                        else{echo 'Experienced (Non-Managerial)';} ?>
                        </div>
			
                        
                        <?php if(isset($utyp)){ 
                                            if($utyp == 3){
                        if(!isset($first_chk)){
               if($check > 0){
                   echo '<div id="RoundedRectangle7cop_0"> <button class="apply_btn" value="Already Applied">Already Applied</button> </div>';
                   //echo '<div id="APPLYNOW_0">Already Applied</div>';
               }
               else{ ?>
                        
                        <div id="RoundedRectangle7cop_0"> <button class="apply_btn aply" value="Apply Now">Apply Now</button> </div>

                        <?php }}}}elseif(isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                            ?>
                        <div id="RoundedRectangle7cop_0"> <button class="apply_btn aply" value="Apply Now">Apply Now</button> </div>

                                <?php } ?>
                        
                        <div id="left_sqr_ad"><img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq1.png';?>"/></div>

			<div id="left_sqr_ad"><img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq2.png';?>"/></div>

                    </div>
			
		
                    <div class="right_panel_descrip" style="width: 747px;">
                    
                        
                        
            <div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?> </div>
            <div class="message"><?php echo $this->session->flashdata('err_msg');
            echo validation_errors();?></div>
                        
                        <div class="alert alert-info">
                            <h3> Apply for this job <a class="close" data-dismiss="alert" href="#">x</a></h3> 
                            <table>
			
                                <tr>
                                    <?php echo form_open('jobs/apply'); ?>
                                    <td>Select Resume:</td>
                                <input type="hidden" name="job_id" value="<?php echo $job_dt[0]['job_id']; ?>"/>
                                <input type="hidden" name="company" value="<?php echo $job_dt[0]['company']; ?>"/>
                                <td><select name="apl_resume" id="apl_resume" class="inpt_fld">
                                                   <?php if(!empty($resume)){
                                                        foreach($resume as $res_bld){
                                                    ?>
                                                    <option value="<?php echo $res_bld['id']?>"> <?php echo $res_bld['first_name'].' '.$res_bld['last_name'].'('.date("jS M Y",strtotime($res_bld['create_date'])).')'?> </option>
                                                    <?php }} ?>
                                                    <?php if(!empty($uploaded_res)){
                                                        foreach($uploaded_res as $up_res){ $inci=0;?>
                                                    <option value="<?php echo 'd'.$inci;?>"> <?php echo $up_res; ?> </option>
                                                    <?php $inci++;} }
                                                    ?>
                                        </select></td>
                                </tr>
                                
                                <tr><td colspan="2" class="clearfix"></td></tr>
                                
                                <tr>
                                    <td colspan="2"><strong>Cover Letter</strong></td>
                                </tr>
                                
                                <tr><td colspan="2" class="clearfix"></td></tr>
                                
                                <tr>
                                    <td>Title:</td>
                                    <td><input required="" name="cover_title" class="inpt_fld" id="cover_title"/></td>
                                </tr>
                                
                                <tr><td colspan="2" class="clearfix"></td></tr>
                                
                                <tr>
                                    <td>Cover Letter:</td>
                                    <td><textarea name="cover_letter_des" id="cover_letter_des"></textarea></td>
                                </tr>
                                
                                <tr><td colspan="2" class="clearfix"></td></tr>
                                
                                <tr>
                                    <td colspan="2" style="text-align:center;"> 
                                        <input type="submit" value="Apply" class="apply_btn"/>
                                    </td>
                                    <?php echo form_close(); ?>
                                </tr>
                                
                                
                                
                            </table>
                        </div>
			
			<div id="comp_logo_sml"> <?php if($job_dt[0]['logo'] != ""){
                            echo '<img src="'.base_url().'uploads/profile_images/'.$job_dt[0]['logo'].'"/>';
                        }elseif($job_dt[0]['profile_pic'] != ""){?>
                        <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job_dt[0]['profile_pic'];?>"/>
                        <?php }else{?>
                        <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                        <?php }?> 
                        </div>
                        <div class="ttl_compjob more_wid">
                        <div class="main_title"><?php echo $job_dt[0]['job_title'];?></div>
			<div class="company"> <?php if($job_dt[0]['company_name'] == ""){ 
            echo $job_dt[0]['first_name'].' '.$job_dt[0]['last_name'];
            }else{
                echo $job_dt[0]['company_name'];
            }
            ?> </div>
                        </div>
                        
                        <div class="dat_aply_contnr">
                            <div class="post_date"><?php $date1=date_create($job_dt[0]['start_date']); echo date_format($date1,'jS F Y'); ?>  <script>// var intrvl = ''; intrvl = prettyDate('<?php echo str_replace(" ", 'T', $job_dt[0]['start_date']);?>'); document.write(intrvl); </script> </div>
			
                               <?php   if(isset($utyp)){ 
                                            if($utyp == 3){
                                if(!isset($first_chk)){
               if($check > 0){
                   echo '<div id="RoundedRectangle7cop"> <button class="apply_btn sml" value="Apply Now">Already Applied</button> </div>';
                   
               }
               else{ ?>
                            <div id="RoundedRectangle7cop"> <button class="apply_btn sml aply" value="Apply Now">Apply Now</button> </div>
			 <?php }}}} elseif(isset($this->session->userdata['user_data']['is_user_logged_in']))
                        {?>
                        <div id="RoundedRectangle7cop"> <button class="apply_btn sml aply" value="Apply Now">Apply Now</button> </div>
			<?php } ?>
                        </div>
			
                        
			<div id="Shape5"><img src="<?php echo base_url();?>resources/images/images3/Shape5.png"></div>
			<div id="Layer41"><img src="<?php echo base_url();?>resources/images/images3/Layer41.png"></div>
			<div class="favourites">Add to Favourites</div>
                        <div id="Layer40"> <a href="<?php echo base_url('');?>welcome/load_map/<?php echo $job_dt[0]['job_id']; ?>" title="Show Map" ><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"> </a></div>
			<div class="locationn"><?php echo $job_dt[0]['city_name']?></div>
			
                        <div id="RoundedRectangle7">
                        <?php if($job_dt[0]['job_type'] == 2){ ?>
                        <img src="<?php echo base_url();?>resources/images/images2/part_time2.png">
                         <?php } else{ ?>
							 <img src="<?php echo base_url();?>resources/images/images2/full_time2.png">
							 <?php } ?> 
                        </div>
			<div id="Shape5copy"><img src="<?php echo base_url();?>resources/images/images3/Shape5copy.png"></div>
			<div class="job_description">
			<h2>Description</h2>
			<?php echo content($job_dt[0]['job_description']); ?>
			<?php //echo substr(content($job_dt[0]['job_description']), 0, 30); ?>
			</div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="btns_contnr">
                        
                            <div id="back_cntnr"> <a href="<?php echo base_url();?>" title="Go back"><button class="back_btn" value="Back" >Back</button> </a></div>
			
                        <?php if(isset($utyp)){ 
                                            if($utyp == 3){
                                if(!isset($first_chk)){ 
               if($check > 0){
                   echo '<div id="RoundedRectangle7cop_1"> <button class="apply_btn" value="Apply Now">Already Applied</button> </div>';
                   
               }
               else{ ?>
                   
                                <div id="RoundedRectangle7cop_1"><a href="<?php echo $url;?>jobs/apply/<?php echo $job_dt[0]['job_id'].'/'.$job_dt[0]['company'];?>" class="aply"> <button class="apply_btn" value="Apply Now">Apply Now</button> </a></div>
                                
                   ?>
                                
                            <div id="RoundedRectangle7cop_1"> <button class="apply_btn aply" value="Apply Now">Apply Now</button> </div>
                                
               <?php }}}
               else
               {
                   echo '<div id="RoundedRectangle7cop_1"><a href="'.base_url().'jobs/edit_job/'.$job_dt[0]['job_id'].'" class="updt"/><input class="btn_blue" type="button" name="Edit" value="Update Job Details"/></a></div>';
                   echo '<div class="del_cntnr"><a onclick="return window.confirm("Are you sure you want to delete this Job.");" href="'.base_url().'jobs/delete_job/'.$job_dt[0]['job_id'].'" class="updt"/><input class="btn_red" type="button" name="delete" value="Delete Job"/></a></div>';
               }
               } elseif(isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                   ?>
                        <div id="RoundedRectangle7cop_1"> <button class="apply_btn aply" value="Apply Now">Apply Now</button> </div>
                                
                                <?php } ?>
                        
                    </div>
                        
                </div>
                    <div class="right_long_ad">
    
    <div class="jdmo_header">More Options</div>

                    <div class="jdmo_detail" style="width:239px; padding-left:10px;">

               		  <div style="line-height:20px; font-weight:900; color:#000; font-size:11px; font-family:Verdana, Geneva, sans-serif">Job Tools</div>

					 
					  <div id="save_jobs" style="margin-top:5px;">

							

								<div id="ahmad" style="float:left; width:105px; font-weight:bold;"></div>

								
								<div class="clear"></div>

                    </div>
			
			
		
					  
                    	<div>

                        	<a title="Print" href="javascript:void(0);" style="text-decoration:none;" onclick="javascript: showjobdescription('<?php echo $job_dt[0]['job_id']; ?>');" ><img src="<?php echo base_url('');?>resources/images/jt_print.png" alt="Print"> <span>Print This Job</span></a>

		</div>

							
<?php if($job_dt[0]['company_id'] != '') {?>
                   	<div style="padding-top:0px;"><img src="<?php echo base_url('');?>resources/images/jt_search.png" alt="search"> <span><a style="text-decoration:none;" href="<?php echo base_url('');?>welcome/job_search/morecompanyjobs<?php echo $job_dt[0]['company_id']; ?>"> More Jobs by this Company </a></span></div>
<?php } ?>                    


                    	<div class="clear"> </div>
<?php if($job_dt[0]['category'] != '') {?>
<div style="padding-top:0px;"><img src="<?php echo base_url('');?>resources/images/jt_search.png" alt="search"> <span><a style="text-decoration:none;" href="<?php echo base_url('');?>welcome/job_search/similiarjobs<?php echo $job_dt[0]['category']; ?>"> View Similar Jobs</a></span></div>
<?php } ?>



 

 </div>

<div id="Rectangle15copy">
<img src="<?php echo base_url();?>resources/images/ad_vr1.png" width="198" height="936" /></div>
</div>

                   
                    </div>
    

			
			
		
		
 
<div id="dialog_job_print" title="Print Job">
    <span id="print_job"></span>
</div>

<?php include 'common_pages/internal_footer.php';?>
<?php

	function content($text, $allowed_tags = '<p><b><i><sup><sub><em><strong><ul><br><li><div><span>')
    {
        mb_regex_encoding('UTF-8');
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
              $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    } 

    if(isset($this->session->userdata['user_data']['is_user_logged_in'])){
 ?>

<script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery.gdocsviewer.min.js" ?>"></script>
<script>

var cover_url = "<?php echo base_url().'jobs/get_covering_letter/'?>";

$('.close').click(function(){
    $('.alert-info').css('display','none');
});

   $('.aply').click(function(){
       $('.alert-info').css('display','block');
       $('html, body').animate({scrollTop : 0},800);
		return false;
   });     
        
        
        
        $('#apl_resume').change(function(){
                    var res_id = "";
                $("#apl_resume option:selected").each(function () {
                res_id += $(this).val();
                });

                if(res_id == "")
                {
                    res_id = $('#apl_resume').val();
                }

                $.ajax({url: cover_url +res_id, success: function(result) {

                        if(result != false){
                            obj = JSON.parse(result);
                        $('#cover_title').val(obj["letter_title"]); 
                        tinyMCE.activeEditor.setContent(obj["letter_description"]);
                    }
                }});
        }).trigger('change');
</script>

    <?php } ?>
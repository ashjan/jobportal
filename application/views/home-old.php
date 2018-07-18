<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include 'common_pages/headers.php';?>
	
		
			

			
			
<!--			<div id="Shape4"><img src="<?php echo base_url();?>resources/images/images/Shape4.png"></div>-->
			


			
                        <div id="latest_container">
                        
                        
			<div class="latest_ttl">
			<div id="Layer25"><img src="<?php echo base_url();?>resources/images/images/Layer25.png"></div>
                        <div id="LatestJobs">Hot Jobs</div>
                        </div>
                        <div class="latest_ttl">
                        <div id="Layer28"><img src="<?php echo base_url();?>resources/images/images/Layer28.png"></div>
			<div id="LatestResumes">Hot Resume</div>
                        </div>
                        <div class="latest_ttl">
                        <div id="Layer26"><img src="<?php echo base_url();?>resources/images/images/Layer26.png"></div>
			<div id="LatestCompanies"> Hot Companies </div>
                        </div>
                         
                        <div class="clearfix"></div>
                        <div class="border"></div>
                        
                        <div class="latest_job">
                            <?php if(!empty($latest_jobs)){
                                $ltst_count = count($latest_jobs);
                                foreach($latest_jobs as $ltst){
                                    $ltst_count--;?>
                            <div class="jobs_container">
                                <div class="comp_logo"> 
                                <?php if($ltst['profile_pic'] != "" && $ltst['profile_pic'] != 'no file'){
                                    $pr_pic = $ltst['profile_pic'];
                                }else{
                                     $pr_pic = 'profilepic.png';
                                }?>    
                                    <img width="34px" height="38px" src="<?php echo base_url().'uploads/profile_images/'.$pr_pic; ?>"> 
                                
                                </div>
                            <div class="job">
                                <div class="job_title"> <a href="<?php echo $url.'welcome/job_details/'.$ltst['job_id'];?>"><?php echo $ltst['job_title'];?></a></div>
                            <div class="comp_name"> <?php echo $ltst['first_name']." ".$ltst['last_name'];?> </div>
                            </div>
                                <div class="loc_icon"> <a href="<?php echo base_url().'jobs/load_map';?>"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></a> </div>
                            <div class="location"> <?php echo $ltst['city_name'];?> </div>
                            
                            <div class="job_typ">
                            <?php if($ltst['job_type'] == 1){?>
                                <img src="<?php echo base_url();?>resources/images/images/full_time.png"/>
                                <?php }else{?>
                                <img src="<?php echo base_url();?>resources/images/images/part_time.png"/>
                                <?php }?>
                            </div>
                            </div>
                            
                            <?php if($ltst_count != 0){ ?>
                            <div class="clearfix"></div>
                            <div class="border"></div>
                            <?php }}} ?>
                            
                             </div>
                        
                        <div class="latest_resume">
                            <?php if(!empty($latest_resumes)){
                                $ltst_count = count($latest_resumes);
                                foreach($latest_resumes as $ltst){
                                    $ltst_count--;?>
                            <div class="jobs_container">
                            <div class="comp_logo"> 
                            
                                <?php if($ltst['profile_pic'] != "" && $ltst['profile_pic'] != 'no file'){
                                    $pr_pic = $ltst['profile_pic'];
                                }else{
                                     $pr_pic = 'profilepic.png';
                                }?>    
                                    <img width="34px" height="38px" src="<?php echo base_url().'uploads/profile_images/'.$pr_pic; ?>"> 
                                
                            </div>
                            <div class="job">
                                <div class="job_title"> <a href="<?php echo $url.'welcome/resume_details/'.$ltst['res_id'].'/'.$ltst['candidate_id'];?>"><?php echo $ltst['first_name'].' '.$ltst['last_name'];?></a></div>
                            <div class="comp_name"> <?php echo $ltst['category_name'];?> </div>
                            </div>
                            <div class="loc_icon"> <a href="<?php echo base_url().'jobs/load_map';?>"> <img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"> </a> </div>
                            <div class="location"> <?php echo $ltst['city_name'];?> </div>
                            
                            <div class="job_typ">
                            <?php //if($ltst['job_type'] == 1){?>
                                <img src="<?php echo base_url();?>resources/images/images/full_time.png"/>
                                <?php //}else{?>
<!--                                <img src="<?php echo base_url();?>resources/images/images/part_time.png"/>-->
                                <?php //}?>
                            </div>
                            </div>
                            
                            <?php if($ltst_count != 0){ ?>
                            <div class="clearfix"></div>
                            <div class="border"></div>
                            <?php }}} ?>
                            
                             </div>
                        
                        <div class="latest_companies">
                            <?php if(!empty($latest_companies)){
                                $ltst_count = count($latest_companies);
                                foreach($latest_companies as $ltst){
                                    $ltst_count--;?>
                            <div class="jobs_container">
                            <div class="comp_logo"> 
                            
                                <?php if($ltst['profile_pic'] != "" && $ltst['profile_pic'] != 'no file'){
                                    $pr_pic = $ltst['profile_pic'];
                                }else{
                                     $pr_pic = 'profilepic.png';
                                }?>    
                                    <img width="34px" height="38px" src="<?php echo base_url().'uploads/profile_images/'.$pr_pic; ?>"> 
                                
                            </div>
                            <div class="job">
                                <div class="job_title"> <a href="#"><?php echo $ltst['first_name'].' '.$ltst['last_name'];?></a></div>
                            <div class="comp_name"> <?php //echo $ltst['category_name'];?> </div>
                            </div>
                            <div class="loc_icon"> <a href="<?php echo base_url().'jobs/load_map';?>"> <img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"> </a> </div>
                            <div class="location"> <?php echo "Pakistan";?> </div>
                            
                            <div class="job_typ">
                            <?php //if($ltst['job_type'] == 1){?>
                                <img src="<?php echo base_url();?>resources/images/images/full_time.png"/>
                                <?php //}else{?>
<!--                                <img src="<?php echo base_url();?>resources/images/images/part_time.png"/>-->
                                <?php //}?>
                            </div>
                            </div>
                            
                            <?php if($ltst_count != 0){ ?>
                            <div class="clearfix"></div>
                            <div class="border"></div>
                            <?php }}} ?>
                            
                             </div>
                        
                        <div id="featured_company"><img src="<?php echo base_url();?>resources/images/images/Background_1.png"></div>
                                    </div>
                        
                        <div class="sqr_sml_ads">
                        <div id="sq_ad"><img width="235px" height="242px" src="<?php echo base_url();?>resources/images/ad_sq4.png"></div>
                        <div id="sq_ad"><img width="235px" height="242px" src="<?php echo base_url();?>resources/images/ad_sq3.png"></div>
                        </div>
<!--			<div id="Rectangle11"><img src="<?php echo base_url();?>resources/images/images/Rectangle11.png"></div>-->
<!--			<div id="Rectangle11copy"><img src="<?php echo base_url();?>resources/images/images/Rectangle11copy.png"></div>-->
                        
<!--<div id="Rectangle10"> <img src="<?php echo base_url();?>resources/images/images/Rectangle10.png"> </div>-->
<!--                        <div id="Shape5copy"><img src="<?php echo base_url();?>resources/images/images/Shape5copy.png"></div>
			<div id="Shape5copy3"><img src="<?php echo base_url();?>resources/images/images/Shape5copy3.png"></div>
			<div id="Shape5copy4"><img src="<?php echo base_url();?>resources/images/images/Shape5copy4.png"></div>
			<div id="Shape5copy2"><img src="<?php echo base_url();?>resources/images/images/Shape5copy2.png"></div>-->
                        
			
                        
                        <div class="statistics_container">
                        
                            <div id="pricing_heading"><img src="<?php echo base_url();?>resources/images/images/statistic_icon.png">
                                <div class="heading_text"><img src="<?php echo base_url();?>resources/images/images/SiteStatistics.png"></div>
                            </div>
                        
                            <div class="stats_cnt">
			<div id="stat_in_cnt">
                        <div id="stat_icon"><img src="<?php echo base_url();?>resources/images/images/Layer24.png"></div>
                        <div id="stat_count"><?php echo $jobs_cnt;?> <!--<img src="<?php echo base_url();?>resources/images/images/layer_33.png">--></div>
                        <div id="stat_text"><img src="<?php echo base_url();?>resources/images/images/JOBOFFERS.png"></div>
                        </div>
			
			<div id="stat_in_cnt">
                        <div id="stat_icon"><img src="<?php echo base_url();?>resources/images/images/Layer29.png"></div>
                        <div id="stat_count"><?php echo $resumes_cnt;?> <!--<img src="<?php echo base_url();?>resources/images/images/layer_20.png">--></div>
                        <div id="stat_text"><img src="<?php echo base_url();?>resources/images/images/RESUMES.png"></div>
                        </div>
                        
			<div id="stat_in_cnt">
                        <div id="stat_icon"><img src="<?php echo base_url();?>resources/images/images/Layer27.png"></div>
                        <div id="stat_count"><?php echo $companies_cnt;?> <!--<img src="<?php echo base_url();?>resources/images/images/layer_19.png">--></div>
                        <div id="stat_text"><img src="<?php echo base_url();?>resources/images/images/COMPANIES.png"></div>
                        </div>
                        
			<div id="stat_in_cnt">
			<div id="stat_icon"><img src="<?php echo base_url();?>resources/images/images/Layer31.png"></div>
			<div id="stat_count"> <?php echo $members;?> <!--<img src="<?php echo base_url();?>resources/images/images/layer_58.png">--></div>
                        <div id="stat_text"><img src="<?php echo base_url();?>resources/images/images/MEMBERS.png"></div>
                        </div>
                            </div>    
                                
                        </div>
			
<!--			<div id="Rectangle4copy10"><img src="<?php echo base_url();?>resources/images/images/Rectangle4copy10.png"></div>
			<div id="JobMugcopy"><img src="<?php echo base_url();?>resources/images/images/JobMugcopy.png"></div>
			<div id="Layer21copy"><img src="<?php echo base_url();?>resources/images/images/Layer21copy.png"></div>-->

			
                        <div class="clearfix"></div>
                        
                        <div id="pricing_container">
			<div id="pricing_heading"><img src="<?php echo base_url();?>resources/images/images/Layer41.png">
                        <div id="PlansandPricing"><img src="<?php echo base_url();?>resources/images/images/PlansandPricing.png"></div>
                        </div>

			
                        <div class="pricing">
                            
                            <div class="pricing_container">
                                <div class="price_title"> Start Up </div>
                                <div class="price"> $27 </div>
                                <div class="price_duration"> 1 Job for 30 Days </div>
                                <div class="price_desc"> One Time Fee Allows 1 Job Posting No Highlighted Post</div>
                                <div class="add_cart"><img src="<?php echo base_url().'resources/images/images/add_cart.png';?>"/></div>
                            </div>
                            
                            <div class="pricing_container">
                                <div class="price_title"> Company </div>
                                <div class="price"> $59 </div>
                                <div class="price_duration"> 2 Jobs for 30 Days </div>
                                <div class="price_desc"> One Time Fee Allows 2 Job Posting Highlighted Job Post For 30 Days </div>
                                <div class="add_cart"><img src="<?php echo base_url().'resources/images/images/add_cart.png';?>"/></div>
                            </div>
                            
                            <div class="pricing_container">
                                <div class="price_title"> Enterprise </div>
                                <div class="price"> $89 </div>
                                <div class="price_duration"> 5 Job for 30 Days </div>
                                <div class="price_desc"> One Time Fee Allows 5 Job Posting Highlighted Job Post For 90 Days Spotlighted Company Post </div>
                                <div class="add_cart"><img src="<?php echo base_url().'resources/images/images/add_cart.png';?>"/></div>
                            </div>
                            
                        </div>
                        
                        </div>

			
			
                        
			
			<!--<div id="ADcopy2"><img src="<?php echo base_url();?>resources/images/images/ADcopy2.png"></div>
			<div id="ADcopy3"><img src="<?php echo base_url();?>resources/images/images/ADcopy3.png"></div>
			<div id="ADcopy4"><img src="<?php echo base_url();?>resources/images/images/ADcopy4.png"></div>-->
                        
                        
<!--                        <div class="post_job_container">
                        <div id="Wegiveyou30daysfreep"><img src="<?php echo base_url();?>resources/images/images/Wegiveyou30daysfreep.png"></div>
                        <a href="<?php echo $url.'jobs';?>">
                            
                            <div id="POSTAJOBNOW"><img src="<?php echo base_url();?>resources/images/images/POSTAJOBNOW.png"></div>
                        </a>
                        </div>-->
                        
                        <div class="testimonials_outer_container">
			<div id="pricing_heading"><img src="<?php echo base_url();?>resources/images/images/testimonial_icon.png">
                            <div class=""><img src="<?php echo base_url();?>resources/images/images/Testimonials.png"></div>
                        </div>
                            
                            <div class="testim_cntnr">
			<div id="layer_46"><img src="<?php echo base_url();?>resources/images/images/layer_46.png"></div>
			
                        <div class="testimonial_cntnr">
			<div id="testmonial_img"><img src="<?php echo base_url();?>resources/images/images/Background_0.png"></div>
                        <div class="testim_ttl">
                        <div id="testimonial_usr_nam"><img src="<?php echo base_url();?>resources/images/images/JakeCaputo.png"></div>
                        <div id="testimonial_des"><img src="<?php echo base_url();?>resources/images/images/JobMugofferanamazing.png"></div>
                        </div>
                        </div>
                        
                        <div class="testimonial_cntnr">
			<div id="testmonial_img"><img src="<?php echo base_url();?>resources/images/images/Layer23.png"></div>
			<div class="testim_ttl">
                        <div id="testimonial_usr_nam"><img src="<?php echo base_url();?>resources/images/images/AdamSpencer.png"></div>
			<div id="testimonial_des"><img src="<?php echo base_url();?>resources/images/images/Imincrediblypleasedw.png"></div>
                        </div>
                        </div>
                        
			<div id="layer_47"><img src="<?php echo base_url();?>resources/images/images/layer_47.png"></div>
                            </div>
                        </div>
                        
                        
                        <div id="low_home_ad"><img width="1180px" height="155px" src="<?php echo base_url();?>resources/images/ad_hor1.png"></div>
                        
<!--			<div id="MUG"><img src="<?php echo base_url();?>resources/images/images/MUG.png"></div>-->
                            <!-- Footer Starts Here  -->
                            <script>
                            $("#LatestResumes").click(function(){
                                $('.latest_job').css('display','none');
                                $('.latest_resume').css('display','block');
                                $('.latest_companies').css('display','none');
                              });
                              
                              $("#LatestJobs").click(function(){
                                    $('.latest_job').css('display','block');
                                    $('.latest_resume').css('display','none');
                                    $('.latest_companies').css('display','none');
                                  });
                             
                            
                            $("#LatestCompanies").click(function(){
                                    $('.latest_companies').css('display','block');
                                    $('.latest_resume').css('display','none');
                                    $('.latest_job').css('display','none');
                                  });
                            
                            </script>
                         <?php include 'common_pages/footers.php';?>

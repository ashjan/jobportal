<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if(isset($this->session->userdata['user_data']['u_type']))
        {
            if($this->session->userdata['user_data']['u_type'] == 3)
            {
                ?>
                    
                    <ul class="tabs_cnt">
                        
                        <?php if(isset($resume)){ ?>
                        <li>
                            <a href="<?php echo base_url();?>resume/edit_resume/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
                                <img src="<?php echo base_url().'resources/images/edit_resume.png';?>"/>
                            <br/>
                            Edit Resume
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>resume/resume_details/<?php echo $resume[0]['id'].'/'.$resume[0]['candidate_id'];?>"> 
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
                            <a href="<?php echo base_url().'resume';?>"> 
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
                            <a href="<?php echo base_url().'jobs/cand_applications';?>"> 
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
                include("common_pages/left_pannel.php");
            }
        }else{
        ?>
        <div class="left_pannel">
                        <img width="266" height="936" src="<?php echo base_url();?>resources/images/ad_vr2.jpg">
                    </div>
        <?php } ?>
                    
    <div class="right_panel">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="sucs_msg"><?php echo $this->session->flashdata('msg');?></div>
            <?php if(!isset($pg_ck)){
            echo '<h2>Jobs List</h2>';
            }
            else{
                echo '<h2>Most Viewed Jobs</h2>';
            } ?>
            
            <?php 
            if(!empty($jobs)){                //echo "<pre>"; print_r($jobs); exit;
                $rv = 1;
                foreach($jobs as $job){
                    
?>
            <div class="result_container">
            <div class="srch_logo">
                <?php if($job['logo'] != ""){
                    echo '<img src="'.base_url().'uploads/profile_images/'.$job['logo'].'"/>';
                }elseif($job['profile_pic'] != ""){?>
                <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job['profile_pic'];?>"/>
                <?php }else{?>
                <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                <?php }?>
            </div>
            
            <div class="ttl_compjob">
                <div class="result_ttl"><a href="<?php echo $url;?>jobs/job_details/<?php echo $job['job_id'];?>"><?php echo $job['job_title']; ?></a></div>
            <div class="compny"><?php if($job['company_name'] == ""){ 
            echo $job['first_name'].' '.$job['last_name'];
            }else{
                echo $job['company_name'];
            }
            ?></div>
            </div>
            
                <div class="src_loc_icon"><a href="<?php echo base_url('');?>welcome/load_map/<?php echo $job['job_id']; ?>" title="Show Map" ><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"/> </a></div>
            <div class="srch_location loc_wid"><?php echo $job['city_name']; ?></div>
            
                    
            <div class="srch_type">
                <?php if($job['job_type'] == 2){?>
                             <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/part_time2.png"/>
                <?php }else{?>
                             <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/full_time2.png">
                <?php }?>
                 </div>
            
            <div class="srch_descrip"> 
            
                <?php if(isset($job['average']) && $job['average'] != ""){
                    $ttl_avg = count($job['average']);
                    $sum=0;
                            foreach($job['average'] as $avgo){
                                $sum = $avgo[0]['avg_rat']+$sum;
                            }
                            $avragee = $sum/$ttl_avg;
                            
                    }
                    else{
                        $avragee = 0;
                    }
                    
                    
                            if($avragee >= 0 && $avragee < 0.5){
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 0.5 && $avragee < 1){
                                        
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 1 && $avragee < 1.5){
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 1.5 && $avragee < 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 2 && $avragee < 2.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 2.5 && $avragee < 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 3 && $avragee < 3.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 3.5 && $avragee < 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 4 && $avragee < 4.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 4.5 && $avragee < 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee == 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                    }
            
            ?> 
                
            </div>
                
            
            <div class="lowr_cntnr">
            <div class="srch_time"><?php echo date("jS F Y",strtotime($job['start_date'])); ?></div>
            
            <div class="attrs">
                <a href="<?php echo base_url().'jobs/job_details/'.$job['job_id'];?>" class="attr">Overview</a>
                <a href="#popi<?php echo $rv;?>" class="fancybox attr">Review</a>
                <a href="#" class="attr last">Salaries</a>
            </div>
            
            <?php if(isset($this->session->userdata['user_data']['u_type'])){?>
            <div class="addfav_icn fav_pad">
                
                <a href="<?php echo base_url().'jobs/add_fav_job/'.$job['job_id'].'/'.$page.'/'.$job['fav_id'];?>">
                    <?php if($job['fav_id'] == ""){?>
                    <img src="<?php echo base_url(); ?>resources/images/images2/Layer41copy3.png"/>
                <?php }else{?>
                    <img width="24px" height="23px" src="<?php echo base_url(); ?>resources/images/star_full.png"/>
                <?php } ?>
                </a>
                
            </div>
            <div class="add_fav">Add To Favorites</div>
            <?php } if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 3){  ?>
            <div class="fav_apply apl_mrg">
                
                <?php if($job['apl_id'] == 0){?>
                <a href="<?php echo $url;?>jobs/job_details/<?php echo $job['job_id'];?>"><img src="<?php echo base_url().'resources/images/apply_btn.png';?>"/></a>
                <?php }else{ ?>
                <button class="apply_btn sml" value="Apply Now">Already Applied</button>
                <?php } ?>
                
            </div>
            <?php } ?>
            
            </div>
        </div>
            
            
<!--            pop up code starts here-->
            
                <div id="popi<?php echo $rv;?>" style="display:none;">
                        
                    <div class="cv_rating">
                        
                        
                        
                <?php if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 3){?>
                            <h2 class="heading_sb"><?php echo $job['job_title'];?> Rating</h2>
                            <div class="dtls">
                                <?php if(!empty($review_criteria)){ 
                                    
                                        if($rat_dv <= 20){
                                        $rat_dv = 20;
                                    }else{
                                        $rat_dv = $rat_dv;
                                    }
                                    
                                    foreach($review_criteria as $rev){ ?>
                                <div class="text"><?php echo $rev['criteria'];?></div> <div class="field"><div class="rating"  id="rate<?php echo $rat_dv;?>"></div></div>
                                
                                <div class="clearfix"></div>
                                <script>
                                var rv_id = "<?php echo $rat_dv;?>";
                                var str_rt = "<?php echo $url.'review/job_star_rating/'.$rev['id'].'/'.$job['job_id'];?>";
                                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                                </script>

                                <?php $rat_dv++;} } ?>
                                                 <?php echo form_open('review/add_job_review/'.$job['job_id']);?>
                                <div class="text">Review:</div> 
                                <div class="field">
                                    <textarea name="review" rows="9" cols="54" required></textarea>
                                </div>
                                <div class="clearfix"></div>


                                <div class="text"></div><div class="field"><input type="submit" name="post_review" value="Post Review"/></div>
                                <?php echo form_close();?>
                            </div>
                <?php } ?>
                        <div class="clearfix"></div>
            <div class="separator"></div>
            
            
                        <div class="reviews_list">
                                
                    <?php if(isset($job['average']) && $job['average'] != ""){ 
                        echo '<div class="avrage">';
                        echo '<div><h3>Average Rating</h3></div>';
                        $clr_ck=0;
                        foreach($job['average'] as $avrg){?>
                                
                                <div class="rating_cand">
                                <div> <?php echo $avrg[0]['criteria'];?> </div> <div> 
                                    
                                <?php if($avrg[0]['avg_rat'] == 0){
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 0.5 && $avrg[0]['avg_rat'] < 1){
                                        
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 1){
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 1.5 && $avrg[0]['avg_rat'] < 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 2.5 && $avrg[0]['avg_rat'] < 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 3.5 && $avrg[0]['avg_rat'] < 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 4.5 && $avrg[0]['avg_rat'] < 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                    }
                                    ?>
                                </div> </div>
                                <?php $mod = $clr_ck %2; if($mod!=0){?>
            <div class="clearfix"></div>
                                
                                <?php } $clr_ck++;} echo '<div class="clearfix"></div><div class="separator"></div> </div>'; } if($job['reviews'] != ""){ 
                                    $brk_ck = 0;
                                    foreach($job['reviews'] as $rev){
                                        
                                        echo '<div class="review_ttl"> <h3>'.$rev['first_name'].' '.$rev['last_name'].'</h3> </div>';
                                        $clr_ck = 0;
                                        if(isset($rev['ratings'])){
                                        foreach($rev['ratings'] as $rate){?>
                                
                                <div class="rating_cand">
                                <div> <?php echo $rate['criteria'];?> </div> 
                                <div> 
                                    <?php if($rate['rating'] == 0){
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 0.5){
                                        
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 1){
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 1.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 2.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 3.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 4.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                    }
                                    ?>
                                </div> </div>
                                
                                <?php $mod=$clr_ck%2; if($mod!=0){?>
                                <div class="clearfix"></div>
                                    <?php } $clr_ck++; } }?>
                                <div class="clearfix"></div>
                                <div class="review_ttl"> Review </div>
                                <div class="review_txt"> <?php echo $rev['review'];?> </div>
                                <div class="clearfix"></div>
            <div class="separator"></div>
                                <?php 
                                if($brk_ck > 5){
                                    break;
                                }
                                }}else{
                                    echo "No Reviews Found";
                                } ?>
                            </div>

            
                        
                                </div>
                            </div>
                            
                            
                            
            
            <div class="clearfix"></div>
            <div class="separator"></div>

            
            <?php $rv++; }}
            else{
                echo '<div>No Jobs Found.</div>';
            }
            //echo '</table></div>';
            if(!isset($pg_ck)){?>
        
            <div class="pagination"><?php echo $pagin; ?></div>
            <?php } ?>
	
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
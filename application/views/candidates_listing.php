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
            } ?>
            
            <div class="search_results">
        
                <div id="data_dv">
                    
            <?php 
            if(!empty($cands)){                //echo "<pre>"; print_r($jobs); exit;
                $rv = 1;
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
                 <?php
                if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                ?>
                <div class="ttl_comp aut_wid">
                <div class="result_ttl"><?php echo $job['first_name'].' '.$job['last_name'];?> </div>
                <div class="compny"> <?php echo $job['category_name'];?> </div>
                </div>     
                <?php }else{ ?>
                <div class="ttl_comp aut_wid">
                <div class="result_ttl"><a href="<?php echo base_url();?>welcome/resume_details/<?php echo $job['res_id'].'/'.$job['candidate_id'];?>"> <?php echo $job['first_name'].' '.$job['last_name'];?> </a></div>
                <div class="compny"> <?php echo $job['category_name'];?> </div>
                </div>
                <?php } ?>
            <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location"><?php echo $job['city_name'];?></div>
            
            <div class="srch_type">
                             <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/part_time2.png">
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

            
            <div class="lowr_cntnr">
            <div class="srch_time">2 Days Ago</div>
            <?php            
            if(isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
            ?>
            <div class="attrs">
                <a href="<?php echo base_url();?>welcome/resume_details/<?php echo $job['res_id'].'/'.$job['candidate_id'];?>" class="attr">Overview</a>
                <a href="#popi<?php echo $rv;?>" class="fancybox attr">Review</a>
                <a href="#" class="attr last">Salaries</a>
            </div>
           
            <div class="addfav_icn fav_pad">
                <?php if(isset($this->session->userdata['user_data']['u_type'])){?>
                <?php if($job['fav_id'] == ""){?>
                        <a href="<?php echo $url.'jobs/mark_favourite/'.$job['candidate_id'].'/'.$page.'/'.$job['res_id'].'/'; ?>"> <img width="24px" height="24px" src="<?php echo base_url();?>resources/images/star_empty.png"/></a>
                        <?php } else{?>
                        <a href="<?php echo $url.'jobs/mark_favourite/'.$job['candidate_id'].'/'.$page.'/'.$job['res_id'].'/'.$job['fav_id']; ?>"> <img width="24px" height="24px" src="<?php echo base_url();?>resources/images/star_full.png"/></a>
                        <?php } ?>
                </div>
            <div class="add_fav">Add To Favorites</div>
                <?php 
                    }           
                    }
                ?>
                        </div>
        </div>
        
                   
                    <div id="popi<?php echo $rv;?>" style="display:none;">
                        
                        <div class="cv_rating">
                            
                            <div class="reviews_list">
                                
                    <?php if(isset($job['average']) && $job['average'] != ""){ 
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
                                
                                <?php } $clr_ck++;} echo '<div class="clearfix"></div><div class="separator"></div>'; } if($job['reviews'] != ""){ 
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
                                <?php }} ?>
                            </div>
                            
                            <?php if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 4){?>
                            <h2 class="heading_sb"><?php echo $job['first_name'].' '.$job['last_name'];?> Rating</h2>
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
                                var str_rt = "<?php echo $url.'review/star_rating/'.$rev['id'].'/'.$job['res_id'].'/'.$job['candidate_id'];?>";
                                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                                </script>

                                <?php $rat_dv++;} } ?>
                                                 <?php echo form_open('review/add_resume_review/'.$job['res_id'].'/'.$job['candidate_id'].'/');?>
                                <div class="text">Review:</div> 
                                <div class="field">
                                    <textarea name="review" rows="9" cols="54" required></textarea>
                                </div>
                                <div class="clearfix"></div>


                                <div class="text"></div><div class="field"><input type="submit" name="post_review" value="Post Review"/></div>
                                <?php echo form_close();?>
                            </div>
                <?php } ?>
                        </div>
                        
                    </div>
                    
                    
        <div class="clearfix"></div>
        <div class="separator"></div>
            
            <?php $rv++;}}
            else{
                echo '<div>No Candidates Found.</div>';
            }
            
            //echo '</table></div>';
            if(!isset($pg_ck)){?>
        
            <div class="pagination"> <?php echo $pagin; ?> </div>
            <?php } ?>
            
            
            
    </div>
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
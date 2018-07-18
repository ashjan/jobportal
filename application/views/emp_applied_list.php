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
                $rv=1;
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
                <div class="result_ttl">
                    <?php if($app['resume_id'] != 0 && $app['resume_id'] != ""){
                    $ck = explode($app['resume_id'],1);
                    $check = $ck[0];
                    }
                    else{
                        $check = 0;
                    } 
                    
                    if($check == "d"){
                        
                        $ck = substr($app['resume_id'], 1, 2);
                        $resim = explode(",", $app['resume']);
                        //echo "<pre>"; print_r($resim); exit;
                        $resum_name = $resim[$ck];
                    ?>
                    
                    <div id="view_popii<?php echo $app['application_id'];?>" style="display: none;"></div>
                    <a href="#view_popii<?php echo $app['application_id'];?>" class="fancybox" onclick='view_resume(<?php echo $app['application_id'];?>, "<?php echo $resum_name;?>")'>
                    <?php }else{?>
                    <a href="<?php echo $url.'resume/resume_details/'.$app['res_id'].'/'.$app['cand_id'].'/'.$app['application_id'].'/'.$app['job_id'];?>" > 
                        
                    <?php } echo $app['first_name'].' '.$app['last_name']; ?> </a></div>
                <div class="compny"><?php if(isset($app['category_name'])){ echo $app['category_name']; } ?></div>
            <?php if(isset($app['available_date'])){
            if(strtotime($app['available_date']) > strtotime(date("Y-m-d H:i:s"))){
                $dt_cls = "sucs_msg";
            }else{
                $dt_cls = "message";
            }
            }
?>
            <div class="avail_dat"> <?php if(isset($app['available_date'])){ echo '(<span class="'.$dt_cls.'">Availabe Date: '.date("jS M Y",strtotime($app['available_date'])).'</span>)'; } ?> </div>
            </div>
            
                <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location loc_wid">Akutan</div>
            
                    
            <div class="reject_app">
                <a href="<?php echo $url.'jobs/reject_application/'.$app['application_id'].'/'.$page.'/'.$app['job_id'];?>"><input class="red_btn" type="button" name="reject" value="Reject Application"/></a>
             </div>
            
            <div class="srch_descrip"> <?php //echo substr($app['objectives'], 0, 200) ;?> 
                        
                    <?php if(isset($app['average']) && $app['average'] != ""){
                    $ttl_avg = count($app['average']);
                    $sum=0;
                            foreach($app['average'] as $avgo){
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
            
            <?php if($app['start'] != ""){
            echo '<div class="intrv_time">'.str_replace("T", " ", $app['start']).'</br> <img height="24px" src="'.base_url().'resources/images/to_arrow.png"/> </br> '.str_replace("T", " ", $app['end']).'</div>';
            } ?>
            <div class="lowr_cntnr">
            <div class="srch_time"><?php echo date("jS F Y",strtotime($app['apply_date']));?></div>
            
            <div class="attrs">
                <a class="attr" href="<?php echo $url.'resume/resume_details/'.$app['res_id'].'/'.$app['cand_id'].'/'.$app['application_id'].'/'.$app['job_id'];?>">Overview</a>
                <a href="#popi<?php echo $rv;?>" class="fancybox attr">Review</a>
                <a class="attr last" href="#">Salaries</a>
            </div>
            
            <div class="addfav_icn fav_pad">
                <?php if($app['fav_id'] == ""){?>
                        <a href="<?php echo $url.'jobs/mark_favourite/'.$app['candidate_id'].'/'.$page.'/'.$app['job_id'].'/'; ?>"> <img width="24px" height="24px" src="<?php echo base_url();?>resources/images/star_empty.png"/></a>
                        <?php } else{?>
                        <a href="<?php echo $url.'jobs/mark_favourite/'.$app['candidate_id'].'/'.$page.'/'.$app['job_id'].'/'.$app['fav_id']; ?>"> <img width="24px" height="24px" src="<?php echo base_url();?>resources/images/star_full.png"/></a>
                        <?php } ?>
                </div>
            <div class="add_fav">Add To Favorites</div>
            
            <?php if($app['start'] == ""){
                $strt = 0;
            }else{
                $strt = 1;
            }
?>
            
            <div class="schedule_intrv">
               <?php if($strt == 0){ ?>
                <a href="<?php echo $url.'jobs/schedule_interview/'.$app['application_id'].'/'.$page.'/'.$app['job_id'].'/'.$strt;?>"> <input class="green_btn" type="button" name="schedule" id="schedule" value="Schedule Interview"/> </a>
               <?php }else{?>
                 <a href="<?php echo $url.'jobs/schedule_interview/'.$app['application_id'].'/'.$page.'/'.$app['job_id'].'/'.$strt;?>"> <input class="green_btn" type="button" name="schedule" id="schedule" value="RE-schedule Interview"/> </a>
               <?php } ?>
                
            </div>
            
            </div>
        </div>
            
            <div id="popi<?php echo $rv;?>" style="display:none;">
                        
                        <div class="cv_rating">
                            
                            <div class="reviews_list">
                                
                    <?php if($app['average'] != ""){ 
                        echo '<div><h3>Average Rating</h3></div>';
                        $clr_ck=0;
                        foreach($app['average'] as $avrg){?>
                                
                                <div class="rating_cand">
                                <div> <?php echo $avrg[0]['criteria'];?> </div> <div> 
                                    
                                <?php if($avrg[0]['avg_rat'] == 0){
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 0.5 && $avrg[0]['avg_rat'] < 1){
                                        
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 1){
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 1.5 && $avrg[0]['avg_rat'] < 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 2.5 && $avrg[0]['avg_rat'] < 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 3.5 && $avrg[0]['avg_rat'] < 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 4.5 && $avrg[0]['avg_rat'] < 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                    }
                                    ?>
                                </div> </div>
                                <?php $mod = $clr_ck %2; if($mod!=0){?>
                                <div class="clearfix"></div>
                                
                                <?php } $clr_ck++;} echo '<div class="clearfix"></div><div class="separator"></div>'; } if($app['reviews'] != ""){ 
                                    foreach($app['reviews'] as $rev){
                                        
                                        echo '<div class="review_ttl"> <h3>'.$rev['first_name'].' '.$rev['last_name'].'</h3> </div>';
                                        $clr_ck = 0;
                                        if(isset($rev['ratings'])){
                                        foreach($rev['ratings'] as $rate){?>
                                
                                <div class="rating_cand">
                                <div> <?php echo $rate['criteria'];?> </div> 
                                <div> 
                                    <?php if($rate['rating'] == 0){
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 0.5){
                                        
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 1){
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 1.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 2){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 2.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 3){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 3.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 4){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 4.5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px""/>';
                                    }
                                    elseif($rate['rating'] == 5){ 
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                        echo '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px""/>';
                                    }
                                    ?>
                                </div> </div>
                                
                                <?php $mod=$clr_ck%2; if($mod!=0){?>
                                <div class="clearfix"></div>
                                    <?php } $clr_ck++; } } ?>
                                <div class="clearfix"></div>
                                <div class="review_ttl"> Review </div>
                                <div class="review_txt"> <?php echo $rev['review'];?> </div>
                                <div class="clearfix"></div>
                                <div class="separator"></div>
                                <?php }} ?>
                            </div>
                            
                            <?php if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 4){?>
                            <h2 class="heading_sb"><?php echo $app['first_name'].' '.$app['last_name'];?> Rating</h2>
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
                                var str_rt = "<?php echo $url.'review/star_rating/'.$rev['id'].'/'.$app['res_id'].'/'.$app['candidate_id'];?>";
                                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                                </script>

                                <?php $rat_dv++;} } ?>
                                                 <?php echo form_open('review/add_resume_review/'.$app['res_id'].'/'.$app['candidate_id'].'/');?>
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
            
            
            <!--New Design -->
            
            
            
            
            
           <?php
           $rv++;
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
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
    create_eve = '<?php echo base_url() . 'jobs/add_appointment/'; ?>';
    added_eve = '<?php echo base_url() . 'jobs/get_appointments/'; ?>';
    update_eve = '<?php echo base_url() . 'jobs/update_appointment/'; ?>';
    
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
    <script type="text/javascript" src="<?php echo base_url() . "resources/js/jquery.gdocsviewer.min.js" ?>"></script>
    
    <script>
        base = "<?php echo base_url();?>";
        if(base == "http://192.168.162.244:2065/jobportal/"){
            base = "http://58.65.158.188:2065/jobportal/";
        }
        else{
            base = base;
        }
        resume_urll = base+"uploads/resumes/"; 
        
    function view_resume(id,resume)
        {
            $('#view_popii'+id).html('<a class="docview" href="'+resume_urll+resume+'"></a>');
            $('a.docview').gdocsViewer({width: 860, height: 600});
            
        }
</script>
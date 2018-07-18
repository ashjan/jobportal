<!DOCTYPE html>


<?php include 'common_pages/internal_header.php';?>

<div id="background">
<!--  Left BAr portion -->

<div class="left_pannel">


<div class="clearfix"></div>
<div class="separator"></div>

<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Sortby.png" width="65" height="18" /></div>
<div style="cursor: pointer; float:left;" onmouseover="javascript: relevance_wise_search();" onmouseout="javascript: date_wise_search();">
<div id="Ellipse1">
<img id="relevance_image" src="<?php echo base_url();?>resources/images/images2/Ellipse1.png" width="15" height="15" /></div>
<div id="Ellipse1copy" style="display:none; margin-left: 22px;">
<img id="date_image" src="<?php echo base_url();?>resources/images/images2/Ellipse1copy.png" width="15" height="15" /></div>
<div class="Relevance" onmouseover="javascript: relevance_wise_search();" onmouseout="javascript: date_wise_search();">
<a href="javascript:void(0)" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','relevance')" title="Show relevance result" >
<img src="<?php echo base_url();?>resources/images/images2/Relevance.png" width="105" height="16" />
</a>
</div>
</div>
<div style="cursor: pointer; float:left;" onmouseover="javascript: date_wise_search();" onmouseout="javascript: relevance_wise_search();">
<div id="Ellipse1copy_date" style="float: left;">
<img id="date_image" src="<?php echo base_url();?>resources/images/images2/Ellipse1copy.png" width="15" height="15" /></div>
<div id="Ellipse1_date" style="display:none; float: left;">
<img id="relevance_image" src="<?php echo base_url();?>resources/images/images2/Ellipse1.png" width="15" height="15" /></div>
<div class="Relevance">
<a href="javascript:void(0)" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','date')" title="Show Latest Jobs" >
<img src="<?php echo base_url();?>resources/images/images2/Date.png" width="40" height="15" /> </a>
</div>
</div>

<div class="clearfix"></div>
<div class="separator"></div>


<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/DatePosted.png" width="100" height="15" /></div>
<div class="polig1" id="arrow_up_1">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2copy6.png" width="16" height="19" /></div>
<div class="polig1" id="arrow_down_1" style="display:none;">
<img src="<?php echo base_url();?>resources/images/images2/Polygon1copy.png" width="16" height="19" /></div>
<div class="SincelastvisitLas843">
    <ul>
    <li id="mySlideToggler1" style="cursor:pointer;" title="Click here to expand">
    Since Last Visit
    </li>
    </ul>
     
    <ul id="mySlideContent1" style="cursor:pointer;">
        <!--<li ></li>-->
        <li id="lastday" title="Show jobs of last 24 hours" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','lastday')" >Last 24 Hours</li>
        <li id="lastweek" title="Show jobs of last  week" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','lastweek')">Last 7 Days</li>
        <li id="twoweek" title="Show jobs of last two weeks " onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','twoweek')">Last 14 Days</li>
        <li id="lastmonth" title="Show jobs of last  month " onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','lastmonth')">Last 30 Days</li>
        <li id="anytime" title="Show jobs of All time" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','anytime')">Any Time</li>
    </ul>
</div>

<div class="clearfix"></div>
<div class="separator"></div>


<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/JobType.png" width="80" height="18" /></div>
<div class="polig1" id="arrow_up_2">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2copy6.png" width="16" height="19" /></div>
<div class="polig1" id="arrow_down_2" style="display:none;">
<img src="<?php echo base_url();?>resources/images/images2/Polygon1copy.png" width="16" height="19" /></div>
<div class="SincelastvisitLas843">
    <ul>
        <li id="mySlideToggler2" style="cursor:pointer;" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','all_times')"   title="Click here to expand" >All Types</li>
    </ul>
    <ul id="mySlideContent2">
        <li id="part_time"  style="cursor:pointer;" title="Show jobs of Part time" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','part_time')">Part Time</li>
        <li id="full_time"  style="cursor:pointer;" title="Show jobs of Full time" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','full_time')">Full Time</li>
    </ul>
</div>

<div class="clearfix"></div>
<div class="separator"></div>

<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Experience.png" width="100" height="18" /></div>
<div class="selct_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Morethan.png" width="70" height="16" />
</div>
<div id="RoundedRectangle6966">
    <select name="experience" id="experience" onchange="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>',this.value)" style="border-radius:1px; height: 27px;" class="sml_drop">
        <option value="all_years">Any</option>
        <option value="1_year">1 years</option>
        <option value="2_year">2 years</option>
        <option value="3_year">3 years</option>
    </select>
</div>

<div class="clearfix"></div>
<div class="separator"></div>

<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Locations.png" width="90" height="15" /></div>

<div class="AllLocationsNewYo134">
    
    <select id="location_dp" name="location" class="sml_drop" style="border-radius:1px; height: 27px;" onchange="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','location'+this.value)">
        <option value="">All</option>
        <?php foreach($locations as $loc){
            if($loc['name'] != ""){
        echo '<option value="'.$loc['name'].'">'.$loc['name'].'</option>';
        }}?>
    </select>

</div>

<div class="clearfix"></div>
<div class="separator"></div>


<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/SalaryRange.png" width="110" height="19" /></div>
<div class="selct_ttl">
<img src="<?php echo base_url();?>resources/images/images2/From.png" width="40" height="15" /></div>
<div id="RoundedRectangle6211">
    <select id="salary_from" name="salary_from" class="sml_drop" style="border-radius:1px; height: 27px;" onchange="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','salary_from'+this.value)">
        <option value="5000">5000</option>
        <option value="10000">10000</option>
        <option value="20000">20000</option>
    </select>
</div>

<div class="clearfix"></div>

<div class="selct_ttl">
<img src="<?php echo base_url();?>resources/images/images2/To.png" width="17" height="15" /></div>
<div id="RoundedRectangle6514">
    <select id="salary_to" name="salary_to" class="sml_drop" style="border-radius:1px; height: 27px;" onchange="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','salary_to'+this.value)">
        <option value="5000">5000</option>
        <option value="10000">10000</option>
        <option value="20000">20000</option>
    </select></div>

<div class="clearfix"></div>
<div class="separator"></div>


<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/CareerLevel.png" width="110" height="16" /></div>
<div class="polig1" id="arrow_up_3">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2copy6.png" width="16" height="19" /></div>
<div class="polig1" id="arrow_down_3" style="display:none;">
<img src="<?php echo base_url();?>resources/images/images2/Polygon1copy.png" width="16" height="19" /></div>

<div class="SincelastvisitLas843">
        <ul>
        <li id="mySlideToggler3" style="cursor:pointer;" title="Click here to expand" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','carear_level_0')">All</li>
        </ul>
        <ul id="mySlideContent3" style="cursor:pointer;">
        <li id="carear_level_3" title="Show jobs of Entry Level" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','carear_level_3')">Entry Level</li>
        <li id="carear_level_4" title="Show jobs Experienced" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','carear_level_4')"> Experienced</li>
        <li id="carear_level_5" title="Show jobs of Manager" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','carear_level_5')">Manager</li>
        <li id="carear_level_6" title="Show jobs of Executive" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','carear_level_6')">Executive</li>
        <li id="carear_level_7" title="Show jobs of Senior Executive" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','carear_level_7')">Senior Executive</li>
    </ul>
</div>

<div class="clearfix">
</div>

<div class="ResetFilters">
<a href="javascript: void(0)" style="text-decoration : none; color: #FFF;" title="Clear the search" onclick="javascript: clear_search();" >
Clear Search

</a>
</div>
</div>



 <div class="search_results">
 		<div id="ajax_data">
        <div class="srch_top">
        <div class="srch_ttl">Search Results</div>
        <div id="loader" style="display:none">
        <img src="<?php echo base_url('')?>resources/loader.gif" title="Loading..." />
        </div>
        
        <div class="srch_count">
        Total : <?php
		echo $jobcount->total;
		?> Record<?php if($jobcount->total > 1){echo 's';}?> found</div>
        </div>
     <div id="data_dv">
     <?php if(!empty($jobs)){$rv=1; foreach($jobs as $job){?>
        <div class="result_container">
            <div class="srch_logo"> <?php if($job['logo'] != ""){
                    echo '<img src="'.base_url().'uploads/profile_images/'.$job['logo'].'"/>';
                }elseif($job['profile_pic'] != ""){?>
                <img src="<?php echo base_url();?>uploads/profile_images/<?php echo $job['profile_pic'];?>"/>
                <?php }else{?>
                <img src="<?php echo base_url();?>uploads/profile_images/profilepic.png"/>
                <?php }?></div>
            
            <div class="ttl_comp ttl_wid">
                <div class="result_ttl"><a href="<?php echo $url.'welcome/job_details/'.$job['job_id'];?>"><?php echo $job['job_title'];?></a></div>
            <div class="compny"> <?php if($job['company_name'] == ""){ 
            echo $job['first_name'].' '.$job['last_name'];
            }else{
                echo $job['company_name'];
            }
            ?></div>
            </div><div class="src_loc_icon"><a href="<?php echo base_url('');?>welcome/load_map/<?php echo $job['job_id']; ?>" title="Show Map" ><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"/> </a></div>
            <div class="srch_location srch_loc_wid"><?php echo $job['city_name'];?></div>
            
            <div class="srch_type typ_mrg">
             <?php if($job['job_type'] == 1){?>
                <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/full_time2.png"/>
     <?php }else{?>
                <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/part_time2.png"/>
     <?php }?>
            </div>
            
            <div class="srch_descrip">
		
                <?php if(isset($job['average']) && $job['average'] != ""){
                    $ttl_avg = count($job['average']);
                    $sum=0;
                            foreach($job['average'] as $avgo){
                                $sum = $avgo[0]['avg_rat']+$sum;
                            }
                            
                            if($job['guest_rate'] != ""){
                                $ttl_rating = $sum + $job['guest_rate'];
                                $cnt_avg = $ttl_avg+1;
                                $avragee = $ttl_rating/$cnt_avg;
                            }
                            else{
                                $avragee = $sum/$ttl_avg;
                            }
                            
                    }
                    elseif($job['guest_rate'] != ""){
                        $avragee = $job['guest_rate'];
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
              <div style="padding-bottom: 10px;"></div>
                <?php 
			$job['job_description']		=	strip_HTML_tags($job['job_description']);
			echo substr($job['job_description'],0,300); ?>
           	&nbsp;
            <span class="moretag"> <a href="<?php echo $url.'welcome/job_details/'.$job['job_id'];?>" title="View detail" >More...</a> </span>
            <div style="padding-bottom: 10px;"></div>
            </div>
            
            
            
            <div class="lowr_cntnr">
            <div class="srch_time"><?php 
			 $days	=	(strtotime(date('Y-m-d H:i:s')) - strtotime($job['start_date']));
			 $days	=  abs($days);
			 $time	=	$days/86400; // time in days;
			 
			 if($time < 1){
				 // time is less than a day than convert days into hours
				 $time	=	$time * 24;
				 if($time < 1){
					 // if time is less than an hour than conert time into minuters
					 $time	=	$time * 60 ;
					 $time	=	round($time,0) ;
					 $time .= " minutes ago";
					 }
				elseif($time < 2){
					$time	=	round($time,0) ;
					$time .= " hour ago";
					}
				else{
					$time	=	round($time,0) ;
					$time .= " hours ago";
					}		 
				}
			elseif($time < 2){
				$time	=	round($time,0) ;
				$time .= " day ago";
					}
			
			elseif($time > 7 and $time < 30 ){
				$time	=	$time/7 ;
				$time	=	round($time,0) ;
				if($time > 1){
					$time .= " weeks ago";
					}
				else{
					$time .= " week ago";
					}
				
				}
			elseif($time > 30){
				$time	=	$time/30 ;
				$time	=	round($time,0) ;
				if($time > 1){
					$time .= " months ago";
					}
				else{
					$time .= " month ago";
					}	
				
				}
			else{
				$time	=	round($time,0) ;
				$time .= " days ago";
					}
						
			 echo $time;
			  ?></div>
            
            <div class="attrs">
                <a class="attr" href="<?php echo $url.'welcome/job_details/'.$job['job_id'];?>">Overview</a>
                <a href="#popi<?php echo $rv;?>" class="fancybox attr">Review</a>
                <a class="attr last" href="#">Salaries</a>
            </div>
            <?php if(isset($this->session->userdata['user_data']['usr_id'])){ ?>
            <div class="addfav_icn"><img src="<?php echo base_url();?>resources/images/images2/Layer41copy3.png"/></div>
            <div class="add_fav">Add To Favorites</div>
     <?php }?>
            </div>
        </div>
        
         
         <!--            pop up code starts here-->
            
                <div id="popi<?php echo $rv;?>" style="display:none;">
                        
                    <div class="cv_rating">
                        
                         <?php 
                if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 3){?>
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
                <?php } else{ ?>
                            
                            <h2> Give Your Rating </h2>
                            
                            <div class="rating"  id="rate<?php echo $rv;?>"></div>
                                        <script>
                                var rv_id = "<?php echo $rv;?>";
                                var str_rt = "<?php echo $url.'review/job_guest_star_rating/'.$job['job_id'];?>";
                                $('#rate'+rv_id).rating(str_rt, {maxvalue:5, increment:.5});
                                </script>
                            
                <?php } ?>
                                <div class="clearfix"></div>
                                <div class="separator"></div>
                                
                        <div class="reviews_list">
                                
                    <?php if(isset($job['average']) && $job['average'] != ""){ 
                        echo '<div class="avrage">';
                        echo '<div><h3>Average Rating</h3></div>';
                        $clr_ck=0;
                        foreach($job['average'] as $avrg){?>
                                
                                <div class="rating_candi">
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
                                
                                <?php } $clr_ck++;} echo '<div class="clearfix"></div><div class="separator"></div></div>'; } if($job['reviews'] != ""){
                                    $brk_ck=0;
                                    foreach($job['reviews'] as $rev){
                                        
                                        echo '<div class="review_ttl"> <h3>'.$rev['first_name'].' '.$rev['last_name'].'</h3> </div>';
                                        $clr_ck = 0;
                                        if(isset($rev['ratings'])){
                                        foreach($rev['ratings'] as $rate){?>
                                
                                <div class="rating_candi">
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
                                                                        break; }
                                }}else{
                                    echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        echo '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        ?>
                                        
                                        <div class="clearfix"></div>
                                        <div class="separator"></div>
            
            
            <?php
                                } ?>
                            </div>

            
                                </div>
                            </div>
                            
                            
       
        <div class="separator"></div>
     <?php $rv++;} } else {?>
     <div class="result_container">
          <div class="ttl_comp ttl_wid">
                <div class="result_ttl" style="width: 150%;"> No Record found please search again with change keywork</div>
            </div>
            
        </div>
        <?php } ?>
      
     </div>
   	 <div class="pagination">
     <?php echo $pagination; ?>
	 </div>
     </div> <!-- AJaX div end -->

    </div>
<!--</div>-->


<div class="right_long_ad">
    
    <div class="jdmo_header">More Options</div>

                    <div class="jdmo_detail" style="width:239px; padding-left:10px;">

               		  <div style="line-height:20px; font-weight:900; color:#000; font-size:11px; font-family:Verdana, Geneva, sans-serif">Job Tools</div>

					 
					  <div id="save_jobs" style="margin-top:5px;">

							

								<div id="ahmad" style="float:left; width:105px; font-weight:bold;"></div>

								
								<div class="clear"></div>

					  </div>
<div>

					


<div style="padding-top:0px;"><img src="<?php echo base_url('');?>resources/images/jt_search.png" alt="search"> <span><a style="text-decoration:none;" href="javascript: void(0);" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['ttl']; ?>','relevance')"> View Similar Jobs</a></span></div>


 <?php if(isset($this->session->userdata['search_dt']['srch']) and $this->session->userdata['search_dt']['srch'] != ''){ ?>
<div style="padding-top:0px;"><img src="<?php echo base_url('');?>resources/images/jt_search.png" alt="search"> <span><a style="text-decoration:none;"  href="javascript: void(0);" onclick="javascript: showrecord('<?php echo $this->session->userdata['search_dt']['srch']; ?>','searchallcityjob')">View All <?php echo $this->session->userdata['search_dt']['srch']; ?> Jobs</a></span></div>

<?php } ?>


<div style="padding-top:0px;"><img src="<?php echo base_url('');?>resources/images/jt_search.png" alt="search"> <span><a style="text-decoration:none;" href="javascript: void(0);" onclick="javascript: showrecord('searchalljob','searchalljob')">  Search All Jobs</a></span></div>

<div style="height:18px;"></div>

 <div style="padding-right:0px"><a href="http://www.bayrozgar.com/job_alert.php" style="font-family:Arial, Helvetica, sans-serif"><img src="<?php echo base_url('');?>resources/images/job_alert_icon.jpg" alt="" width="30" height="26"> <span>Creare job alert for this</span></a> 

 

 </div>

                    <div class="clear"></div>

                    </div>

                   

                   <div class="clear"> </div>

				   

                    </div>
    
<div id="Rectangle15copy">
<img src="<?php echo base_url();?>resources/images/ad_vr1.png" width="198" height="936" /></div>
</div>


</div>
</div>




<?php include 'common_pages/internal_footer.php';?>

<script>
base = '<?php echo base_url();?>';
ser_url = '<?php echo base_url();?>welcome/advance_search/';

function advnc_search()
{  
    //var you = $('#you').val();     
    var loc = $('#location_dp').val();
    var sal = $('#salary_from').val();
    var sl_to = $('#salary_to').val();
    
//    if(you == "")
//    {
//        you = 1;
//    }
    
    var search = loc +'_'+ sal +'_'+ sl_to;
    
    $.ajax({url: ser_url + search, success: function(result) {
            
            obj = [];
                    obj = JSON.parse(result);
                 var jobs = "";
                 if(obj != ""){
                     
                     for(i in obj){
                         
            jobs +='<div class="result_container">';
            jobs +='<div class="srch_logo"><img src="'+ base +'uploads/profile_images/'+ obj[i]['profile_pic'] +'"/></div>';
            
            jobs +='<div class="ttl_comp ttl_wid">';
            jobs +='<div class="result_ttl"><a href="'+ base +'/welcome/job_details/'+ obj[i]['job_id'] +'">'+ obj[i]['job_title'] +'</a></div>';
            jobs +='<div class="compny">'+ obj[i]['first_name'] +' '+ obj[i]['last_name'] +'</div>';
            jobs +='</div>';
            
            jobs +='<div class="src_loc_icon"><img src="'+ base +'resources/images/images2/Layer40copy3.png"/></div>';
            jobs +='<div class="srch_location srch_loc_wid">'+ obj[i]['city_name'] +'</div>';
            
            jobs +='<div class="srch_type typ_mrg">';
             if(obj[i]['job_type'] == 1){
                jobs +='<img width="125px" height="36px" src="'+ base +'resources/images/images2/full_time2.png"/>';
      }else{
                jobs +='<img width="125px" height="36px" src="'+ base +'resources/images/images2/part_time2.png"/>';
     }
            jobs +='</div>';
            
            jobs +='<div class="srch_descrip">'+ obj[i]['job_description'] +' </div>';
            
            jobs +='<div class="lowr_cntnr">';
            jobs +='<div class="srch_time">'+ prettyDate(obj[i]['start_date']) +'</div>';
            
            jobs +='<div class="attrs">';
                jobs +='<a class="attr" href="'+ base +'/welcome/job_details/'+ obj[i]['job_id'] +'">Overview</a>';
                jobs +='<a class="attr" href="#">Review</a>';
                jobs +='<a class="attr last" href="#">Salaries</a>';
            jobs +='</div>';
            
            jobs +='<div class="addfav_icn"><img src="'+ base +'resources/images/images2/Layer41copy3.png"/></div>';
            jobs +='<div class="add_fav">Add To Favorites</div>';
     
            jobs +='</div>';
        jobs +='</div>'; 
                         
                         
                     }
                     $('#data_dv').html(jobs);
                 }
            
    }});
}

</script>
<?php 
for($i=1; $i<=5; $i++ ) {?>
<script type="text/javascript">
	$(function(){
		$('#mySlideContent<?php echo $i;?>').css('display','none');
		$('#mySlideToggler<?php echo $i;?>').click(function(){
			$('#mySlideContent<?php echo $i;?>').slideToggle('slow');
			//$(this).toggleClass('slideSign');
			if($('#arrow_down_<?php echo $i;?>').is(':visible')){
			$('#arrow_down_<?php echo $i;?>').hide();
			$('#arrow_up_<?php echo $i;?>').show();
			}else{
			$('#arrow_down_<?php echo $i;?>').show();	
			$('#arrow_up_<?php echo $i;?>').hide();
				}
			return false;
		});
	});
</script>
<?php } ?>
<script type="text/javascript">APPLICATION_URL='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>resources/js/search.js"> </script>
<?php
function strip_HTML_tags($text)
{ // Strips HTML 4.01 start and end tags. Preserves contents.
    return preg_replace('%
        # Match an opening or closing HTML 4.01 tag.
        </?                  # Tag opening "<" delimiter.
        (?:                  # Group for HTML 4.01 tags.
          ABBR|ACRONYM|ADDRESS|APPLET|AREA|A|BASE|BASEFONT|BDO|BIG|
          BLOCKQUOTE|BODY|BR|BUTTON|B|CAPTION|CENTER|CITE|CODE|COL|
          COLGROUP|DD|DEL|DFN|DIR|DIV|DL|DT|EM|FIELDSET|FONT|FORM|
          FRAME|FRAMESET|H\d|HEAD|HR|HTML|IFRAME|IMG|INPUT|INS|
          ISINDEX|I|KBD|LABEL|LEGEND|LI|LINK|MAP|MENU|META|NOFRAMES|
          NOSCRIPT|OBJECT|OL|OPTGROUP|OPTION|PARAM|PRE|P|Q|SAMP|
          SCRIPT|SELECT|SMALL|SPAN|STRIKE|STRONG|STYLE|SUB|SUP|S|
          TABLE|TD|TBODY|TEXTAREA|TFOOT|TH|THEAD|TITLE|TR|TT|U|UL|VAR
        )\b                  # End group of tag name alternative.
        (?:                  # Non-capture group for optional attribute(s).
          \s+                # Attributes must be separated by whitespace.
          [\w\-.:]+          # Attribute name is required for attr=value pair.
          (?:                # Non-capture group for optional attribute value.
            \s*=\s*          # Name and value separated by "=" and optional ws.
            (?:              # Non-capture group for attrib value alternatives.
              "[^"]*"        # Double quoted string.
            | \'[^\']*\'     # Single quoted string.
            | [\w\-.:]+      # Non-quoted attrib value can be A-Z0-9-._:
            )                # End of attribute value alternatives.
          )?                 # Attribute value is optional.
        )*                   # Allow zero or more attribute=value pairs
        \s*                  # Whitespace is allowed before closing delimiter.
        /?                   # Tag may be empty (with self-closing "/>" sequence.
        >                    # Opening tag closing ">" delimiter.
        | <!--.*?-->         # Or a (non-SGML compliant) HTML comment.
        | <!DOCTYPE[^>]*>    # Or a DOCTYPE.
        %six', '', $text);
}
 ?>
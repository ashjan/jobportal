<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php include 'common_pages/internal_header.php';?>

<div id="background">
<!--  Left BAr portion -->

<div class="left_pannel">

<!--<div id="Rectangle8">
<img src="<?php echo base_url();?>resources/images/images2/Rectangle8.png" width="297" height="1202" /></div>-->
<!--<div id="Shape5copy12">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy12.png" width="268" height="5" /></div>
<div id="Shape5copy13">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy13.png" width="268" height="5" /></div>-->
<div class="Refinements">
<img src="<?php echo base_url();?>resources/images/images2/Refinements.png" width="180" height="21" /></div>
<!--<div id="Shape5copy6">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy6.png" width="268" height="5" /></div>-->
<div class="clearfix"></div>
<div class="separator"></div>

<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Sortby.png" width="75" height="18" /></div>
<div id="Ellipse1">
<img src="<?php echo base_url();?>resources/images/images2/Ellipse1.png" width="18" height="18" /></div>
<div class="Relevance">
<img src="<?php echo base_url();?>resources/images/images2/Relevance.png" width="105" height="16" /></div>
<div id="Ellipse1copy">
<img src="<?php echo base_url();?>resources/images/images2/Ellipse1copy.png" width="18" height="18" /></div>
<div class="Relevance">
<img src="<?php echo base_url();?>resources/images/images2/Date.png" width="47" height="15" /></div>

<div class="clearfix"></div>
<div class="separator"></div>

<!--<div id="Shape5copy10">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy10.png" width="268" height="5" /></div>-->
<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/DatePosted.png" width="125" height="15" /></div>
<div class="polig1">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2.png" width="16" height="19" /></div>
<div class="SincelastvisitLas843">
    <ul>
        <li>Since Last Visit</li>
        <li>Last 24 Hours</li>
        <li>Last 7 Days</li>
        <li>Last 14 Days</li>
        <li>Last 30 Days</li>
        <li>Any Time</li>
    </ul>
</div>

<div class="clearfix"></div>
<div class="separator"></div>

<!--<div id="Shape5copy11">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy11.png" width="268" height="5" /></div>-->
<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/JobType.png" width="96" height="18" /></div>
<div class="polig1">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2copy.png" width="16" height="19" /></div>
<div class="SincelastvisitLas843">
    <ul>
        <li>All Types</li>
        <li>Part Time</li>
        <li>Full Time</li>
    </ul>
</div>

<div class="clearfix"></div>
<div class="separator"></div>

<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Experience.png" width="114" height="18" /></div>
<div class="selct_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Morethan.png" width="104" height="16" />
</div>
<div id="RoundedRectangle6966">
    <select name="" id="" class="sml_drop">
        <option value="">Any</option>
        <option value="">1 years</option>
        <option value="">2 years</option>
        <option value="">3 years</option>
    </select>
</div>

<div class="clearfix"></div>
<div class="separator"></div>

<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/Locations.png" width="99" height="15" /></div>
<div class="polig1">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2copy2.png" width="16" height="19" /></div>
<div class="AllLocationsNewYo134">
    <select id="location_dp" name="location" class="sml_drop" onchange="javascript:advnc_search();">
        <option value="">All</option>
        <?php foreach($locations as $loc){
            if($loc['name'] != ""){
        echo '<option value="'.$loc['name'].'">'.$loc['name'].'</option>';
        }}?>
    </select>
<!--    <ul>
        <li>All Locations</li>
        <li>New York</li>
        <li>Chicago</li>
        <li>Sanfrancisco</li>
        <li>Other</li>
    </ul>-->
</div>

<div class="clearfix"></div>
<div class="separator"></div>

<!--<div id="Shape5copy14">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy14.png" width="268" height="5" /></div>-->
<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/SalaryRange.png" width="136" height="19" /></div>
<div class="selct_ttl">
<img src="<?php echo base_url();?>resources/images/images2/From.png" width="52" height="15" /></div>
<div id="RoundedRectangle6211">
    <select id="salary_from" name="salary_from" class="sml_drop" onchange="javascript:advnc_search();">
        <option value="5000">5000</option>
        <option value="10000">10000</option>
        <option value="20000">20000</option>
    </select>
</div>

<div class="clearfix"></div>

<div class="selct_ttl">
<img src="<?php echo base_url();?>resources/images/images2/To.png" width="24" height="15" /></div>
<div id="RoundedRectangle6514">
    <select id="salary_to" name="salary_to" class="sml_drop" onchange="javascript:advnc_search();">
        <option value="5000">5000</option>
        <option value="10000">10000</option>
        <option value="20000">20000</option>
    </select></div>

<div class="clearfix"></div>
<div class="separator"></div>

<!--<div id="Shape5copy15">
<img src="<?php echo base_url();?>resources/images/images2/Shape5copy15.png" width="268" height="5" /></div>-->
<div class="adv_ttl">
<img src="<?php echo base_url();?>resources/images/images2/CareerLevel.png" width="128" height="16" /></div>
<div class="polig1">
<img src="<?php echo base_url();?>resources/images/images2/Polygon2copy6.png" width="16" height="19" /></div>
<div class="SincelastvisitLas843">
        <ul>
        <li>All</li>
        <li>Entry Level</li>
        <li>Experienced</li>
        <li>Manager</li>
        <li>Executive</li>
        <li>Senior Executive</li>
    </ul>
</div>


<!--<div id="RoundedRectangle7905">
<img src="<?php echo base_url();?>resources/images/images2/RoundedRectangle7905.png" width="185" height="60" /></div>-->
<div class="ResetFilters">
<img src="<?php echo base_url();?>resources/images/images2/ResetFilters.png" width="141" height="17" /></div>
</div>



 <div class="search_results">
        <div class="srch_top">
        <div class="srch_ttl">Search Results</div>
        <div class="srch_count"><?php $count_jobs = count($jobs); echo $count_jobs." ";?> Job<?php if($count_jobs > 1){echo 's';}?></div>
        </div>
     <div id="data_dv">
     <?php if(!empty($jobs)){ foreach($jobs as $job){?>
        <div class="result_container">
            <div class="srch_logo"><img src="<?php echo base_url().'uploads/profile_images/'.$job['profile_pic'];?>"/></div>
            
            <div class="ttl_comp ttl_wid">
                <div class="result_ttl"><a href="<?php echo $url.'/welcome/job_details/'.$job['job_id'];?>"><?php echo $job['job_title'];?></a></div>
            <div class="compny"><?php echo $job['first_name'].' '.$job['last_name'];?></div>
            </div>
            
            <div class="src_loc_icon"><img height="25px" src="<?php echo base_url();?>resources/images/images/Layer40copy4.png"/></div>
            <div class="srch_location srch_loc_wid"><?php echo $job['city_name'];?></div>
            
            <div class="srch_type typ_mrg">
             <?php if($job['job_type'] == 1){?>
                <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/full_time2.png"/>
     <?php }else{?>
                <img width="125px" height="36px" src="<?php echo base_url();?>resources/images/images2/part_time2.png"/>
     <?php }?>
            </div>
            
            <div class="srch_descrip"><?php echo $job['job_description'];?> </div>
            
            <div class="lowr_cntnr">
            <div class="srch_time">2 Days Ago</div>
            
            <div class="attrs">
                <a class="attr" href="<?php echo $url.'/welcome/job_details/'.$job['job_id'];?>">Overview</a>
                <a class="attr" href="#">Review</a>
                <a class="attr last" href="#">Salaries</a>
            </div>
            <?php if(isset($this->session->userdata['user_data']['usr_id'])){ ?>
            <div class="addfav_icn"><img src="<?php echo base_url();?>resources/images/images2/Layer41copy3.png"/></div>
            <div class="add_fav">Add To Favorites</div>
     <?php }?>
            </div>
        </div>
        
        <div class="clearfix"></div>
        <div class="separator"></div>
     <?php } }?>
     </div>

    </div>
    


<div class="right_long_ad">
<div id="Rectangle15copy">
<img src="<?php echo base_url();?>resources/images/ad_vr1.png" width="198" height="936" /></div>
</div>


</div>


<div class="result_container">
            <div class="srch_logo"><img src="http://localhost/jobportal/uploads/profile_images/14147364881.PNG"></div>
            
            <div class="ttl_comp ttl_wid">
                <div class="result_ttl"><a href="http://localhost/jobportal/index.php/welcome/job_details/3">Java EE developer</a></div>
            <div class="compny">Ovex Tech</div>
            </div>
            
            <div class="src_loc_icon"><img height="25px" src="http://localhost/jobportal/resources/images/images/Layer40copy4.png"></div>
            <div class="srch_location srch_loc_wid">Agua Dulce</div>
            
            <div class="srch_type typ_mrg">
                             <img width="125px" height="36px" src="http://localhost/jobportal/resources/images/images2/full_time2.png">
                 </div>
            
            <div class="srch_descrip">The person should be capable of making the application of java an the related technologies. </div>
            
            <div class="lowr_cntnr">
            <div class="srch_time">2 Days Ago</div>
            
            <div class="attrs">
                <a href="http://localhost/jobportal/index.php/welcome/job_details/3" class="attr">Overview</a>
                <a href="#" class="attr">Review</a>
                <a href="#" class="attr last">Salaries</a>
            </div>
                        </div>
        </div>


<?php include 'common_pages/internal_footer.php';?>

<script>
base = '<?php echo base_url();?>';
ser_url = '<?php echo base_url();?>index.php/welcome/advance_search/';

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

<?php include 'login_popup.php';?>
<?php
 	// getting widget data
	$widget1_menus_items=$this->menu_manager->load_widget1_menus();
                
	$widget2_menus_items=$this->menu_manager->load_widget2_menus();
		
	$widget3_menus_items  =  $this->menu_manager->load_widget3_menus();
 ?>

<script>
        
        link_frm  = '<?php echo base_url();?>index.php/jobs/camp_admin';
        link_cmp  = '<?php echo base_url();?>campaign/admin/';
        
        <?php if(isset($this->session->userdata['user_data']['usr_id'])){?>
    link_auto = '<?php echo base_url();?>index.php/jobs/auto_comp_data/';
        link_search = '<?php echo base_url();?>index.php/jobs/inner_search_data/';
    <?php }else{?>
            link_auto = '<?php echo base_url();?>index.php/welcome/auto_comp_data/';
        link_search = '<?php echo base_url();?>index.php/welcome/inner_search_data/';
        <?php }?>
//        var srch = '';
//        function auto_comp(ele)
//        {
//            var srch = ele.value;
//        }
//        
//        alert(srch); 
//        
//        
//        
//        
//        var 
       var jobs = ""; 
    function auto_comp(ele)
        {
            var srch = ele.value;
             $.ajax({
                url: link_auto,
                type: 'post',
                data: {search_box: srch},
                success: function(dta) {
                 var jobs = dta;
                 //alert(jobs);
                      
                }
            });
        }
        
     
     
//     $(function(){
//  
//  // setup autocomplete function pulling from currencies[] array
//  
//  //var srch = $("#autocomplete").val();
//             
//                 var jobs = '<?php //json_encode($auto_results)?>';
//                 //alert(jobs);
//                 $('#autocomplete').autocomplete({
//    lookup: jobs,
//    onSelect: function (suggestion) {
//      var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
//      $('#outputcontent').html(thehtml);
//    }
//  });
//
//});
     
     var options, a;
jQuery(function(){
	options = { serviceUrl:link_auto,
        minChars:1,
	delimiter: /(,|;)\s*/, // regex or character
	deferRequestBy: 0, //miliseconds //aditional parameters
	noCache: false //default is false, set to true to disable caching
	// callback function:
//	onSelect: function(suggestion){
//            $.ajax({
//                url: link_search+suggestion.value,
//                success: function(dta) {
//                 var jobs = dta;
//                window.location.replace(link_search+suggestion.data);
//                 //alert(jobs);
//                }
//            });
//        //alert('You selected: ' + suggestion.value); 
//    }
    };
	a = $('#autocomplete').autocomplete(options);
});
     
     
//     $(function(){
//
//var currencies = <?php 			  
			  //echo json_encode($categories);//format the array into json data
              ?>//;
//  alert(currencies);
//  // setup autocomplete function pulling from currencies[] array
//  $('#autocomplete').autocomplete({
//    lookup: currencies,
//    onSelect: function (suggestion) {
//      var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
//      $('#outputcontent').html(thehtml);
//    }
//  });
//});
     
     
    
    $("#login-form").submit( function(e) {
       var pag = $('#page').val();
        var lgn = $('#lgn').val();
        var pas = $('#pas').val();
        var proc = $('#proc').val();
        
        e.preventDefault();
        $.ajax({
        url: link_cmp,
        type: 'post',
        dataType: 'html',
        data: {login: lgn ,
        password: pas,
        page: pag,
        process: proc},
        success: function(data) {
            
                   console.log(data);
            if (data.reply == 1) {
                
                    window.location.replace(link_cmp); //HTTP Redirect
                }
                window.location.replace(link_cmp); 
                 }
    });
});
        </script>
<!--<div class="footer_outer">
<div class="footer">
     
     <div class="footer_container">
         <div class="footer_ttl">INFORMATION</div>
         <ul class="footer_lnks">
             <li><a href="#">HOME</a></li>
             <li><a href="#">ABOUT US</a></li>
             <li><a href="#">JOBS</a></li>
             <li><a href="#">CANDIDATES</a></li>
             <li><a href="#">COMPANIES</a></li>
             <li><a href="#">PRICING AND PLANS</a></li>
             <li><a href="#">PRIVACY POLICY</a></li>
             <li><a href="#">TERMS AND CONDITIONS</a></li>
             <li><a href="#">TESTIMONIALS</a></li>
             <li><a href="#">CONTACT US</a></li>
             <li><a href="#">FAQ'S</a></li>
         </ul>
     </div>
     
     <div class="footer_container">
        <div class="footer_ttl">SERVICES</div>
         <ul class="footer_lnks">
             <li><a href="#">POST A JOB</a></li>
             <li><a href="#">POST A RESUME</a></li>
             <li><a href="#">FIND A JOB</a></li>
             <li><a href="#">FIND A CANDIDATE</a></li>
             <li><a href="#">MANAGE JOBS</a></li>
             <li><a href="#">MANAGE RESUMES</a></li>
         </ul>
     </div>
     
     
     <div class="footer_container spacer">
         <div class="footer_ttl">MY ACCOUNT</div>
         <ul class="footer_lnks">
             <li><a href="#">SIGN IN</a></li>
             <li><a href="#">MY ALERTS</a></li>
             <li><a href="#">VIEW PROFILE</a></li>
             <li><a href="#">EDIT PROFILE</a></li>
             <li><a href="#">MY DASHBOARD</a></li>
             <li><a href="#">HELP</a></li>
         </ul>
     </div>
     
     <div class="footer_container">
         <div class="footer_ttl">FOLLOW US</div>
         <ul class="footer_lnks">
             <li><a href="#"><div class="social_icon"><img src="<?php echo base_url().'resources/images/images/twitter.png';?>"/></div>TWITTER</a></li>
             <li><a href="#"><div class="social_icon"><img src="<?php echo base_url().'resources/images/images/facebook.png';?>"/></div>FACEBOOK</a></li>
             <li><a href="#"><div class="social_icon"><img src="<?php echo base_url().'resources/images/images/rss.png';?>"/></div>RSS</a></li>
         </ul>
     </div>
     
     
     <div class="prop_txt">
         This website is not officially sponsored by CISCO Systems (R).</br>
         This website is neitehr affiliated with nor endorsed by CISCO Systems Inc.</br>
         “Cisco, “CCIE, “CCSI, “CCNP, “CCSP, “CCIP, “CCNA, “CCDA, “CCDP, are trademarks owned by Cisco Systems Inc.</br>
We respect the Trademarks of all other mentioned companies and institutions. When you send information to us, you grant us a non-exclusive right to use or distribute the information in any way we believe appropriate without incurring any obligation to you. 
     </div>
     
 
</div>

</div>-->





<div class="footer_outer">
<div class="footer">
     
     <div class="footer_container">
         <div class="footer_ttl">INFORMATION</div>
         <ul class="footer_lnks">
                               
                               
                               
                               
                               
                               <?php 
                              
	 if(count($widget1_menus_items)==0){
		}else{
		for($i=0; $i<count($widget1_menus_items);$i++){?>
		<li>
                    <a  href="<?php echo base_url().'index.php/content/display/'.$widget1_menus_items[$i]->content_id; ?>" >
                               <?php echo $widget1_menus_items[$i]->menu_title; ?>
                    </a>
                </li>
      <?php }
	  echo '<br>';
	  } ?>
              
         
         
     </ul>
     </div>
     
     <div class="footer_container">
        <div class="footer_ttl">SERVICES</div>
         <ul class="footer_lnks">
            
            		<?php 
	 if(count($widget2_menus_items)==0){
		}else{
		for($i=0; $i<count($widget2_menus_items);$i++){?>
                        
             <li>
                        <a  href="<?php echo base_url().'index.php/content/display/'.$widget2_menus_items[$i]->content_id; ?>" >    
			<?php echo $widget2_menus_items[$i]->menu_title; ?>
			</a>
             </li>    
      <?php }
	  echo '<br>';
	  } ?> 
            
            
                        </ul>
     </div>
     
     
     <div class="footer_container spacer">
         <div class="footer_ttl">MY ACCOUNT</div>
         <ul class="footer_lnks">
			
                            <?php	if(count($widget3_menus_items)==0){
		}else{
		for($i=0; $i<count($widget3_menus_items);$i++){?>
             <li>
                        <a  href="<?php echo base_url().'index.php/content/display/'.$widget3_menus_items[$i]->content_id; ?>" >
			<?php echo $widget3_menus_items[$i]->menu_title ; ?>                                
			</a>
             </li>     
      <?php }
	  echo '<br>';
          } ?>
                        
                         </ul>
     </div>
     
          <div class="footer_container last">
         <div class="footer_ttl">FOLLOW US</div>
         <ul class="footer_lnks">
             <li><a href="#"><div class="social_icon"><img src="<?php echo base_url().'resources/images/images/twitter.png';?>"/></div>TWITTER</a></li>
             <li><a href="#"><div class="social_icon"><img src="<?php echo base_url().'resources/images/images/facebook.png';?>"/></div>FACEBOOK</a></li>
             <li><a href="#"><div class="social_icon"><img src="<?php echo base_url().'resources/images/images/rss.png';?>"/></div>RSS</a></li>
         </ul>
     </div>
     
     
     <div class="prop_txt">
<!--         This website is not officially sponsored by CISCO Systems (R).</br>
         This website is neitehr affiliated with nor endorsed by CISCO Systems Inc.</br>
         “Cisco, “CCIE, “CCSI, “CCNP, “CCSP, “CCIP, “CCNA, “CCDA, “CCDP, are trademarks owned by Cisco Systems Inc.</br>
We respect the Trademarks of all other mentioned companies and institutions. When you send information to us, you grant us a non-exclusive right to use or distribute the information in any way we believe appropriate without incurring any obligation to you. 
     --></div>
     
 
</div>

</div>
<?php



$currrnt_url = current_url(); 
$exp_ur = explode("/",$currrnt_url); 
//echo "<pre>";print_r($exp_ur); exit;
if(isset($this->session->userdata['user_data']['is_user_logged_in']) && $exp_ur[5] == "comp_profile_editor"){?>
<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true"></script>

<script>
//    $.noConflict();
        var latitudee = '<?php echo $profile[0]['latitude'];?>';
        var longitudee =  '<?php echo $profile[0]['longitude'];?>';
        
        var latt = '';
        var lngg = '';
        if(latitudee != "" && longitudee != ""){
            latt = latitudee
            lngg = longitudee
        }else{
            latt = 33.7337589;
            lngg =  73.13496050000003;
        }
        
        
    $(function () {
        
         var lat = latt,
             lng = lngg,
             latlng = new google.maps.LatLng(lat, lng),
             image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';

         //zoomControl: true,
         //zoomControlOptions: google.maps.ZoomControlStyle.LARGE,

         var mapOptions = {
             center: new google.maps.LatLng(lat, lng),
             zoom: 13,
             mapTypeId: google.maps.MapTypeId.ROADMAP,
             panControl: true,
             panControlOptions: {
                 position: google.maps.ControlPosition.TOP_RIGHT
             },
             zoomControl: true,
             zoomControlOptions: {
                 style: google.maps.ZoomControlStyle.LARGE,
                 position: google.maps.ControlPosition.TOP_left
             }
         },
         map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
             marker = new google.maps.Marker({
                 position: latlng,
                 map: map,
                 icon: image
             });

         var input = document.getElementById('searchTextField');
         var autocomplete = new google.maps.places.Autocomplete(input, {
             types: ["geocode"]
         });

         autocomplete.bindTo('bounds', map);
         var infowindow = new google.maps.InfoWindow();

         google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
             infowindow.close();
             var place = autocomplete.getPlace();
             if (place.geometry.viewport) {
                 map.fitBounds(place.geometry.viewport);
             } else {
                 map.setCenter(place.geometry.location);
                 map.setZoom(17);
             }

             moveMarker(place.name, place.geometry.location);
             
             $('.MapLat').val(place.geometry.location.lat());
             $('.MapLon').val(place.geometry.location.lng());
         });
         google.maps.event.addListener(map, 'click', function (event) {
             $('.MapLat').val(event.latLng.lat());
             $('.MapLon').val(event.latLng.lng());
         });
         $("#searchTextField").focusin(function () {
             $(document).keypress(function (e) {
                 if (e.which == 13) {
                     return false;
                     infowindow.close();
                     var firstResult = $(".pac-container .pac-item:first").text();
                     var geocoder = new google.maps.Geocoder();
                     geocoder.geocode({
                         "address": firstResult
                     }, function (results, status) {
                         if (status == google.maps.GeocoderStatus.OK) {
                             var lat = results[0].geometry.location.lat(),
                                 lng = results[0].geometry.location.lng(),
                                 placeName = results[0].address_components[0].long_name,
                                 latlng = new google.maps.LatLng(lat, lng);

                             moveMarker(placeName, latlng);
                             $("input").val(firstResult);
                         }
                     });
                 }
             });
         });

         function moveMarker(placeName, latlng) {
             marker.setIcon(image);
             marker.setPosition(latlng);
             infowindow.setContent(placeName);
             //infowindow.open(map, marker);
         }
     });
    
    </script>
<?php } ?>
</html>

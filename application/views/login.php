<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/divbraries/REST_Controller.php';
//var_dump($this->session->all_userdata());
include("common_pages/internal_header.php");
?>
<script>
        
        fb_log_url = '<?php echo base_url().'welcome/fb_login/';?>';
        red_url = '<?php echo base_url().'welcome'; ?>';
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
	if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '698823353529276',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });


  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
             
                $.post(fb_log_url, 
                            {
                                fb_dt: response
                            }, 
                            function(e) {
                               alert(e);
                                if(e == 'yes')
                                {
                                  window.location.href = red_url;
                                  
                                }
                                else
                                {
                                    window.location.href = '<?php echo base_url().'welcome/login/'?>';
                                    
                                }
                            });
    });
  }
</script>
<body>
		<div id="background">
	
                    <div class="left_pannel">
                        <img width="256px" height="500px" src="<?php echo base_url();?>resources/images/ad_vr2.jpg"/>
                        
                    </div>
                    
                    <div class="right_panel_login">
        <div class="login_outer">
	<div id="login_body">
            <h2>Login</h2>

            <?php echo form_open('welcome/login');?>

<div class="sucs_msg"> <?php echo $this->session->flashdata('msg'); ?></div>
            <div class="message"><?php echo $this->session->flashdata('msgg');
            echo $this->session->flashdata('err_msg');
            echo validation_errors();
			if($this->session->userdata('referrer_page') == 'package')	{
				echo "In order to buy this pricing plan please login.<br />";
				echo "Not a member? <a href='".base_url()."registration'>Join US </a> <br />";
				$this->session->unset_userdata('referrer_page');
				
				}
			?></div>
            
                <div class="text">User Name:</div>
                <div class="field"><input type="text" class="inpt_fld" name="username" id="username" required/></div>
                <div class="clearfix"></div>
                
                <div class="text">Password:</div>
                <div class="field"><input type="password" class="inpt_fld" name="password" id="pass" required/></div>
                <div class="clearfix"></div>
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Login"/></div>
                <div class="clearfix"></div>
                <a href="<?php echo base_url().'registration'?>">
                <img src="<?php echo base_url().'resources/images/signup.png'?>"/>
                </a>
                
                <?php echo form_close();?>
                <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '698823353529276',
      xfbml      : true,
      version    : 'v2.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
	</div>
        
            </div>
                        
                        
        <div class="clearfix"></div>
        
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>
        
        <div class="clearfix"></div>
        
        <a style="cursor: pointer;" href="<?php echo base_url();?>welcome/login_with_linkedin"> Login With Linkedin </a>

<div id="status">
</div>
        
        <div class="resultswrap"  id="resultss">
        </div>
        </div>
                    
                    <div class="right_adds">
                            <img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq1.png';?>"/>
                            <div class="clearfix"></div>
                            <img width="244px" height="250px" src="<?php echo base_url().'resources/images/ad_sq2.png';?>"/>
                        </div>
        
</div>

<?php include("common_pages/internal_footer.php"); ?>  
<script>

ser_url = '<?php echo $url;?>welcome/advance_search/';
urll = '<?php echo $url;?>';

function advnc_search()
{
    var you = $('#you').val();     
    var wht = $('#what').val();
    var whr = $('#where').val();
    var sal = $('#salar').val();
    var sl_to = $('#desig').val();
    var edu = $('#edu').val();
    //var com = $('#comp').val();
    var cat = $('#categ').val();
    var from = $('#from_dat').val();
    var to = $('#to_dat').val();
    
    if(you == "")
    {
        you = 1;
    }
    
    var search = you +'_'+ wht +'_'+ whr +'_'+ sal +'_'+ sl_to +'_'+ edu +'_'+cat+'_'+from+'_'+to;
    
    $.ajax({url: ser_url + search, success: function(result) {
            
            obj = [];
                    obj = JSON.parse(result);
                 var jobs = "";
                 if(obj != ""){
                     jobs += '<table class="results">';
                     if(you == 1)
                     {
                            jobs +='<thead>'
                            jobs +='<th>Job Title</th>';
                            jobs +='<th>Category</th>';
                            jobs +='<th>Location</th>';
                            jobs +='<th>Posted</th>';
                            jobs +='</thead>';

                            for(i in obj){

                                jobs += '<tr><td class="ttll"><a href="'+ urll +'/welcome/job_details/'+ obj[i]['job_id'] +'/'+ you +'">'+ obj[i]['job_title'] +'</a></td>';
                                jobs += '<td>'+ obj[i]['category_name'] +'</td>';
                                jobs += '<td>'+ obj[i]['city_name'] +'</td>';
                                jobs += '<td>'+ obj[i]['start_datee'] +'</td></tr>';

                            }
                        }
                        else
                        {
                            jobs +='<thead>'
                            jobs +='<th>Name</th>';
                            jobs +='<th>Category</th>';
                            jobs +='<th>Location</th>';
                            jobs +='<th>Expected Salary</th>';
                            jobs +='</thead>';

                            for(i in obj){

                                jobs += '<tr><td class="ttll"><a href="'+ urll +'/welcome/resume_details/'+obj[i]['res_id'] +'/'+ obj[i]['candidate_id'] +'">'+ obj[i]['first_name'] +'</a></td>';
                                jobs += '<td>'+ obj[i]['category_name'] +'</td>';
                                jobs += '<td>'+ obj[i]['city_name'] +'</td>';
                                jobs += '<td>'+ obj[i]['expected_salary'] +'</td></tr>';

                            }
                        }
                     jobs += '</table>';   
                 }
                 else{
                        jobs += '<table class="results">'; 
                        jobs += '<tr><td>No Job found in this category</td></tr>';
                        jobs += '</table>';
                 }
                $('#resultss').html(jobs);
            
    }});
    //alert(you +'->'+ wht +'->'+ whr +'->'+ sal +'->'+ des +'->'+ edu +'->'+ com);
}

 $('#from_dat').Zebra_DatePicker();
    $('#to_dat').Zebra_DatePicker();

</script>
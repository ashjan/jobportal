
<!--pop up coded -->

<style>
.offScreen{
	position:inherit;
	}
</style>
<div class='loginDlgBody dialogBody offScreen loginDlgSource' id="hidepopupinhome"> <span class='subHeading'></span>
  <div class='dialogContent cf'>
    <div class='gdLoginModule gdSignInOption center padBotLg' id='SignInModuleCloneable' data-ajax='true' data-redirect-url=''>
      <div class='signInTabs'>
        <ul>
          <li><a href='#gd-popup-create-account' class='login-signup'>Create Account</a></li>
          <li><a href='#gd-popup-sign-in' class='login-signin'>Sign In</a></li>
        </ul>
          
          <!-- Signup tab starts here -->
        <div class='create-account-tab hidden'>
          <h2 class='signInheading margBot'>Sign Up for Job Mug</h2>
          <div class='caSubHeading margBot'></div>
          
          <div class='gplusSignInOption '>
            <div class='gplusWrapper ' data-google-app-id='1084099114544-usq6nj5taa6pvd5uvajufcppklqkrkgr.apps.googleusercontent.com'>
              <div id='LoginModule-GPlusBtnSignUp' class='tbl med gplusBtn' data-user-origin-hook="NOT_IDENTIFIED" data-ajax-login="false" data-onloginurl="/profile/createSocialNetworkAccount.htm" data-postloginurl=""> <i class='gplusIcon middle cell'></i> <span class='middle strong cell gplusBtnLabel'>Sign Up with Google</span> </div>
            </div>
          </div>
          
          <div class='fbSignInOption '>
            <div class='fbSigninCTAWrapper tbl fill'>
              <div class='fbSigninBtn cell lg'> <span class='fbSigninBtnLink' onlogin="checkLoginState();" data-postloginurl="">
                <div class='btnFill'> <span class='btnIcon floatLt'><span class='btnLogoWrapper'><i></i></span></span> <span class='btnLabel strong'>Sign Up with Facebook</span> </div>
                </span> </div>
<!--                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>-->
              <div class="clear"></div>
              <div id='FacebookPrivacyNote'> <i class='asterisk'></i> <span class='text'>Everything you view and do on Job Mug is private</span> </div>
            </div>
          </div>
          
          <div class='clear'></div>
          <div class='hr textCenter'>
            <hr/>
            <span class='center'>Or</span></div>
            <?php echo form_open('registration/index');?>
<!--          <form name='signUpForm' class='signUpForm'>-->
            <div class='clear'></div>
            <div class='err_msgg_dv'>
                <p class='headline'> <i class='error'></i> <span class="err_msgg_spn"></span> </p>
              <div class='clear'></div>
            </div>
            <div class='value emailWrapper'>
                <input type='email' name='email' placeholder='Email Address' onblur="javascript:check_email(this);" class='signup-email std med'/>
            </div>
            <div class='value emailWrapper'>
                <input type='password' name='password' id="pssw" onkeyup="javascript:check_pass(this)" class='signup-password std med' placeholder='Password'/>
            </div>
            <div class="value emailWrapper">
                <select required="" class="signup-password std med" name="utype" id="utype">
                    <option value="">-- Select User Type --</option>
                    
                                <option value="3">Applicant</option>
                                <option value="4">Employer</option>
                </select>
            </div>
            <p class='terms'> By creating an account, you agree to Job Mug's <br/>
              <a href=/about/terms.htm target=_blank><u>Terms of Use</u></a> and <a href=/about/privacy.htm target=_blank><u>Privacy Policy</u></a></p>
            <div class='value'>
                <button id="submit_btnn" type='submit' class='loginDlgSignUpBtn gd-btn gd-btn-button gd-btn-1 gd-btn-med gradient'> <span>Sign Up</span><i class='hlpr'></i></button>
            </div>
<!--          </form>-->
          <?php echo form_close();?>
        </div>
          
          <!-- Signup tab ends here -->
        <script>
 		 	var RecaptchaOptions = {
   		 		theme : 'white'
 			};
 		</script>
                
                
        <div class='sign-in-tab'>
          <h2 class='signInheading margBot'>module.login.header.si-heading </h2>
          <div class='gplusSignInOption '>
            <div class='gplusWrapper ' data-google-app-id='1084099114544-usq6nj5taa6pvd5uvajufcppklqkrkgr.apps.googleusercontent.com'>
              <div id='LoginModule-GPlusBtnSignIn' class='tbl med gplusBtn' data-user-origin-hook="NOT_IDENTIFIED" data-ajax-login="false" data-onloginurl="/profile/createSocialNetworkAccount.htm" data-postloginurl=""> <i class='gplusIcon middle cell'></i> <span class='middle strong cell gplusBtnLabel'>Sign In with Google</span> </div>
            </div>
          </div>
          <div class='fbSignInOption '>
            <div class='fbSigninCTAWrapper tbl fill'>
              <div class='fbSigninBtn cell lg'> <span class='fbSigninBtnLink' onlogin="checkLoginState();" login_text=" " fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=299833433542734&locale=en_US&login_text=%0A&scope=public_profile%2Cemail&sdk=joey" data-postloginurl="">
                <div class='btnFill'> <span class='btnIcon floatLt'><span class='btnLogoWrapper'><i></i></span></span> <span class='btnLabel strong'>Sign In with Facebook</span> </div>
                </span> </div>
                
<!--                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>-->
                
              <div class="clear"></div>
              <div id='FacebookPrivacyNote'> <i class='asterisk'></i> <span class='text'>Everything you view and do on Job Mug is private</span> </div>
            </div>
          </div>
          <div class='clear'></div>
          <div class='hr textCenter'>
            <hr/>
            <span class='center'>Or</span></div>
          <div class='clear'></div>
<!--          <form name='signInForm' class='signInForm'>-->
                <?php echo form_open('welcome/login');?>
            <div class='clear'></div>
<!--            <div id='CompletedAction' class='closeable ajaxResult margBot'>
              <p class='headline'> <i class='error'></i> <span></span> </p>
              <i class='closeBox'></i>
              <div class='clear'></div>
            </div>-->
            <div class='value emailWrapper'>
              <input type='email' name='username' placeholder='Email Address' class='signin-email std med'>
            </div>
            <span class='block-signin'>
            <div class='value passWrapper'>
              <input type='password' name='password' placeholder='Password' class='signin-password std med'/>
            </div>
            <span class='floatLt rememberMe alignLt'>
            <input type='checkbox' name='rememberMe' class='remember' checked='checked'/>
            <label for='rememberMe' class='wrap'>Remember Me</label>
            </span> <span class='padTopXS link floatLt forgotPassword'> <a href='javascript:void(0)' class='forgot-password'>Forgot Password</a> </span>
            <div class='clear'></div>
            <div class='captcha margTop hidden hangLt'>
              <!-- <script src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script> -->
            </div>
            <div class='buttonGroup'>
                <button type='submit' id='signInBtn' class='loginDlgSignInBtn gd-btn gd-btn-button gd-btn-1 gd-btn-med gradient'> <span>Sign In</span><i class='hlpr'></i></button>
            </div>
            </span>
            <div class='clear'></div>
            <div class='block-forgot'>
              <div class='forgotMessage'>Please enter your email address and we will send you an email with instructions for resetting your password</div>
              <div class='clear'></div>
              <div class='buttonGroup'>
                <button type='button' class='loginDlgResetBtn gd-btn gd-btn-button gd-btn-1 gd-btn-med gradient'> <span>Reset</span><i class='hlpr'></i></button>
                <span class='padLt20 padTopXS link'> 
				<a href='javascript:void(0)' class='back-to-signin'>Back to Sign In</a> </span>
				</div>
            </div>
            <div class='clear'></div>
            <?php echo form_close();?>
<!--          </form>-->
        </div>
                
                
      </div>
      <div class='clear'></div>
      <div class='ajaxStatus center middle'> <i class='loginSpinner'></i> <span class='padLt'></span> </div>
    </div>
  </div>
</div>



<script>
				/* <![CDATA[ */
				try {
					GD.runAfterLoad(function () {
					GD.dom.execDeferredScripts("text/x-deferred-js");
					});
				}
				catch(e) {
					Logger.error("Executing deferred scripts failed. (" + e + ")");
				}
				/* ]]> */
	</script>

<!--popup_coded-->

<script>

function check_pass(ele)
{
    var vali = ele.value; 
    var len = vali.length;
    
    if(len < 8)
    {
        var msg = 'length must be greater than the 8';
        $('.err_msgg_dv').css('display','block');
        $('.err_msgg_spn').css('display','block');
        $(".err_msgg_spn").html(msg);
        //alert(msg);
    }
    else
    {
        $('.err_msgg_dv').css('display','none');
        $('.err_msgg_spn').css('display','none');
    }
    
    
}
$('#pssw').keyup(function() {
    alert('vali');
    
});


emailcheck = '<?php echo base_url() . 'registration/check_email_availability'; ?>';
    
    function check_email(ele)
    {
        var email = ele.value;
       
        form_data = {email:email};
        var eml_txt = ""
        $.ajax({url:emailcheck,type:"POST",data:form_data,success:function(result){
                if(result == 'Available'){
                    //eml_txt = '<font color="green"> Availabe </font>';
                    
                    $('.err_msgg_dv').css('display','none');
                    $('.err_msgg_spn').css('display','none');
                    document.getElementById("submit_btnn").disabled = false;
                }
                else{
                    $('.err_msgg_dv').css('display','block');
                    $('.err_msgg_spn').css('display','block');
                    eml_txt = ' Email Already Exists. ';
                    document.getElementById("submit_btnn").disabled = true;
                }
                $('.err_msgg_spn').html(eml_txt);
        }});
    }

</script>
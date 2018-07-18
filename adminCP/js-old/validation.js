function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}

function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function validate_adminprofile(){
	
	var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	
	with (document.frmprofile){
		
	var com = document.getElementById('name').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("Diplay Name must be defined.");
			name.focus();
			return false;
		}
	var com = document.getElementById('email').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("Email Address cannot be empty.");
			email.focus();
			return false;
		}
	if(email.value.match(pattern)){}else{   
		alert('Please enter your valid email address');
		email.focus();
		return false;
	}	
	}
	return true;
	
}//end validate_adminprofile()

function validate_logininfo(){
	
	with (document.loginfrmprofile){
		
	var com = document.getElementById('username').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("User Name must be defined.");
			username.focus();
			return false;
		}
	
	var com = document.getElementById('password').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("Password must be defined.");
			password.focus();
			return false;
		}
		
	var com = document.getElementById('repassword').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("Re-Password must be defined.");
			repassword.focus();
			return false;
		}
	
	if(password.value!=repassword.value){
			alert("Password does not match");
			password.focus();
			return false;
		}
	}
	return true;
}//validate_login()

function validate_contentpage(){
	
	with (document.managecontentfrm){

		if(username.value==""){
			alert("Username cannot be empty.");
			username.focus();
			return false;
		}
		if(password.value==""){
			alert("Password must be mentioned");
			password.focus();
			return false;
		}
		if(repassword.value==""){
			alert("Re-type Password must be match to password field");
			repassword.focus();
			return false;
		}
		if(password.value!=repassword.value){
			alert("Password does not match");
			password.focus();
			return false;
		}
	}
	return true;
}//validate_contentpage()

function validate_contant(){

	with(document.managecontentfrm){
		
	var com = document.getElementById('page_title').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("Page Title cannot be empty.");
			page_title.focus();
			return false;
		}
	}
	
	/*if(document.getElementById('latitude').value == '' )
	{
		alert("Please Enter Latitude Value.");
		document.getElementById('latitude').focus();
		return false;
	}
	if(document.getElementById('longitude').value == '' )
	{
		alert("Please Enter Longitude Value.");
		document.getElementById('longitude').focus();
		return false;
	}*/
	if(valid_character_for_lat_lon(document.getElementById('latitude').value)){
		alert("Please Enter Valid Latitude Value");	
		document.getElementById('latitude').value='';
		document.getElementById('latitude').focus();
		return false
	}
	
	if(valid_character_for_lat_lon(document.getElementById('longitude').value)){
		alert("Please Enter Valid Longitude Value");	
		document.getElementById('longitude').value='';
		document.getElementById('longitude').focus();
		return false
	}
		
	//valid_character_for_lat_lon();
}//validate_contant()
function valid_character_for_lat_lon(latlong){
	var compararry = [];
	for (var m = 0; m < latlong.length; m++) {
    	compararry[m]=latlong.charAt(m);
	}
	var validchars=["+","-",".","0","1","2","3","4","5","6","7","8","9"]; 
	var j;
	var validcharflag;
	for(var j=0; j < compararry.length; j++ ){
		validcharflag=false;	
		for(var i=0; i < validchars.length ; i++){
			if(validchars[i]==compararry[j]){
				validcharflag=true;
				continue;
			}
		}
		if(!validcharflag){
			return true;	
		}
	}
}
function validate_faq(){
	
	with(document.addfaqfrm){
		
	var com = document.getElementById('faq_question').value;
	chars = ' ';
	var test = (ltrim(rtrim(com, chars), chars));
	if(test == '')
		{
			alert("Question cannot be empty.");
			faq_question.focus();
			return false;
		}
	}
}//validate_faq(){
	
function validate_admin_regmails(){ 

	with (document.addmailfrm){ 

		if(fname.value==""){
			alert("Form name cannot be empty.");
			fname.focus();
			return false;
		}
		if(subject.value==""){
			alert("Subject cannot be empty.");
			subject.focus();
			return false;
		}
		if(message.value==""){
			alert("Message cannot be empty.");
			message.focus();
			return false;
		}
	}
	return true;
}//end validate_adminprofile()

function validate_memberemail(){ 

	with (document.email_member){ 
		
		if(subject.value==""){
			alert("Subject cannot be empty.");
			subject.focus();
			return false;
		}
	}
	return true;
}//end validate_adminprofile()

function showfulltext(id)
{
	 
	  $("#short_text_"+id).slideToggle('fast');
      $("#full_text_"+id).slideToggle('fast');
	 
	 return false;
}

function videos_validation()
{
	/*var pmid = document.getElementById("pm_id");
	var pm_id_val = pmid.options[pmid.selectedIndex].value;
	if(pm_id_val== '')
	 {
		 alert("Please Select the PM Names");
		 return false;
	 }
	  
	  var propertyid = document.getElementById("property_id");
	var property_id_val = propertyid.options[propertyid.selectedIndex].value;
	if(property_id_val== '')
	 {
		 alert("Please Select the Property Name");
		 return false;
	 }
	  
	  
	var roomid = document.getElementById("sel_room_id");
	var room_id_val = roomid.options[roomid.selectedIndex].value;
	if(room_id_val== '')
	 {
		 alert("Please Select the Room Name");
		 return false;
	 }*/
	  
	 
	 
	 if(document.getElementById('video_title').value == '')
	 {
		// document.managecontentfrm.video_title.focus();
		 alert("Please Enter the Video Title");
		 return false;
	 }
	 
}
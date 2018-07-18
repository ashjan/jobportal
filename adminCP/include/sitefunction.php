<?php
// Date displayed for users: like  1 Jan, 2005
function mysqltonormal($dated){
	$dated = explode('-', $dated);
	$YYYY  = $dated[0];
	$MM = $dated[1];
	$DD = $dated[2];
	$YY = substr($YYYY,2);
  	$final = date("d M, Y", mktime(0,0,0,$MM,$DD, $YYYY));
	//$final = $MM.'/'.$DD.'/'.$YYYY;
	return $final;		
}

function normaltomysql($dated){

	$dated = explode('/', $dated);
	$MM  = $dated[0];
	$DD = $dated[1];
	$YYYY = $dated[2];
	$final = $YYYY.'-'.$MM.'-'.$DD;
	if($final !='--') {
		return $final;		
	}
}

function userdate($dated){
     
	 $dated = explode('-', $dated);
	 $YYYY  = $dated[0];
	 $MM = $dated[1];
	 $DD = $dated[2];
	 
	 $final = date("M j, Y", mktime(0,0,0,$MM,$DD, $YYYY));
	 return $final;
}

function manageString($str,$maxlenallowed,$wrapstr){
	
	$newstr = stripslashes(nl2br($str));
	$newstr = wordwrap($newstr,$wrapstr, "\n" ,true);
	
	if(strlen($newstr) > $maxlenallowed){
		$newstr = substr($newstr,0,$maxlenallowed).' ...';
	}else{
		$newstr = $newstr;
	}
	return $newstr;
	
} //end manageString()

function setWarp($str,$wrapstr){

	$newstr = stripslashes(nl2br($str));
	$newstr = wordwrap($newstr,$wrapstr,"\n",true);
	return $newstr;

}// end manageString($str,$wrapstr)

//START: Create a Croped Image 
function cropImage($nw, $nh, $source, $stype, $dest) {
       
          $size = getimagesize($source);
          $w = $size[0];
          $h = $size[1];
       
          switch($stype) {
              case 'gif':
              $simg = imagecreatefromgif($source);
              break;
              case 'jpg':
              $simg = imagecreatefromjpeg($source);
              break;
              case 'png':
              $simg = imagecreatefrompng($source);
              break;
          }
       
          $dimg = imagecreatetruecolor($nw, $nh);
       
          $wm = $w/$nw;
          $hm = $h/$nh;
       
          $h_height = $nh/3;
          $w_height = $nw/3;
       
         if($wm> $hm) {
       
              $adjusted_width = $w / $hm;
              $half_width = $adjusted_width / 2;
              $int_width = $half_width - $w_height;
       
              imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
       
          } elseif(($w <$h) || ($w == $h)) {
       
              $adjusted_height = $h / $wm;
              $half_height = $adjusted_height / 3;
              $int_height = $half_height - $h_height;
       
              imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
       
          } else {
              imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
          }
       
          imagejpeg($dimg,$dest,100);
      }
//END: Create a Croped Image

//START : function to find out the property of an attribute
function callSelectedOption($eid,$catid,$memid,$attribname,$attribvalue){
		global $db;
		$selected="";
		$qry_cartItem="SELECT *FROM tbl_tempcart WHERE id=$eid AND catid=$catid AND userid=".$memid;
		$rs_cartItem=$db->Execute($qry_cartItem);
		
		$attribArr=explode('##$$',$rs_cartItem->fields['pattern']);
		
		foreach($attribArr as $index=>$value){
			$properArr=explode('##',$value);
			if(($attribname==$properArr[0]) && $attribvalue==$properArr[1]){
				 $selected="selected=selected";
				break;
				}
			} // end of foreach loop
		
	return $selected;		
}// END: function to find out the property of an attribute
	
function commonDbFunction($selectfield,$tablename,$wherefield,$wherevalue){

	global $db;
	$qry = "SELECT $selectfield FROM tbl_".$tablename." WHERE $wherefield = '".$wherevalue."'";
	$rs = $db->Execute($qry);
	
	return $rs->fields[$selectfield];
	
}// end commonDbFunction()

function generateRandomString($length = 6, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm')
  {
      $s = '';
      $lettersLength = strlen($letters)-1;
     
      for($i = 0 ; $i < $length ; $i++)
      {
      $s .= $letters[rand(0,$lettersLength)];
      }
     
      return $s;
  }
  
 function is_email($email){

	$email = strtolower($email);
	if (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) || empty($email)){
		return false;
	}else{
		return true;
	}
}//end is_email()

//Function to find the user age

function getyear($dob){

	$birthday = str_replace('-','',$dob);
	$today = date('Ymd');
	return $age = (int)(($today - $birthday)/10000);
}
##################################################
#
#  	A function that would delete folders, subfolders and files
#
##################################################

function rmdir_r ( $dir, $DeleteMe = TRUE ){

	if ( ! $dh = @opendir ( $dir ) ) return;
	
	while ( false !== ( $obj = readdir ( $dh ) ) ){
		if ( $obj == '.' || $obj == '..') continue;
		if ( ! @unlink ( $dir . '/' . $obj ) ) rmdir_r ( $dir . '/' . $obj, true );
	}
	
	closedir ( $dh );
	if ( $DeleteMe ){
		@rmdir ( $dir );
	}
}
	function randomid($no){
		$totalChar = $no;  //length of random number
		$salt = "abcdefghijklmnpqrstuvwxyz123456789";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		$randnumber="";
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		return $randnumber;
	}
function slugcreation($name){
	$name = stripslashes($name);
	$removingcomma_name1 = str_replace("'", "", $name);
	$removingcomma_name2 = str_replace('"', "", $removingcomma_name1);
	$slugname_pre = strtolower(trim($removingcomma_name2));
	$slugname_post =  str_replace(" ","-",$slugname_pre);
	
	$slugname_post = refine_sp_chr($slugname_post);
	
	return $slugname_post;
}
function refine_sp_chr($slug){
		$code_entities_match = array( '&quot;','!','@','#','$','%','^','&','*','(',')','+','{','}','|',':','"','<','>','?','[',']','',';',"'",',','.','_','/','*','+','~','`','=',' ','---','--','--');
		$code_entities_replace = array('','','-','','','','-','-','','','','','','','','-','','','','','','','','','','-','','-','-','','','','','','-','-','-','-');
		$slug = str_replace($code_entities_match, $code_entities_replace, $slug);
		$slug=substr($slug,0,150);
		return $slug;
}

/************** Encryption and Decryption *******************/
function password($password) {
	return hashme($password, null, true);
}
function hashme($string, $type = null, $salt = false) {

	if ($salt){
		$string = read().$string;
	}

	$type = strtolower($type);

	if ($type == 'sha1' || $type == null) {
		if (function_exists('sha1')) {
			$return = sha1($string);
			return $return;
		} else {
			$type = 'sha256';
		}
	}

	if ($type == 'sha256') {
		if (function_exists('mhash')) {
			$return = bin2hex(mhash(MHASH_SHA256, $string));
			return $return;
		} else {
			$type = 'md5';
		}
	}

	if ($type == 'md5') {
		$return = md5($string);
		return $return;
	}
}
function read(){
	$name = 'baccoppauthkey';
	return $name;
}

function uploadForm() {
?>


	
		<div id="dvFile0" ><input type="file" id="S_IMAGE" name="S_IMAGE[]" value=""><a href="javascript:_add_more(0);"><img src="<?php echo MYSURL."graphics/plus_icon.gif"?>" border="0" width="20" height="20"></a></div>
			  <div id="dvFile1"></div>
           
	
<script language="javascript">
<!--
	var next_id=0;
	function _add_more() {
		next_id=next_id+1;
		var rval = next_id+1;
		var next_div=next_id+1;
		var txt = "<br><input type=\"file\" name=\"S_IMAGE[]\" id=\"S_IMAGE\">";
		txt+='<div id="dvFile'+next_div+'"></div>';
		document.getElementById("dvFile" + next_id ).innerHTML = txt;
		
	}
	function validate(f){
		var chkFlg = false;
		for(var i=0; i < f.length; i++) {
			if(f.elements[i].type=="file" && f.elements[i].value != "") {
				chkFlg = true;
			}
		}
		if(!chkFlg) {
			alert('Please browse/choose at least one file');
			return false;
		}
		f.pgaction.value='upload';
		return true;
	}
//-->
</script>
<?php
}


//function for the date diffence in terms of days

function count_days( $a, $b )
{
    // First we need to break these dates into their constituent parts:
    $gd_a = getdate( $a );
    $gd_b = getdate( $b );
 
    // Now recreate these timestamps, based upon noon on each day
    // The specific time doesn't matter but it must be the same each day
    $a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
    $b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );
 
    // Subtract these two numbers and divide by the number of seconds in a
    //  day. Round the result since crossing over a daylight savings time
    //  barrier will cause this time to be off by an hour or two.
    return round( abs( $a_new - $b_new ) / 86400 );
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller {


function __construct(){
	parent::__construct();
	
	
	}

function index(){
	
	$uid = $this->session->userdata['user_data']['usr_id'];
	echo $uid;
	$latest_notification		=	$this->m_common->getlatestnotification($uid);
	 //var_dump($latest_notification->total); exit;
	 if($latest_notification->total == 0) {
		 echo "yues";
		 }else{
			 echo "no";
			 }
}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
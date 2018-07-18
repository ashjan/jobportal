<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/welcome
	 *	- or -  
	 * 		http://example.com/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
         public function __construct()
	{
		parent::__construct();
                
                
                //Here i call the model for menus 
                $this->load->model('menu_manager');
                
                //Loading menu for widget 1
                $load_widget1_menus=$this->menu_manager->load_widget1_menus();
                $this->data['widget1_menus_items']=$load_widget1_menus;

        	//Loading menu for widget 2
                $load_widget2_menus=$this->menu_manager->load_widget2_menus();
                $this->data['widget2_menus_items']=$load_widget2_menus;

        	//Loading menu for widget 3
                $load_widget3_menus=$this->menu_manager->load_widget3_menus();
        	$this->data['widget3_menus_items']=$load_widget3_menus;
                
                $this->data['url'] = site_url();
                $this->load->model('jobs_model');
                $this->load->model('auth_model');
                $this->load->model('resume_model');
                $this->data['locations'] = $this->jobs_model->get_locations();
                
                if(isset($this->session->userdata['user_data']['usr_id']))
                {
                    $cand_id = $this->session->userdata['user_data']['usr_id'];
                    $this->data['resume'] = $this->resume_model->get_resume($cand_id);
                }
                
                //echo "<pre>"; print_r($this->session->userdata('appdata')); exit;
        }
  

	public function index()
	{
            if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
            {
                $this->load->model('jobs_model');
                $this->load->model('auth_model');
                $this->load->model('resume_model');
                $this->load->model('testimonial_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['countries'] = $this->jobs_model->get_countries();
                $this->data['latest_jobs'] = $this->jobs_model->get_latest_jobs();
                $this->data['latest_resumes'] = $this->resume_model->get_latest_resumes();
                $this->data['latest_companies'] = $this->resume_model->get_latest_companies();
                $this->data['members'] = $this->auth_model->count_members();
                $this->data['companies_cnt'] = $this->auth_model->count_companies();
                $this->data['resumes_cnt'] = $this->auth_model->count_resumes();
                $this->data['featured_comp'] = $this->jobs_model->get_featured_company();
                $this->data['jobs_cnt'] = $this->auth_model->count_jobs();
                $this->data['testimonials'] = $this->testimonial_model->get_added_testimonials();
				/////////// Zeeshan Code Start m_common model is auto loaded and is located in the model section ///////////
				$this->data['package_array']	=	$this->m_common->view_record('tbl_packages');

                //echo "<pre>"; print_r($this->data['testimonials']); exit;
		$this->load->view('home',$this->data);
            }
            else
            {
                if($this->session->userdata['user_data']['u_type'] == 3)
                {
                        redirect('jobs/job_listing');
                        exit;
                }
                else
                {
                        redirect('jobs/emp_job_listing');
                        exit;
                }
            }
	}
        
        public function login()
        {
            $this->form_validation->set_rules('username','User Name','required');
            $this->form_validation->set_rules('password','Password','required');
            
            if($this->form_validation->run() == FALSE)
            {
                //echo 'mai phans gia'; exit;
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
               
                $this->load->view('login', $this->data);
            }
            else{
                $unam = $this->db->escape_str($this->input->post('username'));
                $pass = $this->db->escape_str($this->input->post('password'));
                $pass = md5($pass);
                $this->load->model('auth_model');
                $result = $this->auth_model->authenticate($unam, $pass);
                //echo "<pre>"; print_r($result); exit;
                if($result > 0)
                { 
                    if($result[0]['id'] == $result[0]['company_id']){
                        $comp_admin = 1;
                    }
                    else{
                        $comp_admin = 0;
                    }
                    $urdta['user_data'] = array(
                        'usr_id' => $result[0]['id'],
                        'is_user_logged_in' => TRUE,
                        'f_name' => $result[0]['first_name'],
                        'l_name' => $result[0]['last_name'],
                        'u_type' => $result[0]['user_type'],
                        'email' => $result[0]['email_address'],
                        'dp' => $result[0]['profile_pic'],
                        'is_comp_admin' => $comp_admin
                        
                    );
                    
        $urdta['dbtables'] = Array
        (
            'eventlog',
            'keymanager_keydata',
            'keymanager_keys',
            'phplist_admin',
            'phplist_admin_attribute',
            'phplist_admin_task',
            'phplist_adminattribute',
            'phplist_admintoken',
            'phplist_attachment',
            'phplist_bounce',
            'phplist_bounceregex',
            'phplist_bounceregex_bounce',
            'phplist_config',
            'phplist_eventlog',
            'phplist_linktrack',
            'phplist_linktrack_forward',
            'phplist_linktrack_ml',
            'phplist_linktrack_uml_click',
            'phplist_linktrack_userclick',
            'phplist_list',
            'phplist_listattr_bpleaseche',
            'phplist_listattr_bwheredoyo',
            'phplist_listattr_cbgroup',
            'phplist_listattr_comments',
            'phplist_listattr_countries',
            'phplist_listattr_hiddenfiel',
            'phplist_listattr_iagreewith',
            'phplist_listattr_most',
            'phplist_listattr_othercomme',
            'phplist_listattr_publickey',
            'phplist_listattr_somemoreco',
            'phplist_listmessage',
            'phplist_listrss',
            'phplist_listuser',
            'phplist_message',
            'phplist_message_attachment',
            'phplist_messagedata',
            'phplist_rssitem',
            'phplist_rssitem_data',
            'phplist_rssitem_user',
            'phplist_sendprocess',
            'phplist_subscribepage',
            'phplist_subscribepage_data',
            'phplist_task',
            'phplist_template',
            'phplist_templateimage',
            'phplist_urlcache',
            'phplist_user_attribute',
            'phplist_user_blacklist',
            'phplist_user_blacklist_data',
            'phplist_user_message_bounce',
            'phplist_user_message_forward',
            'phplist_user_rss',
            'phplist_user_user',
            'phplist_user_user_attribute',
            'phplist_user_user_history',
            'phplist_usermessage',
            'phplist_userstats'
        );
    
        $adm_ps = 'aftab';
        $ps = md5($adm_ps);
        
        $urdta['logindetails'] = Array
        (
            "adminname" => $adm_ps,
            "id" => 1,
            "superuser" => 1,
            "passhash" => $ps
        );
                    
                    $this->session->set_userdata($urdta);
                    //echo "<pre>"; print_r($this->session->all_userdata());
                    if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 2 || $this->session->userdata['user_data']['u_type'] == 4)
                    {
                        $ref = $this->session->userdata('previous_page');
                        if(isset($ref) && $ref != "")
                        {
                            $re_url = $this->session->userdata('previous_page');
                            
                            header("Location: $re_url");
                            exit;
                        }
                        else 
                        {
                            redirect('jobs/emp_job_listing');
                            exit;
                        }
                    }
                    else 
                    {
                        $ref = $this->session->userdata('previous_page');
                        if(isset($ref))
                        {
                            $re_url = $this->session->userdata('previous_page');
                            redirect($re_url);
                            exit;
                        }
                        else 
                        {
                            redirect('jobs/job_listing');
                            exit;
                        }
                    }
                }
                else{
                    $this->session->set_flashdata('msgg','User Name Or password is incorrect....!');
                    redirect('welcome/login');
                }
            }
        }
        
        
        public function blog()
        {
            
            $this->load->view("blog.php",  $this->data);
            
        }
        
        public function pricing()
        {
            $this->load->view('pricing.php', $this->data);
        }

        

        public function candidates_listing()
    { 
//            if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
//            {
//                redirect('welcome/pricing');
//                exit;
//            }
//            else
//            {
                $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."welcome/candidates_listing/";
                 $tbl_nam = 'tbl_resume';
                $this->load->model('jobs_model');
                $this->load->model('resume_model');
                 $rows = $this->jobs_model->record_count($tbl_nam);

                        $config["total_rows"] = $rows;
                        $config["per_page"] = 10;
                        $config["uri_segment"] = 3;
                $this->load->library('pagination');
                $this->pagination->initialize($config);

                if($this->uri->segment(3))
                {
                    $page = $this->uri->segment(3);
                }
                else 
                {
                    $page = 0;
                }
                $this->data['page'] = $page;
                
                if(isset($this->session->userdata['user_data']['usr_id'])){
                    $emp_id = $this->session->userdata['user_data']['usr_id'];
                }
                else{
                    $emp_id = 0;
                }
                
                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['pagin'] =$this->pagination->create_links();
                $this->data['projects'] = $this->resume_model->get_recent_projects();
                $this->data['rat_dv'] = 20;
                $criter = $this->resume_model->get_rat_crit();
                $this->data['cands'] = $this->resume_model->get_latest_resumes($page, $config['per_page'],$check=null,$criter);
//                foreach($this->data['cands'] as $candid){
                    $criteria = $this->resume_model->get_rating_criteria();
       
                    $this->data['review_criteria'] = $criteria;
//                }
                //echo "<pre>"; print_r($this->data['cands']); exit;
                $this->load->view('candidates_listing',$this->data);
            //}
    }
    
    public function cand_list()
    {
        $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."welcome/candidates_listing/";
                 $tbl_nam = 'tbl_resume';
                $this->load->model('jobs_model');
                $this->load->model('resume_model');
                 $rows = $this->jobs_model->record_count($tbl_nam);

                        $config["total_rows"] = $rows;
                        $config["per_page"] = 10;
                        $config["uri_segment"] = 3;
                $this->load->library('pagination');
                $this->pagination->initialize($config);

                if($this->uri->segment(3))
                {
                    $page = $this->uri->segment(3);
                }
                else 
                {
                    $page = 0;
                }
                $this->data['page'] = $page;

                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['pagin'] =$this->pagination->create_links();
                $this->data['projects'] = $this->resume_model->get_recent_projects();
                $this->data['cands'] = $this->resume_model->get_latest_resumes($page, $config['per_page']);
                //echo "<pre>"; print_r($this->data['cands']); exit;
                $this->load->view('candidates_listing',$this->data);
    }
    
     public function consultants_listing()
    {
//          if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
//            {
//                redirect('welcome/pricing');
//                exit;
//            }
//            else
//            {
                $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."welcome/candidates_listing/";
                 $tbl_nam = 'tbl_users';
                $this->load->model('jobs_model');
                $this->load->model('resume_model');
                 $rows = $this->jobs_model->count_consultatnt($tbl_nam);

                        $config["total_rows"] = $rows;
                        $config["per_page"] = 10;
                        $config["uri_segment"] = 3;
                $this->load->library('pagination');
                $this->pagination->initialize($config);

                if($this->uri->segment(3))
                {
                    $page = $this->uri->segment(3);
                }
                else 
                {
                    $page = 0;
                }
                $check = 2;
                $this->data['pg_ck'] = TRUE;
                $this->data['page'] = $page;
                        $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['pagin'] =$this->pagination->create_links();
                $this->data['projects'] = $this->resume_model->get_recent_projects();
                $this->data['rat_dv'] = 20;
                $criter = $this->resume_model->get_rat_crit();
                $candidates = $this->resume_model->get_latest_resumes($page, $config['per_page'], $check, $criter);
                $this->data['cands'] = $candidates;
                $candu = array();
                if(isset($this->session->userdata['user_data']['usr_id']))
                {
                    if(!empty($candidates))
                    {
                        foreach($candidates as $cand)
                        {
                            $emp_id = $this->session->userdata['user_data']['usr_id'];
                            $cand = $this->resume_model->get_rating_criteria($emp_id, $cand['candidate_id']);
                            $candu[] = $cand;
                        }
                    }
                }
               $this->data['criteria'] = $this->resume_model->get_rat_crit();
               $this->data['review_criteria'] = $candu;
                //echo "<pre>"; print_r($this->data['cands']); exit;
                $this->load->view('candidates_listing',$this->data);
            //}
    }
    
        
    public function job_search($start = 1)
    {
        // this will be incase when teh jobsearch will came from the home page
		$this->session_check();
		if (strpos($start,'morecompanyjobs') !== false) {
			 $this->session->sess_destroy();
			 if(isset($_SESSION['similiarjobs'])){
				 unset($_SESSION['similiarjobs']);
		}
			 $_SESSION['morecompanyjobs']		=	 substr($start, 15, 50); 
			 //$seso['search_dt'] = $set_sessn;
             //$this->session->set_userdata($seso);
			 //echo "<pre>"; print_r($this->session->all_userdata()); exit;
		}
		
		if (strpos($start,'similiarjobs') !== false) {
			 $this->session->sess_destroy();
			 if(isset($_SESSION['morecompanyjobs'])){
				 unset($_SESSION['morecompanyjobs']);
		}
			 $_SESSION['similiarjobs']		=	 substr($start, 12, 50); 
			 //$seso['search_dt'] = $set_sessn;
             //$this->session->set_userdata($seso);
		}
		
		if($start == 'homepage'){
			$this->session->sess_destroy();
			$start = 1;
		}
		
		$query_string = '';
		$query_string	.=	"WHERE tbl_jobs.job_id != '' ";
     	$this->form_validation->set_rules('search_box');
       	$this->data['categories'] = $this->jobs_model->get_categories();
       	$search = $this->db->escape_str($this->input->post('search_box'));
       	$loc = $this->db->escape_str($this->input->post('location'));
		if($search == ""){
			$SESSION['ttl'] = "";
		}
		else{
			$SESSION['ttl'] = $search;
			$title_array		=	explode(" ",$search);
				$count_title		=	count($title_array);
				if($count_title > 0){
					$query_string .= 'AND (';
					for($i = 0; $i < $count_title; $i++){
						if($i+1 == $count_title){
							// this mean that the element is last and in that case we dont need to insert OR at the end
							$query_string	.=	"LCASE(tbl_jobs.`job_title`) LIKE LCASE('%".$title_array[$i]."%') ";
							
						}
						else{
							// element is not last and we do need to Insert Or at the end;
							$query_string	.=	" LCASE(tbl_jobs.`job_title`) LIKE LCASE('%".$title_array[$i]."%') OR ";
							}
						}
					//$query_string = $query_string.')';
					$query_string .= 'OR ';
					for($i = 0; $i < $count_title; $i++){
						if($i+1 == $count_title){
							// this mean that the element is last and in that case we dont need to insert OR at the end
							$query_string	.=	"LCASE(tbl_city.`name`) LIKE LCASE('%".$title_array[$i]."%') ";
							
						}
						else{
							// element is not last and we do need to Insert Or at the end;
							$query_string	.=	" LCASE(tbl_city.`name`) LIKE LCASE('%".$title_array[$i]."%') OR ";
							}
						}
					$query_string = $query_string.')';		
			}
			
		}
		
		if($loc == ""){
			$SESSION['srch'] = "";
		}
		else{
			$SESSION['srch'] = $loc;
			$query_string	.=	" AND LCASE(tbl_city.name) LIKE LCASE('%".$loc."%') ";
			
		}
		if(isset($this->session->userdata['date']) and $this->session->userdata['date'] != ''){
			$query_string	.=	" AND tbl_jobs.`start_date` >= '".$this->session->userdata['date']."' ";
           }

		if(isset($this->session->userdata['j_types']) and $this->session->userdata['j_types'] != ''){
			if($this->session->userdata['j_types'] == 0){
				$query_string	.=	" AND tbl_jobs.`job_type` != '' ";
				}
			else{
				$query_string	.=	" AND tbl_jobs.`job_type` = ".$this->session->userdata['j_types']." ";
				}	
		}

		if(isset($this->session->userdata['experience']) and $this->session->userdata['experience'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`experience` >= ".$this->session->userdata['experience']." ";
		}
		if(isset($this->session->userdata['job_city']) and $this->session->userdata['job_city'] != ''){
			
				$query_string	.=	" AND LCASE(tbl_city.name) LIKE LCASE('%".$this->session->userdata['job_city']."%') ";
		}
		if(isset($this->session->userdata['salary_from']) and $this->session->userdata['salary_from'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`salary` >= '".$this->session->userdata['salary_from']."' ";
		}
		if(isset($this->session->userdata['salary_to']) and $this->session->userdata['salary_to'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`salary_to` <= '".$this->session->userdata['salary_to']."' ";
		}

		if(isset($this->session->userdata['carear_level']) and $this->session->userdata['carear_level'] != ''){
				if($this->session->userdata['carear_level'] == 0){
					$query_string	.=	" AND tbl_jobs.`career` != ''";
					}
				else{	
					$query_string	.=	" AND tbl_jobs.`career` = '".$this->session->userdata['carear_level']."' ";
			
				}
		}	
		
			
		if(isset($_SESSION['morecompanyjobs']) and $_SESSION['morecompanyjobs'] != ''){
			
				$query_string	.=	" AND comp.company_id  = '".$_SESSION['morecompanyjobs']."' ";
		}
		
		if(isset($_SESSION['similiarjobs']) and $_SESSION['similiarjobs'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`category`  = '".$_SESSION['similiarjobs']."' ";
		}
		
		
		$seso['search_dt'] = $SESSION;
        $this->session->set_userdata($seso);
		$dbdata['ttl'] = $this->session->userdata['search_dt']['ttl'];
		$dbdata['srch'] = $this->session->userdata['search_dt']['srch'];
		$query_string.=" ORDER BY tbl_jobs.job_id ASC";
		//echo $query_string; exit;
		//echo $query_string; exit;	
		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
		
		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
		
		$field = "city";
		$dbdata['fld'] = $field;
        $data['url'] = site_url();
        $tbl_nam = 'tbl_jobs';
        $field1 = "job_title";
        $this->load->model('jobs_model');
    
		// pagination code start from here
		$this->load->library('pagination');
		$this->data['jobcount']		=	$jobcount	=		$this->jobs_model->getjobscount($query_string);
		
		$config['base_url']  		= base_url('')."welcome/job_search/";
		$config['total_rows']	 	= $jobcount->total; //1000;//$countt->countt;
		$config['per_page']   		= 10;
		$config['uri_segment']		= 3;	
		$data['info']				= array();
		
		$page_start 				= $start;
		$start--;
		$start 						= $start * $config['per_page'];
		$this->pagination->initialize($config);
		$this->data['pagination']			= $this->pagination->create_links();
		$this->data['start'] 				= $page_start;
                
                $this->data['rat_dv'] = 20;
        $criter = $this->resume_model->get_job_rating_criteria();
		$this->data['jobs'] = $this->jobs_model->getjobs($start, $config['per_page'], $query_string, $criter);
		
		// pagination code end here
      
        $this->data['rat_dv'] = 20;
        $criter = $this->resume_model->get_job_rating_criteria();
		//$this->data['jobs'] = $this->jobs_model->getjobs($page, $config['per_page'], $query_string, $criter);
		//echo "<pre>"; print_r($this->data['jobs']); exit;
              
                $criteria = $this->resume_model->get_job_rating_criteria();
       
                    $this->data['review_criteria'] = $criteria;
                
        if(!empty($this->data['jobs'])){
			$this->data['current'] = current_url();
			$this->data['categories'] = $this->jobs_model->get_categories();
			if(isset($this->session->userdata['user_data']['is_user_logged_in']))
			{
				$this->load->model('resume_model');
				$cand_id = $this->session->userdata['user_data']['usr_id'];
				$this->data['resume'] = $this->resume_model->get_resume($cand_id);
				$this->load->view('jobs_listing',$this->data);
			}
			else
			{
				$this->load->view('jobs_search',$this->data);
			}
		}
		else 
		{
			$this->load->view('jobs_search',$this->data);
			
		}
	//}
}

    
    
            
            
    
    public function advance_search()
    {
        $key = $this->uri->segment(3);
        $srch = explode('_', $key);
        //echo "<pre>"; print_r($srch);
        $you = "";
        $loc = $srch[0];
        $sal = $srch[1];
        $sal_to = $srch[2];
        
        if($you == "")
        {
           $you = 1; 
        }
        
        if($you == 1)
        {
            $this->load->model('jobs_model');
            $result = $this->jobs_model->get_advance_results($loc, $sal, $sal_to);
        }
        else{
            $this->load->model('resume_model');
            $result = $this->resume_model->get_emp_adv_srch($wht, $whr, $sal, $cat, $sal_to, $from, $to);
        }
        echo json_encode($result);
    }
    
    public function job_details()
    {
        $this->data['url'] = site_url();
        $id = $this->uri->segment(3);
        $usr_id = "";
        if($id == "")
        {
            redirect('welcome/index');
            exit;
        }
        //$this->data['uid'] = $usr_id;
        //$this->data['utyp'] = $this->uri->segment(4);
        $this->load->model('jobs_model');
        $this->data['categories'] = $this->jobs_model->get_categories();
        $this->load->model('jobs_model');
        $this->data['check'] = $this->jobs_model->check_apply($id, $usr_id);
        //$view = $this->jobs_model->update_views($id);
        $this->data['job_dt'] = $this->jobs_model->get_job_detail($id);
        //echo "<pre>"; print_r($data['job_dt']); exit;
        $this->load->view('job_details',$this->data);
    }
    
     public function resume_details()
    {
        $id = $this->uri->segment(3);
       if($this->uri->segment(4) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(4);
       }
       
       $this->load->model('resume_model');
       $this->data['reseme_details'] = $this->resume_model->get_resume_details($id, $cand_id);
       $this->load->view('resume_preview',$this->data);
       //echo "<pre>"; print_r($reseme_details); exit;
    }
    
    
    function fb_login()
    {
        $dt_fb = $this->input->post('fb_dt');
        //echo "<pre>";        print_r($dt_fb); exit;
        
        $fb_ck = $this->auth_model->fb_login_details($dt_fb['id'], $dt_fb['first_name'], $dt_fb['last_name'], $dt_fb['email']);
        //echo "<pre>";        print_r($fb_ck); exit;
        $urdta['user_data'] = array(
                        'usr_id' => $fb_ck,
                        'is_user_logged_in' => TRUE,
                        'f_name' => $dt_fb['first_name'],
                        'l_name' => $dt_fb['last_name'],
                        'u_type' => 3,
                        'email' => $dt_fb['email'],
                        'dp' => '',
                        'is_fb_usr' => TRUE
                    );
        
        $this->session->set_userdata($urdta);
        if(!empty($this->session->userdata['user_data']))
        {
            $resp = 'yes';
        }
        else 
        {
            $resp = 'no';
        }
            
        echo $resp;
    }
    
    
    public function auto_comp_data()
    {
        
        //$srch = $this->input->post('search_box');
        $srch = $this->input->get('query');
        
        $result['suggestions'] = $this->jobs_model->get_auto_comp($srch);
        
        echo json_encode($result);
        
    }
    
    public function inner_search_data()
    {
        
        //$srch = $this->input->post('search_box');
        $srch = $this->uri->segment(3);
        
        $result = $this->jobs_model->get_inner_search_res($srch);
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/inner_search_data/";
         $tbl_nam = 'tbl_jobs';
        $this->load->model('jobs_model');
         $rows = $this->jobs_model->record_count($tbl_nam);
                
                $config["total_rows"] = $rows;
                $config["per_page"] = 10;
                $config["uri_segment"] = 4;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        if($this->uri->segment(4))
        {
            $page = $this->uri->segment(4);
        }
        else 
        {
            $page = 0;
        }
        $this->data['page'] = $page;
                $this->data['categories'] = $this->jobs_model->get_categories();
        $this->data['pagin'] =$this->pagination->create_links();
        $this->data['jobs'] = $this->jobs_model->get_inner_search_res($srch);
        //echo "<pre>"; print_r($this->data['jobs']); exit;
        if(isset($this->session->userdata['user_data']['usr_id']))
        {
            $this->load->view('jobs_listing',$this->data);
        }
        else
        {
            $this->load->view('jobs_search', $this->data);
        }
    }
    
    function load_map($job_id = '')
    {
		
		if($job_id != ''){
			$this->data['job_detail']	=	$this->m_common->getjobcity($job_id);
			
			}
        $this->load->view('map',  $this->data);
    }
    
    public function job_listing()
    {
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/job_listing/";
         $tbl_nam = 'tbl_jobs';
        $this->load->model('jobs_model');
         $rows = $this->jobs_model->record_count($tbl_nam);
                
                $config["total_rows"] = $rows;
                $config["per_page"] = 10;
                $config["uri_segment"] = 3;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        if($this->uri->segment(3))
        {
            $page = $this->uri->segment(3);
        }
        else 
        {
            $page = 0;
        }
        $this->data['page'] = $page;
        $this->data['categories'] = $this->jobs_model->get_categories();
        $this->data['pagin'] =$this->pagination->create_links();
        
        $this->data['rat_dv'] = 20;
        $criter = $this->resume_model->get_job_rating_criteria();
        $this->data['jobs'] = $this->jobs_model->get_jobs($page, $config['per_page'],$ck_dt = null, $criter);
        
        $criteria = $this->resume_model->get_job_rating_criteria();
       
        $this->data['review_criteria'] = $criteria;
        //echo "<pre>"; print_r($this->data['jobs']); exit;
        $this->load->view('jobs_listing',$this->data);
    }
    
    function companies_listing()
    {
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."welcome/companies_listing/";
        $tbl_nam = 'tbl_companyy';
        $this->load->model('jobs_model');
         $rows = $this->jobs_model->count_companies($tbl_nam);
                
                $config["total_rows"] = $rows;
                $config["per_page"] = 10;
                $config["uri_segment"] = 3;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        if($this->uri->segment(3))
        {
            $page = $this->uri->segment(3);
        }
        else 
        {
            $page = 0;
        }
        $this->data['page'] = $page;
        $this->data['pagin'] =$this->pagination->create_links();
        $this->data['emprs'] = $this->resume_model->get_latest_companies($page, $config['per_page']);
        //echo $this->db->last_query(); echo "<pre>"; print_r($this->data['emprs']); exit;
        $this->load->view('emp_listing',$this->data);
    }
    
    function google_login()
    {
        include("http://localhost/jobportal/resources/google-api-php-client/src/Google_Client.php");
        include("http://localhost/jobportal/resources/google-api-php-client/src/contrib/Google_PlusService.php");

        
        $client = new apiClient(); echo "<pre>"; print_r($client); exit;
        $client->setApplicationName("Google+ PHP Starter Application");
        
        $client->setClientId('Your Client ID');
        $client->setClientSecret('Your Client Secret');
        $client->setRedirectUri('Your Redirect URI');
        $client->setDeveloperKey('Your API key');
        
        $client->setScopes(array('https://www.googleapis.com/auth/plus.me'));
        
        $plus = new apiPlusService($client);
        $cod=$this->input->get('code');
        echo $cod; exit;
//        if(isset($cod))
//        {
//            $client->authenticate();
//            $this->session->set_userdata('access_token') = $client->getAccessToken();
//            //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
//            echo "<pre>"; print_r($this->session->all_userdata()); exit;
//        }
          
         
    }

    public function logout()
        { 
            $this->session->sess_destroy();
            redirect('welcome/index');
            exit;
        }
	function showpopup($package_id = ''){
		$data = '';
		session_start();
		$_SESSION['package_id']		=	$package_id;
		$url		=	 base_url('jobs/getpackagedetail/'.$package_id);
		$this->session->set_userdata('previous_page', $url);
		//return  "";
		return  $this->load->view('common_pages/login_popup',$data);
		exit;
}
	
	function packages(){
		$this->data['url']= base_url();
		$this->data['packagesArray']		=	$this->m_common->view_record('tbl_packages');
		$this->load->view('packages',$this->data);
}

	
	//// THis funciton is used in AJAX CUSTOM search in ADVANCE SEAR
	
	############# PLEASE DONT MESS UP WITH THIS FUNCTION UNTILL 12-12-2015 #############################
	############# THIS WAS CREATE BY SENIOR PHP DEVELOPER ZEESHAN KHUWAJA 
	############# IN ORDER TO BUILT ADVANCE SEARCH FEATURES THROUGH AJAX #############################
	function custom_search($param = '',$source){
		$this->session_check();
		
		//echo $source; exit;
		
		if($param == 'noparameterfortitle'){
			// this parameter was pass in case when the title would be counted as null
			$param = '';
			}
		
			
		$query_string = '';
		$query_string	.=	"WHERE tbl_jobs.job_id != '' ";
		$url 	= 	site_url();
        $set_sessn['search_dt']['order_by']	=	'tbl_jobs.job_id'; 
		$seso = $set_sessn['search_dt'];
        $this->session->set_userdata($seso);
		if($param != 'searchalljob' and $source != 'searchalljob'){
		
			if($source != 'searchallcityjob') {
			
		
		//echo $this->session->userdata['search_dt']['srch']; exit;
		//if($param == 1){ // mean search is for relevance
		//$this->session->userdata['search_dt']['ttl']	=	$param;
		if(isset($this->session->userdata['search_dt']['ttl']) and $this->session->userdata['search_dt']['ttl'] != ''){
				
				$search_title		=	$this->session->userdata['search_dt']['ttl'];
			}
			//}
		else{
			
			$param							=	str_replace("%20", " ", $param);
			$set_sessn['search_dt']['ttl'] 	=	$search_title			=	$param;
            $seso = $set_sessn;
            $this->session->set_userdata($seso);
			//echo "<pre>uf"; print_r($this->session->all_userdata()); exit;
			}
		
		
		if(!isset($this->session->userdata['search_dt']['ttl'])){
				//echo "<pre>dasd"; print_r($this->session->all_userdata()); exit;
				$a['ttl']	=	$this->session->userdata['ttl'];
				$seso['search_dt'] = $a;
    			$this->session->set_userdata($seso);
			
			}
		
		if($this->session->userdata['search_dt']['ttl'] != ''){
			//echo $this->session->userdata['search_dt']['ttl']; exit;
		$title_array		=	explode(" ",$search_title);
					$count_title		=	count($title_array);
					if($count_title > 0){
						$query_string .= 'AND (';
						for($i = 0; $i < $count_title; $i++){
							if($i+1 == $count_title){
								// this mean that the element is last and in that case we dont need to insert OR at the end
								$query_string	.=	"LCASE(tbl_jobs.`job_title`) LIKE LCASE('%".$title_array[$i]."%') ";
								
							}
							else{
								// element is not last and we do need to Insert Or at the end;
								$query_string	.=	" LCASE(tbl_jobs.`job_title`) LIKE LCASE('%".$title_array[$i]."%') OR ";
								}
							}
						//$query_string = $query_string.')';
						
						$query_string .= 'OR ';
						for($i = 0; $i < $count_title; $i++){
							if($i+1 == $count_title){
								// this mean that the element is last and in that case we dont need to insert OR at the end
								$query_string	.=	"LCASE(tbl_city.`name`) LIKE LCASE('%".$title_array[$i]."%') ";
								
							}
							else{
								// element is not last and we do need to Insert Or at the end;
								$query_string	.=	" LCASE(tbl_city.`name`) LIKE LCASE('%".$title_array[$i]."%') OR ";
								}
							}
						$query_string = $query_string.')';	
						
						
				}
		}
		if(isset($this->session->userdata['search_dt']['srch']) and $this->session->userdata['search_dt']['srch'] != ''){
			$query_string	.=	" AND LCASE(tbl_city.name) LIKE LCASE('%".$this->session->userdata['search_dt']['srch']."%') ";
            }
		//echo $query_string; exit;			
		// by default seaxh will be date wise	
		$set_sessn['search_dt']['order_by']	=	'tbl_jobs.job_id';
		if($source == 'relevance'){
			$set_sessn['search_dt']['order_by']	=	'tbl_jobs.`category`';	
		}
		elseif($source == 'date'){
			$set_sessn['search_dt']['order_by']	=	'tbl_jobs.job_id';
			//$query_string.=" ORDER BY  ASC";	
		}
                $seso = $set_sessn['search_dt'];
                                    $this->session->set_userdata($seso);
		
		// START OF  FILTER DATE POSTED ////////
        if($source == 'lastday' || $source == 'lastweek' || $source == 'twoweek' || $source == 'lastmonth' || $source == 'anytime' ){
               
				if($source == 'lastday'){
                   $date = date('Y-m-d');
				   $newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
				   $set_sessn['search_dt']['date'] = date ( 'Y-m-d' , $newdate );
				    
                }
				elseif($source == 'lastweek'){
                   $date = date('Y-m-d');
				   $newdate = strtotime ( '-1 week' , strtotime ( $date ) ) ;
				   $set_sessn['search_dt']['date'] = date ( 'Y-m-d' , $newdate );
				    
                }
				elseif($source == 'twoweek'){
                   $date = date('Y-m-d');
				   $newdate = strtotime ( '-2 week' , strtotime ( $date ) ) ;
				   $set_sessn['search_dt']['date'] = date ( 'Y-m-d' , $newdate );
				    
                }
				elseif($source == 'lastmonth'){
                   $date = date('Y-m-d');
				   $newdate = strtotime ( '-1 month' , strtotime ( $date ) ) ;
				   $set_sessn['search_dt']['date'] = date ( 'Y-m-d' , $newdate );
				    
                }
				else{
                   $date = date('Y-m-d');
				   $newdate = strtotime ( '-13 year' , strtotime ( $date ) ) ;
				   $set_sessn['search_dt']['date'] = date ( 'Y-m-d' , $newdate );
				    
                }
                
                $seso = $set_sessn['search_dt'];
                                    $this->session->set_userdata($seso);
        } 
		
		if(isset($this->session->userdata['date']) and $this->session->userdata['date'] != ''){
			$query_string	.=	" AND tbl_jobs.`start_date` >= '".$this->session->userdata['date']."' ";
            }
		
		// END OF FILTER DATE POSTED ////////
		
		// START OF  FILTER JOB TYPE ////////
        if($source == 'all_times' || $source == 'part_time' || $source == 'full_time'){
                if($source == 'full_time'){
                   $set_sessn['search_dt']['j_types'] = 1 ;
				    
                }
				elseif($source == 'part_time'){
                   $set_sessn['search_dt']['j_types'] = 2;
				    
                }
				else{
				   $set_sessn['search_dt']['j_types'] = 0;
				    
                }
                
                $seso = $set_sessn['search_dt'];
                                    $this->session->set_userdata($seso);
        } 
		
		if(isset($this->session->userdata['j_types']) and $this->session->userdata['j_types'] != ''){
			if($this->session->userdata['j_types'] == 0){
				$query_string	.=	" AND tbl_jobs.`job_type` != '' ";
				}
			else{
				$query_string	.=	" AND tbl_jobs.`job_type` = ".$this->session->userdata['j_types']." ";
				}	
			}
		
		// END OF FILTER JOB TYPE ////////
		
		// START OF  FILTER JOB Experience ////////
        if($source == 'all_years' || $source == '1_year' || $source == '2_year' || $source == '3_year'){
                if($source == '1_year'){
                   $set_sessn['search_dt']['experience'] = 1 ;
				    
                }
				elseif($source == '2_year'){
                   $set_sessn['search_dt']['experience'] = 2 ;
				    
                }
				elseif($source == '3_year'){
                   $set_sessn['search_dt']['experience'] = 3 ;
				    
                }
				else{
				   $set_sessn['search_dt']['experience'] = 0 ;
				    
                }	
                
                $seso = $set_sessn['search_dt'];
                                    $this->session->set_userdata($seso);
        } 
		
		if(isset($this->session->userdata['experience']) and $this->session->userdata['experience'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`experience` >= ".$this->session->userdata['experience']." ";
			}
		
		// END OF FILTER JOB Experience ////////
		
		// START OF  FILTER JOB Location ////////
		if (strpos($source,'location') !== false) {
			 $set_sessn['search_dt']['job_city']		=	 substr($source, 8, 100); 
				
                         $seso = $set_sessn['search_dt'];
                                    $this->session->set_userdata($seso);
		}
		if(isset($this->session->userdata['job_city']) and $this->session->userdata['job_city'] != ''){
			
				$query_string	.=	" AND LCASE(tbl_city.name) LIKE LCASE('%".$this->session->userdata['job_city']."%') ";
			}
		
		// END OF FILTER JOB Location ////////
		
		// START OF  FILTER Salary from ////////
		if (strpos($source,'salary_from') !== false) {
			 $set_sessn['search_dt']['salary_from']		=	 substr($source, 11, 50); 
				
                         $seso = $set_sessn['search_dt'];
                                                $this->session->set_userdata($seso);
		}
		if(isset($this->session->userdata['salary_from']) and $this->session->userdata['salary_from'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`salary` >= '".$this->session->userdata['salary_from']."' ";
			}
		// END OF FILTER Salary from ////////
		
		// START OF  FILTER Salary from ////////
		if (strpos($source,'salary_to') !== false) {
			 $set_sessn['search_dt']['salary_to']		=	 substr($source, 9, 20); 
				
                         $seso = $set_sessn['search_dt'];
            $this->session->set_userdata($seso);
		}
		if(isset($this->session->userdata['salary_to']) and $this->session->userdata['salary_to'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`salary_to` <= '".$this->session->userdata['salary_to']."' ";
			}
		// END OF FILTER Salary from ////////

		// START OF  FILTER Career Level ////////
		if (strpos($source,'carear_level_') !== false) {
			 $set_sessn['search_dt']['carear_level']		=	 substr($source, 13, 20); 
				
                         $seso = $set_sessn['search_dt'];
            $this->session->set_userdata($seso);
		}
		if(isset($this->session->userdata['carear_level']) and $this->session->userdata['carear_level'] != ''){
				if($this->session->userdata['carear_level'] == 0){
					$query_string	.=	" AND tbl_jobs.`career` != ''";
					}
				else{	
					$query_string	.=	" AND tbl_jobs.`career` = '".$this->session->userdata['carear_level']."' ";
			
				}
		}
		
		// END OF FILTER Career Level ////////
		if(isset($_SESSION['morecompanyjobs']) and $_SESSION['morecompanyjobs'] != ''){
				
				$query_string	.=	" AND comp.company_id  = '".$_SESSION['morecompanyjobs']."' ";
		}
		
		if(isset($_SESSION['similiarjobs']) and $_SESSION['similiarjobs'] != ''){
			
				$query_string	.=	" AND tbl_jobs.`category`  = '".$_SESSION['similiarjobs']."' ";
		}	
		//var_dump($this->session->all_userdata()); exit; 
		}
		else{
				
                                $set_sessn['search_dt']['srch']  = $param; 
                         $seso = $set_sessn['search_dt'];
            $this->session->set_userdata($seso);
				$query_string	.=	" AND LCASE(tbl_city.name) LIKE LCASE('%".$this->session->userdata['srch']."%') ";
		
		
			}	
		} // end of if parameter is alljobs
		
		
		if(isset($this->session->userdata['order_by'])){
			$query_string.=" ORDER BY ".$this->session->userdata['order_by']." ASC";
		}
                
                
                
		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
			
		//var_dump($_SESSION); exit;
		//echo $query_string; exit;
		///////////////
                $rat_dv = 20;
		$result	=	'';
			// pagination code start from here
		$this->load->library('pagination');
		$this->data['jobcount']		=	$jobcount	=		$this->jobs_model->getjobscount($query_string);
		
		$config['base_url']  		= base_url('')."welcome/job_search/";
		$config['total_rows']	 	= $jobcount->total; //1000;//$countt->countt;
		$config['per_page']   		= 10;
		$config['uri_segment']		= 3;	
		$data['info']				= array();
		$start						=	1;
		$page_start 				= $start;
		$start--;
		$start 						= $start * $config['per_page'];
		$this->pagination->initialize($config);
		$this->data['pagination']	=	$pagination		= $this->pagination->create_links();
		$this->data['start'] 		= $page_start;
		$this->data['jobs_record'] 		= $this->jobs_model->getjobs($start, $config['per_page'], $query_string);
		
		// pagination code end here
		
		
		$this->load->model('resume_model');
                $criter = $this->resume_model->get_job_rating_criteria();
		$jobs_record =	$this->jobs_model->getjobs($start,$config['per_page'],$query_string,$criter);
			
		$jobs_record =	$this->jobs_model->getjobs($start,$config['per_page'],$query_string);
			
			 //echo $count_jobs; exit;
			 $result		.='<div class="srch_top">';
			 $result	.='<div class="srch_ttl">Search Results</div>';
			 $result	.='<div id="loader" style="display:none">';
			 $result	.='<img src="'.base_url('').'resources/loader.gif" title="Loading..." /></div>';
			 $result	.='<div class="srch_count"> Total '.$jobcount->total.' Record';
			 
			 if($jobcount->total > 1){
				 $result	.='s';
				 }
			$result	.=' found';	 
			$result	.='</div>';
			$result	.='</div>';
			$result	.='<div id="data_dv">';
		if(!empty($jobs_record)){
                    $rv=1;
			foreach($jobs_record as $job){
				$result	.=	'<div class="result_container">';
				$result	.= '<div class="srch_logo">';
					if($job['logo'] != ""){
						$result	.= '<img src="'.base_url('').'uploads/profile_images/'.$job['logo'].'" />';
						
					}elseif($job['profile_pic'] != ""){
						$result	.='<img src="'.base_url('').'uploads/profile_images/'.$job['profile_pic'].'" />		';
                }else{
                $result	.= '<img src="'.base_url('').'resources/images/no_image.jpeg" />';
				
                }
				$result	.= '</div>';
				
            
            	$result	.= '<div class="ttl_comp ttl_wid">';
				$result	.='<div class="result_ttl">';
				$result	.= '<a href="'.$url.'welcome/job_details/'.$job['job_id'].'">';
				$result	.= $job['job_title']."</a></div>";
				$result	.='<div class="compny">';
				if($job['company_name'] == ""){ 
                   	$result	.=	$job['first_name'].' '.$job['last_name'];
            	}else{
                	$result	.=$job['company_name'];
            	}
				$result	.='</div>';
				$result	.= '</div><div class="src_loc_icon">';
				$result	.= '<a href="'.base_url('').'welcome/load_map/'.$job['job_id'].'" title="Show Map" >';
				$result	.= '<img height="25px" src="'.base_url().'resources/images/images/Layer40copy4.png"/>';
				$result	.=  '</a></div>';
				$result	.= '<div class="srch_location srch_loc_wid">'.$job['city_name'].'</div>';
				$result	.= '<div class="srch_type typ_mrg">';
				
				 if($job['job_type'] == 1){
				 $result	.=   '<img width="125px" height="36px" src="'.base_url().'resources/images/images2/full_time2.png"/>';
				 
					}else{
				 $result	.= '<img width="125px" height="36px" src="'.base_url().'resources/images/images2/part_time2.png"/>';
				 
				 }
				$result	.= '</div>';
				
				$result	.= '<div class="srch_descrip">';
				
		
				$job['job_description']		=	$this->strip_HTML_tags($job['job_description']);
				
                                if(isset($job['average']) && $job['average'] != ""){
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
                    
                    $avg_str = '';
                            if($avragee >= 0 && $avragee < 0.5){
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 0.5 && $avragee < 1){
                                        
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 1 && $avragee < 1.5){
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 1.5 && $avragee < 2){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 2 && $avragee < 2.5){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 2.5 && $avragee < 3){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 3 && $avragee < 3.5){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 3.5 && $avragee < 4){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 4 && $avragee < 4.5){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee >= 4.5 && $avragee < 5){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avragee == 5){ 
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $avg_str .= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                    }
				
				$result	.=	$avg_str;
				$result	.= '<div style="padding-bottom: 10px;"></div>';
				//$job['job_description']		=	strip_HTML_tags($job['job_description']);
				$result	.=	substr($job['job_description'],0,300);
				$result	.= '&nbsp;';
				$result	.= '<span class="moretag">';
				$result	.= '<a href="'.$url.'welcome/job_details/'.$job['job_id'].'" title="View detail" >More...</a>';
				$result	.= '</span>';
				$result	.='<div style="padding-bottom: 10px;"></div>';
				$result	.=' </div>';
				$result	.= '<div class="lowr_cntnr">';
				$result	.= '<div class="srch_time">';
				
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
				elseif($time > 30){
					$time	=	$time/60 ;
					if($time > 1){
						$time	=	round($time,0) ;
						$time .= " months ago";
						}
					else{
						$time	=	round($time,0) ;
						$time .= " month ago";
						}	
					
					}
				else{
					$time	=	round($time,0) ;
					$time .= " days ago";
						}
						
			 
			  
				
				$result	.= $time;
				$result	.= '</div>';
				$result	.= '<div class="attrs">';
				$result	.= '<a class="attr" href="'.$url.'welcome/job_details/'.$job['job_id'].'">Overview</a>';
				$result	.= '<a href="#popi'.$rv.'" class="fancybox attr">Review</a>';
				$result	.= '<a class="attr last" href="#">Salaries</a>';
				$result	.= '</div>';
				if(isset($this->session->userdata['user_data']['usr_id'])){
				  $result	.='<div class="addfav_icn"><img src="'.base_url().'resources/images/images2/Layer41copy3.png"/></div>';
				  $result	.= '<div class="add_fav">Add To Favorites</div>';
				  
				}
				$result	.= '</div>';
				$result	.= '</div>';
                                
                                //popup code starts here
                                
                                $result	.= '<div id="popi'.$rv.'" style="display:none;">';
                        
                                $result .= '<div class="cv_rating">';
                        
                                //----------------------------------------------------------------------
                                
                                if(isset($this->session->userdata['user_data']['u_type']) && $this->session->userdata['user_data']['u_type'] == 3){
                            $result .= '<h2 class="heading_sb">'.$job['job_title'].' Rating</h2>';
                            $result	.= '<div class="dtls">';
                                if(!empty($review_criteria)){ 
                                    
                                        if($rat_dv <= 20){
                                        $rat_dv = 20;
                                    }else{
                                        $rat_dv = $rat_dv;
     }
      
                                    foreach($review_criteria as $rev){
                                $result	.='<div class="text">'.$rev['criteria'].'</div> <div class="field"><div class="rating"  id="rate'.$rat_dv.'"></div></div>';
                                
                                $result	.= '<div class="clearfix"></div>';
                                $result	.= '<script>';
                                $result	.= 'var rv_id = '.$rat_dv.';';
                                $result	.= 'var str_rt = "'.$url.'review/job_star_rating/'.$rev['id'].'/'.$job['job_id'].'";';
                                $result	.= '$("#rate"+rv_id).rating(str_rt, {maxvalue:5, increment:.5});';
                                $result	.= '</script>';

                                $rat_dv++;} } 
                                                  $result	.= form_open('review/add_job_review/'.$job['job_id']);
                                $result	.= '<div class="text">Review:</div>';
                                $result	.= '<div class="field">';
                                    $result	.= '<textarea name="review" rows="9" cols="54" required></textarea>';
                                $result	.= '</div>';
                                $result	.= '<div class="clearfix"></div>';


                                $result	.= '<div class="text"></div><div class="field"><input type="submit" name="post_review" value="Post Review"/></div>';
                                $result	.= form_close();
                            $result	.= '</div>';
                 } else{ 
                            
                            $result .='<h2> Give Your Rating </h2>';
                            
                            $result	.= '<div class="rating"  id="rate'.$rv.'"></div>';
                                        $result	.= '<script>';
                                $result	.= 'var rv_id = '.$rv.';';
                                $result	.= 'var str_rt = "'.$url.'review/job_guest_star_rating/'.$job['job_id'].'";';
                                $result	.= '$("#rate"+rv_id).rating(str_rt, {maxvalue:5, increment:.5});';
                                $result	.= '</script>';
                            
	 }
                                
                                //-----------------------------------------------------------------------
                        
                        $result	.= '<div class="reviews_list">';
                                
                    if(isset($job['average']) && $job['average'] != ""){ 
                        $result	.= '<div><h3>Average Rating</h3></div>';
                        $clr_ck=0;
                        foreach($job['average'] as $avrg){
                                
                                $result	.= '<div class="rating_candi">';
                                $result	.= '<div> '.$avrg[0]['criteria'].' </div> <div>';
                                    
                                if($avrg[0]['avg_rat'] == 0){
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 0.5 && $avrg[0]['avg_rat'] < 1){
                                        
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 1){
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 1.5 && $avrg[0]['avg_rat'] < 2){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 2){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 2.5 && $avrg[0]['avg_rat'] < 3){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 3){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 3.5 && $avrg[0]['avg_rat'] < 4){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 4){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] >= 4.5 && $avrg[0]['avg_rat'] < 5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($avrg[0]['avg_rat'] == 5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                    }
                                    
                                $result	.= '</div> </div>';
                                
                                $mod = $clr_ck %2; 
                                if($mod!=0){
            $result	.= '<div class="clearfix"></div>';
                                
                                } $clr_ck++;} 
                                $result	.= '<div class="clearfix"></div><div class="separator"></div>';
                                } 
                                if($job['reviews'] != ""){ 
                                    foreach($job['reviews'] as $rev){
                                        
                                        $result	.= '<div class="review_ttl"> <h3>'.$rev['first_name'].' '.$rev['last_name'].'</h3> </div>';
                                        $clr_ck = 0;
                                        if(isset($rev['ratings'])){
                                        foreach($rev['ratings'] as $rate){
                                
                               $result	.= '<div class="rating_candi">';
                               $result	.= '<div> '.$rate['criteria'].' </div>'; 
                               $result	.= '<div>'; 
                                    if($rate['rating'] == 0){
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 0.5){
                                        
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 1){
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 1.5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 2){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 2.5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 3){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 3.5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 4){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 4.5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/half_star.png" height="32px" width="32px"/>';
                                    }
                                    elseif($rate['rating'] == 5){ 
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/full_star.png" height="32px" width="32px"/>';
                                    }
                                    
                                $result	.= '</div> </div>';
                                
                                $mod=$clr_ck%2; 
                                if($mod!=0){
                                $result	.= '<div class="clearfix"></div>';
                                    } $clr_ck++; } }
                                $result	.= '<div class="clearfix"></div>';
                                $result	.= '<div class="review_ttl"> Review </div>';
                                $result	.= '<div class="review_txt"> '.$rev['review'].' </div>';
                                $result	.= '<div class="clearfix"></div>';
            '$result	.= <div class="separator"></div>';
                                }}else{
                                    $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        $result	.= '<img src="'.base_url().'resources/images/empty_star.png" height="32px" width="32px"/>';
                                        
                                        
                                       $result	.= '<div class="clearfix"></div>';
                                       $result	.= '<div class="separator"></div>';
            
            
            
                                } 
				$result	.= '</div>';
			
            
                        
                            
                    $result	.= '</div>';
                $result	.= '</div>';
                                
                                //popup code ends here
                
                
                
				$result	.= '<div class="separator"></div>';
				$result	.= '</div>';
			
    $rv++; } 
    $result .= '<div class="pagination">';
	 $result .= $pagination.'</div>';
	 }
	 else{ 
	 $result .= '<div class="result_container">';
	 $result .= '<div class="ttl_comp ttl_wid">';
	 $result .= '<div class="result_ttl" style="width: 150%;"> No Record found please search again with change keywork</div></div></div>';
	 //$result = "No record Found";
	 }
	 
     echo $result; exit;
		
		
}
	
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

        
    function login_with_linkedin()
    {
       
        $api_key = "78ylvhj3kxwqlo";
        $api_secret = "JMaynxmSpKmc2BSo";
        $callback_url = "http://localhost/jobportal/welcome/login_with_linkedin";
        $scope = array('r_basicprofile','r_emailaddress','r_fullprofile','r_network');
        //echo 'In link login';
        
        $config = array('api_key' => $api_key, 'api_secret' => $api_secret , 'callback_url' => $callback_url);
       $this->load->library('Linkedin',$config);
        //$this->LinkedIn($config);

        if (isset($_REQUEST['code'])) {
            $code = $_REQUEST['code'];
            $access_token = $this->linkedin->getAccessToken($code);
            $this->linkedin->setAccessToken($access_token);
            $user = $this->linkedin->get("people/~:(id,public-profile-url,first-name,last-name,email-address,headline,picture-url)");
            
//            $sess_array['public-profile-url'] = $user['publicProfileUrl'];
//            echo "<pre>";
//            print_r($user);
//            exit;
//            
            
            
            $this->load->model('auth_model');
            $fb_ck = $this->auth_model->fb_login_details($user['id'], $user['firstName'], $user['lastName'], $user['emailAddress']);
        //echo "<pre>";        print_r($fb_ck); exit;
        $urdta['user_data'] = array(
                        'usr_id' => $fb_ck,
                        'is_user_logged_in' => TRUE,
                        'f_name' => $user['firstName'],
                        'l_name' =>  $user['lastName'],
                        'u_type' => 3,
                        'email' => $user['emailAddress'],
                        'dp' => '',
                        'is_link_usr' => TRUE
                    );
        
        $this->session->set_userdata($urdta);
            //$authUrl = $this->linkedin->getLoginUrl($scope);
                
            redirect('welcome/index');
}
        else{

            if (isset($_REQUEST['error'])) {
                header('Location: ./index.php?error_code=1');
	}
            else{
                $authUrl = $this->linkedin->getLoginUrl($scope);
                
                header("Location: $authUrl");            }
}
	
}

function clearsearchfilter(){
	//$this->load->library('session');
	if(isset($this->session->userdata['search_dt']['ttl'])){	
		$title	=	$this->session->userdata['search_dt']['ttl'];
	}
	else{
		$title	= '';
		}
	$this->session_check();
	//if(isset($_SESSION['similiarjobs'])){
		//unset($_SESSION['similiarjobs']);
	//}

	//if(isset($_SESSION['similiarjobs'])){
		//unset($_SESSION['similiarjobs']);
	//}
	session_destroy();			 	
	//echo $title;	
	
	#### session unset was not working thats why i used session_destroy fro teh time but that will be changed later so 		dont mess up with this function #########


	
/*	$this->session->unset_userdata('srch');
	$this->session->unset_userdata['date'];
	$this->session->unset_userdata['j_types'];
	$this->session->unset_userdata['experience'];
	$this->session->unset_userdata('salary_from');
	$this->session->unset_userdata('salary_to');
	/*$this->session->unset_userdata['carear_level'];
	$this->session->unset_userdata['job_city'];
	*/
	
	//var_dump($this->session->all_userdata());
	//exit;
	
	$this->session->sess_destroy();
	
	$a['ttl']	=	$title;
	$seso['search_dt'] = $a;
    $this->session->set_userdata($seso);
	//$set_sessn['search_dt'] = 
    //$seso = $set_sessn['search_dt'];
    //$this->session->set_userdata($seso);
	//var_dump($this->session->all_userdata());
	//exit;
	//echo $this->session->userdata['search_dt']['ttl'];
	//exit;
	$this->custom_search($this->session->userdata['search_dt']['ttl'],'date');
	
}

function session_check(){
	if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
	}
}
function showjobforprint($job_id){
		$this->data['url'] = site_url();
       	$this->load->model('jobs_model');
        $this->data['categories'] = $this->jobs_model->get_categories();
        $this->load->model('jobs_model');
		$usr_id	=	'';
        $this->data['check'] = $this->jobs_model->check_apply($job_id, $usr_id);
        $view = $this->jobs_model->update_views($job_id);
        $this->data['job_dt'] = $this->jobs_model->get_job_detail($job_id);
        //echo "<pre>"; print_r($data['job_dt']); exit;
        return $this->load->view('print_job',$this->data);
	}
}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
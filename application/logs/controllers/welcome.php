<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
         public function __construct()
	{
		parent::__construct();
                
                
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
                    if($this->session->userdata['user_data']['u_type'] == 2 || $this->session->userdata['user_data']['u_type'] == 4)
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
            if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
            {
                redirect('welcome/pricing');
                exit;
            }
            else
            {
                $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."/welcome/candidates_listing/";
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
    }
    
    public function cand_list()
    {
        $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."/welcome/candidates_listing/";
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
          if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
            {
                redirect('welcome/pricing');
                exit;
            }
            else
            {
                $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."/welcome/candidates_listing/";
                 $tbl_nam = 'tbl_property_manager';
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
                $candidates = $this->resume_model->get_latest_resumes($page, $config['per_page'], $check);
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

               $this->data['review_criteria'] = $candu;
                //echo "<pre>"; print_r($this->data['cands']); exit;
                $this->load->view('candidates_listing',$this->data);
            }
    }
    
        
         public function job_search()
    {
        
        $this->form_validation->set_rules('search_box');
        if($this->form_validation->run() == FALSE)
        {
            $this->load->model('jobs_model');
            $this->data['categories'] = $this->jobs_model->get_categories();
            $this->load->view('job_search',$this->data);
        }
        else
        {
            $search = $this->db->escape_str($this->input->post('search_box'));
            //$dbdata['cat'] = $this->db->escape_str($this->input->post('category'));
            $loc = $this->db->escape_str($this->input->post('location'));
//            if($search != "")
//            {
//                $dbdata['srch'] = $search;
//                $field = "job_title";
//                $dbdata['fld'] = "";
//            }
//            elseif($loc != "")
//            {
//                $dbdata['srch'] = $loc;
//                $field = "city";
//                $dbdata['fld'] = $field;
//            }
//            else
//            {
//                $dbdata['srch'] = "";
//                $field = "";
//                $dbdata['fld'] = $field;
//            }
            if($search == "")
            {
                $dbdata['ttl'] = "a";
            }
            else
            {
                $dbdata['ttl'] = $search;
            }
            
            if($loc == "")
            {
                $dbdata['srch'] = "a";
            }
            else
            {
                $dbdata['srch'] = $loc;
            }
            
            
                $field = "city";
                $dbdata['fld'] = $field;
            
            $data['url'] = site_url();
        $config = array();
        $config["base_url"] = $data['url']."/welcome/job_search/";
         $tbl_nam = 'tbl_jobs';
         
         $field1 = "job_title";
        $this->load->model('jobs_model');
        if($field != "")
        {
            $rows = $this->jobs_model->record_count($tbl_nam,$dbdata,$field,$field1);
        }
        else 
        {
            $rows = $this->jobs_model->record_count_emp($tbl_nam, $dbdata['cat'], $field1);
        }
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
            $this->data['jobs'] = $this->jobs_model->get_jobs($page, $config['per_page'], $dbdata);
//            echo $this->db->last_query();
//            echo "<pre>"; print_r($data['jobs']); exit;
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
                $this->session->set_flashdata('msg','Search Not Found.');
                redirect('welcome/index');
                exit;
            }
        }
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
        $view = $this->jobs_model->update_views($id);
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
        $config["base_url"] = $this->data['url']."/jobs/inner_search_data/";
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
    
    function load_map()
    {
//        echo $this->uri->segment(3); exit;
//        $this->data['adress'] = $_POST['adrs'];
        $this->load->view('map',  $this->data);
    }
    
    public function job_listing()
    {
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."/jobs/job_listing/";
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
        $this->data['jobs'] = $this->jobs_model->get_jobs($page, $config['per_page']);
        //echo "<pre>"; print_r($this->data['jobs']); exit;
        $this->load->view('jobs_listing',$this->data);
    }
    
    function companies_listing()
    {
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."/welcome/companies_listing/";
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
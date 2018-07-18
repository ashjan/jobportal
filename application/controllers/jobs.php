<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

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
                
               session_start();
			   //var_dump($_SERVER); exit;
               if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                   //echo "<pre>"; print_r($_SERVER); exit;
                   if (isset($_SERVER['HTTP_REFERER']))
                    {
                        $this->session->set_userdata('previous_page', $_SERVER['REQUEST_URI']);
						$request_url_data	=	explode('/',$_SERVER['REQUEST_URI']);
						$total_directory_seperator		=	count($request_url_data);
						$requred_url_data	=	$total_directory_seperator	- 1;
						$package_id		= $request_url_data[$requred_url_data];	
						$_SESSION['package_id']		=	$package_id;
						//echo $package_id; exit;
						if(is_numeric($package_id)){
							$this->session->set_userdata('referrer_page','package');
							}
						//var_dump($this->session->userdata('referrer_page')); exit;	
						//$this->session->set-userdata('referrer_page')
						$_SESSION['requested_page'] = $_SERVER['REQUEST_URI'];
						
                    }
                    redirect('welcome/login');
                    exit;
                }
                //$this->load->model('menu_manager');
                //Loading menu for widget 1
                $load_widget1_menus=$this->menu_manager->load_widget1_menus();
                $this->data['widget1_menus_items']=$load_widget1_menus;

        	//Loading menu for widget 2
                $load_widget2_menus=$this->menu_manager->load_widget2_menus();
                $this->data['widget2_menus_items']=$load_widget2_menus;

        	//Loading menu for widget 3
                $this->data['widget3_menus_items']   = $load_widget3_menus  =  $this->menu_manager->load_widget3_menus();
        	//$this->data['widget3_menus_items']=$load_widget3_menus;
                
                
                $this->load->model('jobs_model');
                $this->load->model('profile_model');
                $this->load->model('resume_model');
                if(isset($this->session->userdata['user_data']['usr_id']))
                {
                    $cand_id = $this->session->userdata['user_data']['usr_id'];
                    $this->data['resume'] = $this->resume_model->get_resume($cand_id);
                    $this->data['owner'] = $this->profile_model->check_comp_owner($cand_id);
                }
                
                $this->data['url'] = site_url();
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
                
                if(isset($_GET['query']))
                {
                    $this->data['term'] = $_GET['query'];
                }
                
                if($search = $this->input->post('search', TRUE))
                {
                    $result = $this->jobs_model->get_auto_comp($search);
                    $this->data['auto_results'] = $result;
                }
                else
                {
                    $search = "";
                    $result = $this->jobs_model->get_auto_comp($search);
                    $this->data['auto_results'] = $result;
                }
                
                $cur_url = current_url();
                $re_sgmt = explode('/', $cur_url);
                if(isset($re_sgmt[5]))
                {
                    $this->data['re_sgmt'] = $re_sgmt[5];
                }
        }
        
	public function index()
	{
            $this->form_validation->set_rules('title','Job Title','required');
            $this->form_validation->set_rules('Country','Country','required');
            $this->form_validation->set_rules('State','State','required');
           	$this->form_validation->set_rules('salary','Salary','required');
            $this->form_validation->set_rules('category','Category','required');
            $this->form_validation->set_rules('start_date','Start Date','required');
            $this->form_validation->set_rules('end_date','End Date','required');
			
			// getting the form input from the from
			$data['ttl']	=	$this->data['ttl'] = $this->db->escape_str($this->input->post('title'));
			$data['des']	=	$this->data['des'] = $this->db->escape_str($this->input->post('description'));
			$data['cntry'] 	=	$this->data['cntry'] = $this->db->escape_str($this->input->post('Country'));
			$data['state']	=	$this->data['state'] = $this->db->escape_str($this->input->post('State'));
			
			$data['cty']	=	$this->data['cty'] = $this->db->escape_str($this->input->post('City'));
			$data['sal']	=	$this->data['sal'] = $this->db->escape_str($this->input->post('salary'));
			$data['sal_to']	=	$this->data['sal_to'] = $this->db->escape_str($this->input->post('salary_to'));
			$data['cat']	=	$this->data['cat'] = $this->db->escape_str($this->input->post('category'));
			$data['start']	=	$this->data['start'] = $this->db->escape_str($this->input->post('start_date'));
			$data['end']	=	$this->data['end'] = $this->db->escape_str($this->input->post('end_date'));
			$data['type']	=	$this->data['type'] = $this->db->escape_str($this->input->post('type'));
			$data['u_id']	=	$this->data['u_id']=  $this->session->userdata['user_data']['usr_id'];
			$data['career']	=	$this->data['career'] = $this->db->escape_str($this->input->post('career_lvl'));
			$data['experience']	=	$this->data['experience'] = $this->db->escape_str($this->input->post('experience'));
			$data['vacancies']	=	$this->data['vacancies'] = $this->db->escape_str($this->input->post('vacancies'));
			$data['shift']		=	$this->data['shift'] = $this->db->escape_str($this->input->post('shift'));
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['countries'] = $this->jobs_model->get_countries();
                $this->load->view('post_new_job',$this->data);
            }
            else{
                
                
                $this->load->model('jobs_model');
				
                $result = $this->jobs_model->add_job($data);
				//var_dump($result); exit;
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your job Posted Successfully...!');
                    redirect('jobs/index',$this->data);
                }
                else{
                    $this->session->set_flashdata('err_msg','Job posting Error.');
                    redirect('jobs/index',$this->data);
                }
            }
            
	}
        
        
        public function employer_dashboard()
        {
            $this->load->view('employer_dashboard', $this->data);
        }
    
    function uploadcv() {
        var_dump($_FILES['userfile1']);

        if ($_FILES['userfile1']['error'] == 4) {
            return "no file";
        } else {

            $config_file['upload_path'] = APPPATH . 'uploads/pix';
            $config_file['allowed_types'] = "pdf|doc|docx";
            $config_file['encrypt_name'] = true;
            $config_file['overwrite'] = TRUE;
            $config_file['max_size'] = '1000KB';

            $this->load->library('upload', $config_file);

            if (!$this->upload->do_upload('userfile1')) {
                $error = array('cv error' => $this->upload->display_errors());
                foreach ($error as $key => $value) {
                    echo $key . ": " . $value;
                }
            } else {
                $data = array('upload_data' => $this->upload->data());
                $upload_data = $this->upload->data();
                $cv = $upload_data['file_name'];
                return $cv;
            }
        }
    }
        
        public function edit_job()
	{
            
            $this->form_validation->set_rules('title','Job Title','required');
            $this->form_validation->set_rules('Country','Country','required');
            $this->form_validation->set_rules('State','State','required');
            $this->form_validation->set_rules('City','City','required');
            $this->form_validation->set_rules('salary','Salary','required');
            $this->form_validation->set_rules('category','Category','required');
            $this->form_validation->set_rules('start_date','Start Date','required');
            $this->form_validation->set_rules('end_date','End Date','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $job_id = $this->uri->segment(3);
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['countries'] = $this->jobs_model->get_countries();
                
                $this->data['job_dtl'] = $this->jobs_model->get_added_job_details($job_id);
                
                $this->load->view('edit_job',$this->data);
            }
            else{
                $data['ttl'] = $this->db->escape_str($this->input->post('title'));
                $data['des'] = $this->db->escape_str($this->input->post('description'));
                $data['cntry'] = $this->db->escape_str($this->input->post('Country'));
                $data['state'] = $this->db->escape_str($this->input->post('State'));
                $data['cty'] = $this->db->escape_str($this->input->post('City'));
                $data['sal'] = $this->db->escape_str($this->input->post('salary'));
                $data['sal_to'] = $this->db->escape_str($this->input->post('salary_to'));
                $data['cat'] = $this->db->escape_str($this->input->post('category'));
                $data['start'] = $this->db->escape_str($this->input->post('start_date'));
                $data['end'] = $this->db->escape_str($this->input->post('end_date'));
                $data['jb_id'] = $this->db->escape_str($this->input->post('job_id'));
                $data['type'] = $this->db->escape_str($this->input->post('type'));
                $data['u_id']=  $this->session->userdata['user_data']['usr_id'];
                
                $data['career'] = $this->db->escape_str($this->input->post('career_lvl'));
                $data['experience'] = $this->db->escape_str($this->input->post('experience'));
                $data['vacancies'] = $this->db->escape_str($this->input->post('vacancies'));
                $data['shift'] = $this->db->escape_str($this->input->post('shift'));
                
                $this->load->model('jobs_model');
                $result = $this->jobs_model->update_job($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your job Edited Successfully...!');
                    redirect('jobs/emp_job_listing');
                }
                else{
                    $this->session->set_flashdata('err_msg','Job posting Error.');
                    redirect('jobs/edit_job');
                }
            }
            
	}
        
        function list_states() {
        $id = $this->uri->segment(3);
        $state = $this->uri->segment(4);
        $this->load->model('jobs_model');
        $result = $this->jobs_model->states($id);
        echo '<option value="">--Select State--</option>';
        foreach ($result as $res) {
            if ($state == $res['regionid']) {
                echo '<option value="' . $res['regionid'] . '" selected>' . $res['region'] . '</option>';
            } else {
                echo '<option value="' . $res['regionid'] . '">' . $res['region'] . '</option>';
            }
        }
    }

    function list_cities() {
        $id = $this->uri->segment(3);
        if ($id == 0) {
            $id = $this->uri->segment(5);
        }
        $city = $this->uri->segment(4);
        $this->load->model('jobs_model');
        $result = $this->jobs_model->cities($id);
        //echo "<pre>"; print_r($result); exit;
        echo '<option value=""> --Select City-- </option>';
        if (!empty($result)) {
            foreach ($result as $res) {
                if ($city != "") {
                    if ($city == $res['id']) {
                        echo '<option value="' . $res['id'] . '" selected>' . $res['name'] . '</option>';
                    } else {
                        echo '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
                    }
                } else {
                    echo '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
                }
            }
        }
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
        $this->data['jobs'] = $this->jobs_model->get_jobs($page, $config['per_page'], $ck_dt = null, $criter);
        
        $this->load->model('resume_model');
        $criteria = $this->resume_model->get_job_rating_criteria();
       
                    $this->data['review_criteria'] = $criteria;
        //echo "<pre>"; print_r($this->data['jobs']); exit;
        $this->load->view('jobs_listing',$this->data);
    }
    
    
    
    function filter_jobs()
    {
        $cat_id = $this->uri->segment(3);
        $result = $this->jobs_model->get_filter_jobs($cat_id);
        
        echo json_encode($result);
    }
    
    public function job_details()
    {
        $this->data['url'] = site_url();
        $id = $this->uri->segment(3);
        
        if($id == "")
        {
            redirect('welcome/index');
            exit;
        }
        
        $usr_id = $this->session->userdata['user_data']['usr_id'];
        $this->data['uid'] = $usr_id;
        $this->data['utyp'] = $this->session->userdata['user_data']['u_type'];
        $this->load->model('jobs_model');
        if($this->uri->segment(4) != "")
        {
            $this->data['first_chk'] = $this->uri->segment(4); 
        }
        $this->data['check'] = $this->jobs_model->check_apply($id, $usr_id);
        $view = $this->jobs_model->update_views($id);
        $uploaded_res = $this->jobs_model->get_uploaded_resume($usr_id);
        $resume = explode(',', $uploaded_res);
        $this->data['uploaded_res'] = $resume;
        $this->data['job_dt'] = $this->jobs_model->get_job_detail($id);
        //echo "<pre>"; print_r($this->data['job_dt']); exit;
        $this->load->view('job_details',$this->data);
    }
    
     public function delete_job()
    {
        $data['url'] = site_url();
        $id = $this->uri->segment(3);
        $this->load->model('jobs_model');
        $del = $this->jobs_model->delete_job($id);
        
        if($del > 0)
        {
            $this->session->set_flashdata('msg','The Selected Job Deleted Successfully...');
            redirect('jobs/emp_job_listing');
            exit;
        }
        else 
        {
            $this->session->set_flashdata('err_msg','The selected job not deleted Error..!!');
            redirect('jobs/job_details/'.$id);
            exit;
        }
    }
    
    
    public function add_fav_job()
    {
        $u_typ = $this->session->userdata['user_data']['u_type'];
        $job_id = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $fav_id = $this->uri->segment(5);
        $usr_id = $this->session->userdata['user_data']['usr_id'];
       
        $add_fav = $this->jobs_model->add_fav_job($job_id, $usr_id, $fav_id);
        
        if($u_typ == 3)
        {
            redirect('jobs/job_listing/'.$page);
            exit;
        }
        else
        {
            redirect('jobs/emp_job_listing/'.$page);
            exit;
        }
    }
    
    
    public function job_search()
    {
        $this->form_validation->set_rules('search');
        $this->form_validation->set_rules('category');
        if($this->form_validation->run() == FALSE)
        {
            $this->load->model('jobs_model');
            $this->data['categories'] = $this->jobs_model->get_categories();
            $this->load->view('job_search',$this->data);
        }
        else
        {
            $dbdata['srch'] = $this->db->escape_str($this->input->post('search'));
            $dbdata['cat'] = $this->db->escape_str($this->input->post('category'));
            
            $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/job_listing/";
         $tbl_nam = 'tbl_jobs';
         $field = "job_title";
         $field1 = "category";
        $this->load->model('jobs_model');
         $rows = $this->jobs_model->record_count($tbl_nam,$dbdata,$field,$field1);
                
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
            
            $this->data['pagin'] =$this->pagination->create_links();
            $this->data['jobs'] = $this->jobs_model->get_jobs($page, $config['per_page'], $dbdata);
        
            $this->load->view('jobs_listing',$this->data);
        }
    }

        public function apply()
    {
        $data['url'] = site_url();
        $dbdata['id'] = $this->input->post('job_id');
        $dbdata['comp'] = $this->input->post('company');
        $dbdata['res_id'] = $this->db->escape_str($this->input->post('apl_resume'));
        $dbdata['c_ttl'] = $this->db->escape_str($this->input->post('cover_title'));
        $dbdata['c_ltr'] = $this->db->escape_str($this->input->post('cover_letter_des'));
        
        $dbdata['usr_id'] = $this->session->userdata['user_data']['usr_id'];
        //echo "<pre>"; print_r($dbdata); exit;
        $this->load->model('jobs_model');
        $aply = $this->jobs_model->job_apply($dbdata);
        if($aply > 0)
        {
            $this->session->set_flashdata('msg','You have Successfully Applied for this job');
            redirect('jobs/job_details/'.$dbdata['id']);
            exit;
        }
        else
        {
            $this->session->set_flashdata('err_msg','Job Application Error.....');
            redirect('jobs/job_details/'.$dbdata['id']);
            exit;
        }
    }
    
    
    public function cand_applications()
    {
        $cand_id = $this->session->userdata['user_data']['usr_id'];
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/cand_applications/";
         $tbl_nam = 'job_applications';
         $field = 'candidate_id';
        $this->load->model('jobs_model');
        $rows = $this->jobs_model->record_count($tbl_nam, $cand_id, $field);
             
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
        $this->data['pagin'] =$this->pagination->create_links();
        $this->data['app_list'] = $this->jobs_model->get_cand_applications($page, $config['per_page'], $cand_id);
        //echo "<pre>"; print_r($data['jobs']); exit;
        $this->load->view('candidate_applications',$this->data);
    }
    
    public function most_viewed()
    {
        $this->data['url'] = site_url();

//        
        if($this->uri->segment(3))
        {
            $page = $this->uri->segment(3);
        }
        else 
        {
            $page = 0;
        }
//        $data['pagin'] =$this->pagination->create_links();
        $this->data['page'] = $page;
        $this->data['pg_ck'] = TRUE;
        $this->load->model('jobs_model');
        $this->data['jobs'] = $this->jobs_model->get_most_view_jobs();
       //cho "<pre>"; print_r($data['jobs']); exit;
        $this->load->view('jobs_listing',$this->data);
    }
    
    
    public function emp_job_listing()
    {
        $this->data['url'] = site_url();
         $uid = $this->session->userdata['user_data']['usr_id'];
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/emp_job_listing/";
         $tbl_nam = 'tbl_jobs';
         $field = 'company';
         $check = $uid;
        $this->load->model('jobs_model');
        $rows = $this->jobs_model->record_count_emp($tbl_nam, $check, $field);
                
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
        $uid = $this->session->userdata['user_data']['usr_id'];
        $this->data['pagin'] =$this->pagination->create_links();
        $this->data['jobs'] = $this->jobs_model->get_emp_jobs($page, $config['per_page'], $uid);
        $this->data['uid'] = $uid;
        //echo "<pre>"; print_r($this->data['jobs']); exit;
        $this->load->view('emp_jobs_listing',$this->data);
    }
    
    public function emp_applications()
    {
       $this->data['url'] = site_url();
         $uid = $this->session->userdata['user_data']['usr_id'];
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/emp_applications/";
         $tbl_nam = 'tbl_jobs';
         $field = 'company';
         $check = $uid;
        $this->load->model('jobs_model');
        $rows = $this->jobs_model->record_count_emp($tbl_nam, $check, $field);
                
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
        $uid = $this->session->userdata['user_data']['usr_id'];
        $this->data['pagin'] =$this->pagination->create_links();
        $this->data['jobs'] = $this->jobs_model->get_emp_applications($page, $config['per_page'], $uid);
        
        $this->load->view('emp_app_listing',$this->data);
    }
    
     public function emp_application_details()
    {
        $id = $this->uri->segment(4);
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/emp_application_details/";
         $tbl_nam = 'job_applications';
         $field = 'job_id';
         $this->load->model('resume_model');
        $this->load->model('jobs_model');
        $rows = $this->jobs_model->record_count($tbl_nam, $id, $field);
        
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
        $this->data['rat_dv'] = 20;
        $criter = $this->resume_model->get_rat_crit();
        //$this->data['app_list'] = $this->jobs_model->get_appllied_details($page, $config['per_page'], $id, $criter);
        $this->data['app_list'] = $this->jobs_model->get_applied_cands($page, $config['per_page'], $id, $criter);
        $criteria = $this->resume_model->get_rating_criteria();
       
                    $this->data['review_criteria'] = $criteria;
        //echo $this->db->last_query();
        //echo "<pre>"; print_r($this->data['app_list']); exit;
        $this->load->view('emp_applied_list',$this->data);
    }
    
    public function reject_application()
    {
        $id = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $job_id = $this->uri->segment(5);
        
        
        $reject = $this->jobs_model->reject_app($id);
        
        if($reject > 0)
        {
            $this->session->set_flashdata('msg','Application successfully rejected');
            redirect('jobs/emp_application_details/'.$page.'/'.$job_id);
            exit;
        }
        else
        {
            $this->session->set_flashdata('err_msg','Application Rejection Error. Try again... !!');
            redirect('jobs/emp_application_details/'.$page.'/'.$job_id);
            exit;
        }
    }
    
    public function get_appointments()
    {
        $cand_id = $this->session->userdata['user_data']['usr_id'];
        $this->load->model('jobs_model');
        $results = $this->jobs_model->get_aded_appointments($cand_id);
        
        if($results > 0)
        {
            $events = array(); 
            foreach($results as $res)
            {
                $e['id']    = $res['id'];
                $e['text']  = $res['event_name'];
                $e['start'] = str_replace(' ','T',$res['start']);
                $e['end']   = str_replace(' ','T',$res['end']);
                $schedule[] = $e;
            }
        }
        else 
        {
            $schedule = "";
        }
        
        
        header('Content-Type: application/json');
         echo json_encode($schedule);
    }
    
    public function add_appointment()
    {
        $start = $this->db->escape_str($this->input->post('start'));
        $end = $this->db->escape_str($this->input->post('end'));
        $name = $this->db->escape_str($this->input->post('name'));
        $id = $this->db->escape_str($this->input->post('id'));
        
        $ins_dta = $this->jobs_model->add_appointment_details($start, $end, $name, $id);
        
        if($ins_dta > 0)
        {
            $app_ad['result'] = 'OK';
            $app_ad['message'] = 'Created';
        }
        else 
        {
            $app_ad['result'] = 'Not OK';
            $app_ad['message'] = 'Not created. Create Error';
        }
        
        header('Content-Type: application/json');
         echo json_encode($app_ad);
    }
    
    public function update_appointment()
    {
        $start = $this->db->escape_str($this->input->post('newStart'));
        $end = $this->db->escape_str($this->input->post('newEnd'));
        $id = $this->db->escape_str($this->input->post('id'));
        $text = $this->db->escape_str($this->input->post('text'));
        
        $updt_dta = $this->jobs_model->update_appointment_details($start, $end, $id,$text);
        
        if($updt_dta > 0)
        {
            $app_ad['result'] = 'OK';
            $app_ad['message'] = 'Update successful';
        }
        else 
        {
            $app_ad['result'] = 'Not OK';
            $app_ad['message'] = 'Update Un-successful. Update Error';
        }
        
        header('Content-Type: application/json');
         echo json_encode($app_ad);
    }
    
    public function schedule_interview()
    {
        $this->data['app_id'] = $this->uri->segment(3);
        $this->data['page'] = $this->uri->segment(4);
        $this->data['job_id'] = $this->uri->segment(5);
        $this->data['chhck'] = $this->uri->segment(6);
        $this->load->view('schedule_interview', $this->data);
    }
    
    public function mark_favourite()
    {
        $func = $_SERVER['HTTP_REFERER']; 
        $emp_id = $this->session->userdata['user_data']['usr_id'];
        $applicant_id = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $job_id = $this->uri->segment(5);
        $fav_id = $this->uri->segment(6);
        $favoutite = $this->jobs_model->add_favourite_candidate($emp_id, $applicant_id, $fav_id);
        
            redirect($func);
            exit;
        
    }
    
    public function camp_admin()
    {
       $usr =  $this->input->post('login');
       $adm = $this->input->post('login');
        $pass = $this->input->post('password');
        $proc = $this->input->post('process');
        $sess = $this->input->post('sesson');
        $pas = md5($pass);
            
        if($usr != "")
        {
            
//       $adminlanguage = Array
//        (
//            "info" => 'en',
//            "iso" => 'en',
//            "charset" => 'UTF-8',
//            "dir" => 'ltr'
//        );
//       
    
        
//        $this->session->set_userdata['adminlanguage']  = $adminlanguage; 
//        $this->session->set_userdata['dbtables']  = $dbtables;
       
       
            //echo "<pre>"; print_r($sess);
            $response['reply'] = 1;
            echo json_encode($response);
        }
        else
        {
            $response['reply'] = 0;
            echo json_encode($response);
        }
        
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
    
    
    public function my_favourite_jobs()
    {
        $cand_id = $this->session->userdata['user_data']['usr_id'];
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."jobs/my_favourite_jobs/";
         $tbl_nam = 'tbl_favourite_jobs';
         $field = 'candidate_id';
        $this->load->model('jobs_model');
         $rows = $this->jobs_model->record_count($tbl_nam, $cand_id, $field);
//         echo $this->db->last_query().$rows; exit;
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
        
        $this->data['jobs'] = $this->jobs_model->get_my_favourite_jobs($page, $config['per_page'], $cand_id);
        
        $this->load->view('favourite_jobs', $this->data);
    }
    
    
    function load_map()
    {
        $this->load->view('map',  $this->data);
    }
    
    
    function make_fill_job()
    {
        $fill =  $this->uri->segment(3); 
        $id = $this->uri->segment(4); 
        
        if($fill == "on")
        {
            $fili = 1;
        }
        else
        {
            $fili = 0;
        }
        
        $filled = $this->jobs_model->make_filled($fili, $id);
        
        if($filled > 0)
        {
            $resp = "yes";
        }
        else 
        {
            $resp = "no";
        }
        
        echo $resp; exit;
    }

	function getpackagedetail($package_id = ''){
		$data['url'] = site_url();
		$data['package_id']		=	$package_id;
		
		$data['package_detail']	=	$package_detail		=	$this->m_common->view_specific('package_id',$package_id,'tbl_packages');
		$emp_id					=	$this->session->userdata['user_data']['usr_id'];
		$data['company_info']	=	$company_info	=	$this->m_common->getCompanyProfileByEmpID($emp_id);
			
		//var_dump($package_detail); exit;
		if($package_detail->package_currency != ''){
			// packge is not for free and this require to pay some money	
		// innore the error it doesnt matter
			$data['otherpackages']	=	$otherpackages		=	$this->m_common->getotherpackages($package_id);
			$this->load->view('package_detail',$data);
		}
		else{
			// package is for free and thus not require to pay some money
			$activation_date = date('Y-m-d');
			
             
			//$p_price 		= $package_detail->package_price;
			$expiry_date	 =	date('Y-m-d', strtotime($activation_date."+30 days"));
			$dataArray = array(							
					'package_id'     	=>  $package_detail->package_id,
					'company_id'     	=>  $company_info->company_id,
					'emp_id'     		=>  $company_info->emp_id,
					'amount'     		=>  $package_detail->package_price,
					'subscription_date' =>  date('Y-m-d'),
					'transaction_id' 	=>	'Free',
					'status'     		=>  0,
					'payment_status'	=>  1,
					'expiry_date'		=>	$expiry_date,
					'activation_date'	=>	$activation_date,
					
					
			   );
			 //var_dump($dataArray); exit;   
			 $this->m_common->insert_data('tbl_subscribed_packages',$dataArray);
			 $subscribed_packageid		=	$this->m_common->getmaximumsubscribtionid();
			 $_SESSION['message']	=	"success";
				
				
				// email forwarded to admin
				// get admin email template
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
			
			
			$admin_record		=	$this->m_common->view_specific('id',1,'tbl_admin');
			$email_template_for_admin		=	$this->m_common->view_specific('id','14','tbl_email_conf');
			
			//email text initializing
			$fromemail		=	$company_info->email_address;
			$toEmail		=	$admin_record->notifyemail;
			$subject		=	ucwords($email_template_for_admin->subject);
			$message		=	$email_template_for_admin->email_body;
			
			// email forwarded to admin
			
			
			$this->email->from($fromemail);
			$this->email->to($toEmail);
			$this->email->subject($subject);
			$this->email->message($message);
			
			@$this->email->send();
			//echo $this->email->print_debugger(); exit;
			
			
			
			// sending mail to client
		 
			// get admin data
			
			//get email templates
			$email_template_for_client		=	$this->m_common->view_specific('id','11','tbl_email_conf');
			
			//email text initializing
			$fromemail		=	$admin_record->notifyemail;
			$toEmail		=	$company_info->email_address;
			$subject		=	ucwords($email_template_for_client->subject);
			$message		=	$email_template_for_client->email_body;
			
			// email forwarded to the clinet
			
			
			$this->email->from($fromemail);
			$this->email->to($toEmail);
			$this->email->subject($subject);
			$this->email->message($message);
			
			@$this->email->send();
			$name		=	$company_info->first_name." ".$company_info->last_name;	
			$message	=	str_replace("%displayname%",$name , $message);
			$message	=	str_replace("%package%",$package_detail->package_name , $message);
			//$message	=	str_replace("%package_type%",$package_detail->package_type , $message);
			$message	=	str_replace("%package_price%",'FREE' , $message);
			$message	=	str_replace("%activation_date%",$activation_date , $message);
			$message	=	str_replace("%expiry_date%",$expiry_date , $message);
			
			
			
			// send notification to user in the site account
			
			$dataArray = array(							
				'sender_id'     	=>  0,
				'receiver_id'     	=>  $company_info->emp_id,
				'message'     		=>  $message,
				'sp_id'				=>  $subscribed_packageid->maximum,
				'notification_type' =>  'confirmation',
				'issue_date' 		=>	date('Y-m-d'),
				'status'     		=>  0
				
				
		   );   
		 $this->m_common->insert_data('tbl_notification',$dataArray);
		 //var_dump($dataArray); exit;
			
		 header( "Location: ".base_url()."jobs/subscribedpackage" );    
			
			}
}

	
	function success(){
		
		$data['url'] = site_url();
	
		$this->load->view('success',$data);
		
		}
	
	function subscribedpackage(){
		$data['url'] = site_url();
		$emp_id					=	$this->session->userdata['user_data']['usr_id'];
		unset($_SESSION['package_id']);
		unset($_SESSION['requested_page']);
		
		
		$data['package_details']	=	$package_detail		=	$this->m_common->getSubscribedPackages($emp_id);
		
		//var_dump($data['package_detail']); exit;
		$this->load->view('subscribed_packages',$data);
		
		
		
		}
				
	function shownotification(){
		$data['url'] = site_url();
		$emp_id					=	$this->session->userdata['user_data']['usr_id'];
		$data['notifications']	=	$notification		=	$this->m_common->shownotifications($emp_id);
		
		//var_dump($data['notification']); exit;
		$this->load->view('notification',$data);
}
	function showmap($id)
    {

				
        if($id == "")
        {
            redirect('welcome/index');
            exit;
}

        $usr_id = $this->session->userdata['user_data']['usr_id'];
        $this->data['uid'] = $usr_id;
        $this->data['utyp'] = $this->session->userdata['user_data']['u_type'];
        $this->load->model('jobs_model');
        if($this->uri->segment(4) != "")
        {
            $this->data['first_chk'] = $this->uri->segment(4); 
        }
        $this->data['check'] = $this->jobs_model->check_apply($id, $usr_id);
        $view = $this->jobs_model->update_views($id);
        $this->data['job_dt'] = $this->jobs_model->get_job_detail($id);
        //echo "<pre>"; print_r($this->data['job_dt']); exit;
        $this->load->view('show_map',$this->data);
    }			
    
    function get_covering_letter()
    {
        $usr_id = $this->session->userdata['user_data']['usr_id'];
        $res_id = $this->uri->segment(3);
        
        $cover = $this->jobs_model->get_res_cover($usr_id, $res_id);
        
        echo json_encode($cover);
}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
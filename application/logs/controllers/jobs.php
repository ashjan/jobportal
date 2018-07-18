<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

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
                
               if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                   //echo "<pre>"; print_r($_SERVER); exit;
                   if (isset($_SERVER['HTTP_REFERER']))
                    {
                        $this->session->set_userdata('previous_page', $_SERVER['HTTP_REFERER']);
                    }
                    redirect('welcome/login');
                    exit;
                }
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
                if(isset($re_sgmt[6]))
                {
                    $this->data['re_sgmt'] = $re_sgmt[6];
                }
        }
        
	public function index()
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
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['countries'] = $this->jobs_model->get_countries();
                $this->load->view('post_new_job',$this->data);
            }
            else{
                $data['ttl'] = $this->db->escape_str($this->input->post('title'));
                $data['des'] = $this->db->escape_str($this->input->post('description'));
                $data['cntry'] = $this->db->escape_str($this->input->post('Country'));
                $data['state'] = $this->db->escape_str($this->input->post('State'));
                $data['cty'] = $this->db->escape_str($this->input->post('City'));
                $data['sal'] = $this->db->escape_str($this->input->post('salary'));
                $data['cat'] = $this->db->escape_str($this->input->post('category'));
                $data['start'] = $this->db->escape_str($this->input->post('start_date'));
                $data['end'] = $this->db->escape_str($this->input->post('end_date'));
                $data['type'] = $this->db->escape_str($this->input->post('type'));
                $data['u_id']=  $this->session->userdata['user_data']['usr_id'];
                      
                $data['career'] = $this->db->escape_str($this->input->post('career_lvl'));
                $data['experience'] = $this->db->escape_str($this->input->post('experience'));
                $data['vacancies'] = $this->db->escape_str($this->input->post('vacancies'));
                $data['shift'] = $this->db->escape_str($this->input->post('shift'));
                
                $this->load->model('jobs_model');
                $result = $this->jobs_model->add_job($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your job Posted Successfully...!');
                    redirect('jobs/index');
                }
                else{
                    $this->session->set_flashdata('msg','Job posting Error.');
                    redirect('jobs/index');
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
                $data['cat'] = $this->db->escape_str($this->input->post('category'));
                $data['start'] = $this->db->escape_str($this->input->post('start_date'));
                $data['end'] = $this->db->escape_str($this->input->post('end_date'));
                $data['jb_id'] = $this->db->escape_str($this->input->post('job_id'));
                $data['type'] = $this->db->escape_str($this->input->post('type'));
                $data['u_id']=  $this->session->userdata['user_data']['usr_id'];
                
                $this->load->model('jobs_model');
                $result = $this->jobs_model->update_job($data);
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your job Edited Successfully...!');
                    redirect('jobs/emp_job_listing');
                }
                else{
                    $this->session->set_flashdata('msg','Job posting Error.');
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
            $this->session->set_flashdata('msg','The selected job not deleted Error..!!');
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
        $config["base_url"] = $this->data['url']."/jobs/job_listing/";
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
        $dbdata['id'] = $this->uri->segment(3);
        $dbdata['comp'] = $this->uri->segment(4);
        $dbdata['usr_id'] = $this->session->userdata['user_data']['usr_id'];
        //echo "<pre>"; print_r($dbdata); exit;
        $this->load->model('jobs_model');
        $aply = $this->jobs_model->job_apply($dbdata);
        if($aply > 0)
        {
            $this->session->set_flashdata('msg','Yoy have Successfully Applied for this job');
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
        $config["base_url"] = $this->data['url']."/jobs/cand_applications/";
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
//        $config = array();
//        $config["base_url"] = $data['url']."/jobs/most_viewed/";
//         $tbl_nam = 'tbl_jobs';
//        $this->load->model('jobs_model');
//         $rows = $this->jobs_model->record_count($tbl_nam);
//                
//                $config["total_rows"] = $rows;
//                $config["per_page"] = 10;
//                $config["uri_segment"] = 3;
//        $this->load->library('pagination');
//        $this->pagination->initialize($config);
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
        $config["base_url"] = $this->data['url']."/jobs/emp_job_listing/";
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
        $config["base_url"] = $this->data['url']."/jobs/emp_applications/";
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
        $config["base_url"] = $this->data['url']."/jobs/emp_application_details/";
         $tbl_nam = 'job_applications';
         $field = 'application_id';
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
        $this->data['app_list'] = $this->jobs_model->get_appllied_details($page, $config['per_page'], $id);
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
        
        $updt_dta = $this->jobs_model->update_appointment_details($start, $end, $id);
        
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
    
    
    public function my_favourite_jobs()
    {
        $cand_id = $this->session->userdata['user_data']['usr_id'];
        $this->data['url'] = site_url();
        $config = array();
        $config["base_url"] = $this->data['url']."/jobs/my_favourite_jobs/";
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
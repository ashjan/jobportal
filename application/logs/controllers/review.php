<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends CI_Controller {

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
                $this->load->model('review_model');
        }
    
    
	public function index()
	{
            if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
            {
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
		$this->load->view('login',$this->data);
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
                    redirect('jobs/index');
                    exit;
                }
            }
	}
        
        public function add_resume_review()
        {
            $this->form_validation->set_rules('review','Review','required');
            $res_id = $this->uri->segment(3);
            $cand_id = $this->uri->segment(4);
            $app_id = $this->uri->segment(5);
            $job_id = $this->uri->segment(6);
            $emp_id = $this->session->userdata['user_data']['usr_id'];
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('resume/resume_details/'.$res_id.'/'.$cand_id.'/'.$app_id.'/'.$job_id);
                exit;
            }
            else
            {  
                $review = $this->db->escape_str($this->input->post('review'));
                
                $add_review = $this->review_model->add_resume_review($review, $res_id, $cand_id, $emp_id);
                
                if($add_review)
                {
                    redirect('resume/resume_details/'.$res_id.'/'.$cand_id.'/'.$app_id.'/'.$job_id);
                    exit;
                }
                else
                {
                    redirect('resume/resume_details/'.$res_id.'/'.$cand_id.'/'.$app_id.'/'.$job_id);
                    exit;
                }
            }
        }
        
        function star_rating()
        {
            $criteria_id = $this->uri->segment(3);
            $res_id = $this->uri->segment(4);
            $cand_id = $this->uri->segment(5);
            $check = $this->uri->segment(6);
            $emp_id = $this->session->userdata['user_data']['usr_id'];
            $rating = $this->db->escape_str($this->input->post('rating'));
            
            
            $this->review_model->add_star_rating($rating, $criteria_id, $res_id, $cand_id, $emp_id, $check);
            
            echo 'Ok raing inserted.';
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
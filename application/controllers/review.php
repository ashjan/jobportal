<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends CI_Controller {

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
                
               
                $this->data['url'] = site_url();
                $this->load->model('review_model');
                                
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
            $emp_id = $this->session->userdata['user_data']['usr_id'];
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('welcome/candidates_listing');
                    exit;
            }
            else
            {  
                $review = $this->db->escape_str($this->input->post('review'));
                
                $add_review = $this->review_model->add_resume_review($review, $res_id, $cand_id, $emp_id);
                
                if($add_review)
                {
                    redirect('welcome/candidates_listing');
                    exit;
                }
                else
                {
                    redirect('welcome/candidates_listing');
                    exit;
                }
            }
        }
        
        function star_rating()
        {
            $criteria_id = $this->uri->segment(3);
            $res_id = $this->uri->segment(4);
            $cand_id = $this->uri->segment(5);
            $emp_id = $this->session->userdata['user_data']['usr_id'];
            $rating = $this->db->escape_str($this->input->post('rating'));
            
            
            $this->review_model->add_star_rating($rating, $criteria_id, $res_id, $cand_id, $emp_id, $check);
            
            echo 'Ok raing inserted.';
        }
        
        public function add_job_review()
        {
            $this->form_validation->set_rules('review','Review','required');
            $job_id = $this->uri->segment(3);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('jobs/job_listing');
                    exit;
}
            else
            {  
                $review = $this->db->escape_str($this->input->post('review'));

                $add_review = $this->review_model->add_job_review($review, $job_id, $cand_id);
                
                if($add_review)
                {
                    redirect('jobs/job_listing');
                    exit;
                }
                else
                {
                    redirect('jobs/job_listing');
                    exit;
                }
            }
        }
        
        function job_star_rating()
        {
            $criteria_id = $this->uri->segment(3);
            $job_id = $this->uri->segment(4);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $rating = $this->db->escape_str($this->input->post('rating'));
            
            
            $this->review_model->add_job_star_rating($rating, $criteria_id, $job_id, $cand_id);
            
            echo 'Ok raing inserted.';
        }
        
        function job_guest_star_rating()
        {
            $job_id = $this->uri->segment(3);
            $rating = $this->db->escape_str($this->input->post('rating'));
            
            $this->review_model->add_guest_job_star_rating($rating,$job_id);
            
            echo 'Ok raing inserted.';
            
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
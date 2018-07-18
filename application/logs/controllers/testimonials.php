<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials extends CI_Controller {

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
                $this->load->model('profile_model');
                $this->load->model('resume_model');
                $cand_id = $this->session->userdata['user_data']['usr_id'];
                    $this->data['resume'] = $this->resume_model->get_resume($cand_id);
                    $this->data['owner'] = $this->profile_model->check_comp_owner($cand_id);
        }
        
        public function add_testimonial()
        {
            
            $this->form_validation->set_rules('testimonial');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->view('add_testimonial', $this->data);
            }
            else
            { 
                $uid = $this->session->userdata['user_data']['usr_id'];
                $testim = $this->db->escape_str($this->input->post('testimonial'));
                
                $this->load->model('testimonial_model');
                $add_testmonial = $this->testimonial_model->add_testimonial($testim, $uid);
                
                if($add_testmonial > 0)
                {
                    redirect('jobs/job_listing');
                    exit;
                }
                else 
                {
                    redirect('testimonials/add_testimonial');
                    exit;
                }
                
            }
        }
        
}
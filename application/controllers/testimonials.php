<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials extends CI_Controller {

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
                    $this->session->set_flashdata('msg','Your Testimonial added succesfully.');
                    redirect('jobs/job_listing');
                    exit;
                }
                else 
                {
                    $this->session->set_flashdata('err_msg','Testimonial adding error.....!');
                    redirect('testimonials/add_testimonial');
                    exit;
                }
                
            }
        }
        
}
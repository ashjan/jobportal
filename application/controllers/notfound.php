<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notfound extends CI_Controller {

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
		$this->load->view('not_found',$this->data);
		}

}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
                
                                
                //Here i call the model for menus 
                $this->load->model('menu_manager');
                $this->data['url']= base_url();
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
  


	// F U N C T I O N    D I S P L A Y
	public function display(){
		
		//Assigning  Front page contents
                $this->load->model('menu_manager');
		$arr_contents = $this->menu_manager->load_specific_content($this->uri->segment(3));
                $this->data['pagecontents']=$arr_contents;
		$this->load->view('content',$this->data);
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

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
                
        }
	public function index()
	{
            //$this->form_validation->set_rules('fname','First Name','required');
            //$this->form_validation->set_rules('lname','Last Name','required');
            $this->form_validation->set_rules('password','Password','required|min_length[8]|alpha_numeric');
            //$this->form_validation->set_rules('confpass','Confirm Password','required|matches[pass]');
            //$this->form_validation->set_rules('email','Email','required|valid_email');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->view('registration', $this->data);
            }
            else{
               $data['fnam'] = $this->db->escape_str($this->input->post('fname'));
                $data['lnam'] = $this->db->escape_str($this->input->post('lname'));
                $pass = $this->db->escape_str($this->input->post('password'));
                
                $email = $this->db->escape_str($this->input->post('email'));
                $data['email'] = $email;
//                $data['b_email'] = $this->db->escape_str($this->input->post('bus_email'));
                $data['town'] = $this->db->escape_str($this->input->post('town'));
                $data['phone'] = $this->db->escape_str($this->input->post('phone'));
                $data['utyp'] = $this->db->escape_str($this->input->post('utype'));
                if($data['utyp'] == 3)
                {
                    $data['consultant'] = 1;
                }
                else 
                {
                    $data['consultant'] = 0;
                }
                $data['pass'] = md5($pass);
                $profile = $this->uploadpic();
                if($profile == 'no file')
                {
                    $data['pic'] = 'no file';
                }
                else 
                {
                    $data['pic'] = $profile;
                }
                
                $this->load->model('auth_model');
                $result = $this->auth_model->register($data);
                if($result > 0)
                {
                    $this->load->library('email');

                    $this->email->from($email, 'Applicant');
                    $this->email->to('aftabhassan72@gmail.com');

                    $this->email->subject('New User Registred');
                    $this->email->message('A new user registered with the following email '.$email);

                    $this->email->send();
                    echo $this->email->print_debugger();
                    
                    // email send to the registring candidate
                    $this->email->from('aftabhassan72@gmail.com');
                    $this->email->to($email);
                    
                    $this->email->subject('Job Mug Registration');
                    $this->email->message('Your account has been created on the Job Mug with the following email '.$email.'Kindly complate your registration  process.<br/> '.base_url());
                    
                    $this->email->send();
                    
                    $this->session->set_flashdata('msg','you are registered Successfully now Login Please...!');
                    redirect('welcome/login');
                    exit;
                    //echo 'Successfully Logged In...!';
                }
                else{
                    $this->session->set_flashdata('err_msg','registration Error...!');
                    redirect('registration/index');
                    exit;
                }
            }
	}
        
         function uploadpic() {
        if ($_FILES['userfile']['error'] == 4) {
            return "no file";
        } else {
            $config['upload_path'] = './uploads/profile_images';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '10000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('pic error' => $this->upload->display_errors());
                foreach ($error as $key => $value) {
                    echo $key . ": " . $value;
                }
            } else {
                $data = array('upload_data' => $this->upload->data());

                $upload_data = $this->upload->data();
                $pic = $upload_data['file_name'];
                return $pic;
            }
        }
    }
    
    function check_email_availability()
    {
        $email = $this->input->post('email');
        
        $this->load->model('auth_model');
        $get_result = $this->auth_model->check_email_availablity($email);

        if ($get_result == FALSE) {
            echo 'Available';
        } else {
            echo 'Not Available';
        }
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
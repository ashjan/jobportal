<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		$this->data['sess_data'] = $this->session->all_userdata();
		
		if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                    redirect('welcome/login');
                    exit;
                }
                
                                
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
                
                $this->load->model('profile_model');
                $this->load->model('resume_model');
                $cand_id = $this->session->userdata['user_data']['usr_id'];
                $this->data['resume'] = $this->resume_model->get_resume($cand_id);
                $this->data['url'] = site_url();
                $this->data['owner'] = $this->profile_model->check_comp_owner($cand_id);
                $this->data['usr_ck'] = $this->profile_model->get_com_id($cand_id);
               //echo "<pre>"; print_r($this->data['owner']); exit;
        }
    
	public function index()
	{
           // echo "<pre>";            print_r($this->session->all_userdata()); exit;
            $this->form_validation->set_rules('fname','First Name','required');
            $this->form_validation->set_rules('lname','Last Name','required');
            $this->form_validation->set_rules('town','Town','required');
            $this->form_validation->set_rules('phone','Phone#','required');
            $id = $this->session->userdata['user_data']['usr_id'];
                    
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('profile_model');
                $this->data['profile'] = $this->profile_model->get_user_profile($id);
                //echo "<pre>";  print_r($this->data['profile']); exit;
                $this->load->view('update_profile',$this->data);
            }
            else{
                $data['fname'] = $this->db->escape_str($this->input->post('fname'));
                $data['lname'] = $this->db->escape_str($this->input->post('lname'));
                $data['bus_email'] = $this->db->escape_str($this->input->post('bus_email'));
                $data['town'] = $this->db->escape_str($this->input->post('town'));
                $data['phone'] = $this->db->escape_str($this->input->post('phone'));
                
                $profile = $this->uploadpic();
                if($profile == 'no file')
                {
                    $data['pic'] = 'no file';
                }
                else 
                {
                    $data['pic'] = $profile;
                }
                
                
                $this->load->model('profile_model');
                $result = $this->profile_model->update_profile($data,$id);
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your profile Updated Successfully...!');
                    redirect('welcome/index');
                }
                else{
                    $this->session->set_flashdata('err_msg','Job posting Error.');
                    redirect('profile/index');
                }
            }   
	}
        
        
        
        function uploadpic() {
        if ($_FILES['userfile']['error'] == 4) {
            return "no file";
        } else {
            $config['upload_path'] = './uploads/profile_images';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';
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
    
        
        public function change_password()
        {
            $this->form_validation->set_rules('pass','Job Title','required');
            $this->form_validation->set_rules('new_pass','Job Description','required');
            $this->form_validation->set_rules('conf_pass','Country','required|matches[new_pass]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('profile_model');
                $id = $this->session->userdata['user_data']['usr_id'];
                $this->data['profile'] = $this->profile_model->get_user_profile($id);
                $this->load->view('update_profile',  $this->data);
            }
            else{
                $pass = $this->db->escape_str($this->input->post('pass'));
                $new = $this->db->escape_str($this->input->post('new_pass'));
                $data['id'] = $this->session->userdata['user_data']['usr_id'];
                $data['pass'] = md5($pass);
                $data['new'] = md5($new);
                $this->load->model('profile_model');
                $check = $this->profile_model->check_pass($data);
                if($check > 0)
                {
                    $result = $this->profile_model->change_pass($data);
                    if($result > 0)
                    {
                        $this->session->set_flashdata('msg','your password Successfully...!');
                        redirect('jobs/change_password');
                    }
                    else{
                        $this->session->set_flashdata('err_msg','password change Error.');
                        redirect('profile/change_password');
                    }
                }
                else
                {
                    $this->session->set_flashdata('err_msg','Old Password did not match.');
                    redirect('profile/change_password');
                }
            }   
        }
        
        function dyn_pic_upload()
        {
            //$ip_fil  = $this->uri->segment(3);
            
            if(!empty($_FILES))
            {
                $file = $_FILES[0];
                $targetFolder = "/jobportal/uploads/profile_images";
                
                $timestamp = time();
		$tempFile = $file['tmp_name'];
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
		$t = $timestamp.str_replace(' ','_',$file['name']);
		$targetFile = rtrim($targetPath,'/') . '/' . $t;
                
                if(move_uploaded_file($tempFile, $targetFile))
                {
                    $user_id = $this->session->userdata['user_data']['usr_id'];
                    
                    $this->profile_model->update_pr_pic($t, $user_id);
                    
                    $urdta['user_data'] = array(
                        'usr_id' => $user_id,
                        'is_user_logged_in' => TRUE,
                        'f_name' => $this->session->userdata['user_data']['f_name'],
                        'l_name' => $this->session->userdata['user_data']['l_name'],
                        'u_type' => $this->session->userdata['user_data']['u_type'],
                        'email' => $this->session->userdata['user_data']['email'],
                        'dp' => $t,
                        'is_fb_usr' => TRUE
                    );
					
					$this->load->library('image_lib');
					
					$targetPath_medium		=	$targetPath."/medium";	
					// for medium size thumbs
					$config = array(
						'source_image'      => $targetFile,
						'new_image'         => $targetPath_medium,
						'maintain_ratio'    => false,
						'width'             => 300,
						'height'            => 300
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					
					$targetPath_thumb		=	$targetPath."/thumb";	
					// for thumbs
					
					$thumb = array(
						'source_image'      => $targetFile,
						'new_image'         => $targetPath_thumb,
						'maintain_ratio'    => false,
						'width'             => 150,
						'height'            => 150
					);
					
					$this->image_lib->initialize($thumb);
					$this->image_lib->resize();
                    $this->session->set_userdata($urdta);
                    
					$dt = "YES";
                    echo json_encode($dt);
                }
                else
                {
                    $dt = 'NO';
                    echo json_encode($dt);
                }
            }
       
		}
        
        public function comp_profile_editor()
        {
            $this->form_validation->set_rules('comp_name','Company Name','required');
            $this->form_validation->set_rules('tag_line','Tag Line','required');
            $this->form_validation->set_rules('found_year','Found Year','required');
            $this->form_validation->set_rules('team_size','Team Size','required');
            $this->form_validation->set_rules('category','Category','required');
            $this->form_validation->set_rules('location','Location','required');
            $this->form_validation->set_rules('Country','Coountry','required');
            $this->form_validation->set_rules('State','State','required');
            $this->form_validation->set_rules('City','City','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $usr_id = $this->session->userdata['user_data']['usr_id'];
                $this->load->model('jobs_model');
                $this->data['profile'] = $this->profile_model->get_comp_data($usr_id);
                $this->data['companies'] = $this->profile_model->get_companies();
                //echo "<pre>"; print_r($this->data['profile']); exit;
                $this->data['categories'] = $this->jobs_model->get_categories();
                $this->data['countries'] = $this->jobs_model->get_countries();
                $this->load->view('company_profile_editor',$this->data);
            }
            else
            {   
                $id = $this->db->escape_str($this->input->post('id'));
                $dbdata['emp_id'] = $this->session->userdata['user_data']['usr_id'];
                $dbdata['c_nam'] = $this->db->escape_str($this->input->post('comp_name'));
                $dbdata['tag'] = $this->db->escape_str($this->input->post('tag_line'));
                $dbdata['f_year'] = $this->db->escape_str($this->input->post('found_year'));
                $dbdata['tm_sz'] = $this->db->escape_str($this->input->post('team_size'));
                $dbdata['cat'] = $this->db->escape_str($this->input->post('category'));
                $dbdata['loc'] = $this->db->escape_str($this->input->post('location'));
                $dbdata['cnt'] = $this->db->escape_str($this->input->post('Country'));
                $dbdata['stt'] = $this->db->escape_str($this->input->post('State'));
                $dbdata['cty'] = $this->db->escape_str($this->input->post('City'));
                
                $dbdata['lat'] = $this->db->escape_str($this->input->post('latitude'));
                $dbdata['long'] = $this->db->escape_str($this->input->post('longitude'));
                $dbdata['adress'] = $this->db->escape_str($this->input->post('adress'));
                
                if($id == "")
                {
                    $comp_profile = $this->profile_model->add_comp_data($dbdata);
                }
                else 
                {
                    $comp_profile = $this->profile_model->update_comp_data($dbdata, $id);
                }
                
                if($comp_profile > 0)
                {
                    $this->session->set_flashdata('msg','Company profile updated successfully');
                    redirect('profile/comp_profile_editor');
                    exit;
                }
                else 
                {
                    $this->session->set_flashdata('err_msg','Company profile update Error');
                    redirect('profile/comp_profile_editor');
                    exit;
                }
            }
        }
        
        public function select_company()
        {
            $this->form_validation->set_rules('company','Company','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->view('company_profile_editor');
            }
            else
            {
                $usr_id = $this->session->userdata['user_data']['usr_id'];
                $company = $this->db->escape_str($this->input->post('company'));
                
                $add_comp = $this->profile_model->add_selected_company($company, $usr_id);
                
                $this->session->set_flashdata('msg','Your request is sent to the company`s admin. you will be granted permission after the approval.');
                redirect('jobs/emp_job_listing');
                exit;
            }
        }
        
        public function manage_team()
        {
            
            $usr_id = $this->session->userdata['user_data']['usr_id'];
           
           $config["base_url"] = $this->data['url']."profile/manage_team/";
           
           $rows = $this->profile_model->count_team($usr_id);
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
            $this->data['team'] = $this->profile_model->get_comp_sub_admins($usr_id, $page, $config['per_page']);
            
            //echo "<pre>"; print_r($add_comp); exit;
            
            $this->load->view('team_listing', $this->data);
        }
        
        public function set_privilage()
        {
            $status = $this->uri->segment(3);
            $id = $this->uri->segment(4);
            $page = $this->uri->segment(5);
            
            $change_privilage = $this->profile_model->change_privilege($status, $id);
            
            redirect('profile/manage_team/'.$page);
            exit;
        }
        
        function dyn_logo_upload()
        {
            //$ip_fil  = $this->uri->segment(3);
            $comp_id = $this->uri->segment(3);
            if(!empty($_FILES))
            {
                $file = $_FILES[0];
                $targetFolder = "/jobportal/uploads/profile_images";
                
                $timestamp = time();
		$tempFile = $file['tmp_name'];
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
		$t = $timestamp.str_replace(' ','_',$file['name']);
		$targetFile = rtrim($targetPath,'/') . '/' . $t;
                
                if(move_uploaded_file($tempFile, $targetFile))
                {
                    $user_id = $this->session->userdata['user_data']['usr_id'];
                    
                    $this->profile_model->update_comp_logo($t, $comp_id);
					$this->load->library('image_lib');
					
					$targetPath_medium		=	$targetPath."/medium";	
					// for medium size thumbs
					$config = array(
						'source_image'      => $targetFile,
						'new_image'         => $targetPath_medium,
						'maintain_ratio'    => false,
						'width'             => 300,
						'height'            => 300
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					
					$targetPath_thumb		=	$targetPath."/thumb";	
					// for thumbs
					
					$thumb = array(
						'source_image'      => $targetFile,
						'new_image'         => $targetPath_thumb,
						'maintain_ratio'    => false,
						'width'             => 150,
						'height'            => 150
					);
					
					$this->image_lib->initialize($thumb);
					$this->image_lib->resize();
					
                    
                    
                    $dt = "YES";
                    echo json_encode($dt);
                }
                else
                {
                    $dt = 'NO';
                    echo json_encode($dt);
                }
            }
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
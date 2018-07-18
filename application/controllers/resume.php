<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resume extends CI_Controller {

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
                
                if(!isset($this->session->userdata['user_data']['is_user_logged_in']))
                {
                    redirect('welcome/login');
                    exit;
                }
                                
                $data['url'] = base_url();
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
                $this->load->model('profile_model');
                $this->load->model('resume_model');
                $cand_id = $this->session->userdata['user_data']['usr_id'];
                $this->data['resume'] = $this->resume_model->get_resume($cand_id);
                $this->data['owner'] = $this->profile_model->check_comp_owner($cand_id);
                $this->load->model('jobs_model');
            $this->data['categories'] = $this->jobs_model->get_categories();
                
        }
	public function index()
	{
            
            $this->form_validation->set_rules('fname','First Name','required');
            //$this->form_validation->set_rules('lname','Last Name','required');
            
            //$this->form_validation->set_rules('adres','Adress','required');
            //$this->form_validation->set_rules('adres2','Adress 2','required');
            //$this->form_validation->set_rules('dob','Date of Birth','required');
            //$this->form_validation->set_rules('available','Available Date','required');
            $this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('cnic','CNIC','callback_valid_phone_number_or_empty');
            $this->form_validation->set_rules('phone','Phone','callback_valid_phone_number_or_empty');
            $this->form_validation->set_rules('salary','Salary','callback_numeric_wcomma');
            $this->form_validation->set_rules('exp_sal','Expected','callback_numeric_wcomma');
            $this->form_validation->set_rules('dob','Date of Birth','callback_chec_dob');
            $this->form_validation->set_rules('available','Available From Date','callback_chec_available');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
                //echo "<pre>";                print_r($this->data['categories']); exit;
                $this->load->view('manage_resume',  $this->data);
            }
            else{
                $dbdata['fnam'] = $this->db->escape_str($this->input->post('fname'));
                $dbdata['lnam'] = $this->db->escape_str($this->input->post('lname'));
                $dbdata['fathernam'] = $this->db->escape_str($this->input->post('father_name'));
                $dbdata['gender'] = $this->db->escape_str($this->input->post('gender'));
                $dbdata['mar_st'] = $this->db->escape_str($this->input->post('m_status'));
                $dbdata['cnic'] = $this->db->escape_str($this->input->post('cnic'));
                $dbdata['email'] = $this->db->escape_str($this->input->post('email'));
                $dbdata['phone'] = $this->db->escape_str($this->input->post('phone'));
                $dbdata['adrs'] = $this->db->escape_str($this->input->post('adres'));
                //$dbdata['adrs2'] = $this->db->escape_str($this->input->post('adres2'));
                $dbdata['dob'] = $this->db->escape_str($this->input->post('dob'));
                $dbdata['avail'] = $this->db->escape_str($this->input->post('available'));
                $obj = $this->db->escape_str($this->input->post('objectives'));
                $obj0 = str_replace('\r', ' ', $obj);
                $obj01 = str_replace('\n', ' ', $obj0);
                $obj1 = preg_replace('/<!--\[if[^\]]*]>.*?<!\[endif\]-->/i', '', $obj01);
                $obj2 = preg_replace('/mso-.+?:\s*?.+?;/s', '', $obj1);

                $dbdata['obj'] = addslashes($obj2);
                $dbdata['sal'] = $this->db->escape_str($this->input->post('salary'));
                $dbdata['ex_sal'] = $this->db->escape_str($this->input->post('exp_sal'));
                $dbdata['pr_ct'] = $this->db->escape_str($this->input->post('pro_cat'));
                $dbdata['cand_id'] = $this->session->userdata['user_data']['usr_id'];
                
                $this->load->model('resume_model');
                $result = $this->resume_model->add_step_one($dbdata);
                if($result > 0)
                {
                    $ins_id = $this->db->insert_id();
                    $this->session->set_flashdata('msg','your resume first step details Posted Successfully...!');
                    redirect('resume/step_two/'.$ins_id);
                    exit;
                }
                else{
                    $this->session->set_flashdata('err_msg','Resume adding error.');
                    redirect('resume/index');
                    exit;
                }
            }
            
	}
        
        public function trainingss()
        {
            $this->load->view('trainings',  $this->data);
        }
        
        public function step_two()
        {
            $this->data['id'] = $this->uri->segment(3);
            $this->load->view('manage_resume2', $this->data);
        }
        
        public function step_two_process()
	{
           // echo "<pre>";            print_r($_FILES); exit;
            $id = $this->input->post('id');
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            
            $targetFolder = '/jobportal/uploads/resume_images';  // Relative to the root

				if (!empty($_FILES) && is_array($_FILES['photos']['name'])) 
				{
					for($i=0;$i<count($_FILES['photos']['name']);$i++)
					{
					$timestamp = time();
					$tempFile = $_FILES['photos']['tmp_name'][$i];
					$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
					$t = $timestamp.str_replace(' ','_',$_FILES['photos']['name'][$i]);
					$targetFile = rtrim($targetPath,'/') . '/' . $t;
						// Validate the file type
					$fileTypes = array('jpg','jpeg','gif','png','tif','tiff','bmp'); // File extensions
					$fileParts = pathinfo($_FILES['photos']['name'][$i]);
					//echo "<pre>";
					//print_r($t);
						//echo "<pre>";
//						print_r($t);
//						exit;
                                            $size = $_FILES['photos']['size'][$i];
	
						if (in_array($fileParts['extension'],$fileTypes)) 
						{
							
							$this->db->query("
											INSERT 
											INTO
											tbl_candidate_images
											SET
											`image_name`='".$t."',
                                                                                        `image_type`='".$fileParts['extension']."',
                                                                                        `image_size`='".$size."',
                                                                                        `resume_id`='".$id."',
                                                                                        `candidate_id`='".$cand_id."'
							");
		
                                                     $images = 'added';
		//echo "<div class='img'><img src='".base_url()."upload/".$img."'/></div>";
						} 
						else 
						{
							
							echo 'Invalid file type.';
						}
	
		}
                
                $video = $this->uploadvideo();
                
                if($video != 'no file')
                {
                    $this->db->query("UPDATE
                                      tbl_resume
                                      SET
                                      video='".$video."'
                                      WHERE
                                      id='".$id."'");
                }
            }

            if($images == 'added')
            {
                $this->session->set_flashdata('msg','your resume Second step details Posted Successfully...!');
                redirect('resume/step_three/'.$id);
                exit;
            }
            else 
            {
                $this->session->set_flashdata('err_msg','Image uploading error...!');
                redirect('resume/step_two/'.$id);
                exit;
            }
            
	}
    
        public function step_three()
        {
            $id = $this->uri->segment(3);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $this->form_validation->set_rules('deg_ttl','Degree Title','required');
            $this->form_validation->set_rules('ins_name','Institute Name','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->data['id'] = $id;
                $this->load->view('manage_resume3',$this->data);
            }
            else 
            {
                $id = $this->input->post('id');
                $ttl = $this->input->post('deg_ttl');
                $institute = $this->input->post('ins_name');
                $strt_dat = $this->input->post('strt_date');
                $end_dat = $this->input->post('end_date');
                $sub = $this->input->post('maj_sub');
                
                $grade = $this->input->post('grade');
                
                $this->load->model('resume_model');
                $i=0;
                foreach($ttl as $tt)
                {
                    $subs = addslashes($sub[$i]);
                    $result = $this->resume_model->add_education($tt, $institute[$i], $strt_dat[$i], $end_dat[$i], $subs, $grade[$i], $id, $cand_id);
                    $i++;
                }
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your education details Posted Successfully...!');
                    redirect('resume/step_four/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your resume Posting error...!');
                    redirect('resume/step_three/'.$id);
                    exit;
                }
            }
        }
        
        public function step_four()
        {
            $id = $this->uri->segment(3);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $this->form_validation->set_rules('desig','Degree Title','required');
            $this->form_validation->set_rules('cmpny','Institute Name','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->data['id'] = $id;
                $this->load->view('manage_resume4',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                // Key achievements
                $des= $this->input->post('desc');
                $loct = $this->input->post('location');
                $ach_dat = $this->input->post('ach_date');
                //key achievements
                $ttl = $this->input->post('desig');
                $institute = $this->input->post('cmpny');
                $strt_dat = $this->input->post('strt_date');
                $end_dat = $this->input->post('end_date');
                $sub = $this->input->post('responsiblty');
                $subs = addslashes($sub);
                $this->load->model('resume_model');
                $j=0;
                if(!empty($des))
                {
                    foreach($des as $dd)
                    {
                        if($dd != ""){
                        $key_achs = $this->resume_model->add_key_achvs($dd,$loct[$j], $ach_dat[$j], $id, $cand_id);
                        }
                        $j++;
                    }
                }
                
                $i=0;
                if(!empty($ttl))
                {
                    foreach($ttl as $tt)
                    {
                        if($tt != "")
                        {
                            $result = $this->resume_model->add_work_history($tt, $institute[$i], $strt_dat[$i], $end_dat[$i], $subs[$i], $id, $cand_id);
                        }
                        $i++;
                    }
                }
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your Work details Posted Successfully...!');
                    redirect('resume/step_five/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your Work Posting error...!');
                    redirect('resume/step_four/'.$id);
                    exit;
                }
            }
        }
        
        public function step_five()
        {
            $id = $this->uri->segment(3);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $this->form_validation->set_rules('bus_title','Business Title','required');
            $this->form_validation->set_rules('buss_skill','Business Skills','required');
            //$this->form_validation->set_rules('lang_skill','Lang Skills','required');
            //$this->form_validation->set_rules('comp_skill','Computer Skills','required');
            //$this->form_validation->set_rules('refrence','Refrences','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->data['id'] = $id;
                $this->load->view('manage_resume5',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                //Trainings/ Courses
                $crs_nam = $this->input->post('course_nam');
                $conduct_by = $this->input->post('con_by');
                $loc = $this->input->post('location');
                $on_dat = $this->input->post('con_date');
                //Trainings/ Courses
                $tt = $this->input->post('bus_title');
                $ttl = addslashes($tt);
                $b_ski = $this->input->post('buss_skill');
                $bus_ski = str_replace('\n', ' ', $b_ski);
                $b_skil = addslashes($bus_ski);
                $l_ski = $this->input->post('lang_skill');
                $l_skil = addslashes($l_ski);
                $c_ski = $this->input->post('comp_skill');
                $c_skil = addslashes($c_ski);
                $re = $this->input->post('refrence');
                $ref = addslashes($re);
                
                $this->load->model('resume_model');
                
                if(!empty($crs_nam))
                {
                    $i = 0;
                    foreach($crs_nam as $cr)
                    {
                        if($cr != "")
                        {
                            $training_dtls = $this->resume_model->add_training_info($cr, $conduct_by[$i], $loc[$i], $on_dat[$i], $id, $cand_id);
                        }
                        $i++;
                    }
                }
                
                
               $result = $this->resume_model->add_skill_info($ttl, $b_skil, $l_skil, $c_skil, $ref, $id, $cand_id);
                 
                
                if($training_dtls > 0 || $result > 0)
                {
                    $this->session->set_flashdata('msg','your resume Details Posted Successfully...!');
                    redirect('resume/resume_details/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your skills Posting error...!');
                    redirect('resume/step_five/'.$id);
                    exit;
                }
            }
        }
        
        function resume_upload()
        {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $resume = $this->uploadresume();
            
            if($resume != "no file")
            {
                $this->load->model('resume_model');
                $add_resume = $this->resume_model->add_resume($resume, $cand_id);
            }
            else 
            {
                $add_resume = 0;
            }
            //echo $this->db->last_query(); exit;
            if($add_resume > 0)
            {
                $this->session->set_flashdata('msg','your resume Uploaded Successfully...!');
                    redirect('resume/index');
                    exit;
            }
            else{
                $this->session->set_flashdata('err_msg','your resume Uploading Error...!');
                    redirect('resume/resume_upload');
                    exit;
            }
        }
                
    function uploadvideo() {
        var_dump($_FILES['userfile1']);

        if ($_FILES['userfile1']['error'] == 4) {
            return "no file";
        } else {

            $config_file['upload_path'] = './uploads/resume_videos';
            $config_file['allowed_types'] = "mp4|mpg|mpeg|mkv|flv|avi";
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
    
    
    function uploadresume() {
        var_dump($_FILES['userfile1']);

        if ($_FILES['userfile1']['error'] == 4) {
            return "no file";
        } else {

            $config_file['upload_path'] = './uploads/resumes';
            $config_file['allowed_types'] = "pdf|doc|docx";
            $config_file['encrypt_name'] = true;
            $config_file['overwrite'] = TRUE;
            $config_file['max_size'] = '7000KB';

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
        
    
    
    public function resume_details()
    {
        $id = $this->uri->segment(3);
       $this->load->model('resume_model');
       $this->resume_model->resume_viewed($id);
       if($this->uri->segment(4) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(4);
       }
       
       if($this->uri->segment(5) != "")
       {
           $this->data['app_id'] = $this->uri->segment(5);
       }
       
       if($this->uri->segment(6) != "")
       {
           $this->data['job_id'] = $this->uri->segment(6);
       }
       $this->data['usr_typ'] = $this->session->userdata['user_data']['u_type'];
       
       if($this->data['usr_typ'] != 3)
       {
            $emp_id = $this->session->userdata['user_data']['usr_id'];
       }
        else 
        {
            $emp_id = "";
       }
       
       $this->load->model('resume_model');
       $details = $this->resume_model->get_resume_details($id, $cand_id);
       $this->data['reseme_details'] = $details;
       
       $resume_cover_letter = $this->resume_model->resume_cover_letter($cand_id);
       $this->data['resume_cover_letter'] = $resume_cover_letter;
       

       $criteria = $this->resume_model->get_rating_criteria($emp_id, $details[0]['candidate_id']);
       
       $this->data['review_criteria'] = $criteria;
        //echo "<pre>"; print_r($criteria); exit;
       $this->load->view('resume_preview',$this->data);
       //echo "<pre>"; print_r($reseme_details); exit;
    }
    
    public function edit_resume()
    {
        $this->form_validation->set_rules('fname','First Name','required');
        //$this->form_validation->set_rules('lname','Last Name','required');
        $this->form_validation->set_rules('email','Email','required');
        //$this->form_validation->set_rules('phone','Phone','required');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('cnic','CNIC','callback_valid_phone_number_or_empty');
        $this->form_validation->set_rules('phone','Phone','callback_valid_phone_number_or_empty');
        $this->form_validation->set_rules('salary','Salary','callback_numeric_wcomma');
        $this->form_validation->set_rules('exp_sal','Expected','callback_numeric_wcomma');
        $this->form_validation->set_rules('dob','Date of Birth','callback_chec_dob');
        $this->form_validation->set_rules('available','Available From Date','callback_chec_available');    
        
        $id = $this->uri->segment(3);
        $this->data['id'] = $id;
        $this->data['res_id'] = $id;
       if($this->uri->segment(4) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(4);
       }
       
       if($this->form_validation->run()== FALSE)
       {
           $this->load->model('jobs_model');
                $this->data['categories'] = $this->jobs_model->get_categories();
            $this->load->model('resume_model');
            $this->data['resume_details'] = $this->resume_model->get_resume_details($id, $cand_id);
            $this->load->view('resume_edit',  $this->data);
       }
       else
       {
           $dbdata['fnam'] = $this->db->escape_str($this->input->post('fname'));
           $dbdata['lnam'] = $this->db->escape_str($this->input->post('lname'));
           $dbdata['fathernam'] = $this->db->escape_str($this->input->post('father_name'));
           $dbdata['gender'] = $this->db->escape_str($this->input->post('gender'));
           $dbdata['mar_st'] = $this->db->escape_str($this->input->post('m_status'));
           $dbdata['cnic'] = $this->db->escape_str($this->input->post('cnic'));
           $dbdata['email'] = $this->db->escape_str($this->input->post('email'));
           $dbdata['phone'] = $this->db->escape_str($this->input->post('phone'));
           $dbdata['adrs'] = $this->db->escape_str($this->input->post('adres'));
           //$dbdata['adrs2'] = $this->db->escape_str($this->input->post('adres2'));
           $dbdata['dob'] = $this->db->escape_str($this->input->post('dob'));
           $dbdata['avail'] = $this->db->escape_str($this->input->post('available'));
           $obj = $this->db->escape_str($this->input->post('objectives'));
           $obj0 = str_replace('\r', ' ', $obj);
                $obj01 = str_replace('\n', ' ', $obj0);
                $obj1 = preg_replace('/<!--\[if[^\]]*]>.*?<!\[endif\]-->/i', '', $obj01);
                $obj2 = preg_replace('/mso-.+?:\s*?.+?;/s', '', $obj1);
           
           $dbdata['obj'] = addslashes($obj2);
           $dbdata['sal'] = $this->db->escape_str($this->input->post('salary'));
           $dbdata['ex_sal'] = $this->db->escape_str($this->input->post('exp_sal'));
           $dbdata['pr_ct'] = $this->db->escape_str($this->input->post('pro_cat'));
           $dbdata['id'] = $this->db->escape_str($this->input->post('id'));
           $dbdata['cand'] = $cand_id;
           
            $ttl = $this->input->post('bus_title');
            $dbdata['ttl'] = addslashes($ttl);
                $b_skil = $this->input->post('buss_skill');
                $dbdata['b_skil'] = addslashes($b_skil);
                $l_skil = $this->input->post('lang_skill');
                $dbdata['l_skil'] = addslashes($l_skil);
                $c_skil = $this->input->post('comp_skill');
                $dbdata['c_skil'] = addslashes($c_skil);
                $ref = $this->input->post('refrence');
                $dbdata['ref'] = addslashes($ref);
           
           $this->load->model('resume_model');
           $result = $this->resume_model->edit_resume_one($dbdata);
           //echo $this->db->last_query();
           if($result > 0)
                {
                    $this->session->set_flashdata('msg','Your personal Information details updated Successfully...!');
                    //echo 'successfully edited';
                    redirect('resume/edit_resume/'.$id.'/'.$cand_id);
                    exit;
                }
                else{
                    $this->session->set_flashdata('err_msg','Resume updating error.');
                    redirect('resume/edit_resume/'.$id.'/'.$cand_id);
                    exit;
                }
       }
    }
    
    
    function chec_dob($str)
    {
        $dob = strtotime($str);
        $now = strtotime(date('Y-m-d H:i:s'));
        
        if($dob > $now)
        {
             $this->form_validation->set_message('chec_dob', 'The %s Must be less than the current date');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function chec_available($str)
    {
        $avail = strtotime($str);
        $now = strtotime(date('Y-m-d H:i:s'));
        
        if($avail < $now)
        {
             $this->form_validation->set_message('chec_available', 'The %s Must be greater than the current date');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    
    function numeric_wcomma($str)
    {
        if($str != '')
        {
            if(preg_match('/^[0-9,]+$/', $str))
            {
                return TRUE;
            }
            else
            {
                $this->form_validation->set_message('numeric_wcomma', 'The %s field can only contain the numbers');
                return FALSE;
            }
        }
        else
        {
            return TRUE;
        }
    }
    
    function valid_phone_number_or_empty($value)
    {
            $value = trim($value);
            if ($value != '') {
             
                    if (preg_match('/^[+0-9().-]+$/', $value))
                    {
                            //return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
                        
                        return TRUE;
                    }
                    else
                    {
                        $this->form_validation->set_message('valid_phone_number_or_empty', 'The %s field can only contain the numbers');
                        return FALSE;
                    }
            }
            else
            {
                return TRUE;
            }
    }
    
    
    public function edit_resume3()
    {
        //echo "<pre>";    print_r($this->input->post()); exit;
        $id = $this->uri->segment(3);
        $this->data['id'] = $id;
        $this->data['res_id'] = $id;
       if($this->uri->segment(4) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(4);
       }
       
            $this->form_validation->set_rules('deg_ttl','Degree Title','required');
            $this->form_validation->set_rules('ins_name','Institute Name','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($id, $cand_id);
                $this->load->view('resume_edit',  $this->data);
            }
            else 
            {
                $id = $this->input->post('id');
                $ttl = $this->input->post('deg_ttl');
                $institute = $this->input->post('ins_name');
                $strt_dat = $this->input->post('strt_date');
                $end_dat = $this->input->post('end_date');
                $sub = $this->input->post('maj_sub');
                
                $grade = $this->input->post('grade');
                
                $this->load->model('resume_model');
                $i=0;
                foreach($ttl as $tt)
                {
                    $subs = addslashes($sub[$i]);
                    $result = $this->resume_model->add_education($tt, $institute[$i], $strt_dat[$i], $end_dat[$i], $subs, $grade[$i], $id, $cand_id);
                    $i++;
                }
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your education details Posted Successfully...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('msg','your Education details Posting error Posting error...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
            } 
    }
    
    public function edit_edu()
    {
        //echo '<pre>';        print_r($this->input->post()); exit;
        $resume_id = $this->uri->segment(3);
        $this->data['res_id'] = $resume_id;
        $id = $this->uri->segment(4);
        $this->data['id'] = $id;
       if($this->uri->segment(5) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(5);
       }
       
            $this->form_validation->set_rules('deg_ttl','Degree Title','required');
            $this->form_validation->set_rules('ins_name','Institute Name','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($resume_id, $cand_id);
                
                $this->data['education'] = $this->resume_model->education_detail($id);
                $this->load->view('edit_education',  $this->data);
            }
            else 
            {
                $res_id = $this->input->post('res_id');
                $id = $this->input->post('id');
                $ttl = $this->input->post('deg_ttl');
                $institute = $this->input->post('ins_name');
                $strt_dat = $this->input->post('strt_date');
                $end_dat = $this->input->post('end_date');
                $sub = $this->input->post('maj_sub');
                
                $grade = $this->input->post('grade');
                
                //echo '<pre>'; print_r($_POST); 
                
                $this->load->model('resume_model');
                $i=0;
                foreach($ttl as $tt)
                {
                    $subs = addslashes($sub[$i]);
                    $result = $this->resume_model->update_education($tt, $institute[$i], $strt_dat[$i], $end_dat[$i], $subs, $grade[$i], $id[$i]);
                    $i++;
                }
                    //echo $this->db->last_query(); exit;
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your education details Edited Successfully...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('msg','your resume Posting error...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit; 
                }
            } 
    }
    
            public function delete_edu()
            {
                $resume_id = $this->uri->segment(3);
                $id = $this->uri->segment(4);
                $tbl_nam = "tbl_candidate_education";
                
                $this->load->model('resume_model');
                $result = $this->resume_model->delete($id,$tbl_nam);
                echo $this->db->last_query();
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','The education Detail deleted Successfully...!');
                    redirect('resume/edit_resume/'.$resume_id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','education Detail deletion error...!');
                    redirect('resume/edit_resume/'.$resume_id);
                    exit;
                }
            }
            
    public function edit_resume4()
    {
        //echo "<pre>";    print_r($this->input->post()); exit;
        $resume_id = $this->uri->segment(3);
        $this->data['res_id'] = $resume_id;
        $id = $this->uri->segment(4);
        $this->data['id'] = $id;
       if($this->uri->segment(5) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(5);
       }
       
       //$des= $this->input->post('desc'); $des == ""
       $ttl = $this->input->post('desig');
       
            if($ttl == "")
            {
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($resume_id, $cand_id);
                $this->load->view('resume_edit',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                $res_id = $this->input->post('res_id');
                $ttl = $this->input->post('desig');
                $institute = $this->input->post('cmpny');
                $strt_dat = $this->input->post('strt_date');
                $end_dat = $this->input->post('end_date');
                $sub = $this->input->post('responsiblty');
                
                
                $this->load->model('resume_model');
                
                    
                $i=0;
                foreach($ttl as $tt)
                {
                    $subs = addslashes($sub[$i]);
                    $result = $this->resume_model->add_work_history($tt, $institute[$i], $strt_dat[$i], $end_dat[$i], $subs, $id, $cand_id);
                    $i++;
                }
                 
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your Work details Posted Successfully...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('msg','your Work Posting error...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
            }
    }
    
    public function edit_resume6()
    {
        $resume_id = $this->uri->segment(3);
        $this->data['res_id'] = $resume_id;
        $id = $this->uri->segment(4);
        $this->data['id'] = $id;
       if($this->uri->segment(5) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(5);
       }
       
       $des= $this->input->post('desc');
       
            if($des == "")
            {
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($resume_id, $cand_id);
                $this->load->view('resume_edit',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                //$res_id = $this->input->post('res_id');
                // Key achievements
                $des= $this->input->post('desc');
                $loct = $this->input->post('location');
                $ach_dat = $this->input->post('ach_date');
                
                
                $this->load->model('resume_model');
                $i=0;
                foreach($des as $de)
                {
                    $key_achs = $this->resume_model->add_key_achvs($de,$loct[$i], $ach_dat[$i], $id, $cand_id);
                    $i++;
                }
                 
                 
                
                if($key_achs > 0)
                {
                    $this->session->set_flashdata('msg','your Work achievements Posted Successfully...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your achievements Posting error...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
            }
    }
    
    public function edit_work()
    {
        //echo '<pre>';        print_r($this->input->post()); exit;
        $resume_id = $this->uri->segment(3);
        $this->data['res_id'] = $resume_id;
        $id = $this->uri->segment(4);
        $this->data['id'] = $id;
       if($this->uri->segment(5) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(5);
       }
       
       $des= $this->input->post('desc');
       $this->form_validation->set_rules('desig','Designation','required');
       
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($resume_id, $cand_id);
                $this->data['work'] = $this->resume_model->get_work($id);
                
                $this->load->view('edit_work',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                $res_id = $this->input->post('res_id');
                
                $ttl = $this->input->post('desig');
                $institute = $this->input->post('cmpny');
                $strt_dat = $this->input->post('strt_date');
                $end_dat = $this->input->post('end_date');
                $sub = $this->input->post('responsiblty');
                
                $this->load->model('resume_model');
                
                    
                
                if($ttl != "")
                {
                    $i=0;
                    foreach($ttl as $tt)
                    {
                        $subs = addslashes($sub[$i]);
                        $result = $this->resume_model->update_work_history($tt, $institute[$i], $strt_dat[$i], $end_dat[$i], $subs, $id[$i]);
                        $i++;
                    }
                }
                else 
                {
                    $result = FALSE;
                }
                 
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','your Work details edited Successfully...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your Work editing error...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
            }
       
    }
            
            public function delete_work()
            {
                $resume_id = $this->uri->segment(3);
                $id = $this->uri->segment(4);
                $tbl_nam = "tbl_candidate_wrk_histry";
                
                $this->load->model('resume_model');
                $result = $this->resume_model->delete($id,$tbl_nam);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','The work Detail deleted Successfully...!');
                    redirect('resume/edit_resume/'.$resume_id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','Work Detail deletion error...!');
                    redirect('resume/edit_resume/'.$resume_id);
                    exit;
                }
            }
            
    public function edit_achiev()
    {
        //echo "<pre>"; print_r($_POST); exit;
        $resume_id = $this->uri->segment(3);
        $this->data['res_id'] = $resume_id;
        $id = $this->uri->segment(4);
        $this->data['id'] = $id;
       if($this->uri->segment(5) == "")
       {
            $cand_id = $this->session->userdata['user_data']['usr_id'];
       }
       else
       {
           $cand_id = $this->uri->segment(5);
       }
       
       $des= $this->input->post('desc');
       $this->form_validation->set_rules('desc','Description','required');
       
            if($this->form_validation->run() == FALSE)
            {
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($resume_id, $cand_id);
                $this->data['achievement'] = $this->resume_model->get_achievement($id);
                //echo "<pre>"; print_r($this->data['achievement']); exit;
                $this->load->view('edit_achievement',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                $res_id = $this->input->post('res_id');
                // Key achievements
                $des= $this->input->post('desc');
                $loct = $this->input->post('location');
                $ach_dat = $this->input->post('ach_date');
                //key achievements
                
                $this->load->model('resume_model');
                $i=0;
                foreach($des as $ds)
                {
                    $key_achs = $this->resume_model->update_key_achvs($ds,$loct[$i], $ach_dat[$i], $id[$i]);
                    $i++;
                }
                  
                 
                if($key_achs >0)
                {
                    $this->session->set_flashdata('msg','your Achievements edited Successfully...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your Achievements editing error...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
            }
       
    }
            
            public function delete_achiev()
            {
                $resume_id = $this->uri->segment(3);
                $id = $this->uri->segment(4);
                $tbl_nam = "tbl_candidate_achievements";
                
                $this->load->model('resume_model');
                $result = $this->resume_model->delete($id,$tbl_nam);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','The achievement Detail deleted Successfully...!');
                    redirect('resume/edit_resume/'.$resume_id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','Achievement Detail deletion error...!');
                    redirect('resume/edit_resume/'.$resume_id);
                    exit;
                }
            }
            
       public function edit_resume5()
        {
            $id = $this->uri->segment(3);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $this->form_validation->set_rules('course_nam','Course Title','required');
            
            $this->data['res_id'] = $id;
            
            if($this->form_validation->run() == FALSE)
            {
                $this->data['id'] = $id;
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($id, $cand_id);
                
                $this->load->view('resume_edit',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                //Trainings/ Courses
                $crs_nam = $this->input->post('course_nam');
                $conduct_by = $this->input->post('con_by');
                $loc = $this->input->post('location');
                $on_dat = $this->input->post('con_date');
                //Trainings/ Courses
                
                $this->load->model('resume_model');
                $i=0;
                foreach($crs_nam as $crs)
                {
                    $training_dtls = $this->resume_model->add_training_info($crs, $conduct_by[$i], $loc[$i], $on_dat[$i], $id, $cand_id);
                    $i++;
                }
                        
                 
               
                if($training_dtls > 0)
                {
                    $this->session->set_flashdata('msg','your training Details Posted Successfully...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your Training Posting error...!');
                    redirect('resume/edit_resume/'.$id);
                    exit;
                }
            }
        }
    
        
        public function edit_train()
        {
            //echo "<pre>"; print_r($_POST); exit;
            $resume_id = $this->uri->segment(3);
                $id = $this->uri->segment(4);
            $cand_id = $this->session->userdata['user_data']['usr_id'];
            $this->form_validation->set_rules('course_nam','Course Title','required');
            $this->data['res_id'] = $resume_id;
            
            if($this->form_validation->run() == FALSE)
            {
                $this->data['id'] = $id;
                $this->load->model('resume_model');
                $this->data['resume_details'] = $this->resume_model->get_resume_details($resume_id, $cand_id);
                $this->data['trainings'] = $this->resume_model->get_training($id);
                
                $this->load->view('edit_training',$this->data);
            }
            else 
            {
                //echo "<pre>"; print_r($_POST); exit;
                $id = $this->input->post('id');
                $res_id = $this->input->post('res_id');
                //Trainings/ Courses
                $crs_nam = $this->input->post('course_nam');
                $conduct_by = $this->input->post('con_by');
                $loc = $this->input->post('location');
                $on_dat = $this->input->post('con_date');
                //Trainings/ Courses
                
                $this->load->model('resume_model');
                $i=0;
                foreach($crs_nam as $crs)
                {
                    $training_dtls = $this->resume_model->update_training_info($crs, $conduct_by[$i], $loc[$i], $on_dat[$i], $id[$i]);
                    $i++;
                }
                        
                 
               
                if($training_dtls > 0)
                {
                    $this->session->set_flashdata('msg','your training Details edited Successfully...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','your Training Editing error...!');
                    redirect('resume/edit_resume/'.$res_id[0]);
                    exit;
                }
            }
        }
        
        
             public function delete_train()
            {
                $resume_id = $this->uri->segment(3);
                $id = $this->uri->segment(4);
                $tbl_nam = "tbl_candidate_trainings";
                
                $this->load->model('resume_model');
                $result = $this->resume_model->delete($id,$tbl_nam);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('msg','The education Detail deleted Successfully...!');
                    redirect('resume/edit_resume5/'.$resume_id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('err_msg','education Detail deletion error...!');
                    redirect('resume/edit_resume5/'.$resume_id);
                    exit;
                }
            }
            
            
            public function fav_cand_listing()
            {
                $this->data['url'] = site_url();
                $config = array();
                $config["base_url"] = $this->data['url']."resume/fav_cand_listing/";
                 $tbl_nam = 'tbl_favourite_candidates';
                 $field = 'employer_id';
                 $emp_id = $this->session->userdata['user_data']['usr_id'];
                $this->load->model('jobs_model');
                $this->load->model('resume_model');
                $rows = $this->resume_model->fav_cand_count($tbl_nam, $field, $emp_id);
                 

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
                $this->data['pagin'] = $this->pagination->create_links();
                $this->data['projects'] = $this->resume_model->get_recent_projects();
                $this->data['rat_dv'] = 20;
                $criter = $this->resume_model->get_rat_crit();
                $this->data['cands'] = $this->resume_model->get_fav_candidates($page, $config['per_page'], $emp_id, $criter);
                 $criteria = $this->resume_model->get_rating_criteria();
       
                    $this->data['review_criteria'] = $criteria;
                //echo "<pre>"; print_r($this->data['cands']); exit;
                $this->load->view('candidates_listing',$this->data);
            }
        
            public function resume_management()
            {
                $data['url'] = base_url();
                $usr_id = $this->session->userdata['user_data']['usr_id'];
                
                $this->data['resumes'] = $this->resume_model->candidate_resumes($usr_id);
                //echo "<pre>"; print_r($data['resumes']); exit;
                $this->load->view('candidate_resumes_listing',$this->data);
            }

            public function delete_resume()
            {
                $res_id = $this->uri->segment(3);
                $cand_id = $this->uri->segment(4);
                
                $del = $this->resume_model->delete_resume($res_id, $cand_id);
                
                if($del > 0){
                    $this->session->set_flashdata('msg','The Selected resume is deleted Successfully');
                    redirect('resume/resume_management');
                    exit;
                }
                else{
                    $this->session->set_flashdata('err_msg','Resume deleting error..!!');
                    redirect('resume/resume_management');
                    exit;
                }
            }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
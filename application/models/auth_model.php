<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function authenticate($unam, $pas) {
        $q = 'SELECT * 
              FROM tbl_users
              WHERE email_address="' . $unam . '" and password="' . $pas . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    public function register($data)
    {
        $q = "INSERT
              INTO
              tbl_users
              SET
              `email_address`='".$data['email']."',
              `password`='".$data['pass']."',
              `user_type`='".$data['utyp']."',
              `first_name`='".$data['fnam']."',
              `last_name`='".$data['lnam']."',
              `town`='".$data['town']."',
              `phone_number`='".$data['phone']."',
              `profile_pic`='".$data['pic']."',
              `consultant_check`='".$data['consultant']."'
              ";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    
    function fb_login_details($fb_id, $f_nam, $l_nam, $email)
    { 
        $q = "SELECT
              id 
              FROM 
              `tbl_users` 
              WHERE 
              `email_address`='".$email."'";
        
        $query = $this->db->query($q);
        $res = $query->result_array();
        if($query->num_rows() > 0)
        {
            $res = $query->result_array();
            $id = $res[0]['id'];
        }
        else 
        {
               $in_q = "INSERT
                        INTO
                        tbl_users
                        SET
                        `fb_id`='".$fb_id."',
                        `user_type`=3,
                        `first_name`='".$f_nam."',
                        `last_name`='".$l_nam."',
                        `email_address`='".$email."'";
            
            $in_query = $this->db->query($in_q);
            
            $id = $this->db->insert_id();
        }
        return $id;
    }
    
    
    function count_jobs()
    {
        //$date = date("Y-m-d H:i:s");
        return $this->db->count_all("`tbl_jobs`");
    }
    
    function count_resumes()
    {
        return $this->db->count_all("`tbl_resume`");
    }
    
    function count_members()
    {
        return $this->db->count_all("`tbl_users` WHERE `user_type`  = '3'");
    }
    
    function count_companies()
    {
        return $this->db->count_all("`tbl_users` WHERE `user_type`  != '3'");
    }
    
    
    function check_email_availablity($email)
    {
        $q = 'SELECT * 
              FROM tbl_users
              WHERE email_address="' . $email . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    

}

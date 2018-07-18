<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    
    function change_pass($data)
    {
       $q = "UPDATE
              tbl_users
              SET
              password='".$data['new']."'
              WHERE
              id = '".$data['id']."'
              ";
        
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            return TRUE; 
        }
        else 
        {
            return FALSE;
        }
    }
            
    function check_pass($data) {
        $q = 'SELECT * 
              FROM tbl_users
              WHERE id="' . $data['id'] . '" and password="' . $data['pass'] . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_user_profile($id)
    {
        $q = 'SELECT  
              `first_name`,
              `last_name`,
              `business_email`,
              `town`,
              `phone_number`,
              `user_type`,
              `profile_pic`
              FROM 
              tbl_users
              WHERE id="' . $id . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    function update_profile($data,$id)
    {
//        if($data['pic'] != 'no file')
//        {
//            $q = 'UPDATE  
//              tbl_users
//              SET
//              `first_name`="' . $data['fname'] . '",
//              `last_name`="' . $data['lname'] . '",
//              `town`="' . $data['town'] . '",
//              `phone_number`="' . $data['phone'] . '",
//              `profile_pic`="'.$data['pic'].'"
//              WHERE 
//              id="' . $id . '"';
//            
//            $utyp = $this->session->userdata['user_data']['u_type'];
//            $eml = $this->session->userdata['user_data']['email'];
//            
//            $usr_dta['user_data'] = array(
//                        'usr_id' => $id,
//                        'is_user_logged_in' => TRUE,
//                        'f_name' => $data['fname'],
//                        'l_name' => $data['lname'],
//                        'u_type' => $utyp,
//                        'email' => $eml,
//                        'dp' => $data['pic']
//                    );
//                    $this->session->set_userdata($usr_dta);
//        }
//        else 
//        {
            $q = 'UPDATE  
              tbl_users
              SET
              `first_name`="' . $data['fname'] . '",
              `last_name`="' . $data['lname'] . '",
              `town`="' . $data['town'] . '",
              `phone_number`="' . $data['phone'] . '"
              WHERE 
              id="' . $id . '"';
            $utyp = $this->session->userdata['user_data']['u_type'];
            $eml = $this->session->userdata['user_data']['email'];
            $dp = $this->session->userdata['user_data']['dp'];
            
            $usr_dta['user_data'] = array(
                        'usr_id' => $id,
                        'is_user_logged_in' => TRUE,
                        'f_name' => $data['fname'],
                        'l_name' => $data['lname'],
                        'u_type' => $utyp,
                        'email' => $eml,
                        'dp' => $dp
                    );
                    $this->session->set_userdata($usr_dta);
        //}
        

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function update_pr_pic($pic, $id)
    {
        $q = 'UPDATE  
              tbl_users
              SET
              `profile_pic`="'.$pic.'"
              WHERE 
              id="' . $id . '"';
        
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function add_comp_data($data)
    {
        $q = "INSERT
              INTO
              `tbl_companyy`
              SET
              `company_id`='".$data['emp_id']."',
              `emp_id`='".$data['emp_id']."',
              `company_name`='".$data['c_nam']."',
              `tag_line`='".$data['tag']."',
              `found_year`='".$data['f_year']."',
              `team_size`='".$data['tm_sz']."',
              `location`='".$data['loc']."',
              `category`='".$data['cat']."',
              `country`='".$data['cnt']."',
              `state`='".$data['stt']."',
              `city`='".$data['cty']."',
              `address`='".$data['adress']."',
              `latitude`='".$data['lat']."',
              `longitude`='".$data['long']."'
              ";
          
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            $qq = "UPDATE
              `tbl_users`
              SET
              `company_id`='".$data['emp_id']."'
              WHERE
              id='".$data['emp_id']."'
              ";
        
            $query_in = $this->db->query($qq);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function update_comp_data($data, $id)
    {
        $q = "UPDATE
              `tbl_companyy`
              SET
              `company_name`='".$data['c_nam']."',
              `tag_line`='".$data['tag']."',
              `found_year`='".$data['f_year']."',
              `team_size`='".$data['tm_sz']."',
              `category`='".$data['cat']."',
              `location`='".$data['loc']."',
              `country`='".$data['cnt']."',
              `state`='".$data['stt']."',
              `city`='".$data['cty']."',
              `address`='".$data['adress']."',
              `latitude`='".$data['lat']."',
              `longitude`='".$data['long']."'
              WHERE
              company_id='".$id."'
              ";
        
        $query = $this->db->query($q); 
        
        if($query > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function get_comp_data($u_id)
    {
        $q = 'SELECT  
              `company_id`
              FROM 
              tbl_users
              WHERE 
              id="' . $u_id . '"
              AND
              company_id <> 0';

        $result = $this->db->query($q);
        
        if($result->num_rows() > 0)
        {
            $q = "SELECT
                  usr.`id`,
                  usr.`first_name`,
                  usr.`last_name`,
                  usr.`email_address`,
                  `tbl_companyy`.`company_id`,
                  `tbl_companyy`.`emp_id`,
                  `tbl_companyy`.`company_name`,
                  `tbl_companyy`.`tag_line`,
                  `tbl_companyy`.`logo`,
                  `tbl_companyy`.`found_year`,
                  `tbl_companyy`.`team_size`,
                  `tbl_companyy`.`location`,
                  `tbl_companyy`.`category`,
                  `tbl_companyy`.`country`,
                  `tbl_companyy`.`state`,
                  `tbl_companyy`.`city`,
                  `tbl_companyy`.`address`,
                  `tbl_companyy`.`longitude`,
                  `tbl_companyy`.`latitude`
                  FROM
                  `tbl_users` usr
                  LEFT JOIN
                  `tbl_companyy`
                  ON
                  usr.company_id = `tbl_companyy`.`company_id`
                  WHERE
                  usr.id='". $u_id ."'
                  AND
                  usr.company_id <> 0
                 ";
            
            $query = $this->db->query($q);
            
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
        }
        else
        {}
    }
    
    public function get_companies()
    {
        $q = "SELECT
                  `tbl_companyy`.`company_id`,
                  `tbl_companyy`.`emp_id`,
                  `tbl_companyy`.`company_name`
                  FROM
                  `tbl_companyy`
                 ";
        
        $query = $this->db->query($q);
            
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
    }
    
    public function add_selected_company($company, $usr_id)
    {
        $q = "UPDATE
              tbl_users
              SET
              company_id='".$company."'
              WHERE
              id = '".$usr_id."'
              ";
        
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            return TRUE; 
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function check_comp_owner($usr_id)
    {
        $q = "SELECT
                  `tbl_users`.`id`,
                  `tbl_users`.`company_id`
                  FROM
                  `tbl_users`
                  WHERE
                  company_id=".$usr_id."
                  AND
                  id=".$usr_id."
                 ";
        
        $query = $this->db->query($q);
            
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
    }
    
    public function count_team($usr_id)
    {
        return $this->db->count_all("`tbl_users` WHERE company_id = ".$usr_id." AND `id` <> ".$usr_id."");
    }


    public function get_comp_sub_admins($usr_id, $start, $limit)
    {
        $q = "SELECT
                  usr.`id`,
                  usr.`first_name`,
                  usr.`last_name`,
                  usr.`email_address`,
                  usr.`company_id`,
                  usr.`privilage_status`,
                  usr.phone_number
                  FROM
                  `tbl_users` usr
                  WHERE
                  usr.company_id = ".$usr_id."
                  AND
                  usr.`id` <> ".$usr_id."
                  ORDER BY
                  usr.id DESC
                  LIMIT
                  ".$start.", ".$limit."
                 ";
            
            $query = $this->db->query($q);
            
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
    }
    
    public function change_privilege($status, $id)
    {
        $q = "UPDATE
              tbl_users
              SET
              privilage_status=".$status."
              WHERE
              id = '".$id."'
              ";
        
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            return TRUE; 
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function get_com_id($usr_id)
    {
        $q = "SELECT
                  `company_id`,
                  privilage_status
                  FROM
                  `tbl_users`
                  WHERE
                  id=".$usr_id."
                 ";
        
        $query = $this->db->query($q);
            
            if($query->num_rows() > 0)
            {
                $ret = $query->result_array();
                return $ret[0];
            }
            else
            {
                return FALSE;
            }
    }
    
    public function update_comp_logo($img, $comp)
    {
        $q = "UPDATE
              `tbl_companyy`
              SET
              `logo`='".$img."'
              WHERE
              `company_id` = '".$comp."'
              ";
        
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            return TRUE; 
        }
        else 
        {
            return FALSE;
        }
    }
}

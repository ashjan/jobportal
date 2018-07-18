<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('America/New_York');
    }
    
    
    
    function add_testimonial($testim, $uid)
    {
        $q = "INSERT
              INTO
              `tbl_testimonials`
              SET
              `testimonial`='".$testim."',
              `user_id`='".$uid."',
              `status`='1'
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
    
    
    function get_added_testimonials()
    {
        $q = "SELECT
              tbl_testimonials.`id`,
              tbl_testimonials.`testimonial`,
              tbl_testimonials.`user_id`,
              tbl_testimonials.`created_date`,
              tbl_testimonials.`status`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic
              FROM
              `tbl_testimonials`
              LEFT JOIN
              tbl_users usr
              ON
              usr.id = tbl_testimonials.user_id
              WHERE
              tbl_testimonials.status=1";
        
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
    
    
    
}
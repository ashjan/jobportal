<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
   
    
    
    public function add_resume_review($review, $res_id, $cand_id, $emp_id)
    {
        $q_get = "SELECT
                candidate_id
                FROM
                tbl_resume_reviews
                WHERE
                `candidate_id`='".$cand_id."'
                AND
                `emp_id`='".$emp_id."'
                ";
        $query = $this->db->query($q_get);
        
        if($query->num_rows()>0){
            $q = "UPDATE
              tbl_resume_reviews
              SET
              `review`='".$review."'
              WHERE
              `candidate_id`='".$cand_id."'
              AND
              `emp_id`='".$emp_id."'";
        }
        else{
        $q = "INSERT
              INTO
              tbl_resume_reviews
              SET
              `candidate_id`='".$cand_id."',
              `resume_id`='".$res_id."',
              `emp_id`='".$emp_id."',
              `review`='".$review."'";
        }
        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function add_star_rating($rating, $criteria_id, $res_id, $cand_id, $emp_id)
    {
        $check = $this->check_added_star_rate($criteria_id, $emp_id, $cand_id);
        if($check == 0)
        {
            $q = "INSERT
                  INTO
                  tbl_resume_rating
                  SET
                  `candidate_id`='".$cand_id."',
                  `resume_id`='".$res_id."',
                  `emp_id`='".$emp_id."',
                  `criteria_id`='".$criteria_id."',
                  `rating`='".$rating."'";
        }
        else
        {
            $q = "UPDATE
                  tbl_resume_rating
                  SET
                  `rating`='".$rating."'
                  WHERE
                  id='".$check."'";
        }

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function check_added_star_rate($criteria, $emp_id, $cand_id)
    {
        $q = "SELECT 
              `id`
              FROM
              tbl_resume_rating
              WHERE
              `candidate_id`='".$cand_id."'
              AND
              `emp_id`='".$emp_id."'
              AND
              `criteria_id`='".$criteria."'
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result[0]['id'];
        }
        else
        {
            return 0;
        }
    }
    
    public function add_job_star_rating($rating, $criteria_id, $job_id, $cand_id)
    {
        $check = $this->check_job_added_star_rate($criteria_id, $cand_id, $job_id);
        if($check == 0)
        {
            $q = "INSERT
                  INTO
                  `tbl_job_rating`
                  SET
                  `candidate_id`='".$cand_id."',
                  `job_id`='".$job_id."',
                  `criteria_id`='".$criteria_id."',
                  `rating`='".$rating."'";
}
        else
        {
            $q = "UPDATE
                  `tbl_job_rating`
                  SET
                  `rating`='".$rating."'
                  WHERE
                  id='".$check."'";
        }

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function check_job_added_star_rate($criteria, $cand_id, $job_id)
    {
        $q = "SELECT 
              `id`
              FROM
              tbl_job_rating
              WHERE
              `candidate_id`='".$cand_id."'
              AND
              `job_id`='".$job_id."'
              AND
              `criteria_id`='".$criteria."'
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result[0]['id'];
        }
        else
        {
            return 0;
        }
    }
    
    function add_guest_job_star_rating($rate,$job_id)
    {
        $check = $this->check_job_added_star_guest_rate($job_id);
        if($check == 0)
        {
            $q = "INSERT
                  INTO
                  `tbl_job_guest_rating`
                  SET
                  `rating`='".$rate."',
                  `job_id`='".$job_id."'";
}
        else
        {
            $rating = ($check['rating']+$rate) / 2;
            $q = "UPDATE
                  `tbl_job_guest_rating`
                  SET
                  `rating`='".$rating."'
                  WHERE
                  id='".$check['id']."'";
        }

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function check_job_added_star_guest_rate($job_id)
    {
        $q = "SELECT 
              `id`,
              `rating`
              FROM
              tbl_job_guest_rating
              WHERE
              job_id='".$job_id."'
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result[0];
        }
        else
        {
            return 0;
        }
    }
    
    public function add_job_review($review, $job_id, $cand_id)
    {
        $q_get = "SELECT
                id
                FROM
                `tbl_job_reviews`
                WHERE
                `candidate_id`='".$cand_id."'
                AND
                `job_id`='".$job_id."'
                ";
        $query = $this->db->query($q_get);
        
        if($query->num_rows()>0){
            $q = "UPDATE
              tbl_job_reviews
              SET
              `review`='".$review."'
              WHERE
              `candidate_id`='".$cand_id."'
              AND
              `job_id`='".$job_id."'";
        }
        else{
        $q = "INSERT
              INTO
              tbl_job_reviews
              SET
              `candidate_id`='".$cand_id."',
              `job_id`='".$job_id."',
              `review`='".$review."'";
        }
        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}

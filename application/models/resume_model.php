<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resume_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
     function resume_viewed($id) {
//	    echo "<pre>";
//		echo "UPDATE `tbl_resume_views` SET no_of_views = no_of_views + 1 WHERE `id`='".$id."'";
//		echo "</pre>";
        $this->db->query("UPDATE `tbl_resume_views` SET no_of_views = no_of_views + 1 WHERE `id`='".$id."'");
//		$data = array(
//               'no_of_views'=>'no_of_views + 1'
//            );
//        $this->db->where('id', $id);
//        $this->db->update('tbl_resume_views', $data); 
		
     }
    
    function get_recent_projects()
    {
        $q = "SELECT
              *
              FROM 
              tbl_category
              ORDER BY
              tbl_category.id DESC
              LIMIT
              0, 4
              ";
        
        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            $projects = $result->result_array();
            return $projects;
        }
        else
        {
            return FALSE;
        }
        
    }
    
    function get_latest_companies($start=null, $limit=null)
    {
        if($limit != "")
        {
            $q = "SELECT
              usr.id as usr_id,
              usr.`first_name`,
              usr.`last_name`,
              usr.profile_pic,
              comp.`id` as cmp_id,
			  comp.`company_id`,
              comp.`company_name`,
              comp.`logo`,
              tbl_countries.CountryId,
              tbl_countries.Country as country_name,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_users usr
              INNER JOIN
              tbl_companyy comp
              ON
              usr.id=comp.emp_id
              LEFT JOIN
              tbl_property_category categ
              ON
              comp.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              WHERE
              user_type = 4
              ORDER BY
              usr.id DESC
              LIMIT
              ".$start.", ".$limit."
              ";
        }
        else
        {
            $q = "SELECT
              usr.id as usr_id,
              usr.`first_name`,
              usr.`last_name`,
              usr.profile_pic,
              comp.`id` as cmp_id,
              comp.`company_name`,
              comp.`logo`,
              tbl_countries.CountryId,
              tbl_countries.Country as country_name,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_users usr
              INNER JOIN
              tbl_companyy comp
              ON
              usr.id=comp.emp_id
              LEFT JOIN
              tbl_property_category categ
              ON
              comp.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              WHERE
              usr.user_type = 4
              ORDER BY
              usr.id DESC
              LIMIT
              0, 7
              ";
        }
        
        
        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            $resume = $result->result_array();
            return $resume;
        }
        else
        {
            return FALSE;
        }
    }
            
    function get_latest_resumes($start=null, $limit=null, $check=null,$criteria=null)
    {
        if($start == "" && $limit == "")
        {
        $q = "SELECT
              tbl_resume.`id` as res_id,
              tbl_resume.candidate_id,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`,
              usr.id as usr_id,
              usr.profile_pic,
              tbl_countries.CountryId,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_resume
              INNER JOIN
              tbl_users usr
              ON
              usr.id = tbl_resume.candidate_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_resume.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              ORDER BY
              tbl_resume.id DESC
              LIMIT
              0, 7
              ";
        }
        else
        {
            if($check == "")
            {
            $q = "SELECT
              tbl_resume.`id` as res_id,
              tbl_resume.candidate_id,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`,
              usr.id as usr_id,
              usr.profile_pic,
              tbl_countries.CountryId,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_resume
              INNER JOIN
              tbl_users usr
              ON
              usr.id = tbl_resume.candidate_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_resume.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              ORDER BY
              tbl_resume.id DESC
              LIMIT
              ".$start.", ".$limit."
              ";
            }
            else
            {
                $q = "SELECT
              tbl_resume.`id` as res_id,
              tbl_resume.candidate_id,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`,
              usr.id as usr_id,
              usr.profile_pic,
              tbl_countries.CountryId,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_resume
              INNER JOIN
              tbl_users usr
              ON
              usr.id = tbl_resume.candidate_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_resume.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              WHERE
              consultant_check = ".$check."
              ORDER BY
              tbl_resume.id DESC
              LIMIT
              ".$start.", ".$limit."
              ";
            }
            
        }
        
        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            $resume = $result->result_array();
            if(isset($this->session->userdata['user_data']['usr_id']))
            {
                $emp_id = $this->session->userdata['user_data']['usr_id'];
                foreach($resume as $res)
                {
                     $res['fav_id'] = $this->get_favourite_cand($res['candidate_id'], $emp_id);
                     $res['reviews'] = $this->get_added_reviews($res['candidate_id']);
                     if(!empty($criteria)){
                            foreach($criteria as $crt){
                                $average = $this->get_rating_averrage($crt['id'],$res['candidate_id']);
                                if($average[0]['id'] != ""){
                                $avg[] = $average;}
                                else{
                                    $avg[] = "";
                                }
                            }
                            if(!empty($avg[0])){
                            $res['average'] = $avg;}
                            else{
                                $res['average'] = "";
                            }
                            unset($avg);
                     }
                     $reso[] = $res;
                }
                  return $reso;
            }
            else
            {
                return $resume;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
      public function get_favourite_cand($cand, $emp)
      {
          $sl_q = "SELECT
                   id
                   FROM
                   `tbl_favourite_candidates`
                   WHERE
                   `candidate_id`='".$cand."'
                    and
                    `employer_id`='".$emp."'
                  ";
          
          $sl_query = $this->db->query($sl_q);
          
          if($sl_query->num_rows() > 0)
          {
              $res = $sl_query->result_array();
              return $res[0]['id'];
          }
          else
          {
              return FALSE;
          }
      }
    
    public function get_rating_averrage($crt_id,$cand_id)
    {
        $q = "SELECT
              rat.`id`,
              AVG(rat.`rating`) as avg_rat,
              rat.`emp_id`,
              crit.`criteria`
              FROM
              `tbl_resume_rating` rat
              INNER JOIN
              `tbl_review_criteria` crit
              ON
              rat.`criteria_id`=crit.id
              WHERE
              rat.`candidate_id`='".$cand_id."'
              AND
              rat.`criteria_id`='".$crt_id."'
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows()>0)
        {
            $reslt = $query->result_array();
            return $reslt;
        }
        else 
        {
            return FALSE;
        }
    }
      
    function get_emp_adv_srch($wht, $whr, $sal, $cat, $sal_to, $from, $to)
    {
        if($sal != "" && $sal_to != "")
        {
            if($from != "" && $to != "")
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
              OR
              tbl_resume.`last_name` LIKE '%".$wht."%'
              AND
              tbl_resume.`category` = '".$cat."'
              OR
              tbl_city.name LIKE '".$whr."'
              AND
              tbl_resume.`salary` BETWEEN '".$sal."' and '".$sal_to."'
              AND
              tbl_resume.`available_date` BETWEEN '".$from."' and '".$to."'
              ";
            }
            elseif ($from != "" && $to =="") 
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
              OR
              tbl_resume.`last_name` LIKE '%".$wht."%'
              AND
              tbl_resume.`category` = '".$cat."'
              OR
              tbl_city.name LIKE '".$whr."'
              AND
              tbl_resume.`salary` BETWEEN '".$sal."' and '".$sal_to."'
              AND
              tbl_resume.`available_date` BETWEEN '".$from."' and '".$from."'
              ";
            
            }
            else
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
              OR
              tbl_resume.`last_name` LIKE '%".$wht."%'
              AND
              tbl_resume.`category` = '".$cat."'
              OR
              tbl_city.name LIKE '".$whr."'
              AND
              tbl_resume.`salary` BETWEEN '".$sal."' and '".$sal_to."'
              ";
            }
            
        
        }
        elseif ($sal != "" && $sal_to == "") 
        {
            if($from != "" && $to != "")
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
                  OR
                  tbl_resume.`last_name` LIKE '%".$wht."%'
                  AND
                  tbl_resume.`category` = '".$cat."'
                  OR
                  tbl_city.name LIKE '".$whr."'
                  AND
                  tbl_resume.`salary` BETWEEN '".$sal."' and '".$sal."'
                  AND
                  tbl_resume.`available_date` BETWEEN '".$from."' and '".$to."'
                  ";
            }
            elseif ($from != "" && $to == "") 
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
                  OR
                  tbl_resume.`last_name` LIKE '%".$wht."%'
                  AND
                  tbl_resume.`category` = '".$cat."'
                  OR
                  tbl_city.name LIKE '".$whr."'
                  AND
                  tbl_resume.`salary` BETWEEN '".$sal."' and '".$sal."'
                  AND
                  tbl_resume.`available_date` BETWEEN '".$from."' and '".$from."'
                  ";
            }
            else
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
                  OR
                  tbl_resume.`last_name` LIKE '%".$wht."%'
                  AND
                  tbl_resume.`category` = '".$cat."'
                  OR
                  tbl_city.name LIKE '".$whr."'
                  AND
                  tbl_resume.`salary` BETWEEN '".$sal."' and '".$sal."'
                  ";
            }
        }
        else
        {
            if($from != "" && $to != "")
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
                        OR
                        tbl_resume.`last_name` LIKE '%".$wht."%'
                        AND
                        tbl_resume.`category` = '".$cat."'
                        OR
                        tbl_city.name LIKE '".$whr."'
                        AND
                        tbl_resume.`available_date` BETWEEN '".$from."' and '".$to."'
                        ";
            }
            elseif($from != "" && $to == "")
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
                        OR
                        tbl_resume.`last_name` LIKE '%".$wht."%'
                        AND
                        tbl_resume.`category` = '".$cat."'
                        OR
                        tbl_city.name LIKE '".$whr."'
                        AND
                  tbl_resume.`available_date` BETWEEN '".$from."' and '".$from."'
                        ";
            }
            else
            {
                $where = "tbl_resume.first_name LIKE '%".$wht. "%'
                        OR
                        tbl_resume.`last_name` LIKE '%".$wht."%'
                        AND
                        tbl_resume.`category` = '".$cat."'
                        OR
                        tbl_city.name LIKE '".$whr."'
                        ";
            }
        }
        
        $q = "SELECT
              tbl_resume.`id` as res_id,
              tbl_resume.candidate_id,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`,
              usr.id as usr_id,
              tbl_countries.CountryId,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_resume
              INNER JOIN
              tbl_users usr
              ON
              usr.id = tbl_resume.candidate_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_resume.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              WHERE
              $where
              ";
        
        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            $resume = $result->result_array();
            return $resume;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_resume($cand) {
        $q = 'SELECT
              tbl_resume.`id`,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.candidate_id,
              tbl_resume.create_date
              FROM 
              tbl_resume
              WHERE
              tbl_resume.candidate_id="' . $cand . '"
              ORDER BY tbl_resume.`id` DESC';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            $resume = $result->result_array();
            return $resume;
        }
    }
    
    function get_resume_details($id, $cand) {
        $q = 'SELECT
              tbl_resume.`id`,
              tbl_resume.`candidate_id`,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`marital_status`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`
              FROM 
              tbl_resume
              WHERE 
              tbl_resume.id="' . $id . '"
              and 
              tbl_resume.candidate_id="' . $cand . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            $resume = $result->result_array();
            $resume_details = array();
            foreach($resume as $res)
            {
                $res['education_details'] = $this->get_education_details($res['id'],$cand);
                $res['images'] = $this->get_resume_images($res['id'],$cand);
                $res['work_details'] = $this->get_work_details($res['id'],$cand);
                $res['trainings'] = $this->get_training_details($res['id'],$cand);
                $res['achievements'] = $this->get_achievement_details($res['id'],$cand);
                $resume_details[] = $res;
            }
            return $resume_details;
        }
        else{
            return FALSE;
        }
    }    
    
    
    
    function resume_cover_letter($cand) {
        
            $q = 'SELECT * FROM tbl_covering_letter
                  WHERE 
                  tbl_covering_letter.candidate_id="' . $cand . '"';
                  $result = $this->db->query($q);
               if ($result->num_rows() > 0) {
               return $result->result_array();
        }else{
            return FALSE;
        }
    }
    
    function get_education_details($id, $cand) {
        $q = 'SELECT
              edu.`id`,
              edu.`title`,
              edu.`institute`,
              edu.`start_date`,
              edu.`end_date`,
              edu.`maj_subjects`,
              edu.`resume_id`,
              edu.`candidate_id`,
              edu.`grade`
              FROM 
              `tbl_candidate_education` edu
              WHERE 
              edu.resume_id="' . $id . '"
              and 
              edu.candidate_id="' . $cand . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_resume_images($id, $cand) {
        $q = 'SELECT
              `id`,
              `image_name`,
              `image_type`,
              `image_size`
              FROM 
              `tbl_candidate_images`
              WHERE 
              resume_id="' . $id . '"
              and 
              candidate_id="' . $cand . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_work_details($id, $cand) {
        $q = 'SELECT
              `id`,
              `designation`,
              `company_name`,
              `start_date`,
              `end_date`,
              `job_responsibilities`
              FROM 
              `tbl_candidate_wrk_histry`
              WHERE 
              resume_id="' . $id . '"
              and 
              candidate_id="' . $cand . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_training_details($id, $cand) {
        $q = 'SELECT
              `id`,
              `course_name`,
              `conducted_by`,
              `location`,
              `date`,
              `resume_id`,
              `candidate_id`
              FROM 
              `tbl_candidate_trainings`
              WHERE 
              resume_id="' . $id . '"
              and 
              candidate_id="' . $cand . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_achievement_details($id, $cand) {
        $q = 'SELECT
              `id`,
              `description`,
              `location`,
              `ach_date`
              FROM 
              `tbl_candidate_achievements`
              WHERE 
              resume_id="' . $id . '"
              and 
              candidate_id="' . $cand . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    public function add_step_one($data)
    {
        $q = "INSERT
              INTO
              tbl_resume
              SET
              `first_name`='".$data['fnam']."',
              `last_name`='".$data['lnam']."',
              `email`='".$data['email']."',
              `phone`='".$data['phone']."',
              `address_1`='".$data['adrs']."',
              `date_of_birth`='".$data['dob']."',
              `available_date`='".$data['avail']."',
              `candidate_id`='".$data['cand_id']."',
              `objectives`='".$data['obj']."',
               `category`='".$data['pr_ct']."',
               `father_name`='".$data['fathernam']."',
               `cnic`='".$data['cnic']."',
               `gender`='".$data['gender']."',
               `marital_status`='".$data['mar_st']."',
               `salary`='".$data['sal']."',
               `expected_salary`='".$data['ex_sal']."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function add_education($ttl, $ins, $strt, $end, $sub, $grad, $id, $cand)
    {
        $q = "INSERT
              INTO
              `tbl_candidate_education`
              SET
              `title`='".$ttl."',
              `institute`='".$ins."',
              `start_date`='".$strt."',
              `end_date`='".$end."',
              `maj_subjects`='".$sub."',
              `resume_id`='".$id."',
              `candidate_id`='".$cand."',
              `grade`='".$grad."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
     public function add_work_history($ttl, $ins, $strt, $end, $sub, $id, $cand)
    {
        $q = "INSERT
              INTO
              `tbl_candidate_wrk_histry`
              SET
              `designation`='".$ttl."',
              `company_name`='".$ins."',
              `start_date`='".$strt."',
              `end_date`='".$end."',
              `job_responsibilities`='".$sub."',
              `resume_id`='".$id."',
              `candidate_id`='".$cand."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    public function add_training_info($cr, $conduct_by, $loc, $on_dat, $id, $cand)
    {
        $q = "INSERT
              INTO
              `tbl_candidate_trainings`
              SET
              `course_name`='".$cr."',
              `conducted_by`='".$conduct_by."',
              `location`='".$loc."',
              `date`='".$on_dat."',
              `resume_id`='".$id."',
              `candidate_id`='".$cand."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    
    public function add_key_achvs($dd,$loct, $ach_dat, $id, $cand)
    {
        $q = "INSERT
              INTO
              `tbl_candidate_achievements`
              SET
              `description`='".$dd."',
              `location`='".$loct."',
              `ach_date`='".$ach_dat."',
              `resume_id`='".$id."',
              `candidate_id`='".$cand."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
            
    public function add_skill_info($ttl, $b_skil, $l_skil, $c_skil, $ref, $id, $cand_id)
    {
        $q = "UPDATE
             `tbl_resume`
              SET
              `business_title`='".$ttl."',
              `business_skills`='".$b_skil."',
              `language_skills`='".$l_skil."',
              `computer_skills`='".$c_skil."',
              `refrences`='".$ref."'
              WHERE
              `id`='".$id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
   public function get_uploaded_resumes($cand_id)
   {
       $q = "SELECT resume FROM tbl_users WHERE id='".$cand_id."'";
    
       $query = $this->db->query($q);
       
       if($query->num_rows()>0)
       {
            return $query->result_array();
       }
       else{
           return FALSE;
       }
   }
    
    
    public function add_resume($resume, $cand_id)
    {
        $q = "UPDATE
             `tbl_users`
              SET
              `resume`='".$resume."'
              WHERE
              `id`='".$cand_id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    
     public function edit_resume_one($data)
    {
        $q = "Update
              tbl_resume
              SET
              `first_name`='".$data['fnam']."',
              `last_name`='".$data['lnam']."',
              `email`='".$data['email']."',
              `phone`='".$data['phone']."',
              `address_1`='".$data['adrs']."',
              `date_of_birth`='".$data['dob']."',
              `available_date`='".$data['avail']."',
              `objectives`='".$data['obj']."',
               `father_name`='".$data['fathernam']."',
               `cnic`='".$data['cnic']."',
                `category`='".$data['pr_ct']."',
               `gender`='".$data['gender']."',
               `marital_status`='".$data['mar_st']."',
               `salary`='".$data['sal']."',
               `expected_salary`='".$data['ex_sal']."',
               `business_title`='".$data['ttl']."',
              `business_skills`='".$data['b_skil']."',
              `language_skills`='".$data['l_skil']."',
              `computer_skills`='".$data['c_skil']."',
              `refrences`='".$data['ref']."'
               WHERE 
               `candidate_id`='".$data['cand']."'
               AND
               id='".$data['id']."'
                ";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function delete($id, $tbl_nam)
    {
        $q = "DELETE
              FROM
              $tbl_nam
              WHERE
              `id`='".$id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
     function education_detail($id) {
        $q = 'SELECT
              edu.`id`,
              edu.`title`,
              edu.`institute`,
              edu.`start_date`,
              edu.`end_date`,
              edu.`maj_subjects`,
              edu.`resume_id`,
              edu.`candidate_id`,
              edu.`grade`
              FROM 
              `tbl_candidate_education` edu
              WHERE 
              edu.id="' . $id . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    public function update_education($ttl, $ins, $strt, $end, $sub, $grad, $id)
    {
        $q = "UPDATE
              `tbl_candidate_education`
              SET
              `title`='".$ttl."',
              `institute`='".$ins."',
              `start_date`='".$strt."',
              `end_date`='".$end."',
              `maj_subjects`='".$sub."',
              `grade`='".$grad."'
               WHERE
               id='".$id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_work($id) {
        $q = 'SELECT
              `id`,
              `designation`,
              `company_name`,
              `start_date`,
              `end_date`,
              `job_responsibilities`
              FROM 
              `tbl_candidate_wrk_histry`
              WHERE 
              id="' . $id . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    public function update_work_history($ttl, $ins, $strt, $end, $sub, $id)
    {
        $q = "Update
              `tbl_candidate_wrk_histry`
              SET
              `designation`='".$ttl."',
              `company_name`='".$ins."',
              `start_date`='".$strt."',
              `end_date`='".$end."',
              `job_responsibilities`='".$sub."'
               WHERE
              `id`='".$id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_achievement($id) {
        $q = 'SELECT
              `id`,
              `description`,
              `location`,
              `ach_date`
              FROM 
              `tbl_candidate_achievements`
              WHERE 
              id="' . $id . '"';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
     public function update_key_achvs($dd,$loct, $ach_dat, $id)
    {
        $q = "UPDATE
              `tbl_candidate_achievements`
              SET
              `description`='".$dd."',
              `location`='".$loct."',
              `ach_date`='".$ach_dat."'
               WHERE
               id='".$id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    
    function get_training($id) {
        $q = 'SELECT
              `id`,
              `course_name`,
              `conducted_by`,
              `location`,
              `date`,
              `resume_id`,
              `candidate_id`
              FROM 
              `tbl_candidate_trainings`
              WHERE 
              id="' . $id . '"
              ';

        $result = $this->db->query($q);
        

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    public function update_training_info($cr, $conduct_by, $loc, $on_dat, $id)
    {
        $q = "UPDATE
              `tbl_candidate_trainings`
              SET
              `course_name`='".$cr."',
              `conducted_by`='".$conduct_by."',
              `location`='".$loc."',
              `date`='".$on_dat."'
               WHERE
               `id`='".$id."'";

        $result = $this->db->query($q);
        

        if ($result > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function get_rat_crit()
    {
        $q = "SELECT 
              `id`,
              `criteria`,
              `criteria_ordering`
              FROM
              tbl_review_criteria
              WHERE
              status=1
              ORDER BY
              criteria_ordering ASC
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function get_job_rating_criteria()
    {
        $q = "SELECT 
              `id`,
              `criteria`,
              `criteria_ordering`
              FROM
              tbl_jobs_review_criteria
              WHERE
              status=1
              ORDER BY
              criteria_ordering ASC
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            
//            foreach($result as $res)
//            {
//                $res['check_aded'] = $this->check_added_star_rate($res['id'], $emp_id, $cand_id);
//                $reso[]= $res;
//            }
            return $result;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function get_rating_criteria()
    {
        $q = "SELECT 
              `id`,
              `criteria`,
              `criteria_ordering`
              FROM
              tbl_review_criteria
              WHERE
              status=1
              ORDER BY
              criteria_ordering ASC
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            
//            foreach($result as $res)
//            {
//                $res['check_aded'] = $this->check_added_star_rate($res['id'], $emp_id, $cand_id);
//                $reso[]= $res;
//            }
            return $result;
        }
        else
        {
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
    
    public function get_added_ratings($cand,$emp_id)
    {
        $q = "SELECT
              rat.`id`,
              rat.`rating`,
              rat.`resume_id`,
              rat.`emp_id`,
              crit.`criteria`
              FROM
              `tbl_resume_rating` rat
              INNER JOIN
              `tbl_review_criteria` crit
              ON
              crit.id=rat.`criteria_id`
              WHERE
              rat.`candidate_id`='".$cand."'
              AND
              rat.`emp_id`='".$emp_id."'
              AND
              crit.status=1
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function get_added_reviews($cand)
    {
        $q = "SELECT
              rev.`id`,
              rev.`review`,
              rev.`candidate_id`,
              rev.`emp_id`,
              usr.`first_name`,
              usr.`last_name`
              FROM
              `tbl_resume_reviews` rev
              LEFT JOIN
              `tbl_users` usr
              ON
              rev.`emp_id`=usr.id
              WHERE
              rev.`candidate_id`='".$cand."'
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows()>0)
        {
            $result = $query->result_array();
            foreach($result as $res)
            {
                $res['ratings'] = $this->get_added_ratings($res['candidate_id'], $res['emp_id']);
                $resii[] = $res;
            }
            return $resii;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function fav_cand_count($tbl_name, $field, $check)
    {
        return $this->db->count_all("`$tbl_name` WHERE ".mysql_real_escape_string($field)."  = '".mysql_real_escape_string($check)."'");
    }
    
    function get_fav_candidates($start=null, $limit=null, $emp_id=null, $criteria=null)
    {
        
        $q = "SELECT
              fav_cand.id as fav_id,
              tbl_resume.`id` as res_id,
              tbl_resume.candidate_id,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`,
              usr.id as usr_id,
              usr.profile_pic,
              tbl_countries.CountryId,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM
              tbl_favourite_candidates fav_cand
              INNER JOIN
              tbl_resume
              ON
              tbl_resume.candidate_id = fav_cand.candidate_id
              INNER JOIN
              tbl_users usr
              ON
              usr.id = tbl_resume.candidate_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_resume.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              WHERE
              fav_cand.employer_id = '".$emp_id."'
              ORDER BY
              tbl_resume.id DESC
              LIMIT
              ".$start.", ".$limit."
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows() > 0)
        {
            $resume = $query->result_array();
            
            foreach($resume as $res)
                {
                     $res['fav_id'] = $this->get_favourite_cand($res['candidate_id'], $emp_id);
                     $res['reviews'] = $this->get_added_reviews($res['candidate_id']);
                     if(!empty($criteria)){
                            foreach($criteria as $crt){
                                $average = $this->get_rating_averrage($crt['id'],$res['candidate_id']);
                                if($average[0]['id'] != ""){
                                $avg[] = $average;}
                                else{
                                    $avg[] = "";
                                }
                            }
                            if(!empty($avg[0])){
                            $res['average'] = $avg;}
                            else{
                                $res['average'] = "";
                            }
                            unset($avg);
                     }
                     $reso[] = $res;
                }
                  return $reso;
            
        }
        else
        {
            return FALSE;
        }
      }
      
      public function candidate_resumes($cand)
      {
          $q = "SELECT
              tbl_resume.`id` as res_id,
              tbl_resume.candidate_id,
              tbl_resume.`first_name`,
              tbl_resume.`last_name`,
              tbl_resume.`email`,
              tbl_resume.`phone`,
              tbl_resume.`address_1`,
              tbl_resume.`address_2`,
              tbl_resume.`date_of_birth`,
              tbl_resume.`available_date`,
              tbl_resume.`objectives`,
              tbl_resume.`business_title`,
              tbl_resume.`business_skills`,
              tbl_resume.`language_skills`,
              tbl_resume.`computer_skills`,
              tbl_resume.`refrences`,
              tbl_resume.`father_name`,
              tbl_resume.`cnic`,
              tbl_resume.`category`,
              tbl_resume.`gender`,
              tbl_resume.`marital_status`,
              tbl_resume.`salary`,
              tbl_resume.`expected_salary`,
              tbl_resume.`create_date`,
              usr.id as usr_id,
              usr.profile_pic,
              tbl_countries.CountryId,
              tbl_state.RegionId,
              tbl_city.id as city_id,
              tbl_city.name as city_name,
              categ.property_category_name as category_name
              FROM 
              tbl_resume
              INNER JOIN
              tbl_users usr
              ON
              usr.id = tbl_resume.candidate_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_resume.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = usr.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = usr.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = usr.city
              WHERE
              tbl_resume.candidate_id = '".$cand."'
              ORDER BY
              tbl_resume.id DESC
              LIMIT
              0, 7
              ";
          
          $query = $this->db->query($q);
          
          if($query->num_rows()>0)
          {
              return $query->result_array();
}
          else{
              return FALSE;
          }
      }
      
      function delete_resume($res_id, $cand_id)
      {
          $q = "DELETE
                FROM
                tbl_resume
                WHERE
                tbl_resume.`id` = ".$res_id."
                AND
                tbl_resume.candidate_id = ".$cand_id."
                ";
          
          $query = $this->db->query($q);
          
          if($query)
          {
              return TRUE;
          }
          else{
              return FALSE;
          }
      }
}

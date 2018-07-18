<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobs_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('America/New_York');
    }
    
    function get_countries() {
        $q = "SELECT
              countryid,
              country
              FROM
              tbl_countries";
        $comp = $this->db->query($q);


// $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
    }
    
    function states($id) {
        $q = "SELECT
              countryid,
              regionid,
              region
              FROM
              tbl_state
              WHERE
              countryid='" . $id . "'";
        $comp = $this->db->query($q);


// $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
    }

    function cities($id) {
        $q = "SELECT
              countryid,
              regionid,
              id,
              name
              FROM
              tbl_city
              WHERE
              regionid='" . $id . "'";
        $comp = $this->db->query($q);


// $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
    }
    
    public function get_locations()
    {
        $q = "SELECT
              id,
              name
              FROM
              tbl_city
			  WHERE CountryID = 187
              ORDER BY
              name";
        $comp = $this->db->query($q);


// $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
    }
    
    function get_categories()
    {
        $q = "SELECT
              id,
              property_category_name
              FROM
              tbl_property_category
              ORDER BY
              cat_orderdering ASC";
        $comp = $this->db->query($q);


// $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
    }
    
    function add_job($data)
    {
        $q = "INSERT
              INTO
              tbl_jobs
              SET
              `job_title`='".$data['ttl']."',
              `job_description`='".$data['des']."',
              `category`='".$data['cat']."',
              `country`='".$data['cntry']."',
              `state`='".$data['state']."',
              `city`='".$data['cty']."',
              `salary`='".$data['sal']."',
              `salary_to`='".$data['sal_to']."',
              `start_date`='".$data['start']."',
              `end_date`='".$data['end']."',
              `company`='".$data['u_id']."',
              `job_type`='".$data['type']."',
              `career`='".$data['career']."',
              `experience`='".$data['experience']."',
              `vacancies`='".$data['vacancies']."',  
              `shift_titming`='".$data['shift']."'  
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
     
    
    function delete_job($id)
    {
        $q = "DELETE
              from
              tbl_jobs
              WHERE
              job_id='".$id."'";
        
        $query = $this->db->query($q);
        
        if($query > 0)
        {
            return TRUE;
        }
        else{
              return FALSE;
        }
    }
    
    
    function update_job($data)
    {
        $q = "UPDATE
              tbl_jobs
              SET
              `job_title`='".$data['ttl']."',
              `job_description`='".$data['des']."',
              `category`='".$data['cat']."',
              `country`='".$data['cntry']."',
              `state`='".$data['state']."',
              `city`='".$data['cty']."',
              `salary`='".$data['sal']."',
              `salary_to`='".$data['sal_to']."',
              `start_date`='".$data['start']."',
              `end_date`='".$data['end']."',
               `company`='".$data['u_id']."',
              `job_type`='".$data['type']."',
              `career`='".$data['career']."',
              `experience`='".$data['experience']."',
              `vacancies`='".$data['vacancies']."',  
              `shift_titming`='".$data['shift']."' 
               WHERE
               job_id='".$data['jb_id']."'
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
    
    function get_added_job_details($id)
    {
        $q = "SELECT
               `job_id`,
              `job_title`,
              `job_description`,
              `category`,
              `country`,
              `state`,
              `city`,
              `salary`,
              `salary_to`,
              `start_date`,
              `end_date`,
              `company`,
              `job_type`,
              `career`,
              `experience`,
              `vacancies`,  
              `shift_titming` 
               FROM
               tbl_jobs
               WHERE
               job_id='".$id."'";
        
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
               
              
                  
      public function get_jobs($start, $limit, $ck_dt = null, $criteria = null)
      {
          
          if($ck_dt == "")
          {
        $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`company`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.`job_type`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              comp.`company_name`,
              comp.`id` as company_id,
              comp.`logo`,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              left JOIN
              tbl_companyy comp
              ON
              comp.company_id = usr.company_id
              JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              ORDER BY
              tbl_jobs.job_id ASC
              LIMIT
              ".$start.", ".$limit."
              ";
          }
          else 
          {
//              if($ck_dt['fld'] == "")
//              {
                  $q = "SELECT
                        tbl_jobs.job_id,
                        tbl_jobs.`job_title`,
                        tbl_jobs.`job_description`,
                        tbl_jobs.`category`,
                        tbl_jobs.`company`,
                        tbl_jobs.`country`,
                        tbl_jobs.`state`,
                        tbl_jobs.`city`,
                        tbl_jobs.`salary`,
                        tbl_jobs.`start_date`,
                        tbl_jobs.`end_date`,
                        tbl_jobs.`job_type`,
                        usr.first_name,
                        usr.last_name,
                        usr.profile_pic,
                        comp.`company_name`,
                        comp.`id` as company_id,
                        comp.`logo`,
                        categ.property_category_name as category_name,
                        tbl_countries.Country as cnt_name,
                        tbl_state.Region,
                        tbl_city.name as city_name
					   FROM
					  tbl_jobs
					  JOIN
					  tbl_property_category categ
					  ON
					  tbl_jobs.`category`=categ.id
					  JOIN
					  tbl_users usr
					  ON
					  tbl_jobs.company = usr.id
					  left JOIN
					  tbl_companyy comp
					  ON
					  comp.company_id = usr.company_id
					  JOIN
					  tbl_countries
					  ON
					  tbl_countries.CountryId = tbl_jobs.country
					  JOIN
					  tbl_state
					  ON
					  tbl_state.RegionId = tbl_jobs.state
					  JOIN
					  tbl_city
					  ON
					  tbl_city.id = tbl_jobs.city
                        WHERE
                        tbl_jobs.`job_title` LIKE '%".$ck_dt['ttl']."%'
                        OR
                        tbl_city.`name` LIKE '%".$ck_dt['srch']."%'
                        ORDER BY
                        tbl_jobs.job_id ASC
                        LIMIT
                        ".$start.", ".$limit."
                        ";
          }
        $comp = $this->db->query($q);
        
        
        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            $jobs =  $comp->result_array();
            
            if(isset($this->session->userdata['user_data']['usr_id']))
            {
                $cand_id = $this->session->userdata['user_data']['usr_id'];
                foreach($jobs as $job)
                {
                    $job['fav_id'] = $this->get_favourite_jobs($job['job_id'], $cand_id);
                    $job['apl_id'] = $this->get_applied_id($job['job_id'], $cand_id);
                    
                    $job['reviews'] = $this->get_job_added_reviews($job['job_id']);
                     if(!empty($criteria)){
                            foreach($criteria as $crt){
                                $average = $this->get_job_rating_averrage($crt['id'],$job['job_id']);
                                if($average[0]['id'] != ""){
                                $avg[] = $average;}
                                else{
                                    $avg[] = "";
                                }
                            }
                            if(!empty($avg[0])){
                            $job['average'] = $avg;}
                            else{
                                $job['average'] = "";
                            }
                            unset($avg);
                     }
                     //$reso[] = $res;
                    $resop[] = $job;
                }
                return $resop;
            }
            else 
            {
                foreach($jobs as $job)
                {
                    
                    $job['reviews'] = $this->get_job_added_reviews($job['job_id']);
                     if(!empty($criteria)){
                            foreach($criteria as $crt){
                                $average = $this->get_job_rating_averrage($crt['id'],$job['job_id']);
                                if($average[0]['id'] != ""){
                                $avg[] = $average;}
                                else{
                                    $avg[] = "";
                                }
                            }
                            if(!empty($avg[0])){
                            $job['average'] = $avg;}
                            else{
                                $job['average'] = "";
                            }
                            unset($avg);
                     }
                     //$reso[] = $res;
                    $resop[] = $job;
                }
                return $resop;
            }
        }
      }
      
      public function get_job_added_reviews($job_id)
    {
        $q = "SELECT
              rev.`id`,
              rev.`review`,
              rev.`candidate_id`,
              rev.job_id,
              usr.`first_name`,
              usr.`last_name`
              FROM
              `tbl_job_reviews` rev
              LEFT JOIN
              `tbl_users` usr
              ON
              rev.`candidate_id`=usr.id
              WHERE
              rev.`job_id`='".$job_id."'
              ";
        
        $query = $this->db->query($q);
        
        if($query->num_rows()>0)
        {
            $result = $query->result_array();
            foreach($result as $res)
            {
                $res['ratings'] = $this->get_added_job_ratings($res['job_id'], $res['candidate_id']);
                $resii[] = $res;
            }
            return $resii;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function get_added_job_ratings($job_id, $cand)
    {
        $q = "SELECT
              rat.`id`,
              rat.`rating`,
              rat.`job_id`,
              rat.`candidate_id`,
              crit.`criteria`
              FROM
              `tbl_job_rating` rat
              INNER JOIN
              `tbl_jobs_review_criteria` crit
              ON
              crit.id=rat.`criteria_id`
              WHERE
              rat.`candidate_id`='".$cand."'
              AND
              rat.`job_id`='".$job_id."'
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
    
    
     public function get_job_rating_averrage($crt_id,$job_id)
    {
        $q = "SELECT
              rat.`id`,
              AVG(rat.`rating`) as avg_rat,
              rat.`job_id`,
              crit.`criteria`
              FROM
              `tbl_job_rating` rat
              INNER JOIN
              `tbl_jobs_review_criteria` crit
              ON
              rat.`criteria_id`=crit.id
              WHERE
              rat.`job_id`='".$job_id."'
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
    
      function get_applied_id($job, $cand)
      {
          $q = "SELECT
                `application_id`
                FROM
                `job_applications`
                WHERE
                `job_id`='".$job."'
                AND
                `candidate_id`='".$cand."'";
          
          $query = $this->db->query($q);
          
          if($query->num_rows()>0)
          {
              $result = $query->result_array();
              return $result[0]['application_id'];
          }
          else{
              return 0;
          }
      }
      
      function get_favourite_jobs($job_id, $cand)
      {
          $q = "SELECT
                id
                FROM
                tbl_favourite_jobs
                WHERE
                `job_id`='".$job_id."'
                AND
                `candidate_id`='".$cand."'";
          
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $result = $query->result_array();
              return $result[0]['id'];
          }
          
      }
              
      function get_latest_jobs()
      {
          $q = "SELECT j.`job_id`,j.`job_title`, j.`category`,
				j.`salary`,j.`start_date`,j.`end_date`,j.`job_type`,
				usr.first_name,usr.last_name,usr.profile_pic, comp.`company_name`,
				comp.`id` AS company_id, comp.`logo`, categ.property_category_name AS category_name, 				
				tbl_countries.Country AS cnt_name, tbl_state.Region, tbl_city.name AS city_name
				FROM tbl_jobs j
				JOIN tbl_property_category categ ON j.`category`=categ.id
				JOIN tbl_users usr ON j.company = usr.id
				LEFT JOIN tbl_companyy comp ON comp.company_id = usr.company_id
				JOIN tbl_countries ON tbl_countries.CountryId = j.country
				JOIN tbl_state ON tbl_state.RegionId = j.state
				JOIN tbl_city ON tbl_city.id = j.city
				ORDER BY j.job_id DESC
				LIMIT 0, 7
              ";
          
          $comp = $this->db->query($q);

        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
      }
      
      public function get_filter_jobs($cat)
      {
          if($cat != "")
          {
          $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              tbl_jobs.`category`='".$cat."'
              ORDER BY
              tbl_jobs.job_id ASC
              ";
          }
          else
          {
              $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              ORDER BY
              tbl_jobs.job_id ASC
              ";
          }
          
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $result = $query->result_array();
              foreach($result as $res)
              {
                  $res['start_datee'] = date("l jS F Y",strtotime($res['start_date']));
                  $reso[] = $res;
              }
              return $reso;
          }
      }
      
       public function get_job_detail($id)
      {
        $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`salary_to`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.`company`,
              tbl_jobs.`career`,
              tbl_jobs.`experience`,
              tbl_jobs.`shift_titming`,
              tbl_jobs.`vacancies`,
              tbl_jobs.`job_type`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              comp.`company_name`,
              comp.`company_id` AS company_id,
              comp.`logo`,
              categ.property_category_name,
              tbl_countries.Country AS cnt_name,
              tbl_state.Region,
              tbl_city.name AS city_name
              FROM
              tbl_jobs
              JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              LEFT JOIN
              tbl_companyy comp
              ON
              comp.company_id = usr.company_id
              JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category` = categ.id
              JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              tbl_jobs.job_id = ".$id."
              ";
        $comp = $this->db->query($q);

        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
      }
      
      function get_featured_company()
      {
          $q = "SELECT
                `logo`,
                `company_name`,
                `id`,
                `tag_line`
                FROM
                `tbl_companyy`
                WHERE
                `featured`=1
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
      
      public function count_companies($tbl_name=NULL)
      {
          return $this->db->count_all("`$tbl_name`");
      }
    
    public function record_count($tbl_name=NULL,$check=NULL,$field=NULL,$field1=NULL ) {
		
		
            if($tbl_name == 'job_applications' || $tbl_name == 'tbl_favourite_jobs')
            {
		return $this->db->count_all("`$tbl_name` WHERE ".mysql_real_escape_string($field)."  = '".mysql_real_escape_string($check)."'");
                
            }
            else
            {
                if($check ==''){
 		return $this->db->count_all("$tbl_name");
		}
		else {
		return $this->db->count_all("`$tbl_name` WHERE ".mysql_real_escape_string($field)."  LIKE '%".mysql_real_escape_string($check['srch'])."%' AND ".mysql_real_escape_string($field1)." LIKE '%".mysql_real_escape_string($check['ttl'])."%'");
                }
            }
	}
        
        public function count_consultatnt($tbl_name)
        {
            return $this->db->count_all("`$tbl_name` WHERE consultant_check  = '2'");
        }
        
        public function record_count_emp($tbl_name=NULL,$check=NULL,$field=NULL)
        {
            return $this->db->count_all("`$tbl_name` WHERE ".mysql_real_escape_string($field)."  = '".mysql_real_escape_string($check)."'");
        }
        
        function job_apply($data)
        {
            $q = "INSERT
              INTO
              job_applications
              SET
              `job_id`='".$data['id']."',
              `candidate_id`='".$data['usr_id']."',
              `company_id`='".$data['comp']."',
              `resume_id`='".$data['res_id']."'
               ";
        
            $query = $this->db->query($q);

            if($query > 0)
            {
                $this->add_covering_letter($data['res_id'], $data['usr_id'], $data['c_ttl'], $data['c_ltr']);
                return TRUE; 
            }
            else 
            {
                return FALSE;
            }
        }
        
        public function add_covering_letter($res_id, $u_id, $ttl, $letr)
        {
            $q1 = "SELECT id FROM tbl_covering_letter WHERE resume_id='".$res_id."' AND candidate_id='".$u_id."'";
        
            $check = $this->db->query($q1);

            if($check->num_rows() > 0)
            {
                $res = $check->result_array();
                
               $q = "UPDATE
                      `tbl_covering_letter`
                      SET
                      `letter_title`='".$ttl."',
                      `letter_description`='".$letr."'
                      WHERE
                      id='".$res[0]['id']."'
                       ";
            }
            else
            {
               $q = "INSERT
                        INTO
                        `tbl_covering_letter`
                        SET
                        `resume_id`='".$res_id."',
                        `candidate_id`='".$u_id."',
                        `letter_title`='".$ttl."',
                        `letter_description`='".$letr."'
                         ";
            }
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
        
        
        public function get_cand_applications($start, $limit, $id)
      {
        $q = "SELECT
              app.application_id,
              app.apply_date,
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              job_applications app
              LEFT JOIN
              tbl_jobs
              ON
              tbl_jobs.job_id = app.job_id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              app.candidate_id = ".$id."
              LIMIT ".$start.",".$limit."
              ";
        $comp = $this->db->query($q);

        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
      }
      
      
      public function get_applied_cands($page, $limit , $id, $criteria)
      {
          $q = "SELECT 
                app.`application_id`,
                app.`company_id`,
                app.`job_id`,
                app.`resume_id`,
                app.`candidate_id`
                FROM
                job_applications app
                WHERE
                app.`job_id` = '".$id."'
                AND
                app.`status` = 1
                LIMIT ".$page.", ".$limit."
                ";
          
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $result = $query->result_array();
              foreach($result as $res)
              {
                $resi = $this->get_appllied_details($res['candidate_id'], $res['resume_id'], $res['application_id'], $criteria);
                $resoo[] = $resi;
              }
              return $resoo;
          }
          else
          {
             return FALSE;
          }
          
      }
      
      
      public function get_appllied_details($candid,$res_id,$app_id, $criteria)
      {
          $emp_id = $this->session->userdata['user_data']['usr_id'];
          
//          $q_ck = "";
          if($res_id != 0 && $res_id != ""){
          $ck = explode($res_id,1);
          $check = $ck[0];
          }
          else{
              $check = 0;
          }
          
          if($check == "d"){
              $q = "SELECT
                    app.`application_id`,
                    app.`company_id`,
                    app.`job_id`,
                    app.`resume_id`,
                    app.`candidate_id`,
                    app.`status`,
                    app.`resume_id` as res_id,
                    app.`event_name`,
                    app.`start`,
                    app.`end`,
                    app.`apply_date`,
                    usr.`id` as cand_id,
                    usr.`first_name`,
                    usr.`last_name`,
                    usr.`country`,
                    usr.`state`,
                    usr.`city`,
                    usr.`profile_pic`,
                    usr.`resume`,
                    tbl_countries.Country as cnt_name,
                    tbl_state.Region,
                    tbl_city.name as city_name
                    FROM
                    `tbl_users` usr
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
                    INNER JOIN
                    job_applications app
                    ON
                    app.`candidate_id` = usr.id
                    WHERE
                    usr.id='".$candid."'";
          }else{
          $q = "SELECT
                app.`application_id`,
                app.`company_id`,
                app.`job_id`,
                app.`resume_id`,
                app.`candidate_id`,
                app.`status`,
                app.`event_name`,
                app.`start`,
                app.`end`,
                app.`apply_date`,
                app.`cand_status`,
                usr.`id` as cand_id,
                usr.`first_name`,
                usr.`last_name`,
                usr.`profile_pic`,
                usr.resume,
                tbl_resume.id as res_id,
                tbl_resume.objectives,
                tbl_resume.`available_date`,
                categ.property_category_name as category_name
                FROM
                job_applications app
                INNER JOIN
                tbl_users as usr
                ON
                usr.id = app.candidate_id
                INNER JOIN
                `tbl_resume`
                ON
                `tbl_resume`.`id` =  app.`resume_id`
                LEFT JOIN
                tbl_property_category categ
                ON
                tbl_resume.`category` = categ.id
                WHERE
                app.`application_id` = '".$app_id."'
                ";
          }
          
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $result = $query->result_array();
              
              $this->load->model('resume_model');
              
              foreach($result as $res)
              {
                  $res['fav_id'] = $this->get_favourite_cand($res['candidate_id'], $emp_id);
                  
                   $res['reviews'] = $this->resume_model->get_added_reviews($res['candidate_id']);
                     if(!empty($criteria)){
                            foreach($criteria as $crt){
                                $average = $this->resume_model->get_rating_averrage($crt['id'],$res['candidate_id']);
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
              return $reso[0];
          }
          else
          {
              return FALSE;
          }
      }
      
      public function get_uploaded_resume($cand)
      {
          $q = "SELECT resume FROM tbl_users WHERE id=".$cand."";
          
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $res =  $query->result_array();
              return $res[0]['resume'];
          }
          else{
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
              
      function reject_app($id)
      {
          $q = "UPDATE
                job_applications
                SET
                `status`=0
                WHERE
                `application_id` = '".$id."'";
          
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
      
      function update_views($id)
        {
          $sl_q = "SELECT
                   job_views
                   FROM
                   tbl_jobs
                   WHERE
                   `job_id`='".$id."'
                  ";
          
          $sl_query = $this->db->query($sl_q);
          
          if($sl_query->num_rows()>0)
          {
              $res = $sl_query->result_array();
              $view = $res[0]['job_views'];
              $view = $view + 1;
              $q = "UPDATE
                 tbl_jobs
                 SET
                 job_views = ".$view."
                 WHERE
                `job_id`='".$id."'
               ";
        
            $query = $this->db->query($q);

            if($query > 0)
            {
                return TRUE; 
            }
          }
          else 
          {
                return FALSE;
          }
        }
        
        
        function check_apply($id, $u_id)
        {
            $q = "SELECT
                application_id
                FROM
                job_applications
                WHERE
                `job_id`='".$id."'
                AND
                `candidate_id`='".$u_id."'
               ";
        
            $query = $this->db->query($q);

            if($query->num_rows() > 0)
            {
                return TRUE; 
            }
            else 
            {
                return FALSE;
            }
        }
        
        
        public function get_most_view_jobs()
      {
        $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`company`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.`job_type`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              comp.`company_name`,
              comp.`id` as company_id,
              comp.`logo`,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              LEFT JOIN
              tbl_companyy comp
              ON
              comp.id = usr.company_id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              ORDER BY
              tbl_jobs.job_views DESC
              LIMIT
              0,15
              ";

        $comp = $this->db->query($q);
        $cand_id = $this->session->userdata['user_data']['usr_id'];
        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            $jobs =  $comp->result_array();
            
            foreach($jobs as $job)
            {
                $job['fav_id'] = $this->get_favourite_jobs($job['job_id'], $cand_id);
                $job['apl_id'] = $this->get_applied_id($job['job_id'], $cand_id);
                $resop[] = $job;
            }
            return $resop;
        }
      }
      
      
      public function get_my_favourite_jobs($start, $limit, $u_id)
      {
        $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.job_views,
              tbl_jobs.job_type,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              INNER JOIN
              tbl_favourite_jobs fav
              ON
              fav.job_id = tbl_jobs.job_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              fav.candidate_id = ".$u_id."
              ORDER BY
              tbl_jobs.job_views DESC
              LIMIT
              ".$start.",".$limit."
              ";

        $comp = $this->db->query($q);
        $cand_id = $this->session->userdata['user_data']['usr_id'];
        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            $jobs =  $comp->result_array();
            
            foreach($jobs as $job)
            {
                $job['fav_id'] = $this->get_favourite_jobs($job['job_id'], $cand_id);
                $job['apl_id'] = $this->get_applied_id($job['job_id'], $cand_id);
                $resop[] = $job;
            }
            return $resop;
        }
      }
      
       public function get_emp_jobs($start, $limit, $uid)
      {
        $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.`job_type`,
              tbl_jobs.`company`,
              tbl_jobs.`filled`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              tbl_jobs.company = ".$uid."
              ORDER BY
              tbl_jobs.job_id Desc
              LIMIT
              ".$start.", ".$limit."
              ";
        $comp = $this->db->query($q);
            $uid = $this->session->userdata['user_data']['usr_id'];
        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            $jobs = $comp->result_array();
            foreach($jobs as $job)
            {
               $job['fav_id'] = $this->get_favourite_jobs($job['job_id'], $uid);
               $job['no_of_app'] = $this->count_applications($job['job_id']);
               $jobs_emp[] = $job;
            }
            return $jobs_emp;
        }
      }
      
      public function count_applications($job_id)
      {
         return $this->db->count_all("job_applications WHERE job_id=".$job_id."");
      }


      public function get_emp_applications($start, $limit, $id)
      {
        $q = "SELECT
              app.application_id,
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              job_applications app
              LEFT JOIN
              tbl_jobs
              ON
              tbl_jobs.job_id = app.job_id
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              tbl_jobs.company = ".$id."
              LIMIT ".$start.",".$limit."
              ";
        $comp = $this->db->query($q);

        // $row = $comp->row();
        if ($comp->num_rows() > 0) {
            return $comp->result_array();
        }
      }
      
      public function get_advance_results($loc, $sal, $sal_to)
      {
          
              if($loc != "")
              {
                  $where = "
                    tbl_city.name LIKE '%".$loc."%'
                    ORDER BY
                    tbl_jobs.job_id ASC
                    ";
              }
              elseif ($loc != "" && $sal != "") 
              {
                  $where = "
                    tbl_city.name LIKE '%".$loc."%'
                    OR
                    tbl_jobs.`salary` BETWEEN '".$sal."' and '".$sal."'
                    ORDER BY
                    tbl_jobs.job_id ASC
                    ";
              }
              elseif($loc != "" && $sal != "" && $sal_to == "")
              {
                  $where = "
                    tbl_city.name LIKE '%".$loc."%'
                    OR
                    tbl_jobs.`salary` BETWEEN '".$sal."' and '".$sal_to."'
                    ORDER BY
                    tbl_jobs.job_id ASC
                    ";
              }
//          elseif ($from != "" && $to == "") 
//          {
//              if($sal != "" && $sal_to != "")
//              {
//                  $where = "
//                    tbl_jobs.`job_title` LIKE '%".$ttl."%'
//                    AND
//                    tbl_city.name LIKE '%".$loc."%'
//                    OR
//                    tbl_jobs.`category` = '".$cat."'
//                    OR
//                    tbl_jobs.`end_date` BETWEEN '".$from."' AND '".$from."'
//                    OR
//                    tbl_jobs.`salary` BETWEEN '".$sal."' and '".$sal_to."'
//                    ORDER BY
//                    tbl_jobs.job_id ASC
//                    ";
//              }
//              elseif ($sal != "" && $sal_to == "") 
//              {
//                  $where = "
//                    tbl_jobs.`job_title` LIKE '%".$ttl."%'
//                    AND
//                    tbl_city.name LIKE '%".$loc."%'
//                    OR
//                    tbl_jobs.`category` = '".$cat."'
//                    OR
//                    tbl_jobs.`end_date` BETWEEN '".$from."' AND '".$from."'
//                    OR
//                    tbl_jobs.`salary` BETWEEN '".$sal."' and '".$sal."'
//                    ORDER BY
//                    tbl_jobs.job_id ASC
//                    ";
//              }
//              else
//              {
//                  $where = "
//                    tbl_jobs.`job_title` LIKE '%".$ttl."%'
//                    AND
//                    tbl_city.name LIKE '%".$loc."%'
//                    OR
//                    tbl_jobs.`category` = '".$cat."'
//                    OR
//                    tbl_jobs.`end_date` BETWEEN '".$from."' AND '".$from."'
//                    ORDER BY
//                    tbl_jobs.job_id ASC
//                    ";
//              }
//              
//          }
//          else
//          {
//              if($sal != "" && $sal_to != "")
//              {
//                  $where = "
//                    tbl_jobs.`job_title` LIKE '%".$ttl."%'
//                    AND
//                    tbl_city.name LIKE '%".$loc."%'
//                    OR
//                    tbl_jobs.`category` = '".$cat."'
//                    OR
//                    tbl_jobs.`salary` BETWEEN '".$sal."' and '".$sal_to."'
//                    ORDER BY
//                    tbl_jobs.job_id ASC
//                    ";
//              }
//              elseif ($sal != "" && $sal_to == "") 
//              {
//                  $where = "
//                    tbl_jobs.`job_title` LIKE '%".$ttl."%'
//                    AND
//                    tbl_city.name LIKE '%".$loc."%'
//                    OR
//                    tbl_jobs.`category` = '".$cat."'
//                    OR
//                    tbl_jobs.`salary` BETWEEN '".$sal."' and '".$sal."'
//                    ORDER BY
//                    tbl_jobs.job_id ASC
//                    ";
//              }
//              else
//              {
//                  $where = "
//                    tbl_jobs.`job_title` LIKE '%".$ttl."%'
//                    AND
//                    tbl_city.name LIKE '%".$loc."%'
//                    OR
//                    tbl_jobs.`category` = '".$cat."'
//                    ORDER BY
//                    tbl_jobs.job_id ASC
//                    ";
//              }
//              
//          }
          
          $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.`job_type`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              $where
              ";
          
          
                      
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $result = $query->result_array();
              foreach($result as $res)
              {
                  $res['start_datee'] = date("l jS F Y",strtotime($res['start_date']));
                  $reso[] = $res;
              }
              return $reso;
          }
      }
      
      public function get_aded_appointments($cand)
      {
          $q = "SELECT
                tbl_jobs.job_id,
                tbl_jobs.`job_title`,
                tbl_jobs.`job_description`,
                app.`application_id` as id,
                app.`start`,
                app.`end`,
                app.`event_name`
                FROM
                tbl_jobs
                INNER JOIN
                `job_applications` app
                ON
                tbl_jobs.job_id = app.`job_id`
                WHERE
                tbl_jobs.company = '".$cand."'
                AND
                app.`start` != '' ";
          
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
      
      public function add_appointment_details($start, $end, $name, $id)
      {
          $q = "UPDATE
                job_applications
                SET
                `start` = '".$start."',
                `end` = '".$end."',
                `event_name` = '".$name."'
                WHERE
                `application_id` = '".$id."'";
          
          $query = $this->db->query($q);
          
          if($query)
          {
              return TRUE;
          }
          else 
          {
               return FALSE;
          }
      }
      
      public function update_appointment_details($start=null, $end=null, $id=null, $text=null)
      {
          if($text != ""){
              $q = "UPDATE
                      job_applications
                      SET
                      `event_name` = '".$text."'
                      WHERE
                      `application_id` = '".$id."'";
          }
          else{
                $q = "UPDATE
                      job_applications
                      SET
                      `start` = '".$start."',
                      `end` = '".$end."'
                      WHERE
                      `application_id` = '".$id."'";
          }
          
          $query = $this->db->query($q);
          
          if($query)
          {
              return TRUE;
          }
          else 
          {
               return FALSE;
          }
      }
      
      public function add_favourite_candidate($emp_id, $app_id, $fav_id)
      {
          if($fav_id == "")
          {
            $q = "INSERT
                  INTO
                  `tbl_favourite_candidates`
                  SET
                  `candidate_id`='".$app_id."',
                  `employer_id` = '".$emp_id."'";
          }
          else
          {
              $q = "DELETE
                    FROM
                    `tbl_favourite_candidates`
                    WHERE
                    `id`='".$fav_id."'";
          }
          
          $query = $this->db->query($q);
          
          if($query)
          {
              return TRUE;
          }
          else 
          {
              return FALSE;
          }
      }
      
      
      public function add_fav_job($job_id, $u_id, $fav_id)
      {
          if($fav_id == "")
          {
            $q = "INSERT
                  INTO
                  `tbl_favourite_jobs`
                  SET
                  `candidate_id`='".$u_id."',
                  `job_id` = '".$job_id."'";
          }
          else
          {
              $q = "DELETE
                    FROM
                    `tbl_favourite_jobs`
                    WHERE
                    `id`='".$fav_id."'";
          }
          
          $query = $this->db->query($q);
          
          if($query)
          {
              return TRUE;
          }
          else 
          {
              return FALSE;
          }
      }
      
      
      function get_auto_comp($term)
      {
          $q = "SELECT
                `job_title`,
                `job_id` as id
                FROM 
                tbl_jobs 
                WHERE 
                job_title LIKE '%".$term."%'";
          
          $query = $this->db->query($q);
          
          if($query->num_rows() > 0)
          {
              $result = $query->result_array();
              foreach($result as $res)
              {
                  $row['value'] = stripslashes($res['job_title']);
                  $row['data'] = (int)$res['id'];
                  $res_dtaa[] = $row;
              }
              return $res_dtaa;
          }
          else
          {
              return FALSE;
          }
      }
      
              
      public function get_inner_search_res($srch)
      {
          if(isset($this->session->userdata['user_data']['usr_id']))
          {
            $cand = $this->session->userdata['user_data']['usr_id'];
          }
          else 
          {
              $cand = '';
          }
          $q = "SELECT
              tbl_jobs.job_id,
              tbl_jobs.`job_title`,
              tbl_jobs.`job_description`,
              tbl_jobs.`category`,
              tbl_jobs.`country`,
              tbl_jobs.`state`,
              tbl_jobs.`city`,
              tbl_jobs.`salary`,
              tbl_jobs.`start_date`,
              tbl_jobs.`end_date`,
              tbl_jobs.`job_type`,
              usr.first_name,
              usr.last_name,
              usr.profile_pic,
              categ.property_category_name as category_name,
              tbl_countries.Country as cnt_name,
              tbl_state.Region,
              tbl_city.name as city_name
              FROM
              tbl_jobs
              LEFT JOIN
              tbl_property_category categ
              ON
              tbl_jobs.`category`=categ.id
              LEFT JOIN
              tbl_users usr
              ON
              tbl_jobs.company = usr.id
              LEFT JOIN
              tbl_countries
              ON
              tbl_countries.CountryId = tbl_jobs.country
              LEFT JOIN
              tbl_state
              ON
              tbl_state.RegionId = tbl_jobs.state
              LEFT JOIN
              tbl_city
              ON
              tbl_city.id = tbl_jobs.city
              WHERE
              tbl_jobs.`job_id` = '".$srch."'
              ORDER BY
              tbl_jobs.job_id ASC
              ";
          $query = $this->db->query($q);
          
          if($query->num_rows())
          {
              $result = $query->result_array();
              foreach($result as $res)
              {
                $res['fav_id'] = $this->get_favourite_jobs($res['job_id'], $cand);
                $resti[] = $res;
              }
              return $resti;
          }
          else
          {
                return FALSE;
          }
      }
      
      
      public function make_filled($fil, $id)
      {
          $q = "UPDATE
                tbl_jobs
                SET
                filled=".$fil."
                WHERE
                job_id = ".$id."
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
	 
	 public function getjobs($start,$limit,$query_string,$criteria=null){
		 $q = "SELECT
                      tbl_jobs.job_id,
                      tbl_jobs.`job_title`,
                      tbl_jobs.`job_description`,
                      tbl_jobs.`category`,
                      tbl_jobs.`company`,
                      tbl_jobs.`country`,
                      tbl_jobs.`state`,
                      tbl_jobs.`city`,
                      tbl_jobs.`salary`,
                      tbl_jobs.`start_date`,
                      tbl_jobs.`end_date`,
                      tbl_jobs.`job_type`,
                      usr.first_name,
                      usr.last_name,
                      usr.profile_pic,
                      comp.`company_name`,
                      comp.`company_id` as company_id,
                      comp.`logo`,
                      categ.property_category_name as category_name,
                      tbl_countries.Country as cnt_name,
                      tbl_state.Region,
                      tbl_city.name as city_name
					  FROM
					  tbl_jobs
					  JOIN
					  tbl_property_category categ
					  ON
					  tbl_jobs.`category`=categ.id
					  JOIN
					  tbl_users usr
					  ON
					  tbl_jobs.company = usr.id
					  left JOIN
					  tbl_companyy comp
					  ON
					  comp.company_id = usr.company_id
					  JOIN
					  tbl_countries
					  ON
					  tbl_countries.CountryId = tbl_jobs.country
					  JOIN
					  tbl_state
					  ON
					  tbl_state.RegionId = tbl_jobs.state
					  JOIN
					  tbl_city
					  ON
					  tbl_city.id = tbl_jobs.city
                      ".$query_string."
					  LIMIT
              		  ".$start.", ".$limit."
						";
		$queryRS	=	$this->db->query($q);
                
                if($queryRS->num_rows()>0)
                {
                   $jobs = $queryRS->result_array();
                   
                    if(isset($this->session->userdata['user_data']['usr_id']))
                    {
                        $cand_id = $this->session->userdata['user_data']['usr_id'];
                        foreach($jobs as $job)
                        {
                            $job['fav_id'] = $this->get_favourite_jobs($job['job_id'], $cand_id);
                            $job['apl_id'] = $this->get_applied_id($job['job_id'], $cand_id);

                            $job['guest_rate'] = $this->get_guest_star_rate($job['job_id']);
                            $job['reviews'] = $this->get_job_added_reviews($job['job_id']);
                             if(!empty($criteria)){
                                    foreach($criteria as $crt){
                                        $average = $this->get_job_rating_averrage($crt['id'],$job['job_id']);
                                        if($average[0]['id'] != ""){
                                        $avg[] = $average;}
                                        else{
                                            $avg[] = "";
		}
                                    }
                                    if(!empty($avg[0])){
                                    $job['average'] = $avg;}
                                    else{
                                        $job['average'] = "";
                                    }
                                    unset($avg);
                             }
                             //$reso[] = $res;
                            $resop[] = $job;
                        }
                        return $resop;
                    }
                    else 
                    {
                          foreach($jobs as $job)
                        {
                              $job['guest_rate'] = $this->get_guest_star_rate($job['job_id']);
                            $job['reviews'] = $this->get_job_added_reviews($job['job_id']);
                             if(!empty($criteria)){
                                    foreach($criteria as $crt){
                                        $average = $this->get_job_rating_averrage($crt['id'],$job['job_id']);
                                        if($average[0]['id'] != ""){
                                        $avg[] = $average;}
                                        else{
                                            $avg[] = "";
                    }
                }
                                    if(!empty($avg[0])){
                                    $job['average'] = $avg;}
                else{
                                        $job['average'] = "";
                                    }
                                    unset($avg);
                             }
                             //$reso[] = $res;
                            $resop[] = $job;
                        }
                        return $resop;
                    }
                }
                else{
                    return FALSE;
                }
		}
                
    function get_guest_star_rate($job_id)
    {
        $q = "SELECT 
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
            return $result[0]['rating'];
        }
        else
        {
            return 0;
        }
    }
		
public function getjobscount($query_string){
		 $q = "SELECT count(*) as total
		 			 FROM
					  tbl_jobs
					  JOIN
					  tbl_property_category categ
					  ON
					  tbl_jobs.`category`=categ.id
					  JOIN
					  tbl_users usr
					  ON
					  tbl_jobs.company = usr.id
					  left JOIN
					  tbl_companyy comp
					  ON
					  comp.company_id = usr.company_id
					  JOIN
					  tbl_countries
					  ON
					  tbl_countries.CountryId = tbl_jobs.country
					  JOIN
					  tbl_state
					  ON
					  tbl_state.RegionId = tbl_jobs.state
					  JOIN
					  tbl_city
					  ON
					  tbl_city.id = tbl_jobs.city
                      ".$query_string."
					 ";
		$queryRS	=	$this->db->query($q);
		return $queryRS->row();
       
		}		
function getcandidateexperience($cand_id){
	 $q =  "SELECT SUM((TO_DAYS(end_date)-TO_DAYS(start_date))/365) AS DiffDate
			FROM tbl_candidate_wrk_histry
			GROUP BY candidate_id
			where candidate_id = ".$cand_id."  ";
		$queryRS	=	$this->db->query($q);
		return $queryRS->row();
						
		 } 
                 
                 
          public function get_res_cover($u_id, $res_id)
          {
              $q = "SELECT `letter_title`,`letter_description` FROM `tbl_covering_letter` WHERE `resume_id`='".$res_id."' AND `candidate_id`='".$u_id."'";
              
              $query = $this->db->query($q);
              
              if($query->num_rows() > 0)
              {
                  $result =  $query->result_array();
                  return $result[0];
              }
              else
              {
                  return FALSE;
              }
          }
}

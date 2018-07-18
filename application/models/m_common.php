<?php
class m_common extends CI_model
{
   /*
   This will insert the data into the table
   @param $table is the name of that table to whom we want the data to be inserted
   @param $table_data is the actual data which we want to insert in the table
   */
   
   function insert_data($table,$table_data){
    $this->db->insert($table, $table_data); 
    }
   
    
    /*
    This will show all the record of any particular table
    @param $table_name is the name of that particular table to whom we want the data to be selected
    */
   function view_record($table_name){ // view all record
    $query = $this->db->get($table_name);
    if($query->num_rows()> 0)
    {
        return $query->result();
    
    }
    else {
        return false;
    
    }
   } 
   
   /*
   This will retrieve the data of any table with a specific thing in the where clause
   @param ID is the field name on the basis of which we the data to be selected
   @param $value is the value of that attribute 
   @param $table_name is the name of that particular table
   */
   function view_specific($id,$value,$table_name){
        $this->db->where($id,$value);
        $query = $this->db->get($table_name);
        return $query->row();
        
   }
  
   
   /*
   This will update the record
   @param $ID is the field name
   @param $value is the value of that particular field for which we are going to update record
   @param $table_name is the name of the table to whom we want the data to be deleted
   @param $updated_data is the newest data which we want to replace based on the $value 
   */
   
   
   
   function update_data($updated_data,$table_name,$ID,$value){
        $this->db->where($ID,$value);
        $this->db->update($table_name,$updated_data);
        
   }
   /*
   This will delete the record
   @param $ID is the field name
   $param $value is the value of that particular field for which we are going to delete record
   $param $table_name is the name of the table to whom we want the data to be deleted
   */
   
   
   function delete_record($ID,$value,$table_name){
    $this->db->where($ID,$value);
    $this->db->delete($table_name);
    
   }
   
   function getCompanyProfileByEmpID($empid){
	  $query	=	"SELECT cy.`company_id`, cy.`emp_id`, 
					pm.`first_name`,pm.`last_name`,pm.`email_address`,cy.`company_name`, st.`Region` state, 
					cy.`address`, cont.`Country`, cit.`name` city 
					FROM tbl_companyy cy
					JOIN tbl_users AS pm ON pm.`id` = cy.`emp_id`
					JOIN tbl_countries cont ON cont.`CountryId` = cy.`country`
					JOIN tbl_city cit ON cit.`id` = cy.`city`
					JOIN tbl_state st ON st.`RegionID` = cy.`state`
					WHERE cy.`emp_id` = ".$empid."  " ;
	$queryRS	=	$this->db->query($query);
	return $queryRS->row();
	 }
   
     function getSubscribedPackages($empid){
	  $query	=	"SELECT p.`package_name`, p.`package_currency`,p.`package_type`, 
					p.`package_price`,p.`package_description`,p.`package_detail`,sp.`subscription_date`,sp.`activation_date`, sp.`expiry_date`, sp.`status`, sp.`payment_status`
					FROM tbl_packages p
					JOIN tbl_subscribed_packages AS sp ON sp.`package_id` = p.`package_id`
					WHERE sp.`emp_id` = ".$empid."  " ;
	$queryRS	=	$this->db->query($query);
	return $queryRS->result();
	 }
	 
	 // this funciton is used to get the latest notification for the individual users
	function getlatestnotification($empid){
	  $query	=	"SELECT COUNT(*) AS total
					FROM tbl_notification
					WHERE receiver_id = ".$empid."  " ;
	$queryRS	=	$this->db->query($query);
	return $queryRS->row();
	 } 
	 
	 function shownotifications($empid){
		$query	=	"SELECT * 
					FROM tbl_notification
					WHERE receiver_id =  ".$empid."
					ORDER BY notification_id desc  " ;
		$queryRS	=	$this->db->query($query);
		return $queryRS->result();
			 
	}
	
	 function getjobcity($jobid){
		$query	=	"SELECT j.`city`,c.`name` 
					FROM tbl_jobs j
					JOIN tbl_city c on c.`id` = j.`city`
					WHERE j.`job_id` =  ".$jobid."  " ;
		$queryRS	=	$this->db->query($query);
		return $queryRS->row();
			 
	}
	
	function getTotalCompanyEmp($comp_id){
		$query	=	"SELECT count(*) as total,company_id FROM `tbl_users`
					where company_id = ".$comp_id."
					group by company_id " ;
		$queryRS	=	$this->db->query($query);
		return $queryRS->row();	
		}
	
	function getTotalCompanyJobs($comp_id){
		$query	=	"SELECT count(*) as total ,u.`company_id` FROM `tbl_jobs` as j
					join tbl_users as u on u.`id` = j.`company`  
					where u.`company_id` = ".$comp_id."
					group by u.`company_id` ";
		$queryRS	=	$this->db->query($query);
		return $queryRS->row();	
	}
	function getotherpackages($package_id){
		$query	=	"SELECT *
					FROM tbl_packages
					WHERE package_id != ".$package_id." ";
		$queryRS	=	$this->db->query($query);
		return $queryRS->result();	
		
	}
	
	function getmaximumsubscribtionid(){
		$query	=	"SELECT MAX(sp_id) AS maximum
					FROM tbl_subscribed_packages";
		$queryRS	=	$this->db->query($query);
		return $queryRS->row();	
	}
			

}



